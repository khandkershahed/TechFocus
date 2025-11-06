<?php

namespace App\Http\Controllers\Principal;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Http\Controllers\Controller;

class PrincipalDashboardController extends Controller
{
   private $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $principalId = Auth::guard('principal')->id();
        $brands = $this->brandRepository->getPrincipalBrands($principalId);
        
        $stats = [
            'total_brands' => $brands->count(),
            'approved_brands' => $brands->where('status', 'approved')->count(),
            'pending_brands' => $brands->where('status', 'pending')->count(),
            'rejected_brands' => $brands->where('status', 'rejected')->count(),
        ];

        return view('principal.dashboard', compact('stats', 'brands'));
    }
}
