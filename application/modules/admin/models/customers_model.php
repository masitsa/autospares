<?php

class Customers_model extends CI_Model 
{
	
	
	/*
	*	Retrieve all customers
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_customers($table, $where, $per_page, $page)
	{
		//retrieve all customers
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('customer_name');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Retrieve all administrators
	*
	*/
	public function get_all_administrators()
	{
		$this->db->from('customers');
		$this->db->select('*');
		$this->db->where('customer_level_id = 1');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all front end customers
	*
	*/
	public function get_all_front_end_customers()
	{
		$this->db->from('customers');
		$this->db->select('*');
		$this->db->where('customer_level_id = 2');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_all_countries()
	{
		//retrieve all customers
		$query = $this->db->get('country');
		
		return $query;
	}
	
	/*
	*	Add a new customer to the database
	*
	*/
	public function add_customer()
	{
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'other_names'=>ucwords(strtolower($this->input->post('other_names'))),
				'email'=>$this->input->post('email'),
				'password'=>md5($this->input->post('password')),
				'phone'=>$this->input->post('phone'),
				'address'=>$this->input->post('address'),
				'post_code'=>$this->input->post('post_code'),
				'country_id'=>$this->input->post('country_id'),
				'city'=>$this->input->post('city'),
				'created'=>date('Y-m-d H:i:s'),
				'customer_level_id'=>$this->input->post('customer_level_id'),
				'activated'=>$this->input->post('activated')
			);
			
		if($this->db->insert('customers', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Add a new front end customer to the database
	*
	*/
	public function add_frontend_customer()
	{
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'other_names'=>ucwords(strtolower($this->input->post('other_names'))),
				'email'=>$this->input->post('email'),
				'password'=>md5($this->input->post('password')),
				'phone'=>$this->input->post('phone'),
				'created'=>date('Y-m-d H:i:s'),
				'customer_level_id'=>2,
				'activated'=>1
			);
			
		if($this->db->insert('customers', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Edit an existing customer
	*	@param int $customer_id
	*
	*/
	public function edit_customer($customer_id)
	{
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'other_names'=>ucwords(strtolower($this->input->post('other_names'))),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'address'=>$this->input->post('address'),
				'post_code'=>$this->input->post('post_code'),
				'country_id'=>$this->input->post('country_id'),
				'city'=>$this->input->post('city'),
				'customer_level_id'=>$this->input->post('customer_level_id'),
				'activated'=>$this->input->post('activated')
			);
		
		//check if customer wants to update their password
		$pwd_update = $this->input->post('admin_customer');
		if(!empty($pwd_update))
		{
			if($this->input->post('old_password') == md5($this->input->post('current_password')))
			{
				$data['password'] = md5($this->input->post('new_password'));
			}
			
			else
			{
				$this->session->set_customerdata('error_message', 'The current password entered does not match your password. Please try again');
			}
		}
		
		$this->db->where('customer_id', $customer_id);
		
		if($this->db->update('customers', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Edit an existing customer
	*	@param int $customer_id
	*
	*/
	public function edit_frontend_customer($customer_id)
	{
		$data = array(
				'first_name'=>ucwords(strtolower($this->input->post('first_name'))),
				'other_names'=>ucwords(strtolower($this->input->post('last_name'))),
				'phone'=>$this->input->post('phone')
			);
		
		//check if customer wants to update their password
		$pwd_update = $this->input->post('admin_customer');
		if(!empty($pwd_update))
		{
			if($this->input->post('old_password') == md5($this->input->post('current_password')))
			{
				$data['password'] = md5($this->input->post('new_password'));
			}
			
			else
			{
				$this->session->set_customerdata('error_message', 'The current password entered does not match your password. Please try again');
			}
		}
		
		$this->db->where('customer_id', $customer_id);
		
		if($this->db->update('customers', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Edit an existing customer's password
	*	@param int $customer_id
	*
	*/
	public function edit_password($customer_id)
	{
		if($this->input->post('slug') == md5($this->input->post('current_password')))
		{
			if($this->input->post('new_password') == $this->input->post('confirm_password'))
			{
				$data['password'] = md5($this->input->post('new_password'));
		
				$this->db->where('customer_id', $customer_id);
				
				if($this->db->update('customers', $data))
				{
					$return['result'] = TRUE;
				}
				else{
					$return['result'] = FALSE;
					$return['message'] = 'Oops something went wrong and your password could not be updated. Please try again';
				}
			}
			else{
					$return['result'] = FALSE;
					$return['message'] = 'New Password and Confirm Password don\'t match';
			}
		}
		
		else
		{
			$return['result'] = FALSE;
			$return['message'] = 'You current password is not correct. Please try again';
		}
		
		return $return;
	}
	
	/*
	*	Retrieve a single customer
	*	@param int $customer_id
	*
	*/
	public function get_customer($customer_id)
	{
		//retrieve all customers
		$this->db->from('customers');
		$this->db->select('*');
		$this->db->where('customer_id = '.$customer_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Unfeature an activated customer
	*	@param int $customer_id
	*
	*/
	public function feature_customer($customer_id)
	{
		$data = array(
				'featured' => 1,
				'featured_date' => date('Y-m-d H:i:s')
			);
		$this->db->where('customer_id', $customer_id);
		
		if($this->db->update('customer', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Unfeature an activated customer
	*	@param int $customer_id
	*
	*/
	public function unfeature_customer($customer_id)
	{
		$data = array(
				'featured' => 0
			);
		$this->db->where('customer_id', $customer_id);
		
		if($this->db->update('customer', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
}