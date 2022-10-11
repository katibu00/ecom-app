<div class="modal fade" id="viewCommentsModal">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title viewTitle">Loading. . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
         
                <div class="modal-body" style="min-height: 30vh">
                
                    
                    <div class="col-xl-12">
                        <div class="mb-2 row">
                            <div class="col-lg-4">
                                <select class="default-select form-control wide mb-3" id="view_officer">
                                    <option value="">--Select Officer--</option>
                                    <option value="fm">Form Master</option>
                                    <option value="p">Principal/Director</option>
                                </select>
                            </div>
                        </div>
                    </div>
                  <input type="hidden" id="view_class_id"/>

                    <div class="d-none" id="loading_div">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto; color: #5bcfc5;" role="status"><span class="sr-only">Loading...</span></div>
                        </div>
                    </div>


                   <div id="content_div" class="table-responsive d-none">

                    <table class="table table-bordered table-striped" style="width: 100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Roll Number</th>
                                <th>Student Name</th>
                                <th>Comment</th>

                            </tr>
                        </thead>
                        <tbody id="comments-generate-tr">

                        </tbody>
                    </table>

                   </div>
                
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                </div>
        </form>
        </div>
    </div>
</div>