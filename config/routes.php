<?php
use Cake\Routing\Router;

Router::plugin('Pcaptcha', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
