@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bannières</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Ajouter/Modifier une bannière</li>
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
        <form @if(empty($bannerdata['id'])) action="{{ url('/admin/add-edit-banner') }}" @else action="{{ url('/admin/add-edit-banner/'.$bannerdata['id']) }}" @endif  method="post" enctype="multipart/form-data" name="bannerForm" id="bannerForm">
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
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" name="title"
                         placeholder="Entrez le titre de la bannière"
                        @if (!empty($bannerdata['title']))
                             value="{{ $bannerdata['title'] }}"
                        @else
                             value="{{ old('title') }}"
                        @endif>
                    </div>

                    <div class="form-group">
                        <label for="image">Bannière</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="image" id="image" class="custom-file-input">
                            <label for="" class="custom-file-label">Choisir le fichier</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">
                              upload
                            </span>
                          </div>
                        </div>
                        @if (!empty($bannerdata['image']))
                              <div style="margin-top: 5px;">
                                  <img style="width: 100px" src="{{ asset($bannerdata['image']) }}" alt="{{ '/storage/'.$bannerdata['image'] }}">
                              </div>
                              &nbsp;
                              <a class="confirmDelete" href="javascript:void(0)" record="banner-image" recordid="{{ $bannerdata['id'] }}">Supprimer l'image</a>
                        @endif
                    </div>

            </div>
                <!-- /.col -->
            <div class="col-md-6">

                <div class="form-group">
                    <label for="link">Lien</label>
                    <input type="text" class="form-control" id="link" name="link"
                     placeholder="Entrez le lien de la bannière"
                    @if (!empty($bannerdata['link']))
                         value="{{ $bannerdata['link'] }}"
                    @else
                         value="{{ old('link') }}"
                    @endif>
                </div>

                <div class="form-group">
                    <label for="alt">Alt</label>
                    <input type="text" class="form-control" id="alt" name="alt"
                     placeholder="Entrez le texte alternatif de la bannière"
                    @if (!empty($bannerdata['alt']))
                         value="{{ $bannerdata['alt'] }}"
                    @else
                         value="{{ old('alt') }}"
                    @endif>
                </div>


                  <!-- /.form-group -->


                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->


          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Soumettre</button>
          </div>
        </form>

        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
