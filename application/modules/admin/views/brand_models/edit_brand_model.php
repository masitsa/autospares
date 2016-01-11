          <link href="<?php echo base_url()."assets/themes/jasny/css/jasny-bootstrap.css"?>" rel="stylesheet"/>
          <div class="padd">
            <!-- Adding Errors -->
            <?php
            if(isset($error)){
                echo '<div class="alert alert-danger"> Oh snap! Change a few things up and try submitting again. </div>';
            }
			
			//the brand details
			$brand_id = $brand_model[0]->brand_id;
			$brand_model_name = $brand_model[0]->brand_model_name;
			$brand_model_status = $brand_model[0]->brand_model_status;
            
            $validation_errors = validation_errors();
            
            if(!empty($validation_errors))
            {
				$brand_id = set_value('brand_id');
				$brand_model_name = set_value('brand_name');
				$brand_model_status = set_value('brand_status');
				
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
									$brand_id2 = $cat->brand_id;
									
									if($brand_id == $brand_id2){
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
            </div>
            <!-- brand Name -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Brand Name</label>
                <div class="col-lg-4">
                	<input type="text" class="form-control" name="brand_model_name" placeholder="brand Name" value="<?php echo $brand_model_name;?>" required>
                </div>
            </div>
            <!-- Activate checkbox -->
            <div class="form-group">
                <label class="col-lg-4 control-label">Activate Model?</label>
                <div class="col-lg-4">
                    <div class="radio">
                        <label>
                        	<?php
                            if($brand_model_status == 1){echo '<input id="optionsRadios1" type="radio" checked value="1" name="brand_model_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="1" name="brand_model_status">';}
							?>
                            Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                        	<?php
                            if($brand_model_status == 0){echo '<input id="optionsRadios1" type="radio" checked value="0" name="brand_model_status">';}
							else{echo '<input id="optionsRadios1" type="radio" value="0" name="brand_model_status">';}
							?>
                            No
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-actions center-align">
                <button class="submit btn btn-primary" type="submit">
                    Edit Model
                </button>
            </div>
            <br />
            <?php echo form_close();?>
		</div>