<?php

namespace Skyweb24\ChatgptSeo\Service\Statistics;

class ServiceCountTotalSpent
{
    public function countTotalSpent(?array $statisticsUsageByModel): float
    {
        if (!$statisticsUsageByModel) {
            return 0;
        }

        $result = 0;
        foreach ($statisticsUsageByModel as $row) {
            $result += $row['value'];
        }

        return $result;
    }
}