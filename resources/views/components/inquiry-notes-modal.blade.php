<div class="inquiry-notes-modal modal modal-large modal-fixed-footer">
    <div class="modal-content" style="height: calc(100% - 160px);"></div>
    <div class="modal-footer" style="height: auto;">
        <div class="row">
            <div class="input-field col s12">
                <form id="create-inquiry-note" method="post">
                    {{ csrf_field() }}
                    <textarea id="note" name="note" placeholder="New note"></textarea>
                    <input type="hidden" name="inquiry_id" value="" />
                    <button type="button" name="save" class="btn sbs-red submit-inquiry-note-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style media="screen">
    textarea#note {
        padding: 8px 12px;
        border: 1px solid #DDD !important;
        height: auto;
        border-radius: 4px;
    }
    textarea#note:focus {
        outline: none;
        border: 1px solid #AAA !important;
        box-shadow: none !important;
    }
</style>
