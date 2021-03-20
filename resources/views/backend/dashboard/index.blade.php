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
		<div class="card overflow-hidden sales-card bg-warning">
			<div class="pl-3 pt-3 pr-3 pb-2">
				<div class="">
					<h6 class="mb-3 tx-12 text-white">{{$key}}</h6>
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
@endsection
