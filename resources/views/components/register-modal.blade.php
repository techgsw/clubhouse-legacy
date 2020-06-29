<div id="register-modal" class="register-modal modal modal-large">
    <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;"><i class="fa fa-window-close"></i></button>
    <a name="register"></a>
    <div class="row hero gray" style="padding-top: 30px; padding-bottom: 10px;">
        <div class="col s12">
            <h4 class="header">Join our <img style="width:75px;vertical-align: middle;margin-top:-10px;" src="/images/CH_logo-compass.png"/> community</h4>
        </div>
    </div>
    <div class="row" style="margin-bottom: -25px;">
        <div class="col s12 center-align">
            <div class="arrow down"></div>
        </div>
    </div>
    <div class="modal-content">
        @include('layouts.components.errors')
        @include('forms.register')
    </div>
</div>
