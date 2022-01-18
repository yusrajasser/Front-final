@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="box p-5 rounded">

                    @if (Session::has('error'))
                        <div class="alert alert-danger text-right" id="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success text-right" id="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('message'))
                        <div class="alert alert-danger text-right" id="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @if (@$send_access_key_to)
                        <div class="alert alert-warn">
                            تم إرسال رمز الدخول إلى بريدك {{ $send_access_key_to }}
                        </div>
                @endif

                <!--<form class="text-center w-100">-->
                    <form action="{{ route('login') }}" method="POST" class="text-center">
                        @csrf
                        <h1 class="h3 mb-3 fw-normal c-main">تسجيل الدخول</h1>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('access_key') border border-danger @enderror"
                                   id="floatingInput" name="access_key" placeholder="رقم الدخول" autocomplete="off">
                            <label for="floatingInput">رقم الدخول</label>
                            @error('access_key')
                            <small class="text-danger" role="alert">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control @error('password') border border-danger @enderror"
                                   id="floatingPassword" name="password" placeholder="رقم السري">
                            <label for="floatingPassword">رقم السري</label>
                            @error('password')
                            <small class="text-danger" role="alert">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>

                        <div class="checkbox mb-3">
                            <label>

                                <input type="checkbox" name="remember" id="remember"> حفظ البيانات
                            </label>
                        </div>
                        <button class="w-50 btn btn-lg btn-main" type="submit">تسجيل</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
