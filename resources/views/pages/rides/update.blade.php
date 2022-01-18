@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | تعديل رحلة</title>
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
        action="{{ route('ride.update', $ride) }}" dir="rtl">
        @method('PATCH')
        @csrf
        <h1 class="h3 mb-3 fw-normal p-5 rounded"> تعديل رحلة</h1>
        <input type="hidden" name="driver_id" value="{{ $data['driver_id'] }}">
        <div class="d-flex justify-content-center gap-1 col-6 pt-2">
            <div class="col-6">
                <label class="col-sm-4" for="from">من</label>
                <input class="form-control col-12" type="text" name="from">
                @error('from')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-6">
                <label class="col-sm-4" for="to">إلى</label>
                <input class="form-control col-12" type="text" name="to">
                @error('to')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="name">السيارة</label>
            <select name="car_id" class="form-control">
                <option value="">إختر</option>
                @foreach ($data['cars'] as $key => $value)
                    <option value="{{ $value['id'] }}">{{ $value['id'] }}</option>
                @endforeach
            </select>

            @error('car_id')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- occurance --}}
        <div x-data="{ocu:'once'}" class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="number_of_seats">
                <h4>إختر فترات الحجز</h4>
            </label>

            <div class="d-flex gap-2">
                <input @click="ocu = 'once'" type="radio" name="occurance" value="once" id="occ_once" checked> مرة واحدة
                <input @click="ocu = 'custome'" type="radio" name="occurance" value="custome" id="occ_custome"> عدة مرات
            </div>
            @error('occurance')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
            <div class="w-100" x-show="ocu == 'once' ? true : false" id="oc_once">
                <hr />
                <div class="w-100 form-row p-1 rounded col-6">
                    <label class="col-sm-4" for="once_date"> تاريخ الحجز</label>
                    <input class="form-control col-sm-8" type="text" id="once_date" name="once_date">
                    @error('once_date')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div x-show="ocu == 'custome' ? true : false" class="w-100" id="oc_custom">
                <hr>
                <div class="w-100 d-flex justify-content-between col-6 gap-1 pt-2">
                    <div class="col-12">
                        <label class="col-sm-4" for="multi_date">تواريخ</label>
                        <input class="form-control col-sm-8" type="text" name="multi_date" id="multi_date">
                        <small>يمكنك إختيار عدة تواريخ</small>
                        @error('multi_date')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="form-row p-1 rounded col-6">
                <label class="col-sm-4" for="name">حالة الرحلة</label>
                <select name="status" class="form-control">
                    <option value="">إختر</option>
                    <option value="waiting">إنتظار</option>
                    <option value="done">تم</option>
                    <option value="canceled">إلغاء</option>
                </select>

                @error('status')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="time">الوقت </label>
            <div class="col-12">
                <input class="form-control col-md-4" type="time" name="time" step="600">
            </div>
            @error('time')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="name">سعر المقعد</label>
            <input class="form-control col-sm-8" type="number" step="0.1" min="0" name="amount">
            @error('amount')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex flex-justify-center pt-5">
            <button class="btn btn-lg btn-primary" type="submit">تعديل</button>
            {{-- <button class="w-50 btn btn-lg btn-light" type="reset">تهيئة</button> --}}
        </div>
    </form>

@endsection

@section('script')
    <script>
        flatpickr("#once_date", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });

        flatpickr("#multi_date", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    </script>
@endsection
