@extends('layouts.master2')
@section('content')
<section class="text-gray-700 body-font">
    <div class="container flex flex-col items-center px-5 py-16 mx-auto lg:px-20 lg:pt-24 md:flex-row">
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
            <img class="object-cover object-center rounded-lg "
                 alt="hero"
                 src="{{asset('assets/img/undraw_Bus_stop_8ib0.png')}}">
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
@endsection
