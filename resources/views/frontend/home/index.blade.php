@extends('layouts.master2')
@section('title')
  احجزلي
@endsection
@section('css')
  <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@endsection
@section('content')
<section class="text-gray-700 body-font">
    <div class="container flex flex-col items-center px-5 py-16 mx-auto lg:px-20 lg:pt-24 md:flex-row ">
        <div class="flex flex-col items-center w-full pt-0 mb-16 text-right lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 md:items-start md:text-left md:mb-0 lg:text-center">
            <h1 class="mb-8 text-2xl font-bold tracking-tighter text-center text-black lg:text-right lg:text-5xl title-font">
               احجز الان رحلتك عن طريق الانترنت
            </h1>
            <p class="mb-8 text-base leading-relaxed text-center text-gray-700 lg:text-right lg:text-1xl">
                {{--  Deploy your mvp in minutes, not days. WT offers you a a wide selection swapable sections for
                your landing page.  --}}
            </p>
        </div>
        <div class="w-5/6 lg:max-w-lg lg:w-full md:w-1/2 h-full">
            <img class="object-cover object-center rounded-lg " alt="hero" src="{{asset('assets/img/undraw_Bus_stop_8ib0.png')}}">
        </div>
    </div>
</section>
<section class="text-gray-700 body-font">
    <div class="container px-8 mx-auto pb-36 lg:px-4">
        <div class="flex flex-wrap text-center">
            <div class="px-8 py-6 lg:w-1/4 md:w-1/2 sm:w-1/2">
                <img class="object-cover object-center w-full h-60 mb-6 rounded-xl shadow-md overflow-hidden" src="{{asset('assets/img/undraw_Location_search_re_ttoj.png')}}" alt="content">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font"> ابحث عن المكان والمعاد</h2>
            </div>
            <div class="px-8 py-6 lg:w-1/4 md:w-1/2 sm:w-1/2">
                <img class="object-cover object-center w-full h-60 mb-6 rounded-xl shadow-md overflow-hidden" src="{{asset('assets/img/undraw_Booking_re_gw4j.png')}}" alt="content">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font"> احجز رحلتك</h2>
            </div>
            <div class="px-8 py-6 lg:w-1/4 md:w-1/2 sm:w-1/2">
                <img class="object-cover object-center w-full h-60 mb-6 rounded-xl shadow-md overflow-hidden" src="{{asset('assets/img/undraw_two_factor_authentication_namy.png')}}" alt="content">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font"> تحقق من الكود</h2>
            </div>
            <div class="px-8 py-6 lg:w-1/4 md:w-1/2 sm:w-1/2">
                <img class="object-cover object-center w-full h-60 mb-6 rounded-xl shadow-md overflow-hidden" src="{{asset('assets/img/undraw_confirmed_81ex.png')}}" alt="content">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font"> اكتمال الحجز</h2>
            </div>
        </div>
    </div>
</section>
<section class="text-gray-700 body-font">
    <div class="container px-8 mx-auto pb-36 lg:px-4">
        <form method="get" action="/search" class="flex flex-wrap text-center bg-white rounded-md shadow-md">

            <div class="px-8 py-6 lg:w-1/3 md:w-1/3 sm:w-full w-full">
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
            <div class="px-8 py-6 lg:w-1/3 md:w-1/3 sm:w-full w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">الرحلة الي</h2>
                <select name="to_id" class="select2" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                    <option value="">الي</option>
                    @foreach ($governorates as $governorate)
                      <optgroup label="{{$governorate->name}}">
                      @foreach ($governorate->cities as $city)
                        <option value="{{$city->id}}" {{request()->from_id==$city->id?'selected':''}}>{{$city->name}}</option>
                      @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="px-8 py-6 lg:w-1/3 md:w-1/3 sm:w-full w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">يوم الرحلة</h2>
                <input type="date" name="day" min="{{today()->format('Y-m-d')}}" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" autocomplete="off" required>
            </div>
            <div class="px-8 py-6 lg:w-full md:w-full sm:w-full w-full">
                <input type="submit" value="بحث" class="bg-gray-900 text-white  cursor-pointer active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150 focus:ring">
            </div>
        </form>
    </div>
</section>
@endsection
@section('js')
  <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
  <script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
@endsection
@section('js')
    <script>
        $('#to').keyup(function(){
          var to =$(this).val();
          var from =$('#from').val();
          console.log(' من '+from+' الي '+to);
        });
        $('#from').keyup(function(){
          var from =$(this).val();
          var to =$('#to').val();
          console.log(' من '+from+' الي '+to);
        });
    </script>
@endsection
