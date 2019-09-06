<?php declare(strict_types=1);

namespace EmailServiceBundle\Mailer;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Transport\TransportInterface;
use EmailServiceBundle\Transport\TransportMessageInterface;
use Twig\Environment;
use Twig\Error\Error;

/**
 * Class Mailer
 *
 * @package EmailServiceBundle\Mailer
 */
class Mailer
{

    /**
     * @var TransportInterface
     */
    private $transport;

    /**
     * @var Environment|null
     */
    private $engine;

    /**
     * Mailer constructor.
     *
     * @param TransportInterface $transport
     * @param Environment|null   $engine
     */
    public function __construct(TransportInterface $transport, ?Environment $engine = NULL)
    {
        $this->transport = $transport;
        $this->engine    = $engine;
    }

    /**
     * @param TransportMessageInterface $message
     *
     * @throws MailerException
     */
    public function renderAndSend(TransportMessageInterface $message): void
    {
        if ($message->getTemplate()) {
            if (!$this->engine) {
                throw new MailerException(
                    'Missing template engine. Can not render message.',
                    MailerException::MISSING_TEMPLATE_ENGINE
                );
            }

            try {
                $message->setContent(
                    $this->engine->render(
                        (string) $message->getTemplate(),
                        $message->getDataContent()
                    )
                );
                $this->transport->send($message);
            } catch (Error $e) {
                throw new MailerException(
                    $e->getMessage(),
                    MailerException::TEMPLATE_ENGINE_ERROR,
                    $e
                );
            }
        }
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
            if (!$this->engine) {
                throw new MailerException(
                    'Missing template engine. Can not render message.',
                    MailerException::MISSING_TEMPLATE_ENGINE
                );
            }
        }

        return TRUE;
    }

}
