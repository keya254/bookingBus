@extends('layouts.app')
@section('title')
 الرحلات
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
            <h4 class="content-title mb-0 my-auto"> الرحلات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
    @can('create-trip')
      <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#createtrip">انشاء رحلة</a>
    @endcan
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
  <div class="card-header">الرحلات</div>
  <div class="card-body">
      <table class="table text-center data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>الرحلة من</th>
                <th>الرحلة الي</th>
                <th>يوم الرحلة</th>
                <th>بداية الرحلة</th>
                <th>حالة الرحلة</th>
                <th>سعر مقعد الرحلة</th>
                <th>اقل وقت للرحلة</th>
                <th>اكثر وقت للرحلة</th>
                <th>السيارة</th>
                <th>السائق</th>
                <th>الصلاحيات</th>
            </tr>
        </thead>
        <tbody></tbody>
      </table>
  </div>
</div>
@can('create-trip')
  <x-Trip.Create :cars="$cars" :drivers="$drivers"/>
@endcan
@can('edit-trip')
  <x-Trip.Edit :cars="$cars" :drivers="$drivers"/>
@endcan

@endsection
@section('js')
<script type="text/javascript" charset="utf8" src="{{asset('js/datatables.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    datatable();
   function datatable() {
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('trip.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'from.name', name: 'from.name'},
              {data: 'to.name', name: 'to.name'},
              {data: 'day', name: 'day'},
              {data: 'start_time', name: 'start_time'},
              {data: 'status', name: 'status',orderable: false, searchable: false},
              {data: 'price', name: 'price'},
              {data: 'min_time', name: 'min_time'},
              {data: 'max_time', name: 'max_time'},
              {data: 'car.name', name: 'car_id'},
              {data: 'driver.name', name: 'driver_id'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          },
           fnDrawCallback: function() {
          $('.changestatus').bootstrapToggle();
         }
      });
   };
   $('#ctrip').submit(function (e) {
       e.preventDefault();
       var data=$('#ctrip').serialize();
      $.ajax({
          type: "post",
          url: "{{route('trip.store')}}",
          data: data,
          dataType: "json",
          success: function (response) {
            $('#createtrip').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('#etrip').submit(function (e) {
       e.preventDefault();
      var data=$('#etrip').serialize();
      var id=$('#eid').val();
      $.ajax({
          type: "put",
          url: "{{route('trip.index')}}/"+id,
          data: data,
          dataType: "json",
          success: function (response) {
            $('#edittrip').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
      });
   });
   $(document).on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('trip.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
   $(document).on('click','.edittrip',function()
   {
       $.ajax({
           type: "get",
           url: "{{route('trip.index')}}/"+$(this).attr('data-id'),
           dataType: "json",
           success: function (response) {
            $('input[name=from]').val(response.trip.from);
            $('input[name=to]').val(response.trip.to);
            $('input[name=start_time]').val(response.trip.start_time);
            $('input[name=day]').val(response.trip.day);
            $('input[name=max_time]').val(response.trip.max_time);
            $('input[name=min_time]').val(response.trip.min_time);
            $('input[name=price]').val(response.trip.price);
            $('input[name=id]').val(response.trip.id);
            $('#edittrip').modal('toggle');

           }
       });
   });
   $(document).on('change','.changestatus',function()
   {
       $.ajax({
           type: "post",
           url: "{{route('trip.changestatus')}}",
           dataType: "json",
           data:{id:$(this).attr('data-id')},
           success: function (response) {
            $('.data-table').DataTable().ajax.reload();

           }
       });
   });
  </script>
@endsection
