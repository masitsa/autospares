	<div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>New Product</h3>
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
		$attributes = array('role' => 'form');

		echo form_open_multipart($this->uri->uri_string(), $attributes);
		?>
		<div class="form-group">
			<label for="product_name">Product Name</label>
			<input type="text" class="form-control" name="product_name" placeholder="Enter Product Name" value="<?php echo set_value("product_name");?>">
		</div>
		<div class="form-group">
			<label for="brand_id">Brand</label>
			<select class="form-control brands" id="brand_id" name="brand_id">
            	<option value="wewe" selected>----Select Brand----</option>
            	<?php
					if(count($brands) > 0){
						foreach ($brands as $cat){
							$brand_name = $cat->brand_name;
							$brand_id = $cat->brand_id;
							
							if(set_value("brand_id") == $brand_id){
								?>
								<option value="<?php echo $brand_id?>" selected><?php echo $brand_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $brand_id?>"><?php echo $brand_name?></option>
								<?php
							}
						}
					}
				?>
            </select>
		</div>
		<div class="form-group" id="models">
		</div>
		<div class="form-group">
			<label for="product_year">Product Year</label>
			<input type="text" class="form-control" name="product_year" placeholder="Enter Product Year" value="<?php echo set_value("product_year");?>">
		</div>
		<div class="form-group">
			<label for="category_id">Category</label>
			<select class="form-control" name="category_id">
            	<?php
					if(count($children) > 0){
						foreach ($children as $cat){
							$category_name = $cat->category_name;
							$category_id = $cat->category_id;
							
							if(set_value("category_id") == $category_id){
								?>
								<option value="<?php echo $category_id?>" selected><?php echo $category_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $category_id?>"><?php echo $category_name?></option>
								<?php
							}
						}
					}
				?>
            </select>
		</div>
		
		<div class="form-group">
			<label for="product_buying_price">Buying Price</label>
			<input type="text" class="form-control" name="product_buying_price" placeholder="Enter Buying Price" value="<?php echo set_value("product_buying_price");?>">
		</div>
		
		<div class="form-group">
			<label for="product_selling_price">Selling Price</label>
			<input type="text" class="form-control" name="product_selling_price" placeholder="Enter Selling Price" value="<?php echo set_value("product_selling_price");?>">
		</div>
		
		<div class="form-group">
			<label for="product_balance">Balance</label>
			<input type="text" class="form-control" name="product_balance" placeholder="Enter Balance" value="<?php echo set_value("product_balance");?>">
		</div>
		
		<div class="form-group">
			<label for="product_description">Description</label>
			<textarea name="product_description" class="form-control"><?php echo set_value("product_description");?></textarea>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="image">Product Image</label>
		
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
				<div>
					<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"></span>
					<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label" for="image">Gallery Images</label>
			<div class="controls">
				<?php echo form_upload(array( 'name'=>'gallery[]', 'multiple'=>true ));?>
            </div>
        </div>
        
		<div class="form-group">
			<input type="submit" value="Add Product" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>