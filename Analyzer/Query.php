<?php

namespace SensioLabs\DoctrineQueryStatisticsBundle\Analyzer;

class Query
{
    private $queries = array();

    public function addQuery($sql, $parameters = array())
    {
        $this->queries[] = array(
            'sql' => $sql,
            'parameters' => $parameters
        );
    }

    public function getQueryCount()
    {
        return count($this->queries);
    }

    public function getIdenticalQueries()
    {
        $groupedQueries = array();
        foreach($this->queries as $query)
        {
            $queryKey = $this->generateQueryKeyWithParameters($query['sql'], $query['parameters']);
            $groupedQueries[$queryKey][] = $query;
        }

        return $this->filterIndistinctQueries($groupedQueries);
    }

    public function getSimilarQueries()
    {
        $groupedQueries = array();
        foreach($this->queries as $query)
        {
            $queryKey = $this->generateQueryKeyWithoutParameters($query['sql']);
            $groupedQueries[$queryKey][] = $query;
        }

        return $this->filterIndistinctQueries($groupedQueries);
    }

    private function generateQueryKeyWithParameters($sql, array $parameters)
    {
        return $this->generateQueryKeyWithoutParameters($sql) . ':' . sha1(serialize($parameters));
    }

    private function generateQueryKeyWithoutParameters($sql)
    {
        return sha1($sql);
    }

    private function filterIndistinctQueries(array $allQueries)
    {
        $indistinctQueries = array();
        foreach($allQueries as $queryKey => $queries)
        {
            if (count($queries) > 1)
            {
                $indistinctQueries[$queryKey] = array(
                    'sql' => $queries[0]['sql'],
                    'count' => count($queries),
                    'parameters' => $queries[0]['parameters']
                );
            }
        }

        return $indistinctQueries;
    }
}