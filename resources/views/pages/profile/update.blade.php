@extends('layouts.dashboard')

@section('content')
    <div class="container text-center">
        <div class="bg-light d-grid mx-auto p-5 rounded">
            {{-- admin --}}
            @if (auth()->user()->user_role == 'admin')
                @include('includes.profile.form.admin')
            @endif

            {{-- driver --}}
            @if (auth()->user()->user_role == 'driver')
                @include('includes.profile.form.driver')
            @endif

            {{-- passenger --}}
            @if (auth()->user()->user_role == 'passenger')
                @include('includes.profile.form.passenger')
            @endif
        </div>
    </div>

@endsection
