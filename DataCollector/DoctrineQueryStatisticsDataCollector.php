<?php

namespace SensioLabs\DoctrineQueryStatisticsBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Logging\DebugStack;
use SensioLabs\DoctrineQueryStatisticsBundle\Analyzer\Query as QueryAnalyzer;

class DoctrineQueryStatisticsDataCollector extends DataCollector
{

    private $loggers = array();

    private function countGroupedQueries(array $queries)
    {
        return array_sum(array_map('count', $queries));
    }

    /**
     * Adds the stack logger for a doctrine connection.
     *
     * @param string     $name
     * @param DebugStack $logger
     */
    public function addLogger($name, DebugStack $logger)
    {
        $this->loggers[$name] = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        foreach ($this->loggers as $name => $logger) {
            $this->data['queries'][$name] = $logger->queries;

            $this->data['queryAnalyzers'][$name] = new QueryAnalyzer();
            foreach($this->data['queries'][$name] as $query)
            {
                $this->data['queryAnalyzers'][$name]->addQuery($query['sql'], $query['params']);
            }

            $this->data['identical'][$name] = $this->data['queryAnalyzers'][$name]->getIdenticalQueries();
            $this->data['similar'][$name] = $this->data['queryAnalyzers'][$name]->getSimilarQueries();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'doctrinequerystatistics';
    }

    public function getQueries()
    {
        return $this->data['queries'];
    }

    public function getQueriesCount()
    {
        return $this->countGroupedQueries($this->data['queries']);
    }

    public function getIdenticalQueries()
    {
        return $this->data['identical'];
    }

    public function getIdenticalQueriesCount()
    {
        return $this->countGroupedQueries($this->data['identical']);
    }

    public function getSimilarQueries()
    {
        return $this->data['similar'];
    }

    public function getSimilarQueriesCount()
    {
        return $this->countGroupedQueries($this->data['similar']);
    }
}
