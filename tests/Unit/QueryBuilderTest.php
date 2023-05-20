<?php

use Surreal\Client;
use Tests\Fixtures\PersonModel;

test('basic sql query', function () {
	Client::configure($config = createClientConfig());

	$query = PersonModel::query()
		->where('name', 'Tobie')
		->from('person')
		->select('name');

	[$sql, $parameters] = $query->toSql();

	expect($sql)->toBe('SELECT * FROM person WHERE name = $name_0;')
		->and($parameters)->toBe(['name_0' => 'Tobie']);
});

test('running basic query and getting all results', function () {
	Client::configure($config = createClientConfig());

	$persons = PersonModel::query()
		->where('name', 'Tobie')
		->get();

	expect($persons)->toBeArray()
		->and($persons[0])->toBeInstanceOf(PersonModel::class);

});

test('running basic query and getting first result', function () {
	Client::configure($config = createClientConfig());

	$person = PersonModel::query()
		->where('name', 'Tobie')
		->first();

	expect($person)->toBeArray()
		->and($person)->toBeInstanceOf(PersonModel::class)
		->and($person->name)->toBe('Tobie');
});