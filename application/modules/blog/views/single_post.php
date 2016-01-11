<?php
	$post_id = $row->post_id;
	$blog_category_id = $row->blog_category_id;
	$post_title = $row->post_title;
	$post_status = $row->post_status;
	$post_views = $row->post_views;
	$image = $row->post_image;
	$image = $this->site_model->image_display($posts_path, $posts_location, $image);
	$created_by = $row->created_by;
	$modified_by = $row->modified_by;
	$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
	$categories_query = $this->blog_model->get_all_post_categories($blog_category_id);
	$description = $row->post_content;
	$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
	$created = $row->created;
	$date2 = date('M j Y',strtotime($created));
	$tiny_url = $row->tiny_url;
	$categories = '';
	$count = 0;
	//get all administrators
	$administrators = $this->users_model->get_all_administrators();
	if ($administrators->num_rows() > 0)
	{
		$admins = $administrators->result();
		
		if($admins != NULL)
		{
			foreach($admins as $adm)
			{
				$user_id = $adm->user_id;
				
				if($user_id == $created_by)
				{
					$created_by = $adm->first_name;
				}
			}
		}
	}
	
	else
	{
		$admins = NULL;
	}
	
	foreach($categories_query->result() as $res)
	{
		$count++;
		$category_name = $res->blog_category_name;
		$category_id = $res->blog_category_id;
		$category_web_name = $this->site_model->create_web_name($category_name);
		
		$categories .= ' <a href="'.site_url().'blog/category/'.$category_web_name.'" title="View all posts in '.$category_name.'">'.$category_name.'</a> ';
	}
	
	//comments
	$comments_display = 'No Comments';
	$c_title = 'comments';
	$total_comments = $comments_query->num_rows();
	if($comments_query->num_rows() > 0)
	{
		if($total_comments == 1)
		{
			$c_title = 'comment';
		}
		$comments_display = '';
		foreach ($comments_query->result() as $row)
		{
			$post_comment_user = $row->post_comment_user;
			$post_comment_description = $row->post_comment_description;
			$date = date('jS M Y H:i a',strtotime($row->comment_created));
			
			$comments_display .= 
			'
				<li>
					<div class="post-comment-block">
						<div class="img-thumbnail"> <img src="'.base_url().'assets/images/avatar.jpg" alt="avatar"> </div>
						<div class="post-comment-content">
							<h5>'.$post_comment_user.' says</h5>
							<span class="meta-data">'.$date.'</span>
							<p>'.$post_comment_description.'</p>
						</div>
					</div>
				</li>
			';
		}
	}
		
	$data['categories_query'] = $categories_query;
?>

	<!-- Start Page header -->
    <div class="page-header parallax" style="background-image:url(<?php echo base_url();?>assets/images/rims.jpg);">
    	<div class="container">
        	<h1 class="page-title"><?php echo $title;?></h1>
       	</div>
    </div>
    
    <!-- Utiity Bar -->
    <div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                    	<?php echo $this->site_model->get_breadcrumbs();?>
                    </ol>
            	</div>
                <div class="col-md-4 col-sm-6 col-xs-4">
                	<ul class="utility-icons social-icons social-icons-colored">
                    	<li class="facebook"><a href="#" onclick="post_facebook_share('<?php echo $image;?>', '<?php echo $post_title;?> ', '<?php echo $tiny_url;?>')"><i class="fa fa-facebook"></i></a></li>
                    	<li class="twitter"><a target="_blank" href="https://twitter.com/intent/tweet?screen_name=autosparesk&text=<?php echo $post_title;?>%20<?php echo $tiny_url; ?>"><i class="fa fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
      	</div>
    </div>
    
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
      		<div class="container">
        		<div class="row">
          			<div class="col-md-9 single-post">
            			<header class="single-post-header clearfix">
                            <div class="post-actions">
                                <div class="post-date"><?php echo $date2;?></div>
                                <div class="comment-count"><a href="#"><i class="icon-dialogue-text"></i> <?php echo $total_comments;?> <?php echo $c_title;?></a></div>
                            </div>
              				<h2 class="post-title"><?php echo $post_title;?></h2>
            			</header>
            			<article class="post-content">
              				<div class="featured-image"> <img src="<?php echo $image;?>" alt="<?php echo $post_title;?>" class="img-responsive"> </div>
              				<?php echo $description;?>
              				<div class="post-meta"> <i class="fa fa-tags"></i> <?php echo $categories;?> </div>
                            
            			</article>
            			<section class="post-comments" id="comments">
              				<h3><i class="fa fa-comment"></i> Comments (<?php echo $total_comments;?>)</h3>
              				<ol class="comments">
                				<?php echo $comments_display;?>
                            </ol>
                        </section>
                        <section class="post-comment-form">
                            <h3><i class="fa fa-share"></i> Post a comment</h3>
                            <?php
							$validation_errors = validation_errors();
							$errors = $this->session->userdata('error_message');
							$success = $this->session->userdata('success_message');
							
							if(!empty($validation_errors))
							{
							echo '<div style="color:red;">'.$validation_errors.'</div>';
							}
							
							if(!empty($errors))
							{
							echo '<div style="color:red;">'.$errors.'</div>';
							$this->session->unset_userdata('error_message');
							}
							
							if(!empty($success))
							{
							echo '<div style="color:green;">'.$success.'</div>';
							$this->session->unset_userdata('success_message');
							}
							?>
                            <form method="post" action="<?php echo site_url().'blog/add_comment/'.$post_id;?>">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-4 col-sm-4">
                                            <input type="text" class="form-control input-lg" placeholder="Your name" name="name">
                                        </div>
                                        <div class="col-md-4 col-sm-4">
                                            <input type="email" class="form-control input-lg" placeholder="Your email" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                        	<textarea cols="8" rows="4" class="form-control input-lg" placeholder="Your comment" name="post_comment_description"></textarea>
                                    	</div>
                                	</div>
                            	</div>
                            	<div class="row">
                                	<div class="form-group">
                                    	<div class="col-md-12">
                                        	<button type="submit" class="btn btn-primary btn-lg">Submit your comment</button>
                                    	</div>
                                	</div>
                            	</div>
                        	</form>
                    	</section>
          			</div>
          			<?php echo $this->load->view('includes/sidebar', $data, TRUE);?>
          		</div>
        	</div>
      	</div>
 	</div>
    <!-- End Body Content -->
    
