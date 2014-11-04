<?php
/**
 * User: paolo.fagni@gmail.com
 * Date: 04/11/14
 * Time: 11.26
 */

namespace pff\modules\Abs;

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use pff\Abs\AController;
use pff\App;
use pff\Traits\ControllerTrait;

abstract class AControllerODM extends AController {
    use ControllerTrait;

    /**
     * @var DocumentManager
     */
    public $_dm;

    /**
     * @param string $controllerName
     * @param App $app
     * @param string $action
     * @param array $params
     */
    public function __construct($controllerName,App $app, $action = 'index', $params = array()) {
        parent::__construct($controllerName, $app, $action, $params);
        $this->initDm();
    }

    private function initDm() {


        $config = new Configuration();
        $conn   = new Connection($this->_config->getConfigData('mongo_server'));

        $config->setProxyDir(ROOT . DS . 'app' . DS.  'proxies');
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir(ROOT . DS . 'app' . DS .  'hydrators');
        $config->setHydratorNamespace('Hydrators');
        $config->setDefaultDB($this->_config->getConfigData('mongo_dbName'));

        $config->setMetadataDriverImpl(AnnotationDriver::create(ROOT. DS . 'app'.DS . 'models'));
        AnnotationDriver::registerAnnotationClasses();

        $this->_dm = DocumentManager::create($conn, $config);

    }

    /**
     * @return DocumentManager
     */
    public function getDm() {
        return $this->_dm;
    }

    /**
     * @param DocumentManager $dm
     */
    public function setDm($dm) {
        $this->_dm = $dm;
    }
}