@extends('layouts.app')
@section('title')
 مقاعد الرحلة
@endsection
@section('css')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
@section('page-header')
  <!-- breadcrumb -->
  <div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
            <h4 class="content-title mb-0 my-auto"> مقاعد الرحلة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
        </div>
    </div>
  </div>
  <!-- breadcrumb -->
@endsection
@section('content')
<div class="row">
    <div class="col-7">
        <div class="card ">
          <div class="card-header">مقاعد الرحلة</div>
          <div class="card-body">
            <table class="table text-center data-table">
                <thead>
                    <tr>
                        <th>رقم المقعد</th>
                        <th>العميل</th>
                        <th>تاريخ الحجز</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seats as $seat)
                      <tr>
                        <td>{{$seat->name}}</td>
                        <td>{{$seat->passenger->phone_number??'لم يحجز بعد'}}</td>
                        <td>{{$seat->booking_time?$seat->booking_time->format('Y-m-d'):'لم يحجز بعد'}}</td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
          </div>
        </div>
    </div>
    <div class="col-5">
           <div class="card">
             <div class="card-header">المقاعد</div>
             <div class="card-body" id="trip">
             </div>
           </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{URL::asset('assets/js/seats.js')}}"></script>
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var id = '<?php echo $seats[0]->trip_id; ?>';
    seat(id);
    function seat(id)
    {
      $.ajax({
          type: "post",
          url: "{{route('seats')}}",
          data: {id:id},
          dataType: "json",
          success: function (response) {
            set=new seats(response.trip.id,response.trip.max_seats,response.seats);
            $('#trip').html(set.getall());
          }
      });
    }
</script>
@endsection
