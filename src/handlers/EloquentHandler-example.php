<?php

// Also do not forget to register class to services in config.neon

use Illuminate;
use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentHandlerExample
{

	/** @var \Nextras\TracyQueryPanel\QueryPanel */
	private $queryPanel;

	/**
	 * Boot Eloquent ORM
	 */
	public function __construct($parameters, \Nextras\TracyQueryPanel\QueryPanel $queryPanel)
	{
		$this->queryPanel = $queryPanel;

		$capsule = new Capsule;
		$capsule->addConnection($parameters);
		$capsule->setAsGlobal();
		$capsule->bootEloquent();

		$events = new Illuminate\Events\Dispatcher;
		$events->listen('illuminate.query', function ($query, $bindings, $time, $name) {
			\Nextras\TracyQueryPanel\Handlers\EloquentHandler::register($this->queryPanel, $query, $bindings, $time, $name);
		});

		$capsule->setEventDispatcher($events);
		return $capsule;
	}

}
