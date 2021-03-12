@extends('layouts.master2')
@section('title')
  احجزلي
@endsection
@section('css')
  <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@endsection
@section('content')
<section class="skewed-bottom-right">
    <div class="bg-purple-600 pt-12 lg:pt-20 pb-20 radius-for-skewed">
      <div class="container mx-auto px-4">
        <div class="flex flex-wrap -mx-4">
          <div class="w-full lg:w-1/2 px-4 mb-12 md:mb-20 lg:mb-0 flex items-center">
            <div class="w-full text-center lg:text-right">
              <div class="max-w-md mx-auto lg:mx-0">
                <h2 class="mb-3 text-4xl lg:text-5xl text-white font-bold">
                  <span>احجز الان رحلتك </span>
                  <span class="text-yellow-200">عن طريق الانترنت</span>
                </h2>
              </div>
            </div>
          </div>
          <div class="w-full lg:w-1/2 px-4 flex items-center justify-center">
            <div class="relative" style="z-index: 0;"><img class="h-128 w-full max-w-lg object-cover rounded-3xl md:rounded-br-none" src="{{asset('assets/img/undraw_Bus_stop_8ib0.png')}}" alt=""></div>
          </div>
        </div>
      </div>
    </div>
    <div class="mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-purple-600" viewBox="0 0 10 10" preserveAspectRatio="none">
          <polygon fill="currentColor" points="0 0 10 0 0 10"></polygon>
        </svg>
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
    <div class="mr-for-radius">
        <svg class="h-8 md:h-12 lg:h-20 w-full text-purple-600" viewBox="0 0 10 10" preserveAspectRatio="none">
          <polygon fill="currentColor" points="0 0 10 0 0 10"></polygon>
        </svg>
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
