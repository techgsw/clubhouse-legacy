<div class="follow-up-note-modal modal">
    <div class="modal-content">
        <h4 class="contact-name"></h4>
        <div class="row">
            <div class="input-field col s12">
                <form id="create-follow-up-note" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="contact_id" value="" />
                    <textarea id="note" class="validate" rows="6" name="note" placeholder="How did the follow-up go?"></textarea>
                    <button type="button" name="save" class="btn sbs-red submit-follow-up-note-btn float-right">Close</button>
                </form>
                <div class="float-left">
                    <form id="reschedule-contact-follow-up" method="post" class="compact ">
                        {{ csrf_field() }}
                        <input class="hidden" type="text" name="contact_id" value="" />
                        <div style="display: inline-block">
                            <input class="datepicker validate" id="follow-up-date" type="text" name="follow_up_date" value="" style="margin-bottom: 0; text-align: center;" />
                        </div>
                        <button type="submit" name="reschedule" class="btn blue reschedule-contact-follow-up-btn">Reschedule</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
