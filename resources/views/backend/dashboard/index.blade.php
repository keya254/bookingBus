@extends('layouts.app')
@section('title')
الرئيسية
@endsection
@section('page-header')
	<div class="breadcrumb-header justify-content-between">
		<div class="left-content">
			<div>
			  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1"> أهلا {{auth()->user()->name}}</h2>
			</div>
		</div>
	</div>
@endsection
@section('content')
<div class="row">
    @foreach ($data as $key=> $item)
      <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
		<div class="card overflow-hidden sales-card bg-pink">
			<div class="pl-3 pt-3 pr-3 pb-2">
				<div class="">
					<h6 class="mb-3 tx-12 text-white">@lang('dashboard.'.$key)</h6>
				</div>
				<div class="pb-0 mt-0">
					<div class="d-flex">
						<div class="">
							<h4 class="tx-20 font-weight-bold mb-1 text-white">{{$item}}</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
      </div>
    @endforeach
</div>
<div class="row">
    @role('Admin')
    <div class="col-6 shadow-md pb-4">
        <div class="card">
          <div class="card-header">انواع السيارات</div>
          <div class="card-body" id="typecars" style="height: 400px"></div>
        </div>
    </div>
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">الرحلات</div>
            <div class="card-body" id="trips" style="height: 400px"></div>
        </div>
    </div>
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">السيارات</div>
            <div class="card-body" id="cars" style="height: 400px"></div>
        </div>
    </div>
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">المقاعد</div>
            <div class="card-body" id="seats" style="height: 400px"></div>
        </div>
    </div>
    @endrole

    @role('Owner')
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">سيارتي</div>
            <div class="card-body" id="owner_cars" style="height: 400px"></div>
        </div>
    </div>
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">الرحلات</div>
            <div class="card-body" id="owner_trips" style="height: 400px"></div>
        </div>
    </div>
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">المقاعد</div>
            <div class="card-body" id="owner_seats" style="height: 400px"></div>
        </div>
    </div>
    @endrole

    @role('Driver')
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">الرحلات</div>
            <div class="card-body" id="driver_trips" style="height: 400px"></div>
        </div>
    </div>
    <div class="col-6 shadow-md pb-4">
        <div class="card">
            <div class="card-header">المقاعد</div>
            <div class="card-body" id="driver_seats" style="height: 400px"></div>
        </div>
    </div>
    @endrole
</div>
@endsection
@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});


  @role('Admin')

  google.charts.setOnLoadCallback(typeCar);

  //typecar active , inactive
  function typeCar() {
     active   = '<?php echo $data["active_typecars"]; ?>';
     inactive = '<?php echo $data["inactive_typecars"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Type Cars'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'انواع السيارات',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('typecars'));

    chart.draw(data, options);
  }



  google.charts.setOnLoadCallback(trip);

  //trips active , inactive
  function trip() {
     active   = '<?php echo $data["active_trips"]; ?>';
     inactive = '<?php echo $data["inactive_trips"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Trips'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'الرحلات',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('trips'));

    chart.draw(data, options);
  }

  google.charts.setOnLoadCallback(car);

  //cars active , inactive
  function car() {
     active   = '<?php echo $data["active_cars"]; ?>';
     inactive = '<?php echo $data["inactive_cars"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Cars'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'السيارات',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('cars'));

    chart.draw(data, options);
  }


  google.charts.setOnLoadCallback(seat);

  //seats active , inactive
  function seat() {
     active   = '<?php echo $data["active_seats"]; ?>';
     inactive = '<?php echo $data["inactive_seats"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Seats'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'المقاعد',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('seats'));

    chart.draw(data, options);
  }

  @endrole

  @role('Owner')

  google.charts.setOnLoadCallback(owner_seat);

  //owner seats active , inactive
  function owner_seat() {
     active   = '<?php echo $data["active_auth_owner_seats"]; ?>';
     inactive = '<?php echo $data["inactive_auth_owner_seats"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Seats'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'المقاعد',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('owner_seats'));

    chart.draw(data, options);
  }


  google.charts.setOnLoadCallback(owner_car);

  //owner car active , inactive
  function owner_car() {
     active   = '<?php echo $data["active_auth_owner_cars"]; ?>';
     inactive = '<?php echo $data["inactive_auth_owner_cars"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Seats'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'سياراتي',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('owner_cars'));

    chart.draw(data, options);
  }

  google.charts.setOnLoadCallback(owner_trip);

  //owner trip active , inactive
  function owner_trip() {
     active   = '<?php echo $data["active_auth_owner_trips"]; ?>';
     inactive = '<?php echo $data["inactive_auth_owner_trips"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Seats'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'رحلات',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('owner_trips'));

    chart.draw(data, options);
  }

  @endrole

  @role('Driver')

  google.charts.setOnLoadCallback(driver_seat);

  //driver seats active , inactive
  function driver_seat() {
     active   = '<?php echo $data["active_auth_driver_seats"]; ?>';
     inactive = '<?php echo $data["inactive_auth_driver_seats"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Seats'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'المقاعد',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('driver_seats'));

    chart.draw(data, options);
  }


  google.charts.setOnLoadCallback(driver_trip);

  //driver trip active , inactive
  function driver_trip() {
     active   = '<?php echo $data["active_auth_driver_trips"]; ?>';
     inactive = '<?php echo $data["inactive_auth_driver_trips"]; ?>';

    var data = google.visualization.arrayToDataTable([
      ['Type', 'Count Seats'],
      ['مفعلة',parseInt(active)],
      ['مغلقة',parseInt(inactive)],
    ]);

    var options = {
      title: 'رحلات',
      is3D: true,
      pieStartAngle: 100,
      fontName:'Tajawal'
    };

    var chart = new google.visualization.PieChart(document.getElementById('driver_trips'));

    chart.draw(data, options);
  }

  @endrole

</script>
@endsection
