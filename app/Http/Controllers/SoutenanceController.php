<?php

namespace App\Http\Controllers;

use App\Models\Soutenance;
use Illuminate\Http\Request;
use App\Models\Student;

class SoutenanceController extends Controller
{
    // Afficher la liste des soutenances
    public function index()
    {
        $soutenances = Soutenance::all();
        return view('stageDinitationInterface', compact('soutenances'));
    }

    // Ajouter une soutenance
    public function store(Request $request)
    {
        $request->validate([
            'etudiant' => 'required|string|max:255',
            'jury1' => 'required|string|max:255',
            'jury2' => 'required|string|max:255',
            'societe' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'classe' => 'required|string|max:255',
            'heure' => 'required|date_format:H:i',
            'date_soutenance' => 'required|date',
        ]);

        Soutenance::create($request->all());

        return redirect()->route('stageDinitationInterface')->with('success', 'Soutenance ajoutée avec succès');
    }

    // Modifier une soutenance
    public function edit($id)
    {
        $soutenance = Soutenance::findOrFail($id);
        return view('soutenances.edit', compact('soutenance'));
    }

    // Mettre à jour une soutenance
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'etudiant' => 'required|string|max:255',
            'jury1' => 'required|string|max:255',
            'jury2' => 'required|string|max:255',
            'societe' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'classe' => 'required|string|max:255',
            'heure' => 'required',
            'date_soutenance' => 'required|date',
        ]);

        $soutenance = Soutenance::findOrFail($id);
        $soutenance->update($validated);

        return redirect()->route('stageDinitationInterface')->with('success', 'Soutenance mise à jour avec succès.');
    }
    public function showAll()
    {
        $soutenances = Soutenance::all(); // Récupérer toutes les soutenances
        return view('stageDinitationInterface', compact('soutenances')); // Assurez-vous d'avoir une vue `index` pour afficher les soutenances
    }


    public function destroy($id)
    {
        $soutenance = Soutenance::findOrFail($id);
        $soutenance->delete();
            return redirect()->route('stageDinitationInterface')->with('success', 'Soutenance supprimée avec succès.');
    }
    

    public function search(Request $request)
    {
        // Récupérer la valeur du champ de recherche
        $searchTerm = $request->input('search');
        
        // Récupérer les soutenances dont le titre contient le terme de recherche
        $soutenances = Soutenance::where('etudiant', 'like', '%' . $searchTerm . '%')->get();
        
        // Retourner la vue avec les soutenances trouvées
        return view('stageDinitationInterface', compact('soutenances'));
    }
    
    
    



}

    

