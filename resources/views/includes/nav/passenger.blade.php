<nav class="bg-light sidebar" dir="rtl">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}">
                    <span data-feather="home"></span>
                    لوحة تحكم الراكب
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <span data-feather="users"></span>
                    الصفحة الشخصية
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reserve.create') }}">
                    <span data-feather="bookmark"></span>
                    حجز رحلة
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>التقارير</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('report.my_reserves') }}">
                    <span data-feather="file-text"></span>
                    الحجوزات
                </a>
            </li>
        </ul>
    </div>
