@extends('layouts.app')
@section('title')
الاشعارات
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/datatables.css')}}">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">الاشعارات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="card">
    <div class="card-header">الاشعارات</div>
    <div class="card-body">
        <table class="table text-center data-table">
          <thead>
              <tr>
                  <th>المحتوي</th>
                  <th>الصلاحيات</th>
              </tr>
          </thead>
          <tbody></tbody>
        </table>
    </div>
  </div>
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
          ajax: "{{ route('notifications.index') }}",
          columns: [
              {data: "data.content", name: 'data'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
          language:
          {
            url:"{{asset('assets/js/arabic.json')}}" ,
          }
      });
   };
   $(document).on('click','.delete',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "delete",
       url: "{{route('notifications.index')}}/"+id,
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
   $(document).on('click','.read',function(){
     var id=$(this).attr('data-id');
     $.ajax({
       type: "post",
       url: "{{route('notifications.store')}}",
       data:{id:id},
       dataType: "json",
       success: function (response) {
        $('.data-table').DataTable().ajax.reload();
       }
     });
   });
  </script>
@endsection
