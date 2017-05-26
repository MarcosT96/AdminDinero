<?php 
session_start();
$UserId=$_SESSION['UserId'];

require_once('../includes/db.php');

//echo $UserId;
//Obtener info del usuario

$GetUserInfo = "SELECT * FROM user WHERE UserId = $UserId";
$UserInfo = mysqli_query($mysqli, $GetUserInfo);
$ColUser = mysqli_fetch_assoc($UserInfo);

$SearchTerm = $_GET['filter'];


if($SearchTerm==''){

//Obtener historial de reporte de gastos
$GetExpenseHistory = "SELECT BillsId, Title, Dates,CategoryName, bills.AccountId,AccountName, Amount, Description from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseReport = mysqli_query($mysqli,$GetExpenseHistory); 
}
else{

// Filtrar reporte de gastos
	$GetExpenseHistory = "SELECT BillsId, Title, Dates,CategoryName, bills.AccountId,AccountName, Amount, Description from bills left join category on bills.CategoryId = category.CategoryId left join account on bills.AccountId = account.AccountId where 
					(bills.Title like '%$SearchTerm%' 
					OR account.AccountName like '%$SearchTerm%'
					OR bills.Description like '%$SearchTerm%' 
					OR category.CategoryName like '%$SearchTerm%')
					AND bills.UserId = $UserId ORDER BY bills.Dates DESC";
$ExpenseReport = mysqli_query($mysqli,$GetExpenseHistory); 
	
$field = mysqli_num_fields($ExpenseReport);
}
$setCounter = 0;

$setExcelName = date("Ymd");


$setRec = $ExpenseReport;

//convertir a excel
$setCounter = mysqli_num_fields($setRec);
$setMainHeader = '';
for ($i = 0; $i < $setCounter; $i++) {
    $setMainHeader1 = mysqli_fetch_field_direct($setRec, $i);
    $setMainHeader .= $setMainHeader1->name."\t";
}
echo ucwords($setMainHeader)."\n";
while($rec = mysqli_fetch_assoc($setRec))  {
  $rowLine = '';
  $setData = '';
  foreach($rec as $value)       {
    if(!isset($value) || $value == "")  {
      $value = "\t";
    }   else  {
//Escapa de todo el carácter especial, cita de los datos.
      $value = strip_tags(str_replace('"', '""', $value));
      $value = '' . $value . '' . "\t";
    }
    $rowLine .= $value;
  }
  $setData .= trim($rowLine)."\n";
  echo $setData;
}
  $setData = str_replace("\r", "", $setData);

if ($setData == "") {
  $setData = "No matching records found";
}

$setCounter = mysqli_num_fields($setRec);



//Este encabezado se utiliza para hacer la descarga de datos en lugar de mostrar los datos
header("Content-Type: application/xls");    

header("Content-Disposition: attachment; filename=".$setExcelName."_Expenses_Report.xls");

header("Pragma: no-cache");
header("Expires: 0");




?>