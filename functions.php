<?php

declare(strict_types=1);

/**
 * Sorts values with a custom comparator.
 *
 * Array keys are not preserved. Values considered equal by the comparator are
 * either all retained or collapsed to one value according to $preserveDuplicates.
 *
 * @template TValue
 *
 * @param array<array-key, TValue> $values
 * @param null|callable(TValue, TValue): int $comparator
 *
 * @return list<TValue>
 */
function quickSort(
	array $values,
	?callable $comparator = null,
	bool $preserveDuplicates = true,
): array {
	$values = array_values($values);

	if (count($values) < 2) {
		return $values;
	}

	$comparator ??= static fn (mixed $left, mixed $right): int => $left <=> $right;
	$pivot = qsortSelectPivot($values, $comparator);
	$less = [];
	$equal = [];
	$greater = [];

	foreach ($values as $value) {
		$comparison = $comparator($value, $pivot);

		if ($comparison < 0) {
			$less[] = $value;
		} elseif ($comparison > 0) {
			$greater[] = $value;
		} elseif ($preserveDuplicates || $equal === []) {
			$equal[] = $value;
		}
	}

	return array_merge(
		quickSort($less, $comparator, $preserveDuplicates),
		$equal,
		quickSort($greater, $comparator, $preserveDuplicates),
	);
}

/**
 * Sorts scalar values in ascending order and removes duplicates.
 *
 * This legacy wrapper is retained for backward compatibility.
 * Array keys are not preserved.
 *
 * @param array<array-key, int|float|string> $values
 *
 * @return list<int|float|string>
 */
function qsort(array $values): array
{
	return quickSort($values, preserveDuplicates: false);
}

/**
 * Sorts scalar values in ascending order and preserves duplicates.
 *
 * This legacy wrapper is retained for backward compatibility.
 * Array keys are not preserved.
 *
 * @param array<array-key, int|float|string> $values
 *
 * @return list<int|float|string>
 */
function qsortWithRepeats(array $values): array
{
	return quickSort($values);
}

/**
 * Selects the median of the first, middle and last values as pivot.
 *
 * This reduces consistently unbalanced partitions for common ordered inputs,
 * although quick sort can still degrade to O(n²) for adversarial data.
 *
 * @template TValue
 *
 * @param list<TValue> $values
 * @param callable(TValue, TValue): int $comparator
 *
 * @return TValue
 */
function qsortSelectPivot(array $values, callable $comparator): mixed
{
	$lastIndex = count($values) - 1;
	$candidates = [
		$values[0],
		$values[intdiv($lastIndex, 2)],
		$values[$lastIndex],
	];

	usort($candidates, $comparator);

	return $candidates[1];
}
