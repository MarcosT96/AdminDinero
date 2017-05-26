<?php session_start();

// Comprobar link activo
function ActiveClass($requestUri)
{
    $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

    if ($current_file_name == $requestUri)
        echo 'class="active"';
}
		
		//comprobar si esta logueado
		if (!isset($_SESSION['UserId'])) {
			header ('Location: login.php');
			exit;
		}

		// Cerrar sesion
		if (isset($_GET['action'])) {
			$action = $_GET['action'];
			if ($action == 'logout') {
				session_destroy();
				header('Location: login.php');
			}
		}



 //Link al sitio
if (isset($_GET['page']) && $_GET['page'] == 'Transaction') {
            $page = 'Transaction';
        } else if (isset($_GET['page']) && $_GET['page'] == 'AssetReport') {
            $page = "AssetReport";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageBudget') {
            $page = "ManageBudget";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageIncomeCategory') {
            $page = "ManageIncomeCategory";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageExpenseCategory') {
            $page = "ManageExpenseCategory";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageAccount') {
            $page = "ManageAccount";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageIncome') {
            $page = "ManageIncome";
        } else if (isset($_GET['page']) && $_GET['page'] == 'Settings') {
            $page = "Settings";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ExpenseReport') {
            $page = "ExpenseReport";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ManageExpense') {
            $page = "ManageExpense";
        } else if (isset($_GET['page']) && $_GET['page'] == 'ReportPdf') {
            $page = "ReportPdf";
        } else if (isset($_GET['page']) && $_GET['page'] == 'IncomeVsExpense') {
            $page = "IncomeVsExpense";
        } else if (isset($_GET['page']) && $_GET['page'] == 'IncomeCalender') {
            $page = "IncomeCalender";
        } else if (isset($_GET['page']) && $_GET['page'] == 'AllIncomeReports') {
            $page = "AllIncomeReports";
        } else if (isset($_GET['page']) && $_GET['page'] == 'AllExpenseReports') {
            $page = "AllExpenseReports";    
        } else if (isset($_GET['page']) && $_GET['page'] == 'ExpenseCalender') {
            $page = "ExpenseCalender";
        } else if (isset($_GET['page']) && $_GET['page'] == 'siteSettings') {
            $page = "siteSettings";
        } else {
            $page = 'dashboard';
        }


//obtener notificaciones
include('includes/global.php');

//obtener Header
include('includes/header.php'); 


//establecer mensaje global de notificacion
$msgBox	="";

if (file_exists('pages/'.$page.'.php')) {
            // Cargar el sitio
            include('pages/'.$page.'.php');
        } else {
            // Si no, mostrar error
          
            echo '
                    <div class="wrapper">
                        <h3>Err</h3>
                        <div class="alertMsg default">
                            <i class="icon-warning-sign"></i> The page "'.$page.'" could not be found.
                        </div>
                    </div>
                ';
        }

        include('includes/footer.php');
  

?>
