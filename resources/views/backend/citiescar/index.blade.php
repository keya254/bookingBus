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
    <a href="javascript:void(0);" class="btn btn-primary btn-sm "  data-toggle="modal" data-target="#createcarcities">انشاء مدينة</a>
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
                  <th>اسم السيارة</th>
                  <th>الصلاحيات</th>
              </tr>
          </thead>
          <tbody></tbody>
        </table>
    </div>
  </div>
@can('create-city')
<x-citiescar.create :cars="$cars" :governorates="$governorates" />
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
          ajax: "{{ route('citiescar.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'city.name', name: 'city.name'},
              {data: 'car.name', name: 'car.name',orderable: false},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          }
      });
   };
   $('#ccarcities').submit(function (e) {
       e.preventDefault();
       var data=$('#ccarcities').serialize();
      $.ajax({
          type: "post",
          url: "{{route('citiescar.store')}}",
          data: data,
          dataType: "json",
          success: function (response) {
            $('#createcarcities').modal('toggle');
            $('.data-table').DataTable().ajax.reload();
          }
        });
   });
   $('.data-table').on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('citiescar.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
  </script>
@endsection
