<?php

namespace Nextras\TracyQueryPanel\Handlers;

use Nette;
use Nette\Utils\Html;
use Nextras\TracyQueryPanel\IQuery;
use Nextras\TracyQueryPanel\QueryPanel;
use Tracy\Dumper;

class EloquentHandler implements IQuery
{

	/** @var string */
	protected $query;

	/** @var array */
	protected $bindings;

	/** @var float */
	protected $time;

	/** @var string */
	protected $name;

	public function __construct($query, $bindings, $time, $name)
	{
		$this->query = $query;
		$this->bindings = $bindings;
		$this->time = $time;
		$this->name = $name;
	}

	public static function register(QueryPanel $queryPanel, $query, $bindings, $time, $name)
	{
		$queryPanel->addQuery(new static($query, $bindings, $time, $name));
	}

	/**
	 * Suggested behavior: print Tracy\Dumper::toHtml() array
	 * of returned rows so row count is immediately visible.
	 *
	 * @return Html|string
	 */
	public function getResult()
	{
		// TODO
		return FALSE;
	}

	/**
	 * Arbitrary identifier such as mysql, postgres, elastic, neo4j
	 *
	 * @return string
	 */
	public function getStorageType()
	{
		// TODO
		return 'mysql';
	}

	/**
	 * Database name, fulltext index or similar, NULL if not applicable
	 *
	 * @return NULL|string
	 */
	public function getDatabaseName()
	{
		return $this->name;
	}

	/**
	 * Actual formatted query, e.g. 'SELECT * FROM ...'
	 *
	 * @return Html|string
	 */
	public function getQuery()
	{
		$html = trim(Nette\Database\Helpers::dumpSql($this->query, $this->bindings));
		return Html::el()->setHtml($html);
	}

	/**
	 * @return NULL|float ms
	 */
	public function getElapsedTime()
	{
		return $this->time;
	}

	/**
	 * e.g. explain
	 *
	 * @return NULL|Html|string
	 */
	public function getInfo()
	{
		// TODO: Implement getInfo() method.
	}

}
