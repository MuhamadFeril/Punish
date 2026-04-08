<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class SearchHelper
{
    public static function search(Request $request, $model, array $columns = [], array $with = [], $resourceClass = null)
    {
        // default and maximum items per page (match controller behavior)
        $requested = (int) $request->query('per_page', 3);
        if ($requested < 1) $requested = 1;
        $maxPerPage = 5;
        $perPage = min($requested, $maxPerPage);
        $q = $request->query('q');

        $queryBuilder = $model::query();

        if (!empty($with)) {
            $queryBuilder = $queryBuilder->with($with);
        }

        if (!empty($q) && !empty($columns)) {
            $queryBuilder->where(function ($qb) use ($q, $columns) {
                foreach ($columns as $column) {
                    $qb->orWhere($column, 'LIKE', "%{$q}%");
                }
            });
        }

        $paginator = $queryBuilder->paginate($perPage);
        // preserve query parameters on paginator links
        $paginator->appends($request->query());
        $collection = $paginator->getCollection();

        if ($resourceClass) {
            $items = $resourceClass::collection($collection)->resolve();
        } else {
            $items = $collection->toArray();
        }
        $meta = [
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
        ];

        return ResponsHelper::success(['items' => $items, 'meta' => $meta], 'Data found');
    }
}