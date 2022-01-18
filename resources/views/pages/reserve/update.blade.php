@extends('layouts.dashboard')

@section('title')
    <title>لوحة التحكم | تحديث حجز</title>
    @livewireStyles
@endsection

@section('content')
    <livewire:update-reserve :data="$data" />
@endsection

@section('script')
    <script>
        // hide submit button
        $("#submitBtn").hide();
        $(".result_table").hide();

        let reserveId = $("#reserve_id").val();
        let rides = JSON.parse(document.getElementById('all_rides').value);
        let fromTo = document.getElementById('from-to').value;
        let form = document.getElementById('reserve_form');
        let messages = document.getElementById('messages');

        $(document).ready(function() {
            $('input[name=occurance]').click(function() {

                // hide submit button
                // $("#submitBtn").hide();
                // $(".result_table").hide();

                let rides_dates = JSON.parse(document.getElementById('all_rides_dates').value);
                let fromTo = document.getElementById('from-to').value;
                let oc = $(this).val();
                console.log(rides_dates);
                rides.map((value) => {
                    console.log(oc);
                    if (oc == 'once') {
                        console.log(value.once_date);
                        flatpickr("#once_date", {
                            dateFormat: "Y-m-d",
                            inline: true,
                            minDate: "today",
                            enable: rides_dates
                        });
                        // once_date.config._enable = [value.once_date]
                    }
                    if (oc == 'custome') {
                        flatpickr("#multi_date", {
                            mode: "multiple",
                            dateFormat: "Y-m-d",
                            inline: true,
                            minDate: "today",
                            enable: rides_dates
                        });
                    }
                })
            })

            // when press next
            $("#next").click(function() {
                if (confirm("هل انت متأكد من خياراتك ؟") == false) {
                    return 0
                }
                let fromTo = document.getElementById('from-to').value;

                // show table with selected ride and it's date's
                $(".result_table").show();

                // show submit button
                $("#submitBtn").show();
                $("#next").hide();

                // filter from-to
                let arr_from_to = fromTo.split(',');
                console.log(arr_from_to);
                // once_date value & multi_date
                let once_date, multi_date;
                let multi_date_arr = [];

                // get occurance
                let oc = $('input[name=occurance]:checked').val();

                if (oc == 'once') {
                    once_date = document.getElementById('once_date').value;
                }
                if (oc == 'custome') {
                    multi_date = document.getElementById('multi_date').value;
                    multi_date_arr = multi_date.split(', ');
                }

                // get selected dates first
                let result = rides.filter((item) => {
                    // if it once
                    if (item.once_date != null && item.once_date == once_date) {
                        console.log('left: ', item.once_date, 'right: ', once_date, 'logic: ', item
                            .once_date == once_date);
                        return item.once_date != null && item.from == arr_from_to[0] && item.to ==
                            arr_from_to[1] && item.once_date == once_date;
                    }

                    // if it multi or custome
                    if (item.multi_date != null) {
                        return item.multi_date != null && item.from == arr_from_to[0] && item.to ==
                            arr_from_to[1] && multi_date_arr.includes(item.multi_date)
                    }
                })

                // append items in table
                var result_table = document.getElementById('result_table');
                if (result.length < 1) {
                    result_table.insertAdjacentHTML('afterend', `<tr>
                                <td colspan="7" class="text-center">لا توجد بيانات لهذا الحجز</td>
                            </tr>`);
                } else {
                    result.map((item) => {
                        result_table.insertAdjacentHTML('afterend', `<tr>
                                <td>
                                    <input ${item.actual_reservation_nums == 0 ? 'disabled' : ''} type="checkbox" class="select-id" value="${item.id}" date="${item.multi_date}">
                                    <br>
                                    ${item.actual_reservation_nums == 0 ? '<small class="text-danger">المقاعد ممتلئة</small>' : ''}
                                    </td>
                                <td>${item.id}</td>
                                <td>${item.from} ---> ${item.to}</td>
                                <td>${item.time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })}</td>
                                <td>${item.car.seats_num - item.actual_reservation_nums} / ${item.car.seats_num}</td>
                                <td>${item.multi_date}</td>
                                <td>${item.car.seat_price}</td>
                            </tr>`);
                    });
                }

            })

            $("#submitBtn").click(function() {

                // select all selected checkboxes
                let selects = document.querySelectorAll('.select-id:checked');
                console.log(selects);

                let select_box = [];
                let data = {};

                let filtered_selects = selects.forEach((item) => {
                    select_box.push(item.value);
                });

                data.ride_id = select_box;
                data._token = $('*[name=_token]').val()
                data.num_of_seats_reserved = $('*[name=num_of_seats_reserved]').val();
                data.occurance = $('*[name=occurance]:checked').val();
                data.once_date = $('*[name=once_date]').val();
                data.multi_dates = $('*[name=multi_dates]').val();
                data.multi_dates = $('*[name=status]').val();

                $.ajax({
                    type: "POST",
                    url: `/reserve/${reserveId}/update`,
                    data: data,
                    success: function(res) {
                        console.log(res);
                        if (res.success) {
                            messages.innerHTML =
                                `<div class="alert alert-success">${res.message}</div>`
                            messages.scrollIntoView();
                        } else {
                            messages.innerHTML =
                                `<div class="alert alert-danger">${res.message}</div>`
                            messages.scrollIntoView();
                        }
                    }
                });

            })

        })
    </script>
    @livewireScripts
@endsection
