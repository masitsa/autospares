<?php
foreach($category as $cat){
	
	$category_name = $cat->category_name;
	$category_preffix = $cat->category_preffix;
	$category_image_name = $cat->category_image_name;
	$category_parent = $cat->category_parent;
}

$name = set_value("category_name");
$preffix = set_value("category_preffix");
$parent = set_value("category_parent");
if(
	(!empty($name)) || 
	(!empty($preffix)) || 
	(!empty($parent))
){
	$category_name = set_value("category_name");
	$category_parent = set_value("category_parent");
	$category_preffix = set_value("category_preffix");
}
?>
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Update Category</h3>
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
        <input type="hidden" name="category_image_name" value="<?php echo $category_image_name?>"/>
		<div class="form-group">
			<label for="category_name">Category Name</label>
			<input type="text" class="form-control" name="category_name" placeholder="Enter Category Name" value="<?php echo $category_name;?>">
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
							
							if($category_parent == $category_id){
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
			<input type="text" class="form-control" name="category_preffix" placeholder="Enter Preffix" value="<?php echo $category_preffix;?>">
		</div>
		
		<label class="control-label" for="image">Category Image</label>
        <div class="fileinput fileinput-new" data-provides="fileinput">
        	<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
        		<img src="<?php echo base_url();?>assets/categories/images/<?php echo $category_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $category_name?>">
        	</div>
        	<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
        	<div>
        		<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"></span>
        		<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
        	</div>
        </div>
		
		<div class="form-group">
			<input type="submit" value="Update Category" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
	?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>