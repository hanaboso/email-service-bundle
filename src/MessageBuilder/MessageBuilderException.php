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

    public const int INVALID_DATA = self::OFFSET + 1;

    protected const int OFFSET = 500;

}
