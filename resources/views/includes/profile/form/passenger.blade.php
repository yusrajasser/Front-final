<form action="" class="w-50">
    @csrf

    <div class="form-row p-1 rounded col-6">

        <label class="col-sm-4" for="name">:الاسم</label>
        <input class="form-control col-sm-8" type="text" name="name">
        @error('name')
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>

    <label class="col-sm-4" for="name">:الاسم</label>
    <input class="form-control col-sm-8" type="text" name="name">
    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    </div>

    <label class="col-sm-4" for="name">:الاسم</label>
    <input class="form-control col-sm-8" type="text" name="name">
    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    </div>

    <label class="col-sm-4" for="name">:الاسم</label>
    <input class="form-control col-sm-8" type="text" name="name">
    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    </div>

    <label class="col-sm-4" for="name">:الاسم</label>
    <input class="form-control col-sm-8" type="text" name="name">
    @error('name')
        <div class="text-danger">
            {{ $message }}
        </div>
    @enderror
    </div>

    <button type="submit">

    </button>


</form>
