<div class="container-fluid" id="compare-options" style="background-color: #F2F2F2;">
    <div class="container">
        <div class="row">
            <div class="col s12 center">
                <h4 class="uppercase" style="margin: 1.14rem 0 0.912rem 0;">EXTEND YOUR POSTING</h4>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="center-align row">
        <p style="font-size: 24px; font-weight: bold;">$250.00</p>
        @if ($job_type_id != JOB_TYPE_ID['sbs_default'])
            <p style="font-size: 16px; font-weight: 400;">If you haven't found the right fit for your open position, you can extend your job listing for an additional
                @if ($job_type_id == JOB_TYPE_ID['user_free'])
                    <b>30</b>
                @elseif ($job_type_id == JOB_TYPE_ID['user_premium'])
                    <b>45</b>
                @elseif ($job_type_id == JOB_TYPE_ID['user_platinum'])
                    <b>60</b>
                @endif
                days on our board.</p>
            <a href="{{ $job_extension->getURL(false, 'checkout') }}/{{ $job->id }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Extend Now</a>
        @else
            <p class="center-align" style="font-size: 18px; font-weight: 400;">Admin postings do not require extensions</p>
        @endif
    </div>
</div>
