
function Persistencia(){
	this.storage;
	this.local = false;	
	this.listaListener = new Event(this);
	this.lista = new Array();
	
	this.setEstrategiaPersistencia = function (tipo){
		if(tipo === "remota"){
			this.storage = new PersistenciaWS(this);
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
	this.listarTodos =  function(){	
		this.lista=new Array();
	    this.storage.listarTodos();
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