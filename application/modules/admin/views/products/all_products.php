<?php
		
		$result = '<!--<a href="'.site_url().'add-product" class="btn btn-success pull-right">Add Part</a>-->';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Image</th>
					  <th>Code</th>
					  <th>Part</th>
					  <th>Price</th>
					  <th>Date Added</th>
					  <th>Customer</th>
					  <th>Transaction No.</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $cat)
			{
				$brand_model_name = $cat->brand_model_name;
				$brand_name = $cat->brand_name;
				$product_code = $cat->product_code;
				$product_id = $cat->product_id;
				$product_description = $cat->product_description;
				$product_selling_price = number_format($cat->product_selling_price, 0);
				$product_buying_price = $cat->product_buying_price;
				$customer_name = $cat->customer_name;
				$product_status = $cat->product_status;
				$product_image_name = $cat->product_image_name;
				$product_date = date('jS M Y H:i a',strtotime($cat->product_date));
				$category_name = $cat->category_name;
				$transaction_number = $cat->transaction_number;
				$product_name = $brand_name.' '.$brand_model_name.' '.$category_name;
					
				if($product_status == 1){
					$class = 'success';
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-default" href="'.site_url().'admin/deactivate-product/'.$product_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$product_name.'?\');">Deactivate</a>';
				}
				else{
					$class = 'danger';
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/activate-product/'.$product_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$product_name.'?\');">Activate</a>';
				}
				
				//create deactivated status display
				if($product_status == 0)
				{
				}
				//create activated status display
				else if($product_status == 1)
				{
				}
				
				$count++;
				$result .= 
				'
					<tr class="'.$class.'">
						<td>'.$count.'</td>
						<td><img src="'.base_url()."assets/products/thumbs/".$product_image_name.'"></td>
						<td>'.$product_code.'</td>
						<td>'.$product_name.'</td>
						<td>'.$product_selling_price.'</td>
						<td>'.$product_date.'</td>
						<td>'.$customer_name.'</td>
						<td>'.$transaction_number.'</td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'admin/delete-product/'.$product_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$product_name.'?\');">Delete</a></td>
					</tr> 
				';
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no products";
		}
		
		echo $result;
?>