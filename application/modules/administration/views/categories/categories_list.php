	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($categories) > 0){
				?>
                
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th></th>
                    	<th>Category Parent</th>
                    	<th>Category</th>
                    	<th>Preffix</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($categories as $cat){
					
					$category_name = $cat->category_name;
					$category_id = $cat->category_id;
					$category_parent = $cat->category_parent;
					$category_status = $cat->category_status;
					$category_preffix = $cat->category_preffix;
					$category_image_name = $cat->category_image_name;
					
					if($category_parent > 0){
		
						$table = "category";
						$where = "category_id = ".$category_parent;
						$items = "category_name";
						$order = "category_name";
						$parent = $this->administration_model->select_entries_where($table, $where, $items, $order);
						foreach($parent as $par){
							$parent_name = $par->category_name;
						}
					}
					else{
						$parent_name = "";
					}
					
					if($category_status == 1){
						$status = "active";
					}
					else{
						$status = "deactivated";
					}
					?>
                    <tr>
                    	<td>
                        <img src="<?php echo base_url();?>assets/categories/thumbs/<?php echo $category_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $category_name?>">
                        </td>
                    	<td><?php echo $parent_name?></td>
                    	<td><?php echo $category_name?></td>
                    	<td><?php echo $category_preffix?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/edit_category/".$category_id;?>" class="i_size" title="Edit">	
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </a>
                        	<a href="<?php echo $category_id;?>" class="i_size delete_category" title="Delete">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($category_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_category/".$category_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_category/".$category_id;?>" class="i_size" title="Activate">
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
				echo "There are no categories to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>