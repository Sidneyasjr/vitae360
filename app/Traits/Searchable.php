<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait Searchable
{
    /**
     * Aplica a pesquisa nos campos especificados
     *
     * @param Builder $query
     * @param string|null $search
     * @param array $searchableFields
     * @return Builder
     */
    public function scopeSearch(Builder $query, ?string $search, array $searchableFields): Builder
    {
        if (empty($search) || empty($searchableFields)) {
            return $query;
        }

        return $query->where(function ($query) use ($search, $searchableFields) {
            foreach ($searchableFields as $field) {
                $query->orWhere($field, 'like', "%{$search}%");
            }
        });
    }

    /**
     * Aplica ordenação
     *
     * @param Builder $query
     * @param string $orderBy
     * @param string $direction
     * @return Builder
     */
    public function scopeOrder(Builder $query, string $orderBy = 'created_at', string $direction = 'desc'): Builder
    {
        return $query->orderBy($orderBy, $direction);
    }

    /**
     * Aplica paginação
     *
     * @param Builder $query
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function scopePaginateResults(Builder $query, int $perPage = 10): LengthAwarePaginator
    {
        return $query->paginate($perPage)->withQueryString();
    }
}
