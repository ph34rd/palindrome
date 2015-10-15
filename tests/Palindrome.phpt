<?php

require __DIR__ . '/../vendor/autoload.php';

use Ph34rd\Palindrome\Palindrome,
	Tester\Assert;

Tester\Environment::setup();

Assert::same(
	'aba',
	Palindrome::find('aba')
);

Assert::same(
	'aba',
	Palindrome::find('abaa')
);

Assert::same(
	'aba',
	palindrome_find('abaa')
);

Assert::same(
	'abaaba',
	Palindrome::find('zabaaba')
);

Assert::same(
	'abaaba',
	Palindrome::find('zabaaba')
);

Assert::same(
	'...',
	Palindrome::find('...ab a', true)
);

Assert::same(
	'字漢字',
	Palindrome::find('....!汉字 /漢字 !')
);

Assert::same(
	'äüä',
	Palindrome::find('Ä Ü Ä Ö ß')
);
