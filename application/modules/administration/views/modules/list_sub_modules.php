	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($navigation) > 0){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th></th>
                    	<th>Navigation</th>
                    	<th>Sub Navigation</th>
                    	<th>Navigation URL</th>
                    	<th>Sub Navigation URL</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				$count = 0;
				foreach($navigation as $cat){
					$count++;
					$navigation_name = $cat->navigation_name;
					$navigation_url = $cat->navigation_url;
					$sub_navigation_name = $cat->sub_navigation_name;
					$sub_navigation_url = $cat->sub_navigation_url;
					$sub_navigation_id = $cat->sub_navigation_id;
					?>
                    <tr>
                    	<td><?php echo $count?></td>
                    	<td><?php echo $navigation_name?></td>
                    	<td><?php echo $sub_navigation_name?></td>
                    	<td><?php echo $navigation_url?></td>
                    	<td><?php echo $sub_navigation_url?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/edit_sub_module/".$sub_navigation_id;?>" class="i_size" title="Edit">	
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </a>
                        	<a href="<?php echo $sub_navigation_id;?>" class="i_size delete_sub_module" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                        </td>
                    </tr>
                    <?php
				}
				?>
                </table>
                <?php
			}
			
			else{
				echo "There are no modules to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>