
function AtividadeControle(){
	this.persistencia= new PersistenciaLocal();
	this.atividadeVisao = new AtividadeVisao();
	this.atualizarLista =function(){	 
	    var lista = this.persistencia.listarTodos();				
		this.atividadeVisao.carregarTudo(lista);
	}	
	this.remover =function(id){		
		this.persistencia.remover(id);
		this.atualizarLista();
	}	
	this.salvar =function(node){		
		var atividade = this.atividadeVisao.getAtividade(node);
	    var lista = this.persistencia.salvar(atividade);
		this.atualizarLista();
	}	
	this.adicionarAtividade = function(){        
		var atividade = this.atividadeVisao.getNovaAtividade();		
		atividade.status =0;
        this.persistencia.salvar(atividade);		
		this.atualizarLista();			    		
    }    
    this.limparTudo = function(){
        this.persistencia.limpar();
		this.atualizarLista();
    }    	
}


