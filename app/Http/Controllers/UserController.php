<?php

namespace App\Http\Controllers;

use App\Datatable\UserDatatable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class UserController extends AppBaseController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new UserDatatable())->get())->make(true);
        }
        return view('users.index');
    }
}
