<?php

class Categories_model extends CI_Model 
{	
	/*
	*	Retrieve all categories
	*
	*/
	public function all_categories()
	{
		$this->db->where('category_status = 1');
		$query = $this->db->get('category');
		
		return $query;
	}
	/*
	*	Retrieve latest category
	*
	*/
	public function latest_category()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('category');
		
		return $query;
	}
	/*
	*	Retrieve all parent categories
	*
	*/
	public function all_parent_categories()
	{
		$this->db->where('category_status = 1 AND category_parent = 0');
		$this->db->order_by('category_name', 'ASC');
		$query = $this->db->get('category');
		
		return $query;
	}
	/*
	*	Retrieve all children categories
	*
	*/
	public function all_child_categories()
	{
		$this->db->where('category_status = 1 AND category_parent > 0');
		$this->db->order_by('category_name', 'ASC');
		$query = $this->db->get('category');
		
		return $query;
	}
	
	/*
	*	Retrieve all categories
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_categories($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('category_parent', 'ASC');
		$this->db->order_by('category_name', 'ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new category
	*	@param string $image_name
	*
	*/
	public function add_category($image_name)
	{
		$data = array(
				'category_name'=>ucwords(strtolower($this->input->post('category_name'))),
				'category_parent'=>$this->input->post('category_parent'),
				'category_preffix'=>strtoupper($this->input->post('category_preffix')),
				'category_status'=>$this->input->post('category_status'),
				'category_image_name'=>$image_name
			);
			
		if($this->db->insert('category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing category
	*	@param string $image_name
	*	@param int $category_id
	*
	*/
	public function update_category($image_name, $category_id)
	{
		$data = array(
				'category_name'=>ucwords(strtolower($this->input->post('category_name'))),
				'category_parent'=>$this->input->post('category_parent'),
				'category_preffix'=>strtoupper($this->input->post('category_preffix')),
				'category_status'=>$this->input->post('category_status'),
				'category_image_name'=>$image_name
			);
			
		$this->db->where('category_id', $category_id);
		if($this->db->update('category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single category's children
	*	@param int $category_id
	*
	*/
	public function get_sub_categories($category_id)
	{
		//retrieve all users
		$this->db->from('category');
		$this->db->select('*');
		$this->db->where('category_parent = '.$category_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single category's details
	*	@param int $category_id
	*
	*/
	public function get_category($category_id)
	{
		//retrieve all users
		$this->db->from('category');
		$this->db->select('*');
		$this->db->where('category_id = '.$category_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	get a single category's details
	*	@param int $category_id
	*
	*/
	public function get_category_by_name($category_name)
	{
		//retrieve all users
		$this->db->from('category');
		$this->db->select('*');
		$this->db->where('category_name', $category_name);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing category
	*	@param int $category_id
	*
	*/
	public function delete_category($category_id)
	{
		if($this->db->delete('category', array('category_id' => $category_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated category
	*	@param int $category_id
	*
	*/
	public function activate_category($category_id)
	{
		$data = array(
				'category_status' => 1
			);
		$this->db->where('category_id', $category_id);
		
		if($this->db->update('category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated category
	*	@param int $category_id
	*
	*/
	public function deactivate_category($category_id)
	{
		$data = array(
				'category_status' => 0
			);
		$this->db->where('category_id', $category_id);
		
		if($this->db->update('category', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function total_categories()
	{
		$this->db->from('category');
		$this->db->where('category_status = 1');
		return $this->db->count_all_results();
	}
	
	public function get_category_id($category_name)
	{
		//retrieve all users
		$this->db->from('category');
		$this->db->select('category_id');
		$this->db->where('category_name', $category_name);
		$query = $this->db->get();
		$post_id = FALSE;
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$category_id = $row->category_id;
		}
		
		return $category_id;
	}
	
	public function limit_sub_categories($category_id)
	{
		$children = '';
		$this->db->where("category_parent = ".$category_id);
		$this->db->order_by("category_name");
		
		$result2 = $this->db->get("category");
		
		if($result2->num_rows() > 0)
		{
			foreach($result2->result() as $res2)
			{
				$category_web_name = $this->site_model->create_web_name($res2->category_name);
				$total_categories = $this->count_products($res2->category_id);
				$children .= '<li class="list-group-item"><span class="badge">'.$total_categories.'</span><a href="'.site_url().'spareparts/category/'.$category_web_name.'" title="View all parts under'.$res2->category_name.'">'.$res2->category_name.'</a></li>';
			}
		}
		
		return $children;
	}
	
	public function count_products($category_id)
	{
		$table2 = "product, category, brand_model, brand, location, customer";
		$where2 = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		
		$total_categories = $this->users_model->count_items($table2, $where2.' AND (category.category_id = '.$category_id.' OR category.category_parent = '.$category_id.' OR category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent = '.$category_id.')  OR category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent = '.$category_id.')))');
		
		return $total_categories;
	}
	
	/*
	*	Check if a category is a parent
	*	@param int $category_id
	*
	*/
	public function check_parent($category_id)
	{
		//retrieve all users
		$this->db->from('category');
		$this->db->select('*');
		$this->db->where('category_id = '.$category_id);
		$query = $this->db->get();
		
		$row = $query->row();
		$category_parent = $row->category_parent;
		
		if($category_parent == 0)
		{
			return $category_id;
		}
		
		else
		{
			return $category_parent;
		}
	}
}
?>