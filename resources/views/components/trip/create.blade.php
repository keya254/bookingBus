<div id="createtrip" class="modal fade">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  border-0">
            <div class="modal-header">انشاء رحلة</div>
            <div class="modal-body">
                 <form id="ctrip" class="row">
                     <div class="form-group col-6" >
                       <label for="">الرحلة من</label>
                        <select name="from_id" class="select2 form-control">
                            <option value="">من</option>
                            @foreach ($governorates as $governorate)
                              <optgroup label="{{$governorate->name}}">
                              @foreach ($governorate->cities as $city)
                                <option value="{{$city->id}}" {{request()->to_id==$city->id?'selected':''}}>{{$city->name}}</option>
                              @endforeach
                            </optgroup>
                           @endforeach
                       </select>
                     </div>
                     <div class="form-group col-6">
                        <label for="">الرحلة الي</label>
                        <select name="to_id" class="select2 form-control">
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
                      <div class="form-group col-6">
                        <label for="">يوم الرحلة</label>
                        <input type="date" name="day"  class="form-control" placeholder="يوم الرحلة">
                      </div>
                      <div class="form-group col-6">
                        <label for="">بداية الرحلة</label>
                        <input type="time" name="start_time"  class="form-control" placeholder="بداية الرحلة">
                      </div>
                     <div class="form-group col-6">
                        <label for="">سعر مقعد الرحلة</label>
                        <input type="text"  name="price"  class="form-control" placeholder="سعر مقعد الرحلة">
                      </div>
                      <div class="form-group col-6">
                        <label for="">اقل وقت للرحلة</label>
                        <input type="number" name="min_time"  class="form-control" placeholder="اقل وقت للرحلة">
                      </div>
                      <div class="form-group col-6">
                        <label for="">اكثر وقت للرحلة</label>
                        <input type="number" name="max_time"  class="form-control" placeholder="اكثر وقت للرحلة">
                      </div>
                      <div class="form-group col-6">
                        <label for="">اقصي عدد من المقاعد يمكن حجزها</label>
                        <input type="text" name="max_seats"  class="form-control">
                      </div>
                     <div class="form-group col-6">
                        <label for="">السيارة</label>
                        <select name="car_id" class="form-control">
                           @foreach ($cars as $car)
                            <option value="{{$car->id}}">{{$car->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-6">
                        <label for="">السائق</label>
                        <select name="driver_id" class="form-control">
                           @foreach ($drivers as $driver)
                            <option value="{{$driver->id}}">{{$driver->name}}</option>
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
