	<div class="main_items col-sm-10 col-md-10">
    	<?php
        	if(count($customers) > 0){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th></th>
                    	<th>Date Joined</th>
                    	<th>Name</th>
                    	<th>Email</th>
                    	<th>Phone</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				$count = 0;
				foreach($customers as $cat){
					$count++;
					$customer_name = $cat->customer_name;
					$customer_email = $cat->customer_email;
					$customer_id = $cat->customer_id;
					$customer_joined = date('jS M Y H:i a',strtotime($cat->customer_joined));
					$customer_phone = $cat->customer_phone;
					?>
                    <tr>
                    	<td><?php echo $count?></td>
                    	<td><?php echo $customer_joined?></td>
                    	<td><?php echo $customer_name?></td>
                    	<td><?php echo $customer_email?></td>
                    	<td><?php echo $customer_phone?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/customers/edit_customer/".$customer_id.'/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'];?>" class="i_size" title="Edit">	
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            </a>
                        	<a href="<?php echo $customer_id;?>" class="i_size delete_customer" title="Delete">
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
				echo "There are no customers to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>