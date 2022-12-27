<div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-3">
                    <h3 id="title" class="mb-2">Loading...</h3>
                </div>

               
                <div class="my-5" id="details_loading_div">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto;" role="status"></div>
                    </div>
                </div>

                <div class="d-none" id="details_content_div">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Student</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody class="table-border-bottom-0" id="tbody">
                          </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-12 text-center">
                    <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                        aria-label="Close">
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>