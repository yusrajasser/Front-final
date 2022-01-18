@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | تقارير الحجوزات</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    @if (count($data) > 0)
        <div class="table-responsive">
            <table class="table table-main">
                <thead>
                    <tr>
                        <th scope="col">الرقم التسلسلي</th>
                        <th scope="col">الرقم الراكب التسلسلي</th>
                        <th scope="col">إسم الراكب</th>
                        <th scope="col">الوجهة</th>
                        <th scope="col">نوع الحجز</th>
                        <th scope="col">تاريخ الحجز</th>
                        <th scope="col">عدد المقاعد</th>
                        <th scope="col">السعر</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">تاريخ الإنشاء</th>
                        <th scope="col">تاريخ أخر تحديث</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['reserves_status'] as $key => $value)
                        <tr>
                            <th scope="row">{{ $value['id'] }}</th>
                            <th scope="row">{{ $value['passenger']['id'] ?? 'لا يوجد' }}</th>
                            <th scope="row">{{ $value['passenger']['name'] ?? 'لا يوجد' }}</th>
                            <td>{{ $value['ride']['from'] }} -->
                                {{ $value['ride']['to'] }}
                            </td>
                            <td>{{ $value['reserve']['occurance'] == 'once' ? 'مرة واحدة' : 'معدل' }}
                            </td>
                            <td>
                                @if ($value['ride']['occurance'] == 'once')
                                    {{ $value['reserve']['once_date'] }}
                                @else
                                    {{ $value['reserve']['multi_dates'] }}
                                @endif
                            </td>
                            <th>{{ $value['reserve']['num_of_seats_reserved'] }}</th>
                            <td>{{ $value['ride']['amount'] }}</td>
                            <td>
                                @if ($value['reserve']['status'] == 1)
                                    <span class="text-success">تم الحجز</span>
                                @else
                                    <span class="text-danger">الحجز ملغي</span>
                                @endif
                            </td>
                            <td>{{ $value['created_at'] ?? 'لا يوجد' }}</td>
                            <td>{{ $value['updated_at'] ?? 'لا يوجد' }}</td>
                            <td class="d-flex justify-content-around align-items-center">
                                {{-- <a href="{{ route('reserve.edit', $value['reserve']['id']) }}"
                                    class="btn btn-primary">تعديل</a> --}}
                                <form method="POST" onsubmit="return confirm('هل أنت متأكد ؟');"
                                    action="{{ route('reserve.destroy', $value['reserve']['id']) }}">
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
                        <th scope="col">الرقم الراكب التسلسلي</th>
                        <th scope="col">إسم الراكب</th>
                        <th scope="col">الوجهة</th>
                        <th scope="col">نوع الحجز</th>
                        <th scope="col">تاريخ الحجز</th>
                        <th scope="col">عدد المقاعد</th>
                        <th scope="col">السعر</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">تاريخ الإنشاء</th>
                        <th scope="col">تاريخ أخر تحديث</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    @else
        <div class="text-muted"><small>
                لا يوجد بيانات
            </small></div>
    @endif

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
