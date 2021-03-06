<?php 
	/*header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Cache-Control: no-cache");
	header("Pragma: no-cache");*/
	
	if(count($contacts) > 0){
		foreach($contacts as $cat){
			$site_name = $cat->site_name;
			$logo = $cat->logo;
		}
	}
?>
<!DOCTYPE html>
<html>
  <head>
  	<!-- Begin Inspectlet Embed Code -->
	<script type="text/javascript" id="inspectletjs">
        window.__insp = window.__insp || [];
        __insp.push(['wid', 1495970815]);
        (function() {
            function __ldinsp(){var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); }
            if (window.attachEvent){
                window.attachEvent('onload', __ldinsp);
            }else{
                window.addEventListener('load', __ldinsp, false);
            }
        })();
    </script>
    <!-- End Inspectlet Embed Code -->
  	<meta http-equiv="Cache-control" content="public">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $site_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <!-- Sidemenu -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/side_menu.css" />
    <!-- Search -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/search.css">
    <!-- General -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <!-- Animate -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/carousel-style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.jscrollpane.css" media="all" />
    <!-- Favicon -->
    <link href="<?php echo base_url();?>assets/img/favicon.png" rel="shortcut icon" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    
    <!-- Facebook Conversion Code for Autospares Web Conversions -->
	<script>(function() {
    var _fbq = window._fbq || (window._fbq = []);
    if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
    }
    })();
    window._fbq = window._fbq || [];
    window._fbq.push(['track', '6017660222719', {'value':'0.01','currency':'USD'}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6017660222719&amp;cd[value]=0.01&amp;cd[currency]=USD&amp;noscript=1" /></noscript>
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

	function facebook_share(image, name, price, tiny_url)
	{
		 FB.ui({
			method: 'feed',
			picture: "<?php echo base_url();?>assets/products/images/"+image,
			link: tiny_url,
			description: name+" @ "+price,
		}, function(response){});
	}

	function post_facebook_share(image, name, tiny_url)
	{
		 FB.ui({
			method: 'feed',
			picture: "<?php echo base_url();?>assets/products/images/"+image,
			link: tiny_url,
			description: name,
		}, function(response){});
	}
    </script>
    
  <input type="hidden" name="baseurl" id="baseurl" value="<?php echo site_url();?>"/>