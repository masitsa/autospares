<?php
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$email2 = $contacts['email'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$linkedin = $contacts['linkedin'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
		
		if(!empty($email))
		{
			$email = '<div class="top-number"><p><i class="fa fa-envelope-o"></i> '.$email.'</p></div>';
		}
		
		if(!empty($facebook))
		{
			$twitter = '<li class="pm_tip_static_bottom" title="Twitter"><a href="#" class="fa fa-twitter" target="_blank"></a></li>';
		}
		
		if(!empty($facebook))
		{
			$linkedin = '<li class="pm_tip_static_bottom" title="Linkedin"><a href="#" class="fa fa-linkedin" target="_blank"></a></li>';
		}
		
		if(!empty($facebook))
		{
			$google = '<li class="pm_tip_static_bottom" title="Google Plus"><a href="#" class="fa fa-google-plus" target="_blank"></a></li>';
		}
		
		if(!empty($facebook))
		{
			$facebook = '<li class="pm_tip_static_bottom" title="Facebook"><a href="#" class="fa fa-facebook" target="_blank"></a></li>';
		}
	}
	else
	{
		$email = '';
		$facebook = '';
		$twitter = '';
		$linkedin = '';
		$logo = '';
		$company_name = '';
		$google = '';
	}
?>   
        <!-- Start Site Header -->
		<div class="site-header-wrapper">
			<header class="site-header">
				<div class="container sp-cont">
					<div class="site-logo">
						<h1><a href="<?php echo site_url();?>"><img src="<?php echo base_url().'assets/logo/'.$logo;?>" class="img-responsive" alt="<?php echo $company_name;?>"></a></h1>
						<span class="site-tagline">Buying or Selling,<br>just got easier!</span>
					</div>
					<div class="header-right">
						<div class="user-login-panel">
							<a href="#" class="user-login-btn" data-toggle="modal" data-target="#loginModal"><i class="fa fa-user"></i></a>
						</div>
						<div class="topnav dd-menu">
							<ul class="top-navigation sf-menu">
								<li><a href="<?php echo site_url().'spareparts';?>">Buy</a></li>
								<li><a href="<?php echo site_url().'sell';?>">Sell</a></li>
								<li><a href="<?php echo site_url().'join';?>">Join</a></li>
							</ul>
						</div>
					</div>
				</div>
			</header>
			<!-- End Site Header -->
			<div class="navbar">
				<div class="container sp-cont">
					<div class="search-function">
						<span><i class="fa fa-phone"></i> Call us <strong><?php echo $phone;?></strong></span>
					</div>
					<a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
					<!-- Main Navigation -->
					<nav class="main-navigation dd-menu toggle-menu" role="navigation">
						<ul class="sf-menu">
                        	
							<?php echo $this->site_model->get_navigation();?>
							
						</ul>
					</nav> 
				</div>
			</div>
		</div>
		