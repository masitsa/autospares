<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_mail extends MX_Controller 
{
	function __construct()
	{
		parent:: __construct();
		$this->load->model('email_model');
	}
	
	public function send($receiver, $sender, $message)
	{
		$this->email_model->send_smpt_mail($receiver, $sender, $message);
	}
	
	public function send2()
	{
		echo 'here';
	}
}