<?php

namespace Api\Model;


class TransactionModel
{
    private $email;
    private $amount;
    private $status;

    /**
     * Email validator
     * @param $email
     * @return bool
     */
    private function checkEmail($email)
    {
        return filter_var($param, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Amount validator
     * @param $amount
     * @return bool
     */
    private function checkAmount($amount)
    {
        return filter_var($param, FILTER_VALIDATE_FLOAT) !== false;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Stub for generating saving results
     * @return array - saving result structure
     */
    private function generateSavingResultStub()
    {
        $result = [];

        $statuses = ['rejected', 'approved'];
        $errorMessages = [
            'Fraud detected',
            'Duplicated',
            'Server is on maintenance',
        ];

        $result['status'] = $statuses[rand() % 2];
        if ('rejected' === $result['status']) {
            $result['error_message'] = $errorMessages[rand() % count($errorMessages)];
        } else {
            $result['transaction_id'] = rand();
        }

        return $result;
    }

    /**
     * @param $email  - email
     * @param $amount - amount
     * @throws \Exception - in case of invalid parameters
     */
    public function __counstruct($email, $amount)
    {
        if (!$this->checkEmail($email)) {
            throw new \Exception('Invalid email specified');
        }
        if (!$this->checkAmount($amount)) {
            throw new \Exception('Invalid amount specified');
        }

        $this->email = $email;
        $this->amount = $amount;
        $this->status = 'new';     //dummy status before save
    }

    /**
     * Transaction saving simulator
     * @return array - array structure with result of saving
     */
    public function save()
    {
        $savingResult = $this->generateSavingResultStub();
        $this->status = $savingResult['status'];

        return $savingResult;
    }
}