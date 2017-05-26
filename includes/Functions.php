<?php


/*
     * Función para mostrar un tipo de mensaje de alerta
     *
     * @param string $message   Mensaje de Alerta
     * @return string           Caja de alerta
     */
    function alertBox($message) {
       // return "<div class=\"alert alert-dismissable $type\"><span>$icon</span> $message <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</a></div>";
       return  "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">x</button>$message</div>";
    }
    /*
     * Función para convertir un número en moneda legible
     *
     * @param string $n   			The number
     * @param string $n_decimals	The decimal position
     * @return string           	The formatted Currency Amount
	 *
	 * Devuelve del tipo de cadena, el número redondeado - igual que php number_format()):
	 *
	 * Ejemplos:
	 *		format_amount(54.377, 2) 	retorna 54.38
	 *		format_amount(54.004, 2) 	retorna 54.00
	 *		format_amount(54.377, 3) 	retorna 54.377
	 *		format_amount(54.00007, 3) 	retorna 54.00
     */
	function format_amount($n, $n_decimals) {
        return ((floor($n) == round($n, $n_decimals)) ? number_format($n).'.00' : number_format($n, $n_decimals));
    }
    
    /*
     * Función para cifrar datos sensibles al usuario para almacenar en la base de datos
     *
     * @param string	$value		El texto a cifrar
	 * @param 			$encodeKey	La clave para usar en el cifrado
     * @return						El texto encriptado
     */
	function encryptIt($value) {
		// El encodeKey DEBE coincidir con el decodeKey
		$encodeKey = 'Li1KUqJ4tgX14dS,A9ejk?uwnXaNSD@fQ+!+D.f^`Jy';
		$encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($encodeKey), $value, MCRYPT_MODE_CBC, md5(md5($encodeKey))));
		return($encoded);
	}

    /*
     * Función para descifrar datos sensibles al usuario para mostrar al usuario
     *
     * @param string	$value		El texto a descifrar
	 * @param 			$decodeKey	La clave a utilizar para el descifrado
     * @return						El texto descifrado
     */
	function decryptIt($value) {
		// El decodeKey DEBE coincidir con el encodeKey
		$decodeKey = 'Li1KUqJ4tgX14dS,A9ejk?uwnXaNSD@fQ+!+D.f^`Jy';
		$decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($decodeKey), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($decodeKey))), "\0");
		return($decoded);
	}
	
	function clean($string) {
			return $string = str_replace(',', '', $string); // Reemplaza todos los espacios con guiones.
	}
	
	function Percentage($value){
			return round($value * 100). "%";
		}
		
		function Percentages($value){
			return round($value * 100);
		}
    
?>
