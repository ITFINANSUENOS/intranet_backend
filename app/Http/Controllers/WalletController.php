<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Services\CarteraService;
use Illuminate\Http\Request;


class WalletController extends Controller
{
    protected $service;

    public function __construct(CarteraService $service)
    {
        $this->service = $service;
    }

    public function dashboard(Request $request)
    {
        // Validamos que el frontend envíe la key del archivo S3
        $request->validate([
            'file_key' => 'required|string'
        ]);

        try {
            $data = $this->service->obtenerDashboard($request->query('file_key'));
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}