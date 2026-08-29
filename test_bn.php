<?php
$result = \App\Models\BreakingNews::orderByDesc('priority')->latest()->paginate(20);
echo get_class($result) . PHP_EOL;
echo $result->count() . PHP_EOL;
echo $result->total() . PHP_EOL;
