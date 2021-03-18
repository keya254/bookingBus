@extends('layouts.app')
@section('title')
اصحاب السيارات
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">اصحاب السيارات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
    <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#createowner">انشاء مالك سيارة</a>
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
    <div class="card-header">اصحاب السيارات</div>
    <div class="card-body">
        <table class="table text-center data-table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>اسم المالك سيارة</th>
                  <th>البريد الالكتروني للمالك سيارة</th>
                  <th>الصلاحيات</th>
              </tr>
          </thead>
          <tbody></tbody>
        </table>
    </div>
  </div>
@can('create-owner')
<x-owner.create/>
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
          ajax: "{{ route('owner.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          }
      });
   };
   $('#cowner').submit(function (e) {
       e.preventDefault();
       var data=$('#cowner').serialize();
      $.ajax({
          type: "post",
          url: "{{route('owner.store')}}",
          data: data,
          dataType: "json",
          success: function (response) {
            $('#createowner').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('.data-table').on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('owner.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
  </script>
@endsection
