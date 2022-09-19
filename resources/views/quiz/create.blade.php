@extends('layouts.app')
@section('title')
    Add Quiz
@endsection
@section('header')
    <a href="{{ route('quiz') }}" class="btn btn-default"><i class="fa-solid fa-arrow-left mr-1"></i>{{__('Back')}}</a>
@endsection
@section('content')
    <style>
        .question-acc-btn {
            width: 100%;
            text-align: left;
            padding: 1.25rem 1.5rem;
            color: #7b859e !important;
        }

        .question-acc-btn:hover {
            color: #5e72e4 !important;
        }

        .langSelect .select2-selection.select2-selection--single {
            height: auto;
        }

        .langSelect .select2-selection__rendered {
            padding: 10px;
        }

        .langSelect .select2-selection__arrow {
            top: 50% !important;
            right: 5px !important;
            transform: translateY(-50%);
        }
    </style>
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Add Quiz</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @if ($errors->any())
                            <div class="alert alert-danger pb-0 pt-0">
                                <ul class="j-error-padding list-unstyled p-2 mb-0">
                                    <li>{{ $errors->first() }}</li>
                                </ul>
                            </div>
                        @endif
                        {{ Form::open(['route' => 'quiz.store', 'files' => 'true']) }}
                        <div class="form-group col-xl-7 col-md-7 col-sm-12 langSelect">
                            {{ Form::label(__('language').':') }} <span class="mandatory">*</span>
                            {{ Form::select('language_id', $language ,null, ['class' => 'form-control','required','id'=>'language_id','placeholder'=>'Select Language']) }}
                        </div>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header p-0" id="headingOne">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link question-acc-btn" data-toggle="collapse"
                                           data-target="#queOne" aria-expanded="true" aria-controls="queOne">
                                            <span>Question 1</span><span class="float-right"><i class="fas fa-plus"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="queOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="form-group col-xl-12 col-md-12 col-sm-12">
                                            {{ Form::label(__('Question').':') }} <span class="mandatory">*</span>
                                            {{ Form::text('question1', null, ['class' => 'form-control','required']) }}
                                        </div>
                                        <div class="d-flex">
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_A').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option1A', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_B').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option1B', null, ['class' => 'form-control','required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_C').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option1C', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_D').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option1D', null, ['class' => 'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                                                <div class="d-flex justify-content-around">
                                                    {{ Form::label(__('answer').':') }} <span class="mandatory">*</span>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer1" value="A" class="custom-control-input"
                                                               id="answer1a"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer1a">A</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer1" value="B" class="custom-control-input"
                                                               id="answer1b"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer1b">B</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer1" value="C" class="custom-control-input"
                                                               id="answer1c"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer1c">C</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer1" value="D" class="custom-control-input"
                                                               id="answer1d"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer1d">D</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a class="btn btn-primary text-white" data-toggle="collapse"
                                                   data-target="#queTwo" aria-expanded="true" aria-controls="queTwo">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header p-0" id="headingTwo">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link question-acc-btn collapsed" data-toggle="collapse"
                                           data-target="#queTwo" aria-expanded="false" aria-controls="queTwo">
                                            <span>Question 2</span><span class="float-right"><i class="fas fa-plus"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="queTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="form-group col-xl-12 col-md-12 col-sm-12">
                                            {{ Form::label(__('Question').':') }} <span class="mandatory">*</span>
                                            {{ Form::text('question2', null, ['class' => 'form-control','required']) }}
                                        </div>
                                        <div class="d-flex">
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_A').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option2A', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_B').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option2B', null, ['class' => 'form-control','required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_C').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option2C', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_D').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option2D', null, ['class' => 'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                                                <div class="d-flex justify-content-around">
                                                    {{ Form::label(__('answer').':') }} <span class="mandatory">*</span>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer2" value="A" class="custom-control-input"
                                                               id="answer2a"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer2a">A</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer2" value="B" class="custom-control-input"
                                                               id="answer2b"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer2b">B</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer2" value="C" class="custom-control-input"
                                                               id="answer2c"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer2c">C</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer2" value="D" class="custom-control-input"
                                                               id="answer2d"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer2d">D</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a class="btn btn-primary text-white" data-toggle="collapse"
                                                   data-target="#queThree" aria-expanded="true"
                                                   aria-controls="queThree">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header p-0" id="headingThree">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link question-acc-btn collapsed" data-toggle="collapse"
                                           data-target="#queThree" aria-expanded="false" aria-controls="queThree">
                                            <span>Question 3</span><span class="float-right"><i class="fas fa-plus"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="queThree" class="collapse" aria-labelledby="headingThree"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="form-group col-xl-12 col-md-12 col-sm-12">
                                            {{ Form::label(__('Question').':') }} <span class="mandatory">*</span>
                                            {{ Form::text('question3', null, ['class' => 'form-control','required']) }}
                                        </div>
                                        <div class="d-flex">
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_A').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option3A', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_B').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option3B', null, ['class' => 'form-control','required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_C').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option3C', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_D').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option3D', null, ['class' => 'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                                                <div class="d-flex justify-content-around">
                                                    {{ Form::label(__('answer').':') }} <span class="mandatory">*</span>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer3" value="A" class="custom-control-input"
                                                               id="answer3a"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer3a">A</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer3" value="B" class="custom-control-input"
                                                               id="answer3b"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer3b">B</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer3" value="C" class="custom-control-input"
                                                               id="answer3c"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer3c">C</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer3" value="D" class="custom-control-input"
                                                               id="answer3d"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer3d">D</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a class="btn btn-primary text-white" data-toggle="collapse"
                                                   data-target="#queFour" aria-expanded="true" aria-controls="queFour">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header p-0" id="headingFour">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link question-acc-btn collapsed" data-toggle="collapse"
                                           data-target="#queFour" aria-expanded="false" aria-controls="queFour">
                                            <span>Question 4</span><span class="float-right"><i class="fas fa-plus"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="queFour" class="collapse" aria-labelledby="headingFour"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="form-group col-xl-12 col-md-12 col-sm-12">
                                            {{ Form::label(__('Question').':') }} <span class="mandatory">*</span>
                                            {{ Form::text('question4', null, ['class' => 'form-control','required']) }}
                                        </div>
                                        <div class="d-flex">
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_A').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option4A', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_B').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option4B', null, ['class' => 'form-control','required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_C').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option4C', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_D').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option4D', null, ['class' => 'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                                                <div class="d-flex justify-content-around">
                                                    {{ Form::label(__('answer').':') }} <span class="mandatory">*</span>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer4" value="A" class="custom-control-input"
                                                               id="answer4a"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer4a">A</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer4" value="B" class="custom-control-input"
                                                               id="answer4b"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer4b">B</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer4" value="C" class="custom-control-input"
                                                               id="answer4c"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer4c">C</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input name="answer4" value="D" class="custom-control-input"
                                                               id="answer4d"
                                                               type="radio">
                                                        <label class="custom-control-label" for="answer4d">D</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a class="btn btn-primary text-white" data-toggle="collapse"
                                                   data-target="#queFive" aria-expanded="true" aria-controls="queFive">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header p-0" id="headingFive">
                                    <h5 class="mb-0">
                                        <a class="btn btn-link question-acc-btn collapsed" data-toggle="collapse"
                                           data-target="#queFive" aria-expanded="false" aria-controls="queFive">
                                            <span>Question 5</span><span class="float-right"><i class="fas fa-plus"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="queFive" class="collapse" aria-labelledby="headingFive"
                                     data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="form-group col-xl-12 col-md-12 col-sm-12">
                                            {{ Form::label(__('Question').':') }} <span class="mandatory">*</span>
                                            {{ Form::text('question5', null, ['class' => 'form-control','required']) }}
                                        </div>
                                        <div class="d-flex">
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_A').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option5A', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_B').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option5B', null, ['class' => 'form-control','required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_C').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option5C', null, ['class' => 'form-control', 'required']) }}
                                            </div>
                                            <div class="form-group col-xl-3 col-md-6 col-sm-12">
                                                {{ Form::label(__('option_D').':') }} <span class="mandatory">*</span>
                                                {{ Form::text('option5D', null, ['class' => 'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="form-group col-xl-3 col-md-3 col-sm-12">
                                            <div class="d-flex justify-content-around">
                                                {{ Form::label(__('answer').':') }} <span class="mandatory">*</span>
                                                <div class="custom-control custom-radio">
                                                    <input name="answer5" value="A" class="custom-control-input" id="answer5a"
                                                           type="radio">
                                                    <label class="custom-control-label" for="answer5a">A</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input name="answer5" value="B" class="custom-control-input" id="answer5b"
                                                           type="radio">
                                                    <label class="custom-control-label" for="answer5b">B</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input name="answer5" value="C" class="custom-control-input" id="answer5c"
                                                           type="radio">
                                                    <label class="custom-control-label" for="answer5c">C</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input name="answer5" value="D" class="custom-control-input" id="answer5d"
                                                           type="radio">
                                                    <label class="custom-control-label" for="answer5d">D</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 pt-4">
                            {{ Form::submit(__('Save'), ['class' => 'btn btn-primary save-btn']) }}
                            <a href="{{ route('quiz') }}"
                               class="btn btn-default">{{__('Cancel')}}</a>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script>
        $("#language_id ").select2({
            width: '100%',
        });
    </script>
@endpush
