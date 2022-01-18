<div>
    <div id="messages">

    </div>

    <form method="POST" class="d-flex flex-column justify-content-center align-items-center" dir="rtl" id="reserve_form">
        @csrf
        <h1 class="h3 mb-3 fw-normal p-5 rounded"> إضافة حجز</h1>
        <input type="hidden" name="passenger_id" value="{{ $data['passenger']['id'] }}">

        <div class="w-100 d-flex justify-content-center gap-1 col-6 pt-2">
            <div class="form-row p-1 rounded col-6">
                <label class="col-sm-4">الوجهة</label>
                <select name="ride_id" wire:model="selectRide" class="form-control" id="from-to" required>
                    <option value="" readonly>إختر</option>
                    @foreach ($data['rides'] as $key => $value)
                        <option value="{{ $value['from'] }},{{ $value['to'] }}">{{ $value['from'] }} --->
                            {{ $value['to'] }}</option>
                    @endforeach
                </select>

                @error('ride_id')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="number_of_seats">عدد المقاعد</label>
            <div class="d-flex" x-data="{ count: 0 }">
                <button wire:click="increment" type="button" class="btn btn-primary px-2">+</button>
                <input class="form-control" type="number" style="width: 60px" step="1" name="num_of_seats_reserved"
                    value="{{ $count }}" min="1" max="18" required>
                <button wire:click="decrement" type="button" class="btn btn-primary px-2">-</button>
            </div>
            @error('number_of_seats')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <hr>
        {{-- occurance --}}
        <div x-data="{ocu:'once'}" class="form-row p-1 rounded col-6">
            <label class="col-sm-4" for="number_of_seats">
                <h4>إختر فترات الحجز</h4>
            </label>

            <div class="d-flex gap-2">
                <input @click="ocu = 'once'" type="radio" name="occurance" value="once" id="occ_once"> مرة واحدة
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
                        <label class="col-sm-4" for="multi_dates">تواريخ</label>
                        <input class="form-control col-sm-8" type="text" name="multi_dates" id="multi_date">
                        <small>يمكنك إختيار عدة تواريخ</small>
                        @error('multi_dates')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <input type="hidden" id="all_rides" value="{{ $data['rides_json'] }}">
                <input type="hidden" id="all_rides_dates" value="{{ $uniqueDates }}">
            </div>
        </div>

        <div class="result_table">
            <div class="table table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>تحديد</th>
                            <th>الرقم التسلسلي</th>
                            <th>الوجهة</th>
                            <th>الزمن</th>
                            <th>المقاعد الحالية</th>
                            <th>تاريخ الرحلة</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody id="result_table">

                    </tbody>
                </table>
            </div>
        </div>

        <button type="button" id="next" class="my-5 w-100 btn btn-primary">التالي</button>

        <div class="d-flex flex-justify-center pt-5 pb-5">
            <button class="w-100 btn btn-lg btn-primary" id="submitBtn" type="button">حجز</button>
            {{-- <button class="w-50 btn btn-lg btn-light" type="reset">تهيئة</button> --}}
        </div>
    </form>

</div>
