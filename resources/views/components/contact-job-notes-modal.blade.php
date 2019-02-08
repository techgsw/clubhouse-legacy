<div class="contact-job-notes-modal modal modal-large modal-fixed-footer">
    <div class="modal-content" style="height: calc(100% - 160px);"></div>
    <div class="modal-footer" style="height: auto;">
        <div class="row">
            <div class="input-field col s12">
                <form id="create-contact-job-note" method="post">
                    {{ csrf_field() }}
                    <textarea id="note" name="note" placeholder="New note"></textarea>
                    <input type="hidden" name="contact_job_id" value="" />
                    <button type="button" name="save" class="btn sbs-red submit-contact-job-note-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
