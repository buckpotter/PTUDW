<?php

namespace App\Http\Controllers;

use App\Models\TicketDetail;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminTicketDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_text = $request['search'] ?? "";
        $ticketDetails = TicketDetail::sortable()
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('normal_users', 'tickets.IdUser', '=', 'normal_users.IdUser')
            ->select('ticket_details.*', 'trips.IdChuyen', 'trips.GiaVe', 'bus_routes.TenTuyen', 'normal_users.HoTen')
            ->where('TinhTrangVe', 'Đã hủy');



        if ($search_text == "") {
            $ticketDetails = $ticketDetails->paginate(15);
        } else {
            $ticketDetails = $ticketDetails
                ->where(function ($query) use ($search_text) {
                    $query->where('IdCTBV', 'like', "%$search_text%")
                        ->orWhere('tickets.IdBanVe', 'like', "%$search_text%")
                        ->orWhere('trips.IdChuyen', 'like', "%$search_text%")
                        ->orWhere('TenTuyen', 'like', "%$search_text%")
                        ->orWhere('HoTen', 'like', "%$search_text%")
                        ->orWhere('GiaVe', 'like', "%$search_text%")
                        ->orWhere('pttt', 'like', "%$search_text%");
                })
                ->paginate(15);
        }

        $ticketDetails = $ticketDetails->appends(['search' => $search_text]);

        return view('ticket_details.index', [
            'ticket_details' => $ticketDetails,
            'search' => $search_text
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
     * @param  int  $IdCTBV
     * @return \Illuminate\Http\Response
     */
    public function show($IdCTBV)
    {
        $data = DB::table('ticket_details')
            ->where('ticket_details.IdCTBV', $IdCTBV)
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('normal_users', 'tickets.IdUser', '=', 'normal_users.IdUser')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->select('ticket_details.*', 'trips.*', 'bus_routes.TenTuyen', 'normal_users.HoTen', 'normal_users.sdt', 'normal_users.email', 'buses.So_xe', 'buses.So_Cho_Ngoi', 'bus_companies.Ten_NX')
            ->first();

        return view('ticket_details.show', [
            'ticket_detail' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $IdCTBV
     * @return \Illuminate\Http\Response
     */
    public function edit($IdCTBV)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdCTBV
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdCTBV)
    {
        // Không cho phép duyệt vé không thuộc quyền quản lý của nhà xe
        $IdNX = DB::table('ticket_details')
            ->where('ticket_details.IdCTBV', $IdCTBV)
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->select('bus_companies.IdNX')
            ->first()
            ->IdNX;
        if (Auth::user()->IdNX != NULL && Auth::user()->IdNX != $IdNX) {
            return redirect()->route('ticket_details.index')->with('error', 'Bạn không có quyền duyệt vé này');
        }

        DB::table('ticket_details')->where('IdCTBV', $IdCTBV)->update([
            'TinhTrangVe' => 'Chưa hoàn thành'
        ]);

        return redirect()->route('ticket_details.index')->with('message', 'Duyệt thành công vé ' . $IdCTBV);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $IdCTBV
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdCTBV)
    {
        //
    }
}
