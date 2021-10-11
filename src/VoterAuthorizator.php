<?php

	namespace Inteve\Authorizator;


	class VoterAuthorizator implements IAuthorizator
	{
		/** @var IUser */
		private $user;

		/** @var IVoter[] */
		private $voters;

		/** @var IAdapter */
		private $adapter;


		/**
		 * @param IVoter[] $voters
		 */
		public function __construct(IUser $user, array $voters, IAdapter $adapter)
		{
			$this->user = $user;
			$this->voters = $voters;
			$this->adapter = $adapter;
		}


		/**
		 * @param  string $resource
		 * @return bool
		 */
		public function isAdmin($resource)
		{
			return $this->adapter->getAccessLevel($resource) === IAuthorizator::UNLIMITED;
		}


		/**
		 * @param  string|callable $resource
		 * @param  object|NULL $object
		 * @return bool
		 */
		public function isAllowed($resource, $object = NULL)
		{
			try {
				$this->authorize($resource, $object);
				return TRUE;

			} catch (AuthorizationException $e) {
			}

			return FALSE;
		}


		/**
		 * @param  string|callable $resource
		 * @param  object|NULL $object
		 * @return void
		 * @throws AuthorizationException
		 */
		public function authorize($resource, $object = NULL)
		{
			$access = IAuthorizator::DENIED;

			if (is_string($resource)) {
				$access = $this->adapter->getAccessLevel($resource);

			} elseif (is_callable($resource)) {
				$res = call_user_func($resource, $this->user, $object);

				if (is_bool($res)) {
					$access = $res ? IAuthorizator::UNLIMITED : IAuthorizator::DENIED;

				} else {
					throw new InvalidValueException('Resource callback must return bool, ' . gettype($res) . ' returned.');
				}

			} else {
				throw new InvalidValueException('Invalid resource type.');
			}

			if ($access === IAuthorizator::UNLIMITED) {
				return;
			}

			if ($access === IAuthorizator::DENIED) {
				$label = is_string($resource) ? "'$resource'" : 'callback';
				throw new AuthorizationException("Denied for resource $label.");
			}

			if ($access !== IAuthorizator::LIMITED) {
				throw new InvalidValueException("Invalid access level '$access'.");
			}

			assert(is_string($resource));

			// pokud jeden hlasuje proti, zamitame pristup (pravo VETA)
			// pokud se vsichni zdrzi, take zamitame pristup, protoze objekt nikdo nevlastni
			$allAbstain = TRUE;
			$resourceToCheck = new Resource($resource);

			foreach ($this->voters as $voter) {
				$res = $voter->isOwnedBy($this->user, $resourceToCheck, $object);

				if ($res === FALSE) {
					throw new AuthorizationException("Denied for resource '$resource'.");
				}

				if ($res === TRUE) {
					$allAbstain = FALSE;
				}
			}

			if ($allAbstain) {
				throw new AuthorizationException("Denied for resource '$resource', all voters abstain.");
			}
		}
	}
