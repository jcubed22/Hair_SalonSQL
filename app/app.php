<?php

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Stylist.php';

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // use Symfony\Component\HttpFoundation\Request;
    // Request::enableHttpMethodParamterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post('/add_stylist', function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();

        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post('/delete_stylists', function() use($app) {
        Stylist::deleteAll();

        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    


    return $app;

?>
