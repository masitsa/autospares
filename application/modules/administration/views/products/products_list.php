	<div class="main_items col-sm-10 col-md-10">
    	<?php
		
        	if(is_array($products)){
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th></th>
                    	<th>Brand</th>
                    	<th>Model</th>
                    	<th>Code</th>
                    	<th>Category</th>
                    	<th>Selling Price</th>
                    	<th>Date Added</th>
                    	<th>Customer</th>
                    	<th>Transaction No.</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				foreach($products as $cat){
					
					$brand_model_name = $cat->brand_model_name;
					$brand_name = $cat->brand_name;
					$product_code = $cat->product_code;
					$product_id = $cat->product_id;
					$product_description = $cat->product_description;
					$product_name = $cat->product_name;
					$product_selling_price = $cat->product_selling_price;
					$product_buying_price = $cat->product_buying_price;
					$customer_name = $cat->customer_name;
					$product_status = $cat->product_status;
					$product_image_name = $cat->product_image_name;
					$product_date = date('jS M Y H:i a',strtotime($cat->product_date));
					$category_name = $cat->category_name;
					$transaction_number = $cat->transaction_number;
					
					if($product_status == 1){
						$status = "active";
						$class = 'success';
					}
					else{
						$status = "deactivated";
						$class = 'danger';
					}
					?>
                    <tr class="<?php echo $class;?>">
                    	<td>
                        	<img src="<?php echo base_url();?>assets/products/thumbs/<?php echo $product_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $product_name?>">
                        </td>
                    	<td><?php echo $brand_name?></td>
                    	<td><?php echo $brand_model_name?></td>
                    	<td><?php echo $product_code?></td>
                    	<td><?php echo $category_name?></td>
                    	<td><?php echo $product_selling_price?></td>
                    	<td><?php echo $product_date?></td>
                    	<td><?php echo $customer_name?></td>
                    	<td><?php echo $transaction_number?></td>
                    	<td>
                        	<!-- <a href="#" class="btn btn-gray col-md-6" style="background-color:#4E69A2; color:#fff; margin-top:16px; float:left; max-height:25px; padding-top:1px; width:80px;" onclick="facebook_share('<?php echo $product_image_name;?>', '<?php echo $brand_name;?> <?php echo $brand_model_name;?> <?php echo $category_name;?>', '<?php echo $product_selling_price;?>')"><i class="fa fa-facebook-square"></i> Share</a> -->
                        	<a href="<?php echo $product_id;?>" class="i_size view_product" title="View">
                            <button class="btn btn-primary btn-sm col-md-6" type="button" data-toggle="modal" data-target="#view_product"  ><span class="glyphicon glyphicon-list"></span> View</button>
                            </a>
                        	<a href="<?php echo site_url()."administration/edit_product/".$product_id;?>" class="i_size" title="Edit">
                            <button class="btn btn-success btn-sm col-md-6" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            	
                            </a>
                        	<a href="<?php echo $product_id;?>" class="i_size delete_product" title="Delete">
                            <button class="btn btn-danger btn-sm col-md-6" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            	
                            </a>
                            <?php
								if($product_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate_product/".$product_id;?>" class="i_size" title="Deactivate">
                            <button class="btn btn-warning btn-sm col-md-6" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                            
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate_product/".$product_id;?>" class="i_size" title="Activate">
                            <button class="btn btn-info btn-sm col-md-6" type="button" ><i class="fa fa-thumbs-o-up"></i> Activate</button>
                                            
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
				echo "There are no products to display :-(";
			}
		?>
    </div><!-- End Content -->
</div>

<!-- Modal -->
<div class="modal fade" id="view_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="product_content">
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->