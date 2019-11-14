<?php
require_once 'models/TelefoneModel.php';


/**
* @package Exemplo simples com MVC 
* @author DigitalDev 
* @version 0.1.1
*  
* Camada - Modelo ou Model.
* Diretório Pai - models  
* Arquivo - TelefoneModel
*
* Responsável por gerenciar e persistir os dados dos  
* Contatos da Agenda Telefônica 
**/
class ContatoModel extends PersistModelAbstract
{
	private $in_id;
	private $st_nome;
	private $st_email;
	
	function __construct()
	{
		parent::__construct();
		//executa método de criação da tabela de Telefone
		$this->createTableContato();
	}
	
	
	/**
	 * Setters e Getters da
	 * classe TelefoneModel
	 */
	
	public function setId( $in_id )
	{
		$this->in_id = $in_id;
		return $this;
	}
	
	public function getId()
	{
		return $this->in_id;
	}
	
	public function setNome( $st_nome )
	{
		$this->st_nome = $st_nome;
		return $this;
	}
	
	public function getNome()
	{
		return $this->st_nome;
	}
	
	public function setEmail( $st_email )
	{
		$this->st_email = $st_email;
		return $this;
	}
	
	public function getEmail()
	{
		return $this->st_email;
	}
	
	/**
	* Retorna um array contendo os contatos
	* @param string $st_nome
	* @return Array
	*/
	public function _list( $st_nome = null )
	{
		if(!is_null($st_nome))
			$st_query = "SELECT * FROM tbl_contato WHERE con_st_nome LIKE '%$st_nome%';";
		else
			$st_query = 'SELECT * FROM tbl_contato;';	
		
		$v_contatos = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_contato = new ContatoModel();
				$o_contato->setId($o_ret->con_in_id);
				$o_contato->setNome($o_ret->con_st_nome);
				$o_contato->setEmail($o_ret->con_st_email);
				array_push($v_contatos, $o_contato);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_contatos;
	}
	
	/**
	* Retorna os dados de um contato referente
	* a um determinado Id
	* @param integer $in_id
	* @return ContatoModel
	*/
	public function loadById( $in_id )
	{
		$v_contatos = array();
		$st_query = "SELECT * FROM tbl_contato WHERE con_in_id = $in_id;";
		$o_data = $this->o_db->query($st_query);
		$o_ret = $o_data->fetchObject();
		$this->setId($o_ret->con_in_id);
		$this->setNome($o_ret->con_st_nome);
		$this->setEmail($o_ret->con_st_email);		
		return $this;
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de contato. Se o ID for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		if(is_null($this->in_id))
			$st_query = "INSERT INTO tbl_contato
						(
							con_st_nome,
							con_st_email
						)
						VALUES
						(
							'$this->st_nome',
							'$this->st_email'
						);";
		else
			$st_query = "UPDATE
							tbl_contato
						SET
							con_st_nome = '$this->st_nome',
							con_st_email = '$this->st_email'
						WHERE
							con_in_id = $this->in_id";
		try
		{
			
			if($this->o_db->exec($st_query) > 0)
				if(is_null($this->in_id))
				{
					
					/*
					* verificando se o driver usado é sqlite e pegando o ultimo id inserido
					* por algum motivo, a função nativa do PDO::lastInsertId() não funciona com sqlite
					*/
					if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
					{
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS com_in_id')->fetchObject();
						return $o_ret->com_in_id;
					}
					else
						return $this->o_db->lastInsertId();
					
				}
				else
					return $this->in_id;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
		return false;				
	}

	/**
	* Deleta os dados persistidos na tabela de
	* contato usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_id))
		{
			$st_query = "DELETE FROM
							tbl_contato
						WHERE con_in_id = $this->in_id";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	/**
	* Cria tabela para armazernar os dados de contato, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableContato()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		$st_query = "CREATE TABLE IF NOT EXISTS tbl_contato
					(
						con_in_id INTEGER NOT NULL $st_auto_increment,
						con_st_nome CHAR(200),
						con_st_email CHAR(100),
						PRIMARY KEY(con_in_id)
					)";

		//executando a query;
		try
		{
			$this->o_db->exec($st_query);
		}
		catch(PDOException $e)
		{
			throw $e;
		}	
	}
}
?>