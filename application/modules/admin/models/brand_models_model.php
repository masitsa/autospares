<?php

class Brand_models_model extends CI_Model 
{	
	/*
	*	Retrieve all active brand_models
	*
	*/
	public function all_active_brand_models()
	{
		$this->db->where('brand_model_status = 1');
		$query = $this->db->get('brand_model');
		
		return $query;
	}
	
	/*
	*	Retrieve latest brand_model
	*
	*/
	public function latest_brand_model()
	{
		$this->db->limit(1);
		$this->db->order_by('created', 'DESC');
		$query = $this->db->get('brand_model');
		
		return $query;
	}
	
	/*
	*	Retrieve all brand_models
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_brand_models($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('brand.brand_name, brand_model.brand_model_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Add a new brand_model
	*
	*/
	public function add_brand_model()
	{
		$data = array(
			'brand_id'=>$this->input->post('brand_id'),
			'brand_model_status'=>$this->input->post('brand_model_status'),
			'brand_model_name'=>$this->input->post('brand_model_name')
		);
		if($this->db->insert('brand_model', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing brand_model
	*	@param int $brand_model_id
	*
	*/
	public function update_brand_model($brand_model_id)
	{
		$data = array(
			'brand_id'=>$this->input->post('brand_id'),
			'brand_model_status'=>$this->input->post('brand_model_status'),
			'brand_model_name'=>$this->input->post('brand_model_name')
		);
			
		$this->db->where('brand_model_id', $brand_model_id);
		if($this->db->update('brand_model', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single brand_model's details
	*	@param int $brand_model_id
	*
	*/
	public function get_brand_model($brand_model_id)
	{
		//retrieve all users
		$this->db->from('brand_model');
		$this->db->select('*');
		$this->db->where('brand_model_id = '.$brand_model_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing brand_model
	*	@param int $brand_model_id
	*
	*/
	public function delete_brand_model($brand_model_id)
	{
		if($this->db->delete('brand_model', array('brand_model_id' => $brand_model_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated brand_model
	*	@param int $brand_model_id
	*
	*/
	public function activate_brand_model($brand_model_id)
	{
		$data = array(
				'brand_model_status' => 1
			);
		$this->db->where('brand_model_id', $brand_model_id);
		
		if($this->db->update('brand_model', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated brand_model
	*	@param int $brand_model_id
	*
	*/
	public function deactivate_brand_model($brand_model_id)
	{
		$data = array(
				'brand_model_status' => 0
			);
		$this->db->where('brand_model_id', $brand_model_id);
		
		if($this->db->update('brand_model', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function get_brand_model_id($brand_model_name)
	{
		//retrieve all users
		$this->db->from('brand_model');
		$this->db->select('brand_model_id');
		$this->db->where('brand_model_name', $brand_model_name);
		$query = $this->db->get();
		$post_id = FALSE;
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$brand_model_id = $row->brand_model_id;
		}
		
		return $brand_model_id;
	}
}
?>