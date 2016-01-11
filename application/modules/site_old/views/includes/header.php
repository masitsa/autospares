<?php 
	if(count($contacts) > 0){
		foreach($contacts as $cat){
			$site_name = $cat->site_name;
		}
	}
?>

	<!-- Header -->
    <header class="navbar navbar_parts navbar-fixed-top bs-docs-nav" role="banner">
  		<div class="container">
        
        	<div class="float_right padding">
                <button id="showTop" class="search" style="color:#8e202b;"><span class="glyphicon glyphicon-search"></span>
</button>
            </div>
            
    		<div class="navbar-header">
      			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
        			<span class="sr-only">Toggle navigation</span>
        			<span class="glyphicon glyphicon-align-justify"></span>
      			</button>
      			<a href="<?php echo site_url();?>" class="title">
                	<img src="<?php echo base_url();?>assets/img/logo.png" class="img-responsive logo_image" alt="autospares.co.ke"/>
                </a>
    		</div>
    		
            <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      			<ul class="nav navbar-nav" style="cursor:pointer;">
        			<?php
					if(count($pages) > 0){
						
						foreach($pages as $cat){
					
							$page_name = $cat->page_name;
							$page_url = $cat->page_url;
							
							if($page_url == 'home')
							{
								?>
								<li>
									<a href="<?php echo site_url();?>"><?php echo $page_name;?></a>
								</li>
								<?php
							}
							
							else
							{
								?>
								<li>
									<a href="<?php echo site_url()."".$page_url;?>"><?php echo $page_name;?></a>
								</li>
								<?php
							}
						}
					}
					?>
      			</ul>
    		</nav>
  		</div>
	</header>
    <nav class="cbp-spmenu cbp-spmenu-horizontal cbp-spmenu-top" id="cbp-spmenu-s3">
    	<div class="row search_title">
        	<div class="col-md-2 col-sm-2 col-xs-2">
            	<div style="margin: 0 auto; text-align:center; margin:20% 0 0 30%;"<i class="fa fa-search fa-4x"></i></div>
            	<div style="margin: 0 auto; text-align:center; margin-top:20%; font-family: 'Oswald', sans-serif; font-size:1.8em;">Search</div>
            </div>
            
        	<div class="col-md-10 col-sm-10 col-xs-10 search_content">
                <form action="<?php echo site_url()."search";?>" method="post">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label for="brand">Car Brand</label>
                            <div class="styled_checkbox">
                            <select class="form-control search_brand_model" id="brand_id" name="brand_id">
                                  <option value="0">---Select Car Brand---</option>
                                  <?php echo $brands;?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label for="car_type">Brand Model</label>
                            <div class="styled_checkbox">
                            <select class="form-control" id="brand_model_id" name="brand_model_id">
                                  <option value="0">---Select Brand Model---</option>
                                  <?php echo $models;?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label for="year">Year</label>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;">
                           			<div class="styled_checkbox">
                                    <select class="form-control" name="year_from">
                                        <option value="0">------From------</option>
                                        <?php echo $year_from;?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6" style="padding-right:0px;">
                            		<div class="styled_checkbox">
                                    <select class="form-control" name="year_to">
                                        <option value="0">------To------</option>
                                        <?php echo $year_to;?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label for="car_type">Category</label>
                            <div class="styled_checkbox">
                            <select class="form-control search_category_children" id="category_id" name="category_id">
                                  <option value="0">---Select Category---</option>
                                  <?php echo $categories;?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label for="car_type">Sub Category</label>
                            <div class="styled_checkbox">
                            <select class="form-control" id="category_child" name="category_child">
                                  <option value="0">---Select Sub Category---</option>
                                  <?php echo $children;?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <label for="car_type">Location</label>
                            <div class="styled_checkbox">
                            <select class="form-control" id="location_id" name="location_id">
                                  <option value="0">---Select Location---</option>
                                  <?php echo $locations;?>
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="btn_align">
                    	<button class="btn btn-lg search" style="margin-top:11px; width:200px; font-size:1.0em" type="submit">Filter</button>
                    </div>
                </form>
             </div>
       	</div>
    </nav>
    <div class="shadow"></div>

    <!-- End Header -->
    
    
    	