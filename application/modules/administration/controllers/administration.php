<?php session_start();
ini_set('display_errors', 'On');

error_reporting(-1);

define('MP_DB_DEBUG', true); 

class Administration extends MX_Controller {
	
	var $gallery_path;
	var $gallery_path2;
	var $gallery_path3;
	var $gallery_path4;
	var $gallery_path5;
	
	/********************************************************************************************
	*																							*
	*			BY DEFAULT ALL ACTIONS WARANTY A CHECK TO SEE WHETHER THE ADMINISTRATOR'S 		*
	*										SESSION IS ACTIVE									*
	*																							*
	********************************************************************************************/
	
	function __construct() 
	{
		redirect('admin');
  	}
	
	/********************************************************************************************
	*																							*
	*									INCLUDE HEADERS & FOOTERS								*
	*																							*
	********************************************************************************************/
	
	function index()
	{
		redirect('admin');
	}
	
	function select_navigation()
	{
  		$table = "navigation";
		$where = "navigation.navigation_id > 0";
		$items = "navigation_id, navigation_name, navigation_url";
		$order = "navigation_name";
		
		$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	function select_sub_navigation()
	{
  		$table = "sub_navigation";
		$where = "sub_navigation.navigation_id = ".$_SESSION['navigation_id'];
		$items = "sub_navigation_id, sub_navigation_name, sub_navigation_url";
		$order = "sub_navigation_id";
		
		$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	function load_head()
	{
		$data2['navigation'] = $this->select_navigation();
		$data['navigation'] = $this->select_sub_navigation();
		
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data3['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("includes/head", $data3);
		$this->load->view("includes/login_head", $data2);
		$this->load->view("includes/header");
		$this->load->view('includes/nav',$data);
	}
	
	function load_foot()
	{
		$this->load->view("includes/footer");
	}
	
	function load_login()
	{
		$this->load->view("includes/login_head");
	}
	
	function do_upload($gallery_path) 
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
		
		$this->load->library('upload', $config);
		if($this->upload->do_upload() == FALSE)
		{
			return "FALSE";
		}
		else{
			$image_data = $this->upload->data();
			return $image_data;
		}
	}
	
	function create_thumb($path, $gallery_path, $file_name)
	{
		/*
			-----------------------------------------------------------------------------------------
			Create a thumbnail
			-----------------------------------------------------------------------------------------
		*/
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $path.'thumbs/'.$file_name,
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
	
	function resize_image($path, $gallery_path, $file_name)
	{
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $path.'images/'.$file_name,
			'create_thumb'  => FALSE,
			'width' => 500,
			'height' => 500,
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
	
	function resize_image_slideshow($path, $gallery_path, $file_name)
	{
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $path.'images/'.$file_name,
			'create_thumb'  => FALSE,
			'width' => 1035,
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
	
	/**
	 * Upload multiple files for a gallery
	 *
	 * @param int product_id
	 *
	 */
    function upload_gallery($product_id)
    {
		//Libraries
        $this->load->library('upload');
        $this->load->library('image_lib');
    
        // Change $_FILES to new vars and loop them
        foreach($_FILES['gallery'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }
        // Unset the useless one ;)
        unset($_FILES['gallery']);
    
        // Put each errors and upload data to an array
        $error = array();
        $success = array();
        
        // main action to upload each file
        foreach($_FILES as $field_name => $file)
        {
		
		$upload_conf = array(
			'allowed_types' => 'JPG|JPEG|jpg|jpeg|gif|png',
			'upload_path' => realpath('assets/products'),
			'quality' => "100%",
			'file_name' => "image_".date("Y")."_".date("m")."_".date("d")."_".date("H")."_".date("i")."_".date("s"),
			'max_size' => 20000,
			'maintain_ratio' => true,
			'height' => 345,
			'width' => 460
         );
    
        $this->upload->initialize( $upload_conf );
		
		if ( ! $this->upload->do_upload($field_name))
		{
			// if upload fail, grab error 
			$error['upload'][] = $this->upload->display_errors();
		}
		else
		{
			// otherwise, put the upload datas here.
			// if you want to use database, put insert query in this loop
			$upload_data = $this->upload->data();
			
			// set the resize config
			$resize_conf = array(
				// it's something like "/full/path/to/the/image.jpg" maybe
				'source_image'  => $upload_data['full_path'], 
				'new_image'     => $upload_data['file_path'].'gallery/'.$upload_data['file_name'],
				'create_thumb'     => FALSE,
				'width' => 460,
				'height' => 345,
				'maintain_ratio' => true,
				);

			// initializing
			$this->image_lib->initialize($resize_conf);

			// do it!
			if ( ! $this->image_lib->resize())
			{
				// if got fail.
				$error['resize'][] = $this->image_lib->display_errors();
			}
			else
			{
				// otherwise, put each upload data to an array.
				$success[] = $upload_data;
			}
			
			$data = array(//get the items from the form
				'product_id' => $product_id,
				'product_image_name' => $upload_data['file_name'],
				'product_image_thumb' => 'thumb_'.$upload_data['file_name']
			);
		
			$insert = $this->db->insert('product_image', $data);
			
			// set the resize config
			$resize_conf = array(
				// it's something like "/full/path/to/the/image.jpg" maybe
				'source_image'  => $upload_data['full_path'], 
				// and it's "/full/path/to/the/" + "thumb_" + "image.jpg
				// or you can use 'create_thumbs' => true option instead
				'new_image'     => $upload_data['file_path'].'gallery/thumb_'.$upload_data['file_name'],
				'width'         => 80,
				'height'        => 60,
				'maintain_ratio' => true,
				);

			// initializing
			$this->image_lib->initialize($resize_conf);

			// do it!
			if ( ! $this->image_lib->resize())
			{
				// if got fail.
				$error['resize'][] = $this->image_lib->display_errors();
			}
			else
			{
				// otherwise, put each upload data to an array.
				$success[] = $upload_data;
			}
			//delete_files($upload_data['full_path']);
		}
			
        }

        // see what we get
        if(count($error > 0))
        {
            $data['error'] = $error;
        }
        else
        {
            $data['success'] = $upload_data;
        }
		return TRUE;
    }
	
	/**
	 * Delete gallery image
	 *
	 * @param int product_image_id
	 *
	 */
	function delete_gallery_image($product_image_id, $product_id)
	{
		$table = 'product_image';
		$field = 'product_image_id';
		$this->administration_model->delete($table, $field, $product_image_id);
		$this->edit_product($product_id);
	}
	
	/********************************************************************************************
	*																							*
	*									CATEGORIES FUNCTIONS									*
	*																							*
	********************************************************************************************/
	
	function list_categories($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "category";
		$where = "category_id > 0";
		$items = "*";
		$order = "category_parent, category_name";
		
		$data['categories'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("categories/categories_list", $data);
		$this->load_foot();
	}
	
	function add_category($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('category_preffix', 'Preffix', 'trim|required|is_unique[category.category_preffix]|xss_clean');
		$this->form_validation->set_rules('category_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category Parent', 'numeric|xss_clean');
		//$this->form_validation->set_rules('userfile', 'Image', 'required|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique preffix is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path2;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			$data = array(
				'category_name'=>$this->input->post('category_name'),
				'category_parent'=>$this->input->post('category_parent'),
				'category_preffix'=>$this->input->post('category_preffix'),
				'category_image_name'=>$file_name
			);
			
			$table = "category";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_category/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new category
				-----------------------------------------------------------------------------------------
			*/
		
			$table = "category";
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("categories/add_category", $data);
			$this->load_foot();
		}
	}
	
	function edit_category($category_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('category_preffix', 'Preffix', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category Parent', 'numeric|xss_clean');
		//$this->form_validation->set_rules('userfile', 'Image', 'required|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique preffix is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path2;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post('category_image_name');
			}
			
			$data = array(
				'category_name'=>$this->input->post('category_name'),
				'category_parent'=>$this->input->post('category_parent'),
				'category_preffix'=>$this->input->post('category_preffix'),
				'category_image_name'=>$file_name
			);
			
			$table = "category";
			$this->administration_model->update($table, $data, "category_id", $category_id);
			redirect('administration/list_categories/1/1');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new category
				-----------------------------------------------------------------------------------------
			*/
		
			$table = "category";
			$where = "category_id = ".$category_id;
			$items = "*";
			$order = "category_name";
			$data['category'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("categories/edit_category", $data);
			$this->load_foot();
		}
	}
	
	function delete_category($category_id)
	{
		$this->administration_model->delete("category", "category_id", $category_id);
		
		echo "true";
	}
	
	function deactivate_category($category_id)
	{
		$data = array(
			'category_status'=>0
		);
		
		$table = "category";
		$this->administration_model->update($table, $data, "category_id", $category_id);
		
		redirect('administration/list_categories/1/1');
	}
	
	function activate_category($category_id)
	{
		$data = array(
			'category_status'=>1
		);
		
		$table = "category";
		$this->administration_model->update($table, $data, "category_id", $category_id);
		
		redirect('administration/list_categories/1/1');
	}
	
	/********************************************************************************************
	*																							*
	*									BRANDS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function brands($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "brand";
		$where = "brand_id > 0";
		$items = "*";
		$order = "brand_name";
		
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['base_url'] = site_url().'administration/brands/'.$navigation_id."/".$sub_navigation_id;
		$config['per_page'] = 30;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data['brands'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		$data['page'] = $page;
		
        $data["links"] = $this->pagination->create_links();
		
		$this->load_head();
		$this->load->view("brands/brand_list", $data);
		$this->load_foot();
	}
	
	function add_brand($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path5;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			$data = array(
				'brand_name'=>$this->input->post('brand_name'),
				'brand_image_name'=>$file_name
			);
			
			$table = "brand";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_brand/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$this->load_head();
			$this->load->view("brands/add_brand");
			$this->load_foot();
		}
	}
	
	function edit_brand($brand_id, $page)
	{
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path5;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post('hidden_image');
			}
			
			$data = array(
				'brand_name'=>$this->input->post('brand_name'),
				'brand_image_name'=>$file_name
			);
			
			$table = "brand";
			$this->administration_model->update($table, $data, "brand_id", $brand_id);
			redirect('administration/brands/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']."/".$page);
		}
		
		else
		{
			$table = "brand";
			$where = "brand_id = ".$brand_id;
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("brands/edit_brand", $data);
			$this->load_foot();
		}
	}
	
	function delete_brand($brand_id)
	{
		$this->administration_model->delete("brand", "brand_id", $brand_id);
		
		echo "true";
	}
	
	function deactivate_brand($brand_id)
	{
		$data = array(
			'brand_status'=>0
		);
		
		$table = "brand";
		$this->administration_model->update($table, $data, "brand_id", $brand_id);
		
		redirect('administration/brands/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	function activate_brand($brand_id)
	{
		$data = array(
			'brand_status'=>1
		);
		
		$table = "brand";
		$this->administration_model->update($table, $data, "brand_id", $brand_id);
		
		redirect('administration/brands/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	/********************************************************************************************
	*																							*
	*									MODELS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function brand_models($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "brand_model, brand";
		$where = "brand_model.brand_id = brand.brand_id";
		$items = "brand.brand_id, brand.brand_name, brand_model.brand_model_name, brand_model.brand_model_id, brand_model.brand_model_status";
		$order = "brand_name, brand_model_name";
		
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['base_url'] = site_url().'administration/brand_models/'.$navigation_id."/".$sub_navigation_id;
		$config['per_page'] = 30;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data['brand_models'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
        $data["links"] = $this->pagination->create_links();
		
		$this->load_head();
		$this->load->view("brands/brand_model_list", $data);
		$this->load_foot();
	}
	
	function add_brand_model($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_name', 'Model Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			$data = array(
				'brand_id'=>$this->input->post('brand_id'),
				'brand_model_name'=>$this->input->post('brand_model_name')
			);
			
			$table = "brand_model";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_brand_model/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "brand";
			$where = "brand_status = 1";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("brands/add_brand_model", $data);
			$this->load_foot();
		}
	}
	
	function edit_brand_model($brand_model_id)
	{
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_name', 'Model Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			$data = array(
				'brand_id'=>$this->input->post('brand_id'),
				'brand_model_name'=>$this->input->post('brand_model_name')
			);
			
			$table = "brand_model";
			$this->administration_model->update($table, $data, "brand_model_id", $brand_model_id);
			redirect('administration/brand_models/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "brand";
			$where = "brand_status = 1";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "brand_model, brand";
			$where = "brand_model.brand_id = brand.brand_id AND brand_model_id = ".$brand_model_id;
			$items = "brand.brand_id, brand_name, brand_model_name, brand_model_id";
			$order = "brand_name, brand_model_name";
			
			$data['brand_models'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("brands/edit_brand_model", $data);
			$this->load_foot();
		}
	}
	
	function delete_brand_model($brand_model_id)
	{
		$this->administration_model->delete("brand_model", "brand_model_id", $brand_model_id);
		
		echo "true";
	}
	
	function deactivate_brand_model($brand_model_id)
	{
		$data = array(
			'brand_model_status'=>0
		);
		
		$table = "brand_model";
		$this->administration_model->update($table, $data, "brand_model_id", $brand_model_id);
		
		redirect('administration/brand_models/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	function activate_brand_model($brand_model_id)
	{
		$data = array(
			'brand_model_status'=>1
		);
		
		$table = "brand_model";
		$this->administration_model->update($table, $data, "brand_model_id", $brand_model_id);
		
		redirect('administration/brand_models/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	/********************************************************************************************
	*																							*
	*									PRODUCTS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function list_products($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "product, category, brand_model, brand, customer";
		$where = "product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND product.brand_id = brand.brand_id AND product.customer_id = customer.customer_id";
		$items = "product.transaction_number, customer.customer_name, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_date";
		
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['base_url'] = site_url().'administration/list_products/'.$navigation_id."/".$sub_navigation_id;
		$config['per_page'] = 30;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data['products'] = $this->administration_model->select_pagination2($config["per_page"], $page, $table, $where, $items, $order);
		
        $data["links"] = $this->pagination->create_links();
		
		$this->load_head();
		$this->load->view("products/products_list", $data);
		$this->load_foot();
	}
	
	function add_product($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('product_year', 'Product Year', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_buying_price', 'Buying Price', 'trim|xss_clean');
		$this->form_validation->set_rules('product_balance', 'Balance', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique code is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			/*
				-----------------------------------------------------------------------------------------
				Create Product Number
				-----------------------------------------------------------------------------------------
			*/
			$table = "category";
			$where = "category_id = ".$this->input->post('category_id');
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
			
			$data = array(
				'product_code'=>$number,
				'product_year'=>$this->input->post('product_year'),
				'brand_model_id'=>$this->input->post('brand_model_id'),
				'brand_id'=>$this->input->post('brand_id'),
				'product_description'=>$this->input->post('product_description'),
				'product_name'=>$this->input->post('product_name'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_balance'=>$this->input->post('product_balance'),
				'category_id'=>$this->input->post('category_id'),
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
			
			if($product_id > 0){
				$this->upload_gallery($product_id);
			}
			redirect('administration/add_product/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
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
			
			$table = "brand";
			$where = "brand_id > 0";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("products/add_product", $data);
			$this->load_foot();
		}
	}
	
	function get_brand_models($brand_id)
	{
		$table = "brand_model";
		$where = "brand_id = ".$brand_id;
		$items = "*";
		$order = "brand_model_name";
		$data['brand_models'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("products/models", $data);
	}
	
	function create_thumb2($path, $gallery_path, $file_name, $new_path)
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
	
	function resize_image2($path, $gallery_path, $file_name, $new_path)
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
	
	function do_upload2($gallery_path, $field_name) 
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
	
	function upload_file()
	{
		$this->load->library('image_lib');
		if(is_uploaded_file($_FILES['image_name']['tmp_name']))
		{
			$field_name = 'image_name';
			$gallery_path = $this->gallery_path;
			$image_data = $this->do_upload2($gallery_path, $field_name);
		
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
				$create = $this->resize_image2($path, $gallery_path, $file_name, $new_path);
				
				/*
					-----------------------------------------------------------------------------------------
					Create product thumbnail
					-----------------------------------------------------------------------------------------
				*/
				$create = $this->create_thumb2($path, $gallery_path, $file_name, $thumb_path);
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
				$image_data = $this->do_upload2($gallery_path, $field_name);
			
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
					$create = $this->resize_image2($path, $gallery_path, $gallery_file, $new_path);
					
					/*
						-----------------------------------------------------------------------------------------
						Create product thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb2($path, $gallery_path, 'thumb_'.$gallery_file, $new_path);
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
	
	function edit_product($product_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_code', 'Code', 'trim|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|xss_clean');
		$this->form_validation->set_rules('customer_id', 'Customer', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_buying_price', 'Buying Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_balance', 'Balance', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique code is requred.");

		if ($this->form_validation->run())
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
				$file_name = $this->input->post('product_image');;
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
			
			$data = array(
				'product_year'=>$this->input->post('product_year'),
				'product_code'=>$this->input->post('product_code'),
				'product_description'=>$this->input->post('product_description'),
				'customer_id'=>$this->input->post('customer_id'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_balance'=>$this->input->post('product_balance'),
				'category_id'=>$this->input->post('category_id'),
				'brand_id'=>$this->input->post('brand_id'),
				'brand_model_id'=>$this->input->post('brand_model_id'),
				'product_image_name'=>$file_name
			);
			
			if($this->input->post('brand_id') == "0"){
				$data['brand_model_id'] = $this->input->post('model_id');
			}
			else{
				$data['brand_model_id'] = $this->input->post('brand_model_id');
			}
			
			$table = "product";
			$this->administration_model->update($table, $data, "product_id", $product_id);
			//$this->upload_gallery($product_id);
			redirect('administration/list_products/2/3');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new product
				-----------------------------------------------------------------------------------------
			*/
			$table = "product, category, brand_model, brand";
			$where = "brand_model.brand_id = brand.brand_id AND product.brand_model_id = brand_model.brand_model_id AND product.category_id = category.category_id AND product.product_id = ".$product_id;
			$items = "product.customer_id, brand_model.brand_model_name, brand.brand_name, brand_model.brand_id, product.category_id, product.product_year, product.brand_model_id, product.product_code, product.product_id, category.category_name, product.product_description, product.product_name, product.product_selling_price, product.product_buying_price, product.product_status, product.product_balance, product.product_image_name, product.product_date";
			$order = "product_name";
			$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "brand";
			$where = "brand_id > 0";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "brand_model";
			$where = "brand_model_id > 0";
			$items = "*";
			$order = "brand_model_name";
			$data['brand_models'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$items = "*";
			$table = "product_image";
			$where = "(product_id = ".$product_id.")";
			$order = "product_id"; 
			$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "category";
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "customer";
			$where = "customer_id > 0";
			$items = "*";
			$order = "customer_name";
			
			$data['customers'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("products/edit_product", $data);
			$this->load_foot();
		}
	}
	
	function delete_product($product_id)
	{
		$this->administration_model->delete("product", "product_id", $product_id);
		
		echo "true";
	}
	
	function deactivate_product($product_id)
	{
		$data = array(
			'product_status'=>0
		);
		
		$table = "product";
		$this->administration_model->update($table, $data, "product_id", $product_id);
		
		redirect('administration/list_products/2/3');
	}
	
	function activate_product($product_id)
	{
		$data = array(
			'product_status'=>1
		);
		
		$table = "product";
		$this->administration_model->update($table, $data, "product_id", $product_id);
		
		redirect('administration/list_products/2/3');
	}
	
	function view_product($product_id)
	{
  		$table = "product, category, brand_model, brand";
		$where = "product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_id = ".$product_id;
		$items = "brand_model.brand_model_name, brand.brand_name, product_year, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$items = "*";
		$table = "product_image";
        $where = "(product_id = ".$product_id.")";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("products/view_product", $data);
	}
	
	/********************************************************************************************
	*																							*
	*									SLIDESHOW FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function slideshow($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "slideshow";
		$where = "slideshow_id > 0";
		$items = "*";
		$order = "slideshow_id";
		
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("slideshow/list_slides", $data);
		$this->load_foot();
	}
	
	function add_slide($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path3;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image_slideshow($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			$data = array(
				'slideshow_image_name'=>$file_name
			);
			
			$table = "slideshow";
			$this->administration_model->insert($table, $data);
			redirect('administration/slideshow/4/5');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new category
				-----------------------------------------------------------------------------------------
			*/
		
			$table = "slideshow";
			$where = "slideshow_id > 0";
			$items = "*";
			$order = "slideshow_id";
			
			$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("slideshow/add_slide", $data);
			$this->load_foot();
		}
	}
	
	function delete_slideshow($slideshow_id)
	{
		$this->administration_model->delete("slideshow", "slideshow_id", $slideshow_id);
		
		echo "true";
	}
	
	function deactivate_slideshow($slideshow_id)
	{
		$data = array(
			'slideshow_status'=>0
		);
		
		$table = "slideshow";
		$this->administration_model->update($table, $data, "slideshow_id", $slideshow_id);
		
		redirect('administration/slideshow/4/5');
	}
	
	function activate_slideshow($slideshow_id)
	{
		$data = array(
			'slideshow_status'=>1
		);
		
		$table = "slideshow";
		$this->administration_model->update($table, $data, "slideshow_id", $slideshow_id);
		
		redirect('administration/slideshow/4/5');
	}
	
	/********************************************************************************************
	*																							*
	*									MODULES FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function modules($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "navigation";
		$where = "navigation.navigation_id > 0";
		$items = "*";
		$order = "navigation_name";
		
		$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("modules/list_modules", $data);
		$this->load_foot();
	}
	
	function add_module($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_url', 'Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('module_name', 'Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_name'=>$this->input->post("module_name"),
				'navigation_url'=>$this->input->post("module_url")
			);
			
			$table = "navigation";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_module/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/add_module");
			$this->load_foot();
		}
	}
	
	function edit_module($navigation_id)
	{	
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_url', 'Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('module_name', 'Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_name'=>$this->input->post("module_name"),
				'navigation_url'=>$this->input->post("module_url")
			);
			
			$table = "navigation";
			$this->administration_model->update($table, $data, "navigation_id", $navigation_id);
			redirect('administration/modules/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			$table = "navigation";
			$where = "navigation.navigation_id = ".$navigation_id;
			$items = "*";
			$order = "navigation_name";
			
			$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/edit_module", $data);
			$this->load_foot();
		}
	}
	
	function delete_module($navigation_id)
	{
		$this->administration_model->delete("sub_navigation", "navigation_id", $navigation_id);
		$this->administration_model->delete("navigation", "navigation_id", $navigation_id);
		
		echo "true";
	}
	
	function sub_modules($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "navigation, sub_navigation";
		$where = "navigation.navigation_id = sub_navigation.navigation_id";
		$items = "navigation.navigation_id, navigation.navigation_name, navigation.navigation_url, sub_navigation.sub_navigation_name, sub_navigation.sub_navigation_url, sub_navigation.sub_navigation_id";
		$order = "navigation_name, sub_navigation_name";
		
		$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("modules/list_sub_modules", $data);
		$this->load_foot();
	}
	
	function add_sub_module($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_id', 'Module', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('sub_module_url', 'Sub Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_module_name', 'Sub Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_id'=>$this->input->post("module_id"),
				'sub_navigation_name'=>$this->input->post("sub_module_name"),
				'sub_navigation_url'=>$this->input->post("sub_module_url")
			);
			
			$table = "sub_navigation";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_sub_module/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			$table = "navigation";
			$where = "navigation.navigation_id > 0";
			$items = "*";
			$order = "navigation_name";
			
			$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/add_sub_module", $data);
			$this->load_foot();
		}
	}
	
	function edit_sub_module($sub_navigation_id)
	{	
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_id', 'Module', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('sub_module_url', 'Sub Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_module_name', 'Sub Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_id'=>$this->input->post("module_id"),
				'sub_navigation_name'=>$this->input->post("sub_module_name"),
				'sub_navigation_url'=>$this->input->post("sub_module_url")
			);
			
			$table = "sub_navigation";//echo $this->input->post("module_id");
			$this->administration_model->update($table, $data, "sub_navigation_id", $sub_navigation_id);
			redirect('administration/sub_modules/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			$table = "navigation";
			$where = "navigation.navigation_id > 0";
			$items = "*";
			$order = "navigation_name";
			$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "navigation, sub_navigation";
			$where = "sub_navigation.sub_navigation_id = ".$sub_navigation_id." AND navigation.navigation_id = sub_navigation.navigation_id";
			$items = "navigation.navigation_id, navigation.navigation_name, navigation.navigation_url, sub_navigation.sub_navigation_name, sub_navigation.sub_navigation_url, sub_navigation.sub_navigation_id";
			$order = "navigation_name, sub_navigation_name";
			$data['sub_navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/edit_sub_module", $data);
			$this->load_foot();
		}
	}
	
	function delete_sub_module($sub_navigation_id)
	{
		$this->administration_model->delete("sub_navigation", "sub_navigation_id", $sub_navigation_id);
		
		echo "true";
	}
	
	/********************************************************************************************
	*																							*
	*									CONTACTS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function contacts($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('post', 'Postal Address', 'trim|xss_clean');
		$this->form_validation->set_rules('physical', 'Physical Address', 'trim|xss_clean');
		$this->form_validation->set_rules('facebook', 'Facebook Address', 'trim|xss_clean');
		$this->form_validation->set_rules('blog', 'Blog', 'trim|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path4;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post("logo");
			}
			$data = array(
				'email'=>$this->input->post("email"),
				'phone'=>$this->input->post("phone"),
				'post'=>$this->input->post("post"),
				'physical'=>$this->input->post("physical"),
				'site_name'=>$this->input->post("site_name"),
				'blog'=>$this->input->post("blog"),
				'logo'=>$file_name,
				'facebook'=>$this->input->post("facebook")
			);
			
			$table = "contacts";
			$this->administration_model->update($table, $data, "contacts_id", "1");
			redirect('administration/contacts/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "contacts";
			$where = "contacts_id = 1";
			$items = "*";
			$order = "contacts_id";
			
			$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("contacts/list_contacts", $data);
			$this->load_foot();
		}
	}
	
	/********************************************************************************************
	*																							*
	*									PAGES FUNCTIONS											*
	*																							*
	********************************************************************************************/
	
	function pages($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "page";
		$where = "page_id > 0";
		$items = "*";
		$order = "page_position, page_name";
		
		$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("pages/list_pages", $data);
		$this->load_foot();
	}
	
	function add_page($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_url', 'Page URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_position', 'Page Position', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'page_name'=>$this->input->post("page_name"),
				'page_position'=>$this->input->post("page_position"),
				'page_url'=>$this->input->post("page_url")
			);
			
			$table = "page";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_page/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$this->load_head();
			$this->load->view("pages/add_page");
			$this->load_foot();
		}
	}
	
	function edit_page($page_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_url', 'Page URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_position', 'Page Position', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'page_name'=>$this->input->post("page_name"),
				'page_position'=>$this->input->post("page_position"),
				'page_url'=>$this->input->post("page_url")
			);
			
			$table = "page";
			$this->administration_model->update($table, $data, "page_id", $page_id);
			redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "page";
			$where = "page_id = ".$page_id;
			$items = "*";
			$order = "page_name";
			
			$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("pages/edit_page", $data);
			$this->load_foot();
		}
	}
	
	function delete_page($page_id)
	{
		$this->administration_model->delete("page", "page_id", $page_id);
		
		echo "true";
	}
	
	function deactivate_page($page_id)
	{
		$data = array(
			'page_status'=>0
		);
		
		$table = "page";
		$this->administration_model->update($table, $data, "page_id", $page_id);
		
		redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
	}
	
	function activate_page($page_id)
	{
		$data = array(
			'page_status'=>1
		);
		
		$table = "page";
		$this->administration_model->update($table, $data, "page_id", $page_id);
		
		redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
	}
	
	function update_brand()
	{
		$table = 'product';
		$items = 'product_id, brand_model_id';
		$where = 'product_id > 0';
		$order = 'product_id';
		$products = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		foreach($products as $prod){
			$product_id = $prod->product_id;
			$model_id = $prod->brand_model_id;
			
			$table = 'brand_model';
			$items = 'brand_id';
			$where = 'brand_model_id = '.$model_id;
			$order = 'brand_id';
			$brands = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			if(count($brands) > 0)
			{
				foreach($brands as $b)
				{
					$brand_id = $b->brand_id;
				}
				$data = array(
					'brand_id'=> $brand_id
				);
				
				$table = "product";
				$where = '';
				$this->administration_model->update($table, $data, 'product_id', $product_id);
			}
		}
			
		//redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
	}
}