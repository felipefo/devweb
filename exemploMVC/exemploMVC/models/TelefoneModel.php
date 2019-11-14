<?php
/**
 * 
 * Responsável por gerenciar e persistir os dados de telefones dos
 * Contatos da Agenda Telefonica
 * 
 * Camada - models ou modelo
 * Diretório Pai - models
 * Arquivo - TelefoneModel.php
 * 
 * @author DigitalDev
 * @version 0.1.1
 *
 */
class TelefoneModel extends PersistModelAbstract
{
	private $in_id;
	private $in_ddd;
	private $in_telefone;
	private $in_contato_id;
	
	function __construct()
	{
		parent::__construct();
		
		//executa método de criação da tabela de Telefone
		$this->createTableTelefone();
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
	
	public function setDDD( $in_ddd )
	{
		$this->in_ddd = $in_ddd;
		return $this;
	}
	
	public function getDDD()
	{
		return $this->in_ddd;
	}
	
	public function setTelefone( $in_telefone )
	{
		$this->in_telefone = $in_telefone;
		return $this;
	}
	
	public function getTelefone()
	{
		return $this->in_telefone;
	}
	
	public function setContatoId( $in_contato_id )
	{
		$this->in_contato_id = $in_contato_id;
		return $this;
	}
	
	public function getContatoId()
	{
		return $this->in_contato_id;
	}
	
	
	/**
	* Retorna um array contendo os telefones
	* de um determinado contato
	* @param integer $in_contato_id
	* @return Array
	*/
	public function _list( $in_contato_id )
	{
		$st_query = "SELECT * FROM tbl_telefone WHERE con_in_id = $in_contato_id";
		$v_telefones = array();
		try
		{
			$o_data = $this->o_db->query($st_query);
			while($o_ret = $o_data->fetchObject())
			{
				$o_telefone = new TelefoneModel();
				$o_telefone->setId($o_ret->tel_in_id);
				$o_telefone->setDDD($o_ret->tel_in_ddd);
				$o_telefone->setTelefone($o_ret->tel_in_telefone);
				$o_telefone->setContatoId($o_ret->con_in_id);
				array_push($v_telefones,$o_telefone);
			}
		}
		catch(PDOException $e)
		{}				
		return $v_telefones;
	}
	
	/**
	* Retorna os dados de um telefone referente
	* a um determinado Id
	* @param integer $in_id
	* @return TelefoneModel
	*/
	public function loadById( $in_id )
	{
		$v_contatos = array();
		$st_query = "SELECT * FROM tbl_telefone WHERE tel_in_id = $in_id;";
		try 
		{
			$o_data = $this->o_db->query($st_query);
			$o_ret = $o_data->fetchObject();
			$this->setId($o_ret->tel_in_id);
			$this->setDDD($o_ret->tel_in_ddd);
			$this->setTelefone($o_ret->tel_in_telefone);
			$this->setContatoId($o_ret->con_in_id);
			return $this;
		}
		catch(PDOException $e)
		{}
		return false;	
	}
	
	/**
	* Salva dados contidos na instancia da classe
	* na tabela de telefone. Se o ID for passado,
	* um UPDATE será executado, caso contrário, um
	* INSERT será executado
	* @throws PDOException
	* @return integer
	*/
	public function save()
	{
		if(is_null($this->in_id))
			$st_query = "INSERT INTO tbl_telefone
						(
							con_in_id,
							tel_in_ddd,
							tel_in_telefone
						)
						VALUES
						(
							$this->in_contato_id,
							'$this->in_ddd',
							'$this->in_telefone'
						);";
		else
			$st_query = "UPDATE
							tbl_telefone
						SET
							tel_in_ddd = '$this->in_ddd',
							tel_in_telefone = '$this->in_telefone'
						WHERE
							tel_in_id = $this->in_id";
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
						$o_ret = $this->o_db->query('SELECT last_insert_rowid() AS tel_in_id')->fetchObject();
						return $o_ret->tel_in_id;
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
	* telefone usando como referencia, o id da classe.
	*/
	public function delete()
	{
		if(!is_null($this->in_id))
		{
			$st_query = "DELETE FROM
							tbl_telefone
						WHERE tel_in_id = $this->in_id";
			if($this->o_db->exec($st_query) > 0)
				return true;
		}
		return false;
	}
	
	
	
	/**
	* 
	* Cria tabela para armazernar os dados de telefone, caso
	* ela ainda não exista.
	* @throws PDOException
	*/
	private function createTableTelefone()
	{
		/*
		* No caso do Sqlite, o AUTO_INCREMENT é automático na chave primaria da tabela
		* No caso do MySQL, o AUTO_INCREMENT deve ser especificado na criação do campo
		*/
		if($this->o_db->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite')
			$st_auto_increment = '';
		else
			$st_auto_increment = 'AUTO_INCREMENT';
		
		
		$st_query = "CREATE TABLE IF NOT EXISTS tbl_telefone
					(
						tel_in_id INTEGER NOT NULL $st_auto_increment,
						con_in_id INTEGER NOT NULL,
						tel_in_ddd CHAR(5),
						tel_in_telefone CHAR(12),
						PRIMARY KEY(tel_in_id)
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