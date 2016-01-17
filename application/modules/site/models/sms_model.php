<?php

class Sms_model extends CI_Model 
{	
	public function send_sms($phone,$message)
	{
        // This will override any configuration parameters set on the config file
		// max of 160 characters
		// to get a unique name make payment of 8700 to Africastalking/SMSLeopard
		// unique name should have a maximum of 11 characters
        $params = array('username' => 'alviem', 'apiKey' => '1f61510514421213f9566191a15caa94f3d930305c99dae2624dfb06ef54b703');  
        $this->load->library('africastalkinggateway', $params);
		
        // Send the message
		try 
		{
        	$results = $this->africastalkinggateway->sendMessage($phone, $message);
			
			//var_dump($results);die();
			// foreach($results as $result) {
			// 	// status is either "Success" or "error message"
			// 	echo " Number: " .$result->number;
			// 	echo " Status: " .$result->status;
			// 	echo " MessageId: " .$result->messageId;
			// 	echo " Cost: "   .$result->cost."\n";
			// }
			
		}
		
		catch(AfricasTalkingGatewayException $e)
		{
			// echo "Encountered an error while sending: ".$e->getMessage();
		}
    }
}
?>