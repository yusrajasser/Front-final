@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | الإشعارات</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')

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
                    @if ($value['is_readed'])
                        <tr class="">
                        @else
                        <tr class="bg-light">
                    @endif
                    <td>
                        <strong>{{ $value['id'] }}</strong>
                    </td>
                    <td>
                        <div class="d-flex flex-column justify-content-start align-items-start">
                            <a href="{{ route('notification_show', $value['id']) }}" class="h5">
                                @if ($value['alert_type'] == 'warn')
                                    <div class="badge alert-warning">
                                        تحذير
                                    </div>
                                @endif

                                @if ($value['alert_type'] == 'update')
                                    <div class="badge alert-info">
                                        تحديث
                                    </div>
                                @endif

                                @if ($value['alert_type'] == 'delete')
                                    <div class="badge alert-danger">
                                        حذف
                                    </div>
                                @endif
                                {{ $value['af_model'] }}
                            </a>
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
