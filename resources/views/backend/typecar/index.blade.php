@extends('layouts.app')
@section('title')
 انواع السيارات
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
            <h4 class="content-title mb-0 my-auto"> انواع السيارات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
    @can('create-typecar')
      <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#createtypecar">انشاء نوع سيارة</a>
    @endcan
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
  <div class="card-header">انواع السيارات</div>
  <div class="card-body">
      <table class="table text-center data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم السيارة</th>
                <th>عدد المقاعد</th>
                <th>حالة السيارة</th>
                <th>الصلاحيات</th>
            </tr>
        </thead>
        <tbody></tbody>
      </table>
  </div>
</div>
@can('create-typecar')
  <x-TypeCar.Create/>
@endcan
@can('edit-typecar')
  <x-TypeCar.Edit />
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
          ajax: "{{ route('type-car.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'number_seats', name: 'number_seats'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          },
          fnDrawCallback: function() {
          $('.changestatus').bootstrapToggle();
         },
      });
   };
   $('#ctypecar').submit(function (e) {
       e.preventDefault();
       var data=$('#ctypecar').serialize();
      $.ajax({
          type: "post",
          url: "{{route('type-car.store')}}",
          data: data,
          dataType: "json",
          success: function (response) {
            $('#createtypecar').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('#etypecar').submit(function (e) {
       e.preventDefault();
      var data=$('#etypecar').serialize();
      var id=$('#eid').val();
      $.ajax({
          type: "put",
          url: "{{route('type-car.index')}}/"+id,
          data: data,
          dataType: "json",
          success: function (response) {
            $('#edittypecar').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
      });
   });
   $(document).on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('type-car.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
   $(document).on('click','.edittypecar',function()
   {
       $.ajax({
           type: "get",
           url: "{{route('type-car.index')}}/"+$(this).attr('data-id'),
           dataType: "json",
           success: function (response) {
            $('#ename').val(response.typecar.name);
            $('#eid').val(response.typecar.id);
            $('#enumber_seats').val(response.typecar.number_seats);
            $('#edittypecar').modal('toggle');
           }
       });
   });
   $(document).on('change','.changestatus',function()
   {
       $.ajax({
           type: "post",
           url: "{{route('type-car.change-status')}}",
           dataType: "json",
           data:{id:$(this).attr('data-id')},
           success: function (response) {
            $('.data-table').DataTable().ajax.reload();

           }
       });
   });
  </script>
@endsection
