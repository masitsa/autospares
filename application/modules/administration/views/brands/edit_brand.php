<?php
foreach($brands as $cat){
					
	$brand_name = $cat->brand_name;
	$brand_image_name = $cat->brand_image_name;
}

$name = set_value("brand_name");
$image = set_value("brand_image_name");
if(
	(!empty($name)) || 
	(!empty($image))
){
	$brand_name = set_value("brand_name");
	$brand_image_name = set_value("brand_image_name");
}
?>	
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Edit <?php echo $brand_name;?></h3>
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
			<label for="brand_name">Brand Name</label>
			<input type="text" class="form-control" name="brand_name" placeholder="Enter Brand Name" value="<?php echo $brand_name;?>">
		</div>
		
		<div class="form-group">
        	<input type="hidden" name="hidden_image" value="<?php echo $brand_image_name;?>"
			<label class="control-label" for="image">Brand Image</label>
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="<?php echo base_url();?>assets/products/images/<?php echo $brand_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $brand_name?>">
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                <div>
                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"></span>
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                </div>
            </div>
		</div>
		
		<div class="form-group">
			<input type="submit" value="Edit Brand" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>