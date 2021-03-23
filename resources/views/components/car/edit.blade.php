<div id="editcar" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">تعديل سيارة</div>
            <div class="modal-body">
                 <form id="ecar" enctype="multipart/form-data">
                     <div class="form-group">
                       <label for="">اسم السيارة</label>
                       <input type="text" name="name" id="ecarname"  class="form-control" placeholder="اسم السيارة">
                     </div>
                     <div class="form-group">
                        <label for="">نوع السيارة</label>
                        <select name="typecar_id" id="etypecar_id"  class="form-control">
                           @foreach ($typecars as $typecar)
                            <option value="{{$typecar->id}}">{{$typecar->name}}</option>
                           @endforeach
                        </select>
                      </div>
                     <div class="form-group">
                        <label for="">صورة السيارة</label>
                        <input type="file" name="image">
                     </div>
                     <div class="form-group">
                        <label for="">رقم الهاتف</label>
                        <input type="text" name="phone_number" class="form-control">
                     </div>
                     <div class="form-group">
                        <p>يعمل عامة</p>
                        <input type="radio" name="public" value="1"> يعمل
                        <input type="radio" name="public" value="0"> لا يعمل
                     </div>
                     <div class="form-group">
                        <p>يعمل مخصوص</p>
                        <input type="radio" name="private" value="1"> يعمل
                        <input type="radio" name="private" value="0"> لا يعمل
                     </div>
                     <input type="hidden" id="ecarid" name="id">
                     <div class="form-group text-center">
                         <input type="submit" class="btn btn-primary" value="حفظ">
                     </div>
                 </form>
            </div>
        </div>
    </div>
</div>
