<?php
		
		$result = '<a href="'.site_url().'admin/add-model" class="btn btn-success pull-right">Add Model</a>';
		
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
					  <th>Brand Name</th>
					  <th>Model Name</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$brand_model_id = $row->brand_model_id;
				$brand_name = $row->brand_name;
				$brand_model_name = $row->brand_model_name;
				$brand_model_status = $row->brand_model_status;
				
				//status
				if($brand_model_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($brand_model_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/activate-model/'.$brand_model_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$brand_model_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($brand_model_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/deactivate-model/'.$brand_model_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$brand_model_name.'?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$brand_name.'</td>
						<td>'.$brand_model_name.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'admin/edit-model/'.$brand_model_id.'/'.$page.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'admin/delete-model/'.$brand_model_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$brand_model_name.'?\');">Delete</a></td>
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
			$result .= "There are no brands";
		}
		
		echo $result;
?>