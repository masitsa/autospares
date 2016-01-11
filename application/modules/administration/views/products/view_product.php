<?php
if(count($product) > 0){
	
	foreach($product as $cat){
		
		$product_code = $cat->product_code;
		$product_id = $cat->product_id;
		$product_description = $cat->product_description;
		$product_name = $cat->product_name;
		$product_selling_price = $cat->product_selling_price;
		$product_buying_price = $cat->product_buying_price;
		$product_balance = $cat->product_balance;
		$product_status = $cat->product_status;
		$product_image_name = $cat->product_image_name;
		$product_date = date('jS M Y H:i a',strtotime($cat->product_date));
		$product_year = $cat->product_year;
		$category_name = $cat->category_name;
		$brand_model_name = $cat->brand_model_name;
		$brand_name = $cat->brand_name;
		
		if($product_status == 1){
			$status = "active";
		}
		else{
			$status = "deactivated";
		}
	}
}
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><?php echo $product_name;?></h4>
</div>

<div class="modal-body">
  
    <table class="table table-condensed table-striped table-hover">
        <tr>
            <th>Code</th>
            <td><?php echo $product_code?></td>
        </tr>
        <tr>
            <th>Brand</th>
            <td><?php echo $brand_name?></td>
        </tr>
        <tr>
            <th>Model</th>
            <td><?php echo $brand_model_name?></td>
        </tr>
        <tr>
            <th>Model Year</th>
            <td><?php echo $product_year?></td>
        </tr>
        <tr>
            <th>Category</th>
            <td><?php echo $category_name?></td>
        </tr>
        <tr>
            <th>Buying Price</th>
            <td><?php echo $product_buying_price?></td>
        </tr>
        <tr>
            <th>Selling Price</th>
            <td><?php echo $product_selling_price?></td>
        </tr>
        <tr>
            <th>Date Added</th>
            <td><?php echo $product_date?></td>
        </tr>
        <tr>
            <th>Balance</th>
            <td><?php echo $product_balance?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo $status?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?php echo $product_description?></td>
        </tr>
	</table>
    <table class="table table-condensed table-striped table-hover">
        <tr>
            <td><img src="<?php echo base_url();?>assets/products/images/<?php echo $product_image_name?>" class="img-responsive img-thumbnail" alt="<?php echo $product_name?>"></td>
        </tr>
	</table>
    <?php
         
	 if(is_array($product_images)){
		 foreach($product_images as $prod){
			 $id = $prod->product_image_id;
			 $image = $prod->product_image_name;
			 $thumb = $prod->product_image_thumb;
			 ?>
			 <div style="float:left">
				<img src="<?php echo base_url();?>assets/products/gallery/<?php echo $image;?>" alt="<?php echo $image;?>"/>
				<a href="<?php echo site_url("admin/products/delete_gallery_image/".$id."/".$product_id)?>">Delete</a>
			 </div>
	<?php
		 }
	 }
	 
	?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>