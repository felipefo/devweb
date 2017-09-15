
function AtividadeVisao(persistencia){
	
	this.persistencia = persistencia;
	var _this = this;

	this.limpar = function (){
		var lista = document.getElementById("listaAtividades");
	}
    this.getAtividade = function(){
        var atividade  = new Atividade();
        var inputAtividade = document.getElementById("atividade").value;
        atividade = new Atividade(inputAtividade, atividade.tiposStatus.aFazer);
        return atividade;
    }
	this.carregarTudo = function(){
		var listas = _this.persistencia.getLista();	
		var lista = document.getElementById("listaAtividades");
		lista.innerHTML = "";
		var listaInputs = lista.innerHTML ;
		for(var key in listas) {
			var atividade = listas[key];	
			 var input = "";
			if(atividade.status == 0)
			    input = '<input type="checkbox" onclick="atualizar(this);" id="'  + atividade.id +  '" name="afazer" value="' +  atividade.descricao + '"> <label for="' +   atividade.id + '"> ' +  atividade.descricao + '</label><br>';
			else
			    input = '<input type="checkbox" onclick="atualizar(this);" id="'  + atividade.id +  '" name="concluido" value="' +  atividade.descricao + '" checked> <label for="' +   atividade.id + '"> ' +  atividade.descricao + '</label><br>';
			listaInputs += input;	
		}
		lista.innerHTML = listaInputs;	
	}

}

