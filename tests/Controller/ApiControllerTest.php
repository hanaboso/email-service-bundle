<?php declare(strict_types=1);

namespace Tests\Controller;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\MessageBuilder\MessageBuilderException;
use Tests\ControllerTestCaseAbstract;

/**
 * Class ApiControllerTest
 *
 * @package Tests\Controller
 */
class ApiControllerTest extends ControllerTestCaseAbstract
{

    /**
     *
     */
    public function testSend(): void
    {
        $response = $this->sendPost('/mailer/generic/send', [
            'from'    => 'email@example.com',
            'to'      => 'email@example.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertEquals('OK', $response->content->status);
    }

    /**
     *
     */
    public function testSendInvalidData(): void
    {
        $response = $this->sendPost('/mailer/generic/send', [
            'from'    => '',
            'to'      => '',
            'subject' => '',
            'content' => '',
        ]);
        $content = $response->content;

        $this->assertEquals(500, $response->status);
        $this->assertEquals(MessageBuilderException::class, $content->type);
        $this->assertEquals(2001, $content->error_code);
    }

    /**
     *
     */
    public function testSendNotFoundMailer(): void
    {
        $response = $this->sendPost('/mailer/unknown/send', []);
        $content = $response->content;

        $this->assertEquals(500, $response->status);
        $this->assertEquals(MailerException::class, $content->type);
        $this->assertEquals(2001, $content->error_code);
    }

    /**
     *
     */
    public function testSendTest(): void
    {
        $response = $this->sendPost('/mailer/generic/send/test', [
            'from'    => 'email@example.com',
            'to'      => 'email@example.com',
            'subject' => 'Subject',
            'content' => 'Content',
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertEquals('OK', $response->content->status);
    }

    /**
     *
     */
    public function testSendTestInvalidData(): void
    {
        $response = $this->sendPost('/mailer/generic/send', [
            'from'    => '',
            'to'      => '',
            'subject' => '',
            'content' => '',
        ]);
        $content = $response->content;

        $this->assertEquals(500, $response->status);
        $this->assertEquals(MessageBuilderException::class, $content->type);
        $this->assertEquals(2001, $content->error_code);
    }

    /**
     *
     */
    public function testSendTestNotFoundMailer(): void
    {
        $response = $this->sendPost('/mailer/unknown/send', []);
        $content = $response->content;

        $this->assertEquals(500, $response->status);
        $this->assertEquals(MailerException::class, $content->type);
        $this->assertEquals(2001, $content->error_code);
    }

}