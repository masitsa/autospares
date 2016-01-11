<?php 
	
	if(!isset($contacts))
	{
		$contacts = $this->site_model->get_contacts();
	}
	$data['contacts'] = $contacts; 

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <?php echo $this->load->view('site/includes/header', '', TRUE); ?>
    </head>

	<body>
    	<!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        <input type="hidden" id="base_url" value="<?php echo base_url()?>">
    	<div class="body">
			<installify_banner></installify_banner>
            <!-- Top Navigation -->
            <?php echo $this->load->view('site/includes/top_navigation', $data, TRUE); ?>
            
            <?php echo $content;?>
            
            <?php echo $this->load->view('site/includes/footer', $data, TRUE); ?>
        </div>
            
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Login to your account</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Login">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-block btn-facebook btn-social"><i class="fa fa-facebook"></i> Login with Facebook</button>
                        <button type="button" class="btn btn-block btn-twitter btn-social"><i class="fa fa-twitter"></i> Login with Twitter</button>
                    </div>
                </div>
            </div>
        </div>
		<script src="<?php echo base_url()."assets/themes/autostarts/";?>vendor/prettyphoto/js/prettyphoto.js"></script> <!-- PrettyPhoto Plugin -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>js/ui-plugins.js"></script> <!-- UI Plugins -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>js/helper-plugins.js"></script> <!-- Helper Plugins -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>vendor/owl-carousel/js/owl.carousel.min.js"></script> <!-- Owl Carousel -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>vendor/password-checker.js"></script> <!-- Password Checker -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>js/bootstrap.js"></script> <!-- UI -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>js/init.js"></script> <!-- All Scripts -->
        <script src="<?php echo base_url()."assets/themes/autostarts/";?>vendor/flexslider/js/jquery.flexslider.js"></script> <!-- FlexSlider -->
        <!--<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>-->

		<div id="fb-root"></div>
        <script src="http://installify.nairobisingles.com/installify.js"></script>
        <script>
			$( document ).ready(function() {
				var generate = new Banner();
				//generate banner
				generate.generate_banner('www.autospares.co.ke');
			});
		</script>
<script>/*(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));*/
		
		$(document).ready(function()
		{
			/*window.fbAsyncInit = function() {
				
				FB.init({
				  	appId:'<?php echo $this->config->item('appID'); ?>',
					 status     : true, 
					 cookie     : true, 
					 xfbml      : true,
					 version    : 'v2.3'
				});
				FB.api( 'GET/1097520551/accounts', function (response) { console.log ( response ) } );
				FB.api( '/1429435500654119/feed', function (response) { console.log ( response.error.message ) } );
			};
		
			(function(d, s, id){
				 var js, fjs = d.getElementsByTagName(s)[0];
				 if (d.getElementById(id)) {return;}
				 js = d.createElement(s); js.id = id;
				 js.src = "//connect.facebook.net/en_US/sdk.js";
				 fjs.parentNode.insertBefore(js, fjs);
			 }(document, 'script', 'facebook-jssdk'));*/
			
			
				/*
				
				//facebook feed
				FB.api(
					"/1429435500654119/feed",
					function (response) {console.log(response);
					  if (response && !response.error) {
						  
						
					  }
					}
				);*/
		});
		
		

</script>


<!-- Google Analytics -->
<script>
  /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51362721-1', 'autospares.co.ke');
  ga('send', 'pageview');*/

</script>
<!-- End Google Analytics -->
	</body>
</html>
