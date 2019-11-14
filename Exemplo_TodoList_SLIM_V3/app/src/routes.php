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

$app->get('/tasks', function ($request, $response, $args) {
    header("Access-Control-Allow-Origin: *");
    $sth = $this->db->prepare("SELECT * FROM task");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});


$app->get('/tasks/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM task WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $todos = $sth->fetchObject();
    return $this->response->withJson($todos);
});



$app->delete('/tasks/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("delete FROM task WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();

    $sth = $this->db->prepare("SELECT * FROM task");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

$app->post('/tasks', function ($request, $response) {
    $input = $request->getParsedBody();

    $sql = "INSERT INTO task (description, status) VALUES (:description,:status )";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("status", $input['status']);
    $sth->bindParam("description", $input['description']);
    $sth->execute();

    $sth = $this->db->prepare("SELECT * FROM task");
    $sth->execute();
    $todos = $sth->fetchAll();
    return $this->response->withJson($todos);
});

$app->post('/login', function ($request, $response) {
    
    $session = new Session();
    $app->responseset('user', "felipefo@gmail.com");
    $app->responsewithRedirect('/public/www/index.html');
    //return $response;
    
    /*$_SESSION['USER'] = $todos[0]->email;    
    
    
    $input = $request->getParsedBody();

    $sql = "select * from user where email=:email and password:=password";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("email", $input['email']);    
   /* $options = [
    'cost' => 11,
    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
    ];
    $passwd = password_hash($input['password'], PASSWORD_BCRYPT, $options);    
    $sth->bindParam("password", $input['password']);
    $sth->execute();
    $todos = $sth->fetchAll();
    if(count($todos)>0){
        $_SESSION['USER'] = $todos[0]->email;        
        $response = $response->withRedirect('/public/www/index.html');
    }
    else{  
        $app->response->setStatus(400);   
        $app->response->headers->set('Content-Type', 'application/json');    
        return $app->response;
    }*/
});

