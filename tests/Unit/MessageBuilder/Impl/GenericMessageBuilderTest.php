<?php declare(strict_types=1);

namespace Tests\Unit\MessageBuilder\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
use EmailServiceBundle\Transport\TransportMessageInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericMessageHandlerTest
 *
 * @package Tests\Unit\MessageBuilder\Impl
 */
class GenericMessageBuilderTest extends TestCase
{

    /**
     *
     */
    public function testValid(): void
    {
        $data = [
            'from'    => 'no-reply@test.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $this->assertTrue(GenericMessageBuilder::isValid($data));
    }

    /**
     *
     */
    public function testInvalid(): void
    {
        $data = [
            'from'    => 'no-reply&test.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $this->assertFalse(GenericMessageBuilder::isValid($data));
    }

    /**
     *
     */
    public function testBuildTransportMessage(): void
    {
        $data = [
            'from'    => 'no-reply@test.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $handler = new GenericMessageBuilder();
        $message = $handler->buildTransportMessage($data);

        $this->assertInstanceOf(TransportMessageInterface::class, $message);
    }

    /**
     *
     */
    public function testBuildTransportMessageFails(): void
    {
        $data = [
            'from'    => 'invalid$mail',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ];

        $handler = new GenericMessageBuilder();

        $this->expectException(MessageBuilderException::class);
        $this->expectExceptionCode(MessageBuilderException::INVALID_DATA);

        $handler->buildTransportMessage($data);
    }

}