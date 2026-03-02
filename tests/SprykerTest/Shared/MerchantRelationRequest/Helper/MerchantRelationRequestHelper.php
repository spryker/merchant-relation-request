<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Shared\MerchantRelationRequest\Helper;

use ArrayObject;
use Codeception\Module;
use Generated\Shared\DataBuilder\MerchantRelationRequestBuilder;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\MerchantRelationRequestTransfer;
use Orm\Zed\MerchantRelationRequest\Persistence\SpyMerchantRelationRequest;
use Orm\Zed\MerchantRelationRequest\Persistence\SpyMerchantRelationRequestQuery;
use Orm\Zed\MerchantRelationRequest\Persistence\SpyMerchantRelationRequestToCompanyBusinessUnit;
use Orm\Zed\MerchantRelationRequest\Persistence\SpyMerchantRelationRequestToCompanyBusinessUnitQuery;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;

class MerchantRelationRequestHelper extends Module
{
    use DataCleanupHelperTrait;

    /**
     * @param array<string, mixed> $seed
     *
     * @return \Generated\Shared\Transfer\MerchantRelationRequestTransfer
     */
    public function haveMerchantRelationRequest(array $seed = []): MerchantRelationRequestTransfer
    {
        $merchantRelationRequestTransfer = (new MerchantRelationRequestBuilder($seed))->build();
        if (isset($seed[MerchantRelationRequestTransfer::ASSIGNEE_COMPANY_BUSINESS_UNITS])) {
            $merchantRelationRequestTransfer->setAssigneeCompanyBusinessUnits(
                $seed[MerchantRelationRequestTransfer::ASSIGNEE_COMPANY_BUSINESS_UNITS],
            );
        }

        $merchantRelationRequestEntity = (new SpyMerchantRelationRequest())
            ->fromArray($merchantRelationRequestTransfer->toArray())
            ->setFkMerchant($merchantRelationRequestTransfer->getMerchantOrFail()->getIdMerchantOrFail())
            ->setFkCompanyUser($merchantRelationRequestTransfer->getCompanyUserOrFail()->getIdCompanyUserOrFail())
            ->setFkCompanyBusinessUnit($merchantRelationRequestTransfer->getOwnerCompanyBusinessUnitOrFail()->getIdCompanyBusinessUnitOrFail());

        $merchantRelationRequestEntity->save();
        $persistedMerchantRelationRequest = (new MerchantRelationRequestTransfer())
            ->fromArray($merchantRelationRequestEntity->toArray(), true);

        if ($merchantRelationRequestTransfer->getAssigneeCompanyBusinessUnits()) {
            $assigneeCompanyBusinessUnits = [];

            foreach ($merchantRelationRequestTransfer->getAssigneeCompanyBusinessUnits() as $companyBusinessUnitTransfer) {
                $assigneeCompanyBusinessUnits[] = $this->createAssigneeCompanyBusinessUnit(
                    $merchantRelationRequestEntity->getIdMerchantRelationRequest(),
                    $companyBusinessUnitTransfer->getIdCompanyBusinessUnitOrFail(),
                );
            }

            $persistedMerchantRelationRequest->setAssigneeCompanyBusinessUnits(
                new ArrayObject($assigneeCompanyBusinessUnits),
            );
        }

        $this->getDataCleanupHelper()->_addCleanup(function () use ($merchantRelationRequestEntity): void {
            $this->deleteMerchantRelationRequest($merchantRelationRequestEntity->getIdMerchantRelationRequest());
        });

        return $persistedMerchantRelationRequest;
    }

    protected function createAssigneeCompanyBusinessUnit(
        int $idMerchantRelationRequest,
        int $idCompanyBusinessUnit
    ): CompanyBusinessUnitTransfer {
        $merchantRelationRequestToCompanyBusinessUnitEntity = (new SpyMerchantRelationRequestToCompanyBusinessUnit())
            ->setFkMerchantRelationRequest($idMerchantRelationRequest)
            ->setFkCompanyBusinessUnit($idCompanyBusinessUnit);

        $merchantRelationRequestToCompanyBusinessUnitEntity->save();

        $this->getDataCleanupHelper()->_addCleanup(function () use ($merchantRelationRequestToCompanyBusinessUnitEntity): void {
            $this->deleteAssigneeCompanyBusinessUnit($merchantRelationRequestToCompanyBusinessUnitEntity->getIdMerchantRelationRequestToCompanyBusinessUnit());
        });

        return (new CompanyBusinessUnitTransfer())->fromArray(
            $merchantRelationRequestToCompanyBusinessUnitEntity->getCompanyBusinessUnit()->toArray(),
            true,
        );
    }

    protected function deleteMerchantRelationRequest(int $idMerchantRelationRequest): void
    {
        $merchantRelationRequestEntity = $this->getMerchantRelationRequestQuery()
            ->findOneByIdMerchantRelationRequest($idMerchantRelationRequest);

        if ($merchantRelationRequestEntity) {
            $merchantRelationRequestEntity->delete();
        }
    }

    protected function deleteAssigneeCompanyBusinessUnit(
        int $idMerchantRelationRequestToCompanyBusinessUnit
    ): void {
        $merchantRelationRequestToCompanyBusinessUnitEntity = $this->getMerchantRelationRequestToCompanyBusinessUnitQuery()
            ->findOneByIdMerchantRelationRequestToCompanyBusinessUnit($idMerchantRelationRequestToCompanyBusinessUnit);

        if ($merchantRelationRequestToCompanyBusinessUnitEntity) {
            $merchantRelationRequestToCompanyBusinessUnitEntity->delete();
        }
    }

    protected function getMerchantRelationRequestQuery(): SpyMerchantRelationRequestQuery
    {
        return SpyMerchantRelationRequestQuery::create();
    }

    protected function getMerchantRelationRequestToCompanyBusinessUnitQuery(): SpyMerchantRelationRequestToCompanyBusinessUnitQuery
    {
        return SpyMerchantRelationRequestToCompanyBusinessUnitQuery::create();
    }
}
