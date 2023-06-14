@extends('layouts.app')
@section('PageTitle', 'Comments Entry')


@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-5">
            <div class="col-md">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="card-header header-elements">
                            <span class="me-2">Comments Entry</span>
            
                            <div class="card-header-elements ms-auto">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-sm btn-primary">
                                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add Comments
                                </button>
                            </div>
                        </div>

                       
                        @include('comments.table')
                        

                    </div>
                </div>
                @include('comments.addModal')
                @include('comments.viewCommentsModal')



                <div class="modal fade" id="editCommentModal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title edit-comment-title"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <input type="hidden" id="edit_comment_student_id" name="edit_comment_student_id"/>
                                    <div class="mb-3">
                                        <label for="editComment" class="form-label">Comment</label>
                                        <select name="comment[]" class="form-select" id="editComment">
                                            <option value=""></option>
                                            <optgroup label="High Performers">
                                                <option value="Great work! Your outstanding performance shows your dedication and hard work.">Great work! Your outstanding performance shows your dedication and hard work.</option>
                                                <option value="Impressive! Your consistent top scores reflect your commitment to excellence.">Impressive! Your consistent top scores reflect your commitment to excellence.</option>
                                                <option value="Excellent! Your exceptional results highlight your passion for learning.">Excellent! Your exceptional results highlight your passion for learning.</option>
                                                <option value="Excellent performance! Keep up the great work!">Excellent performance! Keep up the great work!</option>
                                                <option value="Outstanding performance! Congratulations!">Outstanding performance! Congratulations!</option>
                                                <option value="Top-notch performance! Keep aiming high!">Top-notch performance! Keep aiming high!</option>
                                            </optgroup>
                                            <optgroup label="Medium Performers">
                                                <option value="Good effort! Keep up the progress!">Good effort! Keep up the progress!</option>
                                                <option value="Nice going! Your performance is improving.">Nice going! Your performance is improving.</option>
                                                <option value="You are on track! Keep working towards your goals.">You are on track! Keep working towards your goals.</option>
                                                <option value="Good effort! Keep striving for improvement.">Good effort! Keep striving for improvement.</option>
                                                <option value="Nice work! You're making progress.">Nice work! You're making progress.</option>
                                                <option value="Solid performance! Keep it up.">Solid performance! Keep it up.</option>
                                                <option value="Decent effort! Keep pushing yourself.">Decent effort! Keep pushing yourself.</option>
                                            </optgroup>
                                            <optgroup label="Low Performers">
                                                <option value="Room for improvement. Let's work together to enhance your results.">Room for improvement. Let's work together to enhance your results.</option>
                                                <option value="Keep trying! You can do better.">Keep trying! You can do better.</option>
                                                <option value="You have potential! Let's work on boosting your performance.">You have potential! Let's work on boosting your performance.</option>
                                                <option value="Keep persevering! We're here to support you.">Keep persevering! We're here to support you.</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editAdditionalComment" class="form-label">Additional Comment</label>
                                        <input type="text" class="form-control" id="editAdditionalComment">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="saveChangesButton" onclick="saveChanges()">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                

            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="/js/sweetalert.min.js"></script>
@include('comments.script')
@endsection
