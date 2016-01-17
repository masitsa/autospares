<?php

class Products_model extends CI_Model 
{	
	/*
	*	Retrieve all products
	*
	*/
	public function all_products()
	{
		$this->db->where('product_status = 1');
		$query = $this->db->get('product');
		
		return $query;
	}
	
	/*
	*	Retrieve all products
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_products($table, $where, $per_page, $page, $limit = NULL, $order_by = 'product_date', $order_method = 'DESC')
	{
		$this->db->from($table);
		$this->db->select('product.*, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email, category.category_name, brand.brand_name, brand_model.brand_model_name');
		$this->db->where($where);
		$this->db->order_by($order_by, $order_method);
		
		if(isset($limit))
		{
			$query = $this->db->get('', $limit);
		}
		
		else
		{
			$query = $this->db->get('', $per_page, $page);
		}
		
		return $query;
	}
	
	/*
	*	Add a new product
	*	@param string $image_name
	*
	*/
	public function add_product($image_name, $thumb_name)
	{
		$code = $this->create_product_code($this->input->post('category_id'));
		
		$data = array(
				'product_name'=>ucwords(strtolower($this->input->post('product_name'))),
				'featured'=>$this->input->post('featured'),
				'sale_price'=>$this->input->post('product_sale_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_status'=>$this->input->post('product_status'),
				'product_description'=>$this->input->post('product_description'),
				'product_code'=>$code,
				'product_balance'=>$this->input->post('product_balance'),
				'brand_id'=>$this->input->post('brand_id'),
				'category_id'=>$this->input->post('category_id'),
				'created'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'product_thumb_name'=>$thumb_name,
				'product_image_name'=>$image_name
			);
			
		if($this->db->insert('product', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Add a new product
	*	@param string $image_name
	*
	*/
	public function add_product_site($file_name, $customer_id)
	{
		$parent = $this->input->post('product_category_id');
		$child = $this->input->post('product_category_child');
		$sub_child = $this->input->post('product_category_sub_child');
		$category_id = $parent;
		
		if($child > 0)
		{
			$category_id = $child;
		}
		if($sub_child > 0)
		{
			$category_id = $sub_child;
		}
		
		$code = $this->create_product_code($category_id);
			
		$data = array(
			'product_status'=>0,
			'customer_id'=>$customer_id,
			'product_code'=>$code,
			'location_id'=>$this->input->post('location_id'),
			'product_year'=>$this->input->post('product_year'),
			'brand_id'=>$this->input->post('product_brand_id'),
			'brand_model_id'=>$this->input->post('product_model_id'),
			'product_description'=>$this->input->post('product_description'),
			'product_selling_price'=>$this->input->post('product_selling_price'),
			'product_balance'=>1,
			'product_status'=>1,
			'category_id'=>$category_id,
			'product_image_name'=>$file_name
		);
		
		if($this->db->insert('product', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Update an existing product
	*	@param string $image_name
	*	@param int $product_id
	*
	*/
	public function update_product($file_name, $thumb_name, $product_id)
	{
		$data = array(
				'product_name'=>ucwords(strtolower($this->input->post('product_name'))),
				'featured'=>$this->input->post('featured'),
				'sale_price'=>$this->input->post('product_sale_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_status'=>$this->input->post('product_status'),
				'product_description'=>$this->input->post('product_description'),
				'product_balance'=>$this->input->post('product_balance'),
				'brand_id'=>$this->input->post('brand_id'),
				'category_id'=>$this->input->post('category_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'product_image_name'=>$file_name,
				'product_thumb_name'=>$thumb_name
			);
			
		$this->db->where('product_id', $product_id);
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single product's details
	*	@param int $product_id
	*
	*/
	public function get_product($product_id)
	{
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product.tiny_url, product.product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND product.product_id = ".$product_id;
		
		//retrieve all users
		$this->db->from($table);
		$this->db->select($items);
		$this->db->where($where);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Delete an existing product
	*	@param int $product_id
	*
	*/
	public function delete_product($product_id)
	{
		if($this->db->delete('product', array('product_id' => $product_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Activate a deactivated product
	*	@param int $product_id
	*
	*/
	public function activate_product($product_id)
	{
		$data = array(
				'product_status' => 1
			);
		$this->db->where('product_id', $product_id);
		
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Deactivate an activated product
	*	@param int $product_id
	*
	*/
	public function deactivate_product($product_id)
	{
		$data = array(
				'product_status' => 0
			);
		$this->db->where('product_id', $product_id);
		
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function create_product_code($category_id)
	{
		//get category_details
		$query = $this->categories_model->get_category($category_id);
		
		if($query->num_rows() > 0)
		{
			$result = $query->result();
			$category_preffix =  $result[0]->category_preffix;
			
			//select product code
			$this->db->from('product');
			$this->db->select('MAX(product_code) AS number');
			$this->db->where("product_code LIKE '".$category_preffix."%'");
			$query = $this->db->get();
			
			if($query->num_rows() > 0)
			{
				$result = $query->result();
				$number =  $result[0]->number;
				$number++;//go to the next number
				
				if($number == 1){
					$number = $category_preffix."001";
				}
			}
			else{//start generating receipt numbers
				$number = $category_preffix."001";
			}
		}
		
		else
		{
			$number = '001';
		}
		
		return $number;
	}
	
	/*
	*	Save a product's gallery image
	*	@param int $product_id
	*	@param char $image
	*	@param char $thumb
	*
	*/
	public function save_gallery_file($product_id, $image, $thumb)
	{
		//save the image data to the database
		$data = array(
			'product_id' => $product_id,
			'product_image_name' => $image,
			'product_image_thumb' => $thumb
		);
		
		if($this->db->insert('product_image', $data))
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	get a single product's gallery images
	*	@param int $product_id
	*
	*/
	public function get_gallery_images($product_id)
	{
		//retrieve all users
		$this->db->from('product_image');
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	delete a product's gallery images
	*	@param int $product_id
	*
	*/
	public function delete_gallery_images($product_id)
	{
		if($this->db->delete('product_image', array('product_id' => $product_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function delete_gallery_image($product_image_id)
	{
		if($this->db->delete('product_image', array('product_image_id' => $product_image_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Get all the feature valuess of a feature
	 * Called when adding a new product
	 *
	 * @param int category_feature_id
	 *
	 * @return object
	 *
	 */
	function fetch_new_category_features($category_feature_id)
	{
		if(isset($_SESSION['name'.$category_feature_id]))
		{
			$total_features = count($_SESSION['name'.$category_feature_id]);
			
			if($total_features > 0)
			{
				$features = '';
				//var_dump($_SESSION['name'.$category_feature_id]);
				for($r = 0; $r < $total_features; $r++)
				{
					if(isset($_SESSION['name'.$category_feature_id][$r]))
					{
						$name = mysql_real_escape_string($_SESSION['name'.$category_feature_id][$r]);
						$quantity = $_SESSION['quantity'.$category_feature_id][$r];
						$price = $_SESSION['price'.$category_feature_id][$r];
						$image = '<img src="'. base_url().'assets/images/features/'.$_SESSION['thumb'.$category_feature_id][$r].'" alt="'.$name.'"/>';
						
						$features .= '
							<tr>
								<td>
									<a href="'.$r.'" class="delete_feature" id="'.$category_feature_id.'" onclick="return confirm(\'Do you want to delete '.$name.'?\');"><i class="icon-trash butn butn-danger"></i></a>
								</td>
								<td>'.$name.'</td>
								<td>'.$quantity.'</td>
								<td>'.$price.'</td>
								<td>'.$image.'</td>
							</tr>
						';
					}
				}
				
				return $features;
			}
		
			else{
				return NULL;
			}
		}
		
		else{
			return NULL;
		}
	}
	
	function add_new_features($category_feature_id, $feature_name, $feature_quantity, $feature_price, $image_name = 'None', $thumb_name = 'None')
	{
		if(isset($_SESSION['name'.$category_feature_id]))
		{
			$total_features = count($_SESSION['name'.$category_feature_id]);
			
			if($total_features > 0)
			{
				$r = $total_features;
			}
			
			else
			{
				$r = 0;
			}
				
		}
		
		else{
			$r = 0;
		}
		
		$_SESSION['name'.$category_feature_id][$r] = $feature_name;
		$_SESSION['quantity'.$category_feature_id][$r] = $feature_quantity;
		$_SESSION['price'.$category_feature_id][$r] = $feature_price;
		$_SESSION['image'.$category_feature_id][$r] = $image_name;
		$_SESSION['thumb'.$category_feature_id][$r] = $thumb_name;
		
		$feature_values = $this->fetch_new_category_features($category_feature_id);
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
		
		return $options;
	}
	
	/**
	 * Get all the feature valuess of a feature
	 * Called when adding a new product
	 *
	 * @param int category_feature_id
	 *
	 * @return object
	 *
	 */
	function save_features($product_id)
	{
		$features = $this->features_model->all_features();
		
		if($features->num_rows() > 0)
		{
			$feature = $features->result();
			
			foreach($feature as $feat)
			{
				$feature_id = $feat->feature_id;
				
				if(isset($_SESSION['name'.$feature_id]))
				{
					$total_features = count($_SESSION['name'.$feature_id]);
					
					if($total_features > 0)
					{	
						for($r = 0; $r < $total_features; $r++)
						{
							if(isset($_SESSION['name'.$feature_id][$r]))
							{
								$name = $_SESSION['name'.$feature_id][$r];
								$quantity = $_SESSION['quantity'.$feature_id][$r];
								$price = $_SESSION['price'.$feature_id][$r];
								$image = $_SESSION['image'.$feature_id][$r];
								$thumb = $_SESSION['thumb'.$feature_id][$r];
								
								$data = array(
										'feature_id'=>$feature_id,
										'product_id'=>$product_id,
										'feature_value'=>$name,
										'quantity'=>$quantity,
										'price'=>$price,
										'image'=>$image,
										'thumb'=>$thumb
									);
									
								$this->db->insert('product_feature', $data);
							}
						}
					}
				}
			}
		}
		session_unset();
		return TRUE;
	}
	
	/*
	*	get a single product's features
	*	@param int $product_id
	*
	*/
	public function get_features($product_id)
	{
		//retrieve all users
		$this->db->from('product_feature');
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	delete a product's features
	*	@param int $product_id
	*
	*/
	public function delete_features($product_id)
	{
		
		if($this->db->delete('product_feature', array('product_id' => $product_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	get a single product's features
	*	@param int $feature_id
	*
	*/
	public function get_product_feature($product_feature_id)
	{
		//retrieve all users
		$this->db->from('product_feature');
		$this->db->select('*');
		$this->db->where('product_feature_id = '.$product_feature_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	delete a product feature
	*	@param int $product_feature_id
	*
	*/
	public function delete_product_feature($product_feature_id)
	{
		
		if($this->db->delete('product_feature', array('product_feature_id' => $product_feature_id)))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Retrieve latest products
	*
	*/
	public function get_latest_products()
	{
		$this->db->select('product.*, category.category_name, brand.brand_name, brand_model.brand_model_name, location.location_name, customer.customer_name, customer.customer_email, customer.customer_phone')->from('product, location, customer, brand, brand_model, category')->where("product.location_id = location.location_id AND product.location_id = location.location_id AND product.customer_id = customer.customer_id AND product.product_status = 1 AND product.category_id = category.category_id AND product.brand_id = brand.brand_id AND product.brand_model_id = brand_model.brand_model_id")->order_by("product.product_date", 'DESC');
		$query = $this->db->get('',12);
		
		return $query;
	}
	
	/*
	*	Retrieve featured products
	*
	*/
	public function get_featured_products()
	{
		$this->db->select('*')->from('product')->where("product_status = 1 AND featured = 1")->order_by("created", 'DESC');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve max product price
	*
	*/
	public function get_max_product_price()
	{
		$this->db->select('MAX(product_selling_price) AS price')->from('product')->where("product_status = 1");
		$query = $this->db->get();
		$result = $query->row();
		
		return $result->price;
	}
	
	/*
	*	Retrieve min product price
	*
	*/
	public function get_min_product_price()
	{
		$this->db->select('MIN(product_selling_price) AS price')->from('product')->where("product_status = 1");
		$query = $this->db->get();
		$result = $query->row();
		
		return $result->price;
	}
	
	/*
	*	get a similar products
	*	@param int $product_id
	*
	*/
	public function get_similar_products($product_id)
	{
		$table2 = "product, category, brand_model, brand, location, customer";
		$where2 = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		
		//retrieve all users
		$this->db->from($table2);
		$this->db->select('*');
		$this->db->where($where2.' AND ((product.category_id = (SELECT category_id FROM product WHERE product_id = '.$product_id.')) OR (product.brand_id = (SELECT brand_id FROM product WHERE product_id = '.$product_id.')) OR (product.brand_model_id = (SELECT brand_model_id FROM product WHERE product_id = '.$product_id.'))) AND (product_id <> '.$product_id.')');
		$query = $this->db->get('', 10);
		
		return $query;
	}
	
	public function update_clicks($product_id)
	{
		//get clicks);
		$this->db->select('clicks');
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product');
		
		$row = $query->row();
		$clicks = $row->clicks;
		
		//increment clicks
		$clicks++;
		
		//save clicks
		$data = array(
				'clicks'=>$clicks
			);
			
		$this->db->where('product_id', $product_id);
		if($this->db->update('product', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	/*
	*	Retrieve all product reviews
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function get_all_product_review($table, $where, $per_page, $page)
	{
		//retrieve all orders
		$this->db->from($table);
		$this->db->select('product_review.*, product.product_code, category.category_name, brand.brand_name, brand_model.brand_model_name');
		$this->db->where($where);
		$this->db->order_by('product_review.last_modified','desc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function total_products()
	{
		$this->db->from('product');
		$this->db->where('product_status = 1');
		return $this->db->count_all_results();
	}
	/*
	*	Retrieve all products images
	*
	*/
	public function get_product_images()
	{
		$this->db->order_by('product_id');
		$query = $this->db->get('product_image');
		
		return $query;
	}
	
	public function get_product_id($product_code)
	{
		//retrieve all users
		$this->db->from('product');
		$this->db->select('product_id');
		$this->db->where('product_code', $product_code);
		$query = $this->db->get();
		$post_id = FALSE;
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$product_id = $row->product_id;
		}
		
		return $product_id;
	}
	/*
	*	Retrieve all products images
	*
	*/
	public function get_products_images($product_id)
	{
		$this->db->where('product_id', $product_id);
		$query = $this->db->get('product_image');
		
		return $query;
	}
	
	public function decode_web_name($web_name)
	{
		$page = explode("-", $web_name);
		$total = count($page);
		$last = $total - 1;
		
		$product_code = $page[0];
		
		$prod_name = str_replace($product_code."-", "", $web_name);
		$prod_name = str_replace("-", " ", $prod_name);
		
		$dobi_data = array(
			'prod_name' 		=> $prod_name,
			'product_code'		=> $product_code
		);
		
		return $dobi_data;
	}
	
	function getTinyUrl($product_id) 
	{
		$product_details = $this->products_model->get_product($product_id);
		$cat = $product_details->row();
		//the product details
		$product_code = $cat->product_code;
		$category_name = $cat->category_name;
		$model = $cat->brand_model_name;
		$brand = $cat->brand_name;
		$prod_name = $brand.' '.$model.' '.$category_name;
		$product_web_name = $this->site_model->create_web_name($product_code.' '.$prod_name);
		
		$url = site_url().'spareparts/'.$product_web_name;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://tinyurl.com/api-create.php?url=".$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tinyurl = curl_exec($ch);
		curl_close($ch);
		//$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
		return $tinyurl;
	}
	
	public function upload_product_image($product_path, $product_location, $field_name)
	{
		//upload product's gallery images
		$resize['width'] = 600;
		$resize['height'] = 600;
		
		if(isset($_FILES[$field_name]['tmp_name']))
		{
			if(file_exists($_FILES[$field_name]['tmp_name']) || is_uploaded_file($_FILES[$field_name]['tmp_name']))
			{
				$file_name = $this->session->userdata('product_file_name');
				if(!empty($file_name))
				{
					//delete any other uploaded image
					$this->file_model->delete_file($product_path."\\".$file_name, $product_location);
					
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($product_path."\\thumbnail_".$file_name, $product_location);
				}
				//Upload image
				$response = $this->file_model->upload_file($product_path, $field_name, $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
					
					$image_upload_data = $response['upload_data'];
					$upload_width = $image_upload_data['image_width'];
					$upload_height = $image_upload_data['image_height'];
					
					//Set sessions for the image details
					$this->session->set_userdata($field_name, $file_name);
					$this->session->set_userdata($field_name.'_thumb', $thumb_name);
				
					return TRUE;
				}
			
				else
				{
					$this->session->set_userdata('error', $response['error']);
					
					return FALSE;
				}
			}
		}
		
		else
		{
			$this->session->set_userdata('error', '');
			return FALSE;
		}
	}
	
	public function upload_product_gallery1($gallery_path, $gallery_location)
	{
		//upload product's gallery images
		$resize['width'] = 600;
		$resize['height'] = 600;
		
		if(isset($_FILES['gallery1']['tmp_name']))
		{
			if(file_exists($_FILES['gallery1']['tmp_name']) || is_uploaded_file($_FILES['gallery1']['tmp_name']))
			{
				$file_name = $this->session->userdata('product_image1_name');
				if(!empty($file_name))
				{
					//delete any other uploaded image
					$this->file_model->delete_file($gallery_path."\\".$file_name, $gallery_location);
					
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($gallery_path."\\thumbnail_".$file_name, $gallery_location);
				}
				//Upload image
				$response = $this->file_model->upload_file($gallery_path, 'gallery1', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
					
					//crop file
					$response_crop = $this->file_model->crop_file($gallery_path."\\".$file_name, $resize['width'], $resize['height']);
					
					if(!$response_crop)
					{
						$this->session->set_userdata('error', $response_crop);
					
						return FALSE;
					}
					
					else
					{	
						//Set sessions for the image details
						$this->session->set_userdata('product_image1_name', $file_name);
						$this->session->set_userdata('product_image1_thumb', $thumb_name);
					
						return TRUE;
					}
				}
			
				else
				{
					$this->session->set_userdata('error', $response['error']);
					
					return FALSE;
				}
			}
		}
		
		else
		{
			$this->session->set_userdata('error', '');
			return FALSE;
		}
	}
	
	public function upload_product_gallery2($gallery_path, $gallery_location)
	{
		//upload product's gallery images
		$resize['width'] = 600;
		$resize['height'] = 600;
		
		if(isset($_FILES['gallery2']['tmp_name']))
		{
			if(file_exists($_FILES['gallery2']['tmp_name']) || is_uploaded_file($_FILES['gallery2']['tmp_name']))
			{
				$file_name = $this->session->userdata('product_image2_name');
				if(!empty($file_name))
				{
					//delete any other uploaded image
					$this->file_model->delete_file($gallery_path."\\".$file_name, $gallery_location);
					
					//delete any other uploaded thumbnail
					$this->file_model->delete_file($gallery_path."\\thumbnail_".$file_name, $gallery_location);
				}
				//Upload image
				$response = $this->file_model->upload_file($gallery_path, 'gallery2', $resize);
				if($response['check'])
				{
					$file_name = $response['file_name'];
					$thumb_name = $response['thumb_name'];
					
					//crop file
					$response_crop = $this->file_model->crop_file($gallery_path."\\".$file_name, $resize['width'], $resize['height']);
					
					if(!$response_crop)
					{
						$this->session->set_userdata('error', $response_crop);
					
						return FALSE;
					}
					
					else
					{	
						//Set sessions for the image details
						$this->session->set_userdata('product_image2_name', $file_name);
						$this->session->set_userdata('product_image2_thumb', $thumb_name);
					
						return TRUE;
					}
				}
			
				else
				{
					$this->session->set_userdata('error', $response['error']);
					
					return FALSE;
				}
			}
		}
		
		else
		{
			$this->session->set_userdata('error', '');
			return FALSE;
		}
	}
	public function more_info_request($product_id)
	{
		$this->load->model('site/email_model');
		$this->load->library('Mandrill', $this->config->item('mandrill_key'));
		$this->load->model('site/sms_model');

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$preferred_contact = $this->input->post('preferred_contact');

		//retrieve all users
		$this->db->from('product_request');
		$this->db->select('*');
		$this->db->where('name =  "'.$name.'" AND product_id = '.$product_id);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return FALSE;
		}
		else
		{
			// get the product name 
			$product_name = $this->get_product_info($product_id);
			$data = array(
				'name'=>ucwords(strtolower($this->input->post('name'))),
				'email'=>$this->input->post('email'),
				'phone'=>$this->input->post('phone'),
				'product_name'=>$product_name,
				'product_id'=>$this->input->post('product_id'),
				'preferred_contact'=>$this->input->post('preferred_contact'),
				'created'=>date('Y-m-d')
			);			
			if($this->db->insert('product_request', $data))
			{
				$product_details = $this->products_model->get_product($product_id);
				$cat = $product_details->row();

				$product_code = $cat->product_code;
				$product_year = $cat->product_year;
				$product_id = $cat->product_id;
				$product_description = $cat->product_description;
				$product_balance = $cat->product_balance;
				$tiny_url = $cat->tiny_url;
				$category_name = $cat->category_name;
				$product_date = date('jS M Y',strtotime($cat->product_date));
				$product_year = $cat->product_year;
				$model = $cat->brand_model_name;
				$brand = $cat->brand_name;
				$customer_name = $cat->customer_name;
				$customer_phone = $cat->customer_phone;
				$customer_email = $cat->customer_email;

				$message = 'I am '.$this->input->post('name').', Phone: '.$this->input->post('phone').', please give me more details on '.$tiny_url.' code: '.$product_code.'';

				$this->sms_model->send_sms($customer_phone,$message);

				$subject = "Autospares Product Info ";
				$message = ' Name :'.$this->input->post('name').' <br>
							 Email : '.$this->input->post('email').' <br>
							 Phone : '.$this->input->post('phone').' <br>
							 Product Name : '.$product_name.' <br>
						';
				$sender_email = $this->input->post('email');
				$shopping = "";
				$from = $this->input->post('name');
				
				$button = '';
				$button = '';
			 $this->email_model->send_mandrill_mail('info@autospares.co.ke', "Hi Admin", $subject, $message, $sender_email, $shopping, $from, $button);
		
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
	}
	public function get_product_info($product_id)
	{
		//retrieve all users
		$this->db->from('product');
		$this->db->select('*');
		$this->db->where('product_id = '.$product_id);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			foreach ($query->result() as $key) {
				# code...
				$product_description = $key->product_description;
				$product_code = $key->product_code;

				$product_name = $product_code." (".$product_description.")";
			}
			return $product_name;
		}
		else
		{
			$product_name = "";
			return $product_name;			
		}

	}

	public function get_product_details($product_id)
	{
		$this->db->where('product_id = '.$product_id);
		$query = $this->db->get('product');
		
		return $query;
	}
	
}
?>