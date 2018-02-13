<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder;

/**
 * Interface BuilderDataValidatorInterface
 *
 * @package App\MessageBuilder
 */
interface BuilderDataValidatorInterface
{

    /**
     * @param array $data
     *
     * @return bool
     */
    public function isValid(array $data): bool;

}
