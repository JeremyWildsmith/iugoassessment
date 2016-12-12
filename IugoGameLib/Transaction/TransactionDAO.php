<?php

namespace IugoGameLib\Transaction;

use IugoGameLib\Transaction\ImmutableTransactionDAO;

interface TransactionDAO extends ImmutableTransactionDAO {
    public function update($transaction);
    public function delete($transaction);
    public function save();
}