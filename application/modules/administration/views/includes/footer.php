
        
    </div><!--wrapper-->
    
    <div class="row footer">
  		<div class="col-md-8 col-md-offset-4">
        	<a href="#" target="_blank"><?php echo date("Y");?></a>
        </div>
    </div>
    
    <!-- JQuery 2.0.3 -->
 	<script src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <!-- JQuery UI -->
  	<script src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
    <!-- Scripts -->
  	<script src="<?php echo base_url();?>assets/js/script.js"></script>
    <!-- Scripts -->
  	<script src="<?php echo base_url();?>assets/js/jasny-bootstrap.js"></script>
    <!-- Datepicker functions -->
	<script>
  			$(function(){
				
				//date picker
				$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
				$( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
			});
  </script>
    <!--IE Support-->
    <script type="text/javascript">
		if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
  			var msViewportStyle = document.createElement("style")
  				msViewportStyle.appendChild(
    				document.createTextNode(
      					"@-ms-viewport{width:auto!important}"
    				)
  				)
  			document.getElementsByTagName("head")[0].appendChild(msViewportStyle)
		}
	</script>
  </body>
</html>