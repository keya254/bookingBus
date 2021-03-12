@extends('layouts.master2')
@section('name')
تاكيد كلمة المرور
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
                    تاكيد كلمة المرور
                </h6>
              </div>
              من فضلك اكد كلمة المرور قبل الاستمرار
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
              <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <input id="password" type="password" placeholder="كلمة المرور" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="text-center mt-6">
                  <button class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150" type="submit">
                    تاكيد كلمة المرور
                  </button>
                   @if (Route::has('password.request'))
                       <a class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150" href="{{ route('password.request') }}">
                           نسيت كلمة المرور
                       </a>
                   @endif
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
