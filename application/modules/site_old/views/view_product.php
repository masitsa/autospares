<?php
/*foreach($product as $cat){
	
	$product_code = $cat->product_code;
	$product_id = $cat->product_id;
	$product_description = $cat->product_description;
	$product_selling_price = number_format($cat->product_selling_price, 2, '.', ',');
	$product_balance = $cat->product_balance;
	$product_status = $cat->product_status;
	$product_image_name = $cat->product_image_name;
	$category_name = $cat->category_name;
	$product_date = date('jS M Y',strtotime($cat->product_date));
	$product_year = $cat->product_year;
	$brand_model_name = $cat->brand_model_name;
	$brand_name = $cat->brand_name;
	$location_name = $cat->location_name;
	$customer_name = $cat->customer_name;
	$customer_phone = $cat->customer_phone;
	$customer_email = $cat->customer_email;
}*/

?>
                        
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $brand_name;?> <?php echo $brand_model_name;?> <?php echo $category_name;?></h4>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                        
                            <!-- Slideshow -->
                            <div class="col-md-6">
                                
                                <div id="view_product" class="carousel slide" data-ride="carousel">
                                
                                    <ol class="carousel-indicators">
                                        <li data-target="#view_product" data-slide-to="0" class="active"></li>
                                    <?php
                         
                                     if(is_array($product_images)){
                                         $count = 1;
                                         foreach($product_images as $prod){
                                             ?>
                                             <li data-target="#view_product" data-slide-to="<?php echo $count;?>" class=""></li>
                                            <?php
                                             $count++;
                                         }
                                     }
                                     
                                    ?>
                                    </ol>
                                    
                                    <div class="carousel-inner">
                                        <div class="item active">
                                            <img src="<?php echo base_url();?>assets/products/images/<?php echo $product_image_name;?>"/>
                                         </div>
                                    <?php
                         
                                     if(is_array($product_images)){
                                         $count = 0;
                                         foreach($product_images as $prod){
                                             $image = $prod->product_image_name;
                                             
                                             ?>
                                             <div class="item">
                                                <img src="<?php echo base_url();?>assets/products/gallery/<?php echo $image;?>"/>
                                             </div>
                                            <?php
                                             $count++;
                                         }
                                     }
                                     
                                    ?>
                                    </div>
                        
                                    <a class="left carousel-control" href="#view_product" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                        
                                    <a class="right carousel-control" href="#view_product" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                
                                </div>
                            </div><!-- End Slideshow -->
                            
                            <!-- Cart -->
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Description</legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-condensed table-striped table-hover">
                                                <tr>
                                                    <th>Price</th>
                                                    <td><?php echo $product_selling_price;?></td>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <td><?php echo $location_name;?></td>
                                                </tr>
                                                <?php if($product_year != "0000"){ ?>
                                                <tr>
                                                    <th>Year</th>
                                                    <td><?php echo $product_year;?></td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-condensed table-striped table-hover">
                                                <tr>
                                                    <th>Brand</th>
                                                    <td><?php echo $brand_name;?></td>
                                                </tr>
                                                <tr>
                                                    <th>Model</th>
                                                    <td><?php echo $brand_model_name;?></td>
                                                </tr>
                                                <tr>
                                                    <th>Added</th>
                                                    <td><?php echo date('j M Y',strtotime($product_date));?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <p>
                                        <?php echo $product_description?>
                                    </p>
                                </fieldset>
                                <fieldset>
                                    <legend>Contact Seller</legend>
                                        <table class="table table-condensed table-striped table-hover">
                                            <tr>
                                                <th>Name</th>
                                                <td><?php echo $customer_name;?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td><?php echo $customer_phone;?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $customer_email;?></td>
                                            </tr>
                                        </table>
                                </fieldset>
                                
                            </div><!-- End Cart -->
                        </div>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
                      </div>