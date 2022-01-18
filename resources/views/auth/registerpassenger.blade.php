@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="box p-5 rounded text-center">
                    <form method="POST" action="{{ route('registerpassenger') }}">
                        @csrf

                        {{-- error messages --}}
                        @if (Session::has('error'))
                            <div class="alert alert-danger text-right" id="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <h1 class="h3 mb-3 fw-normal c-main">انشاء حساب راكب وصلني</h1>
                        <div class="form-floating mb-3">
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') border border-danger @enderror"
                                   value="{{ old('name') }}" required>
                            <label for="name">الاسم</label>
                            @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="phone" id="phone"
                                   class="form-control @error('phone') border border-danger @enderror"
                                   value="{{ old('phone') }}" required>
                            <label for="phone">رقم الموبايل </label>
                            @error('phone')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') border border-danger @enderror"
                                   value="{{ old('email') }}" required>
                            <label for="email">البريد الالكتروني </label>
                            @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="address" id="address"
                                   class="form-control @error('address') border border-danger @enderror"
                                   value="{{ old('address') }}" required>
                            <label for="address">الموقع</label>
                            @error('address')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') border border-danger @enderror" value="" required>
                            <label for="password">الرقم السري </label>
                            @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control @error('password_confirmation') border border-danger @enderror"
                                   value="" required>
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
