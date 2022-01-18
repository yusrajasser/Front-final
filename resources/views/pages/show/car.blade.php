@extends('layouts.dashboard')

@section('title')
    <title>بيانات السيارة</title>
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
                <h3>رقم السيارة التسلسلي : <h3>{{ $car['id'] }}</h3>
                </h3>
                <h3>عدد المقاعد : <h3>{{ $car['seats_num'] }}</h3>
                    <h3>سعر المقعد : <h3>{{ $car['seat_price'] }}</h3>
                    </h3>
                    <h3>
                        رخصة السيارة :
                        <img src="{{ asset("storage/$car[car_license]") ?? '' }}" style="fit-object:cover;" width="120"
                            height="60">
                    </h3>
            </div>
        </div>
        <div class="row">
            <div class="d-flex justify-content-around">
                <form action="{{ route('cars.requests.post') }}" method="post">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $car['id'] }}">
                    <button type="submit" class="btn btn-primary">تأكيد</button>
                </form>
                <a href="{{ route('cars.requests.index') }}" class="btn btn-light">رجوع</a>
            </div>
        </div>
    </div>
@endsection
