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

namespace Aligent\ABNBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class ABN extends Constraint
{
    public $message = 'This is not a valid ABN number.';
}
