	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($brand_models) > 0){
				?>
                
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>Brand</th>
                    	<th>Model</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($brand_models as $cat){
					
					$brand_name = $cat->brand_name;
					$brand_model_name = $cat->brand_model_name;
					$brand_model_id = $cat->brand_model_id;
					$brand_model_status = $cat->brand_model_status;
					
					if($brand_model_status == 1){
						$status = "active";
					}
					else{
						$status = "deactivated";
					}
					?>
                    <tr>
                    	<td><?php echo $brand_name?></td>
                    	<td><?php echo $brand_model_name?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/edit_brand_model/".$brand_model_id;?>" class="i_size" title="Edit">	
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </a>
                        	<a href="<?php echo $brand_model_id;?>" class="i_size delete_brand_model" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($brand_model_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_brand_model/".$brand_model_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_brand_model/".$brand_model_id;?>" class="i_size" title="Activate">
                            <button class="btn btn-info btn-sm" type="button" ><i class="fa fa-thumbs-o-up"></i> Activate</button>
                                        </a>
                                    <?php
								}
							?>
                        </td>
                    </tr>
                    <?php
				}
				?>
                </table>
                <?php
				if(isset($links)){
					echo $links;
				}
			}
			
			else{
				echo "There are no models to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>