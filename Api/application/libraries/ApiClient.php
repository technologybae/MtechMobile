<?php
class ApiClient
{
	//region Infrastructure Code

	const SITE_NAME = 'certificationsbuzz.com';
	const API_KEY = 'IaeFXCgK/0GXPrhuKsBFCN3fErcv5+pMkVA9SBPyj+s=';
	const API_URL = 'https://www.practice4exam.com/api/';


	private $lastError = '';

	private function sendRequest($method, $url, $data = NULL)
	{
		$this->clearError();

		$url = self::API_URL . $url;
		$API_KEY = getSiteSettings('api_key');
		$opts = array('http' =>  array(
			'method' =>  $method,
			'header' => "Accept: application/json\r\n" .
						"Content-Type: application/json\r\n" .
						"API-Key: " . $API_KEY,
			'ignore_errors' => true
		));

		if($method == 'POST')
		{
			$opts['http']['content'] = json_encode($data);
		}


		$context = stream_context_create($opts);
		$response = @file_get_contents($url, false, $context);
		$headers = $this->parseHeaders($http_response_header);
		$responseCode = (int)$headers['ResponseCode'];

		$output = '';

		if($responseCode == 200)
		{
			$output = json_decode($response);
		}
		else
		{
			$error = json_decode($response)->Message;

			if($error == null)
				$error = $headers[0];

			$this->setError($error);
		}

		return $output;
	}


	private function parseHeaders($headers)
	{
		$head = array();
		foreach( $headers as $k=>$v )
		{
			$t = explode( ':', $v, 2 );
			if( isset( $t[1] ) )
				$head[ trim($t[0]) ] = trim( $t[1] );
			else
			{
				$head[] = $v;
				if( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) )
					$head['ResponseCode'] = intval($out[1]);
			}
		}
		return $head;
	}


	private function setError($error)
	{
		$this->lastError = $error;
	}

	//endregion


	/**
	 * Clears the error produced during last API call.
	 */
	public function clearError()
	{
		$this->setError('');
	}


	/**
	 * Returns the error produced during last API call.
	 * @return mixed string containing the error message.
	 */
	public function getError()
	{
		return $this->lastError;
	}


	/**
	 * Returns a boolean indicating if the last API call resulted in an error.
	 * @return boolean TRUE if there was and error. Use getError() to retrieve the error message. FALSE if the last call was successful.
	 */
	public function hasError()
	{
		return $this->lastError != '';
	}


	/**
	 * Generates license keys for specified product.
	 * @param mixed $productId Product ID to generate the license for, e.g. 70-461.
	 * @param mixed $users Number of computers that a single license key will cover.
	 * @param mixed $validity Number of days the license will remain valid for.
	 * @param mixed $count Number of keys to generate. Must be <= 500
	 * @return mixed Array containing requested number of license keys.
	 */
	public function getLicenseKey($productId, $users, $validity, $count)
	{
		$params = array
		(
			'users' => $users,
			'validity' => $validity,
			'count' => $count
		);

		$query = http_build_query($params);
		$uri = 'licensing/create/' . $productId . '?' . $query;
		return $this->sendRequest("POST", $uri);
	}


	/**
	 * Gets information about a license key.
	 * @param mixed $licenseKey License key to get the details of.
	 * @return mixed Object containing details of the license. Use dump() for details.
	 */
	public function getLicenseInfo($licenseKey)
	{
		return $this->sendRequest('GET', 'licensing/' . $licenseKey);
	}


	/**
	 * Extends or reduces the license entitlement for the given key. If a negative number of users is specified,
	 * the number computers the license is valid on will be reduced by the given number. Existing activations will
	 * not be affected. e.g. If a license is valid for 5 computers and activated on 3 computers, passing -4 to $users
	 * will reduce the allowed number of computers to 3 instead of 1.
	 *
	 * @param mixed $licenseKey License key to extend.
	 * @param mixed $users Number of users to add to the license. Can be negative to reduce the users or 0 to leave users unchanged.
	 * @param mixed $days Number of days to add to the license. Can be negative to reduce the validity or 0 to leave validity unchanged.
	 * @return mixed Object containing details of the updated license.
	 */
	public function extendLicense($licenseKey, $users, $days)
	{
		$params = array
		(
			'users' => $users,
			'days' => $days
		);

		$query = http_build_query($params);
		$uri = 'licensing/extend/' . $licenseKey . '?' . $query;
		return $this->sendRequest("POST", $uri);
	}


	/**
	 * Revokes the license associated with the given set of keys. If the license has been activated
	 * all activations will become invalid. If there are no activations for the given key present,
	 * the license will be deleted.
	 * @param array $keys Array containings keys to revoke.
	 * @return mixed N/A
	 */
	public function revokeLicense(array $keys)
	{
		$uri = 'licensing/revoke/';
		return $this->sendRequest("POST", $uri, $keys);
	}


	/**
	 * Adds a product to the download queue and initiates the download.
	 * @param mixed $productId Product ID of the product to download. e.g. 70-461
	 * @param mixed $type setup or pdf
	 * @return void
	 */
	public function downloadProduct($productId, $type, $user_email, $order_id)
	{
		$url = $this->sendRequest('GET', 'products/' . $type . '/'. $productId);
		if((bool)$this->hasError())
		{
			if($type == 'pdf'){
				$product_type = 'PDF';
			}
			elseif($type == 'setup')  
			{
				$product_type = 'Practice Exam';
			}
			addtoActivityLog($productId." ".$product_type." Download Failed",$user_email,'',$order_id,'',0,'');
			return;
		}
		else
		{
			if($type == 'pdf'){
				$product_type = 'PDF';
			}
			elseif($type == 'setup')  
			{
				$product_type = 'Practice Exam';
			}
			addtoActivityLog($productId." ".$product_type." Downloaded",$user_email,'',$order_id,'',0,'');
			ob_clean();
			header('Location: ' . $url);
			die();
		}			
		
	}
}


/**
 * Utility function to dump an object to browser.
 * @param void
 */
function dump($obj)
{
	$output = print_r($obj, true);
	echo("<pre>" . $output . "</pre>");
}
?>
