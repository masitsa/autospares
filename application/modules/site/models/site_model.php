<?php

class Site_model extends CI_Model 
{
	public function display_page_title()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$name = $this->site_model->decode_web_name($page[$last]);
		
		if(is_numeric($name))
		{
			$last = $last - 1;
			$name = $this->site_model->decode_web_name($page[$last]);
		}
		
		$page_url = ucwords(strtolower($name));
		
		return $page_url;
	}
	
	public function get_crumbs()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		
		$crumb[0]['name'] = ucwords(strtolower($page[0]));
		$crumb[0]['link'] = $page[0];
		
		if($total > 1)
		{
			$sub_page = explode("-",$page[1]);
			$total_sub = count($sub_page);
			$page_name = '';
			
			for($r = 0; $r < $total_sub; $r++)
			{
				$page_name .= ' '.$sub_page[$r];
			}
			$crumb[1]['name'] = ucwords(strtolower($page_name));
			
			if($page[1] == 'category')
			{
				$category_id = $page[2];
				$category_details = $this->categories_model->get_category($category_id);
				
				if($category_details->num_rows() > 0)
				{
					$category = $category_details->row();
					$category_name = $category->category_name;
				}
				
				else
				{
					$category_name = 'No Category';
				}
				
				$crumb[1]['link'] = 'products/all-products/';
				$crumb[2]['name'] = ucwords(strtolower($category_name));
				$crumb[2]['link'] = 'products/category/'.$category_id;
			}
			
			else if($page[1] == 'brand')
			{
				$brand_id = $page[2];
				$brand_details = $this->brands_model->get_brand($brand_id);
				
				if($brand_details->num_rows() > 0)
				{
					$brand = $brand_details->row();
					$brand_name = $brand->brand_name;
				}
				
				else
				{
					$brand_name = 'No Brand';
				}
				
				$crumb[1]['link'] = 'products/all-products/';
				$crumb[2]['name'] = ucwords(strtolower($brand_name));
				$crumb[2]['link'] = 'products/brand/'.$brand_id;
			}
			
			else if($page[1] == 'view-product')
			{
				$product_id = $page[2];
				$product_details = $this->products_model->get_product($product_id);
				
				if($product_details->num_rows() > 0)
				{
					$product = $product_details->row();
					$product_name = $product->product_name;
				}
				
				else
				{
					$product_name = 'No Product';
				}
				
				$crumb[1]['link'] = 'products/all-products/';
				$crumb[2]['name'] = ucwords(strtolower($product_name));
				$crumb[2]['link'] = 'products/view-product/'.$product_id;
			}
			
			else
			{
				$crumb[1]['link'] = '#';
			}
		}
		
		return $crumb;
	}
	
	function generate_price_range()
	{
		$max_price = $this->products_model->get_max_product_price();
		//$min_price = $this->products_model->get_min_product_price();
		
		$interval = $max_price/5;
		
		$range = '';
		$start = 0;
		$end = 0;
		
		for($r = 0; $r < 5; $r++)
		{
			$end = $start + $interval;
			$value = 'KES '.number_format(($start+1), 0, '.', ',').' - KES '.number_format($end, 0, '.', ',');
			$range .= '
			<label class="radio-fancy">
				<input type="radio" name="agree" value="'.$start.'-'.$end.'">
				<span class="light-blue round-corners"><i class="dark-blue round-corners"></i></span>
				<b>'.$value.'</b>
			</label>';
			
			$start = $end;
		}
		
		return $range;
	}
	
	public function get_navigation()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		
		$name = strtolower($page[0]);
		
		$home = '';
		$about = '';
		$shop = '';
		$blog = '';
		$contact = '';
		$spareparts = '';
		$sell = '';
		
		if($name == 'home')
		{
			$home = 'active';
		}
		
		if($name == 'about')
		{
			$about = 'active';
		}
		
		if($name == 'spareparts')
		{
			$spareparts = 'active';
		}
		
		if($name == 'blog')
		{
			$blog = 'active';
		}
		
		if($name == 'contact')
		{
			$contact = 'active';
		}
		
		if($name == 'sell')
		{
			$sell = 'active';
		}
		
		//variables
		$brands_path = realpath(APPPATH . '../assets/brand/images');
		$categories_path = realpath(APPPATH . '../assets/categories/images');
		
		//image locations
		$brands_location = base_url().'assets/brand/images/';
		$categories_location = base_url().'assets/categories/images/';
		
		//category parents
		$category_parents = $this->categories_model->all_parent_categories();
		$parents = '';
		
		if($category_parents->num_rows() > 0)
		{
			foreach($category_parents->result() as $res)
			{
				$category_id = $res->category_id;
				$category_name = $res->category_name;
				$category_image_name = $res->category_image_name;
				$image = $this->site_model->image_display($categories_path, $categories_location, $category_image_name);
				$category_web_name = $this->site_model->create_web_name($category_name);
				$parents .= '<li class="col-md-4"> <a href="'.site_url().'spareparts/category/'.$category_web_name.'" title="'.$category_name.'" onClick="limit_sub_categories('.$category_id.')"><img src="'.$image.'" alt="'.$category_name.'" class="img-responsice"> <span>'.$category_name.'</span></a></li>';
			}
		}
		
		else
		{
			$parents = '<li>No categories :-(</li>';
		}
		
		//brands
		$active_brands = $this->brands_model->all_active_brands(8);
		$brands = '';
		
		if($active_brands->num_rows() > 0)
		{
			foreach($active_brands->result() as $res)
			{
				$brand_name = $res->brand_name;
				$brand_image_name = $res->brand_image_name;
				$image = $this->site_model->image_display($brands_path, $brands_location, $brand_image_name);
				$brand_web_name = $this->site_model->create_web_name($brand_name);
				$brands .= '<li class="item col-md-3"> <a href="'.site_url().'spareparts/brand/__/'.$brand_web_name.'" title="'.$brand_name.'"><img src="'.$image.'" alt="'.$brand_name.'" class="img-responsice"><br/><div class="brand_name">'.$brand_name.'</div></a></li>';
			}
		}
		
		else
		{
			$brands = '<li>No categories :-(</li>';
		}
		
		//blog categories
		$active_blog_categories = $this->blog_model->get_all_active_categories();
		$blog_categories = '';
		
		if($active_blog_categories->num_rows() > 0)
		{
			foreach($active_blog_categories->result() as $res)
			{
				$blog_category_name = $res->blog_category_name;
				$blog_category_web_name = $this->site_model->create_web_name($blog_category_name);
				$blog_categories .= '<li> <a href="'.site_url().'blog/category/'.$blog_category_web_name.'" title="'.$blog_category_name.'">'.$blog_category_name.'</a></li>';
			}
		}
		
		else
		{
			$blog_categories = '<li>No categories :-(</li>';
		}
		
		$navigation = 
		'
			<li class="'.$home.'"><a href="'.site_url().'home">Home</a></li>
			<li class="megamenu '.$spareparts.'"><a href="'.site_url().'spareparts">Spareparts</a>
				<ul class="dropdown">
					<li>
						<div class="megamenu-container container">
							<div class="row">
								<div class="mm-col col-md-2">
									<ul class="sub-menu">
										<li><a href="'.site_url().'spareparts">Latest spares</a></li>
										<li><a href="'.site_url().'spareparts/featured-sellers">Featured sellers</a></li>
										<li><a href="'.site_url().'spareparts/most-popular">Most popular spares</a></li>
									</ul>
								</div>
								<div class="mm-col col-md-5">
									<span class="megamenu-sub-title">Browse by category</span>
									<ul class="body-type-widget">
										'.$parents.'
									</ul>
									<a href="'.site_url().'spareparts" class="basic-link">view all</a>
								</div>
								<div class="mm-col col-md-5">
									<span class="megamenu-sub-title">Browse by make</span>
									<ul class="make-widget">
										'.$brands.'
									</ul>
									<a href="'.site_url().'spareparts" class="basic-link">view all</a>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</li>
			<li class="'.$sell.'"><a href="'.site_url().'sell">Sell</a></li>
			<li class="'.$blog.'"><a href="'.site_url().'blog">Blog</a>
				<ul class="dropdown">
					'.$blog_categories.'
				</ul>
			</li>
			<li class="'.$about.'"><a href="'.site_url().'about">About</a></li>
			<li class="'.$contact.'"><a href="'.site_url().'contact">Contact</a></li>
			
		';
		
		return $navigation;
	}
	
	public function create_web_name($field_name)
	{
		$web_name = str_replace(" ", "-", $field_name);
		
		return $web_name;
	}
	
	public function decode_web_name($web_name)
	{
		$field_name = str_replace("-", " ", $web_name);
		
		return $field_name;
	}
	
	public function image_display($base_path, $location, $image_name = NULL)
	{
		$default_image = 'http://placehold.it/300x300&text=Autospares';
		$file_path = $base_path.'/'.$image_name;
		//echo $file_path.'<br/>';
		
		//Check if image was passed
		if($image_name != NULL)
		{
			if(!empty($image_name))
			{
				if((file_exists($file_path)) && ($file_path != $base_path.'\\'))
				{
					return $location.$image_name;
				}
				
				else
				{
					return $default_image;
				}
			}
			
			else
			{
				return $default_image;
			}
		}
		
		else
		{
			return $default_image;
		}
	}
	
	public function get_contacts()
	{
  		$table = "contacts";
		
		$query = $this->db->get($table);
		$contacts = array();
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$contacts['email'] = $row->email;
			$contacts['phone'] = $row->phone;
			$contacts['facebook'] = $row->facebook;
			$contacts['twitter'] = $row->twitter;
			$contacts['linkedin'] = $row->pintrest;
			$contacts['company_name'] = $row->company_name;
			$contacts['logo'] = $row->logo;
			$contacts['address'] = $row->address;
			$contacts['city'] = $row->city;
			$contacts['post_code'] = $row->post_code;
			$contacts['building'] = $row->building;
			$contacts['floor'] = $row->floor;
			$contacts['location'] = $row->location;
			$contacts['working_weekend'] = $row->working_weekend;
			$contacts['working_weekday'] = $row->working_weekday;
			$contacts['mission'] = $row->mission;
			$contacts['vision'] = $row->vision;
			$contacts['motto'] = $row->motto;
			$contacts['about'] = $row->about;
			$contacts['objectives'] = $row->objectives;
			$contacts['core_values'] = $row->core_values;
		}
		return $contacts;
	}
	
	public function get_breadcrumbs()
	{
		$page = explode("/",uri_string());
		$total = count($page);
		$last = $total - 1;
		$crumbs = '<li><a href="'.site_url().'home">Home </a></li>';
		$name = $this->decode_web_name($page[$last]);
		if(is_numeric($name))
		{
			$total = $total - 1;
		}
		
		for($r = 0; $r < $total; $r++)
		{
			$name = $this->decode_web_name($page[$r]);
			if($r == $last)
			{
				$crumbs .= '<li class="active">'.strtoupper($name).'</li>';
			}
			else
			{
				if($total == 3)
				{
					if($r == 1)
					{
						$crumbs .= '<li><a href="'.site_url().$page[$r-1].'/'.strtolower($name).'">'.strtoupper($name).'</a></li>';
					}
					else
					{
						$crumbs .= '<li><a href="'.site_url().strtolower($name).'">'.strtoupper($name).'</a></li>';
					}
				}
				else
				{
					$crumbs .= '<li><a href="'.site_url().strtolower($name).'">'.strtoupper($name).'</a></li>';
				}
			}
		}
		
		return $crumbs;
	}
}

?>