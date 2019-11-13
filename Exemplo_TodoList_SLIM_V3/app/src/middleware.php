<?php
 //Application middleware

 //e.g: $app->add(new \Slim\Csrf\Guard);

$slimSettings = array('determineRouteBeforeAppMiddleware' => true);
$slimConfig = array('settings' => $slimSettings);
$app = new Slim\App($slimConfig);

 //Check the user is logged in when necessary.
$loggedInMiddleware = function ($request, $response, $next) {
    
    return $this->response->withJson($request);
    if(strcmp($request->getPath(), "public/login") == 0 || isset($_SESSION['USER'])){
        $response = $next($request, $response); //cadeia de responsabilidade.
        
    }    
    else {
        // redirect the user to the login page and do not proceed.
        $response = $response->withRedirect('/public/www/login.html');
    }
    return $response;
};

 //Apply the middleware to every request.
$app->add($loggedInMiddleware);


 //Define app routes

 //Show the logged in dashboard page
$app->get('/', function (Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    // redirect the user to the logged in page.
    $homeController = new HomeController($request, $response, $args);
    return $homeController->index();
})->setName('home');


 //Show the login page
$app->get('/login', function (Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    $homeController = new HomeController($request, $response, $args);
    return $homeController->index();
})->setName('login');

//});