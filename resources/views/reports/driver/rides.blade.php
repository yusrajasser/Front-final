@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | جدول الرحلات</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-right" id="alert">
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">الرقم التسلسلي</th>
                    <th scope="col">رقم السيارة التسلسلي</th>
                    <th scope="col">من</th>
                    <th scope="col">إلى</th>
                    <th scope="col">الزمن</th>
                    <th scope="col">عدد المقاعد</th>
                    <th scope="col">تاريخ الرحلة</th>
                    <th scope="col">زمن الفترة</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">تاريخ أخر تعديل</th>
                    <th scope="col">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <th scope="row">{{ $value['id'] }}</th>
                        <td>{{ $value['car_id'] }}</td>
                        <td>{{ $value['from'] }}</td>
                        <td>{{ $value['to'] }}</td>
                        <td>{{ date('h:i A', strtotime($value['time'])) }}</td>
                        <td>{{ $value['actual_reservation_nums'] }} / {{ $value['car']['seats_num'] }}</td>
                        <td>
                            @if ($value['occurance'] == 'once')
                                مرة واحدة
                            @endif
                            @if ($value['occurance'] == 'custome')
                                معدل
                            @endif
                        </td>
                        <td>
                            @if ($value['occurance'] == 'once')
                                {{ $value['once_date'] }}
                            @endif
                            @if ($value['occurance'] == 'custome')
                                {{ $value['multi_date'] }}
                            @endif
                        </td>
                        <td>
                            @if ($value['status'] == 'waiting')
                                <span data-feather="clock" class="text-warning"></span> <small
                                    class="d-hidden">waiting</small>
                            @endif
                            @if ($value['status'] == 'done')
                                <span data-feather="check" class="text-success"></span> <small
                                    class="d-hidden">done</small>
                            @endif
                            @if ($value['status'] == 'canceled')
                                <span data-feather="x" class="text-danger"></span> <small
                                    class="d-hidden">canceled</small>
                            @endif
                        </td>
                        <td>{{ $value['created_at'] ?? 'لا يوجد' }}</td>
                        <td>{{ $value['updated_at'] ?? 'لا يوجد' }}</td>
                        <td class="d-flex justify-content-around align-items-center">
                            <a href="{{ route('ride.edit', $value['id']) }}" class="btn btn-primary">تعديل</a>
                            <form method="POST" onsubmit="return confirm('هل أنت متأكد ؟');"
                                action="{{ route('ride.destroy', $value['id']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">الرقم التسلسلي</th>
                    <th scope="col">رقم السيارة التسلسلي</th>
                    <th scope="col">من</th>
                    <th scope="col">إلى</th>
                    <th scope="col">الزمن</th>
                    <th scope="col">عدد المقاعد</th>
                    <th scope="col">تاريخ الرحلة</th>
                    <th scope="col">زمن الفترة</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">تاريخ أخر تعديل</th>
                    <th scope="col">العمليات</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            // $('table').DataTable();

            // Setup - add a text input to each footer cell
            $('table tfoot th').each(function() {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table = $('table').DataTable({
                initComplete: function() {
                    // Apply the search
                    this.api().columns().every(function() {
                        var that = this;

                        $('input', this.footer()).on('keyup change clear', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });
                }
            });
        });
    </script>
@endsection
