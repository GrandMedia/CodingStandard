<?php declare(strict_types = 1);

namespace GrandMediaCodingStandard\Foo;

use DateTime;

function bar(): void
{
}

final class Foo
{

	public function foo(int $number): void
	{
		\strlen('foo');
		DateTime::createFromFormat(\strlen('foo'), '');
		$this->foo(\strlen('foo'));
		\GrandMediaCodingStandard\Foo\bar();
	}

}
