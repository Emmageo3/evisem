@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Frais de livraison</h1>
            </div>
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Frais de livraison</li>
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
                <h3 class="card-title">Frais de livraison</h3>
                <a href="{{ url('admin/add-edit-product') }}" style="max-width: 200px; float: right;display: inline-block" class="btn btn-block btn-success">Ajouter un produit</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Zone</th>
                    <th>Frais de livraison</th>
                    <th>Statut</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($shipping_charges as $shipping)
                    <tr>
                        <td>{{ $shipping['id'] }}</td>
                        <td>{{ $shipping['zone']  }}</td>
                        <td>{{ $shipping['shipping_charges'] }} Fcfa</td>
                        <td>
                        @if($shipping['status']==1)
                         <a href="javascript:void(0)" class="updateShippingStatus">Actif</a>
                         @else
                         <a href="javascript:void(0)" class="updateShippingStatus">Inactif</a>
                         @endif
                        </td>
                        <td>
                            <a title="mettre a jour les frais de livraison" href=""><i class="fas fa-edit"></i></a>
                            &nbsp;&nbsp;
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
