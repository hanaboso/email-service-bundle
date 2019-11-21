<?php declare(strict_types=1);

namespace EmailServiceBundle\Transport\Impl;

use EmailServiceBundle\Transport\TransportException;
use EmailServiceBundle\Transport\TransportInterface;
use EmailServiceBundle\Transport\TransportMessageInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Throwable;

/**
 * Class SwiftMailerTransport
 *
 * @package EmailServiceBundle\Transport\Impl
 */
class SwiftMailerTransport implements TransportInterface
{

    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * SwiftMailerTransport constructor.
     *
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->logger = new NullLogger();
    }

    /**
     * @param TransportMessageInterface $messageData
     *
     * @throws TransportException
     */
    public function send(TransportMessageInterface $messageData): void
    {
        $message = (new Swift_Message())
            ->setSubject($messageData->getSubject())
            ->setFrom($messageData->getFrom())
            ->setTo($messageData->getTo());

        $message->setBody($messageData->getContent(), $messageData->getContentType(), 'utf-8');

        if ($messageData->getContentAttachments()) {
            foreach ($messageData->getContentAttachments() as $contentAttachment) {
                $message->attach(
                    new Swift_Attachment(
                        $contentAttachment->getContent(),
                        $contentAttachment->getFilename(),
                        $contentAttachment->getContentType()
                    )
                );
            }
        }

        $logBody = sprintf(
            'subject: %s, recipient: %s, datetime: %s.',
            $messageData->getSubject(),
            $messageData->getTo(),
            date(DATE_ATOM)
        );

        try {
            $sent = $this->mailer->send($message);
        } catch (Throwable $t) {
            $this->logger->error('Message send failed.', ['Exception' => json_encode($t)]);
            $sent = 0;
        }

        if ($sent === 0) {
            $this->logger->error(sprintf('Message send failed: %s', $logBody));
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
