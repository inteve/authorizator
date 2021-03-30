<?php

	namespace Inteve\Authorizator;


	interface IVoter
	{
		const GRANTED = TRUE;
		const DENY = FALSE;
		const ABSTAIN = NULL;


		/**
		 * @param  object|NULL $object
		 * @return bool|NULL
		 */
		function isOwnedBy(IUser $user, Resource $resource, $object = NULL);
	}
