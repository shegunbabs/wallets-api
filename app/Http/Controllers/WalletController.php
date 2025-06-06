<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWalletRequest;
use App\Http\Resources\WalletResource;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateWalletRequest $request, WalletService $walletService): WalletResource
    {
        $wallet = $walletService->createWallet(
            ownerId: $request->owner_id,
            ownerType: $request->owner_type,
            currency: $request->currency,
            walletType: $request->wallet_type,
            metadata: $request->metadata,
        );

        return new WalletResource($wallet);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
