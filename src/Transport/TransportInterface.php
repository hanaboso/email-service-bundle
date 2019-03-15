<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport;

use Psr\Log\LoggerAwareInterface;

/**
 * Interface TransportInterface
 *
 * @package EmailServiceBundle\Transport
 */
interface TransportInterface extends LoggerAwareInterface
{

    /**
     * @param TransportMessageInterface $message
     *
     * @return mixed
     */
    public function send(TransportMessageInterface $message);

}

