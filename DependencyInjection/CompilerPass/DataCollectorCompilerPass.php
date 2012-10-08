<?php

namespace SensioLabs\DoctrineQueryStatisticsBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DataCollectorCompilerPass implements CompilerPassInterface
{


    /**
     * {@inheritdoc}
     */
    function process(ContainerBuilder $container)
    {
        $dataCollectorDefinition = $container->getDefinition('sensiolabs.doctrinequerystatistics.data_collector');
        $connectionNames = $container->get('doctrine')->getConnectionNames();

        foreach ($connectionNames as $name => $serviceId)
        {
            $dataCollectorDefinition->addMethodCall('addLogger', array(
                $name,
                new Reference('doctrine.dbal.logger.profiling.' . $name)
            ));
        }
    }
}
