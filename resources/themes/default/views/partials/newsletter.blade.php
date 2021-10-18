<!-- NEWSLETTER -->
<div id="newsletter" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>Sign Up for the <strong>NEWSLETTER</strong></p>
                    <form>
                        <input class="input" type="email" placeholder="Enter Your Email">
                        <button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                    </form>
                    <ul class="newsletter-follow">
                        <li>
                            <a href="{{ $settings->facebook_url }}"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="{{ $settings->twitter_url }}"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="{{ $settings->instagram_url }}"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="{{ $settings->youtube_url }}"><i class="fa fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /NEWSLETTER -->
