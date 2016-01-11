	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($brands) > 0){
				?>
                
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th></th>
                    	<th>Brand</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($brands as $cat){
					
					$brand_name = $cat->brand_name;
					$brand_id = $cat->brand_id;
					$brand_status = $cat->brand_status;
					$brand_image_name = $cat->brand_image_name;
					
					if($brand_status == 1){
						$status = "active";
					}
					else{
						$status = "deactivated";
					}
					?>
                    <tr>
                    	<td>
                        <img src="<?php echo base_url();?>assets/brand/thumbs/<?php echo $brand_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $brand_name?>">
                        </td>
                    	<td><?php echo $brand_name?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/edit_brand/".$brand_id."/".$page;?>" class="i_size" title="Edit">	
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </a>
                        	<a href="<?php echo $brand_id;?>" class="i_size delete_brand" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($brand_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_brand/".$brand_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_brand/".$brand_id;?>" class="i_size" title="Activate">
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
				echo "There are no brands to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>