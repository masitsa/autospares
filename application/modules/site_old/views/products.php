
        	
        <!-- Products -->
        <div class="col-sm-9 col-md-9">
            <fieldset>
                <legend><?php echo $page_title;?></legend>
            
                    <!-- Items -->
                    <div class="row products">
                        
                        <!-- Products -->
                        <div class="col-md-12 no_padding">
                            <?php $this->load->view("products_list");?>
                        </div>
                        
                        <div class="row">
                            <div class="btn_align">
                                <?php echo $this->pagination->create_links();?>
                            </div>
                        </div>
                        
                    </div><!-- End Products -->
			</fieldset>
        </div><!-- End content -->
	</div><!-- End inner-page -->