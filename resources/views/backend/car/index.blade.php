@extends('layouts.app')
@section('title')
 السيارات
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
            <h4 class="content-title mb-0 my-auto"> السيارات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
    @can('create-car')
      <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#createcar">انشاء سيارة</a>
    @endcan
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
  <div class="card-header">السيارات</div>
  <div class="card-body">
      <table class="table text-center data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم السيارة</th>
                <th>صورة السيارة</th>
                <th>مالك السيارة</th>
                <th>نوع السيارة</th>
                <th>حالة السيارة</th>
                <th>يعمل عامة</th>
                <th>يعمل مخصوص</th>
                <th>الصلاحيات</th>
            </tr>
        </thead>
        <tbody></tbody>
      </table>
  </div>
</div>
@can('edit-car')
  <x-Car.Edit :typecars="$typecars"/>
@endcan
@can('create-car')
  <x-Car.Create :typecars="$typecars"/>
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
          ajax: "{{ route('car.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'image', name: 'image'},
              {data: 'owner.name', name: 'owner_id'},
              {data: 'typeCar.name', name: 'typecar_id'},
              {data: 'status', name: 'status',orderable: false, searchable: false},
              {data: 'public', name: 'public',orderable: false, searchable: false},
              {data: 'private', name: 'private',orderable: false, searchable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          },
          fnDrawCallback: function() {
             $('.changestatus').bootstrapToggle();
             $('.changepublic').bootstrapToggle();
             $('.changeprivate').bootstrapToggle();
          }
      });
   };
   $('#ccar').submit(function (e) {
       e.preventDefault();
       var data = new FormData($('#ccar')[0]);
       if ($('input[type=file]').get(0).files.length != 0) {
        data.append('image', $('input[type=file]').get()[0].files[0]);
       }
      $.ajax({
          type: "post",
          url: "{{route('car.store')}}",
          data: data,
          dataType: "json",
          processData: false,
          contentType: false,
          success: function (response) {
            $('#createcar').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('#ecar').submit(function (e) {
       e.preventDefault();
       var da= new FormData(this);
       if ($('input[type=file]').get(0).files.length != 0) {
        da.append('image', $('input[type=file]').get()[0].files[0]);
       }
      var id=$('#ecarid').val();
      $.ajax({
          type: "post",
          url: "{{route('car.index')}}/"+id,
          data:da,
          contentType: false,
          cache: false,
          processData:false,
          dataType: "json",
          success: function (response) {
            $('#editcar').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
            $('#ecar')[0].reset();
            $('input[type=file]').html();
          }
      });
   });
   $(document).on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('car.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
   $(document).on('click','.editcar',function()
   {
       $.ajax({
           type: "get",
           url: "{{route('car.index')}}/"+$(this).attr('data-id'),
           dataType: "json",
           success: function (response) {
            $('#ecarname').val(response.car.name);
            $('#ecarid').val(response.car.id);
            $('#etypecar_id').val(response.car.typecar_id);
            $('input[name=public][value='+response.car.public+']').attr('checked', 'checked');
            $('input[name=private][value='+response.car.private+']').attr('checked', 'checked');
            $('input[name=phone_number]').val(response.car.phone_number);
            $('#editcar').modal('toggle');
           }
       });
   });
   $(document).on('change','.changestatus',function()
   {
       $.ajax({
           type: "post",
           url: "{{route('car.change-status')}}",
           dataType: "json",
           data:{id:$(this).attr('data-id')},
           success: function (response) {
            $('.data-table').DataTable().ajax.reload();

           }
       });
   });
   $(document).on('change','.changepublic',function()
   {
       $.ajax({
           type: "post",
           url: "{{route('car.change-public')}}",
           dataType: "json",
           data:{id:$(this).attr('data-id')},
           success: function (response) {
            $('.data-table').DataTable().ajax.reload();

           }
       });
   });
   $(document).on('change','.changeprivate',function()
   {
       $.ajax({
           type: "post",
           url: "{{route('car.change-private')}}",
           dataType: "json",
           data:{id:$(this).attr('data-id')},
           success: function (response) {
            $('.data-table').DataTable().ajax.reload();

           }
       });
   });
  </script>
@endsection
