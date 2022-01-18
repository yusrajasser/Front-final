@extends('layouts.app')

@section('content')
    <main class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="box p-5 rounded">
                    <form method="POST"
                          action="{{ route('driver_store') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf

                        {{-- error messages --}}
                        @if (Session::has('error'))
                            <div class="alert alert-danger text-right" id="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <h1 class="h3 mb-3 fw-normal c-main">انشاء حساب سائق وصلني</h1>

                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="name">
                            <label for="name">الاسم</label>
                            @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="number" name="phone">
                            <label for="phone">رقم الموبايل </label>
                            @error('phone')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" name="email">
                            <label for="email">البريد الالكتروني </label>
                            @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="file" name="driver_license">
                            <label for="name">الرخصة</label>
                            @error('driver_license')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" name="password">
                            <label for="password">الرقم السري </label>
                            @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" name="password_confirmation">
                            <label for="password-confirmation">اعادة الرقم السري </label>
                            @error('password_confirmation')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-row p-1 rounded">
                            <button class="w-50 btn btn-lg btn-main" type="submit">تسجيل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
