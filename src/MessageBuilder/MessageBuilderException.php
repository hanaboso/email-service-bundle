<?php declare(strict_types=1);

namespace EmailServiceBundle\MessageBuilder;

use Hanaboso\Utils\Exception\PipesFrameworkExceptionAbstract;

/**
 * Class MessageBuilderException
 *
 * @package EmailServiceBundle\MessageBuilder
 */
final class MessageBuilderException extends PipesFrameworkExceptionAbstract
{

    protected const OFFSET = 500;

    public const INVALID_DATA = self::OFFSET + 1;

}
