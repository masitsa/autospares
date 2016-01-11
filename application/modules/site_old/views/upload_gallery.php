

		<!-- The main CSS file -->
		<link href="<?php echo base_url()."assets/upload_assets/";?>css/style.css" rel="stylesheet" />

		<form id="upload" method="post" action="<?php echo site_url()."site/upload_image_gallery";?>" enctype="multipart/form-data">
			<div id="drop">
				Drop Here

				<a>Browse</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>
        
		<!-- JavaScript Includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="<?php echo base_url()."assets/upload_assets/";?>js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="<?php echo base_url()."assets/upload_assets/";?>js/jquery.ui.widget.js"></script>
		<script src="<?php echo base_url()."assets/upload_assets/";?>js/jquery.iframe-transport.js"></script>
		<script src="<?php echo base_url()."assets/upload_assets/";?>js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="<?php echo base_url()."assets/upload_assets/";?>js/script.js"></script>