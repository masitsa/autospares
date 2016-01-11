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
		$comments = $this->users_model->count_items('post_comment', 'post_comment_status = 1 AND post_id = '.$post_id);
		$title = 'Comments';
		if($comments == 1)
		{
			$title = 'Comment';
		}
		
		$recent_posts .= '
			<div class="widgett">
				  <div class="imgholder">
					   <a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'"><img src="'.$image.'" alt="'.$post_title.'"></a>
				  </div>
	
				  <div class="wttitle">
					   <h4><a href="'.site_url().'blog/post/'.$post_id.'" rel="bookmark" title="'.$post_title.'">'.$post_title.'</a></h4>
				  </div>
	
				  <div class="details2">
					   <a href="'.site_url().'blog/post/'.$post_id.'" title="'.$post_title.'">'.$comments.' '.$title.'</a>
				  </div>
			 </div>
		';
	}
}

else
{
	$recent_posts = 'No posts yet';
}
		
		if($categories_query->num_rows() > 0)
		{
			$cats = '';
			foreach($categories_query->result() as $res)
			{
				$category_name = $res->blog_category_name;
				$category_id = $res->blog_category_id;
				$category_web_name = $this->site_model->create_web_name($category_name);
				
				$total_categories = $this->users_model->count_items('post', '(post.blog_category_id = '.$category_id.')');
				
				$cats .= '<li><a href="'.site_url().'blog/category/'.$category_web_name.'" title="View posts under '.$category_name.'">'.$category_name.'</a> ('.$total_categories.')</li>';
			}
		}
		
		else
		{
			$cats = 'There are no categories :-(';
		}

		$popular_query = $this->blog_model->get_popular_posts();
		if($popular_query->num_rows() > 0)
		{
			$popular_posts = '';
			
			foreach ($popular_query->result() as $row)
			{
				$post_id = $row->post_id;
				$post_title = $row->post_title;
				$web_name = $this->site_model->create_web_name($post_title);
				$image = $row->post_image;
				$image = $this->site_model->image_display($posts_path, $posts_location, $image);
				$comments = $this->users_model->count_items('post_comment', 'post_comment_status = 1 AND post_id = '.$post_id);
				$title2 = 'Comments';
				if($comments == 1)
				{
					$title2 = 'Comment';
				}
				
				$popular_posts .= '
					 <div class="post-block post-review-block">
						<div class="review-status">
							<img src="'.$image.'" alt="'.$post_title.'" class="img-thumbnail">
							<span>'.$comments.' '.$title2.'</span>
						</div>
						<h3 class="post-title"><a href="'.site_url().'blog/'.$web_name.'" title="'.$post_title.'">'.$post_title.'</a></h3>
					</div>
				';
			}
		}
		
		else
		{
			$popular_posts = 'No popular posts yet';
		}
?>

<!-- Start Sidebar -->
<div class="col-md-3 sidebar">
    <div class="widget sidebar-widget search-form-widget">
        <form action="<?php echo site_url().'blog/search';?>" method="POST">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="Search Posts..." name="search_item">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="fa fa-search fa-lg"></i></button>
                </span>
            </div>
        </form>
    </div>
    <div class="widget sidebar-widget widget_categories">
        <h3 class="widgettitle">Post Categories</h3>
        <ul>
            <?php echo $cats;?>
        </ul>
    </div>
    <div class="widget sidebar-widget widget_recent_reviews">
        <h3 class="widgettitle">Popular posts</h3>
        <?php echo $popular_posts;?>
    </div>
</div>
		