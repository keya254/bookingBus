<div id="editcity" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">تعديل مدينة</div>
            <div class="modal-body">
                 <form id="ecity">
                     <div class="form-group">
                       <label for="">اسم المدينة</label>
                       <input type="text" name="name"  id="ename" class="form-control" placeholder="اسم المدينة" value="">
                       <small id="name" class="text-muted"></small>
                     </div>
                     <div class="form-group">
                        <label for="">المحافظة</label>
                        <select name="governorate_id" class="form-control">
                           @foreach ($governorates as $governorate)
                            <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                           @endforeach
                        </select>
                      </div>
                     <div class="form-group text-center">
                         <input type="hidden" id="eid">
                         <input type="submit" class="btn btn-primary" value="حفظ">
                     </div>
                 </form>
            </div>
        </div>
    </div>
</div>
