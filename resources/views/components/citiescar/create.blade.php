<div id="createcarcities" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  border-0">
            <div class="modal-header">انشاء رحلة</div>
            <div class="modal-body">
                 <form id="ccarcities" class="row">
                     <div class="form-group col-6">
                        <label for="">السيارة</label>
                        <select name="car_id" class="form-control">
                           @foreach ($cars as $car)
                            <option value="{{$car->id}}">{{$car->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-6">
                        <select name="city_id" class="select2" class="px-3 py-3 placeholder-gray-400 text-gray-700 bg-white rounded text-sm shadow focus:outline-none focus:shadow-outline w-full ease-linear transition-all duration-150">
                           <option value="">المدينة</option>
                           @foreach ($governorates as $governorate)
                             <optgroup label="{{$governorate->name}}">
                             @foreach ($governorate->cities as $city)
                               <option value="{{$city->id}}" {{request()->to_id==$city->id?'selected':''}}>{{$city->name}}</option>
                             @endforeach
                           </optgroup>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group text-center col-12">
                        <input type="submit" class="btn btn-primary" value="حفظ">
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>
