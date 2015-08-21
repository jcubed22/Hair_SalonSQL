<?php

    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Stylist.php';
    require_once __DIR__.'/../src/Client.php';

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    //Home page
    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Creates a new stylist and returns to home page.
    $app->post('/add_stylist', function() use ($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();

        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //Deletes all stylists, returns to home page.
    $app->post('/delete_stylists', function() use($app) {
        Stylist::deleteAll();

        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get('/stylists/{id}', function($id) use ($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->post('/add_client', function() use ($app) {
        $c_name = $_POST['name'];
        $phone = $_POST['phone'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($c_name, $phone, $id = null, $stylist_id);
        $client->save();

        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
    });

    $app->get('/clients/{id}', function($id) use ($app) {
        $client = Client::find($id);
        $stylists = Stylist::getAll();

        return $app['twig']->render('client.html.twig', array('client' => $client, 'stylists' => $stylists));
    });

    $app->patch('/update_client', function() use ($app) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $stylist_id = $_POST['stylist_id'];
        $client_id = $_POST['client_id'];

        $stylists = Stylist::getAll();
        $client = Client::find($client_id);
        $client->update_client($name, $phone, $client_id, $stylist_id);

        return $app['twig']->render('client.html.twig', array('client' => $client, 'stylists' => $stylists));
    });

    return $app;

?>
