<?php
namespace App\Http\Controllers;

use App\Models\Rpg;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $rpgs = Rpg::join('user_rpg', 'user_rpg.id_rpg_fk', '=', 'rpgs.id')
            ->select('rpgs.rpg_name', 'rpgs.rpg_description', 'rpgs.rpg_image_path', 'rpgs.hash', 'user_rpg.role') // Incluindo o 'rpgs.hash' na seleção
            ->where('user_rpg.id_user_fk', $userId)
            ->orderByRaw("FIELD(user_rpg.role, 'owner', 'admin', 'player', 'viewer') DESC")
            ->get();

        return view('dashboard', compact('rpgs'));
    }
}
