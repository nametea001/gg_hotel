<?php

namespace App\Domain\Payment\Service;

use App\Domain\Payment\Repository\PaymentRepository;

/**
 * Service.
 */
final class PaymentUpdater
{
    private $repository;
    private $validator;

    public function __construct(
        PaymentRepository $repository,
        PaymentValidator $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        //$this->logger = $loggerFactory
        //->addFileHandler('store_updater.log')
        //->createInstance();
    }

    public function insertPayment(array $data): int
    {
        // Input validation
        $this->validator->validatePaymentInsert($data);

        // Map form data to row
        $paymentRow = $this->mapToPaymentRow($data);

        $id = $this->repository->insertPayment($paymentRow);


        return $id;
    }

    public function updatePayment(int $paymentId, array $data): void
    {

        $this->validator->validatePaymentUpdate($paymentId, $data);


        $storeRow = $this->mapToPaymentRow($data);

        // Insert store
        $this->repository->updatePayment($paymentId, $storeRow);
    }

    public function deletePayment(int $paymentId, array $data): void
    {
        // Insert store
        $this->repository->deletePayment($paymentId);

        // Logging
        //$this->logger->info(sprintf('Store updated successfully: %s', $storeId));
    }

    /**
     * Map data to row.
     *
     * @param array<mixed> $data The data
     *
     * @return array<mixed> The row
     */
    private function mapToPaymentRow(array $data): array
    {
        $result = [];
        if (isset($data['deposit'])) {
            $result['deposit'] = (string)$data['deposit'];
        }
        if (isset($data['amount'])) {
            $result['amount'] = (string)$data['amount'];
        }
        if (isset($data['image_deposit'])) {
            $result['image_deposit'] = (string)$data['image_deposit'];
        }
        return $result;
    }
}
