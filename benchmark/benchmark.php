<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

const BENCHMARK_SIZE = 5000;
const BENCHMARK_ITERATIONS = 5;

$random = [];

for ($index = 0; $index < BENCHMARK_SIZE; $index++) {
	$random[] = random_int(0, BENCHMARK_SIZE * 10);
}

$sorted = $random;
sort($sorted);
$reversed = array_reverse($sorted);

$datasets = [
	'random' => $random,
	'sorted' => $sorted,
	'reversed' => $reversed,
];

printf("PHP %s, %d values, %d iterations\n\n", PHP_VERSION, BENCHMARK_SIZE, BENCHMARK_ITERATIONS);

foreach ($datasets as $name => $values) {
	$quickSortTime = measure(static fn (): array => quickSort($values));
	$nativeSortTime = measure(static function () use ($values): array {
		$result = $values;
		sort($result);

		return $result;
	});

	printf(
		"%-10s quickSort: %8.3f ms | sort: %8.3f ms | ratio: %6.1fx\n",
		$name,
		$quickSortTime,
		$nativeSortTime,
		$nativeSortTime > 0.0 ? $quickSortTime / $nativeSortTime : 0.0,
	);
}

/**
 * Returns the median execution time in milliseconds.
 *
 * @param callable(): array $operation
 */
function measure(callable $operation): float
{
	$durations = [];

	for ($iteration = 0; $iteration < BENCHMARK_ITERATIONS; $iteration++) {
		$startedAt = hrtime(true);
		$operation();
		$durations[] = (hrtime(true) - $startedAt) / 1_000_000;
	}

	sort($durations);

	return $durations[intdiv(count($durations), 2)];
}
