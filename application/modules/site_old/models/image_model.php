<?php

class Image_model extends CI_Model {
	
	function __construct() 
	{
        //$this->load->library('image_lib');
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
}