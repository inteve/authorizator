<?php

	declare(strict_types=1);

	namespace Inteve\Authorizator;


	interface IUser
	{
		/**
		 * @return int|string
		 */
		function getUserId();
	}
