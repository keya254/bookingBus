@extends('layouts.app')
@section('title')
المدن
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">المدن</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
    <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#createcity">انشاء مدينة</a>
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
    <div class="card-header">المدن</div>
    <div class="card-body">
        <table class="table text-center data-table">
          <thead>
              <tr>
                  <th>#</th>
                  <th>اسم المدينة</th>
                  <th>اسم المحافظة</th>
                  <th>المدن</th>
              </tr>
          </thead>
          <tbody></tbody>
        </table>
    </div>
  </div>
@can('create-city')
<x-city.Create :governorates="$governorates"/>
@endcan
@can('edit-city')
<x-city.Edit :governorates="$governorates" />
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
          ajax: "{{ route('city.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'governorate.name', name: 'governorate.name',orderable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          }
      });
   };
   $('#ccity').submit(function (e) {
       e.preventDefault();
       var data=$('#ccity').serialize();
      $.ajax({
          type: "post",
          url: "{{route('city.store')}}",
          data: data,
          dataType: "json",
          success: function (response) {
            $('#createcity').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('#ecity').submit(function (e) {
       e.preventDefault();
      var data=$('#ecity').serialize();
      var id=$('#eid').val();
      $.ajax({
          type: "put",
          url: "{{route('city.index')}}/"+id,
          data: data,
          dataType: "json",
          success: function (response) {
            $('#editcity').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
      });
   });
   $('.data-table').on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('city.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
   $('.data-table').on('click','.editcity',function()
   {
       $.ajax({
           type: "get",
           url: "{{route('city.index')}}/"+$(this).attr('data-id'),
           dataType: "json",
           success: function (response) {
            $('#ename').val(response.city.name);
            $('#eid').val(response.city.id);
            $('select[name=governorate_id]').val(response.city.governorate_id);
            $('#editcity').modal('toggle');
           }
       });
   });
  </script>
@endsection
