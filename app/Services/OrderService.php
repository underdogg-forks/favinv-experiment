<?php

namespace App\Services;

use App\Model\Order\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * Order Service Class
 * 
 * Handles all business logic for Order operations.
 * Implements SOLID principles, DRY pattern, and early returns.
 */
class OrderService
{
    /**
     * Get all orders with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = Order::query()->with(['user', 'product', 'invoice']);

        // Early return pattern for filters
        if (isset($filters['client'])) {
            $query->where('client', $filters['client']);
        }

        if (isset($filters['order_status'])) {
            $query->where('order_status', $filters['order_status']);
        }

        if (isset($filters['product'])) {
            $query->where('product', $filters['product']);
        }

        if (isset($filters['invoice_id'])) {
            $query->where('invoice_id', $filters['invoice_id']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('number', 'like', "%{$filters['search']}%")
                  ->orWhere('serial_key', 'like', "%{$filters['search']}%")
                  ->orWhere('domain', 'like', "%{$filters['search']}%");
            });
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $perPage > 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find an order by ID.
     *
     * @param int $id
     * @return Order|null
     */
    public function find(int $id): ?Order
    {
        return Order::with(['user', 'product', 'invoice'])->find($id);
    }

    /**
     * Find an order by number.
     *
     * @param string $number
     * @return Order|null
     */
    public function findByNumber(string $number): ?Order
    {
        return Order::where('number', $number)->first();
    }

    /**
     * Create a new order.
     *
     * @param array $data
     * @return Order
     * @throws \Exception
     */
    public function create(array $data): Order
    {
        DB::beginTransaction();

        try {
            // Generate order number if not provided
            if (!isset($data['number'])) {
                $data['number'] = $this->generateOrderNumber();
            }

            // Set default order status
            if (!isset($data['order_status'])) {
                $data['order_status'] = 'pending';
            }

            $order = Order::create($data);

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing order.
     *
     * @param int $id
     * @param array $data
     * @return Order
     * @throws \Exception
     */
    public function update(int $id, array $data): Order
    {
        $order = $this->find($id);

        if (!$order) {
            throw new \Exception("Order not found with ID: {$id}");
        }

        DB::beginTransaction();

        try {
            $order->update($data);
            DB::commit();

            return $order->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete an order.
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $order = $this->find($id);

        if (!$order) {
            throw new \Exception("Order not found with ID: {$id}");
        }

        return $order->delete();
    }

    /**
     * Update order status.
     *
     * @param int $id
     * @param string $status
     * @return Order
     * @throws \Exception
     */
    public function updateStatus(int $id, string $status): Order
    {
        $order = $this->find($id);

        if (!$order) {
            throw new \Exception("Order not found with ID: {$id}");
        }

        $order->update(['order_status' => $status]);

        return $order->fresh();
    }

    /**
     * Get orders by client ID.
     *
     * @param int $clientId
     * @return Collection
     */
    public function getByClient(int $clientId): Collection
    {
        return Order::where('client', $clientId)
            ->with(['product', 'invoice'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get orders by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return Order::where('order_status', $status)->get();
    }

    /**
     * Get orders by invoice ID.
     *
     * @param int $invoiceId
     * @return Collection
     */
    public function getByInvoice(int $invoiceId): Collection
    {
        return Order::where('invoice_id', $invoiceId)->get();
    }

    /**
     * Generate a unique order number.
     *
     * @return string
     */
    private function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $timestamp = time();
        $random = mt_rand(1000, 9999);
        
        return "{$prefix}-{$timestamp}-{$random}";
    }

    /**
     * Get total order count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return Order::count();
    }

    /**
     * Get orders count by status.
     *
     * @param string $status
     * @return int
     */
    public function getCountByStatus(string $status): int
    {
        return Order::where('order_status', $status)->count();
    }

    /**
     * Get recent orders.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Order::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
