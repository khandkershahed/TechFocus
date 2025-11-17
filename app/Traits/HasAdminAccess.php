<?php

namespace App\Traits;

use App\Models\Principal;

trait HasAdminAccess
{
    public function hasAccessTo($model)
    {
        // SuperAdmin has access to everything
        if ($this->hasRole('SuperAdmin')) {
            return true;
        }

        // Creator always has access to their own records
        if ($model->creator_id === $this->id) {
            return true;
        }

        // Public records are accessible
        if ($model->is_public) {
            return true;
        }

        // Check scoped access for BrandAdmin and Viewer
        if ($this->hasRole('BrandAdmin') || $this->hasRole('Viewer')) {
            return $this->hasScopedAccessTo($model);
        }

        // Contributor can only access their own records
        if ($this->hasRole('Contributor')) {
            return $model->creator_id === $this->id;
        }

        return false;
    }

    public function hasScopedAccessTo($model)
    {
        $scopes = $this->getAdminScopes();
        
        foreach ($scopes as $scopeType => $scopeIds) {
            $foreignKey = "{$scopeType}_id";
            
            if (isset($model->$foreignKey) && in_array($model->$foreignKey, $scopeIds)) {
                return true;
            }
        }

        return false;
    }

    public function getAdminScopes()
    {
        $scopes = [];
        
        foreach ($this->roles as $role) {
            if (method_exists($role, 'getAdminScopes')) {
                $roleScopes = $role->getAdminScopes();
                foreach ($roleScopes as $scopeType => $scopeIds) {
                    $scopes[$scopeType] = array_merge(
                        $scopes[$scopeType] ?? [],
                        $scopeIds
                    );
                }
            }
        }

        // Remove duplicates
        foreach ($scopes as &$scopeIds) {
            $scopeIds = array_unique($scopeIds);
        }

        return $scopes;
    }
}