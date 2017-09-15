

function Atividade( descricao, status, id){    
    
	this.tiposStatus = { "aFazer" : 0 , "concluido" : 1};	
	this.descricaoStatus =[ "A fazer" , "Concluido"];				
	this.id = id;	
	this.descricao = descricao;
	this.status = status;		
	if(arguments.length  == 2){
        this.id = Math.floor(Math.random() * 1000000000);
    }
	this.toAtividade  = function (jsonObject){	
		var atividadeJSON = JSON.parse(jsonObject);
		if(atividadeJSON != null)
	    var atividade = new Atividade(atividadeJSON.descricao, atividadeJSON.status, atividadeJSON.id);
		return atividade;
	}
	this.getStatus = function (){
		return this.descricaoStatus[this.status];
	}
	this.toString = function (){	
		var atividadeJSON = {"status": this.status, "descricao": this.descricao, "id": this.id };
		return JSON.stringify(atividadeJSON);	
	};	
}
