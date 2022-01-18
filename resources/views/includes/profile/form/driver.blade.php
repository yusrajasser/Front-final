<form method="POST" class="d-flex flex-column justify-content-center align-items-center"
    action="{{ route('profile.update', $data->email) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    {{-- error messages --}} @if (Session::has('error'))
        <div class="alert alert-danger text-right" id="alert">
            {{ Session::get('error') }}
        </div>
    @endif

    <h1 class="h3 mb-3 fw-normal p-5 rounded"> تحديث البيانات الشخصية</h1>
    <div class="form-row p-1 rounded col-6">
        <label class="col-sm-4" for="name">:الاسم</label>
        <input class="form-control col-sm-8" type="text" name="name">
        @error('name')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-row p-1 rounded col-6">
        <label class="col-sm-4" for="phone">رقم الموبايل </label>
        <input class="form-control col-sm-8" type="number" name="phone">
        @error('phone')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-row p-1 rounded col-6">
        <label class="col-sm-4" for="email">البريد الالكتروني </label>
        <input class="form-control col-sm-8" type="text" name="email">
        @error('email')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-row p-1 rounded col-6">
        <label class="col-sm-4" for="name">الرخصة</label>
        <input class="form-control col-sm-8" type="file" name="driver_license">
        @error('driver_license')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-row p-1 rounded col-6">
        <button class="w-50 btn btn-lg btn-primary" type="submit">تحديث</button>
    </div>
</form>
