<?php
$recent_query = $this->blog_model->get_recent_posts();

if($recent_query->num_rows() > 0)
{
	$recent_posts = '';
	
	foreach ($recent_query->result() as $row)
	{
		$post_id = $row->post_id;
		$post_title = $row->post_title;
		$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
		$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
		
		$recent_posts .= '
			<div class="widgett">
				  <div class="imgholder">
					   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
				  </div>
	
				  <div class="wttitle">
					   <h4><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h4>
				  </div>
	
				  <div class="details2">
					   <a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' Comments</a>
				  </div>
			 </div>
		';
	}
}

else
{
	$recent_posts = 'No posts yet';
}

$categories_query = $this->blog_model->get_all_active_category_parents();
if($categories_query->num_rows() > 0)
{
	$categories = '';
	foreach($categories_query->result() as $res)
	{
		$category_id = $res->blog_category_id;
		$category_name = $res->blog_category_name;
		
		$children_query = $this->blog_model->get_all_active_category_children($category_id);
		
		//if there are children
		if($children_query->num_rows > 0)
		{
			$categories .= '<li><a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts filed under '.$category_name.'">'.$category_name.'</a><ul class="sub-menu">';
			
			foreach($children_query->result() as $res2)
			{
				$child_id = $res2->blog_category_id;
				$child_name = $res2->blog_category_name;
				
				$categories .= '<li><a href="'.site_url().'blog/category/'.$child_id.'" title="View all posts filed under '.$child_name.'">'.$child_name.'</a></li>';
			}
			$categories .= '</ul></li>';
		}
		
		//no childrent
		else
		{
			$categories .= '<li><a href="'.site_url().'blog/category'.$category_id.'" title="View all posts filed under '.$category_name.'">'.$category_name.'</a></li>';
		}
	}
}

else
{
	$categories = 'No Categories';
}
$popular_query = $this->blog_model->get_popular_posts();

if($popular_query->num_rows() > 0)
{
	$popular_posts = '';
	
	foreach ($popular_query->result() as $row)
	{
		$post_id = $row->post_id;
		$post_title = $row->post_title;
		$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
		$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
		
		$popular_posts .= '
			<div class="widgett">
				  <div class="imgholder">
					   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
				  </div>
	
				  <div class="wttitle">
					   <h4><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h4>
				  </div>
	
				  <div class="details2">
					   <a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' Comments</a>
				  </div>
			 </div>
		';
	}
}

else
{
	$popular_posts = 'No posts views yet';
}
?>
  <!-- ***************** - FOOTER - ***************** -->
  <div id="footer">
    <div class="totop">
	<!-- ***************** - TO TOP BUTTON - ***************** -->
      <div class="gototop">
        <div class="arrowgototop"></div>
      </div>
    </div>

    <div class="fshadow"></div>

    <div class="socialfooter">
      <div class="socialcategory">
        <a target="_blank" class="facebooklinkfooter" href="http://www.facebook.com/GFlashDesign" title="Facebook"></a>
		<a target="_blank" class="twitterlinkfooter" href="https://twitter.com/premiumcoding" title="Twitter"></a>
		<a target="_blank" class="diggfooter" href="http://digg.com/" title="Digg"></a>
		<a target="_blank" class="dribblefooter" href="http://dribbble.com/gljivec" title="Dribble"></a>
		<a target="_blank" class="flickerlinkfooter" href="http://www.flickr.com/" title="Flicker "></a>
		<a target="_blank" class="linkedinlinkfooter" href="http://www.linkedin.com/" title="Linkedin"></a>
		<a target="_blank" class="rsslinkfooter" href="http://premiumcoding.com/feed" title="RSS"></a>
      </div>
    </div>
	<!-- ***************** - FOOTER WIDGETS - ***************** -->
    <div id="footerinside">
      <div class="footer_widget">
        
        <div class="footer_widget2">
          <div class="widget-1 widget-first widget category_posts">
            <h3><span>Popular</span> Posts</h3>
			<?php echo $popular_posts;?>
          </div>
        </div>

        <div class="footer_widget3">
          <div class="widget-1 widget-first widget widget_categories">
            <h3>Categories</h3>

            <ul>
              <?php echo $categories;?>
            </ul>
          </div>
        </div>

        <div class="footer_widget4">
          <div class="widget-1 widget-first widget recent_posts">
            <h3><span>Recent</span> Posts</h3>
            <?php echo $recent_posts;?>
        </div>
      </div>
    </div>
    </div>
<!-- ***************** - LOWER FOOTER - ***************** -->
    <div id="footerbwrap">
      <div id="footerb">
        <div class="footernav">
          <div class="menu-footer-container">
            <ul id="menu-footer" class="footernav">
                <li> <a href="<?php echo site_url().'home';?>"> Home </a> </li>
                <li> <a href="<?php echo site_url().'shop';?>"> Shop </a> </li>
                <li> <a href="<?php echo site_url().'blog';?>"> Blog </a> </li>
            </ul>
          </div>
        </div>

        <div class="copyright">
          &copy; Inches2Style <?php echo date('Y');?>
        </div>
      </div>
    </div>
  </div><script type='text/javascript' src='<?php echo base_url().'assets/themes/darx/';?>js/gistfile_pmc.js?ver=3.4.1'>
</script><script type='text/javascript' src='<?php echo base_url().'assets/themes/darx/';?>js/jquery-ui-1.8.20.custom.min.js?ver=3.4.1'>
</script><script type="text/javascript" charset="utf-8">
//<![CDATA[

  jQuery(document).ready(function(){

    jQuery("a[rel^='lightbox']").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false});

  });

  //]]>
  </script>
