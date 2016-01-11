<?php	
		$result = '<a href="'.site_url().'add-customer" class="btn btn-success pull-right">Add Customer</a>';
		
		//if customers exist display them
		if ($customers->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
			'
				<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Name</th>
					  <th>Phone</th>
					  <th>Email</th>
					  <th>Joined</th>
					  <th colspan="2">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			foreach ($customers->result() as $row)
			{
				$customer_id = $row->customer_id;
				$fname = $row->customer_name;
				$phone = $row->customer_phone;
				$email = $row->customer_email;
				$featured = $row->featured;
				
				if($featured == 1)
				{
					$featured = '<td><a href="'.site_url().'unfeature-customer/'.$customer_id.'" class="btn btn-sm btn-default">Unfeature</a></td>';
				}
				else
				{
					$featured = '<td><a href="'.site_url().'feature-customer/'.$customer_id.'" class="btn btn-sm btn-success">Feature</a></td>';
				}
				//create deactivated status display
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$fname.'</td>
						<td>'.$phone.'</td>
						<td>'.$email.'</td>
						<td>'.date('jS M Y H:i a',strtotime($row->customer_joined)).'</td>
						<td><a href="'.site_url().'edit-customer/'.$customer_id.'" class="btn btn-sm btn-info">Edit</a></td>
						'.$featured.'
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
			$result .= "There are no customers";
		}
		
		echo $result;
?>