<?php 
	if(count($contacts) > 0){
		foreach($contacts as $cat){
			
			$email = $cat->email;
			$phone = $cat->phone;
			$post = $cat->post;
			$physical = $cat->physical;
			$site_name = $cat->site_name;
			$logo = $cat->logo;
			$facebook = $cat->facebook;
			$blog = $cat->blog;
		}
	}
?>
<!-- Home page -->
<div class="home-page">
    <div class="row latest">
    
    <?php
	
	$success = $this->session->userdata('email_success');
	if(!empty($success)){
		echo '<div class="alert alert-success">'.$success.'</div>';
		$this->session->unset_userdata('email_success');
		
	}
	
	$error = $this->session->userdata('email_error');
	if(!empty($error)){
		echo '<div class="alert alert-error">'.$error.'</div>';
		$this->session->unset_userdata('email_error');
	}
	
    $validation_errors = validation_errors();
	if(!empty($validation_errors)){
		echo '<div class="alert alert-danger">'.$validation_errors.'</div>';
	}
	?>
    
<!-- Contacts -->
<div class="col-md-12">
    <fieldset>
        <legend>Contact</legend>
    
    <div class="row">
    	
        <!-- Email us -->
    	<div class="col-md-9">
            <fieldset>
                <legend>Submit an enquiry</legend>
            <?php
            $attributes = array('role' => 'form');
    
            echo form_open($this->uri->uri_string(), $attributes);
            ?>
            <div class="form-group col-md-6">
                <label for="category_name">Your Email</label>
                <input type="email" class="form-control" name="sender_email" placeholder="Your Email" value="<?php echo set_value("sender_email");?>" required="required">
                
                <label for="category_name">Your Name</label>
                <input type="text" class="form-control" name="sender_name" placeholder="Your Name" value="<?php echo set_value("sender_name");?>" required="required">
                
                <label for="category_name">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" value="<?php echo set_value("phone_number");?>" required="required">
                
                <label for="category_name">Subject</label>
                <input type="text" class="form-control" name="subject" placeholder="Subject" value="<?php echo set_value("subject");?>">
            </div>
            <div class="form-group col-md-6 contact">
                <label for="category_name">Message</label>
                <textarea name="message" class="form-control" required="required"><?php echo set_value("message");?></textarea>
            </div>
		
            <div class="btn_align" style="clear:both;">
                <input type="submit" value="Send Email" class="btn btn_pink site_product">
            </div>
            <?php echo form_close();?>
            </fieldset>
        </div>
    	
        <!-- Contacts -->
    	<div class="col-md-3 contact">
            <fieldset>
                <legend>Contact Information</legend>
            <div>
                <i class="fa fa-envelope fa-2x" style="padding-left:4%;"></i> <?php echo $email;?>
            </div>
            <div>
                <i class="fa fa-mobile fa-3x" style="padding-left:6%;"></i> <?php echo $phone;?>
            </div>
            <div>
                <i class="fa fa-map-marker fa-3x" style="padding-left:5%;"></i> <?php echo $physical;?>
            </div>
            <div>
                <i class="fa fa-facebook-square fa-2x" style="padding-left:5%;"></i> <a href="<?php echo $facebook;?>" class="auto_grey" target="_blank">Autospares</a>
            </div>
            </fieldset>
        </div>
    </div>
</div>
</fieldset>
</div>
</div>