<link href="<?php echo base_url();?>assets/css/jasny-bootstrap.css" rel="stylesheet">
<!-- Home page -->
<div class="home-page">
    <div class="row latest">
	<div class="col-md-12 main_items">
    	<?php
			if(isset($_SESSION['success']))
			{
				echo '<div class="alert alert-success">
					'.$_SESSION['success'].'
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				</div>';
				$_SESSION['success'] = NULL;
			}
		?>
        <div class="input_form">
            <fieldset>
                <legend>Sell spares</legend>
        <?php
        $error2 = validation_errors(); 
        if(!empty($error2)){?>
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?php echo validation_errors(); ?>
                    </div>
                </div>
            </div>
    	<?php }
    
    	if(isset($_SESSION['error'])){?>
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <?php echo $_SESSION['error']; $_SESSION['error'] = NULL;?>
                    </div>
                </div>
            </div>
    	<?php }?>
    
    	<?php
		$attributes = array('role' => 'form', 'class' => 'form-horizontal add_product');

		echo form_open_multipart(site_url()."add-autopart/", $attributes);
		?>
        <fieldset>
            <legend>How To Sell</legend>
		
		<div class='row'>
            
            <div class="col-md-6">
                <div style="margin:0 auto; text-align:center;">
                    <iframe class="latest3" src="//www.youtube.com/embed/L3ZLNKko9q4?rel=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
			<div class="col-md-6">
                Click to expand
                <div class="panel-group" id="accordion">
                    <div class="panel panel-success">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                How to Sell
                                </h4>
                            </div>
                        </a>
                        <div id="collapseOne" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="list-group">
                                    <li class="list-group-item">All fields are required</li>
                                    <li class="list-group-item">Enter the details of the product you would like to sell, the product's images if any and your contact details then click the 'Add Part' button</li>
                                    <li class="list-group-item">You will be prompted to make a payment via MPesa of KES 50</li>
                                    <li class="list-group-item">Make the payment and then enter your transaction number in the box provided</li>
                                    <li class="list-group-item">Once your payment has been verified your part shall be displayed for sale :-)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel panel-success">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                How to Pay
                                </h4>
                            </div>
                        </a>
                        <div id="collapseTwo" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Go to your MPesa menu</li>
                                    <li class="list-group-item">Enter an amount of KES 50</li>
                                    <li class="list-group-item">Enter the number 0726 200 331</li>
                                    <li class="list-group-item">Hit send</li>
                                    <li class="list-group-item">After sending the amount you will be receive a confirmation message that the amount was sent to Autospares Ltd.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
        </div>
		</fieldset>
        
		<div class='row'>
			<div class="col-md-6">
				<fieldset>
					<legend>Product Details</legend>
					<div class="form-group">
						<label class="col-sm-4 control-label"for="brand_id">Location</label>
						<div class=" col-sm-8 col-xs-12 input-group">
						<div class="styled_checkbox">
						<select class="form-control location_id" id="location_id" name="location_id">
							<?php echo $locations;?>
						</select>
						</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label"for="brand_id">Brand</label>
						<div class=" col-sm-8 col-xs-12 input-group">
						<div class="styled_checkbox">
						<select class="form-control product_brands" id="product_brand_id" name="product_brand_id">
							<?php echo $product_brands;?>
						</select>
						</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label"for="product_model_id">Model</label>
						<div class=" col-sm-8 col-xs-12 input-group">
						<div class="styled_checkbox">
						<select class="form-control product_models" id="product_model_id" name="product_model_id">
							<?php echo $product_models;?>
						</select>
						</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label"for="product_year">Product Year</label>
						<div class=" col-sm-8 col-xs-12 input-group">
						<div class="styled_checkbox">
						<select class="form-control" id="product_year" name="product_year">
							<?php echo $product_year_to;?>
						</select>
						</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label"for="product_category_id">Category</label>
						<div class=" col-sm-8 col-xs-12 input-group">
						<div class="styled_checkbox">
						<select class="form-control product_category_children" id="product_category_id" name="product_category_id">
                          <?php echo $product_categories;?>
                    	</select>
						</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label"for="product_category_child">Sub Category</label>
						<div class=" col-sm-8 col-xs-12 input-group">
                            <div class="styled_checkbox">
                            <select class="form-control" id="product_category_child" name="product_category_child">
                                  <?php echo $product_children;?>
                            </select>
                            </div>
						</div>
					</div>
					
					<div class="form-group" id="product_selling_price_error">
						<label class="col-sm-4 control-label"for="product_selling_price">Selling Price</label>
						<div class=" col-sm-8 input-group">
							<span class="input-group-addon">KES</span>
							<input type="number" class="form-control" name="product_selling_price" placeholder="Selling Price" required>
						</div>
						<div class="input-error col-sm-8 col-md-offset-4" id="product_selling_price_error_msg"></div>
					</div>
		
					<!--<div class="form-group" id="product_balance_error">
						<label class="col-sm-4 control-label"for="product_balance">Quantity</label>
						<div class=" col-sm-8 input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-tasks"></span></span>
							<input type="number" class="form-control" name="product_balance" placeholder="Quantity" value="1" required>
						</div>
						<div class="col-sm-8 col-md-offset-4 input-error" id="product_balance_error_msg"></div>
					</div>-->
					
					<div class="form-group">
						<label class="col-sm-4 control-label"for="product_description">Description</label>
						<div class=" col-sm-8">
						<textarea name="product_description" class="form-control" required></textarea>
						</div>
					</div>
				</fieldset>
			</div>
		<!-- <div class="form-group">
			<label class="col-sm-4 control-label"class="control-label" for="image">Gallery Images</label>
			<div class="controls">
				<?php echo form_upload(array( 'name'=>'gallery[]', 'multiple'=>true ));?>
            </div>
        </div> -->
		
			<div class="col-md-6">
			
				<fieldset>
					<legend>About you</legend>
					<div class="form-group" id="seller_name_error">
						<label class="col-sm-4 control-label"for="seller_name">Names</label>
						<div class=" col-sm-8 input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
						  <input type="text" class="form-control" name="seller_name" placeholder="Your Names" required>
						</div>
						<div class=" col-sm-8 col-md-offset-4 input-error" id="seller_name_error_msg"></div>
					</div>
					
					<div class="form-group" id="user_phone_error">
						<label class="col-sm-4 control-label"for="user_phone">Phone</label>
						<div class=" col-sm-8 input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
						  <input type="text" class="form-control" name="user_phone" placeholder="Your Phone Number" required>
						</div>
						<div class=" col-sm-8 col-md-offset-4 input-error" id="user_phone_error_msg"></div>
					</div>
					
					<div class="form-group" id="user_email_error">
						<label class="col-sm-4 control-label"for="user_email">Email</label>
						<div class=" col-sm-8 input-group">
						  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
						  <input type="email" class="form-control" name="user_email" placeholder="Your Email Address">
						</div>
						<div class=" col-sm-8 col-md-offset-4 input-error" id="user_email_error_msg"></div>
					</div>
					
				</fieldset>
		
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
                    </div>
                    
                    <div class="row">
                    	<div class="col-md-6 col-sm-6 col-xs-6">
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
                        
                    	<div class="col-md-6 col-sm-6 col-xs-6">
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
			</div>
		</div>
		
		<div class='btn_align'>
			<input type="submit" value="Add Part" class="login_btn btn btn_dark_pink btn-lg btn_width">
		</div>
		<?php
			form_close();
		?>
        
            </fieldset>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>
<script id="loader" src="<?php echo base_url();?>assets/js/loader.js" type="text/javascript"></script>