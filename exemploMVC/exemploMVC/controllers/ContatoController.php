<?php
//incluindo classes da camada Model
require_once 'models/ContatoModel.php';


/**
 * 
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - ContatoController.php
 * 
 * @author DigitalDev
* @version 0.1.1
 *
 */
class ContatoController
{
	/**
	* Efetua a manipulação dos modelos necessários
	* para a aprensentação da lista de contatos
	*/
	public function listarContatoAction()
	{
		$o_Contato = new ContatoModel();
		
		//Listando os contatos cadastrados
		$v_contatos = $o_Contato->_list();
		
		//definindo qual o arquivo HTML que será usado para
		//mostrar a lista de contatos
		$o_view = new View('views/listarContato.phtml');
		
		//Passando os dados do contato para a View
		$o_view->setParams(array('v_contatos' => $v_contatos));
		
		//Imprimindo código HTML
		$o_view->showContents();
	}
	
	
	/**
	* Gerencia a  de criação
	* e edição dos contatos 
	*/
	public function manterContatoAction()
	{
		$o_contato = new ContatoModel();
		
		//verificando se o id do contato foi passado
		if( isset($_REQUEST['in_con']) )
			//verificando se o id passado é valido
			if( DataValidator::isNumeric($_REQUEST['in_con']) )
				//buscando dados do contato
				$o_contato->loadById($_REQUEST['in_con']);
			
		if(count($_POST) > 0)
		{
			$o_contato->setNome(DataFilter::cleanString($_POST['st_nome']));
			$o_contato->setEmail(DataFilter::cleanString($_POST['st_email']));
			
			//salvando dados e redirecionando para a lista de contatos
			if($o_contato->save() > 0)
				Application::redirect('?controle=Contato&acao=listarContato');
		}
			
		$o_view = new View('views/manterContato.phtml');
		$o_view->setParams(array('o_contato' => $o_contato));
		$o_view->showContents();
	}
	
	/**
	* Gerencia a requisições de exclusão dos contatos
	*/
	public function apagarContatoAction()
	{
		if( DataValidator::isNumeric($_GET['in_con']) )
		{
			//apagando o contato
			$o_contato = new ContatoModel();
			$o_contato->loadById($_GET['in_con']);
			$o_contato->delete();
			
			//Apagando os telefones do contato
			$o_telefone = new TelefoneModel();
			$v_telefone = $o_telefone->_list($_GET['in_con']);
			foreach($v_telefone AS $o_telefone)
				$o_telefone->delete();
			Application::redirect('?controle=Contato&acao=listarContato');
		}	
	}
}
?>