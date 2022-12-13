<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTripsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = DB::table('trips')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->select('trips.*', 'buses.So_xe', 'bus_routes.TenTuyen', 'bus_companies.Ten_NX')
            ->paginate(15);
        return view(
            'trips.index',
            [
                'trips' => $trips
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = [
            'Hòa Bình', 'Sơn La', 'Điện Biên', 'Lai Châu', 'Lào Cai', 'Yên Bái', 'Phú Thọ', 'Hà Giang', 'Tuyên Quang', 'Cao Bằng', 'Bắc Kạn', 'Thái Nguyên', 'Lạng Sơn', 'Bắc Giang', 'Quảng Ninh', 'Hà Nội', 'Bắc Ninh', 'Hà Nam', 'Hải Dương', 'Hải Phòng', 'Hưng Yên', 'Nam Định', 'Thái Bình', 'Vĩnh Phúc', 'Ninh Bình', 'Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Quảng Bình', 'Quảng Trị', 'Huế', 'Đà Nẵng', 'Quảng Nam', 'Quảng Ngãi', 'Bình Định', 'Phú Yên', 'Khánh Hòa', 'Ninh Thuận', 'Bình Thuận', 'TP. Hồ Chí Minh', 'Vũng Tàu', 'Bình Dương', 'Bình Phước', 'Đồng Nai', 'Tây Ninh', 'An Giang', 'Bạc Liêu', 'Bến Tre', 'Cà Mau', 'Cần Thơ', 'Đồng Tháp', 'Hậu Giang', 'Kiên Giang', 'Long An', 'Sóc Trăng', 'Tiền Giang', 'Trà Vinh', 'Vĩnh Long', 'Kon Tum', 'Gia Lai', 'Đắk Lắk', 'Đắk Nông', 'Lâm Đồng',
        ];

        return view('trips.create', [
            'cities' => $cities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate
        $request->validate([
            'DiemDi' => 'required|different:DiemDen',
            'DiemDen' => 'required|different:DiemDi',
            'XuatPhat' => 'required|after_or_equal:today',
            'Den' => 'required|after:XuatPhat',
            'So_xe' => 'required|regex:/^[0-9]{2}[A-Za-z]{1}-[0-9]{4,5}$/|exists:buses,So_xe',
            'GiaVe' => 'required|numeric|gt:0',
        ]);

        $IdTuyen = DB::table('bus_routes')->where('TenTuyen', $request->DiemDi . ' - ' . $request->DiemDen)->first()->IdTuyen;

        // Insert
        $request->merge([
            'IdXe' => DB::table('buses')->where('So_xe', $request->So_xe)->first()->IdXe,
            'IdTuyen' => $IdTuyen,
            'GioDi' => date('H:i:s', strtotime($request->XuatPhat)),
            'GioDen' => date('H:i:s', strtotime($request->Den)),
            'NgayDi' => date('Y-m-d', strtotime($request->XuatPhat)),
            'NgayDen' => date('Y-m-d', strtotime($request->Den)),
        ]);


        $count = DB::table('trips')->count() + 1;
        while (true) {
            $check = DB::table('trips')->where('IdChuyen', 'T' . $count)->first();
            if ($check == null)
                break;
            $count++;
        }


        Trip::create([
            'IdChuyen' => 'T' . $count,
            'IdTuyen' => $request->IdTuyen,
            'NgayDi' => $request->NgayDi,
            'GioDi' => $request->GioDi,
            'NgayDen' => $request->NgayDen,
            'GioDen' => $request->GioDen,
            'IdXe' => $request->IdXe,
            'GiaVe' => $request->GiaVe,
        ]);

        // dd($request->all());

        return redirect()->route('trips.index')
            ->with('message', 'Tạo chuyến xe thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $IdChuyen
     * @return \Illuminate\Http\Response
     */
    public function show($IdChuyen)
    {
        $trip = DB::table('trips')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->select('trips.*', 'buses.So_xe', 'bus_routes.TenTuyen', 'bus_companies.Ten_NX', 'buses.So_Cho_Ngoi')
            ->where('trips.IdChuyen', $IdChuyen)
            ->first();

        $reservedSeats = DB::table('ticket_details')
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->where('tickets.IdChuyen', $IdChuyen)
            ->where('ticket_details.TinhTrangVe', '!=', 'Đã hủy')
            ->count();

        return view('trips.show', [
            'trip' => $trip,
            'availableSeats' => $trip->So_Cho_Ngoi - $reservedSeats,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $IdChuyen
     * @return \Illuminate\Http\Response
     */
    public function edit($IdChuyen)
    {
        $cities = [
            'Hòa Bình', 'Sơn La', 'Điện Biên', 'Lai Châu', 'Lào Cai', 'Yên Bái', 'Phú Thọ', 'Hà Giang', 'Tuyên Quang', 'Cao Bằng', 'Bắc Kạn', 'Thái Nguyên', 'Lạng Sơn', 'Bắc Giang', 'Quảng Ninh', 'Hà Nội', 'Bắc Ninh', 'Hà Nam', 'Hải Dương', 'Hải Phòng', 'Hưng Yên', 'Nam Định', 'Thái Bình', 'Vĩnh Phúc', 'Ninh Bình', 'Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Quảng Bình', 'Quảng Trị', 'Huế', 'Đà Nẵng', 'Quảng Nam', 'Quảng Ngãi', 'Bình Định', 'Phú Yên', 'Khánh Hòa', 'Ninh Thuận', 'Bình Thuận', 'TP. Hồ Chí Minh', 'Vũng Tàu', 'Bình Dương', 'Bình Phước', 'Đồng Nai', 'Tây Ninh', 'An Giang', 'Bạc Liêu', 'Bến Tre', 'Cà Mau', 'Cần Thơ', 'Đồng Tháp', 'Hậu Giang', 'Kiên Giang', 'Long An', 'Sóc Trăng', 'Tiền Giang', 'Trà Vinh', 'Vĩnh Long', 'Kon Tum', 'Gia Lai', 'Đắk Lắk', 'Đắk Nông', 'Lâm Đồng',
        ];

        $Tuyen = DB::table('trips')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->select('bus_routes.TenTuyen')
            ->where('trips.IdChuyen', $IdChuyen)
            ->first();
        $DiemDi = explode(' - ', $Tuyen->TenTuyen)[0];
        $DiemDen = explode(' - ', $Tuyen->TenTuyen)[1];

        $trip = DB::table('trips')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->select('trips.*', 'buses.So_xe', 'bus_routes.TenTuyen', 'bus_companies.Ten_NX', 'buses.So_Cho_Ngoi')
            ->where('trips.IdChuyen', $IdChuyen)
            ->first();

        $XuatPhat = date('Y-m-d H:i:s', strtotime("$trip->NgayDi $trip->GioDi"));
        $Den = date('Y-m-d H:i:s', strtotime("$trip->NgayDen $trip->GioDen"));
        return view('trips.edit', [
            'trip' => $trip,
            'cities' => $cities,
            'DiemDi' => $DiemDi,
            'DiemDen' => $DiemDen,
            'XuatPhat' => $XuatPhat,
            'Den' => $Den,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdChuyen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdChuyen)
    {
        // Validate
        $request->validate([
            'DiemDi' => 'required|different:DiemDen',
            'DiemDen' => 'required|different:DiemDi',
            'XuatPhat' => 'required|after_or_equal:today',
            'Den' => 'required|after:XuatPhat',
            'So_xe' => 'required|regex:/^[0-9]{2}[A-Za-z]{1}-[0-9]{4,5}$/|exists:buses,So_xe',
            'GiaVe' => 'required|numeric|gt:0',
        ]);

        $IdTuyen = DB::table('bus_routes')->where('TenTuyen', $request->DiemDi . ' - ' . $request->DiemDen)->first()->IdTuyen;

        // Insert
        $request->merge([
            'IdXe' => DB::table('buses')->where('So_xe', $request->So_xe)->first()->IdXe,
            'IdTuyen' => $IdTuyen,
            'GioDi' => date('H:i:s', strtotime($request->XuatPhat)),
            'GioDen' => date('H:i:s', strtotime($request->Den)),
            'NgayDi' => date('Y-m-d', strtotime($request->XuatPhat)),
            'NgayDen' => date('Y-m-d', strtotime($request->Den)),
        ]);

        Trip::where('IdChuyen', $IdChuyen)
            ->update([
                'IdTuyen' => $request->IdTuyen,
                'NgayDi' => $request->NgayDi,
                'GioDi' => $request->GioDi,
                'NgayDen' => $request->NgayDen,
                'GioDen' => $request->GioDen,
                'IdXe' => $request->IdXe,
                'GiaVe' => $request->GiaVe,
            ]);

        // dd($request->all());

        return redirect()->route('trips.show', $IdChuyen)
            ->with('message', 'Sửa thông tin chuyến xe thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $IdChuyen
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdChuyen)
    {
        // xóa các vé đã bán của chuyến xe
        // $tickets là mảng các object đại diện cho hóa đơn của chuyến xe
        $tickets = DB::table('tickets')->where('IdChuyen', $IdChuyen)->get()->toArray();
        foreach ($tickets as $ticket)
            DB::table('ticket_details')->where('IdBanVe', $ticket->IdBanVe)->delete();

        // xóa hóa đơn của các vé đã bán của chuyến xe
        DB::table('tickets')->where('IdChuyen', $IdChuyen)->delete();

        // xóa chuyến xe
        DB::table('trips')->where('IdChuyen', $IdChuyen)->delete();

        return redirect()->route('trips.index')
            ->with('message', 'Xóa chuyến xe thành công.');
    }
}
