<?php echo modules::run('site/load_head');?>
<div class="grey-background">
    <div class="container">
        <?php echo $this->load->view('includes/sidebar', '', TRUE); ?>
        	<div class="col-sm-9 col-md-9">
            <fieldset>
                <legend><?php echo $page_title;?></legend>
                <?php echo $content; ?>
			</fieldset>
            </div>
        </div>
    </div>
</div>
<?php echo modules::run('site/load_foot');?>