<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport;

use Hanaboso\CommonsBundle\Exception\PipesFrameworkExceptionAbstract;

/**
 * Class TransportException
 *
 * @package EmailServiceBundle\Transport
 */
class TransportException extends PipesFrameworkExceptionAbstract
{

    protected const OFFSET = 600;

    public const SEND_FAILED = self::OFFSET + 1;

}
