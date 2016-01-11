
<ul class="nav nav-list tree">
    <li><a href="<?php echo site_url()."all-categories";?>">All Categories</a></li>
    <li class="panel_divider"></li>
    
	<?php
		$children = '';
		
        if(count($categories) > 0){
            
            foreach($categories as $cat){
                $category_name = $cat->category_name;
                $category_id = $cat->category_id;
				$children .= '
					<li><label class="tree-toggler nav-header">'.$category_name.'</label>
						<ul class="nav nav-list tree">
							<li class="panel_in_divider"><a href="'.site_url()."category/".$category_id.'">All '.$category_name.'</a></li>';
				
				//check if category has children
				
				if(count($all_children) > 0){
					foreach($all_children as $cat2){
						$child_name = $cat2->category_name;
						$child_id = $cat2->category_id;
						$parent_id = $cat2->category_parent;
						
						if($parent_id == $category_id){
							$children .= '<li class="panel_in_divider"><a href="'.site_url()."category/".$child_id.'">'.$child_name.'</a></li>';
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