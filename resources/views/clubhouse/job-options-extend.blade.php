<div class="container-fluid" id="compare-options" style="background-color: #F2F2F2;">
    <div class="container">
        <div class="row">
            <div class="col s12 center">
                <h4 class="uppercase" style="margin: 1.14rem 0 0.912rem 0;">EXTEND YOUR POSTING</h4>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="center-align row">
    <!-- <p style="font-size: 24px; font-weight: bold;">$250.00</p> -->
        @if ($job_type_id != JOB_TYPE_ID['sbs_default'])
            <p style="font-size: 16px; font-weight: 400;">Thank you for posting your job on <strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup></strong> Job Board!  We hope the process has been smooth and you've been able to connect with some quality candidates. If for some reason you haven't been able to identify the right fit for the job, you are welcome to extend your listing for another 30 days on the job board for FREE. We'll also provide additional promotion to give your open job a boost and help you get a little wider to attract new candidates. If you have any questions for <strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup></strong> and SBS team, feel free to reach out anytime at <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a>.</p>
            <a href="{{ $job_extension->getURL(false, 'checkout') }}/{{ $job->id }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Extend Now</a>
        @else
            <p class="center-align" style="font-size: 18px; font-weight: 400;">Admin postings do not require extensions</p>
        @endif
    </div>
</div>
