<div id="mentor-request-modal" class="modal">
    <div class="modal-content">
        <div id="messages" class="row">
            <div class="col s12">
                <div class="error-message alert card-panel red lighten-4 red-text text-darken-4 hidden">

                </div>
                <div class="success-message alert card-panel green lighten-4 green-text text-darken-4 hidden">

                </div>
            </div>
        </div>
        @if($is_blocked)
            <div class="error-message alert card-panel red lighten-4 red-text text-darken-4">
                <p>Sorry, you have exceeded your limit of two mentor requests per week. Please try again later.</p>
            </div>
        @else
            @include('mentor.forms.request')
        @endif
    </div>
</div>
<div id="mentor-calendly-modal" class="modal" style="max-height:100%;min-width:320px;overflow-y:hidden;">
    @if($is_blocked)
        <div class="modal-content">
            <div class="error-message alert card-panel red lighten-4 red-text text-darken-4">
                <p>Sorry, you have exceeded your limit of two mentor requests per week. Please try again later.</p>
            </div>
        </div>
    @else
        <div class="modal-content" style="padding:0px;height:80vh;">
            <div id="mentor-calendly-embed" style="position: relative;min-width:320px;height:100%;">
            </div>
        </div>
    @endif
</div>
