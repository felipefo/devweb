function AtividadePersistencia(){

	this.storage;
	this.listaAdded = new Event(this);
	this.lista = new Array();
	this.local = false;
	
	this.setEstrategiaPersistencia = function (tipo){
		if(tipo === "remota"){
			this.storage = new AtividadeWS(this);
		}else {
			this.storage = new PersistenciaLocal(this);
		}
	}

	this.limpar = function(){	
	        this.storage.limpar();    
	}
	this.salvar =  function(atividade){	
	        this.storage.salvar(atividade);        
	}
	this.getLista = function (){
		return this.lista;
	}
	this.listarTodos =  function(){			
	    this.storage.listarTodos(this);
	}	
	this.getUUID = function (){
	    var uuid = "0001"//so para testes no navegador localmente
    	try{
    		 uuid = device.uuid;
    	}catch(ex){
    		console.log(ex);
    	}
    	return uuid;
	    
	}
}

