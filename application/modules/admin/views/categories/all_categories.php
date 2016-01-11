<?php
		
		$result = '<a href="'.site_url().'admin/add-category" class="btn btn-success pull-right">Add Category</a>';
		
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
					  <th>Category Name</th>
					  <th>Category Parent</th>
					  <th>Status</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$category_id = $row->category_id;
				$category_name = $row->category_name;
				$parent = $row->category_parent;
				$category_status = $row->category_status;
				$image = $row->category_image_name;
				$category_image_name = $row->category_image_name;
				
				//status
				if($category_status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Disabled';
				}
				$category_parent = '-';
				
				//category parent
				$categories_query = $this->categories_model->all_categories();
				foreach($categories_query->result() as $row2)
				{
					$category_id2 = $row2->category_id;
					if($parent == $category_id2)
					{
						$category_parent = $row2->category_name;
						break;
					}
				}
				
				//create deactivated status display
				if($category_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/activate-category/'.$category_id.'/'.$page.'" onclick="return confirm(\'Do you want to activate '.$category_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($category_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-info" href="'.site_url().'admin/deactivate-category/'.$category_id.'/'.$page.'" onclick="return confirm(\'Do you want to deactivate '.$category_name.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td style="background-color:#c64133;"><img src="'.base_url()."assets/categories/images/".$image.'"></td>
						<td>'.$category_name.'</td>
						<td>'.$category_parent.'</td>
						<td>'.$status.'</td>
						<td><a href="'.site_url().'admin/edit-category/'.$category_id.'/'.$page.'" class="btn btn-sm btn-success">Edit</a></td>
						<td>'.$button.'</td>
						<td><a href="'.site_url().'admin/delete-category/'.$category_id.'/'.$page.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete '.$category_name.'?\');">Delete</a></td>
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
			$result .= "There are no categories";
		}
		
		echo $result;
?>