
			<label for="brand_model_id">Model</label>
			<select class="form-control" name="brand_model_id">
            	<?php
					if(count($brand_models) > 0){
						foreach ($brand_models as $cat){
							$brand_model_name = $cat->brand_model_name;
							$brand_model_id = $cat->brand_model_id;
							
							if(set_value("brand_model_id") == $brand_model_id){
								?>
								<option value="<?php echo $brand_model_id?>" selected><?php echo $brand_model_name?></option>
								<?php
							}
							
							else{
								?>
								<option value="<?php echo $brand_model_id?>"><?php echo $brand_model_name?></option>
								<?php
							}
						}
					}
				?>
            </select>