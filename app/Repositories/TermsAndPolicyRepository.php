<?php
namespace App\Repositories;
use App\Models\Admin\TermsAndPolicy;
use App\Repositories\Interfaces\TermsAndPolicyRepositoryInterface;

class TermsAndPolicyRepository implements TermsAndPolicyRepositoryInterface
{
    public function allTermsAndPolicy()
    {
        return TermsAndPolicy::latest('id')->get();
    }

    public function storeTermsAndPolicy(array $data)
    {
        return TermsAndPolicy::create($data);
    }

    public function findTermsAndPolicy(int $id)
    {
        return TermsAndPolicy::findOrFail($id);
    }

    public function updateTermsAndPolicy(array $data, int $id)
    {
        return TermsAndPolicy::findOrFail($id)->update($data);
    }

    public function destroyTermsAndPolicy(int $id)
    {
        return TermsAndPolicy::destroy($id);
    }
    public function getActiveTermsAndPolicies()
{
    return TermsAndPolicy::where('is_active', 1)
        ->where('expiration_date', '>', now())
        ->orderBy('created_at', 'desc')
        ->get();
}
}
