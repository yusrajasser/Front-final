@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | الرسائل</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- <a href="{{ route('make.message') }}" type="button" class="btn btn-primary p-4 mb-4">
        <span data-feather="plus"></span> إضافة رسالة
    </a> --}}

    <div class="" dir="rtl">
        <table class="table">
            <thead class="d-none">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">content</th>
                    <th scope="col">First</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <td>
                            <strong>{{ $value['id'] }}</strong>
                        </td>
                        <td>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <div class="h5">{{ $value['ride']['from'] }} --> {{ $value['ride']['to'] }}
                                </div>
                                <div class="truncate">{{ $value['message'] }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <div class=""></div>
                                <div class="" dir="ltr"><small
                                        class="text-muted">{{ $value['created_at'] }}</small>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                {{-- <tr>
                    <td>
                        <div class="d-flex flex-column justify-content-start align-items-start">
                            <div class="h5">Ahmed</div>
                            <div class="truncate">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                Laboriosam molestiae doloremque, adipisci debitis nam laborum.</div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                            <div class=""></div>
                            <div class=""><small class="text-muted">2012-10-12</small></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="d-flex flex-column justify-content-start align-items-start">
                            <div class="h5">User Name</div>
                            <div class="truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsum
                                laboriosam assumenda neque incidunt ullam quos eveniet nemo placeat expedita corrupti.</div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                            <div class=""></div>
                            <div class=""><small class="text-muted">2012-10-12</small></div>
                        </div>
                    </td>
                </tr> --}}
            </tbody>

        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('table').DataTable({
                "language": {
                    "search": "بحث :",
                    "paginate": {
                        "previous": "السابق",
                        "next": "التالي",
                    },
                    "zeroRecords": "لا نتائج"
                }
            });

        });
    </script>
    <script>
        document.querySelectorAll('.truncate').forEach((elem) => {
            elem.innerText = elem.innerText.slice(0, 60) + ' ...';
        });
    </script>
@endsection
