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
      <style>
        body{
            font-family: 'Tajawal', sans-serif;
          }
      </style>
  </head>
  <body dir="rtl">
      <div class="text-gray-700 bg-white border-t border-b body-font top-0 fixed z-50 w-full navbar-expand-lg shadow">
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
      </div>
      @yield('content')
  </body>
  <script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  @yield('js')
</html>
