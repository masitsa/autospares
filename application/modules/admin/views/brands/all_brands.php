<?php
		
		$result = '<a href="'.site_url().'admin/add-brand" class="btn btn-success pull-right">Add Brand</a>';
		
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
					  <th>Brand Name</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			foreach ($query->result() as $row)
			{
				$brand_id = $row->brand_id;
				$brand_name = $row->brand_name;
				$brand_status = $row->brand_status;
				$image = $row->brand_image_name;
				
				//status
				if($brand_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				
				//create deactivated status display
				if($brand_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/activate-brand/'.$brand_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$brand_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($brand_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/deactivate-brand/'.$brand_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$brand_name.'?\');">Deactivate</a>';
				}
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td style="background-color:#c64133;"><img src="'.base_url()."assets/brand/images/".$image.'"></td>
						<td>'.$brand_name.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'admin/edit-brand/'.$brand_id.'/'.$page.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'admin/delete-brand/'.$brand_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$brand_name.'?\');">Delete</a></td>
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