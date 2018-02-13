<?php declare(strict_types=1);

namespace EmailServiceBundle\DependencyInjection;

use EmailServiceBundle\EmailServiceBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class EmailServiceExtension
 *
 * @package EmailServiceBundle\DependencyInjection
 */
class EmailServiceExtension extends Extension
{

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return EmailServiceBundle::KEY;
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        //        $config = $this->processConfiguration(new Configuration(FALSE), $configs);
        //
        //        $container->setParameter(EmailServiceBundle::KEY, $config);

        var_dump($configs);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator([
                __DIR__ . '/../Resources/config',
                __DIR__ . '/../Resources/config/packages',
                __DIR__ . '/../Resources/config/services',
            ])
        );

        $loader->load('services.yml');
    }

}