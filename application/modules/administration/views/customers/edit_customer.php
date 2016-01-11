<?php
	if(count($customers) > 0){
		
		foreach($customers as $cat){
			
			$customer_name = $cat->customer_name;
			$customer_email = $cat->customer_email;
			$customer_phone = $cat->customer_phone;
		}
	}
?>
    <div class="main_items col-sm-10 col-md-10">
    	
        <div class="input_form">
        <h3>Edit Customer</h3>
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
			<label for="customer_name">Name</label>
			<input type="text" class="form-control" name="customer_name" placeholder="Enter Name" value="<?php echo $customer_name;?>">
		</div>
		<div class="form-group">
			<label for="customer_email">Email</label>
			<input type="text" class="form-control"name="customer_email" placeholder="Enter Email" value="<?php echo $customer_email;?>">
		</div>
		<div class="form-group">
			<label for="customer_phone">Phone</label>
			<input type="text" class="form-control"name="customer_phone" placeholder="Enter Phone No." value="<?php echo $customer_phone;?>">
		</div>
		
		<div class="form-group">
			<input type="submit" value="Update Customer" class="login_btn btn btn-success btn-lg">
		</div>
		<?php
			form_close();
		?>
        </div><!-- input form -->
    </div><!-- End Content -->
</div>