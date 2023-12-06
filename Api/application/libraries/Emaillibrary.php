<?php

require FCPATH.'aws/ses/vendor/autoload.php';
use Aws\Ses\SesClient;

class Emaillibrary
{


	public function send_email($email,$subject,$body, $from = 'system@bakhtoo.com', $reply_to = 'system@bakhtoo.com'){
		
		
		$clientSES = SesClient::factory(array(
			'key' => 'AKIAS47ENG7RUZVZTYCJ',
			'secret' => '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',
			'region' => 'us-west-2'
		));
		
		try {
			$emailSentId = $clientSES->sendEmail(array(
			// Source is required
			'Source' => $from,
			// Destination is required
			'Destination' => array(
				'ToAddresses' => array($email)
			),
			// Message is required
			'Message' => array(
				// Subject is required
				'Subject' => array(
					// Data is required
					'Data' => $subject,
					'Charset' => 'UTF-8',
				),
				// Body is required
				'Body' => array(
					'Html' => array(
						// Data is required
						'Data' => $body,
						'Charset' => 'UTF-8',
					),
				),
			),
			'ReplyToAddresses' => array($reply_to),
			'ReturnPath' => $reply_to
		));
			
		} catch (Exception $e) {
			
			echo $e->getMessage();
			
		}
	}




}
?>