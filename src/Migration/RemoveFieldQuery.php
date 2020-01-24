<?php
/**
 *
 *
 * @category  Aligent
 * @package
 * @author    Adam Hall <adam.hall@aligent.com.au>
 * @copyright 2018 Aligent Consulting.
 * @license
 * @link      http://www.aligent.com.au/
 */

namespace Aligent\ABNBundle\Migration;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Types\Type;
use Oro\Bundle\EntityConfigBundle\Migration\RemoveFieldQuery as BaseRemoveFieldQuery;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendHelper;
use Psr\Log\LoggerInterface;

class RemoveFieldQuery extends BaseRemoveFieldQuery
{

    public function execute(LoggerInterface $logger)
    {
        parent::execute($logger);

        $this->removeEntityConfig($logger);
    }

    protected function removeEntityConfig($logger)
    {
        $entityRow = $this->getEntityRow($this->entityClass);
        if (!$entityRow) {
            $logger->info("Entity '{$this->entityClass}' not found");

            return;
        }
        $entityData = $this->connection->convertToPHPValue($entityRow['data'], Type::TARRAY);

        if(isset($entityData['extend']['schema']['property'][$this->entityField])) {
            unset($entityData['extend']['schema']['property'][$this->entityField]);
        }

        if(isset($entityData['extend']['index'][$this->entityField])) {
            unset($entityData['extend']['index'][$this->entityField]);
        }

        $extendClass = ExtendHelper::getExtendEntityProxyClassName($this->entityClass);
        if(isset($entityData['extend']['schema']['doctrine'][$extendClass]['fields'][$this->entityField])) {
            unset($entityData['extend']['schema']['doctrine'][$extendClass]['fields'][$this->entityField]);
        }

        $this->updateEntityData($logger, $entityData, $this->entityClass);
    }

    /**
     * @param string $entityClass
     *
     * @return array
     */
    protected function getEntityRow($entityClass)
    {
        $getEntitySql = 'SELECT e.data 
                FROM oro_entity_config as e 
                WHERE e.class_name = ? 
                LIMIT 1';

        return $this->connection->fetchAssoc(
            $getEntitySql,
            [$entityClass]
        );
    }

    /**
     * @param LoggerInterface $logger
     * @param array           $entityData
     * @param string          $entityClass
     *
     * @throws DBALException
     */
    protected function updateEntityData(
        LoggerInterface $logger,
        $entityData,
        $entityClass
    ) {

        $data = $this->connection->convertToDatabaseValue($entityData, Type::TARRAY);

        $this->executeQuery(
            $logger,
            'UPDATE oro_entity_config SET data = ? WHERE class_name = ?',
            [
                $data,
                $entityClass
            ]
        );
    }
}