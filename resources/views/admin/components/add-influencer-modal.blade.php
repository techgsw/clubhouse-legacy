<div id="register-modal" class="register-modal modal modal-large">
    <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;"><i class="fa fa-window-close"></i></button>
    <a name="register"></a>
    <div class="row hero gray" style="padding-top: 30px; padding-bottom: 10px;">
        <div class="col s12">
            <h3 class="header">Add a New Influencer</h3>
        </div>
    </div>
    <div class="modal-content">
    <form method="post" action="/admin/influencers/new">
        {{ csrf_field() }}
        <input type="text" name="name" data-input="influencer_name" placeholder="Influencer Name" required="required"/>
        <input type="hidden" name="influencer" data-input="influencer" />
        <div class="row">
            <strong>Signup Link:</strong> {{ route('register') }}/<span data-type="influencer"></span>
        </div>
        <div class="row">
            <div class="col m12 right-align">
                <button type="submit" class="btn sbs-red" style="width: 200px;">Submit</button>
            </div>
        </div>
    </form>
    </div>
</div>
