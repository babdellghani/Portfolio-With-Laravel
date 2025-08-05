<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    /**
     * Check if current user is admin
     */
    protected function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Check if current user is active
     */
    protected function isActiveUser(): bool
    {
        return Auth::check() && Auth::user()->isActive();
    }

    /**
     * Ensure user is admin or abort with 403
     */
    protected function requireAdmin(): void
    {
        if (! $this->isAdmin()) {
            abort(403, 'Admin access required');
        }
    }

    /**
     * Ensure user is authenticated and active or abort with 403
     */
    protected function requireActiveUser(): void
    {
        if (! Auth::check()) {
            abort(401, 'Authentication required');
        }

        if (! $this->isActiveUser()) {
            abort(403, 'Active account required');
        }
    }

    /**
     * Check if user can modify resource (admin or owner)
     */
    protected function canModifyResource($resourceUserId = null): bool
    {
        if (! Auth::check()) {
            return false;
        }

        // Admin can modify any resource
        if ($this->isAdmin()) {
            return true;
        }

        // User can modify their own resources
        if ($resourceUserId && Auth::id() === $resourceUserId) {
            return true;
        }

        return false;
    }

    /**
     * Ensure user can modify resource or abort with 403
     */
    protected function requireResourceAccess($resourceUserId = null): void
    {
        if (! $this->canModifyResource($resourceUserId)) {
            abort(403, 'You do not have permission to access this resource');
        }
    }
}
