@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | طلبات الركاب</title>
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if (Session::has('error'))
        <div class="alert alert-danger text-right" id="alert" dir="rtl">
            {{ Session::get('error') }}
        </div>
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success text-right" id="alert" dir="rtl">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="" dir="rtl">
        <table class="table">
            <thead class="d-none">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $value)
                    <tr>
                        <td>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <a href="{{ route('passenger.show', $value['id']) }}">
                                    <div class="h5">{{ $value['name'] }}</div>
                                </a>
                                <div class="truncate">{{ $value['address'] }}</div>
                            </div>

                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <form action="{{ route('passengers.requests.post') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $value['id'] }}">
                                    <button type="submit" class="btn btn-primary">
                                        موافقة
                                    </button>
                                </form>
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
