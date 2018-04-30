<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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

        return view('admin/report', [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'users' => $users->get()
        ]);
    }

}
