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



$slimSettings = array('determineRouteBeforeAppMiddleware' => true);


$slimConfig = array('settings' => $slimSettings);
$app = new Slim\App($slimConfig);

// Check the user is logged in when necessary.
$loggedInMiddleware = function ($request, $response, $next) {
    $route = $request->getAttribute('route');
    $routeName = $route->getName();
    $groups = $route->getGroups();
    $methods = $route->getMethods();
    $arguments = $route->getArguments();

    # Define routes that user does not have to be logged in with. All other routes, the user
    # needs to be logged in with.
    $publicRoutesArray = array(
        'login',
        'post-login',
        'register',
        'forgot-password',
        'register-post'
    );

    if (!isset($_SESSION['USER']) && !in_array($routeName, $publicRoutesArray))
    {
        // redirect the user to the login page and do not proceed.
        $response = $response->withRedirect('/login');
    }
    else
    {
        // Proceed as normal...
        $response = $next($request, $response);
    }

    return $response;
};

// Apply the middleware to every request.
$app->add($loggedInMiddleware);


// Define app routes

// Show the logged in dashboard page
$app->get('/', function (Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    // redirect the user to the logged in page.
    $homeController = new HomeController($request, $response, $args);
    return $homeController->index();
})->setName('home');


// Show the login page
$app->get('/login', function (Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    $homeController = new HomeController($request, $response, $args);
    return $homeController->index();
})->setName('login');

//});
