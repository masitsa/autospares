<?php
		
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{	
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$post_id = $row->post_id;
				$blog_category_name = $row->blog_category_name;
				$blog_category_id = $row->blog_category_id;
				$post_title = $row->post_title;
				$web_name = $this->site_model->create_web_name($post_title);
				$post_status = $row->post_status;
				$post_views = $row->post_views;
				$image = $row->post_image;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$comments = $this->users_model->count_items('post_comment', 'post_comment_status = 1 AND post_id = '.$post_id);
				$categories_query = $this->blog_model->get_all_post_categories($blog_category_id);
				$description = $row->post_content;
				$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
				$created = $row->created;
				$date = date('jS M Y',strtotime($created));
				$image = $this->site_model->image_display($posts_path, $posts_location, $image);
				
				$categories = '';
				$count = 0;
				if($comments == 1)
				{
					$title2 = 'comment';
				}
				else
				{
					$title2 = 'comments';
				}
				
				foreach($categories_query->result() as $res)
				{
					$count++;
					$category_name = $res->blog_category_name;
					$category_id = $res->blog_category_id;
					$category_web_name = $this->site_model->create_web_name($category_name);
					
					$categories .= '<div class="post-meta">Posted in: <a href="'.site_url().'blog/category/'.$category_web_name.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a></div>';
				}
				
				$result .= 
				'
						<article class="post format-standard">
                    		<div class="row">
                      			<div class="col-md-4 col-sm-4"> <a href="'.site_url().'blog/'.$web_name.'"><img src="'.$image.'" alt="'.$post_title.'" class="img-thumbnail"></a> </div>
                      			<div class="col-md-8 col-sm-8">
                                    <div class="post-actions">
                                        <div class="post-date">'.$date.'</div>
                                        <div class="comment-count"><a href="'.site_url().'blog/'.$web_name.'"><i class="icon-dialogue-text"></i> '.$comments.' '.$title2.'</a></div>
                                    </div>
                        			<h3 class="post-title"><a href="'.site_url().'blog/'.$web_name.'" title="'.$post_title.'">'.$post_title.'</a></h3>
                        			<p>'.$mini_desc.'<a href="'.site_url().'blog/'.$web_name.'" class="continue-reading"> Continue reading <i class="fa fa-long-arrow-right"></i></a></p>
									'.$categories.'
                      			</div>
                    		</div>
                  		</article>
				';
			}
		}
		
		else
		{
			$result = "There are no posts :-(";
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
                </div>
            </div>
      	</div>
    </div>
    
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
            <div class="container">
              	<div class="row">
                	<div class="col-md-9 posts-archive">
                  		
                  		<?php echo $result;?>
                        
                        <?php
							if(isset($links)){echo '<div class="center-align">'.$links.'</div>';}
						?>
                    </div>
                    
                    <?php echo $this->load->view('includes/sidebar', $data, TRUE);?>
              	</div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
    