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

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function move($id, $type, $action)
    {
        // This is the lowest valid step that the users are allowed to take.
        $LOWEST_VALID_STEP = 3;   

        try {
            $job_pipeline = JobPipeline::all();

            $max_job_pipeline_step = $job_pipeline[0]::orderBy('pipeline_id', 'desc')->first();

            // Getting the type of job canidate, contact or inquiry
            $canidate = null;

            // $isValidStep = false;

            $note = new Note();

            if ($type == 'contact') {
                $canidate = ContactJob::find($id);
                
                $note->user_id = Auth::user()->id;
                $note->notable_id = $canidate->contact->id;
                $note->notable_type = "App\Contact";
                // $note->content = "Moved to " . $job_pipeline[$canidate->pipeline_id]->name . " on " .$canidate->job->title . " [id:" . $canidate->job->id . "].";

            } elseif ($type == 'user') {
                $canidate = Inquiry::find($id);
                
                $note->user_id = Auth::user()->id;
                $note->notable_id = $canidate->id;
                $note->notable_type = "App\Inquiry";
                // $note->content = "Moved to " . $job_pipeline[$canidate->pipeline_id]->name . " on " .$canidate->job->title . " [id:" . $canidate->job->id . "].";
            } else {
                return response()->json([
                    'type' => 'failure',
                    'action' => $action,
                    'id_type' => $type,
                    'id' => $id,
                ]);
            }
            $test = false;
            switch ($action) {
                case "forward":
                    if ($canidate->pipeline_id < $max_job_pipeline_step->pipeline_id) {
                        if ($canidate->pipeline_id == 1) {
                            try {
                                if ($type == 'user') {
                                    switch ($canidate->job->recruiting_type_code) {
                                        case 'active':
                                            Mail::to($canidate->user)->send(new InquiryRated($canidate, 'active-up'));
                                            break;
                                        case 'passive':
                                            Mail::to($canidate->user)->send(new InquiryRated($canidate, 'passive-up'));
                                            break;
                                        default:
                                            break;
                                    }
                                } elseif ($type == 'contact') {
                                    switch ($canidate->job->recruiting_type_code) {
                                    /*
                                        case 'active':
                                            // Trying to get property of non-object
                                            Mail::to($canidate->contact->user)->send(new ContactWarmComm($canidate, 'active'));
                                            break;
                                        case 'passive':
                                            // Trying to get property of non-object
                                            Mail::to($canidate->contact->user)->send(new ContactColdComm($canidate, 'passive'));
                                            break;
                                        default:
                                            break;
                                            */
                                    }
                                }
                                $test = true;
                            } catch (Exception $e) {
                                // TODO log exception
                                Log::error($e->getMessage());
                                return response()->json([
                                    'type' => 'failure',
                                    'action' => $action,
                                    'id_type' => $type,
                                    'id' => $id,
                                    'email_error' => $e->getMessage(),
                                ]);
                            }
                        }
                        $canidate->pipeline_id += 1;
                        $note->content = "Moved to " . $job_pipeline[$canidate->pipeline_id-1]->name . " on " .$canidate->job->title . " [id:" . $canidate->job->id . "].";
                        
                        // $isValidStep = true;
                        break;
                    }
                case "halt":    
                    // stubbed for note and possible email communications
                    // $isValidStep = true;
                    break;
                case "backward":
                    if ($canidate->pipeline_id >= $LOWEST_VALID_STEP) {
                        $canidate->pipeline_id -= 1;
                        $note->content = "Moved to " . $job_pipeline[$canidate->pipeline_id-1]->name . " on " .$canidate->job->title . " [id:" . $canidate->job->id . "].";
                        
                        // $isValidStep = true;
                        break;
                    }
                default:
                    return response()->json([
                        'type' => 'failure',
                        'action' => $action,
                        'id_type' => $type,
                        'id' => $id,
                    ]);
                    break;
            }

            // Check is we made a valid step, if so save.
            // if ($isValidStep) {
            $canidate->save();
            $note->save();
            $isValidStep = false;
            // } else {
            //     return response()->json([
            //         'type' => 'failure',
            //         'action' => $action,
            //         'id_type' => $type,
            //         'id' => $id,
            //         'new' => 'fail'
            //     ]);
            // }
        } catch( \Exception $e){
            Log::error($e->getMessage());

            return response()->json([
                'type' => 'failure',
                'action' => $action,
                'id_type' => $type,
                'id' => $id,
                'canidate_id' => $canidate->pipeline_id,
                'test' => $canidate,
                'new' => $e->getMessage()
            ]);
        }

        return response()->json([
            'type' => 'success',
            'action' => $action,
            'id_type' => $type,
            'id' => $id,
            'pipeline_position' => $canidate->pipeline_id,
        ]);
    }

    public function job(Request $request)
    {
        $this->authorize('view-admin-pipelines');

        // $start_date = $request->query->get('date_range_start');
        // $end_date = $request->query->get('date_range_end');

        // if (is_null($end_date)) {
        //     $end_date = new \DateTime('now');
        // } else {
        //     $end_date = new \DateTime($end_date);
        // }

        // if (is_null($start_date)) {
        //     $start_date = clone $end_date;
        //     $start_date->sub(new \DateInterval('P30D'));
        // } else {
        //     $start_date = new \DateTime($start_date);
        // }

        // $clubhouse_users = RoleUser::where('role_code', 'clubhouse');

        // $transactions = DB::table('transaction_product_option as tpo')
        //     ->selectRaw('DATE_FORMAT(t.created_at,\'%Y-%m-%d\') as date, u.id as user_id, u.first_name, u.last_name, u.email, p.id as product_id, p.name, pt.tag_name')
        //     ->join('transaction as t','tpo.transaction_id', 't.id')
        //     ->join('user as u','t.user_id', 'u.id')
        //     ->join('product_option as po','tpo.product_option_id', 'po.id')
        //     ->join('product as p','po.product_id', 'p.id')
        //     ->join('product_tag as pt','pt.product_id', 'p.id')->whereIn('pt.tag_name', array('Career Service', 'Membership', 'Webinar'))
        //     ->where('t.created_at', '>=', $start_date->format('Y-m-d'))
        //     ->where('t.created_at', '<=', $end_date->format('Y-m-d').' 23:59:59')
        //     ->orderBy('t.created_at', 'DESC')
        //     ->get();
            //->toSql();
        $steps = DB::table('pipeline')->get();
        $job_pipeline_steps = DB::table('pipeline')
            ->join('job_pipeline', 'job_pipeline.pipeline_id', 'pipeline.id')
            ->get();

        return view('admin/pipeline/pipeline', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Admin' => '/admin',
                'Pipelines' => '/admin/pipeline ',
                // 'Transactions' => '/admin/report/transactions's
            ],
            'steps' => $steps,
            'job_pipeline_steps' => $job_pipeline_steps,
            // 'start_date' => $start_date,
            // 'end_date' => $end_date,
            // 'clubhouse_users' => $clubhouse_users->get(),
            // 'transactions' => $transactions,
        ]);
    }

    public function ajaxProductTypePurchaseCountGraph(Request $request)
    {
        $this->authorize('view-admin-reports');

        $start_date = $request->query->get('date_range_start');
        $end_date = $request->query->get('date_range_end');
        
        if (is_null($end_date)) {
            $end_date = new \DateTime('now');
        } else {
            $end_date = new \DateTime($end_date);
        }

        if (is_null($start_date)) {
            $start_date = clone $end_date;
            $start_date->sub(new \DateInterval('P30D'));
        } else {
            $start_date = new \DateTime($start_date);
        }

        $products = DB::table('transaction_product_option as tpo')
            ->selectRaw('DATE_FORMAT(t.created_at,\'%Y-%m-%d\') as date, pt.tag_name, count(po.id) as count')
            ->join('transaction as t','tpo.transaction_id', 't.id')
            ->join('product_option as po','tpo.product_option_id', 'po.id')
            ->join('product as p','po.product_id', 'p.id')
            ->join('product_tag as pt','pt.product_id', 'p.id')->whereIn('pt.tag_name', array('Career Service', 'Membership', 'Webinar'))
            ->where('t.created_at', '>=', $start_date->format('Y-m-d'))
            ->where('t.created_at', '<=', $end_date->format('Y-m-d').' 23:59:59')
            ->groupBy('date','pt.tag_name')
            ->get();

        // Structure report
        $data = array();
        $products = $products->toArray();
        $active_products = array('Career Service', 'Webinar', 'Membership');

        $date = clone $start_date;
        $i = 0; 
        $current_products = array();
        while ($date->getTimestamp() <= $end_date->getTimestamp()) {
            $current_date = $date->format('Y-m-d');
            //$current_data = $products[$i];
            $labels[] = $date->format('Y-m-d');
            //var_dump($date->format('Y-m-d'));

            while (isset($products[$i]) && $current_date == $products[$i]->date) {
                $current_products[] = $products[$i]->tag_name;
                $data[$products[$i]->tag_name][] = $products[$i]->count;
                $i++;
                /*
                if (isset($products[$i])) {
                    $current_data = $products[$i];
                }
                */
            }    
            foreach (array_diff($active_products, $current_products) as $missing_product) {
                $data[$missing_product][] = 0; 
            }    
            $current_products = array();

            $date->add(new \DateInterval('P1D'));
        }    

        return response()->json(
            array(
                'graph' => array(
                    'labels' => $labels,
                    'data' => $data,
                )
            )
        );
    }

    public function notes(Request $request)
    {
        $this->authorize('view-admin-reports');

        $start_date = $request->query->get('date_range_start');
        $end_date = $request->query->get('date_range_end');
        if (is_null($end_date)) {
            $end_date = new \DateTime('now');
        } else {
            $end_date = new \DateTime($end_date);
        }

        if (is_null($start_date)) {
            $start_date = clone $end_date;
            $start_date->sub(new \DateInterval('P30D'));
        } else {
            $start_date = new \DateTime($start_date);
        }

        $users = User::join('role_user', 'role_user.user_id', 'user.id')
            ->where('role_user.role_code', 'sbs');

        return view('admin/report/notes', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Admin' => '/admin',
                'Reports' => '/admin/report',
                'Notes' => '/admin/report/notes'
            ],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'users' => $users->get()
        ]);
    }
}
