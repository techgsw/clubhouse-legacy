<div class="follow-up-note-modal modal">
    <div class="modal-content">
        <form id="create-follow-up-note" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="input-field col s12">
                    <input type="hidden" name="contact_id" value="" />
                    <textarea id="note" rows="6" name="note" placeholder="How did the follow-up go?"></textarea>
                    <button type="button" name="save" class="btn sbs-red submit-follow-up-note-btn float-right">Close follow-up</button>
                </div>
            </div>
        </form>
    </div>
</div>
