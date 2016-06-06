<?php

	namespace Inteve\Authorizator;

	use Nette\Security\User;


	class UserLoggedAuthorizator implements IAuthorizator
	{
		/** @var User */
		protected $user;


		public function __construct(User $user)
		{
			$this->user = $user;
		}


		/**
		 * @inheritdoc
		 */
		public function authorize($resource, $action, $parameters = NULL)
		{
			if (!$this->user->isLoggedIn()) {
				throw new AuthorizationException('User is not logged in.');
			}
			return TRUE;
		}
	}
