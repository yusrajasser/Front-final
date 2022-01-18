@extends('layouts.dashboard')

@section('title')
    <title> لوحة التحكم | إضافة سيارة</title>
    @livewireStyles
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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="box p-5 rounded">
                <form method="POST"
                      action="{{ auth()->user()->user_role == 'admin' ? route('car.store') : route('driver.car.store') }}"
                      enctype="multipart/form-data">
                    @csrf
                    <h1 class="h3 mb-3 fw-normal c-main"> إضافة سيارة</h1>

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-row p-1 rounded">
                        <label class="c-main mb-2" for="name">السائق</label>
                        <select name="driver_id" class="form-control">
                            <option value="" readonly>إختر من القائمة</option>
                            @if (auth()->user()->user_role == 'admin')
                                @foreach ($data as $key => $value)
                                    <option value="{{ $value['id'] }}">{{ $value['access_key'] }}</option>
                                @endforeach
                            @endif

                            @if (auth()->user()->user_role == 'driver')
                                @foreach ($data as $key => $value)
                                    @if (auth()->user()->email == $value['email'])
                                        <option value="{{ $value['id'] }}">{{ $value['access_key'] }}</option>
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

                    <livewire:seats-counter-component />
                    {{-- <div class="form-row p-1">
                        <label class="c-main mb-2" for="seats_num">عدد المقاعد</label>
                        <div class="d-flex" x-data="{ count: 0 }">
                            <button @click="count++" type="button" class="btn btn-primary px-2">+</button>
                            <input class="form-control" x-model="count" type="number" style="width: 60px" step="1" name="seats_num"
                                value="1" min="1" max="18" required>
                            <button @click="count--" type="button" class="btn btn-primary px-2">-</button>
                        </div>
                        @error('seats_num')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}

                    <div class="form-row p-1">
                        <label class="c-main mb-2" for="name">سعر المقعد</label>
                        <input class="form-control" type="number" step="0.1" name="seat_price" required>
                        @error('seat_price')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-row p-1">
                        <label class="c-main mb-2" for="name">رخصة السيارة</label>
                        <input class="form-control" type="file" name="car_license" required>
                        @error('car_license')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex flex-justify-center pt-5">
                        <button class="w-50 btn btn-lg btn-main" type="submit">إضافة</button>
                        <button class="w-50 m-r-5 btn btn-lg btn-gray" type="reset">تهيئة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @livewireScripts
@endsection
