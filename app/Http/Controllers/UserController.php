<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends AppBaseController
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        if ($request->ajax()) {
            return Datatables::of((new OrderDatatable())->get($request->all()))->make(true);
        }
        return view('users.index');
    }
}
