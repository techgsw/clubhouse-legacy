<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ContactJob;
use App\Inquiry;
use App\Mail\ContactJobInterestRequest;
use App\Mail\InquiryInterestRequest;
use Mail;

class SendJobInvite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobinvite:send {--contact_job=} {--inquiry=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'TEST COMMAND, REMOVE ME. Send a job invite to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contact_job_id = $this->option('contact_job');
        $inquiry_id = $this->option('inquiry');

        $contact_job = ContactJob::where('id','=',$contact_job_id)->first();
        $inquiry = Inquiry::where('id','=',$inquiry_id)->first();


        if (is_null($contact_job) && is_null($inquiry)) {
            $this->info('Need either a contact_job id or an inquiry id');
            $this->info('Try --contact_job=12 and or --inquiry=25');
            die();
        }

        if (!is_null($contact_job)) {
            $contact_job->generateJobInterestToken();
            try {
                Mail::to($contact_job->contact)->send(new ContactJobInterestRequest($contact_job));
            } catch (Exception $e) {
                Log::error($e->getMessage());
                dd($e);
            }
            
            $contact_job->job_interest_request_date = new \DateTime('now');
            $contact_job->save();
        }
        if (!is_null($inquiry)) {
            $inquiry->generateJobInterestToken();
            try {
                Mail::to($inquiry->user)->send(new InquiryInterestRequest($inquiry));
            } catch (Exception $e) {
                Log::error($e->getMessage());
                dd($e);
            }
            
            $inquiry->job_interest_request_date = new \DateTime('now');
            $inquiry->save();
        }
        dump('Sent emails');
    }
}
