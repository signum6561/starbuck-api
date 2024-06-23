<?php

namespace App\Services\V1;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Services\Query;

class CustomerQuery extends Query
{

    public function transform(Request $request)
    {
        $perPage = $request->perPage;
        $includeInvoices = $request->includeInvoices;

        $customers = Customer::sort()->filter();

        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }

        if (isset($perPage)) {
            $customers = $customers->paginate($perPage);
        } else {
            $customers = $customers->get();
        }
        return $customers;
    }
}
