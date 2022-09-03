@extends('layouts.app')
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
                                <h3 class="mb-0">Users</h3>
                            </div>
{{--                            <div class="col-4 text-right">--}}
{{--                                <a href="" class="btn btn-sm btn-primary">Add user</a>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="table-responsive py-4">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Last')}}</th>
                                <th scope="col">{{__('Mobile')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Login By')}}</th>
                                <th scope="col">{{__('Action')}}</th>
                            </tr>
                            </thead>
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>Admin Admin</td>--}}
{{--                                <td>--}}
{{--                                    <a href="mailto:admin@argon.com">admin@argon.com</a>--}}
{{--                                </td>--}}
{{--                                <td>12/02/2020 11:00</td>--}}
{{--                                <td class="text-right">--}}
{{--                                    <div class="dropdown">--}}
{{--                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"--}}
{{--                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                                            <i class="fas fa-ellipsis-v"></i>--}}
{{--                                        </a>--}}
{{--                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">--}}
{{--                                            <a class="dropdown-item" href="">Edit</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
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
    let userUrl = "{{route('user')}}";
    $(document).ready(function () {
        var tableName = '#datatable-basic';
        var tbl = $(tableName).DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: {
                url: userUrl,
            },
            "language": {
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            },
            columnDefs: [
            //     {
            //         'targets': [4],
            //         'className': 'text-center',
            //         'width': '11%'
            //     },
                {
                    'targets': [4],
                    'className': 'text-center',
                    'orderable': false
                }
            ],
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'mobile_no',
                    name: 'mobile_no'
                },
                {
                    data: 'email',
                    name: 'email '
                },
                {
                    data: function data(row) {
                        if (row.login_by==2){
                            return `<i class="fas fa-apple-alt"></i>`
                        } else if (row.login_by==3){
                            return `<i class="fa fa-facebook-square"></i>`
                        } else if (row.login_by==4){
                            return `<i class="fa fa-google"></i>`
                        } else {
                            return `<i class="fas fa-mobile-alt"></i>`
                        }
                    },
                    name: 'login_by'
                },
                {
                    data: function data(row) {
                        var url = userUrl + '/' + row.id+'/edit';
                        return `
<div class="d-flex justify-content-center"> <a title="Edit" class="btn btn-sm mr-1 edit-btn" href="${url}">
            <i class="fas fa-edit"></i>
                </a> <a title="Delete" class="btn btn-sm delete-btn" data-id="${row.id}" href="#">
           <i class="fas fa-trash"></i>
                </a></div>`
                    },
                    name: 'id',
                }]
        });

        $(document).on('click', '.delete-btn', function (event) {
            var userId = $(event.currentTarget).attr('data-id');
            deleteItem(userUrl + '/' + userId, tableName, 'User');
        });

    });


    </script>
@endpush

