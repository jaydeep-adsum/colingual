@extends('layouts.app')
@section('title')
    Edit User
@endsection
{{--@section('header')--}}
{{--    <a href="{{ route('user') }}" class="btn btn-default"><i class="fa-solid fa-arrow-left mr-1"></i>{{__('Back')}}--}}
{{--    </a>--}}
{{--@endsection--}}
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
                                <h3 class="mb-0">{{__('Edit User')}}</h3>
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
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        {{ Form::model($user, ['route' => ['user.update',$user->id], 'files' => 'true']) }}
                        <div class="row">
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('name').':') }} <span class="mandatory">*</span>
                                {{ Form::text('name', null, ['class' => 'form-control','required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('last_name').':') }} <span class="mandatory">*</span>
                                {{ Form::text('last_name', null, ['class' => 'form-control', 'required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('mobile_no').':') }} <span class="mandatory">*</span>
                                {{ Form::text('mobile_no', null, ['class' => 'form-control', 'required']) }}
                            </div>
                            <div class="form-group col-xl-6 col-md-6 col-sm-12">
                                {{ Form::label(__('email ').':') }} <span class="mandatory">*</span>
                                {{ Form::email('email', null, ['class' => 'form-control','required']) }}
                            </div>
                            <div class="form-group col-sm-12 pt-4">
                                {{ Form::submit(__('Save'), ['class' => 'btn btn-primary save-btn']) }}
                                <a href="{{ route('user') }}"
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
