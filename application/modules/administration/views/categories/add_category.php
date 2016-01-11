	<div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>New Category</h3>
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
			<label for="category_name">Category Name</label>
			<input type="text" class="form-control" name="category_name" placeholder="Enter Category Name" value="<?php echo set_value("category_name");?>">
		</div>
		<div class="form-group">
			<label for="category_name">Category Parent</label>
			<select class="form-control" name="category_parent" placeholder="Select Parent">
            	<option value="0">---No Parent---</option>
            	<?php
					if(count($children) > 0){
						foreach ($children as $cat){
							$category_name = $cat->category_name;
							$category_id = $cat->category_id;
							
							if(set_value("category_preffix") == $category_id){
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
			<label for="category_preffix">Preffix</label>
			<input type="text" class="form-control" name="category_preffix" placeholder="Enter Preffix" value="<?php echo set_value("category_preffix");?>">
		</div>
		
		<label class="control-label" for="image">Category Image</label>
			<div class="fileinput fileinput-new" data-provides="fileinput">
				<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="background-color:#c64133;width:200px; height:200px;">
					<div>
                        <span class="btn btn-file btn-info"><span class="fileinput-new">Select Image</span><span class="fileinput-exists">Change</span><input type="file" name="category_image"></span>
                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
					</div>
				</div>
			</div>
		
		<div class="form-group">
			<input type="submit" value="Add Category" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>