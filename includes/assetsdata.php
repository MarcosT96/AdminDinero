	<?php

	/* Array de columnas de la base de datos que deben ser leídas y devueltas a DataTables. Utilice un espacio 
	 * en el que desee insertar un campo que no sea de base de datos (por ejemplo, un contador o una imagen estática)
	 */
	$aColumns = array( 'Title', 'Date', 'CategoryId', 'AccountId', 'Amount','Description');
	
	/* Columna indexada (utilizada para la cardinalidad rápida y precisa de la tabla) */
	$sIndexColumn = "AssetsId";
	
	/* DB tabla a usar */
	$sTable = "assets";
	
	/* Incluir conexión a la base de datos */
	include 'db.php';
	
	/* 
	 * Paginación
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".$mysqli->real_escape_string( $_GET['iDisplayStart'] ).", ".
			$mysqli->real_escape_string( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Pedido
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".$mysqli->real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	// Filtración
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= $aColumns[$i]." LIKE '%".$mysqli->real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Filtrado de columna individual */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".$mysqli->real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * Consultas SQL
	 * Obtener datos para mostrar
	 */
	$sQuery = "
		SELECT * from assets
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysqli_query($mysqli,$sQuery) or die(mysqli_error());
	
	/* Longitud del conjunto de datos después del filtradog */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysqli_query($mysqli,$sQuery) or die(mysqli_error());
	$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Longitud total del conjunto de datos */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = mysqli_query( $mysqli, $sQuery) or die(mysqli_error());
	$aResultTotal = mysqli_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Salida
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysqli_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				/* Formato de salida especial para la columna 'versión' */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* Salida general */
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;
	}
	echo json_encode( $output );
	?>
