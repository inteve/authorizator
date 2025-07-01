<?php

	declare(strict_types=1);

	namespace Inteve\Authorizator;

	use Nette\Utils\Strings;


	class Resource
	{
		/** @var string */
		private $resource;


		/**
		 * @param string $resource
		 */
		public function __construct($resource)
		{
			$this->resource = $resource;
		}


		/**
		 * @param  string $resource
		 * @return bool
		 */
		public function is($resource)
		{
			return $this->resource === $resource;
		}


		/**
		 * @param  string $resource
		 * @return bool
		 */
		public function isUnder($resource)
		{
			return Strings::startsWith($this->resource, $resource . '.');
		}
	}
