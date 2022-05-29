@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Produits</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Ajouter/Modifier un produit</li>
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
        <form @if(empty($productdata['id'])) action="{{ url('/admin/add-edit-product') }}" @else action="{{ url('/admin/add-edit-product/'.$productdata['id']) }}" @endif  method="post" enctype="multipart/form-data" name="productForm" id="productForm">
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
                        <label>Choisir la sous catégorie</label>
                        <select name="product_id" id="product_id" class="form-control select2bs4" style="width: 100%;">
                          <option value="">Sélectionner</option>
                          @foreach ($categories as $section)
                              <optgroup label="{{ $section['name'] }}"></optgroup>
                              @foreach ($section['categories'] as $category)
                                  <option value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                  @foreach ($category['subcategories'] as $subcategory)
                                      <option value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                  @endforeach
                              @endforeach
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="product_name">Nom</label>
                        <input type="text" class="form-control" id="product_name" name="product_name"
                         placeholder="Entrez le nom du produit"
                        @if (!empty($productdata['product_name']))
                             value="{{ $productdata['product_name'] }}"
                        @else
                             value="{{ old('product_name') }}"
                        @endif>
                    </div>

                    <div class="form-group">
                        <label for="product_price">Prix</label>
                        <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Entrez le prix du produit"
                        @if (!empty($productdata['product_price']))
                                value="{{ $productdata['product_price'] }}"
                        @else
                                value="{{ old('product_price') }}"
                        @endif>
                    </div>

                    <div class="form-group">
                        <label for="product_discount">Remise (%)</label>
                        <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Entrez la remise du produit"
                        @if (!empty($productdata['product_discount']))
                                value="{{ $productdata['product_discount'] }}"
                        @else
                                value="{{ old('product_discount') }}"
                        @endif>
                    </div>



                    <div class="form-group">
                        <label for="product_video">Vidéo</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="product_video" id="product_video" class="custom-file-input">
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
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control">@if (!empty($categorydata['description'])) {{ $categorydata['description'] }} @else {{ old('description') }} @endif </textarea>
                  </div>

                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Manches</label>
                        <select name="sleeve" id="sleeve" class="form-control select2bs4" style="width: 100%;">
                          <option value="">Sélectionner</option>
                          @foreach ($sleeveArray as $sleeve)
                              <option value="{{ $sleeve }}">{{ $sleeve }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Motif</label>
                        <select name="pattern" id="pattern" class="form-control select2bs4" style="width: 100%;">
                          <option value="">Sélectionner</option>
                          @foreach ($patternArray as $pattern)
                              <option value="{{ $pattern }}">{{ $pattern }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                            <label for="meta_title">Meta titre</label>
                            <textarea name="meta_title" id="meta_title" class="form-control">@if (!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }} @else {{ old('meta_title') }} @endif
                        </textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="meta_keywords">Mots clés</label>
                    <textarea name="meta_keywords" id="meta_keywords" class="form-control">@if (!empty($productdata['meta_keywords'])) {{ $productdata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif </textarea>
                </div>

            </div>
                <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                    <label for="product_code">Code</label>
                    <input type="text" class="form-control" id="product_code" name="product_code"
                     placeholder="Entrez le code du produit"
                    @if (!empty($productdata['product_code']))
                         value="{{ $productdata['product_code'] }}"
                    @else
                         value="{{ old('product_code') }}"
                    @endif>
                </div>

                <div class="form-group">
                    <label for="product_color">Couleur</label>
                    <input type="text" class="form-control" id="product_color" name="product_color"
                     placeholder="Entrez le color du produit"
                    @if (!empty($productdata['product_color']))
                         value="{{ $productdata['product_color'] }}"
                    @else
                         value="{{ old('product_color') }}"
                    @endif>
                </div>

                <div class="form-group">
                    <label for="product_weight">Poids (kg)</label>
                    <input type="text" class="form-control" name="product_weight" id="product_weight" placeholder="Entrez le poids du produit"
                    @if (!empty($productdata['product_weight']))
                            value="{{ $productdata['product_weight'] }}"
                    @else
                            value="{{ old('product_weight') }}"
                    @endif>
                </div>

                <div class="form-group">
                    <label for="main_image">Image principale</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="main_image" id="main_image" class="custom-file-input">
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
                    <label for="wash_care">Soins</label>
                    <textarea name="wash_care" id="wash_care" class="form-control">@if (!empty($productdata['wash_care'])) {{ $productdata['wash_care'] }} @else {{ old('wash_care') }} @endif
                  </textarea>
                </div>

                <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label>Matiere</label>
                    <select name="fabric" id="fabric" class="form-control select2bs4" style="width: 100%;">
                      <option value="">Sélectionner</option>
                      @foreach ($fabricArray as $fabric)
                          <option value="{{ $fabric }}">{{ $fabric }}</option>
                      @endforeach
                    </select>
                </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Occasion</label>
                        <select name="occasion" id="occasion" class="form-control select2bs4" style="width: 100%;">
                          <option value="">Sélectionner</option>
                          @foreach ($occasionArray as $occasion)
                              <option value="{{ $occasion }}">{{ $occasion }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="fit" id="fit" class="form-control select2bs4" style="width: 100%;">
                          <option value="">Sélectionner</option>
                          @foreach ($fitArray as $fit)
                              <option value="{{ $fit }}">{{ $fit }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="meta_description">Meta description</label>
                        <textarea name="meta_description" id="meta_description" class="form-control">@if (!empty($productdata['meta_description'])) {{ $productdata['meta_description'] }} @else {{ old('meta_description') }} @endif </textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_featured">En vedette ?</label>
                    <input type="checkbox" name="is_featured" id="is_featured" value="1">
                </div>


                  <!-- /.form-group -->


                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

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
