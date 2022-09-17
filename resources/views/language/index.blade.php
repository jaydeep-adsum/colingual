@extends('layouts.app')
@section('title')
    Category
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
                                <h3 class="mb-0">Languages</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" class="btn btn-sm btn-primary addModal">Add Language</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="language">
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
        @include('language.create')
        @include('language.edit')
    </div>
@endsection
@push('js')
    <script>
        let languageUrl = "{{route('language.index')}}";
        let languageSaveUrl = "{{ route('language.store') }}";
        $(document).ready(function () {
            var tableName = '#language';
            var tbl = $(tableName).DataTable({
                processing: true,
                serverSide: true,
                searchDelay: 500,
                ajax: {
                    url: languageUrl,
                },
                "language": {
                    "paginate": {
                        "previous": "<i class='fas fa-chevron-left'></i>",
                        "next": "<i class='fas fa-chevron-right'></i>"
                    }
                },
                columns: [
                    {
                        data: 'language',
                        name: 'language'
                    },
                    {
                        data: function data(row) {
                            return `
<div class="d-flex justify-content-center"> <a title="Edit" class="btn btn-sm mr-1 edit-btn" data-id="${row.id}" href="#">
            <i class="fas fa-edit"></i>
                </a> <a title="Delete" class="btn btn-sm delete-btn" data-id="${row.id}" href="#">
           <i class="fas fa-trash"></i>
                </a></div>`
                        },
                        name: 'id',
                    }]
            });

            $(document).on('click', '.delete-btn', function (event) {
                var languageId = $(event.currentTarget).attr('data-id');
                deleteItem(languageUrl + '/' + languageId, tableName, 'Language');
            });

            $(document).on('click', '.addModal', function () {
                $('#addModal').appendTo('body').modal('show');
            });
            $(document).on('submit', '#addForm', function (e) {
                e.preventDefault();
                $.ajax({
                    url: languageSaveUrl,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (result) {
                        if (result.status) {
                            displaySuccessMessage(result.message);
                            $('#addModal').modal('hide');
                            $(tableName).DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function (result) {
                        displayErrorMessage(result.responseJSON.message);
                    },
                });
            });
            $(document).on('click', '.edit-btn', function (event) {
                let languageId = $(event.currentTarget).attr('data-id');
                renderData(languageId);
            });
            window.renderData = function (id) {
                $.ajax({
                    url: languageUrl + '/' + id + '/edit',
                    type: 'GET',
                    success: function (result) {
                        if (result.status) {
                            $('#editLanguage').val(result.data.language);
                            $('#languageId').val(result.data.id);
                            $('#editModal').appendTo('body').modal('show');
                        }
                    },
                    error: function (result) {
                        displayErrorMessage(result.responseJSON.message);
                    },
                });
            };

            $(document).on('submit', '#editForm', function (e) {
                e.preventDefault();
                if ($('#editLanguage').val()=="") {
                    displayErrorMessage('Language field is required.');
                    return false;
                }
                var id = $('#languageId').val();
                $.ajax({
                    url: languageUrl +'/'+id,
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function (result) {
                        if (result.status) {
                            displaySuccessMessage(result.message);
                            $('#editModal').modal('hide');
                            $(tableName).DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function (result) {
                        displayErrorMessage(result.responseJSON.message);
                    },
                });
            });
            $('#addModal').on('hidden.bs.modal', function () {
                $('#addForm')[0].reset();
            });
        });


    </script>
@endpush
