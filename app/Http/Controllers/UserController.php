<?php

namespace App\Http\Controllers;

use App\Datatable\UserDatatable;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;


class UserController extends AppBaseController
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        dd(User::all());
        if ($request->ajax()) {
            return Datatables::of((new UserDatatable())->get())->make(true);
        }
        return view('users.index');
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        return view('users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $this->userRepository->update($request->all(), $id);

        Flash::success('User updated successfully.');

        return redirect(route('user'));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->sendSuccess('User deleted successfully.');
    }
}
