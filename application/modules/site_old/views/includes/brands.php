
<ul class="nav nav-list tree">
    <li><a href="<?php echo site_url()."all-brands";?>">All Brands</a></li>
    <li class="panel_divider"></li>
    
	<?php
		$children = '';
		
        if(count($brands > 0)){
                    
			foreach($brands as $cat){
				$brand_name = $cat->brand_name;
				$brand_id = $cat->brand_id;
				
				$children .= '
					<li><label class="tree-toggler nav-header">'.$brand_name.'</label>
						<ul class="nav nav-list tree">
							<li class="panel_in_divider"><a href="'.site_url()."brand/".$brand_id.'">All '.$brand_name.'</a></li>';
				
				//check if brand has models
				
				if(count($brand_models) > 0){
					foreach($brand_models as $cat1){
						$brand_model_name = $cat1->brand_model_name;
						$brand_model_id = $cat1->brand_model_id;
						$brand_id2 = $cat1->brand_id;
						
						if($brand_id == $brand_id2){
							$children .= '<li class="panel_in_divider"><a href="'.site_url()."model/".$brand_model_id.'">'.$brand_model_name.'</a></li>';
						}
					}
				}
				$children .= '
						</ul>
					</li><li class="panel_divider"></li>';
			}
		}
		
		echo $children;
	?>
</ul>
<li class="divider"></li>