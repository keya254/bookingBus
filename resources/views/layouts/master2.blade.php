<!DOCTYPE html>
<html lang="en"class="dark" >
  <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <title>@yield('title')</title>
      <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap" rel="stylesheet">
      @yield('css')
      <style>
        body{
            font-family: 'Tajawal', sans-serif;
          }
      </style>
  </head>
  <body dir="rtl">
      {{--  <div class="text-gray-700 bg-white border-t border-b body-font top-0 fixed z-50 w-full navbar-expand-lg shadow">
            <div class="flex flex-col flex-wrap p-5 mx-auto md:items-center md:flex-row">
                <a href="/" class="pr-2 lg:pr-8 lg:px-6 focus:outline-none">
                    <div class="inline-flex items-center">
                        <div class="w-2 h-2 p-2 mr-2 rounded-full bg-gradient-to-tr from-cyan-400 to-lightBlue-500">
                        </div>
                        <h2
                            class="font-semibold tracking-tighter transition duration-1000 ease-in-out transform text-blueGray-500 dark:text-blueGray-200 lg:text-md text-bold lg:mr-8">
                            رحلتي
                        </h2>
                    </div>
                </a>
                <nav class="flex flex-wrap items-center justify-center text-base ">
                    <a href="#" class="ml-5 text-sm font-semibold text-gray-600 lg:mr-24 hover:text-gray-800">الرحلات المتاحة</a>
                    <a href="#" class="ml-5 text-sm font-semibold text-gray-600 hover:text-gray-800">تواصل معنا</a>
                    <a href="#" class="ml-5 text-sm font-semibold text-gray-600 hover:text-gray-800">الخدمات</a>
                    <a href="#" class="ml-5 text-sm font-semibold text-gray-600 hover:text-gray-800">عن الموقع</a>
                </nav>
                <div class="flex mr-auto">
                    <a  href="{{route('login')}}"
                        class="items-center  px-8 py-2 mr-auto font-semibold text-white transition duration-500 ease-in-out transform bg-black rounded-lg hover:bg-blueGray-900 focus:ring focus:outline-none">تسجيل دخول</a>
                    <a  href="{{route('register')}}"
                        class="items-center px-8 py-2 mr-5 font-semibold text-white transition duration-500 ease-in-out transform bg-black rounded-lg hover:bg-blueGray-900 focus:ring focus:outline-none">
                        انشاء حساب
                    </a>
                </div>
            </div>
      </div>  --}}
      <nav class="relative px-6 py-6 flex justify-between items-center bg-purple-600">
        <a class="text-white text-3xl font-bold leading-none" href="/">
            {{--  <img class="h-12" src="{{asset('assets/img/undraw_Bus_stop_8ib0.png')}}" alt="" width="auto">  --}}
            رحلتي
        </a>
        <div class="lg:hidden">
          <button class="navbar-burger flex items-center text-white p-3">
            <svg class="block h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <title>Mobile menu</title>
              <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
            </svg>
          </button>
        </div>
        {{--  <ul class="hidden absolute top-1/2 left-1/2 transform -translate-y-1/2 -translate-x-1/2 lg:flex lg:mx-auto  lg:items-center lg:w-auto lg:space-x-6">
          <li><a class="text-sm text-gray-300 hover:text-white" href="#">Start</a></li>
          <li class="text-gray-800">
            <svg class="w-4 h-4 current-fill" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
          </li>
          <li><a class="text-sm text-white font-bold" href="#">About Us</a></li>
          <li class="text-gray-800">
            <svg class="w-4 h-4 current-fill" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
          </li>
          <li><a class="text-sm text-gray-300 hover:text-white" href="#">Services</a></li>
          <li class="text-gray-800">
            <svg class="w-4 h-4 current-fill" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
          </li>
          <li><a class="text-sm text-gray-300 hover:text-white" href="#">Platform</a></li>
          <li class="text-gray-800">
            <svg class="w-4 h-4 current-fill" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
            </svg>
          </li>
          <li><a class="text-sm text-gray-300 hover:text-white" href="#">Testimonials</a></li>
        </ul>  --}}
        <a class="hidden lg:block py-2 px-6 bg-pink-600 hover:bg-pink-700 text-sm text-white font-bold rounded-l-xl rounded-t-xl transition duration-200" href="{{route('login')}}">تسجيل دخول</a>
      </nav>
      <div class="hidden navbar-menu relative z-50">
        <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
        <nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm py-6 px-6 bg-white border-r overflow-y-auto">
          <div class="flex items-center mb-8">
            <a class="mr-auto text-3xl font-bold leading-none" href="#"><img class="h-10" src="atis-assets/logo/atis/atis-color-black.svg" alt="" width="auto"></a>
            <button class="navbar-close">
              <svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
          <div>
            {{--  <ul>
              <li class="mb-1"><a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-purple-50 hover:text-purple-600 rounded" href="#">Start</a></li>
              <li class="mb-1"><a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-purple-50 hover:text-purple-600 rounded" href="#">About Us</a></li>
              <li class="mb-1"><a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-purple-50 hover:text-purple-600 rounded" href="#">Services</a></li>
              <li class="mb-1"><a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-purple-50 hover:text-purple-600 rounded" href="#">Platform</a></li>
              <li class="mb-1"><a class="block p-4 text-sm font-semibold text-gray-400 hover:bg-purple-50 hover:text-purple-600 rounded" href="#">Testimonials</a></li>
            </ul>  --}}
          </div>
          <div class="mt-auto">
            <div class="pt-6">
                <a class="block px-4 py-3 mb-2 leading-loose text-xs text-center text-white font-semibold bg-pink-600 hover:bg-pink-700 rounded-l-xl rounded-t-xl" href="{{route('login')}}">تسجيل دخول</a></div>
          </div>
        </nav>
      </div>
      @yield('content')
  </body>
  <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
    // open
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');

    if (burger.length && menu.length) {
        for (var i = 0; i < burger.length; i++) {
            burger[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    // close
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');

    if (close.length) {
        for (var i = 0; i < close.length; i++) {
            close[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }

    if (backdrop.length) {
        for (var i = 0; i < backdrop.length; i++) {
            backdrop[i].addEventListener('click', function() {
                for (var j = 0; j < menu.length; j++) {
                    menu[j].classList.toggle('hidden');
                }
            });
        }
    }
    });
  </script>
  @yield('js')
</html>
