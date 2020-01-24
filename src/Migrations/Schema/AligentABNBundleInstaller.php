<?php
/**
 * @category  Aligent
 * @package
 * @author    Chris Rossi <chris.rossi@aligent.com.au>
 * @copyright 2020 Aligent Consulting.
 * @license
 * @link      http://www.aligent.com.au/
 */
namespace Aligent\ABNBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityBundle\EntityConfig\DatagridScope;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AligentABNBundleInstaller implements Installation
{
    /**
     * @inheritDoc
     */
    public function getMigrationVersion()
    {
        return 'v1_3';
    }

    /**
     * @inheritDoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable('oro_customer');

        // In case the business number has already been added to the customer entity
        if (!$table->hasColumn('business_number')) {
            $table->addColumn('business_number', 'string', [
                'notnull' => false,
                'length' => 20,
                'oro_options' => [
                    'extend' => ['owner' => ExtendScope::OWNER_CUSTOM],
                    'datagrid' => ['is_visible' => DatagridScope::IS_VISIBLE_FALSE],
                    'dataaudit' => ['auditable' => true],
                    'entity' => [
                        'label' => 'aligent.customer.business_number.label',
                        'description' => 'aligent.customer.business_number.description',
                    ],
                    'email' => ['available_in_template' => 1]
                ],
            ]);
        }
    }
}
