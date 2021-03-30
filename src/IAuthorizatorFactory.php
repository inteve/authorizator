<?php

	namespace Inteve\Authorizator;


	interface IAuthorizatorFactory
	{
		/**
		 * @param  int|string $userId
		 * @return IAuthorizator
		 */
		function create($userId);
	}
