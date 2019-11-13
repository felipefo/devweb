<?php
// Routes

/*
$app->get('/[{name}]', function ($request, $response, $args) {
   if($args['userid'] == "tarefas"){
   }
    return $this->renderer->render($response, 'index.phtml', $args);
});*/

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app->get('/tarefas', function ($request, $response, $args) {
		header("Access-Control-Allow-Origin: *");
        $sth = $this->db->prepare("SELECT * FROM tarefas");
        $sth->execute();
        $todos = $sth->fetchAll();
       return $this->response->withJson($todos);
    });
    

    $app->get('/tarefas/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM tarefas WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $this->response->withJson($todos);
    });
    
	$app->delete('/tarefas/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("delete FROM tarefas WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
       
	    $sth = $this->db->prepare("SELECT * FROM tarefas");    
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
	   
	   
    });
	
    
    $app->post('/tarefas', function ($request, $response) {		
        $input = $request->getParsedBody();
		
        $sql = "INSERT INTO tarefas (descricao, status) VALUES (:descricao,:status )";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("status", $input['status']);
        $sth->bindParam("descricao", $input['descricao']);
        $sth->execute();
		
		$sth = $this->db->prepare("SELECT * FROM tarefas");    
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
		        
    });
    
    
    $app->group('', function () {
	$this->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
	$this->post('/auth/signup', 'AuthController:postSignUp');

	$this->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
	$this->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));
    
    
//});
