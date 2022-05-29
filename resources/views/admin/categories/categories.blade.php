@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sous-catégories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Sous-catégories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sections</h3>
                <a href="{{ url('admin/add-edit-category') }}" style="max-width: 200px; float: right;display: inline-block" class="btn btn-block btn-success">Ajouter une sous-catégorie</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="categories" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Catégorie</th>
                    <th>Nom</th>
                    <th>url</th>
                    <th>Statut</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $category)
                    @if (!isset($category->parentcategory->category_name))
                        <?php $parent_category = "Root"; ?>
                    @else
                        <?php $parent_category = $category->parentcategory->category_name; ?>
                    @endif
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->section->name }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>{{ $category->url }}</td>
                        <td>
                         @if($category->status==1)
                         <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}">Actif</a>
                         @else
                         <a href="javascript:void(0)" class="updateCategoryStatus" id="category-{{ $category->id }}" category_id="{{ $category->id }}">Inactif</a>
                         @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/add-edit-category/'.$category->id) }}">Modifier</a>
                            &nbsp;&nbsp;
                            <a class="confirmDelete" record="category" recordid="{{ $category->id }}" href="javascript:void(0)">Supprimer</a>
                        </td>
                    </tr>
                  @endforeach
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
