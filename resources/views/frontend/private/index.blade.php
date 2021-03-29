@extends('layouts.master2')
@section('title')
السيارات المخصوص
@endsection
@section('content')
<div class="container px-5 py-16 mx-auto lg:px-20 lg:pt-24 pt-20">

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
                  <p class="text-gray-700 text-base">
                  </p>
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
           <h1 class="font-bold text-2xl py-3">لا يوجد رحلات من هذا الطريق</h1>
        </div>
      @endforelse
    </div>
    {{$cars->appends(request()->query())->links()}}
</div>
@endsection
