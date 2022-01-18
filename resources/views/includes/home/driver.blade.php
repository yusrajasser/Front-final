<div class="w-100 d-flex flex-column gap-4 align-items-center">
    <a class="btn btn-primary" href="{{ route('ride.create') }}">رحلة جديدة <span data-feather="plus"></span></a>
    <div class="w-100">
        @include('includes.tables.driver.ridesSchedule')
    </div>
</div>
