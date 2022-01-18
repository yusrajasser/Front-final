@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | الإشعارات</title>
@endsection

@section('content')
    {{-- error messages --}}
    @if (Session::has('error'))
        <div class="alert alert-danger text-right" id="alert" dir="rtl">
            {{ Session::get('error') }}
        </div>
    @endif

    <div class="w-100 mt-5">
        <div class="d-flex justify-content-center align-items-center w-100">
            <div class="d-flex justify-content-between w-100" dir="rtl">
                <div class="d-inline">
                    @if ($data['alert_type'] == 'warn')
                        <div class="badge alert-warning">
                            تحذير
                        </div>
                        <div class="h5">
                            {{ $data['af_model'] }}
                        </div>
                    @endif

                    @if ($data['alert_type'] == 'update')
                        <div class="badge alert-info">
                            تحديث
                        </div>
                        <div class="h5">
                            {{ $data['af_model'] }}
                        </div>
                    @endif

                    @if ($data['alert_type'] == 'delete')
                        <div class="badge alert-danger">
                            حذف
                        </div>
                        <div class="h5">
                            {{ $data['af_model'] }}
                        </div>
                    @endif
                </div>
                <div class="">
                    <div class="" dir="ltr"><small class="text-muted">{{ $data['created_at'] }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 h4" dir="rtl">
            {{ $data['message'] }}
        </div>
    </div>
@endsection
