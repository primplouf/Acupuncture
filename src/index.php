<?php
include 'vendor/autoload.php';
include 'router/Route.class.php';

/*
try {
    // le dossier ou on trouve les templates
    $loader = new Twig\Loader\FilesystemLoader('view');

    // initialiser l'environement Twig
    $twig = new Twig\Environment($loader);

    // load template
    $template = $twig->load('accueil.html');

    // set template variables
    // render template
    echo $template->render(array(
        'lundi' => 'Steak Frites',
        'mardi' => 'Raviolis',
        'mercredi' => 'Pot au Feu',
        'jeudi' => 'Couscous',
        'vendredi' => 'Poisson',
    ));

} catch (Exception $e) {
    die ('ERROR: ' . $e->getMessage());
}
*/
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