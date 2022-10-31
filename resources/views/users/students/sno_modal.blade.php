<!-- Modal -->
<div class="modal fade" id="sno_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sno_modal_title">Loading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <form id="sno_form">
                <div class="modal-body">


                    <div class="" id="sno_loading_div">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto; color: #5bcfc5;" role="status"><span class="sr-only">Loading...</span></div>
                        </div>
                    </div>

                    <div class="d-none" id="sno_content_div">
                        <select class="multi-select" name="states[]" id="sno_id" multiple="multiple">
                           
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="sno_btn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>