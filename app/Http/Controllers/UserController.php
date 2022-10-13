<?php

namespace App\Http\Controllers;

use App\Datatable\UserDatatable;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DB;
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
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\EloquentDataTable;


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
     * @return Application|Factory|View|DataTableAbstract|EloquentDataTable
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new UserDatatable())->get())->addColumn('is_verified', function(User $user) {
                $languages = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->id.'");

                $j = 0;
                foreach ($languages as $language) {
                    if ($language->translator == '1') {
                        $j++;
                    }
                }
                $is_verified = "";
                if ($j == count($languages)) {
                    $is_verified = "1";
                }
                return $is_verified;
            })
                ->addColumn('primary_language', function(User $user) {
                    $languages = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->id.'");
                    $primary_language = "";
                    foreach ($languages as $language) {
                        if ($language->is_primary == '1') {
                            $primary_language = $language->language;
                        }
                    }
                    return $primary_language;
                })
                ->addColumn('language', function(User $user) {
                    $languages = DB::select("SELECT * FROM `language_user` JOIN languages on language_user.language_id=languages.id where user_id='.$user->id.'");
                    $languageArr = [];
                    foreach ($languages as $language) {
                        if ($language->is_primary == '0') {
                            $languageArr[] = $language->language;
                        }
                    }

                    return implode(',',$languageArr);
                })
                ->toJson();
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
