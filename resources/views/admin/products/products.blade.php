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
              <li class="breadcrumb-item active">Produits</li>
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
                <a href="{{ url('admin/add-edit-product') }}" style="max-width: 200px; float: right;display: inline-block" class="btn btn-block btn-success">Ajouter un produit</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Catégorie</th>
                    <th>Sous catégorie</th>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Couleur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->section->name }}</td>
                        <td>{{ $product->category->category_name }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_code }}</td>
                        <td>{{ $product->product_color }}</td>
                        <td>
                         @if($product->status==1)
                         <a href="javascript:void(0)" class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}">Actif</a>
                         @else
                         <a href="javascript:void(0)" class="updateProductStatus" id="product-{{ $product->id }}" product_id="{{ $product->id }}">Inactif</a>
                         @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/add-edit-product/'.$product->id) }}">Modifier</a>
                            &nbsp;&nbsp;
                            <a class="confirmDelete" record="product" recordid="{{ $product->id }}" href="javascript:void(0)">Supprimer</a>
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
