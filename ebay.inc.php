<?php

class ebay {

	private $global_id = '';
	private $app_id = '';
	private $client;
	private $username;
	private $token;
	private $url = 'http://svcs.sandbox.ebay.com/services/search/FindingService/v1';
	
	function __construct($app_id, $dev_id, $cert_id, $username, $token, $country) {

		$this->global_id = $country;
		$this->app_id = $app_id;
		$this->dev_id = $dev_id;
		$this->cert_id = $cert_id;
		$this->username = $username;
		$this->token = $token;
		$this->version = '1.0.0';
		$this->format = 'json';

		/*

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

		*/

	}

	public function findItems($keyword = '', $limit = 2) {
		$url = $this->url
			.'?operation-name=findItemsByKeywords'
			.'&service-version='.$this->version
			.'&keywords='.urlencode($keyword)
			."&paginationInput.entriesPerPage=$limit"
			.'&security-appname='. $this->app_id
			.'&response-data-format=' . $this->format
		;

		return json_decode(file_get_contents($url), true);
	}

/*
	function call($function, $params) {
		$this->client->__setLocation("https://api.sandbox.ebay.com/wsapi?callname=$function&appid={$this->app_id}&siteid={$this->global_id}&version=803&Routing=new");
		return $this->client->__soapCall($function, array($params), NULL, $this->header);
	}

	function call_find($function, $params) {
		$this->client->__setLocation("http://svcs.sandbox.ebay.com/services/search/FindingService/v1?callname=$function&appid={$this->app_id}&siteid={$this->global_id}&version=803&Routing=new");
		return $this->client->__soapCall($function, array($params), NULL, $this->header);
	}

	function test() {
		$res = $this->findItems('banana');
		var_dump($res);
	}
*/
}
