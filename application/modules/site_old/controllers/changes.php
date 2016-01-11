<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
	This module loads the head, header, footer &/or Social media sections.
*/
class Changes extends MX_Controller {
	
	function __construct() 
	{	
		/*
			-----------------------------------------------------------------------------------------
			Load the requred model
			-----------------------------------------------------------------------------------------
		*/
		$this->load->model('administration/administration_model');
  	}
	
	function sort_brands()
	{
		$table = "cars";
		$items = "DISTINCT(make)";
		$where = "cars_id > 0";
		$order = "make";
		
		$cars = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		foreach($cars as $merch){
			
			$make = $merch->make;
			$make2 = ucwords( strtolower($make) );
			$items = array(
						'brand_name' => $make2
					);
			
			$brand_id = $this->administration_model->insert("brand", $items);
		
			$items2 = array(
						'brand_id' => $brand_id
					);
					
			$this->administration_model->update("cars", $items2, "make", $make);
		}
	}
	
	function sort_brand_models()
	{
		$table = "cars";
		$items = "*";
		$where = "brand_id > 20";
		$order = "model";
		
		$cars = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		foreach($cars as $merch){
			
			$model = $merch->model;
			$engine_code = $merch->engine_code;
			$transmission_code = $merch->transmission_code;
			$transmission_type = $merch->transmission_type;
			$gears_no = $merch->gears_no;
			$drive_system_code = $merch->drive_system_code;
			$drive_system = $merch->drive_system;
			$brand_id = $merch->brand_id;
		
			$items3 = array(
						'brand_model_name' => $model,
						'brand_id' => $brand_id,
						'engine_code' => $engine_code,
						'transmission_code' => $transmission_code,
						'transmission_type' => $transmission_type,
						'gears_no' => $gears_no,
						'drive_system_code' => $drive_system_code,
						'drive_system' => $drive_system,
					);
			
			$brand_model_id = $this->administration_model->insert("brand_model", $items3);
			
		}
	}
	
	function sort_cars_new()
	{
		$table = "cars_new";
		$items = "*";
		$where = "brand_id > 0";
		$order = "brand_id, cars_new_name";
		
		$cars = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		foreach($cars as $merch){
			
			$brand_id = $merch->brand_id;
			$cars_new_name = $merch->cars_new_name;
			//$make2 = ucwords( strtolower($make) );
			$items = array(
						'brand_id' => $brand_id,
						'brand_model_name' => $cars_new_name
					);
			
			$brand_id = $this->administration_model->insert("brand_model", $items);
			
		}
	}
	
	function create_tiny_url()
	{
		$table = "product";
		$items = "product_id";
		$where = "product_id > 0";
		$order = "product_id";
		
		$cars = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		foreach($cars as $merch){
			
			$product_id = $merch->product_id;
			$tiny_url = $this->administration_model->getTinyUrl(site_url()."view-autopart/".$product_id);
			
			$items = array(
						'tiny_url' => $tiny_url
					);
			$table = "product";
			$this->administration_model->update($table, $items, "product_id", $product_id);
		}
	}
}