	    
    <!-- Home page -->
	<div class="home-page">
    	<div id="home" data-stellar-background-ratio="0.5">
        	<div class="container">
                <div class="home-content">
                    <div class="red-background wow zoomInRight">
                        <a class="btn btn-lg btn-blue float-right" href="<?php echo site_url().'sell';?>">Sell Spares</a>
                        <p>Upload your auto spares
                        <span>and we will market them for you</span></p>
                    </div>
                    <div class="blue-background float-right wow zoomInLeft" data-wow-delay="1s">
                        <a class="btn btn-lg btn-red float-right" href="<?php echo site_url().'all-categories';?>">Buy Spares</a> 
                        <p>Find autospares for your car here</p>
                    </div>
                </div>
            </div><!-- End Home Content -->
        </div><!-- End Home -->
        
    	<!-- Categories -->
    	<div class="categories">
			<h1 class="home-title">Autospares Categories</h1>
            
            <div class="btn_align">
                <div class="fb-like" data-href="https://www.facebook.com/Autospares.co.ke" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
            </div>
            
			<div class="row tablet-display">
                <?php
                    if(count($categories) > 0){
						$count2 = 0;
                        
                        foreach($categories as $cat){
                            
                            $category_id = $cat->category_id;
                            $category_name = $cat->category_name;
                            $category_image_name = $cat->category_image_name;
                    		$count = 0;
                        
							if(is_array($all_product_categories)){
								
								foreach($all_product_categories as $prod){
									$product_category_id = $prod->category_id;
									$product_category_parent = $prod->category_parent;
									
									if(($product_category_id == $category_id) || ($product_category_parent == $category_id))
									{
										$count++;
									}
								}
							}
                            
                            ?>
                            <div class="col-xs-2 col-sm-2 col-md-2">
                                <a href="<?php echo site_url()."category/".$category_id?>" class="cat">
                                    <img src="<?php echo base_url()."assets/categories/images/".$category_image_name?>" class="img-responsive" alt="<?php echo $category_name?>">
                                	<p><?php echo $category_name;?> <br/>(<?php echo $count;?>)</p>
                                </a>
                            </div>
							<?php
                            $count2++;
                            if(($count2 % 6) == 0){
                                ?>
                                    </div>
                                    <div class="row tablet-display">
                                <?php
                            }
                        }
                    }
                ?>
            </div>
            
            <div id="ca-container" class="ca-container mobile-display">
				<div class="ca-wrapper">
                 <?php
                    if(count($categories) > 0){
						$count2 = 0;
                        
                        foreach($categories as $cat){
                            
                            $category_id = $cat->category_id;
                            $category_name = $cat->category_name;
                            $category_image_name = $cat->category_image_name;
                    		$count = 0;
							$count2++;
                        
							if(is_array($all_product_categories)){
								
								foreach($all_product_categories as $prod){
									$product_category_id = $prod->category_id;
									$product_category_parent = $prod->category_parent;
									
									if(($product_category_id == $category_id) || ($product_category_parent == $category_id))
									{
										$count++;
									}
								}
							}
                            
                            ?>
                            <div class="ca-item ca-item-<?php echo $count2;?>">
                                <div class="ca-item-main">
                                    <div class="ca-icon">
                                    	<a href="<?php echo site_url()."category/".$category_id?>" class="cat">
                                    		<img src="<?php echo base_url()."assets/categories/images/".$category_image_name?>" class="img-responsive" alt="<?php echo $category_name?>">
                                		</a>
                                	</div>
                                    <a class="btn-product" href="<?php echo site_url()."category/".$category_id?>"><?php echo $category_name;?> <br/>(<?php echo $count;?>)</a>
                                </div>
                            </div>
							<?php
							}
						}
					?>
				</div>
			</div>
        </div>
        <!-- End categories -->
        
        <!-- Latest -->
        <?php $this->load->view('latest');?>
        <!-- End latest -->
        
        <!-- Brands -->
        <div class="logos">
			<h1 class="home-title">Car Brands</h1>
			<div class="row tablet-display">
                <?php	
                if(count($brands) > 0){
                    $count = 0;
                    foreach($brands as $cat){
                        $count++;
                        $brand_id = $cat->brand_id;
                        $brand_name = $cat->brand_name;
                        $brand_image_name = $cat->brand_image_name;
                        $count_all_products = 0;
                        
                        if(is_array($all_products)){
                            
                            foreach($all_products as $prod){
                                $product_brand_id = $prod->brand_id;
                                
                                if($product_brand_id == $brand_id)
                                {
                                    $count_all_products++;
                                }
                            }
                        }
                        ?>
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <a href="<?php echo site_url()."brand/".$brand_id?>">
                                <img src="<?php echo base_url()."assets/brand/images/".$brand_image_name?>" class=" img-responsive" alt="<?php echo $brand_name?>">
                                <p><?php echo $brand_name;?> <br/>(<?php echo $count_all_products;?>)</p>
                            </a>
                        </div>
                        <?php
                        
                        if(($count % 6) == 0){
                            ?>
                                </div>
                                <div class="row tablet-display">
                            <?php
                        }
                    }
                }
                ?>
            </div>
            
            <div id="ca-container2" class="ca-container mobile-display">
				<div class="ca-wrapper">
					<?php	
                    if(count($brands) > 0){
                        $count2 = 0;
                        foreach($brands as $cat){
                            $count++;
                            $brand_id = $cat->brand_id;
                            $brand_name = $cat->brand_name;
                            $brand_image_name = $cat->brand_image_name;
                            $count_all_products = 0;
                        	$count2++;
                            
                            if(is_array($all_products)){
                                
                                foreach($all_products as $prod){
                                    $product_brand_id = $prod->brand_id;
                                    
                                    if($product_brand_id == $brand_id)
                                    {
                                        $count_all_products++;
                                    }
                                }
                            }
                            ?>
                            <div class="ca-item ca-item-<?php echo $count2;?>">
                                <div class="ca-item-main">
                                    <div class="ca-icon">
                                    	<a href="<?php echo site_url()."brand/".$brand_id?>" class="cat">
                                    		<img src="<?php echo base_url()."assets/brand/images/".$brand_image_name?>" class=" img-responsive" alt="<?php echo $brand_name?>">
                                		</a>
                                	</div>
                                    <a class="btn-product" href="<?php echo site_url()."brand/".$brand_id?>">
										<?php echo $brand_name;?> <br/>(<?php echo $count;?>)
                                    </a>
                                </div>
                            </div>
							<?php
							}
						}
					?>
				</div>
			</div>
            
            <div class="btn_align">
            	<a class="login_btn btn btn_pink btn-lg" href="<?php echo site_url().'all-categories';?>">All Brands</a>
            </div>
        </div>
        <!-- End brands -->
        
        <!-- Video -->
        <?php $this->load->view('video');?>
        <!-- End Video -->
        
        </div>
		<!-- End content -->
     </div><!-- End homepage -->