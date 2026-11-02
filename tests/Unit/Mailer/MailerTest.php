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
use Hanaboso\PhpCheckUtils\PhpUnit\Traits\CustomAssertTrait;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twig\Environment;

/**
 * Class MailerTest
 *
 * @package EmailServiceBundleTests\Unit\Mailer
 */
#[AllowMockObjectsWithoutExpectations]
#[CoversClass(Mailer::class)]
final class MailerTest extends TestCase
{

    use CustomAssertTrait;

    /**
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
            'content' => 'Content',
            'from'    => 'valid@mail.com',
            'subject' => 'Subject',
            'to'      => 'no-reply@test.com',
        ];

        $handler = new GenericMessageBuilder();
        $mailer  = new Mailer($transport, NULL);
        $mailer->renderAndSend($handler->buildTransportMessage($data));
        self::assertFake();
    }

    /**
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
            'content' => 'Content',
            'from'    => 'valid@mail.com',
            'subject' => 'Subject',
            'to'      => 'no-reply@test.com',
        ];

        $handler = new GenericMessageBuilder();
        $mailer  = new Mailer($transport, NULL);
        $mailer->renderAndSendTest($handler->buildTransportMessage($data));
        self::assertFake();
    }

    /**
     * @throws MailerException
     */
    public function testRenderAndSend(): void
    {
        $transport = self::createMock(SymfonyMailerTransport::class);
        $message   = self::createPartialMock(GenericTransportMessage::class, ['getTemplate', 'getDataContent']);
        $message->method('getTemplate')->willReturn('template');
        $message->method('getDataContent')->willReturn(['data']);

        $engine = self::createPartialMock(Environment::class, ['render']);
        $engine->method('render')->willReturn('render');
        $mailer = new Mailer($transport, $engine);
        $mailer->renderAndSend($message);

        self::assertFake();
    }

    /**
     * @throws MailerException
     */
    public function testRenderAndSendErr(): void
    {
        $transport = self::createMock(SymfonyMailerTransport::class);
        $message   = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->method('getTemplate')->willReturn('template');

        $mailer = new Mailer($transport, NULL);
        self::expectException(MailerException::class);
        $mailer->renderAndSend($message);
    }

    /**
     * @throws MailerException
     */
    public function testRenderAndSendErr2(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->expects(self::once())->method('send')->willThrowException(new TransportException());
        $message = self::createPartialMock(GenericTransportMessage::class, ['getTemplate', 'getDataContent']);
        $message->method('getTemplate')->willReturn('template');
        $message->method('getDataContent')->willReturn([]);

        $engine = self::createPartialMock(Environment::class, ['render']);
        $engine->method('render')->willReturn('render');
        $mailer = new Mailer($transport, $engine);

        try {
            $mailer->renderAndSend($message);
            self::fail('MailerException was not thrown.');
        } catch (MailerException $e) {
            self::assertInstanceOf(TransportException::class, $e->getPrevious());
        }
    }

    /**
     * @throws MailerException
     */
    public function testRenderAndSendErr3(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->method('send')->willThrowException(new TransportException());
        $message = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->method('getTemplate')->willReturn(NULL);

        $mailer = new Mailer($transport, NULL);

        self::expectException(MailerException::class);
        $mailer->renderAndSend($message);
    }

    /**
     * @throws MailerException
     */
    public function testRenderAndSendTest(): void
    {
        $transport = self::createMock(SymfonyMailerTransport::class);
        $message   = self::createPartialMock(GenericTransportMessage::class, ['getTemplate']);
        $message->method('getTemplate')->willReturn('template');
        $mailer = new Mailer($transport, NULL);

        self::expectException(MailerException::class);
        $mailer->renderAndSendTest($message);
    }

}
