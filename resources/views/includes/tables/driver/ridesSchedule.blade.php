@if (count($data) > 0)
    <div class="table-responsive">
        <table class="table" dir="rtl">
            <thead>
                <tr>
                    <th scope="col">الرقم التسلسلي</th>
                    <th scope="col">رقم السيارة التسلسلي</th>
                    <th scope="col">الوقت</th>
                    <th scope="col">الوجهة</th>
                    <th scope="col">عدد المقاعد</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">تاريخ الإنشاء</th>
                    <th scope="col">تاريخ أخر تحديث</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['reserves'] as $key => $value)
                    <tr>
                        <th scope="row">{{ $value['id'] }}</th>
                        <th scope="row">{{ $value['car']['id'] }}</th>
                        <td>{{ date('h:i A', strtotime($value['time'])) }}
                        <td>{{ $value['from'] }} -->
                            {{ $value['to'] }}
                        </td>
                        <td>
                            {{ $value['actual_reservation_nums'] == null ? 0 : $value['actual_reservation_nums'] }} /
                            {{ $value['car']['seats_num'] }}
                        </td>
                        <td>
                            @if ($value['status'] == 'waiting')
                                <span data-feather="clock" class="text-warning"></span> <small
                                    class="d-hidden">waiting</small>
                            @endif
                            @if ($value['status'] == 'done')
                                <span data-feather="check" class="text-success"></span> <small
                                    class="d-hidden">done</small>
                            @endif
                            @if ($value['status'] == 'canceled')
                                <span data-feather="x" class="text-danger"></span> <small
                                    class="d-hidden">canceled</small>
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
                    <th scope="col">رقم السيارة التسلسلي</th>
                    <th scope="col">الوقت</th>
                    <th scope="col">الوجهة</th>
                    <th scope="col">عدد المقاعد</th>
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
