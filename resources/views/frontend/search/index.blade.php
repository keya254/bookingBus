@extends('layouts.master2')
@section('title')
 بحث
@endsection
@section('css')
  <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@endsection
@section('content')
<div class="container px-5 py-16 mx-auto lg:px-20 lg:pt-24">
    <div class="flex flex-wrap text-center">
      <div class="lg:w-1/4 md:w-1/4 sm:w-full w-full shadow-md px-8 rounded-lg">
        <form method="get" action="/search" class="flex flex-wrap text-center bg-white rounded-md">
            <div class=" py-6 w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">الرحلة من</h2>
                <select name="from_id" class="select2" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                    <option value="">من</option>
                    @foreach ($governorates as $governorate)
                      <optgroup label="{{$governorate->name}}">
                      @foreach ($governorate->cities as $city)
                        <option value="{{$city->id}}" {{request()->from_id==$city->id?'selected':''}}>{{$city->name}}</option>
                      @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            <div class=" py-6 w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">الرحلة الي</h2>
                <select name="to_id" class="select2" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                    <option value="">الي</option>
                    @foreach ($governorates as $governorate)
                      <optgroup label="{{$governorate->name}}">
                      @foreach ($governorate->cities as $city)
                        <option value="{{$city->id}}" {{request()->to_id==$city->id?'selected':''}}>{{$city->name}}</option>
                      @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            <div class=" py-6 w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">يوم الرحلة</h2>
                <input type="date" name="day" value="{{request()->day}}" min="{{today()->format('Y-m-d')}}" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" autocomplete="off">
            </div>
            <div class=" py-6  w-full">
                <input type="submit" value="بحث" class="bg-gray-900 text-white  cursor-pointer active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150 focus:ring">
            </div>
        </form>
      </div>
      <div class="lg:w-3/4 md:w-3/4 sm:w-full w-full p-3 rounded-lg">
        @forelse ($trips as $trip)
          <div class="w-full rounded-lg shadow-md px-6 py-6 flex flex-wrap text-center bg-blue-500 mb-3">
            <div class="w-1/6 py-3 mb-2 shadow-lg bg-white rounded-lg">الرحلة من</div>
            <div class="w-1/6 py-3 mb-2">{{$trip->from->name}}</div>
            <div class="w-1/6 py-3 mb-2 shadow-lg bg-white rounded-lg">الي</div>
            <div class="w-1/6 py-3 mb-2 ">{{$trip->to->name}}</div>
            <div class="w-1/6 py-3 mb-2 shadow-lg bg-white rounded-lg">مدة الرحلة</div>
            <div class="w-1/6 py-3 mb-2 ">{{$trip->min_time}} - {{$trip->max_time}} دقيقة</div>
            <div class="w-1/6 py-3 mb-2 shadow-lg bg-yellow-400 rounded-lg">يوم الرحلة</div>
            <div class="w-1/6 py-3 mb-2">{{$trip->dayformat}}</div>
            <div class="w-1/6 py-3 mb-2 shadow-lg bg-yellow-400 rounded-lg">ساعة الانطلاق</div>
            <div class="w-1/6 py-3 mb-2 ">{{$trip->timeformat}}</div>
            <div class="w-1/6 py-3 mb-2 shadow-lg bg-yellow-400 rounded-lg">سعر التذكرة</div>
            <div class="w-1/6 py-3 mb-2 ">{{$trip->price}} جنية</div>
          </div>
        @empty
          <div class="w-full rounded-lg shadow-md py-6 text-center">
             <img src="{{asset('assets/img/nc.jpg')}}" class="px-6 w-100 h-full object-center rounded-lg m-auto" alt="">
             <h1 class="font-bold text-2xl py-3">لا يوجد رحلات من هذا الطريق</h1>
          </div>
        @endforelse
        {{$trips->appends(request()->query())->links()}}
      </div>
    </div>
</div>
@endsection
@section('js')
  <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
  <script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
@endsection
