<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\MerchantRelationRequest\Api\Backend\Plugin;

use Codeception\Test\Unit;
use Generated\Api\Backend\MerchantsBackendResource;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Glue\MerchantRelationRequest\Api\Backend\Plugin\MerchantRelationRequestTransferExpanderPlugin;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group MerchantRelationRequest
 * @group Api
 * @group Backend
 * @group Plugin
 * @group MerchantRelationRequestTransferExpanderPluginTest
 * Add your own group annotations below this line
 */
class MerchantRelationRequestTransferExpanderPluginTest extends Unit
{
    public function testExpandSetsIsOpenForRelationRequestFromTheResource(): void
    {
        // Arrange
        $merchantRelationRequestTransferExpanderPlugin = new MerchantRelationRequestTransferExpanderPlugin();
        $merchantTransfer = new MerchantTransfer();
        $merchantsBackendResource = new MerchantsBackendResource();
        $merchantsBackendResource->isOpenForRelationRequest = true;

        // Act
        $merchantTransfer = $merchantRelationRequestTransferExpanderPlugin->expand($merchantTransfer, $merchantsBackendResource);

        // Assert
        $this->assertTrue($merchantTransfer->getIsOpenForRelationRequest());
    }

    public function testExpandLeavesTheCurrentValueUntouchedWhenTheResourcePropertyIsNotSent(): void
    {
        // Arrange
        $merchantRelationRequestTransferExpanderPlugin = new MerchantRelationRequestTransferExpanderPlugin();
        $merchantTransfer = (new MerchantTransfer())->setIsOpenForRelationRequest(true);
        $merchantsBackendResource = new MerchantsBackendResource();

        // Act
        $merchantTransfer = $merchantRelationRequestTransferExpanderPlugin->expand($merchantTransfer, $merchantsBackendResource);

        // Assert
        $this->assertTrue($merchantTransfer->getIsOpenForRelationRequest());
    }
}
