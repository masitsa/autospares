<?php
if(count($pages) > 0){
	
	foreach($pages as $cat){
		
		$page_name = $cat->page_name;
		$page_url = $cat->page_url;
		$page_status = $cat->page_status;
		$page_position = $cat->page_position;
	}
}
?>
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>New Page</h3>
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
			<label for="category_name">Page Name</label>
			<input type="text" class="form-control" name="page_name" placeholder="Enter Page Name" value="<?php echo $page_name;?>">
		</div>
		<div class="form-group">
			<label for="category_name">Page Position</label>
			<input type="text" class="form-control" name="page_position" placeholder="Enter Page Position" value="<?php echo $page_position;?>">
		</div>
		<div class="form-group">
			<label for="category_name">Page URL</label>
			<input type="text" class="form-control"name="page_url" placeholder="Enter Page URL" value="<?php echo $page_url;?>">
		</div>
		
		<div class="form-group">
			<input type="submit" value="Edit Page" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>