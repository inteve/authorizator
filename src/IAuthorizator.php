<?php

	namespace Inteve\Authorizator;


	interface IAuthorizator
	{
		/** @deprecated use DENIED */
		const DENY = 0;
		/** @deprecated use LIMITED */
		const OWNER = 1;
		/** @deprecated use UNLIMITED */
		const ADMIN = 2;

		const DENIED = 0;
		const LIMITED = 1;
		const UNLIMITED = 2;


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
