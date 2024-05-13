<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class InvoicePolicy
{

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Invoice $invoice): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return false;
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Invoice $invoice): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Invoice $invoice): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can restore the model.
     */
    public function restore(Admin $admin, Invoice $invoice): bool
    {
        return true;
    }

    /**
     * Determine whether the admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Invoice $invoice): bool
    {
        return true;
    }
}
