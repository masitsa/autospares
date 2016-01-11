<!-- Latest -->
        <div class="latest">
        	<h1 class="home-title">Latest Additions</h1>
            
            <div id="ca-container3" class="ca-container">
				<div class="ca-wrapper">
                
                    <?php	
					
                    if(is_array($latest_products)){
						$count = 0;
                        foreach($latest_products as $cat){
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
							$count++;
                            ?>
                            
                            
                            <div class="ca-item ca-item-<?php echo $count;?>">
                                <div class="ca-item-main">
                                    <div class="ca-icon"><img src="<?php echo base_url();?>assets/products/images/<?php echo $product_image_name;?>"/></div>
                                    <h3><?php echo $brand_name;?> <?php echo $brand_model_name;?> <?php echo $category_name;?></h3>
                                    <h4>
                                        <span>KES <?php echo $product_selling_price?></span>
                                    </h4>
                                    <a class="btn-product" href="#" data-toggle="modal" data-target="#modal<?php echo $count;?>">View</a>
                                </div>
                            </div>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="modal<?php echo $count;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" id="product_details">
                                    	<div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel"><?php echo $brand_name;?> <?php echo $brand_model_name;?> <?php echo $category_name;?></h4>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row">
                                        
                                            <!-- Slideshow -->
                                            <div class="col-md-6">
                                                
                                                <div id="view_product<?php echo $product_id;?>" class="carousel slide" data-ride="carousel">
                                                
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#view_product<?php echo $product_id;?>" data-slide-to="0" class="active"></li>
                                                    <?php
                                         
                                                     if(is_array($product_images)){
                                                         $count2 = 1;
                                                         foreach($product_images as $prod){

															 $id = $prod->product_id;
															 
															 if($id == $product_id)
															 {
																 ?>
																 <li data-target="#view_product<?php echo $product_id;?>" data-slide-to="<?php echo $count2;?>" class=""></li>
																<?php
																 $count2++;
															 }
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
                                                         $count2 = 0;
                                                         foreach($product_images as $prod){
															 $id = $prod->product_id;
                                                             $image = $prod->product_image_name;
															 
															 if($id == $product_id)
															 {
																 ?>
																 <div class="item">
																	<img src="<?php echo base_url();?>assets/products/gallery/<?php echo $image;?>"/>
																 </div>
																<?php
																 $count2++;
															 }
                                                         }
                                                     }
                                                     
                                                    ?>
                                                    </div>
                                        
                                                    <a class="left carousel-control" href="#view_product<?php echo $product_id;?>" data-slide="prev">
                                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                                    </a>
                                        
                                                    <a class="right carousel-control" href="#view_product<?php echo $product_id;?>" data-slide="next">
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
                                                                <th>Emal</th>
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
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <?php
                        }
                    }
                    ?>
				</div>
			</div>
        </div><!-- End latest -->