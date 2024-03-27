<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Reader;

interface MerchantReaderInterface
{
    /**
     * @param list<int> $merchantIds
     *
     * @return array<int, \Generated\Shared\Transfer\MerchantTransfer>
     */
    public function getMerchantsIndexedByIdMerchant(array $merchantIds): array;
}
