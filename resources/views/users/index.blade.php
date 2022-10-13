@extends('layouts.app')
@section('content')
    <style>
        .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .like-div {
            position: relative;
            text-align: center;
            color: white;
        }

        .centered {
            position: absolute;
            top: 40%;
            left: 50%;
            font-weight: bold;
            font-size: 11px;
            transform: translate(-50%, -50%);
        }

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
                                    <th scope="col">{{__('Mobile')}}</th>
                                    <th scope="col">{{__('Primary Language')}}</th>
                                    <th scope="col">{{__('secondary Languages')}}</th>
                                    <th scope="col">{{__('Translator Services')}}</th>
                                    <th scope="col">{{__('Login By')}}</th>
                                    <th scope="col">{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
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
                        'targets': [4, 5, 6],
                        'className': 'text-center',
                        'orderable': false
                    },
                ],
                columns: [
                    {
                        data: function data(row) {
                            let image = "{{asset('public/assets/img/default_user.png')}}";
                            if (row.image_url) {
                                image = row.image_url;
                            }
                            let like = "{{asset('public/assets/img/heart.png')}}";
                            let star_1 = 0;
                            let star_2 = 0;
                            let star_3 = 0;
                            let star_4 = 0;
                            let star_5 = 0;
                            let i = 0;
                            let average_rating = 0;
                            for (i; i <= row.like_users.length; i++) {
                                if (row.like_users[i] != null && row.like_users[i].pivot.rating == 1) {
                                    star_1 += 1;
                                }
                                if (row.like_users[i] != null && row.like_users[i].pivot.rating == 2) {
                                    star_2 += 1;
                                }
                                if (row.like_users[i] != null && row.like_users[i].pivot.rating == 3) {
                                    star_3 += 1;
                                }
                                if (row.like_users[i] != null && row.like_users[i].pivot.rating == 4) {
                                    star_4 += 1;
                                }
                                if (row.like_users[i] != null && row.like_users[i].pivot.rating == 5) {
                                    star_5 += 1;
                                }

                                if (i > 0) {
                                    average_rating = (1 * star_1 + 2 * star_2 + 3 * star_3 + 4 * star_4 + 5 * star_5) / i;
                                }
                            }

                            function abbrNum(number, decPlaces) {
                                decPlaces = Math.pow(10, decPlaces);
                                var abbrev = ["k", "m", "b", "t"];
                                for (var i = abbrev.length - 1; i >= 0; i--) {
                                    var size = Math.pow(10, (i + 1) * 3);
                                    if (size <= number) {
                                        number = Math.round(number * decPlaces / size) / decPlaces;
                                        if ((number == 1000) && (i < abbrev.length - 1)) {
                                            number = 1;
                                            i++;
                                        }
                                        number += abbrev[i];
                                        break;
                                    }
                                }
                                return number;
                            }

                            let star = "";
                            if (average_rating <= 0) {
                                star = '<svg width="17px" height="17px" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.09608 0.484964C8.26115 0.150539 8.73804 0.150538 8.90311 0.484964L10.97 4.67224C11.0355 4.80492 11.162 4.89693 11.3084 4.91833L15.9312 5.59402C16.3002 5.64795 16.4472 6.10148 16.1801 6.36165L12.8358 9.619C12.7297 9.72238 12.6812 9.87139 12.7063 10.0174L13.4954 14.6187C13.5585 14.9863 13.1726 15.2666 12.8425 15.093L8.70905 12.9193C8.57792 12.8503 8.42126 12.8503 8.29014 12.9193L4.15673 15.093C3.82659 15.2666 3.4407 14.9863 3.50375 14.6187L4.29292 10.0174C4.31796 9.87139 4.26951 9.72238 4.16337 9.619L0.819066 6.36165C0.551949 6.10148 0.699001 5.64795 1.06796 5.59402L5.69076 4.91833C5.83717 4.89693 5.9637 4.80492 6.02919 4.67224L8.09608 0.484964Z" fill="#D1D1D1"/></svg>';
                            } else {
                                let per = average_rating * 100 / 5;
                                let percentage = Math.round(per) + "%";
                                star = '<svg width="17px" height="17px" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.09608 0.484964C8.26115 0.150539 8.73804 0.150538 8.90311 0.484964L10.97 4.67224C11.0355 4.80492 11.162 4.89693 11.3084 4.91833L15.9312 5.59402C16.3002 5.64795 16.4472 6.10148 16.1801 6.36165L12.8358 9.619C12.7297 9.72238 12.6812 9.87139 12.7063 10.0174L13.4954 14.6187C13.5585 14.9863 13.1726 15.2666 12.8425 15.093L8.70905 12.9193C8.57792 12.8503 8.42126 12.8503 8.29014 12.9193L4.15673 15.093C3.82659 15.2666 3.4407 14.9863 3.50375 14.6187L4.29292 10.0174C4.31796 9.87139 4.26951 9.72238 4.16337 9.619L0.819066 6.36165C0.551949 6.10148 0.699001 5.64795 1.06796 5.59402L5.69076 4.91833C5.83717 4.89693 5.9637 4.80492 6.02919 4.67224L8.09608 0.484964Z" fill="url(#grad1)"/> <defs><linearGradient id="grad1" x1="0%" y1="0%" x2="' + percentage + '" y2="0%"><stop offset="0%" style="stop-color:rgba(255,200,0,1);" /><stop offset="' + percentage + '" style="stop-color:rgba(255,200,0,1);" /><stop offset="100%" style="stop-color:rgba(209,209,209,1);" /></linearGradient></defs></svg>';
                            }
                            let verifyImg = "{{asset('public/assets/img/verified.png')}}";
                            let verify = '';
                            if (row.is_verified == '1') {
                                verify = `<img src="${verifyImg}">`;
                            }
                            return `<div class="d-flex justify-content-between"> <div class="d-flex align-items-center"><div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
<div class=""><img src="${image}" alt="" class="user-img"></div></div><div class="d-flex flex-column"><span>${row.name} ${row.last_name} ${verify} &nbsp;${star}
 ${average_rating.toFixed(2)}</span>
<span>${row.email}</span></div></div><div class="like-div mr-4"><img src="${like}" alt="" height="30px" width="30px"><div class="centered">${abbrNum(row.like_users.length, 2)}</div></div></div>`;
                        },
                        name: 'name'
                    },
                    {
                        data: function data(row) {
                            if (row.mobile_no == null) {
                                return 'Null';
                            }
                            return row.mobile_no;
                        },
                        name: 'mobile_no'
                    },
                    {
                        data: 'primary_language',
                        name: 'last_name'
                    },
                    {
                        data: function data(row) {
                            if (row.language == "") {
                                return 'Null';
                            }
                            return row.language;
                        },
                        name: 'email'
                    },
                    {
                        data: function data(row) {
                            let video = `<i class="fas fa-video fs-1"></i>`;
                            let audio = `<i class="fas fa-microphone fs-1 mr-2 ml-2"></i>`;
                            let chat = `<i class="fas fa-comments fs-1"></i>`;
                            if (row.video == '1') {
                                video = `<i class="fas fa-video text-danger fs-1"></i>`;
                            }
                            if (row.audio == '1') {
                                audio = `<i class="fas fa-microphone text-info fs-1 ml-2 mr-2"></i>`;
                            }
                            if (row.chat == '1') {
                                chat = `<i class="fas fa-comments text-warning fs-1"></i>`;
                            }
                            return video + audio + chat;
                        },
                        name: 'mobile_no'
                    },
                    {
                        data: function data(row) {
                            let login = "{{asset('public/assets/img/mobile.png')}}";
                            if (row.login_by == 2) {
                                login = "{{asset('public/assets/img/apple.png')}}";
                            } else if (row.login_by == 3) {
                                login = "{{asset('public/assets/img/facebook.png')}}";
                            } else if (row.login_by == 4) {
                                login = "{{asset('public/assets/img/google.png')}}";
                            }
                            return `<img src="${login}" alt="" height="20px" width="20px">`
                        },
                        name: 'login_by'
                    },
                    {
                        data: function data(row) {
                            var url = userUrl + '/' + row.id + '/edit';
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

