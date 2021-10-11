<?php

use Tester\Assert;
use Inteve\Authorizator\IAuthorizator;
use Inteve\Authorizator\IUser;
use Inteve\Authorizator\Resource;

require __DIR__ . '/../bootstrap.php';

class DummyUser implements \Inteve\Authorizator\IUser
{
	private $id;


	public function __construct($id)
	{
		$this->id = $id;
	}


	public function getUserId()
	{
		return $this->id;
	}
}

class PostsVoter implements \Inteve\Authorizator\IVoter
{
	public function isOwnedBy(IUser $user, Resource $resource, $object = NULL)
	{
		if ($resource->is('posts')) {
			return TRUE;
		}

		if ($resource->isUnder('posts')) {
			if ($resource->is('posts.create')) {
				return TRUE;
			}

			return FALSE;
		}

		return self::ABSTAIN;
	}
}

class UsersVoter implements \Inteve\Authorizator\IVoter
{
	public function isOwnedBy(IUser $user, Resource $resource, $object = NULL)
	{
		if ($resource->is('users')) {
			return self::ALLOW;
		}

		if ($resource->isUnder('users')) {
			if ($resource->is('users.edit')) {
				return self::ALLOW;
			}

			return self::DENY;
		}

		return self::ABSTAIN;
	}
}

class VoterAuthorizatorFactory implements \Inteve\Authorizator\IAuthorizatorFactory
{
	public function create($userId)
	{
		$adapter = new Inteve\Authorizator\SimpleAdapter(IAuthorizator::UNLIMITED, [
			'users' => IAuthorizator::LIMITED,
			'posts' => IAuthorizator::LIMITED,
			'noVoter' => IAuthorizator::LIMITED,
			'photos' => IAuthorizator::DENIED,
			'photos.gallery' => IAuthorizator::UNLIMITED,
			'invalidLevel' => 'invalid',
		]);

		return new \Inteve\Authorizator\VoterAuthorizator(
			new DummyUser($userId),
			[
				new UsersVoter,
				new PostsVoter,
			],
			$adapter
		);
	}
}


$authorizatorFactory = new VoterAuthorizatorFactory;
$authorizator = $authorizatorFactory->create(123);

test('Basic', function () use ($authorizator) {
	Assert::true($authorizator->isAllowed('users'));
	Assert::true($authorizator->isAllowed('users.edit'));
	Assert::false($authorizator->isAllowed('users.create'));

	Assert::true($authorizator->isAllowed('posts'));
	Assert::true($authorizator->isAllowed('posts.create'));
	Assert::false($authorizator->isAllowed('posts.edit'));

	Assert::false($authorizator->isAllowed('photos'));
	Assert::false($authorizator->isAllowed('photos.edit'));
	Assert::false($authorizator->isAllowed('photos.create'));
	Assert::true($authorizator->isAllowed('photos.gallery'));

	Assert::false($authorizator->isAllowed('noVoter'));
	Assert::true($authorizator->isAllowed('photos.gallery'));
});


test('Method isAdmin', function () use ($authorizator) {
	Assert::true($authorizator->isAdmin('photos.gallery'));
	Assert::false($authorizator->isAdmin('photos'));
});


test('Callable tester', function () use ($authorizator) {
	Assert::true($authorizator->isAllowed(function ($user, $object) {
		Assert::same(123, $user->getUserId());
		Assert::null($object);

		return TRUE;
	}));


	Assert::false($authorizator->isAllowed(function ($user, $object) {
		Assert::same(123, $user->getUserId());
		Assert::null($object);

		return FALSE;
	}));


	Assert::exception(function () use ($authorizator) {
		$authorizator->isAllowed(function () {
			return 'Invalid';
		});
	}, \Inteve\Authorizator\InvalidValueException::class, "Resource callback must return bool, string returned.");
});


test('Invalid level from Adapter', function () use ($authorizator) {
	Assert::exception(function () use ($authorizator) {
		$authorizator->isAllowed('invalidLevel');

	}, \Inteve\Authorizator\InvalidValueException::class, "Invalid access level 'invalid'.");
});



test('Invalid resource ID', function () use ($authorizator) {
	Assert::exception(function () use ($authorizator) {
		$authorizator->isAllowed(123);

	}, \Inteve\Authorizator\InvalidValueException::class, "Invalid resource type.");
});
