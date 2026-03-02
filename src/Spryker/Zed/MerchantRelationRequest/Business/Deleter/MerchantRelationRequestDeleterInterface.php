<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Deleter;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface MerchantRelationRequestDeleterInterface
{
    public function deleteCompanyUserMerchantRelationRequests(CompanyUserTransfer $companyUserTransfer): void;

    public function deleteCompanyBusinessUnitMerchantRelationRequests(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): void;
}
