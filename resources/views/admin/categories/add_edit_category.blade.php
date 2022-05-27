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
        @if ($errors->any())
            <div class="alert alert-danger" style="margin-top: 10px">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{ url('/admin/add-edit-category') }}" method="post" enctype="multipart/form-data" name="categoryForm" id="categoryForm">
          @csrf
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
                        <label for="category_name">Nom</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Entrez le nom de la sous-catégorie">
                    </div>
                  <!-- /.form-group -->
                  <div id="appendCategoriesLevel">
                      @include('admin.categories.append_categories_level')
                  </div>

                  <div class="form-group">
                    <label for="category_discount">Remise</label>
                    <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="Entrez le nom de la sous-catégorie" >
                </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea rows="3" name="description" id="description" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="meta_description">Meta description</label>
                    <textarea  rows="3" name="meta_description" id="meta_description" class="form-control"></textarea>
                  </div>
                </div>



                <!-- /.col -->
                <div class="col-md-6">

                  <div class="form-group">
                      <label>Choisir la catégorie</label>
                      <select name="section_id" id="section_id" class="form-control select2bs4" style="width: 100%;">
                        <option value="">Sélectionner</option>
                        @foreach ($getSections as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                      <label for="">Image</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="category_image" id="category_image" class="custom-file-input">
                          <label for="" class="custom-file-label">Choisir le fichier</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">
                            upload
                          </span>
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <label for="url">url</label>
                    <input type="text" id="url" class="form-control" name="url" placeholder="url">
                </div>

                <div class="form-group">
                  <label for="meta_title">Meta titre</label>
                  <textarea  rows="3" name="meta_title" id="meta_title" class="form-control"></textarea>
                </div>

              <div class="form-group">
                <label for="category_name">Mots clés</label>
                <textarea  rows="3" name="meta_keywords" id="meta_keywords" class="form-control"></textarea>
              </div>


                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Soumettre</button>
            </div>
          </div>
        </form>

        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
