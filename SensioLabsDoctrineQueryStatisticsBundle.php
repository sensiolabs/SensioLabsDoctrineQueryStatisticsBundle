<?php

namespace SensioLabs\DoctrineQueryStatisticsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use SensioLabs\DoctrineQueryStatisticsBundle\DependencyInjection\CompilerPass\DataCollectorCompilerPass;

class SensioLabsDoctrineQueryStatisticsBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DataCollectorCompilerPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}
