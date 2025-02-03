<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFavorite;
use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $favorites = $user->favorites; // Supondo que a relação de favoritos esteja configurada no User model

        return view('user.favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_type' => 'required|in:rpg,folder,sheet,file',
            'target_id' => 'required|integer',
        ]);

        $userFavorite = new UserFavorite();
        $userFavorite->id_user_fk = auth()->id();
        $userFavorite->target_type = $request->target_type;
        $userFavorite->target_id = $request->target_id;
        $userFavorite->save();

        return redirect()->route('user.favorites.index')->with('success', 'Favorite added!');
    }

    public function destroy($favorite_hash)
    {
        $favorite = UserFavorite::where('hash', $favorite_hash)->firstOrFail();
        $favorite->delete();

        return redirect()->route('user.favorites.index')->with('success', 'Favorite removed!');
    }
}
