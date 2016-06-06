<?php

	namespace Inteve\Authorizator;


	abstract class Authorizator implements IAuthorizator
	{
		/**
		 * @inheritdoc
		 */
		public function isAllowed($resource, $action, $parameters = NULL)
		{
			try {
				$this->authorize($resource, $action, $parameters);

			} catch (AuthorizationException $e) {
				return FALSE;
			}
			return TRUE;
		}
	}
