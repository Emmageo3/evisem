@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Bannières</h1>
            </div>
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Bannières</li>
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
                <h3 class="card-title">Bannieres</h3>
                <a href="{{ url('admin/add-edit-product') }}" style="max-width: 200px; float: right;display: inline-block" class="btn btn-block btn-success">Ajouter une bannière</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Link</th>
                    <th>Title</th>
                    <th>Alt</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($banners as $banner)
                    <tr>
                        <td>{{ $banner['id'] }}</td>
                        <td><img src="{{ asset('images/admin_images/'.$banner['image']) }}" alt=""></td>
                        <td>{{ $banner['link'] }}</td>
                        <td>{{ $banner['title'] }}</td>
                        <td>{{ $banner['alt'] }}</td>
                        <td>
                            @if($banner['status']==1)
                            <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}"><i class='fas fa-toggle-on' aria-hidden="true" status="actif"></i></a>
                            @else
                            <a href="javascript:void(0)" class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}"><i class='fas fa-toggle-off' aria-hidden="true" status="inactif"></i></a>
                            @endif
                            &nbsp;&nbsp;
                            <a href="{{ url('admin/add-edit-banner/'.$banner['id']) }}"><i class="fas fa-edit"></i></a>
                            &nbsp;&nbsp;
                            <a class="confirmDelete" record="banner" recordid="{{ $banner['id'] }}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
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
