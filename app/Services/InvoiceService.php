<?php

namespace App\Services;

use App\Model\Order\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * Invoice Service Class
 * 
 * Handles all business logic for Invoice operations.
 * Implements SOLID principles, DRY pattern, and early returns.
 */
class InvoiceService
{
    /**
     * Get all invoices with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return mixed
     */
    public function getAll(array $filters = [], int $perPage = 15)
    {
        $query = Invoice::query()->with(['user', 'orders']);

        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('number', 'like', "%{$filters['search']}%");
            });
        }

        return $perPage > 0 ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find an invoice by ID.
     *
     * @param int $id
     * @return Invoice|null
     */
    public function find(int $id): ?Invoice
    {
        return Invoice::with(['user', 'orders', 'items'])->find($id);
    }

    /**
     * Find an invoice by number.
     *
     * @param string $number
     * @return Invoice|null
     */
    public function findByNumber(string $number): ?Invoice
    {
        return Invoice::where('number', $number)->first();
    }

    /**
     * Create a new invoice.
     *
     * @param array $data
     * @return Invoice
     * @throws \Exception
     */
    public function create(array $data): Invoice
    {
        DB::beginTransaction();

        try {
            // Generate invoice number if not provided
            if (!isset($data['number'])) {
                $data['number'] = $this->generateInvoiceNumber();
            }

            // Set default values
            $data = $this->setDefaults($data);

            $invoice = Invoice::create($data);

            DB::commit();

            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing invoice.
     *
     * @param int $id
     * @param array $data
     * @return Invoice
     * @throws \Exception
     */
    public function update(int $id, array $data): Invoice
    {
        $invoice = $this->find($id);

        if (!$invoice) {
            throw new \Exception("Invoice not found with ID: {$id}");
        }

        DB::beginTransaction();

        try {
            $invoice->update($data);
            DB::commit();

            return $invoice->fresh();
        } catch (\Exception $e) {
            DB::rollBack();
            throw \$e;
        }
    }

    /**
     * Delete an invoice.
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $invoice = $this->find($id);

        if (!$invoice) {
            throw new \Exception("Invoice not found with ID: {$id}");
        }

        return $invoice->delete();
    }

    /**
     * Mark invoice as paid.
     *
     * @param int $id
     * @return Invoice
     * @throws \Exception
     */
    public function markAsPaid(int $id): Invoice
    {
        return $this->updateStatus($id, 'paid');
    }

    /**
     * Mark invoice as unpaid.
     *
     * @param int $id
     * @return Invoice
     * @throws \Exception
     */
    public function markAsUnpaid(int $id): Invoice
    {
        return $this->updateStatus($id, 'unpaid');
    }

    /**
     * Mark invoice as cancelled.
     *
     * @param int $id
     * @return Invoice
     * @throws \Exception
     */
    public function markAsCancelled(int $id): Invoice
    {
        return $this->updateStatus($id, 'cancelled');
    }

    /**
     * Update invoice status.
     *
     * @param int $id
     * @param string $status
     * @return Invoice
     * @throws \Exception
     */
    private function updateStatus(int $id, string $status): Invoice
    {
        $invoice = $this->find($id);

        if (!$invoice) {
            throw new \Exception("Invoice not found with ID: {$id}");
        }

        $invoice->update(['status' => $status]);

        return $invoice->fresh();
    }

    /**
     * Get invoices by user ID.
     *
     * @param int $userId
     * @return Collection
     */
    public function getByUser(int $userId): Collection
    {
        return Invoice::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Get invoices by status.
     *
     * @param string $status
     * @return Collection
     */
    public function getByStatus(string $status): Collection
    {
        return Invoice::where('status', $status)->get();
    }

    /**
     * Get overdue invoices.
     *
     * @return Collection
     */
    public function getOverdue(): Collection
    {
        return Invoice::where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->get();
    }

    /**
     * Generate a unique invoice number.
     *
     * @return string
     */
    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = date('Y');
        $month = date('m');
        $sequence = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;
        
        return sprintf("%s-%s%s-%04d", $prefix, $year, $month, $sequence);
    }

    /**
     * Set default values for invoice data.
     *
     * @param array $data
     * @return array
     */
    private function setDefaults(array $data): array
    {
        if (!isset($data['status'])) {
            $data['status'] = 'unpaid';
        }

        if (!isset($data['date'])) {
            $data['date'] = now();
        }

        if (!isset($data['due_date']) && isset($data['date'])) {
            $data['due_date'] = now()->addDays(30);
        }

        return $data;
    }

    /**
     * Get invoice count.
     *
     * @return int
     */
    public function getCount(): int
    {
        return Invoice::count();
    }

    /**
     * Get invoices count by status.
     *
     * @param string $status
     * @return int
     */
    public function getCountByStatus(string $status): int
    {
        return Invoice::where('status', $status)->count();
    }

    /**
     * Get total revenue from paid invoices.
     *
     * @return float
     */
    public function getTotalRevenue(): float
    {
        return Invoice::where('status', 'paid')->sum('grand_total');
    }

    /**
     * Get recent invoices.
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecent(int $limit = 10): Collection
    {
        return Invoice::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
