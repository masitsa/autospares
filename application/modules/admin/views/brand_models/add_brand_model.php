          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
                echo '<div class="alert alert-danger"> Oh snap! '.$validation_errors.' </div>';
            }
            ?>
            
            <?php echo form_open($this->uri->uri_string(), array("class" => "form-horizontal", "role" => "form"));?>
            <!-- Category Parent -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Brand Name</label>
                <div class="col-lg-4">
                	<select name="brand_id" class="form-control" required>
                    	<?php
							if($brands->num_rows() > 0){
								foreach($brands->result() as $cat){
							
									$brand_name = $cat->brand_name;
									$brand_id = $cat->brand_id;
									
									if($brand_id == set_value("brand_id")){
										?>
										<option value="<?php echo $brand_id?>" selected><?php echo $brand_name?></option>
										<?php
									}
									
									else{
										?>
										<option value="<?php echo $brand_id?>"><?php echo $brand_name?></option>
										<?php
									}
								}
							}
						?>
                    </select>
                </div>
            </div>
            <!-- brand Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Model Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="brand_model_name" placeholder="Model Name" value="<?php echo set_value('brand_model_name');?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Model?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                            <input id="optionsRadios1" type="radio" checked value="1" name="brand_model_status">
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input id="optionsRadios2" type="radio" value="0" name="brand_status">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Add Model
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>