<?php

	namespace Inteve\Authorizator;


	interface IAdapter
	{
		/**
		 * @param  string $resource  for example 'post.create'
		 * @return int  see constants in IAuthorizator
		 */
		function getAccessLevel($resource);
	}
