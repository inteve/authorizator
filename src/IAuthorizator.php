<?php

	namespace Inteve\Authorizator;


	interface IAuthorizator
	{
		/**
		 * Is user allowed to perform given action with given resource.
		 *
		 * @param  mixed
		 * @param  string for example 'view', 'edit'
		 * @param  mixed|NULL array, object, array of objects,...
		 * @return bool
		 * @throws \Inteve\Security\InvalidArgumentException
		 */
		function isAllowed($resource, $action, $parameters = NULL);


		/**
		 * Is user allowed to perform given action with given resource.
		 *
		 * @param  mixed
		 * @param  string for example 'view', 'edit'
		 * @param  mixed|NULL array, object, array of objects,...
		 * @return void
		 * @throws \Inteve\Security\InvalidArgumentException
		 * @throws \Inteve\Security\AuthorizationException
		 */
		function authorize($resource, $action, $parameters = NULL);
	}
