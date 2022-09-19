@extends('layouts.app')
@section('title')
    Quiz
@endsection
@section('header')
    <div class="d-flex px-4 px-sm-0 pt-2 pt-sm-0">
       <a href="{{route('quiz.create')}}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add</a>
    </div>
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
                                <h3 class="mb-0">Quiz</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('quiz.create')}}" class="btn btn-sm btn-primary addModal">Add Quiz</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="quiz">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{__('Language')}}</th>
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
        let quizUrl = "{{route('quiz')}}";
        $(document).ready(function () {
            var tableName = '#quiz';
            var tbl = $(tableName).DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                ajax: {
                    url: quizUrl,
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
                            return row.language.language
                        },
                        name: 'language_id'
                    },
                    {
                        data: function data(row) {
                            let url = quizUrl + '/' + row.id;
                            return `
<div class="d-flex justify-content-center"> <a title="Edit" class="btn btn-sm mr-1 edit-btn" href="${url}/edit">
            <i class="fas fa-edit"></i>
                </a> <a title="Delete" class="btn btn-sm delete-btn" data-id="${row.id}" href="#">
           <i class="fas fa-trash"></i>
                </a></div>`
                        },
                        name: 'id',
                    }]
            });

            $(document).on('click', '.delete-btn', function (event) {
                var quizId = $(event.currentTarget).attr('data-id');
                deleteItem(quizUrl + '/' + quizId, tableName, 'Quiz');
            });
        });
    </script>
@endpush
