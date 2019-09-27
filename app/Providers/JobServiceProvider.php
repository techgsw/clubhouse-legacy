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
use PhpParser\Node\Expr\BinaryOp\Coalesce;

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
                throw new SBSException("You must upload a job description.");
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new SBSException("Sorry, the document you tried to upload failed.");
        }

        try {
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

            return $job;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
        $jobs = Job::where('job_status_id', '!=', JOB_STATUS_ID['expired'])
            ->where(function($expire_time_wheres) {
                $expire_time_wheres->where(function($extended_at_where) {
                    // regardless of job type, if extended_at is the latest time, check if it's been 30 days
                    $extended_at_where->where('job_type_id', '!=', JOB_TYPE_ID['sbs_default'])
                        ->where(DB::raw('COALESCE(extended_at,0)'), '>', DB::raw('COALESCE(upgraded_at,0)'))
                        ->where(DB::raw('TIMESTAMPDIFF(DAY, extended_at, NOW())'), '>=', '30');
                })->orWhere(function($user_free_where) {
                    $user_free_where->where('job_type_id', JOB_TYPE_ID['user_free'])
                        ->where(DB::raw('TIMESTAMPDIFF(DAY,'
                            .'COALESCE(upgraded_at,created_at),'
                            .'NOW())'
                        ), '>=', '30');
                })->orWhere(function($user_premium_where) {
                    $user_premium_where->where('job_type_id', JOB_TYPE_ID['user_premium'])
                        ->where(DB::raw('TIMESTAMPDIFF(DAY,'
                            .'COALESCE(upgraded_at,created_at),'
                            .'NOW())'
                        ), '>=', '45');
                })->orWhere(function($user_platinum_where) {
                    $user_platinum_where->where('job_type_id', JOB_TYPE_ID['user_platinum'])
                        ->where(DB::raw('TIMESTAMPDIFF(DAY,'
                            .'COALESCE(upgraded_at,created_at),'
                            .'NOW())'
                        ), '>=', '60');
                });
            })->get();

        foreach ($jobs as $job) {
            $job->job_status_id = JOB_STATUS_ID['expired'];
            $job->save();
        }
    }
}
