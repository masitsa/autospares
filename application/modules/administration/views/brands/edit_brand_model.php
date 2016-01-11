<?php
foreach($brand_models as $cat){
					
	$brand_id = $cat->brand_id;
	$brand_model_name = $cat->brand_model_name;
}

$brand = set_value("brand_id");
$model = set_value("brand_model_name");
if(
	(!empty($brand)) || 
	(!empty($model))
){
	$brand_id = set_value("brand_id");
	$brand_model_name = set_value("brand_model_name");
}
?>	
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Edit <?php echo $brand_model_name;?></h3>
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
			<label for="category_id">Brand</label>
			<select class="form-control" name="brand_id">
            	<?php
					if(count($brands) > 0){
						foreach($brands as $cat){
					
							$brand_name = $cat->brand_name;
							$brand_id2 = $cat->brand_id;
							
							if($brand_id2 == $brand_id){
								?>
								<option value="<?php echo $brand_id2?>" selected><?php echo $brand_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $brand_id2?>"><?php echo $brand_name?></option>
								<?php
							}
						}
					}
				?>
            </select>
		</div>
        
		<div class="form-group">
			<label for="brand_name">Model Name</label>
			<input type="text" class="form-control" name="brand_model_name" placeholder="Enter Model Name" value="<?php echo $brand_model_name;?>">
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