<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Customers extends admin {
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('customers_model');
		$this->load->model('users_model');
	}
    
	/*
	*
	*	Default action is to show all the customer
	*
	*/
	public function index() 
	{
		$where = 'customer_id > 0';
		$table = 'customer';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'all-customers';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 2;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->customers_model->get_all_customers($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['customers'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('customer/all_customers', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'customer does not exist';
		}
		$data['title'] = 'All Customers';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new customer page
	*
	*/
	public function add_customer() 
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean|is_unique[customer.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
		$this->form_validation->set_rules('other_names', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('post_code', 'Post Code', 'required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('customer_level_id', 'customer Level', 'required|xss_clean');
		$this->form_validation->set_rules('activated', 'Activate customer', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if customer has valid login credentials
			if($this->customers_model->add_customer())
			{
				redirect('all-customer');
			}
			
			else
			{
				$data['error'] = 'Unable to add customer. Please try again';
			}
		}
		
		//open the add new customer page
		$data['title'] = 'Add New customer';
		$data['content'] = modules::run('admin/customer/load_add_page');
		$this->load->view('templates/general_admin', $data);
	}
	
	public function load_add_page()
	{
		$v_data['countries'] = $this->customers_model->get_all_countries();
		$this->load->view('customer/add_customer', $v_data);
	}
    
	/*
	*
	*	Edit an existing customer page
	*	@param int $customer_id
	*
	*/
	public function edit_customer($customer_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|xss_clean');
		$this->form_validation->set_rules('other_names', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'required|xss_clean');
		$this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
		$this->form_validation->set_rules('post_code', 'Post Code', 'required|xss_clean');
		$this->form_validation->set_rules('country_id', 'Country', 'required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|xss_clean');
		$this->form_validation->set_rules('customer_level_id', 'customer Level', 'required|xss_clean');
		$this->form_validation->set_rules('activated', 'Activate customer', 'xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//check if customer has valid login credentials
			if($this->customers_model->edit_customer($customer_id))
			{
				$pwd_update = $this->input->post('admin_customer');
				if(!empty($pwd_update))
				{
					redirect('admin-profile/'.$customer_id);
				}
				
				else
				{
					redirect('all-customer');
				}
			}
			
			else
			{
				$data['error'] = 'Unable to add customer. Please try again';
			}
		}
		
		//open the add new customer page
		$data['title'] = 'Edit customer';
		$v_data['countries'] = $this->customers_model->get_all_countries();
		
		//select the customer from the database
		$query = $this->customers_model->get_customer($customer_id);
		if ($query->num_rows() > 0)
		{
			$v_data['customer'] = $query->result();
			$data['content'] = $this->load->view('customer/edit_customer', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'customer does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing customer page
	*	@param int $customer_id
	*
	*/
	public function delete_customer($customer_id) 
	{
		$this->customers_model->delete_customer($customer_id);
		
		redirect('all-customer');
	}
    
	/*
	*
	*	Activate an existing customer page
	*	@param int $customer_id
	*
	*/
	public function activate_customer($customer_id) 
	{
		$this->customers_model->activate_customer($customer_id);
		
		redirect('all-customer');
	}
    
	/*
	*
	*	Deactivate an existing customer page
	*	@param int $customer_id
	*
	*/
	public function deactivate_customer($customer_id) 
	{
		$this->customers_model->deactivate_customer($customer_id);
		
		redirect('all-customer');
	}
    
	/*
	*
	*	Feature an existing customer page
	*	@param int $customer_id
	*
	*/
	public function feature_customer($customer_id) 
	{
		$this->customers_model->feature_customer($customer_id);
		$this->session->set_userdata('success_message', 'Customer has been successfully featured');
		redirect('all-customers');
	}
    
	/*
	*
	*	Uneature an existing customer page
	*	@param int $customer_id
	*
	*/
	public function unfeature_customer($customer_id) 
	{
		$this->customers_model->unfeature_customer($customer_id);
		$this->session->set_userdata('success_message', 'Customer has been successfully unfeatured');
		redirect('all-customers');
	}
}
?>