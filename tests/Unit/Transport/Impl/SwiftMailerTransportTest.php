<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Transport\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericContentAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericFsAttachment;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use EmailServiceBundle\Transport\Impl\SymfonyMailerTransport;
use EmailServiceBundle\Transport\TransportException;
use Exception;
use Hanaboso\PhpCheckUtils\PhpUnit\Traits\CustomAssertTrait;
use Monolog\Logger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Mailer;

/**
 * Class SwiftMailerTransportTest
 *
 * @package EmailServiceBundleTests\Unit\Transport\Impl
 */
#[CoversClass(SymfonyMailerTransport::class)]
final class SwiftMailerTransportTest extends TestCase
{

    use CustomAssertTrait;

    /**
     * @throws Exception
     */
    public function testSend(): void
    {
        $fakeMailer = $this->createPartialMock(Mailer::class, ['send']);
        $fakeMailer->method('send')->willReturnCallback(
            static function (): void {
            },
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
        self::assertFake();
    }

    /**
     * @throws Exception
     */
    public function testSendHtml(): void
    {
        $fakeMailer = $this->createPartialMock(Mailer::class, ['send']);
        $fakeMailer->method('send')->willReturnCallback(
            static function (): void {
            },
        );

        $message = new GenericTransportMessage(
            'no-reply@test.com',
            'no-reply@test.com',
            'Subject',
            'Content',
            'Some/template.html.twig',
        );
        $mailer  = new SymfonyMailerTransport($fakeMailer);
        $mailer->send($message);
        self::assertFake();
    }

    /**
     * @return void
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
