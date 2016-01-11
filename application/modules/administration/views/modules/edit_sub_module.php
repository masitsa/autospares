<?php
	if(count($sub_navigation) > 0){
		
		foreach($sub_navigation as $cat){
			$navigation_id = $cat->navigation_id;
			$sub_navigation_name = $cat->sub_navigation_name;
			$sub_navigation_url = $cat->sub_navigation_url;
		}
	}
?>
    
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Edit Module</h3>
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
			<label for="category_name">Module</label>
			<select class="form-control" name="module_id" placeholder="Select Module">
            	<?php
					if(count($navigation) > 0){
						foreach ($navigation as $cat){
							$navigation_name = $cat->navigation_name;
							$navigation_id2 = $cat->navigation_id;
							
							if($navigation_id == $navigation_id2){
								?>
								<option value="<?php echo $navigation_id2?>" selected><?php echo $navigation_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $navigation_id2?>"><?php echo $navigation_name?></option>
								<?php
							}
						}
					}
				?>
            </select>
		</div>
		<div class="form-group">
			<label for="category_name">Sub Module Name</label>
			<input type="text" class="form-control" name="sub_module_name" placeholder="Enter Sub Module Name" value="<?php echo $sub_navigation_name;?>">
		</div>
		<div class="form-group">
			<label for="category_name">Sub Module URL</label>
			<input type="text" class="form-control"name="sub_module_url" placeholder="Enter Sub Module URL" value="<?php echo $sub_navigation_url;?>">
		</div>
		
		<div class="form-group">
			<input type="submit" value="Edit Sub Module" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>