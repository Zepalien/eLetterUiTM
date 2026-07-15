<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        $builder->connect('/', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/pages/*', 'Pages::display');

        // AJAX: load template data by ID
        $builder->get('/letter-templates/get-template/:id',
            ['controller' => 'LetterTemplates', 'action' => 'getTemplate']);

        $builder->fallbacks();
    });
};