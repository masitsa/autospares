
	<div class="row grey-background">	
    <div class="inner-page">
        
		<!-- Filters -->
        <div class="col-sm-3 col-md-3">
            	
                <!-- Search -->

                <div class="row" style="margin-bottom:20px;">
                	<div class="col-md-12 no_padding">
                    	<?php echo form_open('mini-search');?>
                        <div class="input-group">
                            <input type="text" class="form-control" name="search_data">
                            <span class="input-group-addon" style="background-color: #2f455d; color:#fff;"><button type="submit" class="btn btn-blue"><span class="glyphicon glyphicon-search"></span></button></span>
                        </div>
                    	<?php echo form_close();?>
                    </div>
                </div><!-- End Search -->
            	
                <!-- Categories -->

                <div class="row">
                	<div class="col-md-12 no_padding">
                    	<div class="panel panel-default">
  							<div class="panel_lorenza">
    							<h4>Filter</h4>
  							</div>
  							<div class="panel-body no_padding">
                                <div class="well" style="padding: 8px 0;">
                                    <div style="overflow-y: scroll; overflow-x: hidden; max-height: 500px;">
                                        <ul class="nav nav-list">
                                            <li><label class="tree-toggler nav-header">Categories</label>
                                                <?php $this->load->view('site/includes/categories');?>
                                            </li>
                                            <li class="panel_divider"></li>
                                            <li><label class="tree-toggler nav-header">Brands</label>
                                                <?php $this->load->view('site/includes/brands');?>
                                            </li>
                                            <li class="panel_divider"></li>
                                        </ul>
                                    </div>
                                </div>
  							</div>
						</div>
                    </div>
                </div><!-- End Categories -->
            	
                <!-- Latest products -->
                <div class="row latest_hide">
                	<div class="col-md-12 no_padding">
                    	<div class="panel panel-default">
  							<div class="panel_lorenza">
    							<h4>Latest Products</h4>
  							</div>
  							<div class="panel-body">
                            	<?php $this->load->view("latest_products");?>
  							</div>
						</div>
                    </div>
                </div><!-- End latest products -->
         </div>