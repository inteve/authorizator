<?php

	namespace Inteve\Authorizator;


	class DummyAuthorizator extends Authorizator
	{
		/**
		 * @inheritdoc
		 */
		public function authorize($resource, $action, $parameters = NULL)
		{
			return TRUE;
		}
	}
