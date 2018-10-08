<?php
require __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

require __DIR__ . '/src/helpers/global-functions.php';

$protocol = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : "http";

$url = $protocol . '://' . $_SERVER['SERVER_NAME'];
if ($_SERVER['SERVER_PORT'] != 80) {
    $url .= ':' . $_SERVER['SERVER_PORT'];
}
$url .= '/';

define('URL', $url);

define("TMP", __DIR__ . '/tmp');

$loader = new Twig_Loader_Filesystem([__DIR__ . '/views', __DIR__ . '/templates']);
$twig = new Twig_Environment($loader, array(
    'cache' => __DIR__ . '/cache/views',
    'auto_reload' => true,
));

$config = new GeeksAreForLife\Config\Config();
$config->load(__DIR__ . '/config.json', __DIR__ . '/config-default.json');

// we will get this from the installed providers later
$providers = [];
$serviceNames = [];

foreach ($config->getValue('providers') as $provider)
{
	$provider = Acorn\Providers\Factory::loadProvider($provider['namespace'], $config);
	$providers[$provider->getName()] = $provider;
	$serviceNames[] = $provider->getName();
}

asort($serviceNames);

$twig->addGlobal('services', $serviceNames);