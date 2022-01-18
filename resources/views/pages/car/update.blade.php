@extends('layouts.dashboard')

@section('title')
    <title> لوحة التحكم | تحديث سيارة</title>
@endsection

@section('content')
    {{-- error messages --}}
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
    <form method="POST" class="d-flex flex-column justify-content-center align-items-center"
        action="{{ route('car.update', $car['id']) }}" enctype="multipart/form-data" dir="rtl">
        @csrf
        @method('PATCH')
        <h1 class="h3 mb-3 fw-normal pt-3 rounded"> إضافة سيارة</h1>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="name">السائق</label>
            <select name="driver_id" class="form-control">
                <option value="" readonly>إختر من القائمة</option>
                @if (auth()->user()->user_role == 'admin')
                    @foreach ($data as $key => $value)
                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                    @endforeach
                @endif

                @if (auth()->user()->user_role == 'driver')
                    @foreach ($data as $key => $value)
                        @if (auth()->user()->email == $value['email'])
                            <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                        @endif
                    @endforeach
                @endif
            </select>

            @error('driver_id')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="name">عدد المقاعد</label>
            <input class="form-control col-sm-8" type="text" name="seats_num">
            @error('seats_num')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="name">رخصة السيارة</label>
            <input class="form-control col-sm-8" type="file" name="car_license">
            @error('car_license')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex flex-justify-center pt-5">
            <button class="w-50 btn btn-lg btn-primary" type="submit">تحديث</button>
        </div>
    </form>

@endsection
