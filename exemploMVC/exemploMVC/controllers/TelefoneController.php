<?php
require_once 'models/TelefoneModel.php';
require_once 'models/ContatoModel.php';

/**
 * 
 * Responsável por gerenciar o fluxo de dados entre
 * a camada de modelo e a de visualização
 * 
 * Camada - Controladores ou Controllers
 * Diretório Pai - controllers
 * Arquivo - TelefoneController.php
 * 
 * @author DigitalDev
* @version 0.1.1
 *
 */
class TelefoneController
{
	public function listarTelefonesAction()
	{
		if( isset($_REQUEST['in_con']) )
			if( DataValidator::isNumeric($_REQUEST['in_con']) )
			{
				$o_contato = new ContatoModel();
				$o_contato->loadById($_REQUEST['in_con']);
				
				$o_telefone = new TelefoneModel();
				$v_telefones = $o_telefone->_list($_GET['in_con']);
				$o_view = new View('views/listarTelefones.phtml');
				$o_view->setParams(array('o_contato' => $o_contato,'v_telefones' => $v_telefones));
				$o_view->showContents();
			}
	}
	
	public function manterTelefoneAction()
	{
		$o_contato = new ContatoModel();
		$o_telefone = new TelefoneModel();
		
		if( isset($_REQUEST['in_con']) )
			if( DataValidator::isInteger($_REQUEST['in_con']) )
				$o_contato->loadById($_REQUEST['in_con']);
			
		if( isset($_REQUEST['in_tel']) )
			if( DataValidator::isInteger($_REQUEST['in_tel']) )
				$o_telefone->loadById($_REQUEST['in_tel']);
				
		if(count($_POST) > 0)
		{
			$o_telefone->setDDD(DataFilter::numeric($_POST['in_ddd']));
			$o_telefone->setTelefone(DataFilter::numeric($_POST['in_telefone']));
			$o_telefone->setContatoId($o_contato->getId());
			if($o_telefone->save() > 0)
				Application::redirect('?controle=Telefone&acao=listarTelefones&in_con='.$o_contato->getId());
		}
			
		$o_view = new View('views/manterTelefone.phtml');
		$o_view->setParams(array('o_contato' => $o_contato,'o_telefone' => $o_telefone));
		$o_view->showContents();
	}
	
	public function apagarTelefoneAction()
	{
		if( isset($_GET['in_tel']) )
			if( DataValidator::isInteger($_GET['in_tel']))
			{
				$o_telefone = new TelefoneModel();
				$o_telefone->loadById($_GET['in_tel']);
				$o_telefone->delete();
				Application::redirect('?controle=Telefone&acao=listarTelefones&in_con='.$_GET['in_con']);
			}	
	}
}	