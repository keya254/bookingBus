@extends('layouts.master2')
@section('title')
السيارات المخصوص
@endsection
@section('css')
  <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
@endsection
@section('content')
<div class="container px-5 py-16 mx-auto lg:px-20 lg:pt-24 pt-20">
    <form method="get" action="/private" class="flex flex-wrap text-center bg-white rounded-md pt-2">
        <div class="w-4/5 p-3">
             <select name="city_id" class="select2" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                 <option value="">المدينة</option>
                 @foreach ($governorates as $governorate)
                   <optgroup label="{{$governorate->name}}">
                   @foreach ($governorate->cities as $city)
                     <option value="{{$city->id}}" {{request()->city_id==$city->id?'selected':''}}>{{$city->name}}</option>
                   @endforeach
                 </optgroup>
                 @endforeach
             </select>
        </div>
        <div class="w-1/5 p-1">
            <input type="submit" value="بحث" class="bg-gray-900 text-white  cursor-pointer active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150 focus:ring">
        </div>
    </form>
    <div class="m-auto flex flex-wrap flex-col md:flex-row items-center justify-start">
      @forelse ($cars as $car)
        <div class="lg:w-1/2 md:w-1/2 sm:w-full w-full my-4 px-4 lg:max-w-full">
         <div class="full lg:max-w-full lg:flex rounded-lg shadow-lg">
            <div class="h-48 lg:h-auto lg:w-48 flex-none bg-cover text-center overflow-hidden" style="background-image: url('{{asset($car->image)}}')" title="Mountain">
            </div>
            <div class="bg-white p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                  <p class="text-sm text-gray-600 flex items-center ml-2">
                    رحلات خاصة
                  </p>
                  <div class="text-gray-900 font-bold text-xl mb-2">الأماكن المتاحة للسيارة</div>
                  <div class="">
                      @foreach ($car->cities as $city)
                        <a href="javascript::void(0)" class="bg-red-900 text-white cursor-pointer
                         active:bg-gray-700 text-sm font-bold uppercase p-1 rounded
                          shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-3
                          w-full ease-linear transition-all duration-150 focus:ring">{{$city->name}}</a>
                      @endforeach
                  </div>
                </div>
                <div class="flex items-center">
                  <img class="w-10 h-10 rounded-full mr-4" src="{{asset($car->owner->image)}}" alt="{{$car->owner->name}}">
                  <div class="text-sm">
                    <p class="text-gray-900 leading-none">{{$car->owner->name}}</p>
                    <p class="text-black leading-none">{{$car->phone_number}}</p>
                  </div>
                </div>
            </div>
         </div>
        </div>
        @empty
        <div class="w-full rounded-lg py-6 text-center">
           <img src="{{asset('assets/img/nc.jpg')}}" class="px-6 w-100 h-full object-center rounded-lg m-auto" alt="">
           <h1 class="font-bold text-2xl py-3">لا يوجد سيارات متاحة لهذا الطريق الان</h1>
        </div>
      @endforelse
    </div>
    {!!$cars->appends(request()->query())->links()!!}
</div>
@endsection
@section('js')
  <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
  <script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
