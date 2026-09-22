<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\MerchantRelationRequest\Api\Backend\Plugin;

use Generated\Api\Backend\MerchantsBackendResource;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Glue\MerchantExtension\Dependency\Plugin\MerchantBackendTransferExpanderPluginInterface;

class MerchantRelationRequestTransferExpanderPlugin implements MerchantBackendTransferExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     */
    public function expand(
        MerchantTransfer $merchantTransfer,
        MerchantsBackendResource $merchantsBackendResource
    ): MerchantTransfer {
        if ($merchantsBackendResource->isOpenForRelationRequest !== null) {
            $merchantTransfer->setIsOpenForRelationRequest($merchantsBackendResource->isOpenForRelationRequest);
        }

        return $merchantTransfer;
    }
}
