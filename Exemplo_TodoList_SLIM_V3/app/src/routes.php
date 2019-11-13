<?php

// Routes

/*
  $app->get('/[{name}]', function ($request, $response, $args) {
  if($args['userid'] == "tarefas"){
  }
  return $this->renderer->render($response, 'index.phtml', $args);
  }); */

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

$app->post('/login', function ($request, $response) {
    $input = $request->getParsedBody();

    $sql = "select  * from user where email=:email and password:=password";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("email", $input['email']);
    
    $options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
    ];
    $passwd = password_hash($input['password'], PASSWORD_BCRYPT, $options);    
    $sth->bindParam("password", $passwd);
    $sth->execute();
    $todos = $sth->fetchAll();
    if(count($todos)>0){
        $_SESSION['USER'] = $todos[0]->email;        
        return $this->response;
    }
    else{  
        $app->response->setStatus(400);   
        $app->response->headers->set('Content-Type', 'application/json');    
        return $app->response;
    }
});

