<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeadAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {


        $adminBCIncome = DB::table('ticket_details')
            ->select(DB::raw('Month(NgayDi) as month'), DB::raw('SUM(GiaVe) as income'))
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->where('TinhTrangVe', '=', 'Đã Hoàn Thành')
            ->where('NgayDi', '<', now())
            ->where('bus_companies.IdNX', '=', $request->IdNX)
            ->groupBy('month')
            ->get();

        // Top 10 người dùng tiềm năng của nhà xe mà admin đang quản lý
        $adminPotentialUsers = DB::table('normal_users')
            ->select(DB::raw('normal_users.IdUser'), DB::raw('HoTen'), DB::raw('sum(GiaVe) as sum'))
            ->join('tickets', 'normal_users.IdUser', '=', 'tickets.IdUser')
            ->join('ticket_details', 'tickets.IdBanVe', '=', 'ticket_details.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->where('TinhTrangVe', '=', 'Đã Hoàn Thành')
            ->where('bus_companies.IdNX', '=', $request->IdNX)
            ->groupBy('IdUser', 'HoTen')
            ->orderBy('sum', 'desc')
            ->take(10)
            ->get()
            ->toArray();

        $Ten_NX = DB::table('bus_companies')->where('IdNX', '=', $request->IdNX)->value('Ten_NX');

        return view('admin.show', [
            'Ten_NX' => $Ten_NX,
            'adminBCIncome' => $adminBCIncome,
            'adminPotentialUsers' => $adminPotentialUsers,
        ]);
    }
}
