<?php

	namespace Inteve\Authorizator;


	interface IAuthorizator
	{
		const DENY = 0;
		const OWNER = 1;
		const ADMIN = 2;


		/**
		 * @param  string|callable $resource  for example 'post', 'post.create' or callback
		 * @param  object|NULL $object
		 * @return bool
		 * @throws InvalidArgumentException
		 * @throws InvalidValueException
		 */
		function isAllowed($resource, $object = NULL);


		/**
		 * @param  string|callable $resource  for example 'post', 'post.create' or callback
		 * @param  object|NULL $object
		 * @return void
		 * @throws InvalidArgumentException
		 * @throws InvalidValueException
		 * @throws AuthorizationException
		 */
		function authorize($resource, $object = NULL);
	}
