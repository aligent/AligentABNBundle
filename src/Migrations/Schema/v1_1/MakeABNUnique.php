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

namespace Aligent\ABNBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class MakeABNUnique implements Migration
{
    /**
     * Modifies the given schema to apply necessary changes of a database
     * The given query bag can be used to apply additional SQL queries before and after schema changes
     */
    public function up(Schema $schema, QueryBag $queries): void
    {
        // Removed unique index on ABN as all clients have requested this
        // This migration is for reference only now

        // $table = $schema->getTable('oro_customer');
        // $table->addUniqueIndex(['abn']);
    }
}
