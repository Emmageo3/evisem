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
                  <h3 class="card-title">Mettre a jour le mot de passe</h3>
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
                <!-- form start -->
                <form method="post" role="form" action="{{ url('/admin/update-current-pwd') }}" name="updatePasswordForm" id="updatePasswordForm">
                    @csrf
                    <div class="card-body">
                 <?php /*
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom</label>
                        <input class="form-control" value="{{ $adminDetails->name }}" readonly>
                    </div>*/?>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Adresse email</label>
                      <input class="form-control" value="{{ $adminDetails->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Type d'administrateur</label>
                        <input class="form-control" value="{{ $adminDetails->type }}" readonly>
                      </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Mot de passe actuel</label>
                      <input type="password" class="form-control" name="current_pwd" id="current_pwd" placeholder="Mot de passe actuel" required>
                      <span id="checkCurrentPwd"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_pwd" name="new_pwd" placeholder="Changer le mot de passe" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" name="confirm_pwd" id="confirm_pwd" placeholder="Confirmer le nouveau mot de passe" required>
                      </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Check me out</label>
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
