@extends('layouts.app')
@section('title')
المحافظات
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">المحافظات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
    <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#creategovernorate">انشاء محافظة</a>
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
    <div class="card-header">المحافظات</div>
    <div class="card-body">
        <table class="table text-center data-table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>اسم المحافظة</th>
                  <th>الصلاحيات</th>
              </tr>
          </thead>
          <tbody></tbody>
        </table>
    </div>
  </div>
@can('create-governorate')
<x-governorate.Create/>
@endcan
@can('edit-governorate')
<x-governorate.Edit/>
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
          ajax: "{{ route('governorate.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          }
      });
   };
   $('#cgovernorate').submit(function (e) {
       e.preventDefault();
       var data=$('#cgovernorate').serialize();
      $.ajax({
          type: "post",
          url: "{{route('governorate.store')}}",
          data: data,
          dataType: "json",
          success: function (response) {
            $('#creategovernorate').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('#egovernorate').submit(function (e) {
       e.preventDefault();
      var data=$('#egovernorate').serialize();
      var id=$('#eid').val();
      $.ajax({
          type: "put",
          url: "{{route('governorate.index')}}/"+id,
          data: data,
          dataType: "json",
          success: function (response) {
            $('#editgovernorate').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
      });
   });
   $('.data-table').on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('governorate.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
   $('.data-table').on('click','.editgovernorate',function()
   {
       $.ajax({
           type: "get",
           url: "{{route('governorate.index')}}/"+$(this).attr('data-id'),
           dataType: "json",
           success: function (response) {
            $('#ename').val(response.governorate.name);
            $('#eid').val(response.governorate.id);
            $('#editgovernorate').modal('toggle');
           }
       });
   });
  </script>
@endsection
