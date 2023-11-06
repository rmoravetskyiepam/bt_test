<?php

namespace App\Service;

use App\Entity\Enum\StatusType;
use App\Repository\SupportCaseRepository;

class SupportCaseService
{
    public function __construct(
        private readonly SupportCaseRepository $supportCaseRepository
    )
    {}

    public function getFullSupportCaseAnalyticData(): array
    {
        $supportCasesAmounts = ['all' => 0];
        foreach (StatusType::arrayFormat() as $typeName => $typeValue) {
            $key = strtolower($typeName);
            $supportCasesAmounts[$key] = $this->supportCaseRepository->getAmountOfCasesByStatus($typeValue);
            $supportCasesAmounts['all'] += $supportCasesAmounts[$key];
        }

        return $supportCasesAmounts;
    }
}
