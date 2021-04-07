<?php

use Tester\Assert;
use Inteve\Authorizator\IAuthorizator;

require __DIR__ . '/../bootstrap.php';

$adapter = new Inteve\Authorizator\SimpleAdapter(IAuthorizator::ADMIN, [
	'users.userRole.delete' => IAuthorizator::DENY,
	'posts' => IAuthorizator::DENY,
	'photos' => IAuthorizator::DENY,
	'photos.gallery' => IAuthorizator::ADMIN,
]);

Assert::true($adapter->getAccessLevel('users.userRole.delete') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('users.userRole.delete.other') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('users.userRole.edit') === IAuthorizator::ADMIN);
Assert::true($adapter->getAccessLevel('users.userRole.create') === IAuthorizator::ADMIN);
Assert::true($adapter->getAccessLevel('users.userRole') === IAuthorizator::ADMIN);
Assert::true($adapter->getAccessLevel('users') === IAuthorizator::ADMIN);


Assert::true($adapter->getAccessLevel('posts.categories.create.other') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('posts.categories.create') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('posts.userRole.edit') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('posts.userRole.create') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('posts.userRole') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('posts') === IAuthorizator::DENY);


Assert::true($adapter->getAccessLevel('photos') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('photos.photo.upload') === IAuthorizator::DENY);
Assert::true($adapter->getAccessLevel('photos.gallery') === IAuthorizator::ADMIN);
Assert::true($adapter->getAccessLevel('photos.gallery.create') === IAuthorizator::ADMIN);
