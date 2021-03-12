@extends('layouts.master2')
@section('title')
 تحقق من البريد الالكتروني
@endsection
@section('content')
<section class="relative w-full h-full py-40 min-h-screen">
    <div class="absolute top-0 w-full h-full  bg-full bg-no-repeat"></div>
    <div class="container mx-auto px-4 h-full">
      <div class="flex content-center items-center justify-center h-full">
        <div class="w-full lg:w-4/12 px-4">
          <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
            <div class="rounded-t mb-0 px-6 py-6">
              <div class="text-center mb-3">
                <h6 class="text-gray-600 text-sm font-bold">
                  تحقق من البريد الالكتروني
                </h6>
              </div>
              <div class="btn-wrapper text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            تحقق من رابط في البريد الالكتروني
                        </div>
                    @endif
              </div>
              <hr class="mt-6 border-b-1 border-gray-400">
            </div>
              قبل التحقق تاكيد من بريدك الالكتروني
              <hr>
              لو لم تستلم البريد الالكتروني
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
              <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="text-center mt-6">
                  <button class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150" type="submit">
                    ارسال مرة اخري
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
