<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\DefaultValues;

use EmailServiceBundle\DefaultValues\DefaultValues;
use Hanaboso\Utils\String\Json;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultValuesTest
 *
 * @package EmailServiceBundleTests\Unit\DefaultValues
 */
final class DefaultValuesTest extends TestCase
{

    /**
     * @var mixed[]
     */
    protected static $data = [
        ['foo' => 'foo@foo.com', 'boo' => 'boo@boo.com'],   //from
        ['foo' => 'Foo subject', 'test' => 'test@example.com'],   //subject
        ['foo' => 'to@foo.com', 'boo' => 'to@boo.com'],   //to
        ['foo' => 'bcc@foo.com', 'boo' => 'bcc@boo.com'],   //bcc
    ];

    /**
     * @dataProvider emptyConstructor
     *
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::__construct()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getDefaults()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getFrom()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getSubject()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getTo()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getBcc()
     *
     * @param string  $module
     * @param mixed[] $result
     */
    public function testEmptyConstruct(string $module, array $result): void
    {
        $default = new DefaultValues();
        $this->assertEquals($result, $default->getDefaults($module));
    }

    /**
     * @dataProvider filledConstructor
     *
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::__construct()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getDefaults()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getBcc()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getFrom()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getSubject()
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::getTo()
     *
     * @param mixed[] $data
     * @param string  $module
     * @param mixed[] $result
     */
    public function testFilledConstructor(array $data, string $module, array $result): void
    {
        [$from, $subject, $to, $bcc] = $data;

        $defaults = new DefaultValues($from, $subject, $to, $bcc);
        $this->assertEquals($result, $defaults->getDefaults($module));
    }

    /**
     * @covers \EmailServiceBundle\DefaultValues\DefaultValues::getDefaults
     * @covers \EmailServiceBundle\DefaultValues\DefaultValues::handleDefaults
     * @covers \EmailServiceBundle\DefaultValues\DefaultValues::getSubject
     * @covers \EmailServiceBundle\DefaultValues\DefaultValues::getTo
     * @covers \EmailServiceBundle\DefaultValues\DefaultValues::getBcc
     * @covers \EmailServiceBundle\DefaultValues\DefaultValues::getFrom
     */
    public function testFrom(): void
    {
        $data     = Json::decode('{"to":"user2@hanaboso.com","subject":"Activate user account","content":"","dataContent":{"link":"127.0.0.4:8000\/user\/5a78840bd5a1d\/activate"},"template":null,"from":""}');
        $defaults = new DefaultValues(['aa' => 'e-mail'], [], [], []);
        $default  = $defaults->getDefaults('aa');

        $defaultData = DefaultValues::handleDefaults($data, $default, ['from']);

        self::assertNotEmpty($defaultData['from']);
        self::assertEquals($defaultData['from'], 'e-mail');
    }

    /**
     * @dataProvider handleDefaults
     * @covers       \EmailServiceBundle\DefaultValues\DefaultValues::handleDefaults()
     *
     * @param mixed[] $data
     * @param mixed[] $defaults
     * @param mixed[] $fields
     * @param mixed[] $result
     */
    public function testHandleDefaults(array $data, array $defaults, array $fields, array $result): void
    {
        $defaultData = DefaultValues::handleDefaults($data, $defaults, $fields);
        $this->assertEquals($result, $defaultData);
    }

    /**
     * @return mixed[]
     */
    public function handleDefaults(): array
    {
        return [
            [
                [],
                ['from' => 'from@example.com', 'to' => 'to@example.com'],
                ['from', 'to'],
                ['from' => 'from@example.com', 'to' => 'to@example.com'],
            ],
            [
                ['from' => 'foo@example.com', 'to' => 'boo@example.com'],
                ['from' => 'from@example.com', 'to' => 'to@example.com'],
                ['from', 'to'],
                ['from' => 'foo@example.com', 'to' => 'boo@example.com'],
            ],
            [
                ['from' => 'foo@example.com', 'to' => 'boo@example.com'],
                ['from' => 'from@example.com', 'to' => 'to@example.com', 'subject' => 'test'],
                ['from', 'to'],
                ['from' => 'foo@example.com', 'to' => 'boo@example.com'],
            ],
            [
                ['from' => 'foo@example.com', 'to' => 'boo@example.com'],
                ['from' => 'from@example.com', 'to' => 'to@example.com', 'subject' => 'test'],
                ['from', 'to', 'subject'],
                ['from' => 'foo@example.com', 'to' => 'boo@example.com', 'subject' => 'test'],
            ],

        ];
    }

    /**
     * @return mixed[]
     */
    public function filledConstructor(): array
    {
        return [
            [
                self::$data,
                'foo',
                ['from' => 'foo@foo.com', 'subject' => 'Foo subject', 'to' => 'to@foo.com', 'bcc' => 'bcc@foo.com'],
            ],
            [
                self::$data,
                'boo',
                ['from' => 'boo@boo.com', 'subject' => NULL, 'to' => 'to@boo.com', 'bcc' => 'bcc@boo.com'],
            ],
            [
                self::$data,
                'test',
                ['from' => NULL, 'subject' => 'test@example.com', 'to' => NULL, 'bcc' => NULL],
            ],
        ];
    }

    /**
     * @return mixed[]
     */
    public function emptyConstructor(): array
    {
        return [
            ['foo', ['from' => NULL, 'subject' => NULL, 'to' => NULL, 'bcc' => NULL]],
        ];
    }

}
