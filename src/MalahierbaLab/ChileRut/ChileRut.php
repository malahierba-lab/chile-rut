<?php namespace MalahierbaLab\ChileRut;

class Rut {
	
	/**
	 * Valida un RUT
	 *
	 * Retorna verdadero/falso para un rut que se le entregue.
	 * Para un rut válido del tipo xx.xxx.xxx-y se consideran válidas
	 * las siguientes formas de escribirlo:
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
			return FALSE;
		
		list($numero, $digitoVerificador) = explode('-', $cleanedRut);
		
		//Validamos requisitos mínimos
		if ((($digitoVerificador != 'K') && (! is_numeric($digitoVerificador))) || (count(str_split($numero)) > 11))
			return FALSE;
		
		//Validamos que todos los caracteres del número sean dígitos
		foreach(str_split($numero) as $chr) {
			if (! is_numeric($chr))
				return FALSE;
		}
		
		$txt		= array_reverse(str_split($numero));
		$sum		= 0;
		$factors	= array(2,3,4,5,6,7,2,3,4,5,6,7);

		foreach($txt as $key => $chr) {
			$sum += $chr * $factors[$key];
		}
		
		$a			= $sum % 11;
		$b			= 11-$a;
		
		if($b == 11)
			$digit	= 0;
		elseif($b == 10)
			$digit	= 'K';
		else
			$digit = $b;
		
		if($digit == $digitoVerificador)
			return TRUE;
		
		return FALSE;
	}
	
	/**
	 * Formatea un RUT
	 *
	 * Estandariza un rut al formato 11222333-K desde cualquier
	 * entrada valida como rut Ej.: 11.222.333-k, 11222333k, etc.
	 * Si la entrada no parece válida retorna FALSE
	 *
	 * @access		public
	 *
	 * @param		string $rut
	 * @return		string|FALSE
	 */
	public function clean($originalRut) {
		
		$input		= str_split($originalRut);
		$cleanedRut	= '';

		foreach ($input as $key => $chr) {
			if (($key + 1) == count($input)){
				if (is_numeric($chr) || ($chr == 'k') || ($chr == 'K'))
					$cleanedRut .= '-'.strtoupper($chr);
				else
					return FALSE;
			}
			elseif (is_numeric($chr))
					$cleanedRut .= $chr;
		}
		
		if (strlen($cleanedRut) < 3)
			return FALSE;
		
		return $cleanedRut;
	}
}