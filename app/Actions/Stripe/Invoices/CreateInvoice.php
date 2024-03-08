<?php

namespace App\Actions\Stripe\Invoices;

use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\InvoiceItem;

class CreateInvoice
{
    /**
     * @throws ApiErrorException
     */
    public function execute(
        string $email,
        int    $price,
        string $currency,
        string $description = '',
    )
    {
        $customer = Customer::create([
            'email' => $email,
        ]);

        $invoiceItem = InvoiceItem::create([
            'customer' => $customer->id,
            'amount' => $price,
            'currency' => $currency,
            'description' => $description,
        ]);

        $invoice = Invoice::create([
            'customer' => $customer->id,
        ]);
    }
}