<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport\Impl;

use EmailServiceBundle\Enum\ContentTypeEnum;
use EmailServiceBundle\Transport\TransportException;
use EmailServiceBundle\Transport\TransportInterface;
use EmailServiceBundle\Transport\TransportMessageInterface;
use Hanaboso\Utils\String\Json;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Throwable;

/**
 * Class SymfonyMailerTransport
 *
 * @package EmailServiceBundle\Transport\Impl
 */
final class SymfonyMailerTransport implements TransportInterface
{

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * SymfonyMailerTransport constructor.
     *
     * @param Mailer $mailer
     */
    public function __construct(protected Mailer $mailer)
    {
        $this->logger = new NullLogger();
    }

    /**
     * @param TransportMessageInterface $message
     *
     * @throws TransportException
     */
    public function send(TransportMessageInterface $message): void
    {
        $email = (new Email())
            ->subject($message->getSubject())
            ->from($message->getFrom())
            ->to($message->getTo());

        if ($message->getContentType() === ContentTypeEnum::PLAIN->value) {
            $email->text($message->getContent());
        } else {
            $email->html($message->getContent());
        }

        if ($message->getContentAttachments()) {
            foreach ($message->getContentAttachments() as $contentAttachment) {
                $email->attach(
                    $contentAttachment->getContent(),
                    $contentAttachment->getFilename(),
                    $contentAttachment->getContentType(),
                );
            }
        }

        $logBody = sprintf(
            'subject: %s, recipient: %s, datetime: %s.',
            $message->getSubject(),
            $message->getTo(),
            date(DATE_ATOM),
        );

        try {
            $this->mailer->send($email);
        } catch (Throwable $t) {
            $this->logger->error('Message send failed.', ['Exception' => Json::encode($t)]);

            throw new TransportException('Message send failed.', TransportException::SEND_FAILED);
        }

        $this->logger->info(sprintf('Message sent: %s', $logBody));
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

}
