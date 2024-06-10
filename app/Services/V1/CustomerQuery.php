<?php

namespace App\Services\V1;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Services\Query;

class CustomerQuery extends Query
{
    protected $safeParms = [
        'fullname' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'birthday' => ['eq'],
        'starPoints' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'type' => ['eq'],
    ];

    protected $columnMap = [
        'starPoints' => 'star_points'
    ];


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
