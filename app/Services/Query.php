<?php

namespace App\Services;

use Illuminate\Http\Request;

abstract class Query {

    protected $safeParms = [];
    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<='
    ];

    public function __construct() {}

    public function getEloQuery(Request $request)
    {
        $eloQuery = [];

        foreach($this->safeParms as $parms => $operators)
        {
            $query = $request->query($parms);
            if(isset($query))
            {
                $col = $this->columnMap[$parms] ?? $parms;
                foreach($operators as $operator)
                {
                    if(isset($query[$operator]))
                    {
                        $eloQuery[] = [$col, $this->operatorMap[$operator], $query[$operator]];
                    }
                }
            }
        }
        return $eloQuery;
    }

    abstract public function transform(Request $request);
}
