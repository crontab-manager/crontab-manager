<?php
use exporter\config\config;
use exporter\parser\parser;
use Pimple\Container;

require_once 'vendor/autoload.php';

$container = new Container();

try {
    $config = new config();
} catch (\Exception $e) {
    exceptionhandler::handler("Unable to init config",$e);
}

$container['config'] = $config;

$parser = new parser();

foreach ($config->getServers() as $server => $serverconfig) {
    echo "Servername: ".$serverconfig['servername']."\n";
    echo "IP        : ".$serverconfig['serverip']."\n";
    $crontab = \exporter\ssh\ssh::getCrontabFromRemoteServer($serverconfig['serverip'],'root');
    $crontab_parsed = $parser->getParsedCrontab($crontab);
    print_r($crontab_parsed);
}



