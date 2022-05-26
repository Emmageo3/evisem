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
              <li class="breadcrumb-item active">Ajouter/Modifier une sous-catégorie</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Ajouter une sous-catégorie</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="category_name">Nom de la sous-catégorie</label>
                      <input type="email" class="form-control" name="category_name" placeholder="Entrez le nom de la sous-catégorie" id="">
                  </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Choisir le niveau de la catégorie</label>
                    <select name="parent_id" class="form-control select2bs4" style="width: 100%;">
                      <option value="">Catégorie principale</option>
                      @foreach ($getSections as $section)
                      <option>{{ $section->name }}</option>
                      @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="category_name">url de la sous-categories</label>
                    <input type="email" class="form-control" name="category_name" placeholder="Entrez le nom de la sous-catégorie" id="">
                </div>
              </div>



              <!-- /.col -->
              <div class="col-md-6">

                <div class="form-group">
                    <label>Choisir la catégorie</label>
                    <select name="section_id" class="form-control select2bs4" style="width: 100%;">
                      <option value="">Sélectionner</option>
                      @foreach ($getSections as $section)
                      <option>{{ $section->name }}</option>
                      @endforeach
                    </select>
                  </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="exampleInputPassword1">Image de la sous-catégorie</label>
                    <input type="file" class="form-control" name="category_image" id="category_image" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="category_name">Remise</label>
                    <input type="email" class="form-control" name="category_name" placeholder="Entrez le nom de la sous-catégorie" id="">
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
