<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Persistence;

use Generated\Shared\Transfer\MerchantRelationRequestDeleteCriteriaTransfer;
use Generated\Shared\Transfer\MerchantRelationRequestToCompanyBusinessUnitDeleteCriteriaTransfer;
use Generated\Shared\Transfer\MerchantRelationRequestTransfer;

interface MerchantRelationRequestEntityManagerInterface
{
    public function createMerchantRelationRequest(
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer
    ): MerchantRelationRequestTransfer;

    /**
     * @param int $idMerchantRelationRequest
     * @param array<int> $companyBusinessUnitIds
     *
     * @return void
     */
    public function createAssigneeCompanyBusinessUnits(int $idMerchantRelationRequest, array $companyBusinessUnitIds): void;

    public function updateMerchantRelationRequest(
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer
    ): MerchantRelationRequestTransfer;

    public function deleteMerchantRelationRequestCollection(
        MerchantRelationRequestDeleteCriteriaTransfer $merchantRelationRequestDeleteCriteriaTransfer
    ): void;

    public function deleteMerchantRelationRequestToCompanyBusinessUnitCollection(
        MerchantRelationRequestToCompanyBusinessUnitDeleteCriteriaTransfer $merchantRelationRequestToCompanyBusinessUnitDeleteCriteriaTransfer
    ): void;
}
