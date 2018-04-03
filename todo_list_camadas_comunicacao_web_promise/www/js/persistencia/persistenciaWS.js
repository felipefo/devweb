
function PersistenciaWS(persistencia){    						
	
	this.domain = "https://todolistcomslimphp-felipefrechiani.c9users.io/slim/slim-skeleton/public/";		
	this.persistencia = persistencia;
	this.salvar = function(atividade){
        var uuid = persistencia.getUUID();
    	$.post( this.domain + "salvartarefa",  atividade)
    	    .done(function(msg){ 			        				
			this.persistencia.lista.push(atividade);//guardando na lista
			this.persistencia.listaListener.notify(this.persistencia.lista); //enviando para os observadores  					
	  		Materialize.toast(msg, 4000) }
	  	    )
        .fail(function(xhr, status, error) {
            alert("alguma falha");
            alert(xhr.responseText);
	        }
        )
	}
	this.limpar = function(){
        var uuid = persistencia.getUUID();
    	$.get( this.domain + "limpartarefas",  function(data, status){
    	    this.persistencia.lista = [];
        	this.persistencia.listaListener.notify([]);
			
        	Materialize.toast(data, 4000);
    	});
	}
   	this.listarTodos  = function (){	
		$.get(this.domain + "tarefas", function(data, status){
			persistencia.lista = data;
        	persistencia.listaListener.notify(data);
    	});
	}
	
};