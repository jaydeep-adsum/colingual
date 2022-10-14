<?php

namespace App\Http\Controllers;

use App\Datatable\CallHistoryDatatable;
use App\Models\CallHistory;
use App\Models\User;
use App\Repositories\CallHistoryRepository;
use Datatables;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CallHistoryController extends AppBaseController
{
    /**
     * @var CallHistoryRepository
     */
    private $callHistoryRepository;

    /**
     * @param CallHistoryRepository $callHistoryRepository
     */
    public function __construct(CallHistoryRepository $callHistoryRepository){
        $this->callHistoryRepository = $callHistoryRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        $callHistory = User::where('role','0')->get();
        foreach($callHistory as $call){
            $data[$call->id] = $call->name.' '.$call->last_name;
        }
        $call_history[1]='Video Call';
        $call_history[2]='Audio Call';
        $call_history[3]='Chat';
        if ($request->ajax()) {
            return Datatables::of((new CallHistoryDatatable())->get($request->all()))->make(true);
        }
        return view('call_history.index',compact('data','call_history'));
    }

    /**
     * @param CallHistory $callHistory
     * @return JsonResponse
     */
    public function destroy(CallHistory $callHistory)
    {
        $callHistory->delete();

        return $this->sendSuccess('Call History deleted successfully.');
    }
}
