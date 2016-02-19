<?php

namespace App\Bundle\Validator;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class UniqueValidator extends ConstraintValidator
{
    /** @var ManagerRegistry */
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Unique) {
            throw new UnexpectedTypeException($constraint, Unique::class);
        }

        if (null === $constraint->class) {
            throw new ConstraintDefinitionException('The class should be specified.');
        }

        if (null === $constraint->field) {
            throw new ConstraintDefinitionException('The field should be specified.');
        }

        $entityManager = $this->registry->getManager($constraint->em);
        $repository = $entityManager->getRepository($constraint->class);

        $entity = $repository->findOneBy([$constraint->field => is_callable($constraint->normalizer) ? call_user_func($constraint->normalizer, $value) : $value]);
        if (null === $entity) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setInvalidValue($value)
            ->addViolation();
    }
}
