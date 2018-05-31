<?php

/* Esta clase se me ocurio cuando anibal Abdulkhalek midieran el tiempo de ejecucion
y vi una gran oportunidad de aprender algo mas */
class formatTime
{
	#inserta un tiempo
	public function set($time)
	{
		
		if($this->timeCreated > 0)
			$this->timeCreated = $this->formatregular($time);
		else
			$this->timeCreated = " - ".$this->formatregular($time * ( - 1));
	}

	#obtiene el tiempo
	public function get()
	{
		return $this->timeCreated;
	}

	#introduce dos tiempo para calcular la distancia entre estos
	public function set2time($start, $end)
	{

		$start = $this->format3600($start);
		$end = $this->format3600($end);
		$this->timeCreated = $end - $start;
		$this->set($this->timeCreated);
	}

	/* No hallaba como solucionar problema de de la hora era un string de H:i:s por ello
	dividi estos en un array de 3 valores propia mente 1 hora tiene 3600 segundos y calcular
	por segundos es mucho mas facil llevar asi la cuenta */
	public function format3600($time)
	{
		$time = explode(':',$time);
		
		if(count($time) == 3)
		{
			$horus = $time[0] * 3600;
			$min = $time[1] * 60;
			$time = $horus + $min + $time[2];
		}
		else
		{
			print("El formato de Tiempo es H:i:s<br>");
			$time = (-1);
		}

		return $time;
	}

	# devuelve de un forma de 3600s a 1 hora
	public function formatregular($time)
	{
		$horus =$this->add0( (int) ($time / 3600 ) );
		$min = $this->add0( (int) (( $time % 3600 )  / 60 ));
		$segund = $this->add0( number_format((($time % 3600) - ($min * 60) ), 2));

		return "{$horus}:{$min}:{$segund}";
	}

	#analiza antes de mostrar el string de tiempo si este tiene 
	public function add0($num)
	{
		if($num < 10)
			return "0{$num}";
		else
			return $num;
	}

	private $timeCreated;
}