<?php declare(strict_types=1);

namespace EmailServiceBundle\Handler;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Loader\MailBuildersLoader;
use EmailServiceBundle\Mailer\Mailer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class MailHandler
 *
 * @package App\Handler
 */
class MailHandler
{

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var MailBuildersLoader
     */
    private $buildersLoader;

    /**
     * MailHandler constructor.
     *
     * @param Mailer             $mailer
     * @param MailBuildersLoader $buildersLoader
     */
    public function __construct(Mailer $mailer, MailBuildersLoader $buildersLoader)
    {
        $this->mailer         = $mailer;
        $this->buildersLoader = $buildersLoader;
    }

    /**
     * @param string $builderId
     * @param array  $data
     *
     * @throws MailerException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function send(string $builderId, array $data): void
    {
        $builder = $this->buildersLoader->getBuilder($builderId);

        $this->mailer->renderAndSend($builder->buildTransportMessage($data));
    }

    /**
     * @param string $builderId
     * @param array  $data
     *
     * @throws ContainerExceptionInterface
     * @throws MailerException
     * @throws NotFoundExceptionInterface
     */
    public function testSend(string $builderId, array $data): void
    {
        $builder = $this->buildersLoader->getBuilder($builderId);

        $this->mailer->renderAndSendTest($builder->buildTransportMessage($data));
    }

}
