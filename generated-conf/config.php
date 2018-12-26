<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('cra_2', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'classname' => 'Propel\\Runtime\\Connection\\ConnectionWrapper',
  'dsn' => 'mysql:host=mysql.latecoere.gl;dbname=cra_2',
  'user' => 'berto',
  'password' => 'lotti',
  'model_paths' =>
  array (
    0 => 'src',
    1 => 'vendor',
  ),
));
$manager->setName('cra_2');
$serviceContainer->setConnectionManager('cra_2', $manager);
$serviceContainer->setDefaultDatasource('cra_2');