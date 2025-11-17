<?php

namespace App\Traits;

use App\Models\AdminScope;

trait HasAdminScopes
{
    public function adminScopes()
    {
        return $this->hasMany(AdminScope::class, 'role_id');
    }

    public function getAdminScopes()
    {
        return $this->adminScopes->groupBy('scope_type')->map(function ($scopes) {
            return $scopes->pluck('scope_id');
        })->toArray();
    }

    public function hasScope($scopeType, $scopeId)
    {
        return $this->adminScopes()
            ->where('scope_type', $scopeType)
            ->where('scope_id', $scopeId)
            ->exists();
    }

    public function addScope($scopeType, $scopeId)
    {
        return $this->adminScopes()->create([
            'scope_type' => $scopeType,
            'scope_id' => $scopeId
        ]);
    }

    public function removeScope($scopeType, $scopeId)
    {
        return $this->adminScopes()
            ->where('scope_type', $scopeType)
            ->where('scope_id', $scopeId)
            ->delete();
    }

    public function syncScopes($scopes)
    {
        $this->adminScopes()->delete();
        
        foreach ($scopes as $scopeType => $scopeIds) {
            foreach ($scopeIds as $scopeId) {
                $this->addScope($scopeType, $scopeId);
            }
        }
    }
}