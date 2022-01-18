    @if (count($data) > 0)
        <div class="table-responsive">
            <table class="table" dir="rtl">
                <thead>
                    <tr>
                        <th scope="col">الرقم التسلسلي</th>
                        <th scope="col">الوجهة</th>
                        {{-- <th scope="col">نوع الحجز</th> --}}
                        <th scope="col">تاريخ الحجز</th>
                        <th scope="col">عدد المقاعد</th>
                        <th scope="col">السعر</th>
                        <th scope="col">المبلغ الكلي</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">تاريخ الإنشاء</th>
                        <th scope="col">تاريخ أخر تحديث</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['reserves_status'] as $key => $value)
                        <tr>
                            <th scope="row">{{ $value['id'] }}</th>
                            <td>{{ $value['ride']['from'] }} -->
                                {{ $value['ride']['to'] }}
                            </td>
                            {{-- <td>{{ $value['reserve']['occurance'] == 'once' ? 'مرة واحدة' : 'معدل' }} --}}
                            </td>
                            <td>
                                @if ($value['ride']['occurance'] == 'once')
                                    {{ $value['reserve']['once_date'] }}
                                @else
                                    {{ $value['multi_date'] }}
                                @endif
                            </td>
                            <th>{{ $value['reserve']['num_of_seats_reserved'] }}</th>
                            <td>{{ $value['ride']['amount'] }}</td>
                            <td><strong><em>{{ $value['total_amount'] }}</em></strong></td>
                            <td>
                                @if ($value['reserve']['status'] == 1)
                                    <span class="text-success">تم الحجز</span>
                                @else
                                    <span class="text-danger">الحجز ملغي</span>
                                @endif
                            </td>
                            <td>{{ $value['created_at'] ?? 'لا يوجد' }}</td>
                            <td>{{ $value['updated_at'] ?? 'لا يوجد' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">الرقم التسلسلي</th>
                        <th scope="col">الوجهة</th>
                        {{-- <th scope="col">نوع الحجز</th> --}}
                        <th scope="col">تاريخ الحجز</th>
                        <th scope="col">عدد المقاعد</th>
                        <th scope="col">السعر</th>
                        <th scope="col">المبلغ الكلي</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">تاريخ الإنشاء</th>
                        <th scope="col">تاريخ أخر تحديث</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    @else
        <div class="text-muted"><small>
                لا يوجد بيانات
            </small></div>
    @endif
