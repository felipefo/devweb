function PersistenciaLocal(persistencia){     
    
	this.persistencia = persistencia;
	this.limpar = function(){	
	   localStorage.clear();	     	   	   
	   this.persistencia.lista = [];
	   this.persistencia.listaListener.notify([]);    
	}		
	this.salvar =  function(atividade){		   
	   console.log("Atividade clicada:" +JSON.stringify(atividade))	     
	   console.log(localStorage.getItem(atividade.id))
	   if(localStorage.getItem(atividade.id)!=null){
		  console.log("atualizando a atividade:" +JSON.stringify(atividade));
		  localStorage.setItem(atividade.id , JSON.stringify(atividade));	
	   }else{	
	       console.log("salvando uma nova atividade:" +JSON.stringify(atividade));
	       localStorage.setItem(atividade.id , JSON.stringify(atividade));			   
	   }
	   this.listarTodos();
	}
	this.remover = function(id){	
	   localStorage.removeItem(id);		   
	   this.listarTodos();
	}	
	this.listarTodos =  function(){							
		this.persistencia.lista=[];
		for ( var i = 0; i < localStorage.length; i++ ) {		
			var atividade  = localStorage.getItem(localStorage.key(i));						
			this.persistencia.lista.push(JSON.parse(atividade));						
		}			
		this.persistencia.listaListener.notify(this.persistencia.lista);		        
	}		    
}