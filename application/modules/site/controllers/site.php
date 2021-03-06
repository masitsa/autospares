<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MX_Controller 
{
	//paths
	var $posts_path;
	var $brand_models_path;
	var $brands_path;
	var $categories_path;
	var $products_path;
	var $gallery_path;
	
	//locations
	var $posts_location;
	var $brand_models_location;
	var $brands_location;
	var $categories_location;
	var $products_location;
	var $gallery_location;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/products_model');
		$this->load->model('admin/categories_model');
		$this->load->model('admin/brands_model');
		$this->load->model('admin/brand_models_model');
		$this->load->model('admin/users_model');
		$this->load->model('site_model');
		$this->load->model('admin/blog_model');
		
		//image paths
		$this->posts_path = realpath(APPPATH . '../assets/images/posts');
		$this->brand_models_path = realpath(APPPATH . '../assets/brand_model/images');
		$this->brands_path = realpath(APPPATH . '../assets/brand/images');
		$this->categories_path = realpath(APPPATH . '../assets/categories/images');
		$this->products_path = realpath(APPPATH . '../assets/products/images');
		$this->gallery_path = realpath(APPPATH . '../assets/products/gallery');
		
		//image locations
		$this->posts_location = base_url().'assets/images/posts/';
		$this->brand_models_location = base_url().'assets/brand_model/images/';
		$this->brands_location = base_url().'assets/brand/images/';
		$this->categories_location = base_url().'assets/categories/images/';
		$this->products_location = base_url().'assets/products/images/';
		$this->gallery_location = base_url().'assets/products/gallery/';
		
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
    
	/*
	*
	*	Default action is to go to the home page
	*
	*/
	public function index() 
	{
		redirect('home');
	}
    
	/*
	*
	*	Home Page
	*
	*/
	public function cover() 
	{
		$this->load->view('cover');
	}
    
	/*
	*
	*	Home Page
	*
	*/
	public function home_page() 
	{
		//get page data
		$where = 'post.blog_category_id = blog_category.blog_category_id AND post.post_status = 1';
		$table = 'post, blog_category';
		$v_data['posts'] = $this->blog_model->get_all_posts($table, $where, 10, 0);
		$where = 'product.product_id = product_review.product_id AND product_review.product_review_status = 1 AND product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product.brand_model_id = brand_model.brand_model_id';
		$table = 'product_review, product, category, brand, brand_model';
		$v_data['product_reviews'] = $this->products_model->get_all_product_review($table, $where, 3, 0);
		$v_data['latest'] = $this->products_model->get_latest_products();
		$v_data['active_brands'] = $this->brands_model->all_active_brands();
		$v_data['total_products'] = $this->products_model->total_products();
		$v_data['total_categories'] = $this->categories_model->total_categories();
		
		//image paths
		$v_data['products_path'] = $this->products_path;
		$v_data['posts_path'] = $this->posts_path;
		$v_data['brands_path'] = $this->brands_path;
		$v_data['categories_path'] = $this->categories_path;
		
		//image locations
		$v_data['products_location'] = $this->products_location;
		$v_data['posts_location'] = $this->posts_location;
		$v_data['brands_location'] = $this->brands_location;
		$v_data['categories_location'] = $this->categories_location;
		
		//slider page data
		//Brands & models
		$results = $v_data['active_brands'];
		
		$count = 0;
		$models = '';
		$brands = '';
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$this->db->where("brand_model_status = 1 AND brand_id = ".$res->brand_id);
					$this->db->select("brand_model_name, brand_model_id");
					$this->db->order_by("brand_model_name");
					
					$result2 = $this->db->get("brand_model");
					
					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $res2)
						{
							$models .= "<option value='".$res2->brand_model_id."'>".$res2->brand_model_name."</option>";
						}
					}
				}
				$brands .= "<option value='".$res->brand_id."'>".$res->brand_name."</option>";
			}
		}
		$v_data['brands'] = $brands;
		$v_data['models'] = $models;
		
		//Year from & to
		$year_from = 1980;
		$v_data['year_from'] = "";
		$v_data['year_to'] = "";
		for($r = $year_from; $r <= date("Y"); $r++)
		{
			$v_data['year_from'] .= "<option>".$r."</option>";
		}
		for($r = date("Y"); $r >= $year_from; $r--)
		{
			$v_data['year_to'] .= "<option>".$r."</option>";
		}
		
		//Categpries & sub categories
		$results = $this->categories_model->all_parent_categories();
		$categories = "";
		$children = "";
		$count = 0;
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$this->db->where("category_parent = ".$res->category_id);
					$this->db->order_by("category_name");
					
					$result2 = $this->db->get("category");
					
					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $res2)
						{
							$children .= "<option value='".$res2->category_id."'>".$res2->category_name."</option>";
						}
					}
				}
				$categories .= "<option value='".$res->category_id."'>".$res->category_name."</option>";
			}
		}
		$v_data['categories'] = $categories;
		$v_data['children'] = $children;
		
		//Location
		$this->db->order_by('location_name');
		$results = $this->db->get('location');
		$locations = "";
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				$locations .= "<option value='".$res->location_id."'>".$res->location_name."</option>";
			}
		}
		$v_data['locations'] = $locations;
		
		//contacts
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;
		
		$data['title'] = $this->site_model->display_page_title();
		$data['class'] = 'home floated-search';
		$data['contacts'] = $contacts;
		$data['content'] = $this->load->view("home", $v_data, TRUE);
		
		$this->load->view("site/templates/general_page", $data);
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function products($search = '__', $category = '__', $brand = '__', $brand_model = '__', $featured_sellers = 0, $order_by = 'product_date', $order_method = 'DESC') 
	{

		$this->session->unset_userdata('product_search');

		$v_data["title"] = $this->site_model->display_page_title();
		$segment = 2;
		$base_url = site_url().'spareparts';

		$product_search = $this->session->userdata('product_search');
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		if(!empty($product_search))
		{
			$where .= $product_search;
		}
		
		$table = "product, category, brand_model, brand, location, customer";
		$order = "product_date";
		
		//filter by category
		$v_data['filter_category_id'] = '';
		if(($category != '__') && (!empty($category)))
		{
			$category_web = $this->site_model->decode_web_name($category);
			$category_id = $this->categories_model->get_category_id($category_web);
			$parent_category = $this->categories_model->check_parent($category_id);
			$v_data['filter_category_id'] = $parent_category;
			$segment = 4;
			$base_url = site_url().'spareparts/category/'.$category;
			
			$where .= ' AND (category.category_id = '.$category_id.' OR category.category_parent = '.$category_id.' OR category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent = '.$category_id.')  OR category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent = '.$category_id.')))';
		}
		
		//filter brand
		$v_data['filter_brand_id'] = '';
		$v_data['category_filter'] = $category;
		if(($brand != '__') && (!empty($brand)))
		{
			$brand_web = $this->site_model->decode_web_name($brand);
			$brand_id = $this->brands_model->get_brand_id($brand_web);
			$v_data['filter_brand_id'] = $brand_id;
			$segment = 5;
			$base_url = site_url().'spareparts/brand/'.$category.'/'.$brand;
			
			$where .= ' AND (brand.brand_id = '.$brand_id.')';
		}
		
		//filter brand_model
		if(($brand_model != '__') && (!empty($brand_model)))
		{
			$brand_model_web = $this->site_model->decode_web_name($brand_model);
			$brand_model_id = $this->brand_models_model->get_brand_model_id($brand_model_web);
			$segment = 6;
			$base_url = site_url().'spareparts/model/'.$category.'/'.$brand.'/'.$brand_model;
			
			$where .= ' AND (brand_model.brand_model_id = '.$brand_model_id.')';
		}
		
		$limit = NULL;
		
		//ordering products
		switch ($order_by)
		{
			case 'price':
				$order_by = 'product_selling_price';
				$order_method = 'ASC';
			break;
			
			case 'price_desc':
				$order_by = 'product_selling_price';
				$order_method = 'DESC';
			break;
		}
		
		//case of search
		if($search != '__')
		{
			$search_web = $this->site_model->decode_web_name($search);
			$where .= " AND (product.product_name LIKE '%".$search_web."%' OR category.category_name LIKE '%".$search_web."%' OR brand.brand_name LIKE '%".$search_web."%')";
			$segment = 4;
			$base_url = site_url().'spareparts/search/'.$search;
		}
		
		//case of featured sellers
		if($featured_sellers == 1)
		{
			$where .= " AND (customer.featured = 1)";
			$segment = 3;
			$base_url = site_url().'spareparts/featured-sellers';
		}
		
		//case of most popular
		if($v_data["title"] == 'Most Popular')
		{
			$segment = 3;
			$base_url = site_url().'spareparts/most-popular';
		}
		
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $this->users_model->count_items($table, $where, $limit);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 21;
		$config['num_links'] = 5;
		
		$config['full_tag_open'] = '<ul class="pagination no-margin-top">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '»';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '«';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
		
		if($limit == NULL)
		{
        	$v_data["links"] = $this->pagination->create_links();
			$v_data["first"] = $page + 1;
			$v_data["total"] = $config['total_rows'];
			
			if($v_data["total"] < $config["per_page"])
			{
				$v_data["last"] = $page + $v_data["total"];
			}
			
			else
			{
				$v_data["last"] = $page + $config["per_page"];
			}
		}
		
		else
		{
			$v_data["first"] = $page + 1;
			$v_data["total"] = $config['total_rows'];
			$v_data["last"] = $config['total_rows'];
		}
		
		//Retrieve product images
		$v_data['product_images'] = $this->products_model->get_product_images();
		
		$table2 = "product, category, brand_model, brand, location, customer";
		$where2 = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		
		//search page data
		//Brands & models
		$results = $this->brands_model->all_active_brands();
		
		$count = 0;
		$models = '';
		$brands = '';
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				$count++;
				$brand_web_name = $this->site_model->create_web_name($res->brand_name);
				
				if($count == 1)
				{
					$this->db->where("brand_model_status = 1 AND brand_id = ".$res->brand_id);
					$this->db->select("brand_model_name, brand_model_id");
					$this->db->order_by("brand_model_name");
					
					$result2 = $this->db->get("brand_model");
					
					if($result2->num_rows() > 0)
					{
						foreach($result2->result() as $res2)
						{
							$total_models = $this->users_model->count_items($table2, $where2.' AND product.brand_model_id = '.$res2->brand_model_id);
							$model_web_name = $this->site_model->create_web_name($res2->brand_model_name);
							$models .= '<li class="list-group-item"><span class="badge">'.$total_models.'</span><a href="'.site_url().'spareparts/model/'.$category.'/'.$brand_web_name.'/'.$model_web_name.'">'.$res2->brand_model_name.'</a></li>';
						}
					}
				}
				
				$total_brands = $this->users_model->count_items($table, $where.' AND product.brand_id = '.$res->brand_id);
				$brands .= '<li class="list-group-item"><span class="badge">'.$total_brands.'</span><a href="'.site_url().'spareparts/brand/'.$category.'/'.$brand_web_name.'">'.$res->brand_name.'</a></li>';
			}
		}
		$v_data['brands'] = $brands;
		$v_data['models'] = $models;
		
		//Year from & to
		$year_from = 1980;
		$v_data['year_from'] = "";
		$v_data['year_to'] = "";
		for($r = $year_from; $r <= date("Y"); $r++)
		{
			$v_data['year_from'] .= "<option>".$r."</option>";
		}
		for($r = date("Y"); $r >= $year_from; $r--)
		{
			$v_data['year_to'] .= "<option>".$r."</option>";
		}
		
		//Categpries & sub categories
		$results = $this->categories_model->all_parent_categories();
		$categories = "";
		$children = "";
		$count = 0;
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				$count++;
				
				if($count == 1)
				{
					$children = $this->categories_model->limit_sub_categories($res->category_id);
				}
				
				$category_web_name = $this->site_model->create_web_name($res->category_name);
				$total_categories = $this->users_model->count_items($table2, $where2.' AND (category.category_id = '.$res->category_id.' OR category.category_parent = '.$res->category_id.' OR category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent = '.$res->category_id.')  OR category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent IN (SELECT category.category_id FROM category WHERE category.category_parent = '.$res->category_id.')))');
				$categories .= '<li class="list-group-item"><span class="badge">'.$total_categories.'</span><a href="'.site_url().'spareparts/category/'.$category_web_name.'" onClick="limit_sub_categories('.$res->category_id.')" title="View all parts under'.$res->category_name.'">'.$res->category_name.'</a></li>';
			}
		}
		$v_data['categories'] = $categories;
		$v_data['children'] = $children;
		
		//Location
		$this->db->order_by('location_name');
		$results = $this->db->get('location');
		$locations = "";
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				
				$total_locations = $this->users_model->count_items($table, $where.' AND product.location_id = '.$res->location_id);
				$locations .= '<li class="list-group-item"><span class="badge">'.$total_categories.'</span><a href="'.$res->location_id.'">'.$res->location_name.'</a></li>';
			}
		}
		$v_data['locations'] = $locations;
		
		//products path
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		
		$v_data['products'] = $this->products_model->get_all_products($table, $where, $config["per_page"], $page, $limit, $order_by, $order_method);
		
		$data['content'] = $this->load->view('products/products', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}

    public function products_search()
	{
		$brand_id = $this->input->post('brand_id');
		$brand_model_id = $this->input->post('brand_model_id');
		$category_id = $this->input->post('category_id');
		$category_child = $this->input->post('category_child');
		$location_id = $this->input->post('location_id');
		$year_from = $this->input->post('year_from');
		$year_to = $this->input->post('year_to');
		
		if(!empty($brand_id))
		{
			$brand_id = ' AND product.brand_id = '.$brand_id.' ';
		}
		else
		{
			$brand_id = '';
		}

		if(!empty($brand_model_id))
		{
			$brand_model_id = ' AND product.brand_model_id = '.$brand_model_id.' ';
		}
		else
		{
			$brand_model_id = '';
		}

		if(!empty($category_id))
		{
			$category_id = ' AND product.category_id = '.$category_id.' ';
		}
		else
		{
			$category_id = '';
		}

		if(!empty($location_id))
		{
			$location_id = ' AND product.location_id = '.$location_id.' ';
		}
		else
		{
			$location_id = '';
		}
		if(!empty($category_child))
		{
			$category_child = ' AND product.caategory_id = '.$category_child.' ';
		}
		else
		{
			$category_child = '';
		}
		
		if(!empty($year_from) && !empty($year_to))
		{
			$product_year = ' AND product.product_year BETWEEN \''.$year_from.'\' AND \''.$year_to.'\'';
			$search_title .= 'Product date from '.date('jS M Y', strtotime($year_from)).' to '.date('jS M Y', strtotime($year_to)).' ';
		}
		
		else if(!empty($year_from))
		{
			$product_year = ' AND product.product_year = \''.$year_from.'\'';
			$search_title .= 'Product date of '.date('jS M Y', strtotime($year_from)).' ';
		}
		
		else if(!empty($year_to))
		{
			$product_year = ' AND product.product_year = \''.$year_to.'\'';
			$search_title .= 'Product date of '.date('jS M Y', strtotime($year_to)).' ';
		}
		
		else
		{
			$product_year = '';
		}
		
		
		
		$search = $brand_id.$brand_model_id.$category_id.$category_child.$product_year.$location_id;
		$this->session->set_userdata('product_search', $search);
		
		$this->products();
	}
	public function search_items()
	{
		$search_item = $this->input->post('search_item');

		//search surname
		$search_item = explode(",",$search_item);
		$total = count($search_item);
		
		$count = 1;
		$search_item = ' AND (';
		for($r = 0; $r < $total; $r++)
		{
			if($count == $total)
			{
				$search_item .= ' brand.brand_name LIKE \'%'.mysql_real_escape_string($search_item[$r]).'%\' OR  brand_model.brand_model_name LIKE \'%'.mysql_real_escape_string($search_item[$r]).'%\' OR category.category_name LIKE \'%'.mysql_real_escape_string($search_item[$r]).'%\'';
			}
			
			else
			{
				$search_item .= ' brand.brand_name LIKE \'%'.mysql_real_escape_string($search_item[$r]).'%\' OR  brand_model.brand_model_name LIKE \'%'.mysql_real_escape_string($search_item[$r]).'%\' OR category.category_name LIKE \'%'.mysql_real_escape_string($search_item[$r]).'%\'';
			}
			$count++;
		}

		$search_item .= ') ';
		
		$search =   $search_item;
		$this->session->set_userdata('product_search', $search);
		
		$this->products();
	}
    
	/*
	*
	*	Search for a product
	*
	*/
	public function search()
	{
		$search = $this->input->post('search_item');
		$web_name = $this->site_model->create_web_name($search);
		
		if(!empty($search))
		{
			redirect('products/search/'.$web_name);
		}
		
		else
		{
			redirect('products/all-products');
		}
	}
    
	/*
	*
	*	Products Page
	*
	*/
	public function view_product($web_name)
	{
		$product_data = $this->products_model->decode_web_name($web_name);
		$product_id = $this->products_model->get_product_id($product_data['product_code']);
		$data['title'] = $product_data['prod_name'];
		$v_data['title'] = $data['title'];
		
		$contacts = $this->site_model->get_contacts();
		$data['contacts'] = $contacts;
		$v_data['contacts'] = $contacts;
		
		$v_data['product_details'] = $this->products_model->get_product($product_id);
		$v_data['product_images'] = $this->products_model->get_products_images($product_id);
		$v_data['similar_products'] = $this->products_model->get_similar_products($product_id);
		
		//products path
		$v_data['products_path'] = $this->products_path;
		$v_data['products_location'] = $this->products_location;
		
		$data['content'] = $this->load->view('products/view_product', $v_data, true);
		
		$this->load->view('templates/general_page', $data);
	}
    public function more_info_request($product_id)
    {
    	//initialize required variables
		$v_data['name_error'] = '';
		$v_data['phone_error'] = '';
		$v_data['email_error'] = '';

		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('name', 'Full name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('preferred_contact', 'Preferred Contact', 'trim|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			if($this->products_model->more_info_request($product_id))
			{
				$data['success'] = 'success';
				$data['result'] = 'You request has been successfully been received. The seller will contact you shortly';
			}
		}
		else
		{
			$validation_errors = validation_errors();
			
			//repopulate form data if validation errors are present
			if(!empty($validation_errors))
			{
				//create errors
				$v_data['name_error'] = form_error('name');
				$v_data['phone_error'] = form_error('phone');
				$v_data['email_error'] = form_error('email');
				
				//repopulate fields
				$v_data['name'] = set_value('name');
				$v_data['phone'] = set_value('phone');
				$v_data['email'] = set_value('email');
			}
			
			//populate form data on initial load of page
			else
			{
				$v_data['name'] = '';
				$v_data['email'] = '';
				$v_data['phone'] = '';
			}
				$data['error'] = 'error';
				$data['result'] = 'Sorry something went wrong, please try again';
		}
		echo json_encode($data);
    }
    public function submit_query()
    {
    	if($this->site_model->submit_query_details())
		{
			$data['success'] = 'success';
			$data['result'] = 'You request has been successfully been received. The seller will contact you shortly';
		}
		else
		{
			$data['error'] = 'error';
			$data['result'] = 'Sorry something went wrong, please try again';
		}
		echo json_encode($data);
    }

    public function send_to_friend($product_id)
    {
    	if($this->site_model->send_to_friend($product_id))
		{
			$data['success'] = 'success';
			$data['result'] = 'You request has been successfully been received. The seller will contact you shortly';
		}
		else
		{
			$data['error'] = 'error';
			$data['result'] = 'Sorry something went wrong, please try again';
		}
		echo json_encode($data);
    }
	/*
	*
	*	About
	*
	*/
	public function about()
	{
		$data['content'] = $this->load->view('about', '', true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
    
	/*
	*
	*	Contact
	*
	*/
	public function contact()
	{
		$contacts = $this->site_model->get_contacts();
		$v_data['contacts'] = $contacts;

		$data['content'] = $this->load->view('contact', $v_data, true);
		
		$data['title'] = $this->site_model->display_page_title();
		$this->load->view('templates/general_page', $data);
	}
	
	public function get_sub_categories($category_id)
	{
		$return['children'] = $this->categories_model->limit_sub_categories($category_id);
		
		echo json_encode($return);
	}
	
	public function get_brand_models($brand_id, $category)
	{
		$table2 = "product, category, brand_model, brand, location, customer";
		$where2 = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		
		//Models
		$results = $this->brands_model->get_brand($brand_id);
		
		$models = '';
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				$brand_web_name = $this->site_model->create_web_name($res->brand_name);
				
				$this->db->where("brand_model_status = 1 AND brand_id = ".$res->brand_id);
				$this->db->select("brand_model_name, brand_model_id");
				$this->db->order_by("brand_model_name");
				
				$result2 = $this->db->get("brand_model");
				
				if($result2->num_rows() > 0)
				{
					foreach($result2->result() as $res2)
					{
						$total_models = $this->users_model->count_items($table2, $where2.' AND product.brand_model_id = '.$res2->brand_model_id);
						$model_web_name = $this->site_model->create_web_name($res2->brand_model_name);
						$models .= '<li class="list-group-item"><span class="badge">'.$total_models.'</span><a href="'.site_url().'spareparts/model/'.$category.'/'.$brand_web_name.'/'.$model_web_name.'">'.$res2->brand_model_name.'</a></li>';
					}
				}
			}
		}
		
		$v_data['models'] = $models;
		
		echo json_encode($v_data);
	}
}
?>