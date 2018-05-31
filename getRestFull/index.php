<?php

#Esto ayuda ha poder ver los errores apesar de que elstatus del servidor es de 500
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

#Api que contendra el manejo de los datos
include('getApi.php');

#solo si existe el GET page
if(isset($_GET['page']))
{
	switch ($_GET['page']) {
		#inicia cesión
		case 'singin':
		 	$mensseguer = singinAction();
		 	print($mensseguer);
		break;
		#pedi el end-point
		case 'questions':
			$messenguer = getQuestions();
			print($messenguer);
		break;
		#cuando no consigue un valor relacionado
		default:
			print("El valor de el GET page no esta en la lista");
		break;
	}
}

#Action de iniciar cesión
function singinAction()
{
	#datos de la pagina
	$page = array(
		'uri' => 'http://apidev.sports4u-quiz.com/auth/sign_in',
		'auth_bool' => false,
		'header_bool' => true
	);

	#parametros
	$body = array(
		'email' => 'akhalek74@yahoo.com',
		'password' => 'manager'
	);

	#Instancia que se comunicara con la pagina externa
	$openApi = new Application_Model_getApi();
    $openApi->setConfig($page);
    $openApi->openApi($body);
    return ($openApi->getDataResponse());
}

#hace la consulta del end-point
function getQuestions()
{
	#direccion de la pagina y sus datos si quiero header pero no hay confirmacion de una header de autorización...
	$page = array(
		'uri' => 'http://apidev.sports4u-quiz.com/questions/get_questions',
		'auth_bool' => false,
		'header_bool' => true
	);

	#datos a enviar
	$body = array(
		'category_id' => '',
		'level_id' => '1'
	);

	$openApi = new Application_Model_getApi();
    $openApi->setConfig($page);
    $openApi->openApi($body);
    return ($openApi->getDataResponse());
}