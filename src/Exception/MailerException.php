<?php declare(strict_types=1);

namespace EmailServiceBundle\Exception;

use Hanaboso\Utils\Exception\PipesFrameworkExceptionAbstract;

/**
 * Class MailerException
 *
 * @package EmailServiceBundle\Exception
 */
final class MailerException extends PipesFrameworkExceptionAbstract
{

    protected const OFFSET = 700;

    public const MISSING_TEMPLATE_ENGINE   = self::OFFSET + 1;
    public const BUILDER_SERVICE_NOT_FOUND = self::OFFSET + 2;
    public const TEMPLATE_ENGINE_ERROR     = self::OFFSET + 3;

}
