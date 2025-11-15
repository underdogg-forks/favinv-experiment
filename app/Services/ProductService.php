<?php

namespace App\Services;

use App\Model\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * Product Service Class
 * 
 * Handles all business logic for Product operations.
 * Follows SOLID principles with SRP, DIP, and OCP.
 */
class ProductService
{
    /**
     * Get all products with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = Product::query();

        // Apply filters with early returns pattern
        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['group'])) {
            $query->where('group', $filters['group']);
        }

        if (isset($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (isset($filters['hidden'])) {
            $query->where('hidden', $filters['hidden']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('description', 'like', "%{$filters['search']}%")
                  ->orWhere('product_sku', 'like', "%{$filters['search']}%");
            });
        }

        return $perPage > 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find a product by ID.
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    /**
     * Find a product by SKU.
     *
     * @param string $sku
     * @return Product|null
     */
    public function findBySku(string $sku): ?Product
    {
        return Product::where('product_sku', $sku)->first();
    }

    /**
     * Create a new product.
     *
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function create(array $data): Product
    {
        DB::beginTransaction();

        try {
            // Set defaults
            $data = $this->setDefaults($data);

            $product = Product::create($data);

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing product.
     *
     * @param int $id
     * @param array $data
     * @return Product
     * @throws \Exception
     */
    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);

        if (!$product) {
            throw new \Exception("Product not found with ID: {$id}");
        }

        DB::beginTransaction();

        try {
            $product->update($data);
            DB::commit();

            return $product->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a product.
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $product = $this->find($id);

        if (!$product) {
            throw new \Exception("Product not found with ID: {$id}");
        }

        return $product->delete();
    }

    /**
     * Get products by type.
     *
     * @param int $typeId
     * @return Collection
     */
    public function getByType(int $typeId): Collection
    {
        return Product::where('type', $typeId)->get();
    }

    /**
     * Get products by category.
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategory(int $categoryId): Collection
    {
        return Product::where('category', $categoryId)->get();
    }

    /**
     * Get visible products (not hidden).
     *
     * @return Collection
     */
    public function getVisible(): Collection
    {
        return Product::where('hidden', 0)->get();
    }

    /**
     * Hide a product.
     *
     * @param int $id
     * @return Product
     * @throws \Exception
     */
    public function hide(int $id): Product
    {
        return $this->toggleVisibility($id, 1);
    }

    /**
     * Show a product.
     *
     * @param int $id
     * @return Product
     * @throws \Exception
     */
    public function show(int $id): Product
    {
        return $this->toggleVisibility($id, 0);
    }

    /**
     * Toggle product visibility.
     *
     * @param int $id
     * @param int $hidden
     * @return Product
     * @throws \Exception
     */
    private function toggleVisibility(int $id, int $hidden): Product
    {
        $product = $this->find($id);

        if (!$product) {
            throw new \Exception("Product not found with ID: {$id}");
        }

        $product->update(['hidden' => $hidden]);

        return $product->fresh();
    }

    /**
     * Set default values for product data.
     *
     * @param array $data
     * @return array
     */
    private function setDefaults(array $data): array
    {
        if (!isset($data['hidden'])) {
            $data['hidden'] = 0;
        }

        if (!isset($data['require_domain'])) {
            $data['require_domain'] = 0;
        }

        if (!isset($data['can_modify_agent'])) {
            $data['can_modify_agent'] = 0;
        }

        if (!isset($data['can_modify_quantity'])) {
            $data['can_modify_quantity'] = 0;
        }

        if (!isset($data['show_agent'])) {
            $data['show_agent'] = 0;
        }

        return $data;
    }

    /**
     * Get products count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return Product::count();
    }

    /**
     * Get products with prices.
     *
     * @return Collection
     */
    public function getWithPrices(): Collection
    {
        return Product::with('price')->get();
    }
}
