<?php declare(strict_types=1);

namespace EmailServiceBundle\DependencyInjection\Compiler;

use EmailServiceBundle\EmailServiceBundle;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class EmailServiceCompilerPass
 *
 * @package EmailServiceBundle\DependencyInjection\Compiler
 */
class EmailServiceCompilerPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $config = $container->getParameter(EmailServiceBundle::KEY);


    }

}