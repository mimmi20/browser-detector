<?php
declare(ENCODING = 'utf-8');

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

use Doctrine\ORM\Tools\EntityGenerator;

ini_set('display_errors', 1);

$libPath = realpath(__DIR__ . '/../library');

// autoloaders
require_once $libPath . '/Doctrine/Common/ClassLoader.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', $libPath);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
$classLoader->register();

// config
$config = new \Doctrine\ORM\Configuration();
$config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(realpath(__DIR__ . '/../application/Model/Entities')));
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setProxyDir(realpath(__DIR__ . '/../application/Model/Proxies'));
$config->setProxyNamespace('Model\Proxies');
$config->addEntityNamespace('', 'Model\Entities');
$config->setAutoGenerateProxyClasses(true);


$connectionParams = array(
    'dbname' => 'browscap',
    'user' => 'root',
    'password' => 'mimmi',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

$em = \Doctrine\ORM\EntityManager::create($connectionParams, $config);

// custom datatypes (not mapped for reverse engineering)
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
$em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

// fetch metadata
$driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
    $em->getConnection()->getSchemaManager()
);
$classes = $driver->getAllClassNames();


$em->getConfiguration()->setMetadataDriverImpl($driver);
$cmf = new \Doctrine\ORM\Tools\DisconnectedClassMetadataFactory();
$cmf->setEntityManager($em);

foreach ($classes as $class) {
    //any unsupported table/schema could be handled here to exclude some classes
    if (true) {
        $metadata[] = $cmf->getMetadataFor($class);
    }
}

$generator = new EntityGenerator();
$generator->setUpdateEntityIfExists(true);
$generator->setGenerateStubMethods(true);
$generator->setGenerateAnnotations(true);
$generator->generate($metadata, realpath(__DIR__ . '/../application/Model/Entities'));

print 'Done!';


