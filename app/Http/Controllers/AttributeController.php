<?php
namespace App\Http\Controllers;

use App\Models\Rpg;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index($rpg_hash)
    {
        $rpg = Rpg::where('hash', $rpg_hash)->firstOrFail();
        $attributes = $rpg->attributes;

        return view('rpg.attributes', compact('rpg', 'attributes'));
    }

    public function store(Request $request, $rpg_hash)
    {
        $request->validate([
            'attributes.*.name' => 'required|string|max:255',
            'attributes.*.price' => 'required|numeric|min:1',
            'attributes.*.type' => 'required|string|max:50',
        ], [
            'attributes.*.name.required' => 'O nome do atributo é obrigatório.',
            'attributes.*.price.required' => 'O preço do atributo é obrigatório.',
            'attributes.*.price.numeric' => 'O preço deve ser um número válido.',
            'attributes.*.price.min' => 'O preço deve ser maior que zero.',
            'attributes.*.type.required' => 'O tipo do atributo é obrigatório.',
        ]);        
    
        $rpg = Rpg::where('hash', $rpg_hash)->first();
        if (!$rpg) {
            return redirect()->route('rpg.index')->with('error', 'RPG não encontrado!');
        }
    
        $attributes = $request->input('attributes');
        if ($attributes) {
            foreach ($attributes as $attributeData) {
    
                $attribute = Attribute::updateOrCreate(
                    ['id' => $attributeData['id'] ?? null],
                    [
                        'attributes_name' => $attributeData['name'],
                        'attributes_price' => $attributeData['price'],
                        'attributes_type' => $attributeData['type'],
                    ]
                );
    
                $rpg->attributes()->syncWithoutDetaching([$attribute->id]);           
            }
        }
    
        return redirect()->route('rpg.attributes.index', ['rpg_hash' => $rpg_hash])
                         ->with('success', 'Atributos atualizados com sucesso!');
    }
    

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return back()->with('success', 'Atributo deletado com sucesso!');
    }    
}
