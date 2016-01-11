<?php 
	if(count($contacts) > 0){
		foreach($contacts as $cat){
			
			$contacts_id = $cat->contacts_id;
			$email = $cat->email;
			$phone = $cat->phone;
			$post = $cat->post;
			$physical = $cat->physical;
			$site_name = $cat->site_name;
			$logo = $cat->logo;
			$facebook = $cat->facebook;
			
			if(!empty($phone)){
				$phone = 'Tel: '.$phone;
			}
			
			if(!empty($post)){
				$post = 'Postal Address: '.$post;
			}
			
			if(!empty($physical)){
				$physical = 'Physical Address: '.$physical;
			}
			
			if(!empty($email)){
				$email = 'Email: '.$email;
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Administration</title>
    <!-- For mobile content -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- IE Support -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <!-- Style -->
    <link href="<?php echo base_url();?>assets/css/admin.css" rel="stylesheet" media="screen">
    <!-- Font awesome -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <!-- Datepicker -->
    <link href="<?php echo base_url();?>assets/css/jquery-ui.css" rel="stylesheet"  />
    <!-- File Upload -->
    <link href="<?php echo base_url();?>assets/css/jasny-bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/logo/thumbs/<?php echo $logo?>" rel="shortcut icon" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div id="fb-root"></div>
	<script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '687392621328638',
            xfbml      : true,
            version    : 'v2.0'
            });
        };
        
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=687392621328638&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

	function facebook_share(image, name, price)
	{
		 FB.ui({
			method: 'feed',
			picture: "<?php echo base_url();?>assets/products/images/"+image,
			link: "<?php echo site_url();?>",
			description: name+" @ "+price,
			to: 1429435500654119
			from: 1429435500654119
		}, function(response){});
	}
    </script>
  	<input type="hidden" id="baseurl" value="<?php echo site_url();?>"/>
    <!-- Header -->
    <div class="row header">
  		<div class="col-md-12">
        	<img src="<?php echo base_url();?>assets/logo/thumbs/<?php echo $logo?>" class="img-responsive img-thumbnail" alt="<?php echo $site_name?>">
            
            <p><?php echo $site_name?></p>
            <div class="contacts">
            <?php echo $phone;?> <br/>
            <?php echo $email;?> <br/>
            <?php echo $physical;?> <br/>
            <?php echo $post;?> <br/></div>
        </div>
	</div>