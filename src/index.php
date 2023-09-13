<?php
include 'vendor/autoload.php';

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