<?php

namespace Notifier\Common\ExecutionStats;

class ScriptRunStatistics
{
    public static function printStats(float $startTime): void
    {
        print(sprintf(
            "\n\nExecution time: %.4f seconds\nMemory peak usage: %.2f MB\n",
            microtime(true) - $startTime,
            memory_get_peak_usage(true) / 1024 / 1024
        ));
    }
}
