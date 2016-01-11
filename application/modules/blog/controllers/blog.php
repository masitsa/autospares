<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends MX_Controller 
{
	//paths
	var $posts_path;
	
	//locations
	var $posts_location;
		
	function __construct()
	{
		parent:: __construct();
		$this->load->model('admin/users_model');
		$this->load->model('admin/blog_model');
		$this->load->model('admin/categories_model');
		$this->load->model('admin/brands_model');
		$this->load->model('site/site_model');
		
		//image paths
		$this->posts_path = realpath(APPPATH . '../assets/images/posts');
		
		//image locations
		$this->posts_location = base_url().'assets/images/posts/';
	}
    
	/*
	*
	*	Default action is to show all the posts
	*
	*/
	public function index($category = '__', $search = '__') 
	{
		$where = 'post.blog_category_id = blog_category.blog_category_id AND post.post_status = 1';
		$segment = 3;
		$base_url = base_url().'blog/'.$category;
		
		if($search != '__')
		{
			$segment = 4;
			$search_web = $this->site_model->decode_web_name($search);
			$base_url = base_url().'blog/search/'.$search;
			$where .= ' AND (post.post_title LIKE \'%'.$search_web.'%\' OR post.post_content LIKE \'%'.$search_web.'%\' OR blog_category.blog_category_name LIKE \'%'.$search_web.'%\')';
		}
		
		if(($category != '__') && (!empty($category)))
		{
			$category_web = $this->site_model->decode_web_name($category);
			$segment = 4;
			$base_url = base_url().'blog/category/'.$category;
			$where .= ' AND ((blog_category.blog_category_name = \''.$category_web.'\') OR (blog_category.blog_category_id = (SELECT blog_category_id FROM blog_category WHERE blog_category_name = \''.$category_web.'\') AND blog_category.blog_category_parent = blog_category.blog_category_id))';
		}
		
		$table = 'post, blog_category';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $this->users_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
		$config['per_page'] = 5;
		$config['num_links'] = 5;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next →';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '← Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->blog_model->get_all_posts($table, $where, $config["per_page"], $page);
		
		//image paths
		$v_data['posts_path'] = $this->posts_path;
		$v_data['posts_location'] = $this->posts_location;
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$v_data['title'] = $this->site_model->display_page_title();
			$data['content'] = $this->load->view('all_posts', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<p>There are no posts</p>';
		}
		$data['title'] = $this->site_model->display_page_title();
		
		$this->load->view('site/templates/general_page', $data);
	}
	
	public function view_post($web_name)
	{
		$post_title = $this->site_model->decode_web_name($web_name);
		$post_id = $this->blog_model->get_post_id($post_title);
		
		if($post_id > 0)
		{
			$this->blog_model->update_views_count($post_id);
			$query = $this->blog_model->get_post($post_id);
			$v_data['comments_query'] = $this->blog_model->get_post_comments($post_id);
			
			if ($query->num_rows() > 0)
			{
				
				foreach ($query->result() as $row)
				{
					$post_title = $row->post_title;
				}
				$data['title'] = $post_title;
				$v_data['title'] = $post_title;
				$v_data['row'] = $query->row();
				//image paths
				$v_data['posts_path'] = $this->posts_path;
				$v_data['posts_location'] = $this->posts_location;
				
				$data['content'] = $this->load->view('blog/single_post', $v_data, true);
			}
			
			else
			{
				$data['title'] = '';
				$v_data['title'] = '';
				$data['content'] = 'Post not found';
				$data['title'] = 'No active posts are available';
			}
		}
			
		else
		{
			$data['title'] = '';
			$data['content'] = 'Post not found';
			$data['title'] = 'No active posts are available';
		}
		
		$this->load->view('site/templates/general_page', $data);
	}
    
	/*
	*
	*	Add a new comment
	*
	*/
	public function add_comment($post_id) 
	{
		//form validation rules
		$this->form_validation->set_rules('post_comment_description', 'Comment', 'required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|xss_clean');
		
		//if form has been submitted
		if ($this->form_validation->run() == FALSE)
		{
			$this->view_post($post_id);
		}
		
		else
		{
			if($this->blog_model->add_comment_user($post_id))
			{
				$this->session->set_userdata('success_message', 'Comment added successfully. Pending approval by admin');
				redirect('blog/post/'.$post_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Could not add comment. Please try again');
				$this->view_post($post_id);
			}
		}
	}
    
	/*
	*
	*	Search for a product
	*
	*/
	public function search()
	{
		$search = $this->input->post('search_item');
		
		if(!empty($search))
		{
			$web_name = $this->site_model->create_web_name($search);
			redirect('blog/search/'.$web_name);
		}
		
		else
		{
			redirect('blog');
		}
	}
}