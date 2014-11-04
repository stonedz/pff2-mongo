<?php
/**
 * User: paolo.fagni@gmail.com
 * Date: 03/11/14
 * Time: 23.22
 */

namespace pff\modules;

use pff\Abs\AModule;
use pff\Iface\IConfigurableModule;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

class Pff2Mongo extends AModule implements IConfigurableModule {

    private $_server, $_dbName;

    public function __construct($confFile = 'pff2-mongo/module.conf.local.yaml') {
        $this->loadConfig($confFile);
    }

    /**
     * @param array $parsedConfig
     * @return mixed
     */
    public function loadConfig($parsedConfig) {
        $conf = $this->readConfig($parsedConfig);
        $this->_server = $conf['moduleConf']['server'];
        $this->_dbName = $conf['moduleConf']['dbName'];

        $this->_app->getConfig()->setConfig('mongo_server', $this->_server);
        $this->_app->getConfig()->setConfig('mongo_dbName', $this->_dbName);
    }
}
