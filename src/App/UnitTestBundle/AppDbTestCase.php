<?php
namespace App\UnitTestBundle;

use Doctrine\ORM\EntityManager;

class AppDbTestCase extends AppTestCase
{
    /**
     * @var string
     */
    protected static $fixture;

    /**
     * @var bool
     */
    protected static $fixtureLoad = true;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private static $entityManager;

    public static function setUpBeforeClass()
    {
        try {
            self::initProperties();
            self::$entityManager = self::getContainer()->get('doctrine')->getManager();
            self::rebuildDatabase();
        } catch (Exception $e) {
            throw $e; // so the tests will be skipped
        }
    }

    public static function rebuildDatabase()
    {
        try {
            self::getContainer()->get('database_connection')->getSchemaManager()->listDatabases();
        } catch (\PDOException $e) {
            static::runConsole('doctrine:database:create', []);
        }

        static::runConsole('doctrine:schema:drop', ['--force' => true]);
        static::runConsole('doctrine:schema:create', ['--no-interaction' => true]);

        if (self::$fixtureLoad) {
            $options = ['-n' => true];

            if (self::$fixture) {
                $options['--fixtures'] = self::$fixture;
            }

            //static::runConsole('doctrine:fixtures:load', $options);
        }
    }

    public static function getRepository($entityName)
    {
        return self::getEntityManager()->getRepository($entityName);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function getEntityManager()
    {
        return self::$entityManager;
    }

    public static function getMockEntityManager($em = null)
    {
        if (is_null($em)) {
            $em = self::getEntityManager();
        }

        $reflection = new \ReflectionClass($em);
        $prop = $reflection->getProperty('eventManager');
        $prop->setAccessible(true);
        $eventManager = $prop->getValue($em);

        /** @var \Symfony\Bridge\Doctrine\ContainerAwareEventManager $eventManager */
        $reflection = new \ReflectionClass($eventManager);
        $prop = $reflection->getProperty('listeners');
        $prop->setAccessible(true);
        $prop->setValue($eventManager, []);

        return $em;
    }

    public static function loadFixtures($fixtures = null, array $options = [])
    {
        $defaultOptions = ['-n' => true];

        if ($fixtures) {
            $appRootDir = dirname(self::$kernel->getRootDir());
            if (strpos($fixtures,  $appRootDir) === false) {
                $fixtures = $appRootDir.'/'.ltrim($fixtures, '/');
            }

            $defaultOptions['--fixtures'] = $fixtures;
        }

        $options = array_merge($options, $defaultOptions);
        static::runConsole('doctrine:fixtures:load', $options);
    }

    public function insert($entityName, array $values, array $columns = [])
    {
        $meta = self::getEntityManager()->getClassMetadata($entityName);
        $connection = self::getEntityManager()->getConnection();

        if (empty($columns)) {
            $columns = $this->getColumns($entityName);
            array_shift($columns);
        }

        $cntColumns = count($columns);
        $result = [];
        foreach ($values as $value) {
            $cntValue = count($value);
            if ($cntColumns > $cntValue) {
                $value = array_merge($value, array_fill($cntValue - 1, $cntColumns - $cntValue, null));
            }
            $value = array_combine($columns, $value);
            $connection->insert($meta->getTableName(), $value);
            $result[] = $connection->lastInsertId();
        }
        return $result;
    }

    public function getColumns($entityName)
    {
        $meta = self::getEntityManager()->getClassMetadata($entityName);
        $columns = $meta->getColumnNames();
        foreach ($meta->getAssociationNames() as $fieldName) {
            $columns[] = $meta->getSingleAssociationJoinColumnName($fieldName);
        }
        return $columns;
    }

    public function update($entityName, array $values, array $columns = [])
    {
        $meta = self::getEntityManager()->getClassMetadata($entityName);
        $connection = self::getEntityManager()->getConnection();

        if (empty($columns)) {
            $columns = $this->getColumns($entityName);
            array_shift($columns);
        }

        $cntColumns = count($columns);
        $result = [];
        foreach ($values as $value) {
            $cntValue = count($value);
            if ($cntColumns > $cntValue) {
                $value = array_merge($value, array_fill($cntValue - 1, $cntColumns - $cntValue, null));
            }
            $value = array_combine($columns, $value);
            $identifier = ['id' => $value['id']];
            unset($value['id']);
            $connection->update($meta->getTableName(), $value, $identifier);
            $result[] = $connection->lastInsertId();
        }
        return $result;
    }

    /**
     * Truncate tables by entity names array
     * @param array || string $entityNames
     */
    public function truncate($entityNames)
    {
        if (!is_array($entityNames)) {
            $entityNames = [$entityNames];
        }

        foreach ($entityNames as $entityName) {
            $meta = self::getEntityManager()->getClassMetadata($entityName);

            $connection = self::getEntityManager()->getConnection();
            $connection->executeUpdate(
                sprintf('DELETE FROM `%s`;', $meta->getTableName())
            );
            $connection->executeUpdate(
                sprintf('ALTER TABLE `%s` AUTO_INCREMENT = 1;', $meta->getTableName())
            );
        }
    }
}
