@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | إنشاء رسالة</title>
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
    <div class="w-100">
        <form action="{{ route('message.store') }}" method="post" class="mt-5" dir="rtl">
            @csrf
            <input type="hidden" name="ride_id" value="{{ $data['id'] }}">
            <input type="hidden" name="{{ $user_role }}" value="{{ $user_id }}">
            <textarea name="message" class="w-100 form-control" rows="10" placeholder="قم بكتابة رسالة"></textarea>
            <div class="mt-5 d-flex justify-content-center gap-4">
                <button type="submit" class="btn btn-primary">إرسال</button>
                <a href="{{ route('message.index') }}" class="btn btn-light">صندوق الرسائل</a>
            </div>
        </form>
    </div>
@endsection
