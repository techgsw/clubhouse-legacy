<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Mail;
use App\Note;
use App\User;
// use App\Product;
// use App\RoleUser;
// use App\Transaction;
use App\JobPipeline;
use App\ContactJob;
use App\Inquiry;
use App\Mail\Admin\ContactWarmComm;
use App\Mail\Admin\ContactColdComm;
use App\Mail\InquiryRated;
use App\Providers\EmailServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-admin-pipelines');

        // Get count of contacts and inquirys
        $contact_job_count = ContactJob::count();

        $inquiry_count = Inquiry::count();

        return view('admin/pipeline', [
                'breadcrumb' => [
                'Clubhouse' => '/',
                'Admin' => '/admin',
                'Pipelines' => '/admin/pipeline',
            ],
            'contact_count' => $contact_job_count,
            'inquiry_count' => $inquiry_count,
        ]);
    }
}
