<div class="contact-notes-modal modal modal-large modal-fixed-footer">
    <div class="modal-content" style="height: calc(100% - 149.5px);">
        <h4 class="contact-name hidden" style="position: static;"></h4>
        <div class="contact-notes-container"></div>
    </div>
    <div class="modal-footer" style="height: auto; padding: 0 20px;">
        <div id="note-actions" class="row">
            <div class="input-field col s12">
                <form id="create-contact-note" method="post">
                    {{ csrf_field() }}
                    <input id="contact-id" type="hidden" name="contact_id" value="" />
                    <textarea id="note" name="note" placeholder="What's the latest?"></textarea>
                    <button type="button" id="submit-contact-note" name="save" class="btn sbs-red">Save</button>
                    <div class="follow-up-controls">
                        <div style="display: inline-block;">
                            <input class="datepicker hidden" id="follow-up-date" type="text" name="follow_up_date" value="" style="margin-bottom: 0; text-align: center;" />
                        </div>
                        <button type="button" id="schedule-follow-up" class="btn blue hidden">Schedule</button>
                        <button type="button" id="reschedule-follow-up" class="btn blue hidden">Reschedule</button>
                        <button type="button" id="close-follow-up" class="btn green hidden">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="note-progress" class="row hidden" style="height: 149.5px; margin: 0; padding: 40px;">
            <div class="input-field col s12">
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>
    </div>
</div>
