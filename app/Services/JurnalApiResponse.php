<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class JurnalApiResponse
{
    protected Collection $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function all()
    {
        return $this->data;
    }

    public function get()
    {
        return $this->data;
    }

    /**
     * Filter produk hanya yang memiliki kode B2B-#### atau B2BN-####
     * dan filter tambahan: search, min, max
     *
     * @param array $filters ['search' => '', 'min' => 0, 'max' => 0]
     */
    public function filteredProducts(array $filters = []): self
    {
        $this->data = $this->data->filter(function ($product) use ($filters) {
            // Filter deleted_at harus null
            if (isset($product['deleted_at']) && $product['deleted_at'] !== null) {
                // return false;
            }

            // Filter kode produk
            if (!isset($product['product_code']) || !preg_match('/^B2B(N)?-\d+$/', $product['product_code'])) {
                return false;
            }

            // Filter search (nama produk, case-insensitive)
            if (!empty($filters['search'])) {
                $search = strtolower($filters['search']);
                $name = strtolower($product['name'] ?? '');
                if (strpos($name, $search) === false) {
                    return false;
                }
            }

            // Filter min (harga minimal)
            if (isset($filters['min']) && is_numeric($filters['min'])) {
                $min = $filters['min'];
                if (($product['sell_price_per_unit'] ?? 0) < $min) {
                    return false;
                }
            }

            // Filter max (harga maksimal)
            if (isset($filters['max']) && is_numeric($filters['max'])) {
                $max = $filters['max'];
                if (($product['sell_price_per_unit'] ?? 0) > $max) {
                    return false;
                }
            }

            return true;
        })->values(); // reset index

        return $this; // <-- ubah di sini!
    }

    /** Urutkan data berdasarkan kolom tertentu */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        $this->data = $this->data->sortBy(
            fn($item) => $item[$column] ?? null,
            SORT_REGULAR,
            strtolower($direction) === 'desc'
        )->values();

        return $this;
    }

    /**
     * Return product recommendations for a given product
     * Heuristic: prefer same product_code prefix (before dash) and shared words in name
     *
     * @param array $currentProduct
     * @param int $limit
     * @return Collection
     */
    public function recommendations(array $currentProduct, int $limit = 4)
    {
        $currentCode = $currentProduct['product_code'] ?? null;
        $currentName = strtolower($currentProduct['name'] ?? '');

        $currentPrefix = null;
        if ($currentCode) {
            $parts = explode('-', $currentCode, 2);
            $currentPrefix = $parts[0] ?? null;
        }

        // prepare words from name
        $currentWords = array_values(array_filter(array_map('trim', preg_split('/\s+/', preg_replace('/[^a-z0-9 ]/i', ' ', $currentName)))));

        $scored = $this->data->filter(function ($p) use ($currentCode) {
            if (!isset($p['product_code'])) return false;
            if ($p['product_code'] === $currentCode) return false;
            if (isset($p['deleted_at']) && $p['deleted_at'] !== null) return false;
            return true;
        })->map(function ($p) use ($currentPrefix, $currentWords) {
            $score = 0;

            // prefix match (high weight)
            $code = $p['product_code'] ?? '';
            $prefix = explode('-', $code, 2)[0] ?? null;
            if ($prefix && $currentPrefix && strcasecmp($prefix, $currentPrefix) === 0) {
                $score += 10;
            }

            // name word overlap
            $name = strtolower($p['name'] ?? '');
            $words = array_values(array_filter(array_map('trim', preg_split('/\s+/', preg_replace('/[^a-z0-9 ]/i', ' ', $name)))));
            if (!empty($currentWords) && !empty($words)) {
                $common = array_intersect($currentWords, $words);
                $score += count($common) * 2;
            }

            // small boost for price closeness (if available)
            if (isset($p['sell_price_per_unit']) && isset($currentWords) && isset($currentWords)) {
                // noop: keep small potential for future
            }

            return ['product' => $p, 'score' => $score];
        })->filter(function ($item) {
            return ($item['score'] ?? 0) >= 0;
        })->sortByDesc(fn($item) => $item['score']);

        $results = $scored->values()->map(fn($item) => $item['product'])->take($limit);

        return $results;
    }

    /** Paginasi hasil data */
    public function paginate(int $perPage = 10, int $page = null): LengthAwarePaginator
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $offset = ($page - 1) * $perPage;

        $items = $this->data->slice($offset, $perPage)->values();
        return new LengthAwarePaginator(
            $items,
            $this->data->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }



    // Bisa tambah method lain seperti pagination, sorting, dll.
}
