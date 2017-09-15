function PersistenciaLocal(persistencia){
    
    this.persistencia = persistencia;
    
    this.limpar = function(){	
	   localStorage.clear();	     
	   this.persistencia.lista = [];
	   this.persistencia.listaAdded.notify([]);    
	}
	this.salvar =  function(atividade){	
	   localStorage.setItem(atividade.id , atividade);	
	   this.persistencia.lista.push(atividade);
	   this.persistencia.listaAdded.notify(this.persistencia.lista);    
	}
	this.listarTodos =  function(){	
		var atividadestat = new Atividade();
		for(var key in localStorage) {
			var jsonObject = localStorage.getItem(key);						
			var atividade = atividadestat.toAtividade(jsonObject);			
			this.persistencia.lista.push(atividade);
		}
        this.persistencia.listaAdded.notify(this.persistencia.lista);
	}		
    
}