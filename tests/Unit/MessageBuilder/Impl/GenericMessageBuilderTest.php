<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
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
            'content' => 'Content',
            'from'    => 'no-reply@test.com',
            'subject' => 'Subject',
            'to'      => 'no-reply@test.com',
        ];

        self::assertTrue(GenericMessageBuilder::isValid($data));
    }

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::isValid
     */
    public function testInvalid(): void
    {
        $data = [
            'content' => 'Content',
            'from'    => 'no-reply&test.com',
            'subject' => 'Subject',
            'to'      => 'no-reply@test.com',
        ];

        self::assertFalse(GenericMessageBuilder::isValid($data));
    }

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     *
     * @throws Exception
     */
    public function testBuildTransportMessage(): void
    {
        $data = [
            'content' => ['link' => 'link'],
            'from'    => 'no-reply@test.com',
            'subject' => 'Subject',
            'to'      => 'no-reply@test.com',
        ];

        $handler = new GenericMessageBuilder();
        $message = $handler->buildTransportMessage($data);

        self::assertNotEmpty($message);
    }

    /**
     * @covers \EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder::buildTransportMessage
     *
     * @throws Exception
     */
    public function testBuildTransportMessageFails(): void
    {
        $data = [
            'content' => 'Content',
            'from'    => 'invalid$mail',
            'subject' => 'Subject',
            'to'      => 'no-reply@test.com',
        ];

        $handler = new GenericMessageBuilder();

        self::expectException(MessageBuilderException::class);
        self::expectExceptionCode(MessageBuilderException::INVALID_DATA);

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

        self::assertFalse(GenericMessageBuilder::isValid($data));

        $data = [
            'from' => 'no-reply@test.com',
            'to'   => 'no-reply@test.com',
        ];

        self::assertFalse(GenericMessageBuilder::isValid($data));

        $data = [
            'from'    => 'no-reply@test.com',
            'subject' => 'test',
            'to'      => 'no-reply@test.com',
        ];

        self::assertFalse(GenericMessageBuilder::isValid($data));
    }

}
