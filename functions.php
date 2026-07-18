<?php

declare(strict_types=1);

/**
 * Sorts values in ascending order and removes duplicates.
 *
 * The function keeps the original public API for backward compatibility.
 * Array keys are not preserved.
 *
 * @param array<int|string, int|float|string> $values
 *
 * @return list<int|float|string>
 */
function qsort(array $values): array
{
	if (count($values) < 2) {
		return array_values($values);
	}

	$pivot = $values[array_key_first($values)];
	$less = [];
	$greater = [];

	foreach ($values as $value) {
		if ($value < $pivot) {
			$less[] = $value;
		} elseif ($value > $pivot) {
			$greater[] = $value;
		}
	}

	return array_merge(qsort($less), [$pivot], qsort($greater));
}

/**
 * Sorts values in ascending order and preserves duplicates.
 *
 * Array keys are not preserved.
 *
 * @param array<int|string, int|float|string> $values
 *
 * @return list<int|float|string>
 */
function qsortWithRepeats(array $values): array
{
	if (count($values) < 2) {
		return array_values($values);
	}

	$pivotKey = array_key_first($values);
	$pivot = $values[$pivotKey];
	$less = [];
	$equal = [];
	$greater = [];

	foreach ($values as $value) {
		if ($value < $pivot) {
			$less[] = $value;
		} elseif ($value > $pivot) {
			$greater[] = $value;
		} else {
			$equal[] = $value;
		}
	}

	return array_merge(
		qsortWithRepeats($less),
		$equal,
		qsortWithRepeats($greater),
	);
}
