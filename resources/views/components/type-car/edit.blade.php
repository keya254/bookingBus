<div id="edittypecar" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">تعديل نوع سيارة</div>
            <div class="modal-body">
                 <form id="etypecar">
                     <div class="form-group">
                       <label for="">اسم السيارة</label>
                       <input type="text" name="name" id="ename" class="form-control" placeholder="اسم السيارة">
                     </div>
                     <div class="form-group">
                        <label for="">عدد المقاعد</label>
                        <input type="number" min="1" name="number_seats" id="enumber_seats" class="form-control" placeholder="عدد المقاعد">
                      </div>
                      <input type="hidden" name="id" id="eid">
                     <div class="form-group text-center">
                         <input type="submit" class="btn btn-primary" value="حفظ">
                     </div>
                 </form>
            </div>
        </div>
    </div>
</div>
