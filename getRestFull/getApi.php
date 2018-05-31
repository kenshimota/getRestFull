<?php

include("getUrlApi.php");

class Application_Model_getApi extends getUrlApi
{
	#Esto permite connectar hacia la direccion de la pagina
	public function openApi($data = array())
	{
		$this->openCurl($this->uri, $this->config, $data);
		$this->setDataSend($data);
	}

	public function setUrl($uri_tmp = "")
	{
		#esto verifica que la variable no este vacia o tenga un valor nulo
		if(!empty($uri_tmp))
			$this->uri = $uri_tmp;
	}

	/* funcion encargada de dar las configuraciones 
	antes de intentar abrir la url de la */
	public function setConfig($dataConfig = array()){
		#esto verifica que la variable no este vacia o tenga un valor nulo
		if(!empty($dataConfig))
		{
			if(isset($dataConfig['uri']))
				$this->setUrl($dataConfig['uri']);
			if(isset($dataConfig['auth_bool']))
				$this->config['auth_bool'] = $dataConfig['auth_bool'];
			if(isset($dataConfig['auth_user']))
				$this->config['auth_user'] = $dataConfig['auth_user'];
			if(isset($dataConfig['auth_token']))
				$this->config['auth_token'] = $dataConfig['auth_token'];
			if(isset($dataConfig['header_bool']))
				$this->config['header_bool'] = $dataConfig['header_bool'];
		}
	}

	/* Obtienes todas las configuraciones que estan establecidad para 
	la direcion de la pagina */
	public function getCofing()
	{
		return $dataConfig;
	}

	/* Funcion encargada de obtener la respuesta del servidor */
	public function getDataResponse()
	{
		$this->printTime();
		$this->data_response = $this->getData();
		return $this->data_response;
	}

	/*  Funcion que se encarga de obtener los estatus de la pagina */
	public function getStatus()
	{
		return $this->status;	
	}

	private $uri;
	private $config;
	private $data_response;
}