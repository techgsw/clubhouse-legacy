<p>We’d love your feedback though! Why aren’t you interested in learning more about this job?<p>
<br />
<form method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col s12 m4" style="margin-bottom: 10px;">
            <button name="negative_interest_reason" value="dream-job" class="flat-button black">I have my dream job</button>
        </div>
        <div class="col s12 m4" style="margin-bottom: 10px;">
            <button name="negative_interest_reason" value="recently-promoted" class="flat-button black">I was recently promoted</button>
        </div>
        <div class="col s12 m4" style="margin-bottom: 10px;">
            <button name="negative_interest_reason" value="cant-leave-team-city" class="flat-button black">I can't leave my team/city</button>
        </div>
        <div class="col s12 m4" style="margin-bottom: 10px;">
            <button name="negative_interest_reason" value="dislike-team-city" class="flat-button black">I don't like the team/city</button>
        </div>
        <div class="col s12 m4" style="margin-bottom: 10px;">
            <button name="negative_interest_reason" value="personal-reasons" class="flat-button black">Personal reasons</button>
        </div>
        <div class="col s12 m4" style="margin-bottom: 10px;">
            <button name="negative_interest_reason" value="other" class="flat-button black">Other</button>
        </div>
    </div>
</form>
