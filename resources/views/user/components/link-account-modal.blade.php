<div class="link-account-modal modal modal-large modal-fixed-footer">
    <div class="modal-content">
        <h4>Link an account</h4>
        <p>You can link one or more duplicate accounts to this one by entering the duplicate account's email below. Linking will make this account the primary account.</p>
        <p>If we found other accounts matching the user's name, we've included their email addresses below. Feel free to remove them if they aren't actually duplicates.</p>
        <form id="link-account-form" method="POST" action="/admin/user/link-accounts">
            {{ csrf_field() }}
            <div class="linked-account row">
                <div class="row">
                    <div class="col s2 l1 center-align">
                        <button class="btn flat-button remove-linked-account" style="margin-top:10px;height: 42px;">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="col s10 l11">
                        <div class="input-field col s12 m6">
                            <input id="email" name="email[]" type="text" value="" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="add-linked-account row" style="margin-bottom: 30px; border-top: 1px dotted #9e9e9e; border-bottom: none;">
                <div class="col s2 l1 center-align">
                    <button class="btn flat-button add-linked-account" style="margin-top:10px;height: 42px;">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="linked-account-template hidden">
                <div class="linked-account row">
                    <div class="row">
                        <div class="col s2 l1 center-align">
                            <button class="btn flat-button remove-linked-account" style="margin-top:10px;height: 42px;">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="col s10 l11">
                            <div class="input-field col s12 m6">
                                <input id="email" name="email[]" type="text" value="" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-field col s12">
                <button id="link-account-submit" type="submit" class="btn sbs-red">Link Accounts</button>
            </div>
            <input type="hidden" id="primary_user_id" name="primary_user_id" value="" required>
        </form>
    </div>
</div>
