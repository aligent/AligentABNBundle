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

namespace Aligent\ABNBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\EntityBundle\EntityConfig\DatagridScope;
use Oro\Bundle\EntityExtendBundle\EntityConfig\ExtendScope;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AlterABNColumn implements Migration
{

    /**
     * Modifies the given schema to apply necessary changes of a database
     * The given query bag can be used to apply additional SQL queries before and after schema changes
     *
     * @param Schema $schema
     * @param QueryBag $queries
     * @return void
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
            $table = $schema->getTable('oro_customer');
            // Removed unique index on ABN as all clients have requested this
            // $table->addUniqueIndex(['business_number']);
        }

        $queries->addPostQuery('UPDATE oro_customer SET business_number = abn WHERE abn IS NOT NULL');
    }
}
