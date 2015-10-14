<?php
require_once 'vendor/autoload.php';


use exporter\config\config;
use exporter\parser\parser;
use Pimple\Container;
use Ulrichsg\Getopt\Getopt;
use Ulrichsg\Getopt\Option;



$getopt = new Ulrichsg\Getopt\Getopt(array(
    new Option('m', 'mode', Getopt::REQUIRED_ARGUMENT),
    new Option('t', 'todo', Getopt::OPTIONAL_ARGUMENT)
));
$getopt->parse();

// print_r($getopt);

$container = new Container();

try {
    $config = new config();
} catch (\Exception $e) {
    exceptionhandler::handler("Unable to init config",$e);
}

$container['config'] = $config;

$parser = new parser();
$arrayallcrontabs = array();

foreach ($config->getServers() as $server => $serverconfig) {
    echo "Servername: " . $serverconfig['servername'] . "\n";
    echo "IP        : " . $serverconfig['serverip'] . "\n";
    $crontab = \exporter\ssh\ssh::getCrontabFromRemoteServer($serverconfig['serverip'], 'root');
    $crontab_parsed = $parser->getParsedCrontab($crontab);
    echo "Array aus getParsedCrontab: ";
    $arrayallcrontabs = array_merge($arrayallcrontabs, $crontab_parsed);
}
//print_r($crontab_parsed);
print_r($arrayallcrontabs);
echo "\n";

$testdb = new exporter\objects\db\job();

/*
foreach ($arrayallcrontabs as $group) {
    $JobGroup = new objects\db\JobGroup();
    $JobGroup->setGroupComment($group['groupcomment']);
    foreach ($group['jobs'] as $job) {
        $jobObj = new objects\db\job();
        $jobObj->setComment($job['comment']);
        $jobObj->setCommentInactive($job['comment_inactive']);
        $jobObj->setTime($job);
        $jobObj->setCommand($job);
        $jobList[]=$jobObj;
    }
}
print_r($joblist);
*/




