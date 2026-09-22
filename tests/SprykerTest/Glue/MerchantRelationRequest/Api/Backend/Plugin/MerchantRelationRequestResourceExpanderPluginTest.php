<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\MerchantRelationRequest\Api\Backend\Plugin;

use Codeception\Test\Unit;
use Generated\Api\Backend\MerchantsBackendResource;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Glue\MerchantRelationRequest\Api\Backend\Plugin\MerchantRelationRequestResourceExpanderPlugin;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group MerchantRelationRequest
 * @group Api
 * @group Backend
 * @group Plugin
 * @group MerchantRelationRequestResourceExpanderPluginTest
 * Add your own group annotations below this line
 */
class MerchantRelationRequestResourceExpanderPluginTest extends Unit
{
    public function testExpandSetsIsOpenForRelationRequestFromTheMerchantTransfer(): void
    {
        // Arrange
        $merchantRelationRequestResourceExpanderPlugin = new MerchantRelationRequestResourceExpanderPlugin();
        $merchantTransfer = (new MerchantTransfer())->setIsOpenForRelationRequest(true);
        $merchantsBackendResource = new MerchantsBackendResource();

        // Act
        $merchantsBackendResource = $merchantRelationRequestResourceExpanderPlugin->expand($merchantsBackendResource, $merchantTransfer);

        // Assert
        $this->assertSame(
            [
                'merchantReference' => null,
                'name' => null,
                'email' => null,
                'registrationNumber' => null,
                'status' => null,
                'isActive' => null,
                'stores' => null,
                'merchantUrls' => null,
                'warehouses' => null,
                'merchantProfile' => null,
                'isOpenForRelationRequest' => true,
            ],
            $merchantsBackendResource->toArray(),
        );
    }

    public function testExpandCarriesOverANullValue(): void
    {
        // Arrange
        $merchantRelationRequestResourceExpanderPlugin = new MerchantRelationRequestResourceExpanderPlugin();
        $merchantTransfer = (new MerchantTransfer())->setIsOpenForRelationRequest(null);
        $merchantsBackendResource = new MerchantsBackendResource();

        // Act
        $merchantsBackendResource = $merchantRelationRequestResourceExpanderPlugin->expand($merchantsBackendResource, $merchantTransfer);

        // Assert
        $this->assertSame(
            [
                'merchantReference' => null,
                'name' => null,
                'email' => null,
                'registrationNumber' => null,
                'status' => null,
                'isActive' => null,
                'stores' => null,
                'merchantUrls' => null,
                'warehouses' => null,
                'merchantProfile' => null,
                'isOpenForRelationRequest' => null,
            ],
            $merchantsBackendResource->toArray(),
        );
    }
}
