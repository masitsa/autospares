	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($pages) > 0){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>Page Name</th>
                    	<th>Page URL</th>
                    	<th>Position</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($pages as $cat){
					
					$page_id = $cat->page_id;
					$page_name = $cat->page_name;
					$page_url = $cat->page_url;
					$page_status = $cat->page_status;
					$page_position = $cat->page_position;
					
					if($page_status == 1){
						$status = "active";
					}
					else{
						$status = "deactivated";
					}
					?>
                    <tr>
                    	<td><?php echo $page_name?></td>
                    	<td><?php echo $page_url?></td>
                    	<td><?php echo $page_position?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/edit_page/".$page_id;?>" class="i_size" title="Edit">	
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </a>
                        	<a href="<?php echo $page_id;?>" class="i_size delete_page" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($page_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_page/".$page_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_page/".$page_id;?>" class="i_size" title="Activate">
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
				echo "There are no pages to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>