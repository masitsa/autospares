<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell extends MX_Controller 
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
		$this->load->model('administration/administration_model');
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
	
	function sell_parts()
	{
		//product images
		$product_image = $this->session->userdata('product_image');
		$gallery1 = $this->session->userdata('gallery1');
		$gallery2 = $this->session->userdata('gallery2');
		
		if(empty($product_image))
		{
			$product_image = 'http://placehold.it/300x300?text=default';
		}
		
		else
		{
			$product_image = $this->products_location.$product_image;
		}
		
		if(empty($gallery1))
		{
			$gallery1 = 'http://placehold.it/300x300?text=image+2';
		}
		
		else
		{
			$gallery1 = $this->products_location.$gallery1;
		}
		
		if(empty($gallery2))
		{
			$gallery2 = 'http://placehold.it/300x300?text=image+3';
		}
		
		else
		{
			$gallery2 = $this->products_location.$gallery2;
		}
		
		$v_data['product_image'] = $product_image;
		$v_data['gallery1'] = $gallery1;
		$v_data['gallery2'] = $gallery2;
		//Brands & models
		$results = $this->brands_model->all_active_brands();
		
		$count = 0;
		$models = '<option value="0">Any model</option>';
		$brands = '<option value="0">Any brand</option>';
		
		if($results->num_rows() > 0)
		{
			$brand_id = set_value('product_brand_id');
			foreach($results->result() as $res)
			{
				if($brand_id == $res->brand_id)
				{
					$brands .= '<option value="'.$res->brand_id.'" selected>'.$res->brand_name.'</option>';
					
					$table = "brand_model";
					$where = "brand_model_status = 1 AND brand_id = ".$brand_id;
					$this->db->order_by('brand_model_name');
					$this->db->where($where);
					$result2 = $this->db->get($table);
					
					if($result2->num_rows() > 0)
					{
						$model_id = set_value('product_model_id');
						foreach($result2->result() as $res2)
						{
							if($model_id == $res2->brand_model_id)
							{
								$models .= "<option value='".$res2->brand_model_id."' selected>".$res2->brand_model_name."</option>";
							}
							
							else
							{
								$models .= "<option value='".$res2->brand_model_id."'>".$res2->brand_model_name."</option>";
							}
						}
					}
				}
				
				else
				{
					$brands .= '<option value="'.$res->brand_id.'">'.$res->brand_name.'</option>';
				}
			}
		}
		$v_data['brands'] = $brands;
		$v_data['models'] = $models;
		
		//Year from & to
		$year_from = 1980;
		$v_data['year_from'] = "";
		$v_data['year_to'] = "";
		$product_year = set_value('product_year');
		for($r = date("Y"); $r >= $year_from; $r--)
		{
			if($product_year == $r)
			{
				$v_data['year_to'] .= "<option selected>".$r."</option>";
			}
			
			else
			{
				$v_data['year_to'] .= "<option>".$r."</option>";
			}
		}
		
		//Categpries & sub categories
		$results = $this->categories_model->all_parent_categories();
		$categories = "";
		$children = "";
		$sub_children = "";
		$count = 0;
		
		if($results->num_rows() > 0)
		{
			$category_id = set_value('product_category_id');
			$child_id = set_value('product_category_child');
			$sub_child_id = set_value('product_category_sub_child');
			
			foreach($results->result() as $res)
			{
				$count++;
				
				if(($count == 1) || (!empty($child_id)))
				{
					$this->db->where("category_parent = ".$res->category_id);
					$this->db->order_by("category_name");
					
					$result2 = $this->db->get("category");
					
					if($result2->num_rows() > 0)
					{
						$count2 = 0;
						foreach($result2->result() as $res2)
						{
							$count2++;
				
							if(($count2 == 1) || (!empty($sub_child_id)))
							{
								$this->db->where("category_parent = ".$res2->category_id);
								$this->db->order_by("category_name");
								
								$result3 = $this->db->get("category");
								
								if($result3->num_rows() > 0)
								{
									foreach($result3->result() as $res3)
									{
										if($sub_child_id == $res3->category_id)
										{
											$sub_children .= '<option value="'.$res3->category_id.'" selected>'.$res3->category_name.'</option>';
										}
										
										else
										{
											$sub_children .= '<option value="'.$res3->category_id.'">'.$res3->category_name.'</option>';
										}
										
									}
								}
							}
							if($child_id == $res2->category_id)
							{
								$children .= '<option value="'.$res2->category_id.'" selected>'.$res2->category_name.'</option>';
							}
							
							else
							{
								$children .= '<option value="'.$res2->category_id.'">'.$res2->category_name.'</option>';
							}
							
						}
					}
				}
				
				if($category_id == $res->category_id)
				{
					$categories .= '<option value="'.$res->category_id.'" selected>'.$res->category_name.'</option>';
				}
				
				else
				{
					$categories .= '<option value="'.$res->category_id.'">'.$res->category_name.'</option>';
				}
				
			}
		}
		$v_data['categories'] = $categories;
		$v_data['children'] = $children;
		$v_data['sub_children'] = $sub_children;
		
		//Location
		$this->db->order_by('location_name');
		$results = $this->db->get('location');
		$locations = "";
		$location_id = set_value('location_id');
		
		if($results->num_rows() > 0)
		{
			foreach($results->result() as $res)
			{
				if($location_id == $res->location_id)
				{
					$locations .= '<option value="'.$res->location_id.'" selected>'.$res->location_name.'</option>';
				}
				
				else
				{
					$locations .= '<option value="'.$res->location_id.'">'.$res->location_name.'</option>';
				}
			}
		}
		$v_data['locations'] = $locations;
		
		$data['title'] = $this->site_model->display_page_title();
		$v_data['title'] = $data['title'];
		
		$data['content'] = $this->load->view('products/add_product', $v_data, true);
		
		$this->load->view('templates/general_page', $data);
	}
	
	function search_brand_models($brand_id)
	{
  		$table = "brand_model";
		$where = "brand_model_status = 1 AND brand_id = ".$brand_id;
		$this->db->order_by('brand_model_name');
		$this->db->where($where);
		$result = $this->db->get($table);
		
		if($result->num_rows() > 0)
		{
			$models = '<select class="form-control selectpicker products_models" name="product_model_id"><option value="0">Any model</option>';
			foreach($result->result() as $res)
			{
				$models .= "<option value='".$res->brand_model_id."'>".$res->brand_model_name."</option>";
			}
			$models .= '</select>';
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
		$this->db->order_by('category_name');
		$this->db->where($where);
		$result = $this->db->get($table);
		
		$children = '<select class="form-control selectpicker product_category_sub_children" name="product_category_child"><option value="">No level 2</option>';
		$sub_children = '<select class="form-control selectpicker" name="product_category_sub_child"><option value="">No level 3</option>';
		
		if($result->num_rows() > 0)
		{
			foreach($result->result() as $res2)
			{
				$children .= "<option value='".$res2->category_id."'>".$res2->category_name."</option>";
				
				$this->db->where("category_parent = ".$res2->category_id);
				$this->db->order_by("category_name");
				
				$result3 = $this->db->get("category");
				
				if($result3->num_rows() > 0)
				{
					foreach($result3->result() as $res3)
					{
						$sub_children .= '<option value="'.$res3->category_id.'">'.$res3->category_name.'</option>';
					}
				}
			}
		}
		
		$sub_children .= '</select>';
		$children .= '</select>';
		
		$return['children'] = $children;
		$return['sub_children'] = $sub_children;
		
		echo json_encode($return);
	}
	
	function search_category_sub_children($category_id)
	{
		$table = "category";
		$where = "category_parent = ".$category_id;
		$this->db->order_by('category_name');
		$this->db->where($where);
		$result = $this->db->get($table);
		
		if($result->num_rows() > 0)
		{
			$sub_children = '<select class="form-control selectpicker" name="product_category_sub_child"><option value="">No level 3 </option>';
			foreach($result->result() as $res2)
			{
				$sub_children .= "<option value='".$res2->category_id."'>".$res2->category_name."</option>";
			}
			$sub_children .= '</select>';
		}
		else
		{
			$sub_children = "false";
		}
		echo $sub_children;
	}
	
	function validate_product()
	{
		$this->load->library('image_lib');
		$this->load->model('admin/file_model');
		
		//upload image if it has been selected
		$response = $this->products_model->upload_product_image($this->products_path, $this->products_location, 'product_image');
		if($response)
		{
			//$v_data['blog_image_location'] = $this->post_location.$this->session->userdata('blog_file_name');
		}
		
		//upload image 2 if it has been selected
		$response = $this->products_model->upload_product_image($this->products_path, $this->products_location, 'gallery1');
		//var_dump($response);die();
		if($response)
		{
			//$v_data['blog_image_location'] = $this->post_location.$this->session->userdata('blog_file_name');
		}
		
		//upload image 3 if it has been selected
		$response = $this->products_model->upload_product_image($this->products_path, $this->products_location, 'gallery2');
		if($response)
		{
			//$v_data['blog_image_location'] = $this->post_location.$this->session->userdata('blog_file_name');
		}
		
		$this->form_validation->set_rules('location_id', 'Location', 'trim|xss_clean');
		$this->form_validation->set_rules('product_year', 'Product Year', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_brand_id', 'Brand', 'trim|numeric|xss_clean');
		$this->form_validation->set_rules('product_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_category_id', 'Category level 1', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_category_child', 'Category level 2', 'trim|xss_clean');
		$this->form_validation->set_rules('product_category_sub_child', 'Category level 3', 'trim|xss_clean');
		$this->form_validation->set_rules('agree', 'Agree to t&c', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|valid_email|xss_clean');
		$this->form_validation->set_rules('seller_name', 'Names', 'trim|required|xss_clean');
		$this->form_validation->set_rules('user_phone', 'Phone', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE) 
		{
			$this->sell_parts();
		} 
		
		else 
		{
			//check if upload error is present
			$upload_error = $this->session->userdata('error');
			
			if(!empty($upload_error))
			{
				$this->sell_parts();
				break;
			}
			
			else
			{
				//get product image name
				$file_name = $this->session->userdata('product_image');
				
				//get customer id
				$customer_id = $this->administration_model->add_customer();
				
				//add product
				$product_id = $this->products_model->add_product_site($file_name, $customer_id);
				
				//create tiny url
				$tiny_url = $this->products_model->getTinyUrl($product_id);
				
				$items = array(
							'tiny_url' => $tiny_url
						);
				$table = "product";
				$this->db->where('product_id', $product_id);
				$this->db->update($table, $items);
				
				//upload product images
				if($product_id > 0)
				{
					$file = $this->session->userdata('gallery1');
					
					if(!empty($file))
					{	
						$table = "product_image";
						$data = array(//get the items from the form
									'product_id' => $product_id,
									'product_image_name' => $file,
									'product_image_thumb' => 'thumbnail_'.$file
								);
						$this->db->insert($table, $data);
					}
					
					$file = $this->session->userdata('gallery2');
					
					if(!empty($file))
					{	
						$table = "product_image";
						$data = array(//get the items from the form
									'product_id' => $product_id,
									'product_image_name' => $file,
									'product_image_thumb' => 'thumbnail_'.$file
								);
						$this->db->insert($table, $data);
					}
				}
				
				//unset sessions
				$this->session->unset_userdata('product_image');
				$this->session->unset_userdata('product_image_thumb');
				
				$this->session->unset_userdata('gallery1');
				$this->session->unset_userdata('gallery1_thumb');
				
				$this->session->unset_userdata('gallery2');
				$this->session->unset_userdata('gallery2_thumb');
				
				$this->session->set_userdata('sell_success', 'Your autopart has been successfully added to Autospares. <a href="'.$tiny_url.'" class="btn btn-success">View autopart</a>');
				$this->sell_parts();
			}
		}
	}
}
?>