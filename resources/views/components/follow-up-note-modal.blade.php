<div class="follow-up-note-modal modal modal-large modal-fixed-footer" style="max-height: 250px;">
    <div class="row">
        <div class="input-field col s12">
            <form id="create-follow-up-note" method="post">
                {{ csrf_field() }}
                <textarea id="note" style="min-height: 150px" name="note" placeholder="New note"></textarea>
                <input type="hidden" name="contact_id" value="" />
                <button type="button" name="save" class="btn sbs-red submit-follow-up-note-btn float-right">Done</button>
            </form>
        </div>
    </div>
</div>
