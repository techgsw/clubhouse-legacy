<?php

namespace App\Providers;

use App\Contact;
use App\Job;
use App\Organization;
use App\Transaction;
use App\User;
use App\Inquiry;
use App\ContactJob;
use App\Providers\ImageServiceProvider;
use function foo\func;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Uploadedfile;
use App\Exceptions\SBSException;

class JobServiceProvider extends ServiceProvider
{
    public static function store(Job $job, UploadedFile $document = null, UploadedFile $alt_image = null, $job_tags = null, $is_admin = false)
    {
        $organization = Organization::find($job->organization_id);
        $image = $organization->image;
        if (!$organization) {
            throw new SBSException("Failed to find organization " . $job->organization_id);
        }

        if (is_null($organization->image) && !$alt_image) {
            throw new SBSException("You must upload an image");
        }

        try {
            if ($document) {
                $document = $document->store('document', 'public');
                $job->document = $document;
            } else {
                throw new SBSException("You must upload a job description.");
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new SBSException("Sorry, the document you tried to upload failed.");
        }

        try {
            // TODO ranks are currently not in use. jobs are displayed in random order based on featured/unfeatured
            $rank = 0;

            $job->organization_name = $organization->name;

            $job->rank = 1;
            $last_job = Job::whereNotNull('rank')->where('featured',$job->featured)->orderBy('rank', 'desc')->first();
            if ($last_job) {
                $job->rank = $last_job->rank+1;
            }

            // If no image file is given, we're reusing the organization's image
            if ($alt_image) {
                // Override image
                $image = ImageServiceProvider::saveFileAsImage(
                    $alt_image,
                    $filename = preg_replace('/\s/', '-', str_replace("/", "", $job->organization->organization_name)).'-SportsBusinessSolutions',
                    $directory = 'job/'.$job->id
                );
            }

            $job->image_id = $image->id;
            $job->save();

            if (in_array($job->job_type_id, array(4, 3))) {
                $job->featured = 1;
                $job->save();

                if (!$is_admin) {
                    // TODO should be using job option id here, not name. Constant? 
                    if ($job->job_type_id == 4) {
                        $job_name = 'Platinum Job';
                    } elseif ($job->job_type_id == 3) {
                        $job_name = 'Premium Job';
                    }

                    $transaction = Transaction::join('transaction_product_option as tpo', 'tpo.transaction_id', 'transaction.id')
                        ->join('product_option as po', 'po.id', 'tpo.product_option_id')
                        ->where('po.name','=',$job_name)
                        ->where('transaction.user_id','=', Auth::user()->id)
                        ->whereNull('transaction.job_id')
                        ->select('transaction.id', 'transaction.job_id')->first();

                    $transaction->job_id = $job->id;
                    $transaction->save();
                }
            }

            if ($job_tags) {
                $job->tags()->sync($job_tags);
            }

            return $job;
        } catch (\Exception $e) {
            Log::error($e);
            throw new SBSException("Sorry, failed to save the job. Please try again." . $e->getMessage());
        }
    }

    public static function getAvailablePaidJobs(User $user, int $product_option_id)
    {
        // TODO this should be using a contant for id rather than searching by name
        $available_paid_jobs = Transaction::join('transaction_product_option as tpo', 'tpo.transaction_id', 'transaction.id')
            ->join('product_option as po', 'po.id', 'tpo.product_option_id')
            ->where('po.id','=',$product_option_id)
            ->where('transaction.user_id','=', $user->id)
            ->whereNull('transaction.job_id')->get();

        return $available_paid_jobs;
    }

    public static function expireJobs()
    {
        $jobs = Job::findExpiredJobs();

        foreach ($jobs as $job) {
            $job->job_status_id = JOB_STATUS_ID['expired'];
            $job->save();
            EmailServiceProvider::sendJobExpirationNotificationEmail($job);
        }
    }

    public static function sendExpirationReminder(int $number_of_days) {
        $jobs = Job::findExpiredJobs($number_of_days, false);

        foreach ($jobs as $job) {
            EmailServiceProvider::sendJobExpirationReminderEmail($job, $number_of_days);
        }
    }

}
