@extends('layouts.admin_layout.admin_layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Parametres</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Accueil</a></li>
              <li class="breadcrumb-item active">Parametres</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Mettre a jour les détails de l'administrateur</h3>
                </div>
                <!-- /.card-header -->
                @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px">
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
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

                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 10px">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- form start -->
                <form method="post" role="form" action="{{ url('/admin/update-admin-details') }}" name="updateAdminDetails" id="updateAdminDetails" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                 <?php /*
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom</label>
                        <input class="form-control" value="{{ $adminDetails->name }}" readonly>
                    </div>*/?>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Adresse email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Type d'administrateur</label>
                        <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly>
                      </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nom complet</label>
                      <input type="text" class="form-control" name="admin_name" id="admin_name" value="{{ Auth::guard('admin')->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Numéro de téléphone</label>
                        <input type="text" class="form-control" id="admin_mobile" name="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Photo</label>
                        <input type="file" class="form-control" name="admin_image" id="admin_image" accept="image/*">
                        @if(!empty(Auth::guard('admin')->user()->image))
                        <a target="_blank" href="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}">Voir la photo</a>
                        <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                        @endif
                      </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Soumettre</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
      </section>

</div>
<!-- /.content-wrapper -->
@endsection
