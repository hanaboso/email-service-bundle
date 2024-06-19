<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\MessageBuilder\Impl;

use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericMessageBuilderTest
 *
 * @package EmailServiceBundleTests\Unit\MessageBuilder\Impl
 */
#[CoversClass(GenericMessageBuilder::class)]
final class GenericMessageBuilderTest extends TestCase
{

    /**
     * @return void
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
     * @return void
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
     * @return void
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
