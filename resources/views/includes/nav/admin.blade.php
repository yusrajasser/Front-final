<nav class="bg-gray sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('dashboard') }}">
                    <span data-feather="home"></span>
                    لوحة تحكم المدير
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.index') }}">
                    <span data-feather="users"></span>
                    الصفحة الشخصية
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('car.create') }}">
                    <span data-feather="bookmark"></span>
                    إضافة سيارة
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading">
            <span>التقارير</span>
        </h6>
        <ul class="nav flex-column mb-2 p-1">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('passenger.index') }}">
                    <span data-feather="file-text"></span>
                    الركاب
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('driver.index') }}">
                    <span data-feather="file-text"></span>
                    السائقين
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('car.index') }}">
                    <span data-feather="file-text"></span>
                    السيارات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ride.index') }}">
                    <span data-feather="file-text"></span>
                    الرحلات
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reserve.index') }}">
                    <span data-feather="file-text"></span>
                    الحجوزات
                </a>
            </li>
        </ul>
    </div>
</nav>
