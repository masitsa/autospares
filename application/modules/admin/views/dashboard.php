<!DOCTYPE html>
<html lang="en">
    <?php echo $this->load->view("includes/header", '', TRUE); ?>
<body>

    <?php echo $this->load->view("includes/top_navigation", '', TRUE); ?>

    <!-- Main content starts -->
    
    <div class="content">
    	<input type="hidden" id="config_url" value="<?php echo site_url();?>"/>
    	<?php echo $this->load->view("includes/left_navigation", '', TRUE); ?>
        
        <!-- Main bar -->
        <div class="mainbar">
            <?php //echo modules::run('admin/control/crumbs'); ?>
            
            <!-- Matter -->
            
            <div class="matter">
                <div class="container">
                
                    <div class="row">
                    
                        <div class="col-md-12">
							<?php echo $this->load->view("includes/welcome", '', TRUE); ?>
                            
                            <!-- Today status. jQuery Sparkline plugin used. -->
							<?php //echo $this->load->view('administration/summary');?>
                            <!-- Today status ends -->
                            
                            <div class="row">
                                <div class="col-md-12">
                                <?php echo $this->load->view('administration/line_graph');?>
                                </div>
                            </div>  
                            
                            <!-- Dashboard Graph starts -->
                            <?php echo $this->load->view('administration/bar_graph');?>
                            <!-- Dashboard graph ends --> 
                            
                            <!-- Dashboard Graph starts -->
                            <?php echo $this->load->view('administration/clicks_graph');?>
                            <!-- Dashboard graph ends --> 
                        
                        </div>
                    
                    </div>
                
                </div>
            </div>
            
            <!-- Matter ends -->
    
        </div>
    
       <!-- Mainbar ends -->	    	
       <div class="clearfix"></div>
    
    </div>
    <!-- Content ends -->
    
<?php //echo modules::run('admin/control/notifications'); ?>
<?php echo $this->load->view("includes/footer", '', TRUE); ?>

</body>
</html>