<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
use EmailServiceBundle\Transport\TransportMessageInterface;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericMessageBuilderTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl
 */
final class GenericMessageBuilderTest extends TestCase
{

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::isValid
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
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::isValid
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
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     *
     * @throws Exception
     */
    public function testBuildTransportMessage(): void
    {
        $data = [
            'from'    => 'no-reply@test.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'Subject',
            'content' => ['link' => 'link'],
        ];

        $handler = new GenericMessageBuilder();
        $message = $handler->buildTransportMessage($data);

        $this->assertInstanceOf(TransportMessageInterface::class, $message);
    }

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     *
     * @throws Exception
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

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::isValid
     */
    public function testIsValid(): void
    {
        $data = [
            'from' => 'no-reply@test.com',
        ];

        $this->assertFalse(GenericMessageBuilder::isValid($data));

        $data = [
            'from' => 'no-reply@test.com',
            'to'   => 'no-reply@test.com',
        ];

        $this->assertFalse(GenericMessageBuilder::isValid($data));

        $data = [
            'from'    => 'no-reply@test.com',
            'to'      => 'no-reply@test.com',
            'subject' => 'test',
        ];

        $this->assertFalse(GenericMessageBuilder::isValid($data));
    }

}
