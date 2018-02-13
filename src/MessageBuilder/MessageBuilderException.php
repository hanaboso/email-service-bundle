<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder;

use EmailServiceBundle\Exception\PipesFrameworkException;

/**
 * Class MessageBuilderException
 *
 * @package App\MessageBuilder
 */
final class MessageBuilderException extends PipesFrameworkException
{

    protected const OFFSET = 500;

    public const INVALID_DATA = self::OFFSET + 1;

}
