	<div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>New Module</h3>
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
			<label for="category_name">Module Name</label>
			<input type="text" class="form-control" name="module_name" placeholder="Enter Module Name" value="<?php echo set_value("module_name");?>">
		</div>
		<div class="form-group">
			<label for="category_name">Module URL</label>
			<input type="text" class="form-control"name="module_url" placeholder="Enter Module URL" value="<?php echo set_value("module_url");?>">
		</div>
		
		<div class="form-group">
			<input type="submit" value="Add Module" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>