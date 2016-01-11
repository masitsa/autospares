<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Brand_models extends admin {
	var $brand_models_path;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('brand_models_model');
		$this->load->model('brands_model');
		$this->load->model('file_model');
		
		$this->load->library('image_lib');
		
		//path to image directory
		$this->brand_models_path = realpath(APPPATH . '../assets/brand_model/images');
	}
    
	/*
	*
	*	Default action is to show all the brand_models
	*
	*/
	public function index() 
	{
		$where = 'brand_model.brand_id = brand.brand_id';
		$table = 'brand_model, brand';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/all-models';
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = 3;
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
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
		$query = $this->brand_models_model->get_all_brand_models($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('brand_models/all_brand_models', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'admin/add-brand_model" class="btn btn-success pull-right">Add Model</a>There are no brand_models';
		}
		$data['title'] = 'All Brands';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Add a new brand_model
	*
	*/
	public function add_brand_model() 
	{
		//form validation rules
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_name', 'Model Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('brand_model_status', 'Status', 'trim|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			if($this->brand_models_model->add_brand_model())
			{
				$this->session->set_userdata('success_message', 'Model added successfully');
				redirect('admin/all-models/'.$page);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add brand model. Please try again');
			}
		}
		
		//open the add new brand_model
		$data['title'] = 'Add New Model';
		$v_data['brands'] = $this->brands_model->select_all_brands();
		$data['content'] = $this->load->view('brand_models/add_brand_model', $v_data, true);
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Edit an existing brand_model
	*	@param int $brand_model_id
	*
	*/
	public function edit_brand_model($brand_model_id, $page=0) 
	{
		//form validation rules
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_name', 'Model Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('brand_model_status', 'Status', 'trim|required|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run())
		{
			//update brand_model
			if($this->brand_models_model->update_brand_model($brand_model_id))
			{
				$this->session->set_userdata('success_message', 'Model updated successfully');
				redirect('admin/all-models/'.$page);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not update brand_model. Please try again');
			}
		}
		
		//open the add new brand_model
		$data['title'] = 'Edit Model';
		
		//select the brand_model from the database
		$query = $this->brand_models_model->get_brand_model($brand_model_id);
		
		if ($query->num_rows() > 0)
		{
			$v_data['brand_model'] = $query->result();
			$v_data['brands'] = $this->brands_model->select_all_brands();
			
			$data['content'] = $this->load->view('brand_models/edit_brand_model', $v_data, true);
		}
		
		else
		{
			$data['content'] = 'Model does not exist';
		}
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing brand_model
	*	@param int $brand_model_id
	*
	*/
	public function delete_brand_model($brand_model_id, $page=0)
	{
		if($this->brand_models_model->delete_brand_model($brand_model_id))
		{
			$this->session->set_userdata('success_message', 'Model has been deleted');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Could not delete model');
		}
		redirect('admin/all-models/'.$page);
	}
    
	/*
	*
	*	Activate an existing brand_model
	*	@param int $brand_model_id
	*
	*/
	public function activate_brand_model($brand_model_id, $page=0)
	{
		if($this->brand_models_model->activate_brand_model($brand_model_id))
		{
			$this->session->set_userdata('success_message', 'Model activated successfully');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Could not activate model');
		}
		redirect('admin/all-models/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing brand_model
	*	@param int $brand_model_id
	*
	*/
	public function deactivate_brand_model($brand_model_id, $page=0)
	{
		if($this->brand_models_model->deactivate_brand_model($brand_model_id))
		{
			$this->session->set_userdata('success_message', 'Model disabled successfully');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Could not disable model');
		}
		redirect('admin/all-models/'.$page);
	}
}
?>