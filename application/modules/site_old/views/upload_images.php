				
    <link href="<?php echo base_url();?>assets/css/jasny-bootstrap.css" rel="stylesheet">
    <div class="upload_images">
    <?php
		$attributes = array('role' => 'form', 'class' => 'form-horizontal add_product');

		echo form_open_multipart(site_url()."site/upload_file/", $attributes);
		?>
                <fieldset class="images">
					<legend>Gallery Images</legend>
                    
                    <div class="row">
                    
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="">
                                    <img src="http://placehold.it/500x500">
                                </div>
                                <div>
                                    <span class="btn btn-file btn_pink"><span class="fileinput-new">Default Image</span><span class="fileinput-exists">Change</span><input type="file" name="product_image" required></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                    
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                                    <img src="http://placehold.it/500x500">
                                
                                </div>
                                <div>
                                    <span class="btn btn-file btn_pink"><span class="fileinput-new">Other image</span><span class="fileinput-exists">Change</span><input type="file" name="gallery1"></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                        
                    	<div class="col-md-4 col-sm-4 col-xs-4">
                        	<div class=" fileinput fileinput-new" data-provides="fileinput">
                                <div class=" fileinput-preview thumbnail" data-trigger="fileinput">
                                    <img src="http://placehold.it/500x500">
                                
                                </div>
                                <div>
                                    <span class="btn btn-file btn_pink"><span class="fileinput-new">Other image</span><span class="fileinput-exists">Change</span><input type="file" name="gallery2"></span>
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
					<div class="col-sm-8 col-md-offset-4 input-error" id="gallery_error"></div>
                    <div class="col-sm-8 col-md-offset-4 input-error" id="upload_error_msg"></div>
				</fieldset>
		
		<div class='btn_align'>
			<input type="submit" value="Add Part" class="login_btn btn btn_dark_pink btn-lg btn_width">
		</div>
		<?php
			form_close();
		?>
		</div>
<script id="loader" src="<?php echo base_url();?>assets/js/loader.js" type="text/javascript"></script>