//bibliotecas que compartilhando o cache atraves de varias instancias do node.
var cluster = require('cluster');
var myCache = require('cluster-node-cache')(cluster, {stdTTL: 60*25, checkperiod: 4000});
var http = require('http');
var numCPUs = require('os').cpus().length;
//http.globalAgent.maxSockets = 30;

if (cluster.isMaster) {
    console.log("master start...");
    // Fork workers.
    for (var i = 0; i < numCPUS; i++) {
        cluster.fork();
    }
    cluster.on('listening',function(worker,address){
        console.log('listening: worker ' + worker.process.pid +', Address: '+address.address+":"+address.port);
    });
    cluster.on('exit', function(worker, code, signal) {
        if (worker.suicide == true)
            console.log('worker ' + worker.process.pid + ' suicide');
        else
            console.log('worker ' + worker.process.pid + ' died');
    });
} else {
    // this is suicide
    // cluster.worker.kill();
    // this is died
    // process.exit();
	http.createServer((request, response) => {
	var method = request.method; 
	var url = request.url;		
	if(method == "GET"){
	//consultando uma informacao no cache dado uma lista de ids sperados por virgula
	//ex. http://127.0.0.1:8081/ids/3,4,5
	var param = url.split('/');
	var jsonResposta = {};
	if(param[1] == 'ids'){		
		var listaIds = param[2].split(",");
		myCache.get(listaIds).then(function(results) {
			if(results.err) {
				console.log(results.err);
				response.end(results.err); 	
			} else {
				console.log(results.value);
				response.end(JSON.stringify(results.value)); 	
			}
		});		
	//criando informacao no cache para testes somente	
	}else if(param[1] == 'create'){
		//para testes somente
		console.log("3");
		//myCache.set( '3' , { "id" : "3" , "hora":"15:00" } , 2000000 , function( err, success ){
		myCache.set( '3' , { "id" : "3" , "hora":"15:00" } , 200).then(function(result) {				
			console.log(result.success);
		});
			
		myCache.set( '101' , { "id" : "101" , "hora":"16:00" } , 200).then(function(result) {			
			console.log(result.success);
		});		
		response.end(""); 	
	}    
  }
  //inserindo uma informacao no cache para posterior consulta.
  else if(method == "POST" ){
	 console.log(url);	 
	 request.on('data', function(data) {
            console.log(data);
			var json  = JSON.parse(data);			            
			console.log(json['id']);
			var timeout = json['timeout'] * 1000 * 60;
			myCache.set( json['id'] , json , timeout).then(function(result) {				
				console.log(result.success);
			});
			response.end("ok");  
        })	 		
  }
  
  }).listen(8081);
		

}