@extends('layouts.master2')
@section('title')
 بحث
@endsection
@section('css')
  <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css')}}">
  <style>
    /* .img-hor-vert {

      -moz-transform: scale(-1, 1);
      -o-transform: scale(-1, 1);
      -webkit-transform: scale(-1, 1);
      transform: scale(-1, 1);
    } */

    .numberseat
    {
      margin-top: -0.5rem;
      margin-right: -15px;
      position: absolute;
      text-align: right;
      z-index: 20;
    }

  </style>
@endsection
@section('content')
<div class="container px-5 py-16 mx-auto lg:px-20 lg:pt-24 pt-20">
    <div class="flex flex-wrap text-center ">
      <div class="lg:w-1/4 md:w-1/4 sm:w-full w-full shadow-md px-8 rounded-lg">
        <form method="get" action="/search" class="flex flex-wrap text-center bg-white rounded-md">
            <div class="py-6 w-full">
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
            <div class=" py-6 w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">الرحلة الي</h2>
                <select name="to_id" class="select2" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                    <option value="">الي</option>
                    @foreach ($governorates as $governorate)
                      <optgroup label="{{$governorate->name}}">
                      @foreach ($governorate->cities as $city)
                        <option value="{{$city->id}}" {{request()->to_id==$city->id?'selected':''}}>{{$city->name}}</option>
                      @endforeach
                    </optgroup>
                    @endforeach
                </select>
            </div>
            <div class=" py-6 w-full">
                <h2 class="mb-3 text-lg font-semibold text-gray-700 lg:text-2xl title-font">يوم الرحلة</h2>
                <input type="date" name="day" value="{{request()->day}}" min="{{today()->format('Y-m-d')}}" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150" autocomplete="off">
            </div>
            <div class=" py-6  w-full">
                <input type="submit" value="بحث" class="bg-gray-900 text-white  cursor-pointer active:bg-gray-700 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150 focus:ring">
            </div>
        </form>
      </div>
      <div class="lg:w-3/4 md:w-3/4 sm:w-full w-full p-3 rounded-lg text-center">
        @forelse ($trips as $trip)
          <div class="w-full rounded-lg shadow-md px-6 py-6 flex flex-wrap text-center bg-purple-600 mb-3">
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 shadow-lg bg-white rounded-lg">الرحلة من</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2">{{$trip->from->name}}</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 shadow-lg bg-white rounded-lg">الي</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 ">{{$trip->to->name}}</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 shadow-lg bg-white rounded-lg">مدة الرحلة</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 ">{{$trip->min_time}} - {{$trip->max_time}} دقيقة</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 shadow-lg bg-yellow-200 rounded-lg">يوم الرحلة</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2">{{$trip->day_trip}}</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 shadow-lg bg-yellow-200 rounded-lg">ساعة الانطلاق</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 ">{{$trip->time_trip}}</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 shadow-lg bg-yellow-200 rounded-lg">سعر التذكرة</div>
            <div class="lg:w-1/6 md:w-1/2 sm:w-1/2 w-1/2 py-1 mb-2 ">{{$trip->price}} جنية</div>
            <div class="lg:w-1/4 md:w-1/2 sm:w-1/2 w-1/2 py-2 mb-2 shadow-lg bg-blue-200 rounded-lg">مالك السيارة</div>
            <div class="lg:w-1/4 md:w-1/2 sm:w-1/2 w-1/2 py-2 mb-2 ">{{$trip->car->owner->name}}</div>
            <div class="lg:w-2/4 md:w-full sm:w-full w-full py-2 mb-2">
                <a class="bg-red-500 shadow-lg py-2 px-8 rounded-lg w-full cursor-pointer booking" href="javascript:void(0)" data-id="{{$trip->id}}">اختر المقاعد</a>
            </div>
          </div>
          <div class="w-full rounded-lg shadow-md px-6 py-6 text-center hidden bg-pink-600 mb-3 trip" id="trip-{{$trip->id}}">
          </div>
        @empty
          <div class="w-full rounded-lg py-6 text-center">
             <img src="{{asset('assets/img/nc.jpg')}}" class="px-6 w-100 h-full object-center rounded-lg m-auto" alt="">
             <h1 class="font-bold text-2xl py-3">لا يوجد رحلات من هذا الطريق</h1>
          </div>
        @endforelse
        {{$trips->appends(request()->query())->links()}}
      </div>
    </div>
    <div id="recaptcha-container"></div>
</div>
@endsection
@section('js')
  <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
  <script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!--Internal Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<script src="{{URL::asset('assets/js/seats.js')}}"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-app.js"></script>
  <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
  <script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-analytics.js"></script>

  <!-- Add Firebase products that you want to use -->
  <script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-firestore.js"></script>
  <script src="{{URL::asset('assets/js/firebase.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.booking').click(function (e) {
        e.preventDefault();
        var id=$(this).attr('data-id');
        if($(this).hasClass('bg-red-500')){
          $('.booking').removeClass('bg-yellow-500');
          $('.booking').addClass('bg-red-500');
          $(this).removeClass('bg-red-500');
          $(this).addClass('bg-yellow-500');
          seat(id);
        }
        else
        {
          $('.trip').addClass('hidden');
          $('#trip-'+id).addClass('hidden');
          $('.booking').removeClass('bg-yellow-500');
          $(this).addClass('bg-red-500');
        }
    });
    function seat(id)
    {
      $.ajax({
          type: "post",
          url: "{{route('seats')}}",
          data: {id:id},
          dataType: "json",
          success: function (response) {
             $('.trip').addClass('hidden');
             $('#trip-'+id).toggleClass('hidden');
            set=new seats(response.trip.id,response.trip.max_seats,response.seats);
            $('#trip-'+id).html(set.getall());
          }
      });
    }
    $(document).on('click','.seat',function(){
        set.storeselected(this,$(this).attr('data-id'));
        $('#trip-'+set.trip).html(set.getall());
    });
    $(document).on('click','.bookingnow',function(){
        form=
        '<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">'+
          '<form id="formbooking">'+
          '<div class="-mx-3 md:flex mb-6">'+
            '<div class="md:w-1/2 px-3 mb-6 md:mb-0">'+
              '<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name">الاسم</label>'+
              '<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="name" type="text" placeholder="الاسم" required>'+
            '</div>'+
            '<div class="md:w-1/2 px-3">'+
              '<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-last-name">رقم الهاتف</label>'+
              '<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4" id="phone_number" type="text" placeholder="رقم الهاتف" required>'+
            '</div>'+
          '</div>'+
          '<div class="-mx-3 md:flex mb-6">'+
            '<div class="md:w-full px-3 mb-6 md:mb-0">'+
               '<input type="submit" class="bg-red-700 p-3 cursor-pointer m-2 rounded-md shadow-md" value="حفظ">'+
            '</div>'+
          '</div>'+
          '</form>'+
        '</div>';
        $('#trip-'+$(this).attr('data-id')).html(form);
    });
    $(document).on('submit','#formbooking',function(e){
        e.preventDefault();
        var name=$('#name').val();
        var phone_number=$('#phone_number').val();
        if(name =='' || name.length < 5)
        {
           alert('خطئ ما حدث في حقل الاسم');
           return false;
        }
        myarray=['0','1','2','5'];
         if(phone_number =='' || phone_number.length != 11 || ! myarray.includes(phone_number.charAt(2)) || phone_number.charAt(1) !=1 || phone_number.charAt(0) !=0)
        {
           alert('خطئ ما حدث في حقل رقم الهاتف');
           return false;
        }
        $('#trip-'+set.trip).addClass('spinner-border');
        localStorage.setItem('name',name);
        localStorage.setItem('phone_number',phone_number);
        fire =new MyFirebase();
        fire.initialize();
        fire.refreshrecaptch();
        formcode='';
        getformcode();
        fire.getphonenumber(phone_number,formcode);

     });
     function getformcode()
     {
        formcode+=
        '<div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">'+
          '<form id="formcode">'+
          '<div class="-mx-3 md:flex mb-6 text-center">'+
            '<div class="md:w-1/2 px-3 mb-6 md:mb-0">'+
              '<label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-first-name">الكود</label>'+
              '<input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" id="code" type="text" placeholder="الكود" required>'+
              '<span id="messagecode"></span>'+
            '</div>'+
          '</div>'+
          '<div class="-mx-3 md:flex mb-6">'+
            '<div class="md:w-full px-3 mb-6 md:mb-0">'+
               '<input type="submit" class="bg-red-700 p-3 cursor-pointer m-2 rounded-md shadow-md" value="ارسال">'+
            '</div>'+
          '</div>'+
          '</form>'+
        '</div>';
     }
     $(document).on('submit','#formcode',function(e){
        e.preventDefault();
       code= $('#code').val();
        if (code.length==6) {
            fire.verifycode(code);
        }
     });
</script>
@endsection
