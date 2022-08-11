<div class="row red lighten-4" style="padding: .7rem 1rem 1rem;">
    <a href="/user/{{ Auth::user()->id }}/edit-profile">
        <div class="col m10" style="color: #b71c1c !important;">
            <div style="display: inline-block">
                <i class="material-icons" style="position: relative; top: 6px;">warning</i>
            </div>
            <div style="display: inline-block">
                In order to take full advantage of our services, please click here to complete your profile.
            </div>
        </div>
    </a>
    <a href="/user/{{ Auth::user()->id }}/dont-ask">
        <div class="col m2 right-align" style="color: #b71c1c !important;">
            <i class="material-icons" style="position: relative; top: 7px;">close</i>Don't ask me again
        </div>
    </a>
</div>
