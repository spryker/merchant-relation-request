<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Updater\UpdateStrategy;

use Generated\Shared\Transfer\MerchantRelationRequestTransfer;

interface MerchantRelationRequestUpdaterStrategyInterface
{
    public function isApplicable(MerchantRelationRequestTransfer $merchantRelationRequestTransfer): bool;

    public function execute(
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer
    ): MerchantRelationRequestTransfer;
}
