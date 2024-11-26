@extends('layouts.crudStudent')

@section('title', 'Gestion des Étudiants')

@section('content')
<div class="col-md-offset-1 col-md-10" style="left: 85px">
    <div class="panel">
        <div class="panel-heading">
            <h4 class="title">Liste des Étudiants</h4>
            <form action="{{ route('students.index') }}" method="GET" class="search-bar">
                <input type="text" name="search" class="form-control" placeholder="Rechercher" value="{{ request()->input('search') }}" />
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Rechercher
                </button>
            </form>
        </div>

        <div class="panel-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Classe</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="studentList">
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->cin }}</td>
                        <td>{{ $student->nom }}</td>
                        <td>{{ $student->prenom }}</td>
                        <td>{{ $student->classe }}</td>
                        <td>
                            <ul class="action-list">
                                <li>
                                    <a href="#" class="editStudentBtn" data-id="{{ $student->id }}" title="Modifier" data-toggle="modal" data-target="#editStudentModal">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" data-toggle="modal" data-target="#confirmDeleteModal" title="Supprimer" onclick="setDeleteStudentId('{{ $student->id }}')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col col-sm-6 col-xs-6">
                    Affichage <b>{{ $students->count() }}</b> sur <b>{{ $students->total() }}</b> entrées
                </div>
                <div class="col-sm-6 col-xs-6">
                    <ul class="pagination hidden-xs pull-right">
                        {{ $students->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fixed-buttons">
    <button class="btn btn-default" title="Ajouter Étudiant" data-toggle="modal" data-target="#addStudentModal">
        <i class="fa fa-plus"></i> Ajouter Étudiant
    </button>
    <button class="btn btn-green" title="Importer Excel" data-toggle="modal" data-target="#importExcelModal">
        <i class="fas fa-file-excel"></i> Importer XL
    </button>



</div>


@endsection

@section('modals')
@include('students.add')
@include('students.delete')
@include('students.edit')
@include('students.excelimport')
@endsection