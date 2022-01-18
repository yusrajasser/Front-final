<div class="row justify-content-center">
    <div class="col-md-3">
        <a href="{{ route('cars.requests.index') }}" class="text-decoration-none d-flex flex-column justify-content-center align-items-center cars p-4 border rounded">
            @if ($cars_count > 0)
                <div class="badge alert-danger">
                    {{ $cars_count }}
                </div>
            @endif
            <i class="fa fa-taxi c-main font-size-45"></i>
            <h3 class="c-gray">السيارات</h3>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('passengers.requests.index') }}" class="text-decoration-none d-flex flex-column justify-content-center align-items-center drivers p-4 border rounded">
            @if ($passengers_count > 0)
                <div class="badge alert-danger">
                    {{ $passengers_count }}
                </div>
            @endif
            <i class="fa fa-user c-main font-size-45"></i>
            <h3 class="c-gray">الركاب</h3>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('drivers.requests.index') }}" class="text-decoration-none d-flex flex-column justify-content-center align-items-center passengers p-4 border rounded">
            @if ($drivers_count > 0)
                <div class="badge alert-danger">
                    {{ $drivers_count }}
                </div>
            @endif
            <i class="fa fa-car c-main font-size-45"></i>
            <h3 class="c-gray">السائقين</h3>
        </a>
    </div>
</div>
