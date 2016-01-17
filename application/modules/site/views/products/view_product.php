<?php
	$cat = $product_details->row();
	//the product details
	$product_code = $cat->product_code;
	$product_year = $cat->product_year;
	$product_id = $cat->product_id;
	$product_description = $cat->product_description;
	$mini_desc = implode(' ', array_slice(explode(' ', $product_description), 0, 10));
	$product_selling_price = number_format($cat->product_selling_price, 0, '.', ',');
	$product_balance = $cat->product_balance;
	$product_status = $cat->product_status;
	$product_image_name = $cat->product_image_name;
	$category_name = $cat->category_name;
	$product_date = date('jS M Y',strtotime($cat->product_date));
	$product_year = $cat->product_year;
	$model = $cat->brand_model_name;
	$brand = $cat->brand_name;
	$location_name = $cat->location_name;
	$customer_name = $cat->customer_name;
	$customer_phone = $cat->customer_phone;
	$customer_email = $cat->customer_email;
	$tiny_url = $cat->tiny_url;
	$prod_name = $brand.' '.$model.' '.$category_name;
	$product_web_name = $this->site_model->create_web_name($product_code.' '.$prod_name);
	$image = $this->site_model->image_display($products_path, $products_location, $product_image_name);
	
	if($product_year == '0000')
	{
		$product_year = '';
	}
?>
	<!-- Start Page header -->
    <div class="page-header parallax" style="background-image:url(<?php echo base_url();?>assets/images/rims.jpg);">
    	<div class="container">
        	<h1 class="page-title"><?php echo $title;?></h1>
       	</div>
    </div>
    
    <!-- Utiity Bar -->
    <div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                    	<?php echo $this->site_model->get_breadcrumbs();?>
                    </ol>
            	</div>
                
                <div class="col-md-4 col-sm-6 col-xs-4" style="margin-top:5px;">
                	<div data-easyshare data-easyshare-url="">
                              <!-- Facebook -->
                              <button data-easyshare-button="facebook">
                                <span class="fa fa-facebook"></span>
                                <span>Share</span>
                              </button>
                              <span data-easyshare-button-count="facebook">0</span>

                              <!-- Twitter -->
                              <button data-easyshare-button="twitter" data-easyshare-tweet-text="">
                                <span class="fa fa-twitter"></span>
                                <span>Tweet</span>
                              </button>
                              <span data-easyshare-button-count="twitter">0</span>

                              <!-- Google+ -->
                              <button data-easyshare-button="google">
                                <span class="fa fa-google-plus"></span>
                                <span>+1</span>
                              </button>
                              <span data-easyshare-button-count="google">0</span>

                              <div data-easyshare-loader>Loading...</div>
                            </div>

                </div>
            </div>
      	</div>
    </div>
    
     <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            	<!-- Vehicle Details -->
                <article class="single-vehicle-details">
                    <div class="single-vehicle-title">
                        <span class="badge-premium-listing" id="status"><?php echo $customer_name;?></span>

                        <h2 class="post-title"><?php echo $prod_name;?></h2>
                    </div>
                    <div class="single-listing-actions">
                        <div class="btn-group pull-right" role="group">
                            <a href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-default" title="Save this car"><i class="fa fa-star-o"></i> <span>Save this part</span></a>
                            <a href="#" data-toggle="modal" data-target="#infoModal" class="btn btn-default" title="Request more info"><i class="fa fa-info"></i> <span>Contact seller</span></a>
                            <a href="#" data-toggle="modal" data-target="#sendModal" class="btn btn-default" title="Send to a friend"><i class="fa fa-send"></i> <span>Send to a friend</span></a>
                        </div>
                        <div class="pull-right" style="margin-top:5px;">
                             <div data-easyshare data-easyshare-url="">
                              <!-- Total -->
                              <button data-easyshare-button="total">
                                <span>Total</span>
                              </button>
                              <span data-easyshare-total-count>0</span>

                              <!-- Facebook -->
                              <button data-easyshare-button="facebook">
                                <span class="fa fa-facebook"></span>
                                <span>Share</span>
                              </button>
                              <span data-easyshare-button-count="facebook">0</span>

                              <!-- Twitter -->
                              <button data-easyshare-button="twitter" data-easyshare-tweet-text="">
                                <span class="fa fa-twitter"></span>
                                <span>Tweet</span>
                              </button>
                              <span data-easyshare-button-count="twitter">0</span>

                              <!-- Google+ -->
                              <button data-easyshare-button="google">
                                <span class="fa fa-google-plus"></span>
                                <span>+1</span>
                              </button>
                              <span data-easyshare-button-count="google">0</span>

                              <div data-easyshare-loader>Loading...</div>
                            </div>
                        </div>
                        <div class="btn btn-info price">Kes <?php echo $product_selling_price;?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="single-listing-images">
                                <div class="featured-image format-image">
                                    <a href="<?php echo $image;?>" data-rel="prettyPhoto[gallery]" class="media-box"><img src="<?php echo $image;?>" alt="<?php echo $prod_name;?>" class="img-responsive"></a>
                                </div>
                                <div class="additional-images">
                                        <ul class="owl-carousel" data-columns="4" data-pagination="no" data-arrows="yes" data-single-item="no" data-items-desktop="4" data-items-desktop-small="4" data-items-tablet="3" data-items-mobile="3">
                                        	<?php
											
											 if($product_images->num_rows() > 0)
											 {
												 $count = 0;
												 foreach($product_images->result() as $prod)
												 {
													 $image = $prod->product_image_name;
													 $thumb = $prod->product_image_thumb;
													 $image = $this->site_model->image_display($products_path, $products_location, $image);
													 $thumb = $this->site_model->image_display($products_path, $products_location, $thumb);
													 ?>
                                                     <li class="item format-image"> <a href="<?php echo $image;?>" data-rel="prettyPhoto[gallery]" class="media-box"><img src="<?php echo $thumb;?>" alt=""></a></li>
													<?php
													 $count++;
												 }
											 }
											 
											?>
                                        </ul>
                                </div>
                            </div>
                      	</div>
                        <div class="col-md-4">
                            <div class="sidebar-widget widget">
                                <ul class="list-group">
                                    <li class="list-group-item"> <span class="badge">Year</span> <?php echo $product_year;?></li>
                                    <li class="list-group-item"> <span class="badge">Make</span> <?php echo $brand;?></li>
                                    <li class="list-group-item"> <span class="badge">Model</span> <?php echo $model;?></li>
                                    <li class="list-group-item"> <span class="badge">Category</span> <?php echo $category_name;?></li>
                                    <li class="list-group-item"> <span class="badge">Added</span> <?php echo date('j M Y',strtotime($product_date));?></li>
                                </ul>
                            </div>
                        </div>
                   	</div>
                 	<div class="spacer-50"></div>
                    <div class="row">
                    	<div class="col-md-8">
                            <div class="tabs vehicle-details-tabs">
                                <ul class="nav nav-tabs">
                                    <li class="active"> <a data-toggle="tab" href="#vehicle-overview">Overview</a></li>
                                    <li> <a data-toggle="tab" href="#vehicle-specs">Seller details</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="vehicle-overview" class="tab-pane fade in active">
                                        <p>
											<?php echo $product_description?>
                                        </p>
                                    </div>
                                    <div id="vehicle-specs" class="tab-pane fade">
                                        <table class="table-specifications table table-striped table-hover">
                                            <tbody>
                                                <tr>
                                                    <td>Seller name</td>
                                                    <td><?php echo $customer_name;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Seller email</td>
                                                    <td><?php echo $customer_email;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Seller phone</td>
                                                    <td><?php echo $customer_phone;?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Toggle --> 
                                    </div>
                                   
                                </div>
                    		</div>
                            <div class="spacer-50"></div>
                            <!-- Recently Listed Vehicles -->
                            <section class="listing-block recent-vehicles">
                                <div class="listing-header">
                                    <h3>Related parts</h3>
                                </div>
                                <div class="listing-container">
                                    <div class="carousel-wrapper">
                                        <div class="row">
                                            <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="3" data-autoplay="" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="3" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1">
                                            <?php
												if($similar_products->num_rows() > 0)
												{
													$product = $similar_products->result();
													
													foreach($product as $cat)
													{
														$product_code = $cat->product_code;
														$product_year = $cat->product_year;
														$product_id = $cat->product_id;
														$product_description = $cat->product_description;
														$mini_desc = implode(' ', array_slice(explode(' ', $product_description), 0, 10));
														$product_selling_price = number_format($cat->product_selling_price, 0, '.', ',');
														$product_balance = $cat->product_balance;
														$product_status = $cat->product_status;
														$product_image_name = $cat->product_image_name;
														$category_name = $cat->category_name;
														$product_date = date('jS M Y',strtotime($cat->product_date));
														$product_year = $cat->product_year;
														$model = $cat->brand_model_name;
														$brand = $cat->brand_name;
														$location_name = $cat->location_name;
														$customer_name = $cat->customer_name;
														$customer_phone = $cat->customer_phone;
														$customer_email = $cat->customer_email;
														$tiny_url = $cat->tiny_url;
														$prod_name = $brand.' '.$model.' '.$category_name;
														$product_web_name = $this->site_model->create_web_name($product_code.' '.$prod_name);
														$image = $this->site_model->image_display($products_path, $products_location, $product_image_name);
														
														if($product_year == '0000')
														{
															$product_year = '';
														}
														
														echo
														'
														<li class="item">
															<div class="vehicle-block format-standard">
																<a href="'.site_url().'spareparts/'.$product_web_name.'" class="media-box"><img src="'.$image.'" alt="'.$prod_name.'"></a>
																<span class="label label-success premium-listing">'.$customer_name.'</span>
																<h5 class="vehicle-title"><a href="'.site_url().'spareparts/'.$product_web_name.'" title="'.$prod_name.'">'.$prod_name.'</a></h5>
																<span class="vehicle-cost">Kes '.$product_selling_price.'</span>
															</div>
														</li>
														';
													}
												}
											?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </section>
                       	</div>
                        <!-- Vehicle Details Sidebar -->
                        <div class="col-md-4 vehicle-details-sidebar sidebar">
                        
                            <!-- Vehicle Enquiry -->
                            <div class="sidebar-widget widget seller-contact-widget">
                              	<h4 class="widgettitle">Send enquiry</h4>
                                <div class="vehicle-enquiry-in">
                                  <form enctype="multipart/form-data" product_id="<?php echo $product_id;?>" action="<?php echo base_url();?>submit-query"  id = "submit_query" method="post">

                                        <input type="text" placeholder="Name*" name="name" class="form-control" required>
                                        <input type="email" placeholder="Email address*" name="email" class="form-control" required>
                                        <div class="row">
                                            <div class="col-md-7"><input type="text" placeholder="Phone no.*" name="phone" class="form-control" required></div>
                                            <div class="col-md-5"><input type="text" placeholder="Zip* (254)" name="zip" class="form-control" required></div>
                                        </div>
                                        <textarea name="query" class="form-control" placeholder="Your query" required></textarea>
                                        <label class="checkbox-inline">
                                            <input type="checkbox"  name="subscribe" value="1" checked> Subscribe To <strong>Autospares Alerts</strong>
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" id="remember" value=""> Remember my details
                                        </label>
                                        <input type="submit" class="btn btn-primary" value="Submit query">
                                    </form>
                                </div>
                                <div class="vehicle-enquiry-foot">
                                    <span class="vehicle-enquiry-foot-ico"><i class="fa fa-phone"></i></span>
                                    <strong><?php echo $customer_phone?></strong>Seller: <a href="#"><?php echo $customer_email;?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="clearfix"></div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
    
<!-- REQUEST MORE INFO POPUP -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Request more info</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" product_id="<?php echo $product_id;?>" action="<?php echo base_url();?>request-more-info/<?php echo $product_id;?>"  id = "request_more_info_form" method="post">

                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                            </div>
                      	</div>
                   	</div>
             		<input type="submit" class="btn btn-primary pull-right" value="Request Info">
                    <label class="btn-block">Preferred Contact</label>
                    <label class="checkbox-inline"><input type="checkbox" name="preferred_contact" value="1"> Email</label>
                    <label class="checkbox-inline"><input type="checkbox" name="preferred_contact" value="2"> Phone</label>
                </form>
           	</div>
        </div>
    </div>
</div>

<!-- SEND TO A FRIEND POPUP -->
<div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Send to a friend</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" product_id="<?php echo $product_id;?>" action="<?php echo base_url();?>send-to-friend/<?php echo $product_id;?>"  id = "send_to_friend" method="post">

                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="your_email" placeholder="Your Email" required>
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="friends_email" placeholder="Friend's Email" required>
                            </div>
                      	</div>
                   	</div>
                    <textarea class="form-control" name="message" placeholder="Message" required></textarea>
             		<input type="submit" class="btn btn-primary pull-right" value="Submit">
                    <div class="clearfix"></div>
                </form>
           	</div>
        </div>
    </div>
</div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '881322258651090',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>