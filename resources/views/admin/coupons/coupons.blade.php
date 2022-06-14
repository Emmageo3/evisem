@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Coupons</h1>
            </div>
            <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
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
                <h3 class="card-title">Coupons</h3>
                <a href="{{ url('admin/add-edit-coupon') }}" style="max-width: 200px; float: right;display: inline-block" class="btn btn-block btn-success">Ajouter un coupon</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Montant</th>
                    <th>Date d'expiration</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon['id'] }}</td>
                        <td>{{ $coupon['coupon_code'] }}</td>
                        <td>{{ $coupon['coupon_type'] }}</td>
                        <td>{{ $coupon['amount'] }}</td>
                        <td>{{ $coupon['expiry_date'] }}</td>
                        <td>
                            @if($coupon['status']==1)
                            <a href="javascript:void(0)" class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}">Actif</a>
                            @else
                            <a href="javascript:void(0)" class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}">Inactif</a>
                            @endif
                            &nbsp;&nbsp;
                            <a href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"><i class="fas fa-edit"></i></a>
                            &nbsp;&nbsp;
                            <a href="{{ url('admin/delete-coupon/'.$coupon['id']) }}" class="confirmDelete" record="coupon" recordid="{{ $coupon['id'] }}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
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
