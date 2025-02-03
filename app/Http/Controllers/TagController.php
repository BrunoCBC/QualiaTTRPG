<?php
namespace App\Http\Controllers;

use App\Models\Rpg;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index($rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $tags = $rpg->tags; // Supondo que a relação entre RPG e Tags já esteja configurada

        return view('tags.index', compact('tags', 'rpg'));
    }

    public function store(Request $request, $rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();

        $request->validate([
            'tag_name' => 'required|string|max:255|unique:tags',
        ]);

        $tag = new Tag();
        $tag->tag_name = $request->tag_name;
        $tag->save();

        $rpg->tags()->attach($tag->id);

        return redirect()->route('tags.index', ['rpg_hash' => $rpg_hash])->with('success', 'Tag added!');
    }

    public function destroy($rpg_hash, $tag_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $tag = Tag::where('hash', $tag_hash)->firstOrFail();

        $rpg->tags()->detach($tag->id);

        return redirect()->route('tags.index', ['rpg_hash' => $rpg_hash])->with('success', 'Tag removed!');
    }
}
