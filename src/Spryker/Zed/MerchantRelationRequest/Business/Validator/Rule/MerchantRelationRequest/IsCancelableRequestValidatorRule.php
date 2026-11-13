<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantRelationRequest\Business\Validator\Rule\MerchantRelationRequest;

use Generated\Shared\Transfer\ErrorCollectionTransfer;
use Generated\Shared\Transfer\MerchantRelationRequestTransfer;
use Spryker\Shared\MerchantRelationRequest\MerchantRelationRequestConfig as SharedMerchantRelationRequestConfig;
use Spryker\Zed\MerchantRelationRequest\Business\Reader\MerchantRelationRequestReaderInterface;
use Spryker\Zed\MerchantRelationRequest\Business\Validator\Util\ErrorAdderInterface;
use Spryker\Zed\MerchantRelationRequest\MerchantRelationRequestConfig;

class IsCancelableRequestValidatorRule extends AbstractStatusApplicableRequestValidatorRule
{
    /**
     * @var string
     */
    protected const GLOSSARY_KEY_REQUEST_CANT_BE_CANCELED = 'merchant_relation_request.validation.cant_be_canceled';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_REQUEST_NOT_FOUND = 'merchant_relation_request.validation.not_found';

    protected ErrorAdderInterface $errorAdder;

    protected MerchantRelationRequestConfig $merchantRelationRequestConfig;

    protected MerchantRelationRequestReaderInterface $merchantRelationRequestReader;

    public function __construct(
        ErrorAdderInterface $errorAdder,
        MerchantRelationRequestConfig $merchantRelationRequestConfig,
        MerchantRelationRequestReaderInterface $merchantRelationRequestReader
    ) {
        $this->errorAdder = $errorAdder;
        $this->merchantRelationRequestConfig = $merchantRelationRequestConfig;
        $this->merchantRelationRequestReader = $merchantRelationRequestReader;
    }

    protected function isApplicable(MerchantRelationRequestTransfer $merchantRelationRequestTransfer): bool
    {
        $newStatus = $merchantRelationRequestTransfer->getStatusOrFail();

        return $newStatus === SharedMerchantRelationRequestConfig::STATUS_CANCELED;
    }

    /**
     * @param array<\Generated\Shared\Transfer\MerchantRelationRequestTransfer> $existingMerchantRelationRequests
     */
    protected function validateRequest(
        int|string $entityIdentifier,
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer,
        array $existingMerchantRelationRequests,
        ErrorCollectionTransfer $errorCollectionTransfer
    ): void {
        $persistedMerchantRelationRequest = $existingMerchantRelationRequests[$merchantRelationRequestTransfer->getUuidOrFail()] ?? null;

        if (!$persistedMerchantRelationRequest || !$this->isRequestOwnedByCompanyUser($persistedMerchantRelationRequest, $merchantRelationRequestTransfer)) {
            $this->errorAdder->addError(
                $errorCollectionTransfer,
                $entityIdentifier,
                static::GLOSSARY_KEY_REQUEST_NOT_FOUND,
            );

            return;
        }

        if (!$this->isRequestCancelable($persistedMerchantRelationRequest)) {
            $this->errorAdder->addError(
                $errorCollectionTransfer,
                $entityIdentifier,
                static::GLOSSARY_KEY_REQUEST_CANT_BE_CANCELED,
            );
        }
    }

    protected function isRequestOwnedByCompanyUser(
        MerchantRelationRequestTransfer $persistedMerchantRelationRequestTransfer,
        MerchantRelationRequestTransfer $merchantRelationRequestTransfer
    ): bool {
        $companyUserTransfer = $merchantRelationRequestTransfer->getCompanyUser();

        if (!$companyUserTransfer) {
            return true;
        }

        $idCompanyUser = $companyUserTransfer->getIdCompanyUser();

        return $idCompanyUser !== null
            && $persistedMerchantRelationRequestTransfer->getCompanyUser()?->getIdCompanyUser() === $idCompanyUser;
    }

    protected function isRequestCancelable(MerchantRelationRequestTransfer $merchantRelationRequestTransfer): bool
    {
        return in_array(
            $merchantRelationRequestTransfer->getStatusOrFail(),
            $this->merchantRelationRequestConfig->getCancelableRequestStatuses(),
            true,
        );
    }
}
