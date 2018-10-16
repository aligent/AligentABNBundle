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
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ABNValidator extends ConstraintValidator
{
    const WEIGHTS = [
        10, 1, 3, 5, 7, 9, 11, 13, 15, 17, 19
    ];

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ABN) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\ABN');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        $valid = false;
        $abn = preg_replace("/\s+/", "", $value);

        // check length is 11 digits
        if (strlen($abn)==11) {
            // apply ato check method
            $sum = 0;
            foreach (static::WEIGHTS as $position => $weight) {
                $digit = $abn[$position] - ($position ? 0 : 1);
                $sum += $weight * $digit;
            }
            $valid = ($sum % 89) == 0;
        }

        if (!$valid) {
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->addViolation();
            }
        }
    }
}
