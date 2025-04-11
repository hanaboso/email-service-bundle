<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport;

use Hanaboso\Utils\Exception\PipesFrameworkExceptionAbstract;

/**
 * Class TransportException
 *
 * @package EmailServiceBundle\Transport
 */
class TransportException extends PipesFrameworkExceptionAbstract
{

    public const int SEND_FAILED = self::OFFSET + 1;

    protected const int OFFSET = 600;

}
