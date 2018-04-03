function PersistenciaLocal(persistencia){     
    
	this.persistencia = persistencia;
	this.limpar = function(){	
	   localStorage.clear();	     	   	   
	   this.persistencia.lista = [];
	   this.persistencia.listaListener.notify([]);    
	}	
	this.adicionar =  function(atividade){	
	  atividade.status=0;	
	  localStorage.setItem(atividade.id , JSON.stringify(atividade));		   
	  this.persistencia.lista.push(atividade);
	  this.persistencia.listaListener.notify(this.persistencia.lista);    
	}	
	this.salvar =  function(atividade){		  
	  localStorage.setItem(atividade.id , JSON.stringify(atividade));		   	  
	}
	
	this.remover = function(id){	
	   localStorage.removeItem(id);		   
	}	
	this.listarTodos =  function(){					
		
		for ( var i = 0; i < localStorage.length; i++ ) {
			var atividade  = localStorage.getItem(localStorage.key(i));						
			this.persistencia.lista.push(JSON.parse(atividade));						
		}			
		this.persistencia.listaListener.notify(this.persistencia.lista);		        
	}		    
}