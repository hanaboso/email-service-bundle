<?php declare(strict_types=1);

namespace EmailServiceBundle\Mailer;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Transport\TransportInterface;
use EmailServiceBundle\Transport\TransportMessageInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class Mailer
 *
 * @package App\Mailer
 */
class Mailer
{

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var null|EngineInterface
     */
    private $templateEngine;

    /**
     * Mailer constructor.
     *
     * @param TransportInterface   $transport
     * @param EngineInterface|null $templateEngine
     */
    public function __construct(TransportInterface $transport, ?EngineInterface $templateEngine = NULL)
    {
        $this->transport      = $transport;
        $this->templateEngine = $templateEngine;
    }

    /**
     * @param TransportMessageInterface $message
     *
     * @throws MailerException
     */
    public function renderAndSend(TransportMessageInterface $message): void
    {
        if ($message->getTemplate()) {
            if (!$this->templateEngine) {
                throw new MailerException(
                    'Missing template engine. Can not render message.',
                    MailerException::MISSING_TEMPLATE_ENGINE
                );
            }
            $message->setContent($this->templateEngine->render($message->getTemplate(), $message->getDataContent()));
        }
        $this->transport->send($message);
    }

    /**
     * @param TransportMessageInterface $message
     *
     * @return bool
     * @throws MailerException
     */
    public function renderAndSendTest(TransportMessageInterface $message): bool
    {
        if ($message->getTemplate()) {
            if (!$this->templateEngine) {
                throw new MailerException(
                    'Missing template engine. Can not render message.',
                    MailerException::MISSING_TEMPLATE_ENGINE
                );
            }
        }

        return TRUE;
    }

}
