		
    
<div class="row login">

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

    <div class="col-md-4 col-md-offset-3">
    
        <?php
            $attributes = array('role' => 'form');

            echo form_open($this->uri->uri_string(), $attributes);
        ?>
    
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title login_title">Login</h3>
            </div>
            
            <div class="panel-body">
                
                <div class="form-group">
                    <label for="Username">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter email" value="<?php echo set_value("email");?>">
                </div>
                
                <div class="form-group">
                    <label for="Password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" value="<?php echo set_value("password");?>">
                </div>
            </div>
            
            <div class="panel-footer">
                <input type="submit" value="Log In" class="login_btn btn btn-success btn-lg">
            </div>
        </div><!--panel-->
        
        <?php echo form_close();?><!-- End Login -->
    </div><!--md-3-->
    
</div><!--login-->