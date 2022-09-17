@extends('layouts.app')
@section('title')
    Add Product
@endsection
@section('header')
    <a href="{{ route('quiz') }}" class="btn btn-default"><i class="fa-solid fa-arrow-left mr-1"></i>{{__('Back')}}
    </a>
@endsection
@section('content')
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
                        {{ Form::model($quiz, ['route' => ['quiz.update',$quiz->id], 'files' => 'true']) }}
                        <div class="row">
                            <div class="form-group col-xl-7 col-md-7 col-sm-12">
                                {{ Form::label(__('language').':') }} <span class="mandatory">*</span>
                                {{ Form::select('language_id', $language ,null, ['class' => 'form-control','required','id'=>'language_id','placeholder'=>'Select Language']) }}
                            </div>
                            <div class="form-group col-xl-8 col-md-8 col-sm-12">
                                {{ Form::label(__('Question').':') }} <span class="mandatory">*</span>
                                {{ Form::text('question', null, ['class' => 'form-control','required']) }}
                            </div>

                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('A').':') }} <span class="mandatory">*</span>
                                {{ Form::text('A', null, ['class' => 'form-control', 'required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('B').':') }} <span class="mandatory">*</span>
                                {{ Form::text('B', null, ['class' => 'form-control','required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('C').':') }} <span class="mandatory">*</span>
                                {{ Form::text('C', null, ['class' => 'form-control', 'required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('D').':') }} <span class="mandatory">*</span>
                                {{ Form::text('D', null, ['class' => 'form-control','required']) }}
                            </div>
                            <div class="form-group col-xl-3 col-md-3 col-sm-12">
                                <div class="d-flex justify-content-around">
                                    {{ Form::label(__('answer').':') }} <span class="mandatory">*</span>
                                    <div class="custom-control custom-radio">
                                        <input name="answer" value="A" class="custom-control-input" id="a" type="radio" {{$quiz->answer=='A'?'checked':''}}>
                                        <label class="custom-control-label" for="a">A</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input name="answer" value="B" class="custom-control-input" id="b" type="radio" {{$quiz->answer=='B'?'checked':''}}>
                                        <label class="custom-control-label" for="b">B</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input name="answer" value="C" class="custom-control-input" id="c" type="radio" {{$quiz->answer=='C'?'checked':''}}>
                                        <label class="custom-control-label" for="c">C</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input name="answer" value="D" class="custom-control-input" id="d" type="radio" {{$quiz->answer=='D'?'checked':''}}>
                                        <label class="custom-control-label" for="d">D</label>
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
