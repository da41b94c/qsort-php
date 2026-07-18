<?php

declare(strict_types=1);

namespace QSortPhp\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class QuickSortTest extends TestCase
{
	#[DataProvider('valuesProvider')]
	public function testQsortRemovesDuplicates(array $input, array $expected): void
	{
		self::assertSame($expected, qsort($input));
	}

	#[DataProvider('valuesWithRepeatsProvider')]
	public function testQsortWithRepeatsPreservesDuplicates(array $input, array $expected): void
	{
		self::assertSame($expected, qsortWithRepeats($input));
	}

	public function testAssociativeKeysAreNormalized(): void
	{
		self::assertSame([1, 2, 3], qsortWithRepeats([
			'c' => 3,
			'a' => 1,
			'b' => 2,
		]));
	}

	public static function valuesProvider(): iterable
	{
		yield 'empty' => [[], []];
		yield 'single value' => [[7], [7]];
		yield 'duplicates' => [[8, 99, 1, 3, 10, 199, 2, 8, 3, 99, 3], [1, 2, 3, 8, 10, 99, 199]];
		yield 'negative numbers' => [[0, -10, 5, -10, 2], [-10, 0, 2, 5]];
		yield 'strings' => [['pear', 'apple', 'pear', 'banana'], ['apple', 'banana', 'pear']];
	}

	public static function valuesWithRepeatsProvider(): iterable
	{
		yield 'empty' => [[], []];
		yield 'single value' => [[7], [7]];
		yield 'duplicates' => [[8, 99, 1, 3, 10, 199, 2, 8, 3, 99, 3], [1, 2, 3, 3, 3, 8, 8, 10, 99, 99, 199]];
		yield 'already sorted' => [[1, 2, 3, 4], [1, 2, 3, 4]];
		yield 'reverse sorted' => [[4, 3, 2, 1], [1, 2, 3, 4]];
	}
}
