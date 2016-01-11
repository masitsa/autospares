<?php

class Administration_model extends CI_Model {
	
	/*
		-----------------------------------------------------------------------------------------
		Retrieve all data from a table in the database
		-----------------------------------------------------------------------------------------
	*/
	 function select($table)
    {
        $query = $this->db->get($table);
		return $query->result();
    }
	
	 function select_order($table, $order, $orient)
    {
        $this->db->select("*");
        $this->db->from($table);
        $this->db->order_by($order, $orient);
       
        $query = $this->db->get();
		return $query->result();
    }
	
	function select_pagination($limit, $start, $table, $where, $items, $order)
	{
		$this->db->limit($limit, $start);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "asc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	function select_pagination2($limit, $start, $table, $where, $items, $order)
	{
		$this->db->limit($limit, $start);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "desc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	/*
		-----------------------------------------------------------------------------------------
		Retrieve particular data from multiple tables in the database
		-----------------------------------------------------------------------------------------
	*/
	 function select_entries_where($table, $where, $items, $order)
    {
        $this->db->select($items);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, "asc");
       
        $query = $this->db->get();
       
        return $query->result();
    }
	 function select_entries_where2($table, $where, $items, $order)
    {
        $this->db->select($items);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, "desc");
       
        $query = $this->db->get();
       
        return $query->result();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Save data to the database
		-----------------------------------------------------------------------------------------
	*/
	 function insert($table, $items)
    {
        $this->db->insert($table, $items);
		
		return $this->db->insert_id();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Updates data in the database
		-----------------------------------------------------------------------------------------
	*/
	 function update($table, $items, $field, $key)
    {
		$this->db->where($field, $key);
        $this->db->update($table, $items);
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Deletes data in the database
		-----------------------------------------------------------------------------------------
	*/
	 function delete($table, $field, $key)
    {
		$this->db->where($field, $key);
        $this->db->delete($table);
    }  
    
	public function items_count($table, $where) {
        $this->db->where($where);
		$this->db->from($table);
        return $this->db->count_all_results();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Select a number of items from a particluar database table; inverse order
		-----------------------------------------------------------------------------------------
	*/
	function select_limit2($limit, $table, $where, $items, $order)
	{
		$this->db->limit($limit);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "desc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	function select_limit($limit, $table, $where, $items, $order)
	{
		$this->db->limit($limit);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "asc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	function select_latest_products()
	{
		$table = "product, category, brand_model, brand, location, customer";
		$items = "product.tiny_url, product.product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date, location.location_name, customer.customer_name, customer.customer_phone, customer.customer_email";
		$order = "product_date";
		$where = "product.customer_id = customer.customer_id AND location.location_id = product.location_id AND product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		$result = $this->select_limit2(4, $table, $where, $items, $order);
		return $result;
	}
	
	function add_customer()
	{		
		/*
			-----------------------------------------------------------------------------------------
			Check if customer exists
			-----------------------------------------------------------------------------------------
		*/
		$table = "customer";
		$where = "customer_email = '".$this->input->post('user_email')."'";
		$items = "customer_id";
		$order = "customer_id";
		
		$result = $this->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{
			$customer_id = $result[0]->customer_id;
		}
		else
		{
			$data = array(
				'customer_email'=>$this->input->post('user_email'),
				'customer_name'=>$this->input->post('seller_name'),
				'customer_phone'=>$this->input->post('user_phone')
			);
			
			$table = "customer";
			$customer_id = $this->insert($table, $data);
		}
		
		return $customer_id;
	}
	
	function get_category_name($category_id)
	{
		$table = "category";
		$items = "category_name";
		$order = "category_name";
		$where = "category_id = ".$category_id;
		$result = $this->select_entries_where($table, $where, $items, $order);
		return $result[0]->category_name;
	}
	
	function get_brand_name($brand_id)
	{
		$table = "brand";
		$items = "brand_name";
		$order = "brand_name";
		$where = "brand_id = ".$brand_id;
		$result = $this->select_entries_where($table, $where, $items, $order);
		return $result[0]->brand_name;
	}
	
	function get_brand_model_name($brand_model_id)
	{
		$table = "brand_model, brand";
		$items = "brand_model_name, brand.brand_name";
		$order = "brand_model_name";
		$where = "brand.brand_id = brand_model.brand_id AND brand_model_id = ".$brand_model_id;
		$result = $this->select_entries_where($table, $where, $items, $order);
		return $result[0]->brand_name.' '.$result[0]->brand_model_name;
	}
	
	function getTinyUrl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://tinyurl.com/api-create.php?url=".$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$tinyurl = curl_exec($ch);
		curl_close($ch);
		//$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);
		return $tinyurl;
	}
}