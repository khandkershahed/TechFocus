<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function allProduct();
    public function allApprovedProducts();
    public function pendingProducts();
    public function getPrincipalProducts($principalId);
    public function storeProduct(array $data);
    public function findProduct(int $id);
    public function updateProduct(array $data, int $id);
    public function destroyProduct(int $id);
    public function approveProduct($id);
    public function rejectProduct($id, $reason = null);
}