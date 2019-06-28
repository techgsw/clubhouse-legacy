<?php

namespace App\Providers;

use App\Contact;
use App\Job;
use App\Organization;
use App\Transaction;
use App\Providers\ImageServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Uploadedfile;
use App\Exceptions\SBSException;

class JobServiceProvider extends ServiceProvider
{
    public static function store(Job $job, UploadedFile $document = null, UploadedFile $alt_image = null)
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
                throw new SBSException("You must upload corresponding document.");
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new SBSException("Sorry, the document you tried to upload failed.");
        }

        try {
            $rank = 0;

            $job->organization_name = $organization->name;

            if ($job->featured) {
                $job->rank = 1;
                $last_job = Job::whereNotNull('rank')->orderBy('rank', 'desc')->first();
                if ($last_job) {
                    $job->rank = $last_job->rank+1;
                }
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
                $job->featured = true;
                $job->save();

                if ($job->job_type_id == 4) {
                    $transaction = Transaction::join('transaction_product_option as tpo', 'tpo.transaction_id', 'transaction.id')
                        ->join('product_option as po', 'po.id', 'tpo.product_option_id')
                        ->where('po.name','=','Platinum Job')
                        ->where('transaction.user_id','=', Auth::user()->id)
                        ->whereNull('transaction.job_id')
                        ->select('transaction.id', 'transaction.job_id')->first();
                } elseif ($job->job_type_id == 3) {
                    $transaction = Transaction::join('transaction_product_option as tpo', 'tpo.transaction_id', 'transaction.id')
                        ->join('product_option as po', 'po.id', 'tpo.product_option_id')
                        ->where('po.name','=','Featured Job')
                        ->where('transaction.user_id','=', Auth::user()->id)
                        ->whereNull('transaction.job_id')
                        ->select('transaction.id', 'transaction.job_id')->first();
                }

                $transaction->job_id = $job->id;
                $transaction->save();
            }

            return $job;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new SBSException("Sorry, failed to save the job. Please try again." . $e->getMessage());
        }
    }
}
