@extends('layouts.dashboard')

@section('title')
    <title>بيانات الراكب</title>
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
                <h3>رقم السائق التسلسلي : <h3>{{ $passenger['id'] }}</h3>
                </h3>
                <h3> الهاتف : <h3>{{ $passenger['phone'] }}</h3>
                    <h3> البريد : <h3>{{ $passenger['email'] }}</h3>
                    </h3>
                    <h3>
                        العنوان : <span>{{ $passenger['address'] }}<span </h3>
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-around">
                <form action="{{ route('passengers.requests.post') }}" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $passenger['id'] }}">
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </form>
                <a href="{{ route('passengers.requests.index') }}" class="btn btn-light">رجوع</a>
            </div>
        </div>
    </div>
@endsection
