	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($slides) > 0){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>Slide</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($slides as $cat){
					
					$slideshow_id = $cat->slideshow_id;
					$slideshow_status = $cat->slideshow_status;
					$slideshow_image_name = $cat->slideshow_image_name;
					
					if($slideshow_status == 1){
						$status = "active";
					}
					else{
						$status = "deactivated";
					}
					?>
                    <tr>
                    	<td>
                        <img src="<?php echo base_url();?>assets/slideshow/images/<?php echo $slideshow_image_name?>" width="450" class="img-responsive img-thumbnail">
                        </td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo $slideshow_id;?>" class="i_size delete_slide" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($slideshow_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_slideshow/".$slideshow_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_slideshow/".$slideshow_id;?>" class="i_size" title="Activate">
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
			}
			
			else{
				echo "There are no slides to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>