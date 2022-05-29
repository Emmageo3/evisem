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
        <form @if(empty($categorydata['id'])) action="{{ url('/admin/add-edit-category') }}" @else action="{{ url('/admin/add-edit-category/'.$categorydata['id']) }}" @endif  method="post" enctype="multipart/form-data" name="categoryForm" id="categoryForm">
          @csrf
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">{{ $title }}</h3>

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
                        <input type="text" class="form-control" id="category_name" name="category_name"
                         placeholder="Entrez le nom de la sous-catégorie"
                        @if (!empty($categorydata['category_name']))
                             value="{{ $categorydata['category_name'] }}"
                        @else
                             value="{{ old('category_name') }}"
                        @endif>
                    </div>


                  <div class="form-group">
                    <label>Choisir la catégorie</label>
                    <select name="section_id" id="section_id" class="form-control select2bs4" style="width: 100%;">
                      <option value="">Sélectionner</option>
                      @foreach ($getSections as $section)
                      <option value="{{ $section->id }}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected @endif>{{ $section->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="category_discount">Remise</label>
                    <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="Entrez le nom de la sous-catégorie"
                    @if (!empty($categorydata['category_discount']))
                             value="{{ $categorydata['category_discount'] }}"
                    @else
                             value="{{ old('category_discount') }}"
                    @endif>
                </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">
                        @if (!empty($categorydata['description']))
                                {{ $categorydata['description'] }}"
                        @else
                                {{ old('description') }}"
                        @endif
                    </textarea>
                  </div>

                  <div class="form-group">
                    <label for="meta_description">Meta description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control">
                    @if (!empty($categorydata['meta_description']))
                             {{ $categorydata['meta_description'] }}
                    @else
                             {{ old('meta_description') }}
                    @endif
                </textarea>
                  </div>
                </div>



                <!-- /.col -->
                <div class="col-md-6">
                     <!-- /.form-group -->
                  <div id="appendCategoriesLevel">
                    @include('admin.categories.append_categories_level')
                </div>

                  <!-- /.form-group -->
                  <div class="form-group">
                      <label for="category_image">Image</label>
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
                      @if (!empty($categorydata['category_image']))
                          <div style="height: 100px">
                              <img style="width: 50px" src="{{ asset($categorydata['category_image']) }}" alt="">
                          </div>
                          &nbsp;Supprimer l'image
                      @endif
                  </div>

                  <div class="form-group">
                    <label for="url">url</label>
                    <input type="text" id="url" class="form-control" name="url" placeholder="url"
                    @if (!empty($categorydata['url']))
                             value="{{ $categorydata['url'] }}"
                    @else
                             value="{{ old('url') }}"
                    @endif>
                </div>

                <div class="form-group">
                  <label for="meta_title">Meta titre</label>
                  <textarea name="meta_title" id="meta_title" class="form-control">
                  @if (!empty($categorydata['meta_title']))
                             {{ $categorydata['meta_title'] }}
                    @else
                             {{ old('meta_title') }}
                    @endif
                </textarea>
                </div>

              <div class="form-group">
                <label for="category_name">Mots clés</label>
                <textarea name="meta_keywords" id="meta_keywords" class="form-control">@if (!empty($categorydata['meta_keywords'])) {{ $categorydata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif </textarea>
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
