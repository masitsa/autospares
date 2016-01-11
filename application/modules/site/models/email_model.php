<?php

class Email_model extends CI_Model 
{
	/*
	*	Send an email
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function send_mail($receiver, $sender, $message)
	{
		$this->load->library('email');

		$this->email->from($sender['email'], $sender['name']);
		$this->email->to($receiver['email']);
		
		$this->email->subject($message['subject']);
		$this->email->message($message['text']);
		
		$this->email->send();
		
		return TRUE;
	}
	
	/*
	*	Send an email
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function send_smpt_mail($receiver, $sender, $message)
	{
		$this->load->library('email');
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'email-smtp.us-east-1.amazonaws.com';
		$config['smtp_user'] = 'AKIAJ3QIODKC5OK2NJ6A';
		$config['smtp_pass'] = 'Aob3FPhLUTNn35qSzRz8vkUYIUHfiR0KafMkOEjvnU/H';
		$config['smtp_port'] = 587;
		$config['smtp_timeout'] = 3600;
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		
		$this->email->initialize($config);

		$this->email->from($sender, 'Alvaro');
		$this->email->to($receiver);
		
		$this->email->subject('Test');
		$this->email->message('AWS test');
		
		$this->email->send();
		echo $this->email->print_debugger();
		
		return TRUE;
	}
}
?>