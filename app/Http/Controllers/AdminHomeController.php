<?php

namespace App\Http\Controllers;

use App\Models\BusCompany;
use App\Models\NormalUser;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function __invoke()
    {
        $Ten_NX = DB::table('bus_companies')->where('IdNX', '=', auth()->user()->IdNX)->value('Ten_NX');

        $completedTrips = DB::table('trips')
            ->where('NgayDi', '<', now())
            ->count();

        $soldTickets = DB::table('ticket_details')
            ->where('TinhTrangVe', '!=', 'Đã Hủy')
            ->count();


        $data = [
            'Người dùng' => [NormalUser::count(), '/imgs/user-icon.png', 'normal_users.index'],
            'Chuyến xe đã hoàn thành' => [$completedTrips, '/imgs/bus-svgrepo-com.svg', 'trips.index'],
            'Vé đã bán' => [$soldTickets, '/imgs/ticket-svgrepo-com.svg', 'ticket_details.index'],
            'Nhà xe' => [BusCompany::count(), '/imgs/building-svgrepo-com.svg', 'bus_companies.index'],
        ];



        if (Auth::user()->IdNX === null) {
            // Doanh thu trên toàn hệ thông theo tháng trong năm 2022
            $income = DB::table('ticket_details')
                ->select(DB::raw('MONTH(NgayDi) as month'), DB::raw('SUM(GiaVe) as income'))
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
                ->where('TinhTrangVe', '=', 'Đã Hoàn Thành')
                ->where('NgayDi', '<', now())
                ->groupBy('month')
                ->get();

            // Doanh thu theo từng nhà xe
            $busCompIncome = DB::table('ticket_details')
                ->select(DB::raw('Ten_NX'), DB::raw('SUM(GiaVe) as income'))
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
                ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
                ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
                ->where('TinhTrangVe', '=', 'Đã Hoàn Thành')
                ->where('NgayDi', '<', now())
                ->groupBy('Ten_NX')
                ->orderBy('income', 'desc')
                ->take(10)
                ->get();

            // Top 10 người dùng tiềm năng trên toàn hệ thống
            $potentialUsers = DB::table('normal_users')
                ->select(DB::raw('normal_users.IdUser'), DB::raw('HoTen'), DB::raw('sum(GiaVe) as sum'))
                ->join('tickets', 'normal_users.IdUser', '=', 'tickets.IdUser')
                ->join('ticket_details', 'tickets.IdBanVe', '=', 'ticket_details.IdBanVe')
                ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
                ->where('TinhTrangVe', '=', 'Đã Hoàn Thành')
                ->groupBy('IdUser', 'HoTen')
                ->orderBy('sum', 'desc')
                ->take(10)
                ->get()
                ->toArray();

            // Top 5 nhà xe có đánh giá cao nhất
            // $busCompRating = DB::table('bus_companies')
            //     ->select(DB::raw('Ten_NX'), DB::raw('AVG(DanhGia) as rating'))
            //     ->join('rates', 'bus_companies.IdNX', '=', 'rates.IdNX')
            //     ->groupBy('Ten_NX')
            //     ->orderBy('rating', 'desc')
            //     ->take(5)
            //     ->get()
            //     ->toArray();

            // Thống kê loại xe 
            $busTypes = DB::table('buses')
                ->select(DB::raw('Loai_Xe'), DB::raw('COUNT(*) as count'))
                ->groupBy('Loai_Xe')
                ->get();

            // Thống kê trạng thái vé
            $ticketStatus = DB::table('ticket_details')
                ->select(DB::raw('TinhTrangVe'), DB::raw('COUNT(*) as count'))
                ->groupBy('TinhTrangVe')
                ->get();

            // Danh sách nhà xe phục vụ cho admin tổng truy xuất dữ liệu của từng nhà xe
            $busComps = DB::table('bus_companies')->get();
            return view(
                'admin.index',
                [
                    'data' => $data,
                    'Ten_NX' => $Ten_NX,
                    'completedTrips' => $completedTrips,
                    'soldTickets' => $soldTickets,
                    'income' => $income,
                    'busCompIncome' => $busCompIncome,
                    'potentialUsers' => $potentialUsers,
                    // 'busCompRating' => $busCompRating,
                    'busTypes' => $busTypes,
                    'ticketStatus' => $ticketStatus,
                    'busComps' => $busComps
                ]
            );
        } else {
            // Doanh thu của nhà xe mà admin đang quản lý
            $adminBCIncome = DB::table('ticket_details')
                ->select(DB::raw('Month(NgayDi) as month'), DB::raw('SUM(GiaVe) as income'))
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
                ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
                ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
                ->where('TinhTrangVe', '=', 'Đã Hoàn Thành')
                ->where('NgayDi', '<', now())
                ->where('bus_companies.IdNX', '=', auth()->user()->IdNX)
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
                ->where('bus_companies.IdNX', '=', auth()->user()->IdNX)
                ->groupBy('IdUser', 'HoTen')
                ->orderBy('sum', 'desc')
                ->take(10)
                ->get()
                ->toArray();


            return view('index', [
                'data' => $data,
                'Ten_NX' => $Ten_NX,
                'completedTrips' => $completedTrips,
                'soldTickets' => $soldTickets,
                'adminBCIncome' => $adminBCIncome,
                'adminPotentialUsers' => $adminPotentialUsers,
            ]);
        }
    }
}
