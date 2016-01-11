
<div class="row">

	<div class="navigation col-sm-2 col-md-2">
    	<div class="list-group">
        <?php
		if(is_array($navigation)){
        	foreach($navigation as $nav){
				$id = $nav->sub_navigation_id;
				$name = $nav->sub_navigation_name;
				$url = $nav->sub_navigation_url;
				
				if($_SESSION['sub_navigation_id'] == 0){
					$_SESSION['sub_navigation_id'] = $id;
				}
				
				if($_SESSION['sub_navigation_id'] == $id){
					$active = "active";
				}
				else{
					$active = "";
				}
				
				echo '<a class="list-group-item '.$active.'" href="'.site_url($url).'/'.$_SESSION['navigation_id'].'/'.$id .'">'.$name.'</a>';
			}
		}
		?>
        </div><!-- End List group -->
    </div><!-- End Side bar -->