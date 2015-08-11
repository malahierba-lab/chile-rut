<?php namespace Malahierba\ChileRut;

class ChileRut {
	
	/**
	 * Valida un RUT
	 *
	 * Retorna verdadero/falso para un rut que se le entregue.
	 *
	 * Se consideran válidas las siguientes formas de escribir el rut:
	 *
	 ** xx.xxx.xxx-y (con separación de miles y con guión antes del dígito verificador)
	 ** xxxxxxxx-y (sin separación de miles y con guión antes del dígito verificador)
	 ** xxxxxxxxy (sin separación de miles y sin guión antes del dígito verificador)
	 *
	 * En cualquier opción requiere el dígito verificador. Además, en caso de que el dígito verificador sea la letra "k",
	 * la aceptará en mayúsculas o minúsculas.
	 *
	 * Valida RUT hasta cientos de millones.
	 *
	 * @access		public
	 *
	 * @param		string $rut
	 * @return		boolean
	 */
	public function check($rut) {
		
		$cleanedRut = $this->clean($rut);
		
		if (! $cleanedRut)
			return false;
		
		list($numero, $digitoVerificador) = explode('-', $cleanedRut);
		
		//Validamos requisitos mínimos
		if ((($digitoVerificador != 'K') && (! is_numeric($digitoVerificador))) || (count(str_split($numero)) > 11))
			return false;
		
		//Validamos que todos los caracteres del número sean dígitos
		foreach(str_split($numero) as $chr) {
			if (! is_numeric($chr))
				return false;
		}
		
		//Calculamos el digito verificador
		$digit = $this->digitoVerificador($numero);
		
		//Comparamos el digito verificador calculado con el entregado
		if($digit == $digitoVerificador)
			return true;
		
		return false;
	}
	
	/**
	 * Formatea un RUT
	 *
	 * Estandariza un rut al formato 11222333-K desde cualquier
	 * entrada valida como rut Ej.: 11.222.333-k, 11222333k, etc.
	 * Si la entrada no parece válida retorna FALSE
	 *
	 * Si se desea formatear un rut que no incluye dígito verificador,
	 * se debe establecer el segundo parámetro a false.
	 *
	 * @access		public
	 *
	 * @param		string $rut
	 * @param 		boolean $incluyeDigitoVerificador
	 * @return		string|FALSE
	 */
	public function clean($originalRut, $incluyeDigitoVerificador = true) {
		
		//Eliminamos espacios al principio y final
		$originalRut = trim($originalRut);

		//En caso de existir, eliminamos ceros ("0") a la izquierda
		$originalRut = ltrim($originalRut, '0');

		$input		= str_split($originalRut);
		$cleanedRut	= '';

		foreach ($input as $key => $chr) {

			//Digito Verificador
			if ((($key + 1) == count($input)) && ($incluyeDigitoVerificador)){
				if (is_numeric($chr) || ($chr == 'k') || ($chr == 'K'))
					$cleanedRut .= '-'.strtoupper($chr);
				else
					return false;
			}

			//Números del RUT
			elseif (is_numeric($chr))
					$cleanedRut .= $chr;
		}
		
		if (strlen($cleanedRut) < 3)
			return false;
		
		return $cleanedRut;
	}

	/**
	 * Calcula el dígito verificador de un rut
	 *
	 * El rut puede ser ingresado en los siguientes formatos:
	 *
	 ** xx.xxx.xxx (con separación de miles)
	 ** xxxxxxxx (sin separación de miles)
	 *
	 * @access		public
	 *
	 * @param		string $rut
	 * @return		string|FALSE
	 */
	public function digitoVerificador($rut) {

		//Preparamos el RUT recibido
		$numero = $this->clean($rut, false);

		//Calculamos el dígito verificador
		$txt		= array_reverse(str_split($numero));
		$sum		= 0;
		$factors	= array(2,3,4,5,6,7,2,3,4,5,6,7);

		foreach($txt as $key => $chr) {
			$sum += $chr * $factors[$key];
		}
		
		$a			= $sum % 11;
		$b			= 11-$a;
		
		if($b == 11)
			$digitoVerificador	= 0;
		elseif($b == 10)
			$digitoVerificador	= 'K';
		else
			$digitoVerificador = $b;

		//Convertimos el número a cadena para efectos de poder comparar
		$digitoVerificador = (string)$digitoVerificador;

		return $digitoVerificador;
	}
}