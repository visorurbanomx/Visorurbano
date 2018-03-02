<?php
use WsdlToPhp\WsSecurity\WsSecurity;

class Soap_Client
{
	private $client = null;
	private $method = null;
	private $parameters = array();
	public $response = null;

	public function __construct($config = array())
	{
		$url = config_item('ws_url');
		$ws_user = config_item('ws_user');
		$ws_pass = config_item('ws_pass');
		if ($url) {
			$this->client = new SoapClient($url,['soap_version'=>SOAP_1_2]);
			date_default_timezone_set("UTC");
			$soapHeader = WsSecurity::createWsSecuritySoapHeader($ws_user, $ws_pass, False, time(), 3600);
			$this->client->__setSoapHeaders(array($soapHeader));
		}
	}

	public function execute($method = null, $parameters = array())
	{
		$this->method = $method ? $method : $this->method;
		$this->parameters = $parameters ? $parameters : $this->parameters;
		if ($this->method && $this->client) {
			try {
				$this->response = $this->client->{$this->method}($this->parameters);
			} catch (Exception $e) {
        $this->response = (object) array('error' => $e->getMessage());
			}
		} else {
			$this->response = (object) array('error' => $this->client ? 'Unrecognized Method' : 'Datos de configuración incorrectos');
		}
	}

	public function setMethod($method = null)
	{
		$this->method = $method;
	}

	public function setParameters($parameters = null)
	{
		$this->parameters = $parameters;
	}

}
