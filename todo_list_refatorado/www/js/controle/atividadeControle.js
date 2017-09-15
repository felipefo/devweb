

function AtividadeControle(){
	
	this.persistencia= new AtividadePersistencia();
	this.atividadeVisao = new AtividadeVisao(this.persistencia);
	var _this = this;
	
	this.setEstrategiaPersistenciaRemota =function(){
		this.persistencia.setEstrategiaPersistencia("remota");			
	}
	
	this.setEstrategiaPersistenciaLocal =function(){
		this.persistencia.setEstrategiaPersistencia("local");			
	}
	
	this.atualizarLista =function(){
	    this.atachListenerAtividadeVisaoLoadAll();  //anexar a visao para o retorno da camada de persistencia?
	    this.persistencia.listarTodos();
	}
	this.adicionarAtividade = function(){
        var atividade = this.atividadeVisao.getAtividade();
        this.persistencia.salvar(atividade);
	    document.getElementById("atividade").value = "";	
    }
    
    this.limparTudo = function(){
        this.persistencia.limpar();
	    this.persistencia.listarTodos();
    }
    
	this.atachListenerAtividadeVisaoLoadAll= function(){
		this.persistencia.listaAdded.attach(function (data) {
        	_this.atividadeVisao.carregarTudo();
			}
        );
	}
}


