<div class="container-fluid" id="compare-options" style="background-color: #F2F2F2;">
    <div class="container">
        <div class="row">
            <div class="col s12 center">
                <h4 class="uppercase" style="margin: 1.14rem 0 0.912rem 0;">UPGRADE YOUR POSTING</h4>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="card-flex-container" style="justify-content:center;">
            <div class="card medium" style="min-width:300px;max-width:425px;">
                <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                    <div class="col s12" style="padding: 10px 0 30px 0;">
                        <h5 class="center-align sbs-red-text" style="font-size: 24px"><strong>PREMIUM</strong></h5>
                        <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                        <br />
                        <!--<p class="center-align" style="font-size: 18px; font-weight: 400;">Boost your job posting now!</p>-->
                        <p class="center-align" style="font-size: 18px; font-weight: 400;">Increase the awareness of your job!</p>
                        <br />
                        <p class="center-align" style="font-size: 16px; font-weight: 400;">Become a featured job on the job board and receive additional exposure. You’ll also be assigned quality candidates from the SBS database based on your search criteria.</p>
                    </div>
                    <div class="col s12 center-align" style="padding-bottom: 10px;">
                        <p class="center-align" style="font-size: 15px; font-weight: 400;">Email <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a> to get a pricing quote.</p>
                        @if ($job_premium)
                            <a href="mailto:theclubhouse@generalsports.com" class="buy-now btn sbs-red" style="margin-top: 18px;">Contact Us</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card medium" style="min-width:300px;max-width:425px;">
                <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                    <div class="col s12" style="padding: 10px 0 30px 0;">
                        <h5 class="center-align" style="font-size: 24px"><strong>PLATINUM</strong></h5>
                        <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                        <br />
                        <p class="center-align" style="font-size: 18px; font-weight: 400;">Maximize your exposure and we do the work!</p>
                        <br />
                        <p class="center-align" style="font-size: 16px; font-weight: 400;">Platinum jobs get the most social media and email promotion. We assign you candidates AND we screen them for you, ensuring that by the time they get to you, they’re qualified and interested.</p>
                    </div>
                    <div class="col s12 center-align" style="padding-bottom: 10px;">
                        <p class="center-align" style="font-size: 15px; font-weight: 400;">Email <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a> to get a pricing quote.</p>
                        @if ($job_platinum)
                            <a href="mailto:theclubhouse@generalsports.com" class="buy-now btn sbs-red" style="margin-top: 18px;">Contact Us</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="compare-options" style="background-color: #F2F2F2;">
    <div class="container">
        <div class="row">
            <div class="col s12 center">
                <h4 class="uppercase" style="margin: 1.14rem 0 0.912rem 0;">COMPARE THE OPTIONS</h4>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col s12 center" style="margin-bottom:12px">
            @include('components.job-options-comparison-table')
        </div>
    </div>
</div>
