<?php session_start();  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/admin/controllers/admin.php";

class Products extends admin {
	var $products_path;
	var $gallery_path;
	var $features_path;
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('users_model');
		$this->load->model('products_model');
		$this->load->model('categories_model');
		$this->load->model('brands_model');
		$this->load->model('brand_models_model');
		$this->load->model('file_model');
		
		//path to image directory
		$this->products_path = realpath(APPPATH . '../assets/images/products/images');
		$this->gallery_path = realpath(APPPATH . '../assets/images/products/gallery');
		$this->features_path = realpath(APPPATH . '../assets/images/features');
	}
    
	/*
	*
	*	Default action is to show all the products
	*
	*/
	public function index() 
	{
		$where = 'product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.customer_id = customer.customer_id';
		$table = 'product, category, brand, brand_model, customer';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/all-products';
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
		$query = $this->products_model->get_all_products($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('products/all_products', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'admin/add-product" class="btn btn-success pull-right">Add Product</a>There are no products';
		}
		$data['title'] = 'All Parts';
		
		$this->load->view('templates/general_admin', $data);
	}
    
	/*
	*
	*	Delete an existing product
	*	@param int $product_id
	*
	*/
	public function delete_product($product_id, $page)
	{
		//delete product image
		$query = $this->products_model->get_product($product_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$image = $result[0]->product_image_name;
			
			//delete image
			$this->file_model->delete_file($this->products_path."\\".$image);
			//delete thumbnail
			$this->file_model->delete_file($this->products_path."\\thumb_".$image);
		}
		
		//delete gallery images
		$query = $this->products_model->get_gallery_images($product_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $res)
			{
				$image = $res->product_image_name;
				$thumb = $res->product_image_thumb;
				
				//delete image
				$this->file_model->delete_file($this->gallery_path."\\".$image);
				//delete thumbnail
				$this->file_model->delete_file($this->gallery_path."\\".$thumb);
			}
			
			$this->products_model->delete_gallery_images($product_id);
		}
		
		//delete features
		$query = $this->products_model->get_features($product_id);
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			foreach($result as $res)
			{
				$image = $res->image;
				$thumb = $res->thumb;
				
				//delete image
				$this->file_model->delete_file($this->features_path."\\".$image);
				//delete thumbnail
				$this->file_model->delete_file($this->features_path."\\".$thumb);
			}
			
			$this->products_model->delete_features($product_id);
		}
		
		$this->products_model->delete_product($product_id);
		$this->session->set_userdata('success_message', 'Product has been deleted');
		redirect('admin/all-products/'.$page);
	}
    
	/*
	*
	*	Activate an existing product
	*	@param int $product_id
	*
	*/
	public function activate_product($product_id, $page)
	{
		$this->products_model->activate_product($product_id);
		$this->session->set_userdata('success_message', 'Product activated successfully');
		redirect('admin/all-products/'.$page);
	}
    
	/*
	*
	*	Deactivate an existing product
	*	@param int $product_id
	*
	*/
	public function deactivate_product($product_id, $page)
	{
		$this->products_model->deactivate_product($product_id);
		$this->session->set_userdata('success_message', 'Product disabled successfully');
		redirect('admin/all-products/'.$page);
	}
	
	public function upload_images() 
	{
		$this->load->view('upload');
	}
	
	// Upload & Resize in action
    public function do_upload()
    {
		$this->load->library('upload');
		$this->load->library('image_lib');
		
		$resize['width'] = 600;
		$resize['height'] = 800;
		
		$response = $this->file_model->upload_gallery(1, $this->gallery_path, $resize);
        
		if($response)
		{
		   $this->load->view('upload');
		}
		
		else
		{
		   var_dump($response);
		}
    }
	
	/**
	 * Get all the features of a category
	 * Called when adding a new product
	 *
	 * @param int category_id
	 *
	 * @return object
	 *
	 */
	function get_category_features($category_id)
	{
		$data['features'] = $this->features_model->all_features_by_category($category_id);
		
		echo $this->load->view('products/features', $data, TRUE);
	}
	
	function add_new_feature($category_feature_id)
	{
		$feature_name = $this->input->post('sub_feature_name'.$category_feature_id);
		$feature_quantity = $this->input->post('sub_feature_qty'.$category_feature_id);
		$feature_price = $this->input->post('sub_feature_price'.$category_feature_id);
		
		//upload product's gallery images
		$resize['width'] = 600;
		$resize['height'] = 800;
		
		if(is_uploaded_file($_FILES['feature_image'.$category_feature_id]['tmp_name']))
		{
			$this->load->library('image_lib');
			
			$features_path = $this->features_path;
			/*
				-----------------------------------------------------------------------------------------
				Upload image
				-----------------------------------------------------------------------------------------
			*/
			$response = $this->file_model->upload_single_dir_file($features_path, 'feature_image'.$category_feature_id, $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				$options = $this->products_model->add_new_features($category_feature_id, $feature_name, $feature_quantity, $feature_price, $file_name, $thumb_name);
		
				$return['result'] = 'success';
				$return['result_options'] = $options;
			}
		
			else
			{
				$return['result'] = 'image_fail';
				$return['options'] = $response['error'];
			}
		}
		
		else
		{
			$options = $this->products_model->add_new_features($category_feature_id, $feature_name, $feature_quantity, $feature_price);
		
			$return['result'] = 'success';
			$return['result_options'] = $options;
		}
			
		echo json_encode($return);
	}
	
	function delete_new_feature($category_feature_id, $row)
	{
		$_SESSION['name'.$category_feature_id][$row] = NULL;
		$_SESSION['quantity'.$category_feature_id][$row] = NULL;
		$_SESSION['price'.$category_feature_id][$row] = NULL;
		
		//delete images
		if($_SESSION['image'.$category_feature_id][$row] != 'None')
		{
			$this->file_model->delete_file($this->features_path."\\".$_SESSION['image'.$category_feature_id][$row]);
			$this->file_model->delete_file($this->features_path."\\".$_SESSION['thumb'.$category_feature_id][$row]);
		}
		$_SESSION['image'.$category_feature_id][$row] = NULL;
		$_SESSION['thumb'.$category_feature_id][$row] = NULL;
		
		$feature_values = $this->products_model->fetch_new_category_features($category_feature_id);
		$options = '';
		
		if(isset($feature_values))
		{
			$options .= '
				<table class="table table-condensed table-responsive table-hover table-striped">
					<tr>
						<th></th>
						<th>Sub Feature</th>
						<th>Quantity</th>
						<th>Additional Price</th>
						<th>Image</th>
					</tr>
			'.$feature_values.'</table>
			';
		}
		
		else
		{
			$options .= '<p>You have not added any features</p>';
		}
		echo $options;
	}
	
	function delete_product_feature($product_feature_id)
	{
		$features = $this->products_model->get_product_feature($product_feature_id);
		$feat = $features->row();
		
		$feat_id = $feat->feature_id;
		$image = $feat->image;
		$thumb = $feat->thumb;
		
		//delete images
		if($image != 'None')
		{
			$this->file_model->delete_file($this->features_path."\\".$image);
			$this->file_model->delete_file($this->features_path."\\".$thumb);
		}
		
		if($this->products_model->delete_product_feature($product_feature_id))
		{
			
			$v_data['features'] = $this->products_model->get_features($product_id);
			$v_data['all_features'] = $this->features_model->all_features();
			
			echo $this->load->view('products/edit_features', $v_data, TRUE);
		}
		
		else
		{
			echo 'false';
		}
	}
	
	public function delete_gallery_image($product_image_id, $product_id)
	{
		$this->products_model->delete_gallery_image($product_image_id);
		redirect('edit-product/'.$product_id);
	}
	
	function view_features()
	{
		//session_unset();
		$res = $this->products_model->fetch_new_category_features(1);
		var_dump($_SESSION['image1']);
	}
}
?>