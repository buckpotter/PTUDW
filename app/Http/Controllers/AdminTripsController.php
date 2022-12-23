<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Trip;
use App\Models\BusCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminTripsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show']);
    }

    public function index(Request $request)
    {
        $search_text = $request['search'] ?? "";
        $trips = NULL;

        if ($search_text == "") {
            $trips = Trip::sortable()
                ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
                ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
                ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
                ->select('trips.*', 'buses.So_xe', 'bus_routes.TenTuyen', 'bus_companies.Ten_NX')
                ->paginate(15);
        } else {
            $trips = Trip::sortable()
                ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
                ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
                ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
                ->select('trips.*', 'buses.So_xe', 'bus_routes.TenTuyen', 'bus_companies.Ten_NX')
                ->where('IdChuyen', 'like', "%$search_text%")
                ->orWhere('NgayDi', 'like', "%$search_text%")
                ->orWhere('GioDi', 'like', "%$search_text%")
                ->orWhere('GioDen', 'like', "%$search_text%")
                ->orWhere('So_xe', 'like', "%$search_text%")
                ->orWhere('TenTuyen', 'like', "%$search_text%")
                ->orWhere('Ten_NX', 'like', "%$search_text%")
                ->orWhere('GiaVe', 'like', "%$search_text%")
                ->paginate(15);
        }

        $trips = $trips->appends([
            'search' => $search_text,
            'sort' => $request['sort'] ?? 'IdChuyen',
            'direction' => $request['direction'] ?? 'asc'
        ]);

        return view(
            'trips.index',
            [
                'trips' => $trips,
                'search' => $search_text
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
        // Nếu không phải admin tổng thì không được thêm chuyến xe không phải thuộc nhà xe của mình
        if (Auth::user()->IdNX != NULL && Bus::where('So_xe', $request->So_xe)->first()->IdNX != Auth::user()->IdNX)
            return redirect()->route('trips.index')->with('error', 'Bạn không thể thực hiện thao tác này!');


        // Validate
        $request->validate([
            'DiemDi' => 'required|different:DiemDen',
            'DiemDen' => 'required|different:DiemDi',
            'XuatPhat' => 'required|after_or_equal:today',
            'Den' => 'required|after:XuatPhat',
            'So_xe' => 'required|regex:/^[0-9]{2}[A-Za-z]{1}-[0-9]{4,5}$/|exists:buses,So_xe',
            'GiaVe' => 'required|numeric|gt:0',
        ]);

        // Kiểm tra xem xe đã có chuyến trong khoảng thời gian đã hay không
        $trips = DB::table('trips')
            ->where('IdXe', DB::table('buses')->where('So_xe', $request->So_xe)->first()->IdXe)
            ->get();
        foreach ($trips as $trip) {
            // Lịch trình của chuyến đi đã có
            $XuatPhat = date('Y-m-d H:i:s', strtotime($request->XuatPhat));
            $Den = date('Y-m-d H:i:s', strtotime($request->Den));

            // Lịch trình của chuyến đi đang xét
            $departure = date('Y-m-d H:i:s', strtotime("$trip->NgayDi $trip->GioDi"));
            $arrival = date('Y-m-d H:i:s', strtotime("$trip->NgayDen $trip->GioDen"));

            // Kiểm tra xem có trùng lịch trình không

            if (($departure >= $XuatPhat && $departure <= $Den) || ($arrival >= $XuatPhat && $arrival <= $Den) || ($departure <= $XuatPhat && $arrival >= $Den))
                return redirect()->route('trips.create')->with('message', 'Xe đã có chuyến đi trong khoảng thời gian này!');
        }


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
        // Lấy thông tin chuyến xe
        $trip = DB::table('trips')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->join('bus_companies', 'buses.IdNX', '=', 'bus_companies.IdNX')
            ->select('trips.*', 'buses.So_xe', 'bus_routes.TenTuyen', 'bus_companies.Ten_NX', 'buses.So_Cho_Ngoi')
            ->where('trips.IdChuyen', $IdChuyen)
            ->first();

        // Lấy số vé đã đặt
        $reservedSeats = DB::table('ticket_details')
            ->join('tickets', 'ticket_details.IdBanVe', '=', 'tickets.IdBanVe')
            ->where('tickets.IdChuyen', $IdChuyen)
            ->where('ticket_details.TinhTrangVe', '!=', 'Đã hủy')
            ->count();

        // Lấy điểm đón
        $DiemDon = DB::table('bus_routes')
            ->join('stops', 'bus_routes.DiaDiemDi', '=', 'stops.DiaDiemDi')
            ->where('bus_routes.IdTuyen', $trip->IdTuyen)
            ->select('stops.*')
            ->get()
            ->toArray();

        return view('trips.show', [
            'trip' => $trip,
            'availableSeats' => $trip->So_Cho_Ngoi - $reservedSeats,
            'DiemDon' => $DiemDon,

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
        // Kiểm tra xem người dùng có phải là nhà xe của chuyến xe này không hoặc là quản trị viên hệ thống
        if (Auth::user()->IdNX != NULL && Auth::user()->IdNX != Trip::join('buses', 'trips.IdXe', '=', 'buses.IdXe')->where('Trips.IdChuyen', $IdChuyen)->select('buses.IdNX')->first()->IdNX)
            return redirect()->route('trips.show', $IdChuyen)->with('error', 'Bạn không thể thực hiện thao tác này!');


        // Nếu ngày giờ đi của chuyến đã qua hiện tại thì không cho sửa 
        $trip = Trip::find($IdChuyen);
        if (strtotime($trip->NgayDi . ' ' . $trip->GioDi) < strtotime(date('Y-m-d H:i:s')))
            return redirect()->route('trips.show', $IdChuyen)->with('error', 'Chuyến xe này đã khởi hành/ đã hoàn thành. Bạn không thể sửa!');


        $cities = [
            'Hòa Bình', 'Sơn La', 'Điện Biên', 'Lai Châu', 'Lào Cai', 'Yên Bái', 'Phú Thọ', 'Hà Giang', 'Tuyên Quang', 'Cao Bằng', 'Bắc Kạn', 'Thái Nguyên', 'Lạng Sơn', 'Bắc Giang', 'Quảng Ninh', 'Hà Nội', 'Bắc Ninh', 'Hà Nam', 'Hải Dương', 'Hải Phòng', 'Hưng Yên', 'Nam Định', 'Thái Bình', 'Vĩnh Phúc', 'Ninh Bình', 'Thanh Hóa', 'Nghệ An', 'Hà Tĩnh', 'Quảng Bình', 'Quảng Trị', 'Huế', 'Đà Nẵng', 'Quảng Nam', 'Quảng Ngãi', 'Bình Định', 'Phú Yên', 'Khánh Hòa', 'Ninh Thuận', 'Bình Thuận', 'TP. Hồ Chí Minh', 'Vũng Tàu', 'Bình Dương', 'Bình Phước', 'Đồng Nai', 'Tây Ninh', 'An Giang', 'Bạc Liêu', 'Bến Tre', 'Cà Mau', 'Cần Thơ', 'Đồng Tháp', 'Hậu Giang', 'Kiên Giang', 'Long An', 'Sóc Trăng', 'Tiền Giang', 'Trà Vinh', 'Vĩnh Long', 'Kon Tum', 'Gia Lai', 'Đắk Lắk', 'Đắk Nông', 'Lâm Đồng',
        ];

        $cities = sort($cities);

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
        if (Auth::user()->IdNX != NULL && Auth::user()->IdNX != Trip::join('buses', 'trips.IdXe', '=', 'buses.IdXe')->where('Trips.IdChuyen', $IdChuyen)->select('buses.IdNX')->first()->IdNX)
            return redirect()->route('trips.show', $IdChuyen)->with('error', 'Bạn không thể thực hiện thao tác này!');

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
