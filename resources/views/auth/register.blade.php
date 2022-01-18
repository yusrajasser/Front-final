@extends('layouts.app')

@section('content')
    <main class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="box d-grid mx-auto p-5 rounded">
                    <h1 class="h3 mb-4 fw-normal rounded c-main">انشاء حساب جديد</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="item1" href="{{ route('registerdriver') }}">
                                <i class="fa fa-taxi"></i>
                                سائق
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="item1" href="{{ route('registerpassenger') }}">
                                <i class="fa fa-user"></i>
                                راكب
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
