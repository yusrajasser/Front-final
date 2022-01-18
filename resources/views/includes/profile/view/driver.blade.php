<div class="w-100 d-flex flex-row-reverse justify-content-center align-items-center">
    {{-- success message --}}
    @if (Session::has('success'))
        <div class="alert alert-success text-right" id="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="w-75" dir="rtl">
        <div class="row gap-4">
            <div class="col-md-6 col-sm-12">
                <label for=""></label>
                <div class="d-flex flex-column justify-content-start align-items-start gap-2">
                    <h4>الإسم</h4><span>{{ $data->name }}</span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for=""></label>
                <div class="d-flex flex-column justify-content-start align-items-start gap-2">
                    <h4>الرخصة</h4><span>
                        <img src="{{ asset("storage/$data->driver_license") ?? '' }}" style="fit-object:cover;"
                            width="120" height="60">
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for=""></label>
                <div class="d-flex flex-column justify-content-start align-items-start gap-2">
                    <h4>الهاتف</h4><span>{{ $data->phone }}</span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for=""></label>
                <div class="d-flex flex-column justify-content-start align-items-start gap-2">
                    <h4>الإيميل</h4><span>{{ $data->email }}</span>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <a href="{{ route('profile.edit', $data->email) }}" class="btn btn-primary p-2">تحديث البيانات</a>
        </div>
    </div>
</div>
