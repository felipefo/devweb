
function AtividadeControle(){
	
	this.persistencia= new Persistencia();
	this.atividadeVisao = new AtividadeVisao();
	var _this= this;	
	
	
	this.atualizarLista =function(){	 	    		
		var lista = this.persistencia.listarTodos();						
	}
	
	this.atachListenerAtividadeVisaoLoadAll= function(){
		
		this.persistencia.promise.done(function(data) {
			_this.atividadeVisao.carregarTudo(data);
		});
		this.persistencia.promise.fail(function(data) {
			 alert("erro");
		});
		
	}	
	this.setEstrategiaPersistenciaRemota =function(){
		this.persistencia.setEstrategiaPersistencia("remota");			
	}	
	this.setEstrategiaPersistenciaLocal =function(){
		this.persistencia.setEstrategiaPersistencia("local");			
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


