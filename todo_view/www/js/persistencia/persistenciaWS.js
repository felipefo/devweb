
function PersistenciaWS(persistencia){    						
	
	this.domain = "http://localhost/server_php/public/";		
	this.persistencia = persistencia;
	_this=this;
	this.salvar = function(atividade){
        //var uuid = persistencia.getUUID();
    	$.post( this.domain + "tarefas",  atividade)
    	    .done(function(msg){ 			        				
			_this.persistencia.lista = (msg);//guardando na lista
			_this.persistencia.listaListener.notify(msg); //enviando para os observadores  					
	  		alert("Criado com sucesso") }
	  	    )
        .fail(function(xhr, status, error) {
            alert("alguma falha");
            alert(xhr.responseText);
	        }
        )
	}	
	
	this.remover = function(id){	
	    var _this=this;
		$.ajax({
			url: this.domain + "tarefas/"+id,
			method: 'DELETE',
			contentType: 'application/json',
			success: function(result) {
				_this.persistencia.lista.push(result);//guardando na lista
				_this.persistencia.listaListener.notify(result); //enviando para os observadores  					
				alert("Removido com sucesso")
			},
			error: function(request,msg,error) {
				alert("alguma falha");
				alert(request.responseText);
			}
		});						   
	}
	this.limpar = function(){
        //var uuid = persistencia.getUUID();
		var _this = this;
    	$.get( this.domain + "limpartarefas",  function(data, status){
    	    _this.persistencia.lista = [];
        	_this.persistencia.listaListener.notify([]);
			
        	Materialize.toast(data, 4000);
    	});
	}
   	this.listarTodos  = function (){	
	    var _this = this;
		$.get(this.domain + "tarefas", function(data, status){
			_this.persistencia.lista = data;
        	_this.persistencia.listaListener.notify(data);
    	});
	}
	
};