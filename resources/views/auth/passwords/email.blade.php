@extends('layouts.master2')
@section('title')
اعادة تعين كلمة المرور
@endsection
@section('content')
<section class="relative w-full h-full py-40 min-h-screen">
    <div class="absolute top-0 w-full h-full bg-gray-900 bg-full bg-no-repeat" style="background-image: url({{asset('assets/img/register_bg_2.png')}});"></div>
    <div class="container mx-auto px-4 h-full">
      <div class="flex content-center items-center justify-center h-full">
        <div class="w-full lg:w-4/12 px-4">
          <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-gray-300 border-0">
            <div class="rounded-t mb-0 px-6 py-6">
              <div class="text-center mb-3">
                <h6 class="text-gray-600 text-sm font-bold">
                    اعادة تعين كلمة المرور
                </h6>
              </div>
              <div class="btn-wrapper text-center">
                    @if (session('status'))
                       <div class="alert alert-success" role="alert">
                           {{ session('status') }}
                       </div>
                    @endif
              </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
              <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <input id="email" type="email" placeholder="البريد الالكتروني" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="text-center mt-6">
                  <button class="bg-gray-900 text-white active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150" type="submit">
                    ارسال رابط لاعادة تعين كلمة المرور
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
