<!-- GA  Scripts-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-104897707-1', 'auto');
  ga('send', 'pageview');

</script>

<!--  Scripts-->
<script src="/js/jquery-2.2.4.min.js"></script>
<script src="/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
<script src="/js/materialize.js"></script>
<script src="/js/medium-editor.js"></script>
<script src="/js/me-markdown.standalone.min.js"></script>
<script src="/js/dropzone.js"></script>
<script src="/js/moment.min.js"></script>
<script src="/js/daterangepicker.js"></script>
<script src="/js/sbs.js?v=56"></script>
@if (Request::is('checkout/*') || Request::is('*/account'))
    <script>SBS.stripe_token = '{{ env('STRIPE_PUBLIC_TOKEN') }}';</script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="/js/checkout.js?v=6"></script>
@endif
@if (Request::is('admin/report*'))
    <script src="/js/Chart.min.js"></script>
    <script src="/js/admin-report.js"></script>
@endif
