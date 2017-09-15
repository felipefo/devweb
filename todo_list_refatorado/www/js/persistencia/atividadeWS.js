
function AtividadeWS(persistencia){    						
	this.domain = "https://todolistcomslimphp-felipefrechiani.c9users.io/slim/slim-skeleton/public/";
	
	//this.domain = "https://todolistcomslimphp-felipefrechiani.c9users.io:8081/";
	var persistencia = persistencia;
	this.salvar = function(atividade){
        var uuid = persistencia.getUUID();
    	$.post( this.domain + "salvartarefa",  {"status": atividade.status, "descricao": atividade.descricao, "id": atividade.id , "userid": uuid })
    	    .done(function(msg){ 
    	    persistencia.lista.push(atividade);
        	persistencia.listaAdded.notify(persistencia.lista);
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
    	    persistencia.lista = [];
        	persistencia.listaAdded.notify([]);
        	Materialize.toast(data, 4000);
    	});
	}
   	this.listarTodos  = function (){	
		$.get(this.domain + "tarefas", function(data, status){
			persistencia.lista = data;
        	persistencia.listaAdded.notify(data);
    	});
	}
	
};