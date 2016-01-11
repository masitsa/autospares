<link href="<?php echo base_url();?>assets/css/jasny-bootstrap.css" rel="stylesheet">
<script src="<?php echo base_url()."assets/themes/jasny/js/jasny-bootstrap.js"?>" type="text/javascript"/></script>	
<script src="<?php echo base_url()."assets/js/site_script.js"?>" type="text/javascript"/></script>	

	<!-- Start Page header -->
    <div class="page-header parallax" style="background-image:url(<?php echo base_url();?>assets/images/rims.jpg);">
    	<div class="container">
        	<h1 class="page-title"><?php echo $title;?></h1>
       	</div>
    </div>
    
    <!-- Utiity Bar -->
    <div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                    	<?php echo $this->site_model->get_breadcrumbs();?>
                    </ol>
            	</div>
                
            </div>
      	</div>
    </div>
    
     <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                
                <!-- instructions -->
                <header>
                    <h2>How to sell on Autospares</h2>
                </header>
                
                <div class="spacer-40"></div>
                
                <div class='row'>
            
                    <div class="col-md-6">
                        <div style="margin:0 auto; text-align:center;">
                            <!--<iframe class="latest3" src="//www.youtube.com/embed/L3ZLNKko9q4?rel=0" frameborder="0" allowfullscreen></iframe>-->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item">All fields are required</li>
                            <li class="list-group-item">Enter the details of the product you would like to sell, the product's images if any and your contact details then click the 'Add Part' button</li>
                        </ul>
                    </div>
                </div>
                
                <div class="spacer-40"></div>
            	<?php
				$success = $this->session->userdata('sell_success');
				if(!empty($success))
				{
					?>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="alert alert-success">
								<strong>Success! </strong> <?php echo $success; ?>
							</div>
						</div>
					</div>
					<?php 
					$this->session->unset_userdata('sell_success');
				}
				
				$error = $this->session->userdata('error');
				if(!empty($error))
				{
					?>
					<div class="row">
						<div class="col-md-8 col-md-offset-2">
							<div class="alert alert-success">
								<strong>Error!</strong> <?php echo $error; ?>
							</div>
						</div>
					</div>
					<?php 
					$this->session->unset_userdata('error');
				}
			?>
			<?php
			$error2 = validation_errors(); 
			if(!empty($error2)){
				?>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="alert alert-danger">
							<strong>Error!</strong> <?php echo validation_errors(); ?>
						</div>
					</div>
				</div>
				<?php 
			}
			?>
				<?php
                $attributes = array('role' => 'form', 'class' => 'form-horizontal add_product');
        
                echo form_open_multipart(site_url()."add-autopart/", $attributes);
                ?>
					<section class="signup-form sm-margint">
						<!-- Regular Signup -->
						<div class="regular-signup">
							<h3>Product details</h3>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-11">Location</label>
										<div class="col-md-11">
											<select class="form-control selectpicker" name="location_id">
												<option value="">--Select location--</option>
												<?php echo $locations;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-11">Brand</label>
										<div class="col-md-11" id="product_brand_id">
											<select class="form-control selectpicker product_brands" name="product_brand_id">
												<?php echo $brands;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-11">Model</label>
										<div class="col-md-11" id="product_model_id">
											<select class="form-control selectpicker product_models" name="product_model_id">
												<?php echo $models;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-11">Year</label>
										<div class="col-md-11">
											<select class="form-control selectpicker" id="product_year" name="product_year">
												<option value="">--Select year--</option>
												<?php echo $year_to;?>
											</select>
										</div>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-11">Category level 1</label>
										<div class="col-md-11">
											<select class="form-control selectpicker product_category_children" id="product_category_id" name="product_category_id">
												<?php echo $categories;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-11">Category level 2</label>
										<div class="col-md-11" id="product_category_child">
											<select class="form-control selectpicker product_category_sub_children" name="product_category_child">
												<option value="">No level 2</option>
												<?php echo $children;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-11">Category level 3</label>
										<div class="col-md-11" id="product_category_sub_child">
											<select class="form-control selectpicker" name="product_category_sub_child">
												<option value="">No level 3</option>
												<?php echo $sub_children;?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-11">Price</label>
										<div class="col-md-11">
											<input type="number" class="form-control" placeholder="Enter part price" name="product_selling_price" value="<?php echo set_value('product_selling_price');?>">
										</div>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-11">Description</label>
										<div class="col-md-11">
											<textarea class="form-control" placeholder="Enter part description" name="product_description" rows="15"><?php echo set_value('product_description');?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
                
                	<div class="spacer-40"></div>
					
					<section class="signup-form sm-margint">
                        <!-- Social Signup -->
                        <div class="regular-signup">
                            <h3>Product images</h3>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="">
                                            <img src="<?php echo $product_image;?>" class="img-responsive">
                                        </div>
                                        <div>
                                            <span class="btn btn-file btn-primary"><span class="fileinput-new">Default Image</span><span class="fileinput-exists">Change</span><input type="file" name="product_image"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                        
                                <div class="col-md-4">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                                            <img src="<?php echo $gallery1;?>" class="img-responsive">
                                        
                                        </div>
                                        <div>
                                            <span class="btn btn-file btn-primary"><span class="fileinput-new">Other image</span><span class="fileinput-exists">Change</span><input type="file" name="gallery1"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                        
                                <div class="col-md-4">
                                    <div class=" fileinput fileinput-new" data-provides="fileinput">
                                        <div class=" fileinput-preview thumbnail" data-trigger="fileinput">
                                            <img src="<?php echo $gallery2;?>" class="img-responsive">
                                        
                                        </div>
                                        <div>
                                            <span class="btn btn-file btn-primary"><span class="fileinput-new">Other image</span><span class="fileinput-exists">Change</span><input type="file" name="gallery2"></span>
                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-md-offset-2 input-error" id="gallery_error"></div>
                                <div class="col-sm-8 col-md-offset-2 input-error" id="upload_error_msg"></div>
                            </div>
                        </div>
                        <!-- End sell form -->
					</section>
                
                	<div class="spacer-40"></div>
					
					<section class="signup-form sm-margint">
                        <!-- Social Signup -->
						<div class="regular-signup">
							<h3>Seller details</h3>
							
							<div class="row">
								<div class="col-md-4">
							
									<div class="form-group">
										<label class="col-md-11">Name</label>
										<div class="col-md-11">
											<input type="text" class="form-control" placeholder="Enter your name" name="seller_name" value="<?php echo set_value('seller_name');?>">
										</div>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-11">Email</label>
										<div class="col-md-11">
											<input type="email" class="form-control" placeholder="Enter your email address" name="user_email" value="<?php echo set_value('user_email');?>">
										</div>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label class="col-md-11">Phone</label>
										<div class="col-md-11">
											<input type="text" class="form-control" placeholder="Enter your phone number" name="user_phone" value="<?php echo set_value('user_phone');?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
                    
                    <div class="row">
                    	<div class="col-md-8 col-md-offset-2">
                            <div class="clearfix spacer-20"></div>
                            <label class="checkbox-inline"><input type="checkbox" name="agree">By selling, I agree to the <a href="<?php echo site_url().'terms-&-conditions';?>">terms &amp; conditions</a> and <a href="<?php echo site_url().'privacy';?>">privacy policy</a></label>
                            <div class="spacer-20"></div>
                            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Sell">
                        </div>
                    </div>
                <?php echo form_close();?>
            
                <div class="clearfix"></div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->