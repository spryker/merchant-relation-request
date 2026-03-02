<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Updater;

use Generated\Shared\Transfer\MerchantRelationRequestTransfer;

interface AssigneeCompanyBusinessUnitUpdaterInterface
{
    public function updateAssigneeCompanyBusinessUnits(
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer
    ): MerchantRelationRequestTransfer;
}
