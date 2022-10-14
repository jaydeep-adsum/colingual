@extends('layouts.app')
@section('title')
    Call History
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">
       <a href="{{route('quiz.create')}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add</a>
    </div>
@endsection
@section('content')
    <style>
        .fs-1 {
            font-size: 1rem;
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
                                <h3 class="mb-0">Call History</h3>
                            </div>
                            <div class="col-2">
                                {{ Form::select('user',$data ,null, ['class' => 'form-control','id'=>'user','placeholder'=>'Select User']) }}
                            </div>
                            <div class="col-2">
                                {{ Form::select('call_type',$call_history ,null, ['class' => 'form-control','id'=>'call_type','placeholder'=>'Select Call Type']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="call_history">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{__('User')}}</th>
                                    <th scope="col">{{__('Called User')}}</th>
                                    <th scope="col">{{__('Duration')}}</th>
                                    <th scope="col">{{__('Call type')}}</th>
                                    <th scope="col">{{__('Tip')}}</th>
                                    <th scope="col">{{__('Date')}}</th>
                                    <th scope="col">{{__('Action')}}</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $("#user,#call_type").select2({
            width: '100%',
        });
        let callHistoryUrl = "{{route('call_history')}}";
        $(document).ready(function () {
            var tableName = '#call_history';
            var tbl = $(tableName).DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                ajax: {
                    url: callHistoryUrl,
                    data: function (d) {
                        d.user = $('#user').val()
                        d.call_type = $('#call_type').val()
                    }
                },
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                },
                columns: [
                    {
                        data: function data(row) {
                            return row.user.name +' '+ row.user.last_name
                        },
                        name: 'id'
                    },
                    {
                        data: function data(row) {
                            return row.call_user.name +' '+ row.call_user.last_name
                        },
                        name: 'id'
                    },
                    {
                        data:'duration',
                        name:'duration',
                    },
                    {
                        data: function data(row) {
                            let icon = '';
                            if (row.call_type=='1') {
                                icon = `<i class="fas fa-video text-danger fs-1"></i>`;
                            }else if (row.call_type=='2') {
                                icon = `<i class="fas fa-microphone fs-1 text-info"></i>`;
                            }else if (row.call_type=='3') {
                                icon = `<i class="fas fa-comments fs-1 text-warning"></i>`;
                            }
                            return icon;
                        },
                        name: 'call_type'
                    },
                    {
                        data:'tip',
                        name:'tip',
                    },
                    {
                        data: function data(row) {
                            return moment(row.created_at, 'YYYY-MM-DD hh:mm:ss').format('Do MMM, YYYY HH:mm');
                        },
                        name:'created_at',
                    },
                    {
                        data: function data(row) {
                            let url = callHistoryUrl + '/' + row.id;
                            return `
<div class="d-flex justify-content-center">
<a title="Delete" class="btn btn-sm delete-btn" data-id="${row.id}" href="#">
           <i class="fas fa-trash"></i>
                </a></div>`
                        },
                        name: 'id',
                    }]
            });

            $("#user,#call_type").change(function () {
                $(tableName).DataTable().draw(true);
            });

            $(document).on('click', '.delete-btn', function (event) {
                var callId = $(event.currentTarget).attr('data-id');
                deleteItem(callHistoryUrl + '/' + callId, tableName, 'Call History');
            });
        });
    </script>
@endpush
