@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Commandes</h1>
            </div>
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Commandes</li>
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
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Numéro de commande</th>
                    <th>Date</th>
                    <th>Nom du client</th>
                    <th>Mail du client</th>
                    <th>Produits commandés</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Méthode de paiement</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ date('d-m-Y', strtotime($order['created_at']))  }}</td>
                        <td>{{ $order['name'] }}</td>
                        <td>{{ $order['email'] }}</td>
                        <td>
                            @foreach ($order['orders_products'] as $pro)
                                {{ $pro['product_code'] }} ({{ $pro['product_qty'] }})<br>
                            @endforeach
                        </td>
                        <td>{{ $order['grand_total'] }} Fcfa</td>
                        <td>{{ $order['order_status'] }}</td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>
                            <a title="voir les détails de la commande" href="{{ url('admin/orders/'.$order['id']) }}"><i class="fas fa-file"></i></a>&nbsp;&nbsp;
                            @if($order['order_status']=="En cours de livraison" || $order['order_status']=="Livré")
                            <a title="voir la facture" href="{{ url('admin/view-order-invoice/'.$order['id']) }}"><i class="fas fa-print"></i></a>
                            @endif
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
