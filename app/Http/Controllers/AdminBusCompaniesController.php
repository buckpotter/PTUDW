<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Rate;
use App\Models\Trip;
use App\Models\User;
use App\Models\Ticket;
use App\Models\BusCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminBusCompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth'])->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show', 'search']);
    }

    public function index(Request $request)
    {
        $search_text = $request['search'] ?? "";
        $busCompanies = NULL;

        if ($search_text == "") {
            $busCompanies = BusCompany::sortable()->paginate(15);
        } else {
            $busCompanies = BusCompany::sortable()
                ->where('Ten_NX', 'like', "%$search_text%")
                ->orwhere('email', 'like', "%$search_text%")
                ->orWhere('sdt', 'like', "%$search_text%")
                ->paginate(15);
        }

        // Buộc phải có để truyền thêm tham số search vào url, nếu không khi chuyển trang sẽ mất tham số search
        $busCompanies->appends([
            'search' => $search_text,
            'sort' => $request['sort'] ?? 'IdNX',
            'direction' => $request['direction'] ?? 'asc'
        ]);

        return view('bus_companies.index', [
            'search' => $search_text,
            'busCompanies' => $busCompanies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->IdNX != NULL)
            return redirect()->route('bus_companies.index')->with('error', 'Bạn không thể thực hiện thao tác này!');

        return view('bus_companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Ten_NX' => 'required',
            'sdt' => 'required|regex:/^0[0-9]{9}$/|unique:bus_companies,sdt',
            'email' => 'required|email',
            'DichVu' => 'required',
        ]);

        $count = BusCompany::where('Ten_NX', $request->Ten_NX)->count() + 1;
        while (true) {
            $busCompany = BusCompany::where('IdNX', '=', 'BC' . $count)->first();

            if ($busCompany == null)
                break;

            $count++;
        }


        BusCompany::create([
            'IdNX' => 'BC' . $count,
            'Ten_NX' => $request->Ten_NX,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'DichVu' => $request->DichVu,
        ]);

        return redirect()->route('bus_companies.index')->with('message', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($IdNX)
    {
        // Đánh giá nhà xe
        $rate = Rate::where('IdNX', $IdNX)->select(DB::raw('AVG(DanhGia) as avg'))->first()->avg;

        return view('bus_companies.show', [
            'busCompany' => BusCompany::where('IdNX', $IdNX)->firstOrFail(),
            'rate' => $rate,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($IdNX)
    {
        // chỉ được sửa thông tin của nhà xe mà mình quản lý
        if (Auth::user()->IdNX != NULL && Auth::user()->IdNX != $IdNX)
            return redirect()->route('bus_companies.show', $IdNX)->with('error', 'Bạn không thể thực hiện thao tác này!');

        return view('bus_companies.edit', [
            'busCompany' => BusCompany::findOrFail($IdNX),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdNX)
    {
        $request->validate([
            'Ten_NX' => 'required',
            'sdt' => 'required|regex:/^0[0-9]{9}$/|unique:bus_companies,sdt,' . $IdNX . ',IdNX',
            'email' => 'required|email',
            'DichVu' => 'required',
        ]);


        BusCompany::where('IdNX', $IdNX)->update([
            'Ten_NX' => $request->Ten_NX,
            'sdt' => $request->sdt,
            'email' => $request->email,
            'DichVu' => $request->DichVu,
        ]);


        return redirect()->route('bus_companies.show', $IdNX)->with('message', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdNX)
    {
        if (Auth::user()->IdNX != NULL && Auth::user()->IdNX != $IdNX)
            return redirect()->route('bus_companies.show', $IdNX)->with('error', 'Bạn không thể thực hiện thao tác này!');

        // Xóa rate của nhà xe
        Rate::where('IdNX', $IdNX)->delete();

        // Xoá tất cả tài khoản admin của nhà xe
        User::where('IdNX', $IdNX)->delete();

        // Xoá tất cả chuyến xe của nhà xe
        $buses = Bus::where('IdNX', $IdNX)->get()->toArray(); // Mảng chứa tất cả xe của nhà xe

        $trips = array(); // Mảng chứa tất cả chuyến xe của nhà xe
        foreach ($buses as $bus) {
            $trips = array_merge($trips, Trip::where('IdXe', $bus['IdXe'])->get()->toArray());
        }

        $tickets = array(); // Mảng chứa tất cả vé của nhà xe
        foreach ($trips as $trip) {
            $tickets = array_merge($tickets, Ticket::where('IdChuyen', $trip['IdChuyen'])->get()->toArray());
        }

        // Xoá tất cả vé của nhà xe
        foreach ($tickets as $ticket)
            DB::table('ticket_details')->where('IdBanVe', $ticket['IdBanVe'])->delete();

        foreach ($trips as $trip)
            DB::table('tickets')->where('IdChuyen', $trip['IdChuyen'])->delete();

        foreach ($buses as $bus)
            DB::table('trips')->where('IdXe', $bus['IdXe'])->delete();

        // Xoá tất cả xe của nhà xe
        DB::table('buses')->where('IdNX', $IdNX)->delete();

        // Xóa nhà xe
        BusCompany::where('IdNX', $IdNX)->delete();
        return redirect()->route('bus_companies.index')->with('message', 'Xóa thành công!');
    }

    public function search(Request $request)
    {
        $busCompanies = BusCompany::where('Ten_NX', 'like', '%' . $request->search . '%')
            ->orwhere('email', 'like', '%' . $request->search . '%')
            ->paginate(10);

        return view('bus_companies.index', [
            'busCompanies' => $busCompanies,
        ]);
    }
}
