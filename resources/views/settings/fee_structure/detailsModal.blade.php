<!-- Modal -->
<div class="modal fade" id="detailsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loading . . .</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="" id="loading_div">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto; color: #5bcfc5;" role="status"><span class="sr-only">Loading...</span></div>
                    </div>
                </div>
    
                <div id="content_div" class="table-responsive d-none">
                    <table class="table table-bordered table-sm" style="width: 100%">
                        <thead>
                            <th>Fee Category</th>
                            <th>Priority</th>
                            <th>Amount</th>
                        </thead>
                        <tbody id="fee_list"></tbody>
                    </table>
                </div>
                   
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>