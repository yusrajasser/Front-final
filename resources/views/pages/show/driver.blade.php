@extends('layouts.dashboard')

@section('title')
    <title>بيانات السائق</title>
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
    <div class="row">
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-column justify-content-start gap-4" dir="rtl">
                <h3>رقم السائق التسلسلي : <h3>{{ $driver['id'] }}</h3>
                </h3>
                <h3> الهاتف : <h3>{{ $driver['phone'] }}</h3>
                    <h3> البريد : <h3>{{ $driver['email'] }}</h3>
                    </h3>
                    <h3>
                        رخصة السائق :
                        <img src="{{ asset("storage/$driver[driver_license]") ?? '' }}" style="fit-object:cover;"
                            width="120" height="60">
                    </h3>
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-around">
                <form action="{{ route('drivers.requests.post') }}" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $driver['id'] }}">
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </form>
                <a href="{{ route('drivers.requests.index') }}" class="btn btn-light">رجوع</a>
            </div>
        </div>
    </div>
@endsection
