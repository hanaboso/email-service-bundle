<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Transport\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use EmailServiceBundle\Transport\Impl\SwiftMailerTransport;
use EmailServiceBundle\Transport\TransportException;
use Exception;
use Monolog\Logger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Swift_Mailer;

/**
 * Class SwiftMailerTransportTest
 *
 * @package EmailServiceBundleTests\Unit\Transport\Impl
 */
final class SwiftMailerTransportTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::setLogger
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::send
     *
     * @throws Exception
     */
    public function testSend(): void
    {
        /** @var MockObject|Swift_Mailer $fakeMailer */
        $fakeMailer = $this->createPartialMock(Swift_Mailer::class, ['send']);
        $fakeMailer->method('send')->willReturn(1);

        /** @var MockObject|Logger $logger */
        $logger = $this->createPartialMock(Logger::class, ['info']);
        $logger->method('info');

        $attach1 = new GenericContentAttachment('hello', 'text/plain', 'hello.txt');
        $attach2 = new GenericFsAttachment('123abc', 'text/plain', 'hello.txt');

        $message = new GenericTransportMessage('no-reply@test.com', 'no-reply@test.com', 'Subject', 'Content');
        $message->addContentAttachment($attach1);
        $message->addFileStorageAttachment($attach2);

        $mailer = new SwiftMailerTransport($fakeMailer);
        $mailer->setLogger($logger);
        $mailer->send($message);
        self::assertTrue(TRUE);
    }

    /**
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::send
     *
     * @throws TransportException
     */
    public function testSendErr(): void
    {
        /** @var MockObject|Swift_Mailer $fakeMailer */
        $fakeMailer = $this->createPartialMock(Swift_Mailer::class, ['send']);
        $fakeMailer->method('send')->willReturn(0);

        $mailer = new SwiftMailerTransport($fakeMailer);
        $mailer->setLogger(new Logger('logger'));

        self::expectException(TransportException::class);
        $mailer->send(new GenericTransportMessage('no-reply@test.com', 'no-reply@test.com', 'Subject', 'Content'));
    }

    /**
     * @covers \EmailServiceBundle\Transport\Impl\SwiftMailerTransport::send
     *
     * @throws TransportException
     */
    public function testSendErr2(): void
    {
        /** @var MockObject|Swift_Mailer $fakeMailer */
        $fakeMailer = $this->createPartialMock(Swift_Mailer::class, ['send']);
        $fakeMailer->method('send')->willThrowException(new Exception());

        $mailer = new SwiftMailerTransport($fakeMailer);
        $mailer->setLogger(new Logger('logger'));

        self::expectException(TransportException::class);
        $mailer->send(new GenericTransportMessage('no-reply@test.com', 'no-reply@test.com', 'Subject', 'Content'));
    }

}
