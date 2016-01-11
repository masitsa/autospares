	<div class="main_items col-sm-10 col-md-10">
    	<?php 
            if(count($contacts) > 0){
				foreach($contacts as $cat){
					
					$contacts_id = $cat->contacts_id;
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
            
            else{
                $contacts_id = "";
                $email = "";
                $phone = "";
                $post = "";
                $physical = "";
				$facebook = "";
				$site_name = "";
				$logo = "";
				$blog = "";
            }
        ?>
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
    	<h3>Website</h3>
		
        <div class="form-group">
            <label for="category_name">Site Name</label>
            <input type="text" class="form-control" name="site_name" placeholder="Enter Site Name" value="<?php echo $site_name;?>">
        </div>
		
		<label class="control-label" for="image">Site Logo</label>
        <input type="hidden" name="logo" value="<?php echo $logo?>"/>
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
            	<img src="<?php echo base_url();?>assets/logo/images/<?php echo $logo?>" class="img-responsive img-thumbnail" alt="<?php echo $site_name?>">
            </div>
            <div>
                <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="userfile"></span>
                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
            </div>
        </div>
        
    	<h3>Contacts</h3>
		
        <div class="form-group">
            <label for="category_name">Email</label>
            <input type="text" class="form-control" name="email" placeholder="Enter Email" value="<?php echo $email;?>">
        </div>
        <div class="form-group">
            <label for="category_name">Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="Enter Phone" value="<?php echo $phone;?>">
        </div>
        <div class="form-group">
            <label for="category_name">Postal Address</label>
            <input type="text" class="form-control" name="post" placeholder="Enter Postal Address" value="<?php echo $post;?>">
        </div>
        <div class="form-group">
            <label for="category_name">Physical Address</label>
            <input type="text" class="form-control" name="physical" placeholder="Enter Physical Address" value="<?php echo $physical;?>">
        </div>
        <div class="form-group">
            <label for="category_name">Facebook Address</label>
            <input type="text" class="form-control" name="facebook" placeholder="Enter Facebook Address" value="<?php echo $facebook;?>">
        </div>
        <div class="form-group">
            <label for="category_name">Blog</label>
            <input type="text" class="form-control" name="blog" placeholder="Enter Blog Address" value="<?php echo $blog;?>">
        </div>
        <div class="form-group">
            <input type="submit" value="Edit Contacts" class="login_btn btn btn-success btn-lg">
        </div>
        <?php form_close();?>
    </div><!-- End Content -->
</div>