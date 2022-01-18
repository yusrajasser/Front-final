@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | الصفحة الشخصية</title>
@endsection


@section('content')
    @if (auth()->user()->user_role == 'passenger')
        @include('includes.profile.view.passenger')
    @endif

    @if (auth()->user()->user_role == 'driver')
        @include('includes.profile.view.driver')
    @endif

    @if (auth()->user()->user_role == 'admin')
        @include('includes.profile.view.admin')
    @endif

    </div>
@endsection
