<?php

namespace App\Http\Controllers;

use App\Models\UserFavorite;
use App\Models\Rpg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $rpgId = $request->input('rpg_id');

        $favorite = UserFavorite::where('id_user_fk', $user->id)
            ->where('target_id', $rpgId)
            ->where('target_type', Rpg::class)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['favorited' => false]);
        } else {
            UserFavorite::create([
                'id_user_fk' => $user->id,
                'target_id' => $rpgId,
                'target_type' => Rpg::class,
            ]);
            return response()->json(['favorited' => true]);
        }
    }
}
