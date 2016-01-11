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
                <button type="button" class="btn btn-block btn-facebook btn-social"><i class="fa fa-facebook"></i> Login with Facebook</button>
            </div>
        </div>
    </div>
</div>