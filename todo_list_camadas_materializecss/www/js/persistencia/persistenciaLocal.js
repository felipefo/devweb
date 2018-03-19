function PersistenciaLocal(){     
    
	
	this.limpar = function(){	
	   localStorage.clear();	     	   	   
	}	
	this.adicionar =  function(atividade){	
	  atividade.status=0;	
	  localStorage.setItem(atividade.id , JSON.stringify(atividade));		   
	}	
	this.salvar =  function(atividade){		  
	  localStorage.setItem(atividade.id , JSON.stringify(atividade));		   
	}
	
	this.remover = function(id){	
	   localStorage.removeItem(id);		   
	}	
	this.listarTodos =  function(){			
		var lista=[];		
		for ( var i = 0; i < localStorage.length; i++ ) {
			var text  = localStorage.getItem(localStorage.key(i));
			lista.push(JSON.parse(text));
		}			
        return lista;
	}		    
}