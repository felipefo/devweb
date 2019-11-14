<?php
 /**
 * Classe designada a validacao de formato de dados
 * @author DigitalDev
 * @version 1.0.2
 */
class DataValidator
{
	/**
	* Verifica se o dado passado esta vazio
	* @param mixed $mx_value
	* @return boolean
	*/
	static function isEmpty( $mx_value )
	{
		if(!(strlen($mx_value) > 0))
			return true;	
		return false;
	}
	
	/**
	* Verifica se o dado passado e um numero
	* @param mixed $mx_value;
	* @return boolean
	*/
	static function isNumeric( $mx_value )
	{
		$mx_value = str_replace(',', '.', $mx_value);
		if(!(is_numeric($mx_value)))
			return false;
		return true;
	}
	
	/**
	* Verifica se o dado passado e um numero inteiro
	* @param mixed $mx_value;
	* @return boolean
	*/
	static function isInteger( $mx_value )
	{
		if(!DataValidator::isNumeric($mx_value))
			return false;
		
		if(preg_match('/[[:punct:]&^-]/', $mx_value) > 0)
			return false;
		return true;
	}
}
?>