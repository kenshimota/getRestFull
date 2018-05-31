<?php

include('formatTime.php');

/* Libreria con una clase que se encargara de enviar y recibir la informacion desde la pagina permitiendo asi recibir los datos que se necesitan, y enviarlos cuando se necesita */
class getUrlApi
{
	/* Funcion encargada de comunicar nuestro BackEnd con la API que necesitemos*/
	public function openCurl($url = "", $option = array(), $data = array()){

        #inicio de ejecucion
        $this->time['execStart'] = date('H:i:s');

        $openUrl = curl_init($url);
        curl_setopt($openUrl, CURLOPT_URL , $url);

        #si no es nulo el valor del array entonces inserta estos headers
        if (!empty($option['header_bool']))
        	curl_setopt($openUrl, CURLOPT_HEADER, $option['header_bool']);

        #si necesita autentificacion
        if($option['auth_bool'] == true)
        {
        	curl_setopt($openUrl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        	curl_setopt($openUrl, CURLOPT_USERPWD, "{$option['auth_user']}:{$option['auth_token']}");
        }

        #opciones de la funcion curl
        $curl_opt = array(
        CURLOPT_AUTOREFERER    => true,
       	CURLOPT_CONNECTTIMEOUT => 120,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    	);

    	curl_setopt_array( $openUrl, $curl_opt);
        curl_setopt($openUrl, CURLOPT_RETURNTRANSFER, true);

        #no hice los diferentes metodos ya que lo que necesitavamos es solo el method POST
        curl_setopt($openUrl, CURLOPT_POST, 1);
        curl_setopt($openUrl, CURLOPT_POSTFIELDS,$data);

		$this->dataResponse = curl_exec($openUrl);

        /* Contendra los datos al ejecutar las transferencia de la pagina */
        $this->status = curl_getinfo($openUrl, CURLINFO_HTTP_CODE);

        # Hora del archivo, tiemo de la ultima ejecucion y ultima conexion
        $this->time['filetime'] = curl_getinfo($openUrl, CURLINFO_FILETIME);
        $this->time['execLast'] = curl_getinfo($openUrl, CURLINFO_TOTAL_TIME); 
        $this->time['connect'] = curl_getinfo($openUrl, CURLINFO_CONNECT_TIME);
		
        curl_close($openUrl);

        #finalizacion del proceso de solicitud de la pagina
        $this->time['execEnd'] = date('H:i:s');
	}

	/* Funcion que devolvera los datos obtenidos del servidor cuando se deseen */
	public function getData(){
		return nl2br("\n{$this->dataResponse}");
	}

    /* Funcion que permite insertar los datos que seran enviados */
    public function setDataSend($data = array())
    {
        # funcion encargada de contar la cantidad de datos enviados atraves de un array
        if(count($data) > 0)
            $this->dataToSend = $data;
        else
            return 0;
    }

    # funcion encargada de todos los iempo de ejecución
    public function printTime()
    {
        $format = new formatTime();

        print("Tiempo de inicio de la conexion : {$this->time['execStart']} <br>");

        if($this->time['filetime'] >= 0)
            print("Tiempo del documento remoto: ".$format->formatregular( $this->time['filename'] )."<br>");
        else
            print("Tiempo del documento remoto : es desconocida la hora del documento<br>");
        print("Tiempo de inicio de la ultima conexion : {$this->time['connect']}s<br>");
        print("Tiempo de ejecucion de la ultima conexion : {$this->time['execLast']}s<br>");
        print("Tiempo de la finalizacion de la conexion : {$this->time['execEnd']}<br>");
    }

    protected $dataToSend; # datos a enviar
	private $time; # Contendra todos los datos de las tiempos al hacer la transferencia...
    private $status; # Esto contedra el codigo recibido al tratar de hacer una transferencia a la pagina 
	private $dataResponse;// Esta variable contendra los datos que se requieren.
}