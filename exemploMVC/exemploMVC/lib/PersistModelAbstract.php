<?php
 /**
 * Diretório Pai - lib
 * Arquivo - PersistModelAbstract.php
 * @author tarcisioruas
 *
 */
abstract class PersistModelAbstract
{
	/**
	* Variável responsável por guardar dados da conexão do banco
	* @var resource
	*/
	protected $o_db;
	
	function __construct()
	{
		//Conectando ao banco de dados		
		$this->o_db = new PDO("sqlite:./databases/db.sq3");
		
		/*
		Mudando para MySQL
		$st_host = localhost;
		$st_banco = agenda;
		$st_usuario = '';
		$st_senha = ''; 
		 
		$st_dsn = "mysql:host=$st_host;dbname=$st_banco"; 
		$this->o_db = new PDO
		(
			$st_dsn,
			$st_usuario,
			$st_senha
		);
		*/		
		$this->o_db->setAttribute ( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
	}
}
?>