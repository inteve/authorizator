<?php

	declare(strict_types=1);

	namespace Inteve\Authorizator;


	interface IAuthorizatorFactory
	{
		/**
		 * @param  int|string $userId
		 * @return IAuthorizator
		 */
		function create($userId);
	}
