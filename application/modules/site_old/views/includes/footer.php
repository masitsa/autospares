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
			$blog = $cat->blog;
		}
	}
?>
    </div><!-- End Wrapper -->
	<div class="footer">
    	<div class="contacts row" style="margin:0">
            <!-- Contacts -->
            <div class="col-xs-6 col-sm-3 col-md-3">
                <h3>Contacts</h3>
                <div>
                    <a href="<?php echo site_url().'contacts'?>"><i class="fa fa-envelope fa-2x" style="padding-left:4%;"></i> info@autospares.co.ke</a>
                </div>
                <div>
                    <a href="#"><i class="fa fa-mobile fa-3x" style="padding-left:4%;"></i> (+254) 0726 200 331</a>
                </div>
                <div>
                    <a href="#"><i class="fa fa-map-marker fa-3x" style="padding-left:3%;"></i> Nairobi</a>
                </div>
            </div><!-- End Contacts -->
        
            <!-- Social Media -->
            <div class="col-xs-6 col-sm-3 col-md-3">
                <h3>The buzz is at...</h3>
                <div>
                    <a href="https://www.facebook.com/Autospares.co.ke" target="_blank"><i class="fa fa-facebook-square fa-2x" style="padding-left:4%;"></i> Autospares Online</a>
                </div>
                
                <div>
                    <a href="https://twitter.com/autosparesK" target="_blank"><i class="fa fa-twitter-square fa-2x" style="padding-left:4%;"></i> autosparesK</a>
            	</div>
            </div><!-- End Social Media -->
        
            <!-- Social Media -->
            <div class="col-xs-6 col-sm-3 col-md-3">
                <h3>Legal</h3>
                <div>
                    <a href="<?php echo site_url().'terms'?>">Terms & Conditions</a>
                </div>
                <div>
                    <a href="<?php echo site_url().'privacy'?>">Privacy Policy</a>
                </div>
            </div><!-- End Social Media -->
        
            <!-- Payment -->
            <div class="col-xs-6 col-sm-3 col-md-3">
                <h3>Quick Links</h3>
                <!-- <div>
                    <a href="<?php echo site_url().'contact'?>">Contact Us</a>
                </div> -->
                <div>
                    <a href="<?php echo site_url().'sell'?>">Sell</a>
                </div>
                <div>
                    <a href="<?php echo site_url().'all-categories'?>">Spares</a>
                </div>
                <div>
                    <a href="<?php echo site_url().'contact'?>">Contact</a>
                </div>
            </div><!-- End Payment -->
        </div>
        <!-- End Contacts -->
        
        <div class='btn_align'>&copy; <?php echo date('Y');?> Autospares. All Rights Reserved.</div>
        
    </div><!-- End Footer -->
  </body>
</html>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-1.7.2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jasny-bootstrap.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>
<script src="<?php echo base_url();?>assets/js/modernizr.custom.js"></script>
<script src="<?php echo base_url();?>assets/js/classie.js"></script>
<!-- Carousel -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.easing.1.3.js"></script>
<!-- the jScrollPane script -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.stellar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/wow.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bind-polyfill.js"></script>
<script src="<?php echo base_url();?>assets/js/smooth-scroll.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.contentcarousel.js"></script>
<script src="<?php echo base_url();?>assets/js/site_script.js"></script>
<script type="text/javascript">
    $('#ca-container').contentcarousel();
    $('#ca-container2').contentcarousel();
    $('#ca-container3').contentcarousel();
</script>

<script type="text/javascript">

	$(document).ready(function () {
		$("ul.tree").hide();//collapses all trees
		$('label.tree-toggler').click(function () {
			$(this).parent().children('ul.tree').toggle(300);
		});
		
		//initialise Stellar.js
		$(window).stellar({
			horizontalScrolling: false
		}); 
		
		//smoothscroll
		smoothScroll.init();
		
		//wow
		new WOW().init();
	});
	
	if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
  		var msViewportStyle = document.createElement("style")
  			msViewportStyle.appendChild(
    			document.createTextNode(
      				"@-ms-viewport{width:auto!important}"
    			)
  			)
  		document.getElementsByTagName("head")[0].appendChild(msViewportStyle)
	}
	
	var 
		menuTop = document.getElementById( 'cbp-spmenu-s3' ),
		showTop = document.getElementById( 'showTop' ),
		body = document.body;
	showTop.onclick = function() {
		classie.toggle( this, 'active' );
		classie.toggle( menuTop, 'cbp-spmenu-open' );
		disableOther( 'showTop' );
	};

	function disableOther( button ) {
		if( button !== 'showTop' ) {
			classie.toggle( showTop, 'disabled' );
		}
	}
</script>

<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51362721-1', 'autospares.co.ke');
  ga('send', 'pageview');

</script>
<!-- End Google Analytics -->