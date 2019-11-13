<?php
 //Application middleware

 //e.g: $app->add(new \Slim\Csrf\Guard);



$slimSettings = array('determineRouteBeforeAppMiddleware' => true);
$slimConfig = array('settings' => $slimSettings);
$app = new Slim\App($slimConfig);

 //Check the user is logged in when necessary.
$loggedInMiddleware = function ($request, $response, $next) {
    
   
    
    $route = $request->getAttribute('route');
    var_dump($route->getMethods());
    
    //var_dump($route);    
    $routeName = $route->getName();
    var_dump($routeName);    
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
        'register-post',
        'public/tarefas'
    );

   
    if (!in_array($routeName, $publicRoutesArray))
    //if (!isset($_SESSION['USER']) && !in_array($routeName, $publicRoutesArray))
    {
        // redirect the user to the login page and do not proceed.
        //$response = $response->withRedirect('/login');
    }
    else
    {
         // Proceed as normal...
        $response = $next($request, $response);
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