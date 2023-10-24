<?php

require_once("vendor/autoload.php");
require_once("router/Router.class.php");

define("CONTROLLERS_PATH", "controllers/");

$router = new Router();
$router->loadRoutes(CONTROLLERS_PATH);
$router->matchRoute($_SERVER['REQUEST_URI']);

try {
    // le dossier ou on trouve les templates
    $loader = new Twig\Loader\FilesystemLoader('views');

    // initialiser l'environement Twig
    $twig = new Twig\Environment($loader);

    // load template
    if(isset($_GET["page"])) {
        $page = htmlspecialchars($_GET["page"]);
        switch ($page) {
            case 'accueil':
                echo $twig->render('accueil.twig');
                break;
            case 'recherchePathologie':
                echo $twig->render('recherchePathologie.twig');
                break;
            case 'filtrePathologie':
                echo $twig->render('filtrePathologie.twig');
                break;
            case 'keywords':
                echo $twig->render('keywords.twig');
                break;
            case 'inscription':
                echo $twig->render('inscription.twig');
                break;
            case 'connexion':
                echo $twig->render('connexion.twig');
                break;
            
            default:
                header('HTTP/1.0 404 Not Found');
                echo $twig->render('404.twig');
                break;
        }
    } else {
        echo $twig->render('connexion.twig');
    }
    
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}

?>