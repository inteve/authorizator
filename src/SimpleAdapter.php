<?php

	namespace Inteve\Authorizator;

	use Nette\Utils\Strings;


	class SimpleAdapter implements IAdapter
	{
		/** @var int */
		private $defaultAccess;

		/** @var array<string, int> [resourceName => access] */
		private $resources;


		/**
		 * @param int $defaultAccess
		 * @param array<string, int> $resources
		 */
		public function __construct($defaultAccess, array $resources)
		{
			$this->defaultAccess = $defaultAccess;
			$this->resources = $resources;
		}


		public function getAccessLevel($resource)
		{
			if (isset($this->resources[$resource])) {
				return $this->resources[$resource];
			}

			// dedi se od shora dolu ('a.b.c' dedi z 'a.b')
			$parts = explode('.', $resource);

			do {
				array_pop($parts);
				$parentId = implode('.', $parts);

				if (isset($this->resources[$parentId])) {
					return $this->resources[$resource] = $this->resources[$parentId];
				}

			} while (!empty($parts));

			// nenasli jsme kandidata, pouzijeme vychozi pristup
			return $this->resources[$resource] = $this->defaultAccess;
		}
	}
