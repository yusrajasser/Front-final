@extends('layouts.dashboard')

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if (auth()->user()->user_role == 'driver')
        @include('includes.home.driver')
    @endif

    @if (auth()->user()->user_role == 'passenger')
        @include('includes.home.passenger')
    @endif

    @if (auth()->user()->user_role == 'admin')
        @include('includes.home.admin')
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
