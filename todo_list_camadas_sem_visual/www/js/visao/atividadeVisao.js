
function AtividadeVisao(){
	this.limparTudo = function (){
		var lista = document.getElementById("listaAtividades");
		lista.innerHTM = "";
		alert("Atividades removidas com sucesso");				
	}
	this.limparInput = function (){
		document.getElementById("atividade").value = "";	
	}
    this.getNovaAtividade = function(){
        var atividade={};
        var input = document.getElementById("atividade");		
		atividade.descricao = input.value;                
	    atividade.id = Math.floor(Math.random() * 1000000000);
		return atividade;
    }	
	this.getAtividade = function(input){		
		var atividade={};
		atividade.descricao = input.value;
		atividade.id = input.id;		
		if (input.checked){							
			atividade.status = 1;						
		}else{
			atividade.status = 0;						
		}			
		return atividade;
	}
	this.carregarTudo = function(listas){		
		listaTeste = listas;
		var lista = document.getElementById("listaAtividades");
		lista.innerHTML = "";
		var listaInputs="";
		console.log(listas);
		for(var key in listas) {
			console.log("key:" +key);
			var atividade = listas[key];	
			console.log("atividade:" + atividade);
			var input = "";			
			var remove = '<button style="margin-left:20px;" onclick="controle.remover('+atividade.id+');" >Remover</button>';			
			if(atividade.status == 0){
			    input = '<input type="checkbox" onclick="controle.salvar(this);" id="'  + 
				atividade.id +  '" name="afazer" value="' +  atividade.descricao + '"> <label for="' +   
				atividade.id + '"> ' +  atividade.descricao + '</label>' + remove +  '<br>';
			}else{
			    input = '<input type="checkbox" onclick="controle.salvar(this);" id="'  + 
				atividade.id +  '" name="concluido" value="' +  atividade.descricao + '" checked> <label for="' 
				+   atividade.id + '"> ' +  atividade.descricao + '</label>'+ remove + '<br>';
				
			}
			listaInputs += input;	
		}
		lista.innerHTML = listaInputs;	
	}

}

