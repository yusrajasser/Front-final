@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | تقارير السيارات</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-main">
            <caption>List of users</caption>
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">اسم السائق</th>
                    <th scope="col">عدد المقاعد</th>
                    <th scope="col">سعر المقعد</th>
                    <th scope="col">رخصة السيارة</th>
                    <th scope="col">الموافقة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">تاريخ أخر تحديث</th>
                    <th scope="col">العمليات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <th scope="row">{{ $value['id'] }}</th>
                        <td>{{ $value['driver']['name'] ?? 'لا يوجد' }}</td>
                        <td>{{ $value['seats_num'] }}</td>
                        <td>{{ $value['seat_price'] }}</td>
                        <td>
                            <img src="{{ asset("storage/$value[car_license]") ?? '' }}" style="fit-object:cover;"
                                width="120" height="60">
                        </td>
                        <td>
                            @if ($value['confirmed'])
                                <span class="text-success">تمت الموافقة</span>
                            @else
                                <span class="text-danger">لم تتم الموافقة</span>
                            @endif
                        </td>
                        <td>{{ $value['created_at'] }}</td>
                        <td>{{ $value['updated_at'] }}</td>
                        <td class="d-flex justify-content-around align-items-center">
                            <form method="POST" onsubmit="return confirm('هل أنت متأكد ؟');"
                                action="{{ route('car.destroy', $value['id']) }}">
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
                    <th scope="col">id</th>
                    <th scope="col">اسم السائق</th>
                    <th scope="col">عدد المقاعد</th>
                    <th scope="col">سعر المقعد</th>
                    <th scope="col">رخصة السيارة</th>
                    <th scope="col">الموافقة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">تاريخ أخر تحديث</th>
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
