<?php

class ebay {

	private $global_id = '';
	private $app_id = '';
	private $client;
	private $username;
	private $token;
	
	function __construct($app_id, $dev_id, $cert_id, $username, $token, $country) {

		$this->global_id = $country;
		$this->app_id = $app_id;
		$this->dev_id = $dev_id;
		$this->cert_id = $cert_id;
		$this->username = $username;
		$this->token = $token;

		$wsdl_url = 'http://developer.ebay.com/webservices/latest/ebaySvc.wsdl';

		$credentials = array('AppId' => $this->app_id, 'DevID' => $this->dev_id, 'AuthCert' => $this->cert_id);

		$this->client = new SOAPClient($wsdl_url, array(
				'trace' => 1,
				'exceptions' => 0,
			));

		$eBayAuth = array(
			'eBayAuthToken' => new SoapVar($this->token, XSD_STRING, NULL, NULL, NULL, 'urn:ebay:apis:eBLBaseComponents'),
			'Credentials' => new SoapVar($credentials, SOAP_ENC_OBJECT, NULL, NULL, NULL, 'urn:ebay:apis:eBLBaseComponents')
		);

		$header_body = new SoapVar($eBayAuth, SOAP_ENC_OBJECT);
		$this->header = array(new SOAPHeader('urn:ebay:apis:eBLBaseComponents', 'RequesterCredentials', $header_body));

	}

	function call($function, $params) {
		$this->client->__setLocation("https://api.sandbox.ebay.com/wsapi?callname=$function&appid={$this->app_id}&siteid={$this->global_id}&version=803&Routing=new");
		return $this->client->__soapCall($function, array($params), NULL, $this->header);
	}

	function test() {
		$data = array(
			'Version' => 803,
			'DetailLevel' => 'ReturnSummary',
			'keywords' => 'banana',
			'UserID' => $this->username, 
		);
		$call = 'findItemsByKeyword';
		$res = $this->call('getUser', $data);

		var_dump($res);
		/*
		$req = $this->client->__getLastRequest();
		echo preg_replace('!>!', ">\n", $req);
// */
	}

}
