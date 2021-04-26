<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Transport\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use EmailServiceBundle\Transport\Impl\SymfonyMailerTransport;
use EmailServiceBundle\Transport\TransportException;
use Exception;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer;

/**
 * Class SwiftMailerTransportTest
 *
 * @package EmailServiceBundleTests\Unit\Transport\Impl
 */
final class SwiftMailerTransportTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\Transport\Impl\SymfonyMailerTransport
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::setLogger
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::send
     *
     * @throws Exception
     */
    public function testSend(): void
    {
        $fakeMailer = $this->createPartialMock(Mailer::class, ['send']);
        $fakeMailer->method('send')->willReturnCallback(
            static function (): void {
            }
        );

        $logger = $this->createPartialMock(Logger::class, ['info']);
        $logger->method('info');

        $attach1 = new GenericContentAttachment('hello', 'text/plain', 'hello.txt');
        $attach2 = new GenericFsAttachment('123abc', 'text/plain', 'hello.txt');

        $message = new GenericTransportMessage('no-reply@test.com', 'no-reply@test.com', 'Subject', 'Content');
        $message->addContentAttachment($attach1);
        $message->addFileStorageAttachment($attach2);

        $mailer = new SymfonyMailerTransport($fakeMailer);
        $mailer->setLogger($logger);
        $mailer->send($message);
        self::assertTrue(TRUE);
    }

    /**
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::send
     */
    public function testSendErr(): void
    {
        $fakeMailer = $this->createPartialMock(Mailer::class, ['send']);
        $fakeMailer->method('send')->willThrowException(new Exception());

        $mailer = new SymfonyMailerTransport($fakeMailer);
        $mailer->setLogger(new Logger('logger'));

        self::expectException(TransportException::class);
        $mailer->send(new GenericTransportMessage('no-reply@test.com', 'no-reply@test.com', 'Subject', 'Content'));
    }

}
