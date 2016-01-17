<?php
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
	}
?>
        <!-- Start site footer -->
		<footer class="site-footer">
			<div class="site-footer-top">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-sm-6 footer_widget widget widget_custom_menu widget_links">
							<h4 class="widgettitle">Contacts</h4>
							<ul>
								<li>
                                	<a href="mailto:<?php echo $email;?>"><i class="fa fa-envelope"></i> <?php echo $email;?></a>
                                </li>
								<li>
                                	<a href="tel:<?php echo $phone;?>"><i class="fa fa-mobile fa-2x"></i> <?php echo $phone;?></a>
                                </li>
							</ul>
						</div>
						<div class="col-md-3 col-sm-6 footer_widget widget widget_custom_menu widget_links">
							<h4 class="widgettitle">The buzz is at</h4>
							<ul>
								<li class="facebook"><a href="<?php echo $facebook;?>" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>
								<li class="twitter"><a href="<?php echo $twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a> Twitter</li>
							</ul>
						</div>
						<div class="col-md-3 col-sm-6 footer_widget widget widget_custom_menu widget_links">
							<h4 class="widgettitle">Legal</h4>
							<ul>
								<li><a href="<?php echo site_url().'terms-and-conditions'?>">Terms &amp; conditions</a></li>
								<li><a href="<?php echo site_url().'privacy-policy'?>">Privacy policy</a></li>
								<li><a href="<?php echo site_url().'about'?>">About</a></li>
							</ul>
						</div>
						<div class="col-md-3 col-sm-6 footer_widget widget widget_custom_menu widget_links">
							<h4 class="widgettitle">Quick links</h4>
							<ul>
								<li><a href="<?php echo site_url().'autospares'?>">Buy</a></li>
								<li><a href="<?php echo site_url().'sell'?>">Sell</a></li>
								<li><a href="<?php echo site_url().'join'?>">Join</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="site-footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 copyrights-left">
							<p>&copy; <?php echo date('Y');?> <?php echo $company_name;?>. All Rights Reserved</p>
						</div>
						<div class="col-md-6 col-sm-6 copyrights-right">
							<ul class="social-icons social-icons-colored pull-right">
								<li class="facebook"><a href="<?php echo $facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li class="twitter"><a href="<?php echo $twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- End site footer -->
		<a id="back-to-top"><i class="fa fa-angle-double-up"></i></a>
    
    <!-- LOGIN POPUP -->
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
                <div id="fb-root"></div>
                <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	
   //Request more information
   $(document).on("submit","form#request_more_info_form",function(e)
     {
      e.preventDefault();
      
      var formData = new FormData(this);
      
      var product_id = $(this).attr('product_id');

      $.ajax({
       type:'POST',
       url: $(this).attr('action'),
       data:formData,
       cache:false,
       contentType: false,
       processData: false,
       dataType: 'json',
       success:function(data){
        alert(data.result);
        location.reload();
       },
       error: function(xhr, status, error) {
        alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
         location.reload();
       }
      });
      return false;
     });
   
    $(document).on("submit","form#submit_query",function(e)
     {
      e.preventDefault();
      
      var formData = new FormData(this);
      
      // var product_id = $(this).attr('product_id');

      $.ajax({
       type:'POST',
       url: $(this).attr('action'),
       data:formData,
       cache:false,
       contentType: false,
       processData: false,
       dataType: 'json',
       success:function(data){
        alert(data.result);
        location.reload();
       },
       error: function(xhr, status, error) {
        alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
         location.reload();
       }
      });
      return false;
     });

     $(document).on("submit","form#send_to_friend",function(e)
     {
      e.preventDefault();
      
      var formData = new FormData(this);
      
      var product_id = $(this).attr('product_id');

      $.ajax({
       type:'POST',
       url: $(this).attr('action'),
       data:formData,
       cache:false,
       contentType: false,
       processData: false,
       dataType: 'json',
       success:function(data){
        alert(data.result);
        location.reload();
       },
       error: function(xhr, status, error) {
        alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
         location.reload();
       }
      });
      return false;
     });
</script>


<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=881322258651090";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>