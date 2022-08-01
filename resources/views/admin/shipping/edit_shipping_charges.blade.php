@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Frais de livraison</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Modifier les frais de livraison</li>
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
            <div class="alert alert-success fade show" role="alert" style="margin-top: 10px">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form action="{{ url('/admin/edit-shipping-charges/'.$shippingDetails['id']) }}"  method="post" enctype="multipart/form-data" name="shippingForm" id="shippingForm">
          @csrf
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Modifier les frais de livraison</h3>

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
                                <label for="zone">Zone</label><br>
                                <input readonly class="form-control"  name="zone" value="{{ $shippingDetails['zone'] }}">
                            </div>
                            <div class="form-group">
                                <label for="shipping_charges">Montant</label><br>
                                <input class="form-control"  name="shipping_charges" @if(!empty($shippingDetails['shipping_charges'])) value="{{ $shippingDetails['shipping_charges'] }}" @else value="{{ old('shipping_charges') }}" @endif>
                            </div>

                        </div>
                    </div>

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
