@extends('layouts.master2')
@section('title')
تسجيل دخول
@endsection
@section('content')
<section class="relative w-full h-full py-40 min-h-screen">
    <div class="absolute top-0 w-full h-full bg-full bg-no-repeat"></div>
    <div class="container mx-auto px-4 h-full">
      <div class="flex content-center items-center justify-center h-full">
        <div class="w-full lg:w-4/12 px-4">
          <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
            <div class="rounded-t mb-0 px-6 py-6">
              <div class="text-center mb-3">
                <h6 class="text-gray-600 text-sm font-bold">
                  تسجيل دخول
                </h6>
              </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="relative w-full mb-3">
                  <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">البريد الالكتروني</label>
                  <input type="email" name="email" value="{{ old('email') }}" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" placeholder="البريد الالكتروني" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="relative w-full mb-3">
                  <label class="block uppercase text-gray-700 text-xs font-bold mb-2" for="grid-password">كلمة المرور</label>
                  <input type="password" name="password" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" placeholder="كلمة المرور" required>
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                </div>
                <div>
                  <label class="inline-flex items-center cursor-pointer"><input id="remember" {{ old('remember') ? 'checked' : '' }} name="remember" type="checkbox" class="form-checkbox text-gray-800 ml-1 w-5 h-5 ease-linear transition-all duration-150"><span class="ml-2 text-sm font-semibold text-gray-700">ذكرني</span></label>
                </div>
                <div class="text-center mt-6">
                  <button class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150" type="submit">
                    تسجيل دخول
                  </button>
                </div>
              </form>
              <div class="flex flex-wrap mt-6">
                <div class="w-1/2">
                  <a href="{{ route('password.request') }}" class="text-blue"><small>نسيت كلمة السر ؟</small></a>
                </div>
                <div class="w-1/2 text-left">
                  {{--  <a href="{{route('register')}}" class="text-blue"><small>انشاء حساب</small></a>  --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
