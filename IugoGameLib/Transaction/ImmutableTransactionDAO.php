<?php

namespace IugoGameLib\Transaction;

interface ImmutableTransactionDAO { 
    public function getWith($userId);
    public function getAll();
}