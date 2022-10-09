<!-- Modal -->
<div class="modal fade" id="detailsModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <div class="" id="loading_div">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="spinner-border" style="height: 40px; width: 40px; margin: 0 auto; color: #5bcfc5;" role="status"><span class="sr-only">Loading...</span></div>
                    </div>
                </div>
                <div class="profile-personal-info d-none" id="content_div">
                    <div class="mb-2">
                        <img alt="school logo" id="logo" class="rounded mr-sm-4 mr-0" width="130" src="/uploads/no-image.jpg">
                    </div>
                    <h4 class="text-primary mb-2">School Information</h4>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">School Name <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="name"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Registered <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="registered"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Username <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="username"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Motto <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="motto"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Phone <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="phone"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Alternate Phone <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="phone2"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="email"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">website <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="website"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">State <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="state"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">LGA <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="lga"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Address <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="address"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Fee/head/term <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="service_fee"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">No of Students <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="students"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">No of Parents <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="parents"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">No of Staffs <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="staffs"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Fee/Term <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="fee_term"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Service Status <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="status"></span>
                        </div>
                    </div>



                    <h5 class="text-primary">Registered Admin</h5>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Name <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="admin_name"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Email <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="admin_email"></span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Phone <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="admin_phone"></span>
                        </div>
                    </div>
                    <h5 class="text-primary">Registrar</h5>
                    <div class="row mb-2">
                        <div class="col-4">
                            <h5 class="f-w-500">Name <span class="pull-right">:</span>
                            </h5>
                        </div>
                        <div class="col-8"><span id="registrar"></span>
                        </div>
                    </div>
                </div>
                   
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>