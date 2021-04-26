<?php declare(strict_types=1);

namespace EmailServiceBundle\Handler;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Loader\MailBuildersLoader;
use EmailServiceBundle\Mailer\Mailer;

/**
 * Class MailHandler
 *
 * @package EmailServiceBundle\Handler
 */
final class MailHandler
{

    /**
     * MailHandler constructor.
     *
     * @param Mailer             $mailer
     * @param MailBuildersLoader $buildersLoader
     */
    public function __construct(private Mailer $mailer, private MailBuildersLoader $buildersLoader)
    {
    }

    /**
     * @param string  $builderId
     * @param mixed[] $data
     *
     * @throws MailerException
     */
    public function send(string $builderId, array $data): void
    {
        $builder = $this->buildersLoader->getBuilder($builderId);

        $this->mailer->renderAndSend($builder->buildTransportMessage($data));
    }

    /**
     * @param string  $builderId
     * @param mixed[] $data
     *
     * @throws MailerException
     */
    public function testSend(string $builderId, array $data): void
    {
        $builder = $this->buildersLoader->getBuilder($builderId);

        $this->mailer->renderAndSendTest($builder->buildTransportMessage($data));
    }

}
