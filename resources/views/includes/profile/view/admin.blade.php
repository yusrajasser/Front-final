<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="data-table p-3 rounded bg-main">
           <div class="data-row mb-3">
               <div class="data-header">
                   <span>الاسم</span>
               </div>
               <div class="data-header">
                   <span>رقم الهاتف</span>
               </div>
               <div class="data-header">
                   <span>الايميل</span>
               </div>
           </div>
        <div class="data-table p-3 rounded bg-light">
           <div class="data-row">
               <div class="data-label">
                   <span>{{ $data->name }}</span>
               </div>
               <div class="data-label">
                   <span>{{ $data->phone }}</span>
               </div>
               <div class="data-label">
                   <span>{{ $data->email }}</span>
               </div>
           </div>
        </div>
    </div>
</div>
