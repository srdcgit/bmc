<?php

namespace App\Http\Controllers\CollectionStaff;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AadharVerificationController extends Controller
{
    public function checkStatus()
    {
        $userId = Auth::id(); // cleaner way to get logged-in user ID
        $shop = Shop::where('user_id', $userId)->first();

        if ($shop) {
            return response()->json([
                'status' => 'success',
                'message' => 'Shop found',
                'shop' => $shop
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Shop not found'
        ], 404);
    }
}
