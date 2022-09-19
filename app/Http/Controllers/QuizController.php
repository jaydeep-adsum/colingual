<?php

namespace App\Http\Controllers;

use App\Datatable\QuizDatatable;
use App\Models\Language;
use App\Models\Quiz;
use App\Repositories\QuizRepository;
use Datatables;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class QuizController extends AppBaseController
{
    /**
     * @var QuizRepository
     */
    private $quizRepository;

    /**
     * @param QuizRepository $quizRepository
     */
    public function __construct(QuizRepository $quizRepository){
        $this->quizRepository = $quizRepository;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if ($request->ajax()) {
            return Datatables::of((new QuizDatatable())->get())->make(true);
        }
        return view('quiz.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create(){
        $language = Language::pluck('language','id');

        return view('quiz.create',compact('language'));
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request){
        $this->quizRepository->create($request->all());

        return redirect(route('quiz'));
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $language = Language::pluck('language', 'id');
        $quiz = Quiz::find($id);

        return view('quiz.edit', compact('language', 'quiz'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $this->quizRepository->update($request->all(), $id);

        return redirect(route('quiz'));
    }

    /**
     * @param Quiz $quiz
     * @return JsonResponse
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return $this->sendSuccess('Quiz deleted successfully.');
    }
}
