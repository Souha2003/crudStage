<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des Soutenances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding-bottom: 60px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            padding: 8px 12px;
        }
        .btn-group-fixed {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 1000;
        }
        .btn-print {
            font-size: 14px;
            color: #fff;
            background-color: #ff9800;
            border: none;
        }
        .btn-print:hover {
            background-color: #e68900;
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .hover-effect {
            transition: background-color 0.3s;
        }
        .hover-effect:hover {
            background-color: #f1f1f1;
        }
        .hidden {
            display: none;
        }
        .search-bar {
            margin-bottom: 15px;
            display: flex;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    <div class="container mt-4" id="mainInterface">
        <div class="table-container">
            <div class="header">
                <h2>Liste des Étudiants en Stage d'initiation</h2>
                <button class="btn btn-print btn-custom" onclick="imprimerPDF()">
                    <i class="bi bi-printer"></i> Imprimer en PDF
                </button>
            </div>
            <div class="search-bar">
               <form action="{{ route('students.search') }}" method="GET">  
    
                <input type="text" class="form-control w-0" id="searchInput" placeholder="Rechercher..."  />
            </div>
          </form>
        
            <table class="table table-striped hover-effect">
    <thead>
        <tr>
            <th>Étudiant</th>
            <th>Jury 1</th>
            <th>Jury 2</th>
            <th>Société de Stage</th>
            <th>Durée de Stage</th>
            <th>Classe</th>
            <th>Heure</th>
            <th>Date de Soutenance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($soutenances as $soutenance)
        <tr>
            <td>{{ $soutenance->etudiant }}</td>
            <td>{{ $soutenance->jury1 }}</td>
            <td>{{ $soutenance->jury2 }}</td>
            <td>{{ $soutenance->societe }}</td>
            <td>{{ $soutenance->date_debut }} - {{ $soutenance->date_fin }}</td>
            <td>{{ $soutenance->classe }}</td>
            <td>{{ $soutenance->heure }}</td>
            <td>{{ $soutenance->date_soutenance }}</td>
            <td>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editSoutenanceModal{{ $soutenance->id }}">
                    Modifier
                </button>
                <form action="{{ route('soutenances.destroy', $soutenance->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette soutenance ?')">
                        Supprimer
                    </button>
                </form>
            </td>
        </tr>

        <!-- Modal de Modification -->
        <div class="modal fade" id="editSoutenanceModal{{ $soutenance->id }}" tabindex="-1" aria-labelledby="editSoutenanceLabel{{ $soutenance->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSoutenanceLabel{{ $soutenance->id }}">Modifier la Soutenance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('soutenances.update', $soutenance->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="etudiant" class="form-label">Étudiant</label>
                                <input type="text" name="etudiant" id="etudiant" class="form-control" value="{{ $soutenance->etudiant }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="jury1" class="form-label">Jury 1</label>
                                <input type="text" name="jury1" id="jury1" class="form-control" value="{{ $soutenance->jury1 }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="jury2" class="form-label">Jury 2</label>
                                <input type="text" name="jury2" id="jury2" class="form-control" value="{{ $soutenance->jury2 }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="societe" class="form-label">Société</label>
                                <input type="text" name="societe" id="societe" class="form-control" value="{{ $soutenance->societe }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début</label>
                                <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ $soutenance->date_debut }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ $soutenance->date_fin }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="classe" class="form-label">Classe</label>
                                <input type="text" name="classe" id="classe" class="form-control" value="{{ $soutenance->classe }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="heure" class="form-label">Heure</label>
                                <input type="time" name="heure" id="heure" class="form-control" value="{{ $soutenance->heure }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="date_soutenance" class="form-label">Date de Soutenance</label>
                                <input type="date" name="date_soutenance" id="date_soutenance" class="form-control" value="{{ $soutenance->date_soutenance }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </tbody>
</table>

<!-- Modal pour Ajouter une Nouvelle Soutenance -->
<div class="modal fade" id="addSoutenanceModal" tabindex="-1" aria-labelledby="addSoutenanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSoutenanceLabel">Ajouter une Soutenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('soutenances.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="etudiant" class="form-label">Étudiant</label>
                        <input type="text" name="etudiant" id="etudiant" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jury1" class="form-label">Jury 1</label>
                        <input type="text" name="jury1" id="jury1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="jury2" class="form-label">Jury 2</label>
                        <input type="text" name="jury2" id="jury2" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="societe" class="form-label">Société</label>
                        <input type="text" name="societe" id="societe" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="classe" class="form-label">Classe</label>
                        <input type="text" name="classe" id="classe" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="heure" class="form-label">Heure</label>
                        <input type="time" name="heure" id="heure" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_soutenance" class="form-label">Date de Soutenance</label>
                        <input type="date" name="date_soutenance" id="date_soutenance" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bouton pour Ouvrir le Modal d'Ajout -->
<button class="btn btn-success my-3" data-bs-toggle="modal" data-bs-target="#addSoutenanceModal">
    Ajouter une Soutenance
</button>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
