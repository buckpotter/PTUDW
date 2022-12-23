<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use Illuminate\Support\Facades\DB;

class AdminTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'show',]);
    }

    public function index(Request $request)
    {
        // Nếu không có min, max, lower-limit, upper-limit thì gán giá trị mặc định
        request()->merge([
            'min' => $request['min'] ?? 0,
            'max' => $request['max'] ?? 1000000000,
            'lower-limit' => $request['lower-limit'] ?? '2022-01-01',
            'upper-limit' => $request['upper-limit'] ?? '2023-12-31',
        ]);

        $request->validate([
            'search' => 'nullable|string',
            'min' => 'nullable|numeric|gte:0|lt:max',
            'max' => 'nullable|numeric|gt:min',
            'lower-limit' => 'nullable',
            'upper-limit' => 'nullable|after:lower-limit',
        ]);

        $search_text = $request['search'] ?? "";
        $min = $request['min'] ?? "";
        $max = $request['max'] ?? "";
        $upperlimit = $request['upper-limit'] ?? "";
        $lowerlimit = $request['lower-limit'] ?? "";
        $tickets = Ticket::sortable()
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('normal_users', 'tickets.IdUser', '=', 'normal_users.IdUser')
            ->join('ticket_details', 'tickets.IdBanVe', '=', 'ticket_details.IdBanVe')
            ->select('tickets.IdBanVe', 'tickets.IdChuyen', 'trips.GiaVe', 'bus_routes.TenTuyen', 'normal_users.HoTen', 'normal_users.email', 'NgayDi', 'tickets.created_at', DB::raw('sum(GiaVe) as TongTien'), DB::raw('count(ticket_details.IdCTBV) as SoVe'))
            ->groupBy('tickets.IdBanVe', 'tickets.IdChuyen', 'trips.GiaVe', 'bus_routes.TenTuyen', 'normal_users.HoTen', 'normal_users.email', 'NgayDi', 'tickets.created_at');

        if ($search_text != "") {
            $tickets = $tickets
                ->where(function ($query) use ($search_text) {
                    $query->where('tickets.IdBanVe', 'like', "%$search_text%")
                        ->orWhere('tickets.IdChuyen', 'like', "%$search_text%")
                        ->orWhere('TenTuyen', 'like', "%$search_text%")
                        ->orWhere('HoTen', 'like', "%$search_text%")
                        ->orWhere('GiaVe', 'like', "%$search_text%")
                        ->orWhere('email', 'like', "%$search_text%");
                });
        }

        // Kiểm tra xem tổng tiền có nằm giữa min và max hay không
        if ($min && $max) {
            $tickets = $tickets->havingRaw('sum(GiaVe) between ? and ?', [$min, $max]);
        } else if ($min) {
            $tickets = $tickets->havingRaw('sum(GiaVe) >= ?', [$min]);
        } else if ($max) {
            $tickets = $tickets->havingRaw('sum(GiaVe) <= ?', [$max]);
        }


        // Kiểm tra xem ngày bán có nằm giữa upperlimit và lowerlimit hay không
        if ($upperlimit && $lowerlimit) {
            $tickets = $tickets->whereDate('tickets.created_at', '>=', $lowerlimit)->whereDate('tickets.created_at', '<=', $upperlimit);
        } else if ($upperlimit) {
            $tickets = $tickets->whereDate('tickets.created_at', '<=', $upperlimit);
        } else if ($lowerlimit) {
            $tickets = $tickets->whereDate('tickets.created_at', '>=', $lowerlimit);
        }

        // Áp dụng lọc, tìm kiếm, sắp xếp cho phân trang
        $tickets = $tickets->paginate(15)->appends([
            'min' => $min,
            'max' => $max,
            'search' => $search_text,
            'sort' => $request['sort'] ?? 'IdBanVe',
            'direction' => $request['direction'] ?? 'asc',
        ]);


        return view('tickets.index', [
            'tickets' => $tickets,
            'search' => $search_text,
            'min' => $min,
            'max' => $max,
            'upperlimit' => $upperlimit,
            'lowerlimit' => $lowerlimit,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $IdBanVe
     * @return \Illuminate\Http\Response
     */
    public function show($IdBanVe)
    {
        // Lấy thông tin hóa đơn
        $ticket = DB::table('tickets')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('normal_users', 'tickets.IdUser', '=', 'normal_users.IdUser')
            ->join('ticket_details', 'tickets.IdBanVe', '=', 'ticket_details.IdBanVe')
            ->where('tickets.IdBanVe', '=', $IdBanVe)
            ->select('tickets.IdBanVe', 'tickets.IdChuyen', 'trips.GiaVe', 'bus_routes.TenTuyen', 'normal_users.HoTen', 'normal_users.sdt', 'normal_users.email', 'tickets.created_at', DB::raw('sum(GiaVe) as TongTien'), DB::raw('count(ticket_details.IdCTBV) as SoVe'))
            ->groupBy('tickets.IdBanVe', 'tickets.IdChuyen', 'trips.GiaVe', 'bus_routes.TenTuyen', 'normal_users.HoTen', 'normal_users.sdt', 'normal_users.email', 'tickets.created_at')
            ->first();

        // Lấy thông tin các ghế đã đặt
        $seats = DB::table('ticket_details')
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->where('ticket_details.IdBanVe', '=', $IdBanVe)
            ->select('TenChoNgoi')
            ->get();

        // Lấy thông tin phương thức thanh toán
        $pttt = DB::table('tickets')
            ->join('ticket_details', 'tickets.IdBanVe', '=', 'ticket_details.IdBanVe')
            ->where('tickets.IdBanVe', '=', $IdBanVe)
            ->select('pttt')
            ->first()
            ->pttt;

        // Lấy thông tin xe
        $bus = DB::table('tickets')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->where('tickets.IdBanVe', '=', $IdBanVe)
            ->select('buses.So_xe', 'bus_companies.Ten_NX')
            ->first();

        // Lấy thông tin ngày giờ xuất phát
        $XuatPhat = DB::table('tickets')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->select('NgayDi', 'GioDi')
            ->first();


        return view('tickets.show', [
            'ticket' => $ticket,
            'seats' => $seats,
            'pttt' => $pttt,
            'bus' => $bus,
            'XuatPhat' => date('H:i:s d-m-Y', strtotime($XuatPhat->GioDi . ' ' . $XuatPhat->NgayDi))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $IdBanVe
     * @return \Illuminate\Http\Response
     */
    public function edit($IdBanVe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdBanVe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdBanVe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $IdBanVe
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdBanVe)
    {
        //
    }
}
