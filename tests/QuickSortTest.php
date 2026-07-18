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

	public function testQuickSortSupportsDescendingComparator(): void
	{
		$result = quickSort(
			[3, 1, 4, 2],
			static fn (int $left, int $right): int => $right <=> $left,
		);

		self::assertSame([4, 3, 2, 1], $result);
	}

	public function testQuickSortSupportsObjects(): void
	{
		$items = [
			(object) ['name' => 'Gamma', 'priority' => 30],
			(object) ['name' => 'Alpha', 'priority' => 10],
			(object) ['name' => 'Beta', 'priority' => 20],
		];

		$result = quickSort(
			$items,
			static fn (object $left, object $right): int => $left->priority <=> $right->priority,
		);

		self::assertSame(['Alpha', 'Beta', 'Gamma'], array_column($result, 'name'));
	}

	public function testQuickSortCanRemoveComparatorEquivalentValues(): void
	{
		$items = [
			['id' => 1, 'group' => 'a'],
			['id' => 2, 'group' => 'a'],
			['id' => 3, 'group' => 'b'],
		];

		$result = quickSort(
			$items,
			static fn (array $left, array $right): int => $left['group'] <=> $right['group'],
			preserveDuplicates: false,
		);

		self::assertCount(2, $result);
		self::assertSame(['a', 'b'], array_column($result, 'group'));
	}

	public function testMedianOfThreePivotHandlesOrderedInput(): void
	{
		$values = range(1, 1000);

		self::assertSame($values, quickSort($values));
		self::assertSame($values, quickSort(array_reverse($values)));
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
