<?php
// Routes

/*
$app->get('/[{name}]', function ($request, $response, $args) {
   if($args['userid'] == "tarefas"){
   }
    return $this->renderer->render($response, 'index.phtml', $args);
});*/


$app->get('/tarefas', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM tarefas");
        $sth->execute();
        $todos = $sth->fetchAll();
       return $response->withJson($todos);
    });
    

$app->get('/tarefas/[{userid}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM tarefas WHERE userid=:userid");
        $sth->bindParam("userid", $args['userid']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $response->withJson($todos);
    });        
    $app->post('/tarefas', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO tarefas (descricao, userid) VALUES (:descricao,:userid )";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("userid", $input['userid']);
        $sth->bindParam("descricao", $input['descricao']);
        $sth->execute();        
        return $response;
    });
        
//});
