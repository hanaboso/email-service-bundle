<?php declare(strict_types=1);

namespace EmailServiceBundleTests\Unit\Loader;

use EmailServiceBundle\Exception\MailerException;
use EmailServiceBundle\Loader\MailBuildersLoader;
use EmailServiceBundle\MessageBuilder\Impl\GenericMessageBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class MailBuildersLoaderTest
 *
 * @package EmailServiceBundleTests\Unit\Loader
 */
#[CoversClass(MailBuildersLoader::class)]
final class MailBuildersLoaderTest extends TestCase
{

    /**
     * @throws MailerException
     */
    public function testGetBuilder(): void
    {
        $locator = self::createPartialMock(ServiceLocator::class, ['has', 'get']);
        $locator->expects(self::any())->method('has')->willReturn(TRUE);
        $locator->expects(self::any())->method('get')->willReturn(new GenericMessageBuilder());
        $loader = new MailBuildersLoader($locator);

        self::assertInstanceOf(GenericMessageBuilder::class, $loader->getBuilder('1'));
    }

    /**
     * @throws MailerException
     */
    public function testGetBuilderErr(): void
    {
        $locator = self::createPartialMock(ServiceLocator::class, ['has']);
        $locator->expects(self::any())->method('has')->willReturn(FALSE);
        $loader = new MailBuildersLoader($locator);

        self::expectException(MailerException::class);
        $loader->getBuilder('1');
    }

}
