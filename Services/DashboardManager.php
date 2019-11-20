<?php

namespace Akiltech\AccountingDashboardBundle\Services;

use Akiltech\AccountingDashboardBundle\Helpers\ArrayGroupBy;

class DashboardManager
{
    private static $accounts = [];
    private static $balanceSheet = [];

    public static function create($operations)
    {
        $defaultAttributes = self::getDefaultAttributes();
        $operationsGrouped = ArrayGroupBy::groupBy(
            $operations,
            [
                [
                    'code',
                    'credit',
                    'debit'
                ]
            ],
            [
            ],
            [
                'code',
                'credit',
                'debit'
            ],
            []
        );


        self::$balanceSheet = $operationsGrouped;

        self::$accounts = array_keys(self::$balanceSheet);

        return new self();
    }

    public function getItem($item)
    {
        $balance = $this->getBalance($item['accounts_debit_credit'], 'accounts_debit_credit');

        return $balance;
    }

    private function getBalance($pattern, $direction)
    {
        $accountsMatched = preg_grep($pattern, self::$accounts);
        $balance = 0;
        switch ($direction) {
            case 'accounts_debit_credit':
                foreach ($accountsMatched as $account) {
                    $diff = self::$balanceSheet[$account]['debit'] - self::$balanceSheet[$account]['credit'];
                    $balance += $diff;
                }
                break;
            case 'accounts_debit':
                foreach ($accountsMatched as $account) {
                    $diff = self::$balanceSheet[$account]['debit'] - self::$balanceSheet[$account]['credit'];
                    $balance += ($diff > 0 ? $diff : 0);
                }
                break;
            case 'accounts_credit':
                foreach ($accountsMatched as $account) {
                    $diff = self::$balanceSheet[$account]['debit'] - self::$balanceSheet[$account]['credit'];
                    $balance += ($diff < 0 ? -$diff : 0);
                }
                break;
        }

        return $balance;
    }

    public function getItems()
    {

    }

    /**
     * Gets default operations
     *
     * @return array
     */
    public static function getDefaultAttributes(): array
    {
        return [
            'id' => 'id',
            'label' => 'label',
            'credit' => 'credit',
            'debit' => 'debit',
            'credit_n1' => 'credit_n1',
            'debit_n1' => 'debit_n1',
            'comment' => 'comment',
            'tag' => 'tag',
            'filename' => 'filename',
            'num_piece' => 'num_piece',
            'operation_id' => 'operation_id',
            'operation_date' => 'operation_date',
            'journal_id' => 'journal_id',
            'journal_code' => 'journal_code',
            'journal_label' => 'journal_label',
            'journal_type_code' => 'journal_type_code',
            'journal_type_label' => 'journal_type_label',
            'is_correct' => 'is_correct',
            'is_proforma' => 'is_correct',
            'code_mi' => 'code_mi',
            'period_id' => 'period_id',
            'period_code' => 'period_code',
            'period_name' => 'period_name',
            'period_is_opened' => 'period_is_opened',
            'period_start_date' => 'period_start_date',
            'period_end_date' => 'period_end_date',
            'account_id' => 'account_id',
            'account_label' => 'account_label',
            'account_code' => 'account_code',
            'code'=>'code',
            'account_enabled_letter' => 'account_enabled_letter',
            'account_order_code' => 'account_order_code',
            'account_letter' => 'account_letter',
            'fiscal_year_id' => 'fiscal_year_id',
            'operation_is_selected' => 'operation_is_selected',
            'class_code' => 'class',
            'sub_class_code' => 'sub_class_code',
            'operation_by_journal_nb' => 'operation_by_journal_nb',
            'solde' => 'solde',
            'solde_debit_n' => 'solde_debit_n',
            'solde_credit_n' => 'solde_credit_n',
            'solde_debit_n1' => 'solde_debit_n1',
            'solde_credit_n1' => 'solde_debit_n1',
            'janvier' => 'janvier',
            'fevrier' => 'fevrier',
            'mars' => 'mars',
            'avril' => 'avril',
            'mai' => 'mai',
            'juin' => 'juin',
            'juillet' => 'juillet',
            'aout' => 'aout',
            'septembre' => 'septembre',
            'octobre' => 'octobre',
            'novembre' => 'novembre',
            'decembre' => 'decembre',
        ];
    }
}