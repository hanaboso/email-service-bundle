<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder;

/**
 * Interface BuilderDataValidatorInterface
 *
 * @package EmailServiceBundle\MessageBuilder
 */
interface BuilderDataValidatorInterface
{

    /**
     * @param mixed[] $data
     *
     * @return bool
     */
    public function isValid(array $data): bool;

}
