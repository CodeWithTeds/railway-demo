<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class AddressService
{
    /**
     * Get all regions
     *
     * @return array
     */
    public function getRegions(): array
    {
        try {
            return DB::table('regions')
                ->select('code', 'name')
                ->orderBy('name')
                ->get()
                ->map(fn($r) => ['code' => $r->code, 'name' => $r->name])
                ->toArray();
        } catch (QueryException $e) {
            return [];
        }
    }

    /**
     * Get provinces by region code
     *
     * @param string $regionCode
     * @return array
     */
    public function getProvinces(string $regionCode): array
    {
        if (!$regionCode) return [];
        try {
            return DB::table('provinces')
                ->where('region_code', $regionCode)
                ->select('code', 'name')
                ->orderBy('name')
                ->get()
                ->map(fn($p) => ['code' => $p->code, 'name' => $p->name])
                ->toArray();
        } catch (QueryException $e) {
            return [];
        }
    }

    /**
     * Get cities by province code
     *
     * @param string $provinceCode
     * @return array
     */
    public function getCities(string $provinceCode): array
    {
        if (!$provinceCode) return [];
        try {
            return DB::table('cities')
                ->where('province_code', $provinceCode)
                ->select('code', 'name')
                ->orderBy('name')
                ->get()
                ->map(fn($c) => ['code' => $c->code, 'name' => $c->name])
                ->toArray();
        } catch (QueryException $e) {
            return [];
        }
    }

    /**
     * Get barangays by city code
     *
     * @param string $cityCode
     * @return array
     */
    public function getBarangays(string $cityCode): array
    {
        if (!$cityCode) return [];
        try {
            return DB::table('barangays')
                ->where('city_code', $cityCode)
                ->select('code', 'name')
                ->orderBy('name')
                ->get()
                ->map(fn($b) => ['code' => $b->code, 'name' => $b->name])
                ->toArray();
        } catch (QueryException $e) {
            return [];
        }
    }

    /**
     * Get user address
     *
     * @param int $userId
     * @return object|null
     */
    public function getUserAddress(int $userId = null): ?object
    {
        $userId = $userId ?? Auth::id();
        try {
            return DB::table('users_addresses')->where('user_id', $userId)->first();
        } catch (QueryException $e) {
            return null;
        }
    }

    /**
     * Save user address
     *
     * @param array $data
     * @param int $userId
     * @return bool
     */
    public function saveUserAddress(array $data, int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        try {
            DB::table('users_addresses')->updateOrInsert(
                ['user_id' => $userId],
                [
                    'region_code' => $data['region_code'],
                    'province_code' => $data['province_code'],
                    'city_code' => $data['city_code'],
                    'barangay_code' => $data['barangay_code'],
                    'exact_address' => $data['exact_address'] ?? null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
            return true;
        } catch (QueryException $e) {
            return false;
        }
    }
}