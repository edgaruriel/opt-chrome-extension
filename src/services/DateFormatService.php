<?php
class DateFormatService{
	function getDateFormat($dateTimeStamp){
		$months = array("Enero"=>1,"Febrero"=>2,"Marzo"=>3,"Abril"=>4,"Mayo"=>5,"Junio"=>6,"Julio"=>7,"Agosto"=>8,"Septiembre"=>9,"Octubre"=>10,"Noviembre"=>11,"Diciembre"=>12);
	
		$year = date('Y',$dateTimeStamp);
		$month = date('n',$dateTimeStamp);
		$day = date('d',$dateTimeStamp);
		$dayOfWeek = date('w',$dateTimeStamp);
	
		$hour = date('h',$dateTimeStamp);
		$minut = date('i',$dateTimeStamp);
		$second = date('s',$dateTimeStamp);
	
		return $day."/".array_search($month, $months)."/".$year." ".$hour."-".$minut."-".$second;
	}
}