<?php
include 'vendor/autoload.php';
include 'router/Route.class.php';



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
        echo $twig->render('accueil.twig');
    }
    
} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}

$routes = [];

$controllers = array_diff(scandir("controllers/"), array('..', '.'));
foreach($controllers as $controller){
    $path = 'controllers/'.$controller;
    $classname = get_classname($path);
    require_once($path);
    $relexionAttributes = (new ReflectionClass($classname))->getAttributes(Route::class);
    print_r($relexionAttributes);
    var_dump((new ReflectionClass($classname))->getMethods()[0]->getAttributes(Route::class)[0]->newInstance());die;
    foreach($relexionAttributes as $reflexionAttribute){
        $route = $reflexionAttribute->newInstance();
        var_dump($route);
        array_push($routes, $route);
    }
}
var_dump($routes);

function get_classname($file){
    $fp = fopen($file, 'r');
    $class = $buffer = '';
    $i = 0;
    while (!$class) {
        if (feof($fp)) break;

        $buffer .= fread($fp, 512);
        $tokens = token_get_all($buffer);

        if (strpos($buffer, '{') === false) continue;

        for (;$i<count($tokens);$i++) {
            if ($tokens[$i][0] === T_CLASS) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if ($tokens[$j] === '{') {
                        $class = $tokens[$i+2][1];
                    }
                }
            }
        }
    }
    return $class;
}