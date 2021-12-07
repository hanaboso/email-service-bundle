<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Mailer;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Mailer\Mailer;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder\GenericTransportMessage;
use EmailServiceBundle\Transport\Impl\SymfonyMailerTransport;
use EmailServiceBundle\Transport\TransportException;
use EmailServiceBundle\Transport\TransportInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

/**
 * Class MailerTest
 *
 * @package EmailServiceBundleTests\Unit\Mailer
 */
final class MailerTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     * @throws Exception
     */
    public function testSend(): void
    {
        $transport = $this->createPartialMock(TransportInterface::class, ['send', 'setLogger']);
        $transport->method('send')->willReturnCallback(
            static function (): void {
            },
        );
        $transport->method('setLogger')->willReturnCallback(static function (): void{});

        $data = [
            'from'    => 'valid@mail.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $handler = new GenericMessageBuilder();
        $mailer  = new Mailer($transport, NULL);
        $mailer->renderAndSend($handler->buildTransportMessage($data));
        self::assertTrue(TRUE);
    }

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSendTest
     * @throws Exception
     */
    public function testSendTest(): void
    {
        $transport = $this->createPartialMock(TransportInterface::class, ['send', 'setLogger']);
        $transport->method('send')->willReturnCallback(
            static function (): void {
            },
        );
        $transport->method('setLogger')->willReturnCallback(static function (): void{});

        $data = [
            'from'    => 'valid@mail.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $handler = new GenericMessageBuilder();
        $mailer  = new Mailer($transport, NULL);
        $mailer->renderAndSendTest($handler->buildTransportMessage($data));
        self::assertTrue(TRUE);
    }

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     *
     * @throws MailerException
     */
    public function testRenderAndSend(): void
    {
        $transport = self::createMock(SymfonyMailerTransport::class);
        $message   = self::createPartialMock(GenericTransportMessage::class, ['getTemplate', 'getDataContent']);
        $message->expects(self::any())->method('getTemplate')->willReturn('template');
        $message->expects(self::any())->method('getDataContent')->willReturn(['data']);

        $engine = self::createPartialMock(Environment::class, ['render']);
        $engine->expects(self::any())->method('render')->willReturn('render');
        $mailer = new Mailer($transport, $engine);
        $mailer->renderAndSend($message);

        self::assertTrue(TRUE);
    }

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     *
     * @throws MailerException
     */
    public function testRenderAndSendErr(): void
    {
        $transport = self::createMock(SymfonyMailerTransport::class);
        $message   = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->expects(self::any())->method('getTemplate')->willReturn('template');

        $mailer = new Mailer($transport, NULL);
        self::expectException(MailerException::class);
        $mailer->renderAndSend($message);
    }

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     *
     * @throws MailerException
     */
    public function testRenderAndSendErr2(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->expects(self::any())->method('send')->willThrowException(new TransportException());
        $message = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->expects(self::any())->method('getTemplate')->willReturn('template');

        $engine = self::createPartialMock(Environment::class, ['render']);
        $mailer = new Mailer($transport, $engine);

        self::expectException(MailerException::class);
        $mailer->renderAndSend($message);
    }

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     *
     * @throws MailerException
     */
    public function testRenderAndSendErr3(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->expects(self::any())->method('send')->willThrowException(new TransportException());
        $message = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->expects(self::any())->method('getTemplate')->willReturn(NULL);

        $mailer = new Mailer($transport, NULL);

        self::expectException(MailerException::class);
        $mailer->renderAndSend($message);
    }

    /**
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSendTest
     *
     * @throws MailerException
     */
    public function testRenderAndSendTest(): void
    {
        $transport = self::createMock(SymfonyMailerTransport::class);
        $message   = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->expects(self::any())->method('getTemplate')->willReturn('template');
        $mailer = new Mailer($transport, NULL);

        self::expectException(MailerException::class);
        $mailer->renderAndSendTest($message);
    }

}
