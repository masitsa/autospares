
<!-- start: Header -->
<div id="header">
    <div class="container">
        <div class="row-fluid">
            <div class="span3 logo">
                <h1 class="site-name"><a href="./index.html">CameraStore</a></h1>
                <h2 class="site-slogan">all for your studio</h2>
            </div>
            <div class="span6 search">
            <?php 
				$attributes = array("style" => "margin:0 0 0;", "class" => "form-search");
				echo form_open("browse/search_product/", $attributes);
			?>
                    <input type="text" class="input-medium" placeholder="Search for products">
                    <button type="submit" class="btn hidden">Search</button>
			<?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<!-- end: Header -->
