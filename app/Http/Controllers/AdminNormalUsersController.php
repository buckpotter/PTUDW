<?php

namespace App\Http\Controllers;

use App\Models\NormalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Builder\FallbackBuilder;

class AdminNormalUsersController extends Controller
{

    // middleware
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show', 'search']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_text = $request['search'] ?? "";
        $normal_users = NULL;

        if ($search_text == "") {
            $normal_users = NormalUser::sortable()->paginate(15);
        } else {
            $normal_users = NormalUser::sortable()
                ->where('HoTen', 'like', "%$search_text%")
                ->orwhere('email', 'like', "%$search_text%")
                ->orWhere('sdt', 'like', "%$search_text%")
                ->orWhere('IdUser', 'like', "%$search_text%")
                ->paginate(15);
        }

        // Buộc phải có để truyền thêm tham số search vào url, nếu không khi chuyển trang sẽ mất tham số search
        $normal_users->appends([
            'search' => $search_text,
            'sort' => $request->sort ?? 'IdUser',
            'direction' => $request->direction ?? 'asc'
        ]);

        return view('normal_users.index', [
            'normal_users' => $normal_users,
            'search' => $search_text,
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
            return redirect()->route('normal_users.index')->with('error', 'Bạn không thể thực hiện thao tác này!');

        return view('normal_users.create');
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
            'HoTen' => 'required',
            'email' => 'required|email|unique:normal_users,email',
            'password' => 'required|min:6|max:20|confirmed',
            'sdt' => 'required|regex:/^0[0-9]{9}$/|unique:normal_users,sdt',
        ]);

        $count = DB::table('normal_users')->count() + 1;
        while (true) {
            $normalUser = DB::table('normal_users')
                ->where('IdUser', '=', 'NU' . $count)
                ->first();

            if ($normalUser == null)
                break;

            $count++;
        }

        // Insert bằng eloquent
        NormalUser::create([
            'IdUser' => 'NU' . $count,
            'HoTen' => $request->HoTen,
            'email' => $request->email,
            'password' => md5($request->password),
            'sdt' => $request->sdt,
        ]);

        return redirect()->route('normal_users.index')->with('message', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $IdUser
     * @return \Illuminate\Http\Response
     */
    public function show($IdUser)
    {
        $orders = DB::table('tickets')
            ->join('normal_users', 'tickets.IdUser', '=', 'normal_users.IdUser')
            ->join('trips', 'tickets.IdChuyen', '=', 'trips.IdChuyen')
            ->join('buses', 'trips.IdXe', '=', 'buses.IdXe')
            ->join('ticket_details', 'tickets.IdBanVe', '=', 'ticket_details.IdBanVe')
            ->join('bus_routes', 'trips.IdTuyen', '=', 'bus_routes.IdTuyen')
            ->where('tickets.IdUser', '=', $IdUser)
            ->paginate(10);

        return view('normal_users.show', [
            'normal_user' => NormalUser::findOrFail($IdUser),
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $IdUser
     * @return \Illuminate\Http\Response
     */
    public function edit($IdUser)
    {
        if (Auth::user()->IdNX != NULL)
            return redirect()->route('normal_users.show', $IdUser)->with('error', 'Bạn không thể thực hiện thao tác này!');

        return view('normal_users.edit', [
            'normal_user' => NormalUser::findOrFail($IdUser),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $IdUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $IdUser)
    {
        $request->validate([
            'HoTen' => 'required',
            'sdt' => 'required|regex:/^0[0-9]{9}$/|unique:normal_users,sdt,' . $IdUser . ',IdUser',
        ]);

        NormalUser::where('IdUser', $IdUser)
            ->update([
                'HoTen' => $request->HoTen,
                'sdt' => $request->sdt,
            ]);

        return redirect()->route('normal_users.show', $IdUser)
            ->with('message', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $IdUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($IdUser)
    {
        if (Auth::user()->IdNX != NULL)
            return redirect()->route('normal_users.show', $IdUser)->with('error', 'Bạn không thể thực hiện thao tác này!');

        // Xóa các vé của user
        $tickets = DB::table('tickets')
            ->where('IdUser', '=', $IdUser)
            ->get();

        foreach ($tickets as $ticket) {
            DB::table('ticket_details')
                ->where('IdBanVe', '=', $ticket->IdBanVe)
                ->delete();
        }

        // Xóa các hoá đơn của user
        DB::table('tickets')
            ->where('IdUser', '=', $IdUser)
            ->delete();

        // Xóa user
        NormalUser::findOrFail($IdUser)->delete();
        return redirect()->route('normal_users.index')
            ->with('message', 'Xóa thành công!');
    }

    public function search(Request $request)
    {
        $search_text = $request['search'] ?? "";
        $normal_users = NULL;

        if ($search_text == "")
            $normal_users = NormalUser::paginate(15);
        else {
            $normal_users = NormalUser::where('HoTen', 'like', "%$search_text%")
                ->orwhere('email', 'like', "%$search_text%")
                ->orWhere('sdt', 'like', "%$search_text%")
                ->paginate(15);
        }

        return view('normal_users.search', [
            'normal_users' => $normal_users,
            'search' => $search_text,
        ]);
    }
}
