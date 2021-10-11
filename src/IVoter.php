<?php

	namespace Inteve\Authorizator;


	interface IVoter
	{
		/** @deprecated use ALLOW */
		const GRANTED = TRUE;
		const ALLOW = TRUE;
		const DENY = FALSE;
		const ABSTAIN = NULL;


		/**
		 * @param  object|NULL $object
		 * @return bool|NULL
		 */
		function isOwnedBy(IUser $user, Resource $resource, $object = NULL);
	}
