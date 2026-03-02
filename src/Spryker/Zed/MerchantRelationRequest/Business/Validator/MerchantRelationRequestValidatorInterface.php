<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Validator;

use Generated\Shared\Transfer\MerchantRelationRequestCollectionResponseTransfer;

interface MerchantRelationRequestValidatorInterface
{
    public function validate(
        MerchantRelationRequestCollectionResponseTransfer $merchantRelationRequestCollectionResponseTransfer
    ): MerchantRelationRequestCollectionResponseTransfer;
}
