<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Handler;

use EmailServiceBundle\Handler\MailHandler;
use EmailServiceBundle\Loader\MailBuildersLoader;
use EmailServiceBundle\Mailer\Mailer;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\Transport\Impl\SymfonyMailerTransport;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class MailHandlerTest
 *
 * @package EmailServiceBundleTests\Unit\Handler
 */
final class MailHandlerTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\Handler\MailHandler
     * @covers \EmailServiceBundle\Handler\MailHandler::send
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::isValid
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     *
     * @throws Exception
     */
    public function testSend(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->method('send');
        $mailer        = new Mailer($transport);
        $builderLoader = self::createPartialMock(MailBuildersLoader::class, ['getBuilder']);
        $builderLoader->expects(self::any())->method('getBuilder')->willReturn(new GenericMessageBuilder());
        $handler = new MailHandler($mailer, $builderLoader);

        $handler->send(
            '1',
            [
                'from'        => 'sender@gmail.com', 'to' => 'recipient@gmail.com', 'subject' => 'example',
                'dataContent' => ['content'],
            ],
        );

        self::assertTrue(TRUE);
    }

    /**
     * @covers \EmailServiceBundle\Handler\MailHandler
     * @covers \EmailServiceBundle\Handler\MailHandler::send
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::isValid
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     * @covers \EmailServiceBundle\Mailer\Mailer::renderAndSend
     *
     * @throws Exception
     */
    public function testTestSend(): void
    {
        $transport = self::createPartialMock(SymfonyMailerTransport::class, ['send']);
        $transport->method('send');
        $mailer        = new Mailer($transport);
        $builderLoader = self::createPartialMock(MailBuildersLoader::class, ['getBuilder']);
        $builderLoader->expects(self::any())->method('getBuilder')->willReturn(new GenericMessageBuilder());
        $handler = new MailHandler($mailer, $builderLoader);

        $handler->testSend(
            '1',
            [
                'from'        => 'sender@gmail.com', 'to' => 'recipient@gmail.com', 'subject' => 'example',
                'dataContent' => ['content'],
            ],
        );

        self::assertTrue(TRUE);
    }

}
