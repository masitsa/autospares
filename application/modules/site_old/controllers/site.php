<?php session_start();
/*
	This module loads the head, header, footer &/or Social media sections.
*/
class Site extends MX_Controller {
	var $gallery_path;
	var $gallery_path2;
	
	/********************************************************************************************
	*																							*
	*			BY DEFAULT ALL ACTIONS WARANTY LOADING THE ENCRYPTION CIPHER			 		*
	*																							*
	*																							*
	********************************************************************************************/
	
	function __construct() 
	{
		/*
			-----------------------------------------------------------------------------------------
			Set the cipher to be used for encryption
			-----------------------------------------------------------------------------------------
		*/
		$this->encrypt->set_cipher(MCRYPT_RIJNDAEL_128);
		
		/*
			-----------------------------------------------------------------------------------------
			Load the requred model
			-----------------------------------------------------------------------------------------
		*/
		$this->load->model('administration/administration_model');
			
		/*
			-----------------------------------------------------------------------------------------
			Image location
			-----------------------------------------------------------------------------------------
		*/
		$this->gallery_path = realpath(APPPATH . '../assets/products');
		
		// Allow from any origin
	    if (isset($_SERVER['HTTP_ORIGIN'])) {
	        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	        header('Access-Control-Allow-Credentials: true');
	        header('Access-Control-Max-Age: 86400');    // cache for 1 day
	    }
	
	    // Access-Control headers are received during OPTIONS requests
	    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
	        exit(0);
	    }
  	}
	
	/********************************************************************************************
	*																							*
	*					INITIAL STAGE FOR ANY USER IS TO VIEW THE HOME PAGE						*
	*																							*
	********************************************************************************************/
	
	public function hello_world()
	{
		echo 'hello workls';
	}
	
	function index()
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve categories
			-----------------------------------------------------------------------------------------
		*/
		$data['categories'] = $this->administration_model->select_entries_where("category", "category_parent = 0 AND category_status = 1", "*", "category_name");
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve brands
			-----------------------------------------------------------------------------------------
		*/
		$data['brands'] = $this->administration_model->select_limit(18, "brand", "brand_image_name LIKE 'image_%' AND brand_status = 1", "*", "brand_name");
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve all products
			-----------------------------------------------------------------------------------------
		*/
		$data['all_products'] = $this->administration_model->select_entries_where("product, brand_model", "product.product_status = 1 AND product.brand_model_id = brand_model.brand_model_id", 'brand_model.brand_id', 'brand_id');
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve all product categories
			-----------------------------------------------------------------------------------------
		*/
		$data['all_product_categories'] = $this->administration_model->select_entries_where("product, category", "product.product_status = 1 AND product.category_id = category.category_id", 'category.category_id, category.category_parent, ', 'category_id');
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve latest products
			-----------------------------------------------------------------------------------------
		*/
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$order = "product_date";
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		
		$data['latest_products'] = $this->administration_model->select_limit2(8, $table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve product images
			-----------------------------------------------------------------------------------------
		*/
		$items = "*";
		$table = "product_image";
        $where = "(product_id > 0)";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("home", $data);
		$this->load_foot();
	}
	
	/********************************************************************************************
	*																							*
	*									INCLUDE HEADERS & FOOTERS								*
	*																							*
	********************************************************************************************/
	
	function load_head()
	{	
		/*
			-----------------------------------------------------------------------------------------
			Site contact info
			-----------------------------------------------------------------------------------------
		*/
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Site pages
			-----------------------------------------------------------------------------------------
		*/
  		$table = "page";
		$where = "page_status = 1";
		$items = "*";
		$order = "page_position, page_name";
		
		$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Brands & models
			-----------------------------------------------------------------------------------------
		*/
  		$table = "brand";
		$where = "brand_status = 1";
		$items = "*";
		$order = "brand_name";
		
		$results = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$brands = "";
		$models = "";
		$count = 0;
		
		if(count($results) > 0)
		{
			foreach($results as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$table = "brand_model";
					$where = "brand_model_status = 1 AND brand_id = ".$res->brand_id;
					$items = "brand_model_name, brand_model_id";
					$order = "brand_model_name";
					
					$result2 = $this->administration_model->select_entries_where($table, $where, $items, $order);
					
					if(count($result2) > 0)
					{
						foreach($result2 as $res2)
						{
							$models .= "<option value='".$res2->brand_model_id."'>".$res2->brand_model_name."</option>";
						}
					}
				}
				$brands .= "<option value='".$res->brand_id."'>".$res->brand_name."</option>";
			}
		}
		$data['brands'] = $brands;
		$data['models'] = $models;
		
		/*
			-----------------------------------------------------------------------------------------
			Year from & to
			-----------------------------------------------------------------------------------------
		*/
		$year_from = 1980;
		$data['year_from'] = "";
		$data['year_to'] = "";
		for($r = $year_from; $r <= date("Y"); $r++)
		{
			$data['year_from'] .= "<option>".$r."</option>";
		}
		for($r = date("Y"); $r >= $year_from; $r--)
		{
			$data['year_to'] .= "<option>".$r."</option>";
		}
		
		/*
			-----------------------------------------------------------------------------------------
			Categpries & sub categories
			-----------------------------------------------------------------------------------------
		*/
  		$table = "category";
		$where = "category_status = 1 AND category_parent = 0";
		$items = "*";
		$order = "category_name";
		
		$results = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$categories = "";
		$children = "";
		$count = 0;
		
		if(count($results) > 0)
		{
			foreach($results as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$table = "category";
					$where = "category_parent = ".$res->category_id;
					$items = "*";
					$order = "category_name";
					
					$result2 = $this->administration_model->select_entries_where($table, $where, $items, $order);
					
					if(count($result2) > 0)
					{
						foreach($result2 as $res2)
						{
							$children .= "<option value='".$res2->category_id."'>".$res2->category_name."</option>";
						}
					}
				}
				$categories .= "<option value='".$res->category_id."'>".$res->category_name."</option>";
			}
		}
		$data['categories'] = $categories;
		$data['children'] = $children;
		
		/*
			-----------------------------------------------------------------------------------------
			Location
			-----------------------------------------------------------------------------------------
		*/
		$table = "location";
		$where = "location_id > 0";
		$items = "*";
		$order = "location_name";
		$results = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$locations = "";
		
		if(count($results) > 0)
		{
			foreach($results as $res)
			{
				$locations .= "<option value='".$res->location_id."'>".$res->location_name."</option>";
			}
		}
		$data['locations'] = $locations;
		
		$this->load->view("site/includes/head", $data);
		$this->load->view("site/includes/header",$data);
	}
	
	function load_left_menu()
	{	
		/*
			-----------------------------------------------------------------------------------------
			Latest products
			-----------------------------------------------------------------------------------------
		*/
		$data2['products'] = $this->administration_model->select_latest_products();
		/*
			-----------------------------------------------------------------------------------------
			Retrieve category parents
			-----------------------------------------------------------------------------------------
		*/
  		$table = "category";
		$where = "category_status = 1 AND category_parent = 0";
		$items = "*";
		$order = "category_name";
		$data2['categories'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		/*
			-----------------------------------------------------------------------------------------
			Retrieve categories
			-----------------------------------------------------------------------------------------
		*/
  		$table = "category";
		$where = "category_status = 1 AND category_parent > 0";
		$items = "*";
		$order = "category_name";
		$data2['all_children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve brands
			-----------------------------------------------------------------------------------------
		*/
  		$table = "brand";
		$where = "brand_status = 1";
		$items = "*";
		$order = "brand_name";
		$data2['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve models
			-----------------------------------------------------------------------------------------
		*/
  		$table = "brand_model";
		$where = "brand_model_status = 1";
		$items = "brand_model_id, brand_model_name, brand_id";
		$order = "brand_model_name";
		$data2['brand_models'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve product images
			-----------------------------------------------------------------------------------------
		*/
		$items = "*";
		$table = "product_image";
        $where = "(product_id > 0)";
		$order = "product_id"; 
		$data2['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("site/includes/left_menu",$data2);
	}
	
	function load_foot()
	{
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$this->load->view("site/includes/footer", $data);
	}
	
	/**
	 * Delete gallery image
	 *
	 * @param int product_image_id
	 *
	 */
	function delete_gallery_image($product_image_id, $product_id, $page){
		
		$data['product_images'] = $this->products_model->delete_product_image($product_image_id);
		$this->update_product($product_id, $page);
	}
	
	/********************************************************************************************
	*																							*
	*									WEBSITE CONTROL FUNCTIONS								*
	*																							*
	********************************************************************************************/
	
	function all_products($category_id, $brand_id = 0, $brand_model_id = 0)
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product.tiny_url, product.product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$order = "product_date";
		
		$search = $this->session->userdata('search_data');
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		$config['uri_segment'] = 5;
		$config['base_url'] = site_url().'all-categories/'.$category_id.'/0/0';
		
		if($category_id > 0){
			$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND (product.category_id = ".$category_id." OR category.category_parent = ".$category_id.")";
			$data['page_title'] = $this->administration_model->get_category_name($category_id);
			$config['base_url'] = site_url().'category/'.$category_id.'/0/0';
		}
		
		else if($brand_id > 0){
			$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND brand_model.brand_id = ".$brand_id;
			$data['page_title'] = $this->administration_model->get_brand_name($brand_id);
			
			$config['base_url'] = site_url().'brand/'.$category_id.'/'.$brand_id.'/0';
		}
		
		else if($brand_model_id > 0){
			$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND product.brand_model_id = ".$brand_model_id;
			$data['page_title'] = $this->administration_model->get_brand_model_name($brand_model_id);
			
			$config['base_url'] = site_url().'model/'.$category_id.'/'.$brand_id.'/'.$brand_model_id;
		}
		
		else{
			
			$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
			$data['page_title'] = 'All Parts';
		
			if(!empty($search))
			{
				$where .= $search;
				$data['page_title'] = 'Search';
			}
		}
		
		/*
			-----------------------------------------------------------------------------------------
			Pagination
			-----------------------------------------------------------------------------------------
		*/
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['per_page'] = 21;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '<span class="glyphicon glyphicon-chevron-right"></span>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '<span class="glyphicon glyphicon-chevron-left"></span>';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
		
		$data['products'] = $this->administration_model->select_pagination2($config["per_page"], $page, $table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve product images
			-----------------------------------------------------------------------------------------
		*/
		$items = "*";
		$table = "product_image";
        $where = "(product_id > 0)";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load_left_menu();
		$this->load->view("products", $data);
		$this->load_foot();
	}
	
	function single_product($product_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve product
			-----------------------------------------------------------------------------------------
		*/
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product.tiny_url, product.product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$order = "product_name";
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND product.product_id = ".$product_id;
		
		$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve product's images
			-----------------------------------------------------------------------------------------
		*/
		$items = "*";
		$table = "product_image";
        $where = "(product_id = ".$product_id.")";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load_left_menu();
		$this->load->view("single_product", $data);
		$this->load_foot();
	}
	
	function view_product($product_id)
	{
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product.tiny_url, product.product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$order = "product_name";
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND product.product_id = ".$product_id;
		
		$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$items = "*";
		$table = "product_image";
        $where = "(product_id = ".$product_id.")";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("view_product", $data);
	}
	
	function category($category_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
  		$table = "product, category";
		$where = "product.category_id = category.category_id AND product.product_status = 1 AND product.category_id = ".$category_id;
		$items = "product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		
		/*
			-----------------------------------------------------------------------------------------
			Pagination
			-----------------------------------------------------------------------------------------
		*/
		$config['base_url'] = site_url().'site/category/'.$category_id;
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['uri_segment'] = 4;
		$config['per_page'] = 20;
		$config['full_tag_open'] = '<ul class="pagination pagination-lg">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '<span class="glyphicon glyphicon-chevron-right"></span>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '<span class="glyphicon glyphicon-chevron-left"></span>';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
		$data['products'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("products", $data);
		$this->load_foot();
	}
	
	function contacts()
	{
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('sender_email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('sender_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|xss_clean');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			foreach($data['contacts'] as $cat){
				$email = $cat->email;
			}
			$this->load->library('email');

			$this->email->from($this->input->post('sender_email'), $this->input->post('sender_name'));
			$this->email->to($email);
			
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('sender_name').", Phone: ".$this->input->post('phone_number').', Email: '.$this->input->post('sender_email').' Says:'.$this->input->post('message'));
			
			if($this->email->send())
			{
				$this->session->set_userdata('email_success', 'Your message has been sent successfully. We will get back to you as soon as possible (ussually within 24 hours).');
			}
			
			else
			{
				$this->session->set_userdata('email_error', 'We were unable to send your message. Please try again');
			}
		}
	
		$this->load_head();
		$this->load->view("contacts", $data);
		$this->load_foot();
	}
	
	function test()
	{
		$this->load->view("test");
	}
	
	function sell_parts()
	{
		$_SESSION['total_images'] = 0;
		/*
			-----------------------------------------------------------------------------------------
			Add a new product
			-----------------------------------------------------------------------------------------
		*/
		$table = "category";
		$where = "category_id > 0";
		$items = "*";
		$order = "category_name";
		$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$table = "location";
		$where = "location_id > 0";
		$items = "*";
		$order = "location_name";
		$location = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$locations = '';
		
		if(count($location) > 0)
		{
			foreach($location as $res)
			{
				$locations .= "<option value='".$res->location_id."'>".$res->location_name."</option>";
			}
		}
		$data['locations'] = $locations;
		
		$table = "brand";
		$where = "brand_id >= 0";
		$items = "*";
		$order = "brand_name";
		$results = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$brands = "";
		$models = "";
		$count = 0;
		
		if(count($results) > 0)
		{
			foreach($results as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$table = "brand_model";
					$where = "brand_model_status = 1 AND brand_id = ".$res->brand_id;
					$items = "brand_model_name, brand_model_id";
					$order = "brand_model_name";
					
					$result2 = $this->administration_model->select_entries_where($table, $where, $items, $order);
					
					if(count($result2) > 0)
					{
						foreach($result2 as $res2)
						{
							$models .= "<option value='".$res2->brand_model_id."'>".$res2->brand_model_name."</option>";
						}
					}
				}
				$brands .= "<option value='".$res->brand_id."'>".$res->brand_name."</option>";
			}
		}
		$data['product_brands'] = $brands;
		$data['product_models'] = $models;
		
		/*
			-----------------------------------------------------------------------------------------
			Year from & to
			-----------------------------------------------------------------------------------------
		*/
		$year_from = 1980;
		$data['product_year_to'] = "";
		
		for($r = date("Y"); $r >= $year_from; $r--)
		{
			$data['product_year_to'] .= "<option>".$r."</option>";
		}
		
		/*
			-----------------------------------------------------------------------------------------
			Categpries & sub categories
			-----------------------------------------------------------------------------------------
		*/
  		$table = "category";
		$where = "category_status = 1 AND category_parent = 0";
		$items = "*";
		$order = "category_name";
		
		$results = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$categories = "";
		$children = "";
		$count = 0;
		
		if(count($results) > 0)
		{
			foreach($results as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$table = "category";
					$where = "category_parent = ".$res->category_id;
					$items = "*";
					$order = "category_name";
					
					$result2 = $this->administration_model->select_entries_where($table, $where, $items, $order);
					
					if(count($result2) > 0)
					{
						foreach($result2 as $res2)
						{
							$children .= "<option value='".$res2->category_id."'>".$res2->category_name."</option>";
						}
					}
				}
				$categories .= "<option value='".$res->category_id."'>".$res->category_name."</option>";
			}
		}
		$data['product_categories'] = $categories;
		$data['product_children'] = $children;
		
		$this->load_head();
		$this->load->view("add_product", $data);
		$this->load_foot();
	}
	
	function validate_product()
	{
		$this->load->library('image_lib');
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		//$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_year', 'Product Year', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('product_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('product_buying_price', 'Buying Price', 'trim|xss_clean');
		//$this->form_validation->set_rules('product_balance', 'Balance', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_category_child', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique code is requred.");
		$this->form_validation->set_rules('user_email', 'Email', 'trim|valid_email|xss_clean');
		$this->form_validation->set_rules('seller_name', 'Names', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_phone', 'Phone', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) 
		{
			/*$return["error"] = array(
									//'product_name' => form_error('product_name'),
									'product_selling_price' => form_error('product_selling_price'),
									//'product_buying_price' => form_error('product_buying_price'),
									'product_description' => form_error('product_description'),
									//'product_balance' => form_error('product_balance'),
									'product_code' => form_error('product_code'),
									'category_id' => form_error('category_id'),
									'brand_id' => form_error('product_model_id'),
									'user_email' => form_error('user_email'),
									'feature' => form_error('feature[]')
						          );*/
			$this->load_head();
			$this->load->view("add_product", $data);
			$this->load_foot();
		} 
		
		else 
		{
			/*
				-----------------------------------------------------------------------------------------
				Upload images
				-----------------------------------------------------------------------------------------
			*/
			$image_return = $this->upload_file();
			//product image
			if($image_return['images']['product_image_result'] == 'success')
			{
				$file_name = $image_return['images']['product_image_file'];
			}
			else if($image_return['images']['product_image_error'] == 'No image selected')
			{
				$file_name = '';
			}
			else
			{
				$data['result'] = 'upload_fail';
				$data['error'] = $image_return['images']['product_image_error'];
				
				$this->load_head();
				$this->load->view("add_product", $data);
				$this->load_foot();
				
				break;
			}
			//gallery images
			for($s = 1; $s < 3; $s++)
			{
				if($image_return['images']['gallery'.$s.'_result'] == 'success')
				{
					$gallery_name[$s] = $image_return['images']['gallery'.$s.'_file'];
				}
				else if($image_return['images']['gallery'.$s.'_error'] == 'No image selected')
				{
					$gallery_name[$s] = '';
				}
				else
				{
					$data['result'] = 'gallery_fail';
					$data['error'] = $image_return['images']['gallery'.$s.'_error'];
				
					$this->load_head();
					$this->load->view("add_product", $data);
					$this->load_foot();
					
					break;
				}
			}
			
			/*
				-----------------------------------------------------------------------------------------
				Create Product Number
				-----------------------------------------------------------------------------------------
			*/
			if($this->input->post('product_category_child') > 0){
				$table = "category";
				$where = "category_id = ".$this->input->post('product_category_child');
				$items = "category_preffix";
				$order = "category_preffix";
				$category_id = $this->input->post('product_category_child');
			}
			
			else{
				$table = "category";
				$where = "category_id = ".$this->input->post('product_category_id');
				$items = "category_preffix";
				$order = "category_preffix";
				$category_id = $this->input->post('product_category_id');
			}
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
			foreach ($result as $row):
				$category_preffix =  $row->category_preffix;
			endforeach;
			
			$table = "product";
			$where = "product_code LIKE '".$category_preffix."%'";
			$items = "MAX(product_code) AS number";
			$order = "number";
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
			if($result != NULL){
				foreach ($result as $row):
					$number =  $row->number;
					$number++;//go to the next number
				endforeach;
				
				if($number == 1){
					$number = $category_preffix."001";
				}
			}
			else{//start generating receipt numbers
				$number = $category_preffix."001";
			}
			
			//get customer id
			$customer_id = $this->administration_model->add_customer();
			
			$data = array(
				'product_status'=>0,
				'customer_id'=>$customer_id,
				'product_code'=>$number,
				'location_id'=>$this->input->post('location_id'),
				'product_year'=>$this->input->post('product_year'),
				'brand_id'=>$this->input->post('product_brand_id'),
				'brand_model_id'=>$this->input->post('product_model_id'),
				'product_description'=>$this->input->post('product_description'),
				'product_name'=>$this->input->post('product_name'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_balance'=>1,
				'category_id'=>$category_id,
				'product_image_name'=>$file_name
			);
			
			$table = "product";
			$product_id = $this->administration_model->insert($table, $data);
			
			//create tiny url
			$tiny_url = $this->administration_model->getTinyUrl(site_url()."view-autopart/".$product_id);
			
			$items = array(
						'tiny_url' => $tiny_url
					);
			$table = "product";
			$this->administration_model->update($table, $items, "product_id", $product_id);
			
			//upload product images
			if($product_id > 0){
				
				$table = "product_image";
				
				$total_gallery_images = count($gallery_name);
				
				for($r = 1; $r < 3; $r++)
				{
					$file = $gallery_name[$r];
					
					if(!empty($file))
					{
						$data = array(//get the items from the form
							'product_id' => $product_id,
							'product_image_name' => $file,
							'product_image_thumb' => 'thumb_'.$file
						);
						$this->administration_model->insert($table, $data);
					}
				}
			}
			$return['result'] = 'success';
			$data['product_id'] = $product_id;
			$_SESSION['product_id'] = $product_id;
				
			$this->load_head();
			$this->load->view("add_payment", $data);
			$this->load_foot();
		}
	}
	
	function validate_product2()
	{
		$this->load->library('image_lib');
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		//$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_year', 'Product Year', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('product_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('product_buying_price', 'Buying Price', 'trim|xss_clean');
		//$this->form_validation->set_rules('product_balance', 'Balance', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_category_child', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique code is requred.");
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('seller_name', 'Names', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_phone', 'Phone', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) 
		{
			$return["error"] = array(
									//'product_name' => form_error('product_name'),
									'product_selling_price' => form_error('product_selling_price'),
									//'product_buying_price' => form_error('product_buying_price'),
									'product_description' => form_error('product_description'),
									//'product_balance' => form_error('product_balance'),
									'product_code' => form_error('product_code'),
									'category_id' => form_error('category_id'),
									'brand_id' => form_error('product_model_id'),
									'user_email' => form_error('user_email'),
									'feature' => form_error('feature[]')
						          );
			$return['result'] = 'validation_fail';
			
			echo json_encode($return);
		} 
		
		else 
		{
			/*
				-----------------------------------------------------------------------------------------
				Upload images
				-----------------------------------------------------------------------------------------
			*/
			$image_return = $this->upload_file();
			//product image
			if($image_return['images']['product_image_result'] == 'success')
			{
				$file_name = $image_return['images']['product_image_file'];
			}
			else if($image_return['images']['product_image_error'] == 'No image selected')
			{
				$file_name = '';
			}
			else
			{
				$return['result'] = 'upload_fail';
				$return['error'] = $image_return['images']['product_image_error'];
				echo json_encode($return);
				break;
			}
			//gallery images
			for($s = 1; $s < 3; $s++)
			{
				if($image_return['images']['gallery'.$s.'_result'] == 'success')
				{
					$gallery_name[$s] = $image_return['images']['gallery'.$s.'_file'];
				}
				else if($image_return['images']['gallery'.$s.'_error'] == 'No image selected')
				{
					$gallery_name[$s] = '';
				}
				else
				{
					$return['result'] = 'gallery_fail';
					$return['error'] = $image_return['images']['gallery'.$s.'_error'];
					echo json_encode($return);
					break;
				}
			}
			
			/*
				-----------------------------------------------------------------------------------------
				Create Product Number
				-----------------------------------------------------------------------------------------
			*/
			$table = "category";
			$where = "category_id = ".$this->input->post('product_category_child');
			$items = "category_preffix";
			$order = "category_preffix";
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
			foreach ($result as $row):
				$category_preffix =  $row->category_preffix;
			endforeach;
			
			$table = "product";
			$where = "product_code LIKE '".$category_preffix."%'";
			$items = "MAX(product_code) AS number";
			$order = "number";
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
			if($result != NULL){
				foreach ($result as $row):
					$number =  $row->number;
					$number++;//go to the next number
				endforeach;
				
				if($number == 1){
					$number = $category_preffix."001";
				}
			}
			else{//start generating receipt numbers
				$number = $category_preffix."001";
			}
			
			//get customer id
			$customer_id = $this->administration_model->add_customer();
			
			$data = array(
				'product_status'=>0,
				'customer_id'=>$customer_id,
				'product_code'=>$number,
				'location_id'=>$this->input->post('location_id'),
				'product_year'=>$this->input->post('product_year'),
				'brand_id'=>$this->input->post('brand_id'),
				'brand_model_id'=>$this->input->post('product_model_id'),
				'product_description'=>$this->input->post('product_description'),
				'product_name'=>$this->input->post('product_name'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_balance'=>1,
				'category_id'=>$this->input->post('product_category_child'),
				'product_image_name'=>$file_name
			);
			
			$table = "product";
			$product_id = $this->administration_model->insert($table, $data);
			
			if($product_id > 0){
				
				$table = "product_image";
				
				$total_gallery_images = count($gallery_name);
				
				for($r = 1; $r < 3; $r++)
				{
					$file = $gallery_name[$r];
					
					if(!empty($file))
					{
						$data = array(//get the items from the form
							'product_id' => $product_id,
							'product_image_name' => $file,
							'product_image_thumb' => 'thumb_'.$file
						);
						$this->administration_model->insert($table, $data);
					}
				}
			}
			$return['result'] = 'success';
			$return['product_id'] = $product_id;
			$_SESSION['product_id'] = $product_id;
			echo json_encode($return);
		}
	}
	
	function search_brand_models($brand_id)
	{
  		$table = "brand_model";
		$where = "brand_model_status = 1 AND brand_id = ".$brand_id;
		$items = "brand_model_name, brand_model_id";
		$order = "brand_model_name";
		
		$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$models = "<option value='0'>Model</option>";
		
		if(count($result) > 0)
		{
			foreach($result as $res)
			{
				$models .= "<option value='".$res->brand_model_id."'>".$res->brand_model_name."</option>";
			}
		}
		else
		{
			$models = "false";
		}
		echo $models;
	}
	
	function search_category_children($category_id)
	{
		$table = "category";
		$where = "category_parent = ".$category_id;
		$items = "*";
		$order = "category_name";
		$children = "";
		
		$result2 = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		if(count($result2) > 0)
		{
			foreach($result2 as $res2)
			{
				$children .= "<option value='".$res2->category_id."'>".$res2->category_name."</option>";
			}
		}
		else
		{
			$children = "false";
		}
		echo $children;
	}
	
	function search_parts()
	{
		/*
			-----------------------------------------------------------------------------------------
			Create search session
			-----------------------------------------------------------------------------------------
		*/
		$brand_id = $this->input->post("brand_id");
		$brand_model_id = $this->input->post("brand_model_id");
		$year_from = $this->input->post("year_from");
		$year_to = $this->input->post("year_to");
		$category_id = $this->input->post("category_id");
		$category_child = $this->input->post("category_child");
		$where = "";
		$table = "";
		
		if($brand_model_id > 0)
		{
			$where .= " AND brand_model.brand_model_id = ".$brand_model_id;
		}
		else
		{
			if($brand_id > 0)
			{
				$where .= " AND brand.brand_id = ".$brand_id;
			}
		}
		
		if(($year_from > 0) && ($year_to > 0))
		{
			$where = " AND product.product_year BETWEEN '".$year_from."' AND '".$year_to."'";
		}
		else if(($year_from > 0) && ($year_to == 0))
		{
			$where = " AND product.product_year = '".$year_from."'";
		}
		else if(($year_from == 0) && ($year_to > 0))
		{
			$where = " AND product.product_year = '".$year_to."'";
		}
		
		if($category_child > 0)
		{
			$where .= " AND category.category_id = ".$category_child;
		}
		else
		{
			if($category_id > 0)
			{
				$where .= " AND category.category_id = ".$category_id;
			}
		}
		
		if(!empty($where)){
			$newdata = array(
				'search_data'  => $where
			);
			$this->session->set_userdata($newdata);
			$this->all_products(0);
		}
		else
		{
			$this->all_products(0);
		}
	}
	
	function mini_search()
	{
		/*
			-----------------------------------------------------------------------------------------
			Create search session
			-----------------------------------------------------------------------------------------
		*/
		if(isset($_POST['search_data']))
		{
			$search_data = explode(" ",$_POST['search_data']);
			$total = count($search_data);
			
			$count = 1;
			$where = " AND ((";
			$table = "";
			
			//search brand model
			for($r = 0; $r < $total; $r++)
			{
				if($count == $total)
				{
					$where .= ' brand_model.brand_model_name LIKE \'%'.mysql_real_escape_string($search_data[$r]).'%\')';
				}
				
				else
				{
					$where .= ' brand_model.brand_model_name LIKE \'%'.mysql_real_escape_string($search_data[$r]).'%\' AND ';
				}
				$count++;
			}
			$where .= ' OR (';
			$count = 1;
			
			//search brand
			for($r = 0; $r < $total; $r++)
			{
				if($count == $total)
				{
					$where .= ' brand.brand_name LIKE \'%'.mysql_real_escape_string($search_data[$r]).'%\')';
				}
				
				else
				{
					$where .= ' brand.brand_name LIKE \'%'.mysql_real_escape_string($search_data[$r]).'%\' AND ';
				}
				$count++;
			}
			$where .= ' OR (';
			$count = 1;
			
			//search category
			for($r = 0; $r < $total; $r++)
			{
				if($count == $total)
				{
					$where .= ' category.category_name LIKE \'%'.mysql_real_escape_string($search_data[$r]).'%\')';
				}
				
				else
				{
					$where .= ' category.category_name LIKE \'%'.mysql_real_escape_string($search_data[$r]).'%\' AND ';
				}
				$count++;
			}
			$where .= ') ';
			
			if(!empty($_POST['search_data'])){
				$newdata = array(
					'search_data'  => $where
				);
				$this->session->set_userdata($newdata);
				$this->all_products(0);
			}
			else
			{
				$this->all_products(0);
			}
		}
		
		else
		{
			$this->all_products(0);
		}
	}
	
	function do_upload($gallery_path, $field_name) 
	{
		/*
			-----------------------------------------------------------------------------------------
			Upload an image
			-----------------------------------------------------------------------------------------
		*/
		$config = array(
			'allowed_types' => 'JPG|JPEG|jpg|jpeg|gif|png',
			'upload_path' => $gallery_path,
			'quality' => "100%",
			'file_name' => "image_".date("Y")."_".date("m")."_".date("d")."_".date("H")."_".date("i")."_".date("s"),
			'max_size' => 2000
		);
		
		$this->load->library('upload'); 
		$this->upload->initialize($config);
		
		if($this->upload->do_upload($field_name) == FALSE)
		{
			return "FALSE";
		}
		else{
			$image_data = $this->upload->data();
			return $image_data;
		}
	}
	
	function create_thumb($path, $gallery_path, $file_name, $new_path)
	{
		/*
			-----------------------------------------------------------------------------------------
			Create a thumbnail
			-----------------------------------------------------------------------------------------
		*/
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $new_path.''.$file_name,
			'create_thumb'  => FALSE,
			'width'         => 80,
			'height'        => 80,
			'maintain_ratio' => true,
		);
		
		 $this->image_lib->initialize($resize_conf);
		 
		if ( ! $this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}
		
		else
		{
			return TRUE;
		}
	}
	
	function resize_image($path, $gallery_path, $file_name, $new_path)
	{
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $new_path.''.$file_name,
			'create_thumb'  => FALSE,
			'width' => 200,
			'height' => 200,
			'maintain_ratio' => true,
		);
		
		$this->image_lib->initialize($resize_conf);
		 
		 if ( ! $this->image_lib->resize())
		{
		 	return $this->image_lib->display_errors();
		}
		
		else
		{
			return TRUE;
		}
	}
	
	function upload_file()
	{
		$this->load->library('image_lib');
		if(is_uploaded_file($_FILES['product_image']['tmp_name']))
		{
			$field_name = 'product_image';
			$gallery_path = $this->gallery_path;
			$image_data = $this->do_upload($gallery_path, $field_name);
		
			if($image_data == "FALSE"){
				$return['images']['product_image_result'] = 'Fail';
				$return['images']['product_image_error'] = $this->upload->display_errors('<p>', '</p>');
			}
			else{
				$path = $image_data['full_path'];
				$file_path = $image_data['file_path'];
				$file_name = $image_data['file_name'];
				$file_type = $image_data['file_type'];
				$new_path = $path.'images/';
				$thumb_path = $path.'thumbs/';
		
				/*
					-----------------------------------------------------------------------------------------
					Resize product image
					-----------------------------------------------------------------------------------------
				*/
				$create = $this->resize_image($path, $gallery_path, $file_name, $new_path);
				
				/*
					-----------------------------------------------------------------------------------------
					Create product thumbnail
					-----------------------------------------------------------------------------------------
				*/
				$create = $this->create_thumb($path, $gallery_path, $file_name, $thumb_path);
				$return['images']['product_image_result'] = 'success';
				$return['images']['product_image_file'] = $file_name;
			}
		}
		
		else{
			$return['images']['product_image_result'] = 'Fail';
			$return['images']['product_image_error'] = 'No image selected';
		}
		/*
			-----------------------------------------------------------------------------------------
			Upload gallery images
			-----------------------------------------------------------------------------------------
		*/
		for($s = 1; $s < 3; $s++)
		{
			if(is_uploaded_file($_FILES['gallery'.$s]['tmp_name']))
			{
				$field_name = 'gallery'.$s;
				$gallery_path = $this->gallery_path;
				$image_data = $this->do_upload($gallery_path, $field_name);
			
				if($image_data == "FALSE"){
					$return['images']['gallery'.$s.'_result'] = 'Fail';
					$return['images']['gallery'.$s.'_error'] = $this->upload->display_errors('<p>', '</p>');
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$gallery_file = $image_data['file_name'];
					$file_type = $image_data['file_type'];
					$new_path = $path.'gallery/';
			
					/*
						-----------------------------------------------------------------------------------------
						Resize product image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $gallery_file, $new_path);
					
					/*
						-----------------------------------------------------------------------------------------
						Create product thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, 'thumb_'.$gallery_file, $new_path);
					$return['images']['gallery'.$s.'_result'] = 'success';
					$return['images']['gallery'.$s.'_file'] = $gallery_file;
				}
			}
			
			else{
				$return['images']['gallery'.$s.'_result'] = 'Fail';
				$return['images']['gallery'.$s.'_error'] = 'No image selected';
			}
			//$gallery_name[$s] = $gallery_file;
		}
		return $return;
		//echo json_encode($return);
	}
	
	function add_payment()
	{
		$this->load_head();
		$this->load->view("add_payment");
		$this->load_foot();
	}
	
	function validate_payment()
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('transaction_number', 'Transaction Number', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) 
		{
			$return["error"] = array(
									'transaction_number' => form_error('transaction_number')
						          );
			$return['result'] = 'validation_fail';
			
			echo json_encode($return);
		} 
		
		else 
		{
			$data = array(
				'product_status'=>0,
				'transaction_number'=>$this->input->post('transaction_number')
			);
			
			$table = "product";
			$product_id = $_SESSION['product_id'];
			$this->administration_model->update($table, $data, 'product_id', $product_id);
			$return['result'] = 'success';
			$_SESSION['product_id'] = NULL;
			redirect(site_url()."all-categories");
			//echo json_encode($return);
		}
	}
	
	function validate_payment2()
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('transaction_number', 'Transaction Number', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) 
		{
			$return["error"] = array(
									'transaction_number' => form_error('transaction_number')
						          );
			$return['result'] = 'validation_fail';
			
			echo json_encode($return);
		} 
		
		else 
		{
			$data = array(
				'product_status'=>0,
				'transaction_number'=>$this->input->post('transaction_number')
			);
			
			$table = "product";
			$product_id = $_SESSION['product_id'];
			$this->administration_model->update($table, $data, 'product_id', $product_id);
			$return['result'] = 'success';
			$_SESSION['product_id'] = NULL;
			echo json_encode($return);
		}
	}
	
	function under_construction()
	{
		$this->load->view("under_construction");
	}
	
	function terms()
	{
		$this->load_head();
		$this->load->view("terms");
		$this->load_foot();
	}
	
	function privacy()
	{
		$this->load_head();
		$this->load->view("privacy");
		$this->load_foot();
	}
	
	function not_found()
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve latest products
			-----------------------------------------------------------------------------------------
		*/
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$order = "product_date";
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		
		$data['latest_products'] = $this->administration_model->select_limit2(8, $table, $where, $items, $order);
		
		/*
			-----------------------------------------------------------------------------------------
			Retrieve product images
			-----------------------------------------------------------------------------------------
		*/
		$items = "*";
		$table = "product_image";
        $where = "(product_id > 0)";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("not_found", $data);
		$this->load_foot();
	}
}