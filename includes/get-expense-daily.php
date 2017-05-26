<?php

session_start();
//Incluir base de datos
include('db.php');

//Incluir funciones
include('Functions.php');

//Incluir notificacion
include ('notification.php');

// Obtener info del usuario
$UserId=$_SESSION['UserId'];
$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);
	
// Buscar datos en el calendario
$query 				   = "select * from bills where UserId = $UserId ";
$assetstocalender      = mysqli_query($mysqli, $query);
$events = array();
$sum = 0;
while ($row = mysqli_fetch_assoc($assetstocalender)) {
    $start = $row['Dates'];
    $end   = $row['Dates'];
    $amount = $ColUser['Currency'].' '.number_format($row['Amount']);
    $title = $row['Title'];
    $sum+= $row['Amount'];
    
    $eventsArray['title'] = $title;
    $eventsArray['start'] = $start;
    $eventsArray['end'] = $end;
    $eventsArray['names'] = $amount;
    $events[] = $eventsArray;
}
$eventsArray['sum'] = $sum;
echo json_encode($events);	
	
?>
