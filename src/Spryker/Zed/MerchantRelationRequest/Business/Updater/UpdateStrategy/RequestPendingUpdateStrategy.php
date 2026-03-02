<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Updater\UpdateStrategy;

use Generated\Shared\Transfer\MerchantRelationRequestTransfer;
use Spryker\Shared\MerchantRelationRequest\MerchantRelationRequestConfig as SharedMerchantRelationRequestConfig;
use Spryker\Zed\MerchantRelationRequest\Business\Exception\MerchantRelationRequestNotFoundException;
use Spryker\Zed\MerchantRelationRequest\Business\Reader\MerchantRelationRequestReaderInterface;
use Spryker\Zed\MerchantRelationRequest\MerchantRelationRequestConfig;
use Spryker\Zed\MerchantRelationRequest\Persistence\MerchantRelationRequestEntityManagerInterface;

class RequestPendingUpdateStrategy implements MerchantRelationRequestUpdaterStrategyInterface
{
    /**
     * @var \Spryker\Zed\MerchantRelationRequest\Persistence\MerchantRelationRequestEntityManagerInterface
     */
    protected MerchantRelationRequestEntityManagerInterface $merchantRelationRequestEntityManager;

    /**
     * @var \Spryker\Zed\MerchantRelationRequest\Business\Reader\MerchantRelationRequestReaderInterface
     */
    protected MerchantRelationRequestReaderInterface $merchantRelationRequestReader;

    /**
     * @var \Spryker\Zed\MerchantRelationRequest\MerchantRelationRequestConfig
     */
    protected MerchantRelationRequestConfig $merchantRelationRequestConfig;

    public function __construct(
        MerchantRelationRequestEntityManagerInterface $merchantRelationRequestEntityManager,
        MerchantRelationRequestReaderInterface $merchantRelationRequestReader,
        MerchantRelationRequestConfig $merchantRelationRequestConfig
    ) {
        $this->merchantRelationRequestEntityManager = $merchantRelationRequestEntityManager;
        $this->merchantRelationRequestReader = $merchantRelationRequestReader;
        $this->merchantRelationRequestConfig = $merchantRelationRequestConfig;
    }

    public function isApplicable(MerchantRelationRequestTransfer $merchantRelationRequestTransfer): bool
    {
        return $merchantRelationRequestTransfer->getStatusOrFail() === SharedMerchantRelationRequestConfig::STATUS_PENDING;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantRelationRequestTransfer $merchantRelationRequestTransfer
     *
     * @throws \Spryker\Zed\MerchantRelationRequest\Business\Exception\MerchantRelationRequestNotFoundException
     *
     * @return \Generated\Shared\Transfer\MerchantRelationRequestTransfer
     */
    public function execute(
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer
    ): MerchantRelationRequestTransfer {
        $persistedMerchantRelationRequest = $this->merchantRelationRequestReader->findMerchantRelationRequestByUuid(
            $merchantRelationRequestTransfer->getUuidOrFail(),
        );

        if (!$persistedMerchantRelationRequest) {
            throw new MerchantRelationRequestNotFoundException();
        }

        foreach ($this->merchantRelationRequestConfig->getModifiableFieldsAllowedForPendingUpdate() as $allowedField) {
            $persistedMerchantRelationRequest->offsetSet($allowedField, $merchantRelationRequestTransfer->offsetGet($allowedField));
        }

        return $this->merchantRelationRequestEntityManager
            ->updateMerchantRelationRequest($persistedMerchantRelationRequest);
    }
}
