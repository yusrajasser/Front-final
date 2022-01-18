@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | تقارير الركاب</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container content">

        <div class="table-responsive">
            <table class="table table-main">
                <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">رمز الدخول</th>
                    <th scope="col">الإسم</th>
                    <th scope="col">الهاتف</th>
                    <th scope="col">الإيميل</th>
                    <th scope="col">العنوان</th>
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
                        <th>{{ $value['access_key'] }}</th>
                        <td>{{ $value['name'] }}</td>
                        <td>{{ $value['phone'] }}</td>
                        <td>{{ $value['email'] }}</td>
                        <td>{{ $value['address'] }}</td>
                        <td>{{ $value['confirmed'] == 0 ? 'لم تتم' : 'تمت' }}</td>
                        <td>{{ $value['created_at'] ?? 'لا يوجد' }}</td>
                        <td>{{ $value['updated_at'] ?? 'لا يوجد' }}</td>
                        <td class="d-flex justify-content-around align-items-center">
                            <form method="POST" onsubmit="return confirm('هل أنت متأكد ؟');"
                                  action="{{ route('passenger.destroy', $value['id']) }}">
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
                    <th scope="col">رمز الدخول</th>
                    <th scope="col">الإسم</th>
                    <th scope="col">الهاتف</th>
                    <th scope="col">الإيميل</th>
                    <th scope="col">العنوان</th>
                    <th scope="col">الموافقة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">تاريخ أخر تحديث</th>
                    <th scope="col">العمليات</th>
                </tr>
                </tfoot>
            </table>
        </div>
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
