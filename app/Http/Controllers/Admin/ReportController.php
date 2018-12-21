<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Note;
use App\User;
use App\Product;
use App\RoleUser;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-admin-reports');

        $one_month_ago = (new \DateTime('now'))->sub(new \DateInterval('P30D'))->format('Y-m-d');
        $sixty_days_ago = (new \DateTime('now'))->sub(new \DateInterval('P60D'))->format('Y-m-d');

        $total_note_count = Note::all()->count();
        $month_note_count = Note::where('created_at', '>', $one_month_ago)->count();
        $sixty_day_note_count = Note::where('created_at', '>', $sixty_days_ago)->count();

        $total_transactions = Transaction::all()->count();
        $month_transaction_count = Transaction::where('created_at', '>', $one_month_ago)->count();
        $sixty_day_transaction_count = Transaction::where('created_at', '>', $sixty_days_ago)->count();

        return view('admin/report', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Admin' => '/admin',
                'Reports' => '/admin/report',
            ],
            'total_note_count' => $total_note_count,
            'one_month_ago' => $one_month_ago,
            'month_note_count' => $month_note_count,
            'sixty_day_note_count' => $sixty_day_note_count,
            'total_transactions' => $total_transactions,
            'month_transaction_count' => $month_transaction_count,
            'sixty_day_transaction_count' => $sixty_day_transaction_count
        ]);
    }

    public function stripe(Request $request)
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

        $transactions = DB::table('transaction_product_option as tpo')
            ->selectRaw('p.name, count(po.id)')
            ->join('product_option as po','tpo.product_option_id', 'po.id')
            ->join('product as p','po.product_id', 'p.id')
            ->groupBy('p.id')
            ->get();

        dd($transactions);

        return view('admin/report', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'users' => $users->get()
        ]);
    }

    public function transactions(Request $request)
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

        $clubhouse_users = RoleUser::where('role_code', 'clubhouse');

        return view('admin/report/transactions', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Admin' => '/admin',
                'Reports' => '/admin/report',
                'Sales' => '/admin/report/sales'
            ],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'clubhouse_users' => $clubhouse_users->get()
        ]);
    }

    public function ajaxProductPurchaseCountGraph(Request $request)
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
            ->selectRaw('DATE_FORMAT(t.created_at,\'%m / %Y\') as date, p.name, count(po.id) as count')
            ->join('transaction as t','tpo.transaction_id', 't.id')
            ->join('product_option as po','tpo.product_option_id', 'po.id')
            ->join('product as p','po.product_id', 'p.id')
            ->groupBy('date','p.id')
            ->get();

        // Structure report
        $data = array();
        $products = $products->toArray();
        $active_products = array_column($products, 'name');
        //foreach ($actions as $action) {
        //    $data[$action] = array();
        //    $totals[$action] = array(
        //        'count' => 0,
        //        'average_per_day' => 0,
        //        'percent' => 0 
        //    );   
        //}    

        $date = clone $start_date;
        $i = 0; 
        $current_products = array();
        while ($date->getTimestamp() <= $end_date->getTimestamp()) {
            $current_date = $date->format('m / Y');
            $current_data = $products[$i];
            $labels[] = $date->format('m / Y');

            while ($current_date == $current_data->date) {
                $current_products[] = $current_data->name;
                $data[$current_data->name][] = $current_data->count;
                //$totals[$current_data['shipping_action']]['count'] += $current_data['count'];
                //$grand_total += $current_data['count'];
                $i++;
                if (!isset($products[$i])) {
                    break 2;
                }
                $current_data = $products[$i];
            }    
            foreach (array_diff($active_products, $current_products) as $missing_product) {
                $data[$missing_product][] = 0; 
            }    
            $current_products = array();

            $date->add(new \DateInterval('P1M'));
        }    

        //$number_of_days = count($labels);

        //foreach ($totals as $action => $action_data) {
        //    if ($action_data['count'] > 0) { 
        //        $totals[$action]['percent'] = round($action_data['count'] / $grand_total * 100, 2);
        //        $totals[$action]['average_per_day'] = round($action_data['count'] / $number_of_days, 0);
        //    }    
        //}    

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
