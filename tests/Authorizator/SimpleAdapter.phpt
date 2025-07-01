<?php

declare(strict_types=1);

use Tester\Assert;
use Inteve\Authorizator\IAuthorizator;

require __DIR__ . '/../bootstrap.php';

$adapter = new Inteve\Authorizator\SimpleAdapter(IAuthorizator::UNLIMITED, [
	'users.userRole.delete' => IAuthorizator::DENIED,
	'posts' => IAuthorizator::DENIED,
	'photos' => IAuthorizator::DENIED,
	'photos.gallery' => IAuthorizator::UNLIMITED,
]);

Assert::true($adapter->getAccessLevel('users.userRole.delete') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('users.userRole.delete.other') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('users.userRole.edit') === IAuthorizator::UNLIMITED);
Assert::true($adapter->getAccessLevel('users.userRole.create') === IAuthorizator::UNLIMITED);
Assert::true($adapter->getAccessLevel('users.userRole') === IAuthorizator::UNLIMITED);
Assert::true($adapter->getAccessLevel('users') === IAuthorizator::UNLIMITED);


Assert::true($adapter->getAccessLevel('posts.categories.create.other') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('posts.categories.create') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('posts.userRole.edit') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('posts.userRole.create') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('posts.userRole') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('posts') === IAuthorizator::DENIED);


Assert::true($adapter->getAccessLevel('photos') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('photos.photo.upload') === IAuthorizator::DENIED);
Assert::true($adapter->getAccessLevel('photos.gallery') === IAuthorizator::UNLIMITED);
Assert::true($adapter->getAccessLevel('photos.gallery.create') === IAuthorizator::UNLIMITED);
