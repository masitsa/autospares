<div class="row logout">
	<div class="col-md-3">
    	<h5>
        	Welcome <?php echo $this->session->userdata('user');?> 
            <?php $logout = site_url("administration/login/logout");?>
            <?php $site = site_url("site");?>
            <a href="<?php echo $logout;?>"><i class="fa fa-sign-out"></i> Log Out</a>
            <a href="<?php echo $site;?>" target="_blank"><i class="fa fa-eye"></i> View Site</a>
            
        </h5>
    </div>
    <?php if (isset($navigation)){?>
	<div class="col-md-9 navigation">
    <nav class="navbar navbar-green" role="navigation">
    	<ul class="nav navbar-nav">
        <?php
		if(is_array($navigation)){
        	foreach($navigation as $nav){
				$id = $nav->navigation_id;
				$name = $nav->navigation_name;
				$url = $nav->navigation_url;
				
				if($_SESSION['navigation_id'] == $id){
					$active = "active";
				}
				else{
					$active = "";
				}
				echo '<li class="'.$active.'"><a href="'.site_url($url).'/'.$id.'/'.$_SESSION['sub_navigation_id'].'">'.$name.'</a></li>';
			}
		}
		?>
    	</ul>
	</nav>
    </div>
    <?php }?>
</div>