<?php

namespace App\Http\Controllers;

use App\Models\TicketDetail;
use Illuminate\Http\Request;
use App\Mail\TicketsStatusMail;
use Dflydev\DotAccessData\Data;
use Illuminate\Broadcasting\Broadcasters\AblyBroadcaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class AdminTicketDetailsController extends Controller
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

        $ticketDetails = TicketDetail::sortable()
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('normal_users', 'tickets.IdUser', '=', 'normal_users.IdUser')
            ->select('ticket_details.*', 'trips.IdChuyen', 'trips.GiaVe', 'bus_routes.TenTuyen', 'normal_users.email')
            ->where('TinhTrangVe', 'Chờ xác nhận');

        if ($search_text != "") {
            $ticketDetails = $ticketDetails
                ->where(function ($query) use ($search_text) {
                    $query->where('IdCTBV', 'like', "%$search_text%")
                        ->orWhere('tickets.IdBanVe', 'like', "%$search_text%")
                        ->orWhere('trips.IdChuyen', 'like', "%$search_text%")
                        ->orWhere('TenTuyen', 'like', "%$search_text%")
                        ->orWhere('email', 'like', "%$search_text%")
                        ->orWhere('pttt', 'like', "%$search_text%");
                });
        }

        // Giá vé giữa min và max
        if ($min && $max) {
            $ticketDetails = $ticketDetails->whereBetween('GiaVe', [$min, $max]);
        } else if ($min) {
            $ticketDetails = $ticketDetails->where('GiaVe', '>=', $min);
        } else if ($max) {
            $ticketDetails = $ticketDetails->where('GiaVe', '<=', $max);
        }

        // Ngày tạo giữa lower-limit và upper-limit
        if ($lowerlimit && $upperlimit) {
            $ticketDetails = $ticketDetails->whereBetween('ticket_details.created_at', [$lowerlimit, $upperlimit]);
        } else if ($lowerlimit) {
            $ticketDetails = $ticketDetails->where('ticket_details.created_at', '>=', $lowerlimit);
        } else if ($upperlimit) {
            $ticketDetails = $ticketDetails->where('ticket_details.created_at', '<=', $upperlimit);
        }

        $ticketDetails = $ticketDetails->paginate(15)->appends([
            'search' => $search_text,
            'min' => $min,
            'max' => $max,
            'lower-limit' => $lowerlimit,
            'upper-limit' => $upperlimit,
            'sort' => $request['sort'] ?? 'IdCTBV',
            'direction' => $request['direction'] ?? 'asc',
        ]);

        return view('ticket_details.index', [
            'ticket_details' => $ticketDetails,
            'search' => $search_text,
            'min' => $min,
            'max' => $max,
            'lowerlimit' => $lowerlimit,
            'upperlimit' => $upperlimit,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdCTBV
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdCTBV)
    {
        // Không cho phép duyệt vé không thuộc quyền quản lý của nhà xe
        if (Auth::user()->IdNX != NULL) {
            $IdNX = DB::table('ticket_details')
                ->where('ticket_details.IdCTBV', $IdCTBV)
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
                ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
                ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
                ->select('bus_companies.IdNX')
                ->first()
                ->IdNX;
            if (Auth::user()->IdNX != $IdNX)
                return redirect()->route('ticket_details.index')->with('error', 'Bạn không có quyền duyệt vé này');
        }

        DB::table('ticket_details')->where('IdCTBV', $IdCTBV)->update([
            'TinhTrangVe' => 'Chưa hoàn thành'
        ]);

        // gửi email thông báo đã hủy vé cho người dùng
        self::sendMail($IdCTBV, 'Duyệt');

        return redirect()->route('ticket_details.index')->with('message', 'Duyệt thành công vé ' . $IdCTBV);
    }

    public function cancel($IdCTBV)
    {
        // Không cho phép hủy vé không thuộc quyền quản lý của nhà xe
        if (Auth::user()->IdNX != NULL) {
            $IdNX = DB::table('ticket_details')
                ->where('ticket_details.IdCTBV', $IdCTBV)
                ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
                ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
                ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
                ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
                ->select('bus_companies.IdNX')
                ->first()
                ->IdNX;
            if (Auth::user()->IdNX != $IdNX)
                return redirect()->route('ticket_details.index')->with('error', 'Bạn không có quyền hủy vé này');
        }

        DB::table('ticket_details')->where('IdCTBV', $IdCTBV)->update([
            'TinhTrangVe' => 'Đã hủy'
        ]);

        // gửi email thông báo đã hủy vé cho người dùng
        self::sendMail($IdCTBV, 'Hủy');

        return redirect()->route('ticket_details.index')->with('message', 'Hủy thành công vé ' . $IdCTBV);
    }

    public function sendMail($IdCTBV, $status)
    {
        // gửi email thông báo đã hủy vé cho người dùng
        $IdBanVe = DB::table('ticket_details')
            ->where('ticket_details.IdCTBV', $IdCTBV)
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->select('tickets.IdBanVe')
            ->first()
            ->IdBanVe;

        $email = DB::table('normal_users')
            ->join('tickets', 'normal_users.IdUser', '=', 'tickets.IdUser')
            ->where('tickets.IdBanVe', $IdBanVe)
            ->select('normal_users.email')
            ->first()
            ->email;

        $mailData = [
            'IdCTBV' => $IdCTBV,
            'IdBanVe' => $IdBanVe,
            'status' => $status,
        ];
        Mail::to("$email")->send(new TicketsStatusMail($mailData));
    }
}
