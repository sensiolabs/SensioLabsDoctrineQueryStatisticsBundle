# SensioLabsDoctrineQueryStatisticsBundle

## About

This bundle adds a tab to your Profiler which gathers statistical information about the Doctrine queries that have
been executed during a request.

Right now the bundle generates statistical information about:

- Duplicate queries
- Similar queries (same queries with different parameters)

## Installation

Add a requirement in your composer.json for the `sensiolabs/doctrine-query-statistics-bundle` package:

            "sensiolabs/doctrine-query-statistics-bundle": "*"

Add the SensioLabsDoctrineQueryStatisticsBundle to your application's kernel:

    public function registerBundles()
    {
        $bundles = array(
            ...
            new SensioLabs\DoctrineQueryStatisticsBundle\SensioLabsDoctrineQueryStatisticsBundle(),
            ...
        );
        ...
    }

## License

Released under the MIT License, see LICENSE.