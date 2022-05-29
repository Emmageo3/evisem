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
              <li class="breadcrumb-item active">Ajouter/Modifier des attributs</li>
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
        <form action="{{ url('/admin/add-attributes/'.$productdata['id']) }}" method="post" name="attributeForm" id="attributeForm">
          @csrf
          <input type="hidden" name="product_id" value="{{ $productdata['id'] }}">
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
                        <label for="product_name">Nom : {{ $productdata['product_name'] }}</label>
                    </div>

                    <div class="form-group">
                        <label for="product_code">Code : {{ $productdata['product_code'] }}</label>
                    </div>

                    <div class="form-group">
                        <label for="product_color">Couleur : {{ $productdata['product_color'] }}</label>
                    </div>

                    <div class="field_wrapper">
                        <div>
                            <input style="width: 120px" type="text" name="size[]" id="size" placeholder="taille" required/>
                            <input style="width: 120px" type="text" name="sku[]" id="sku" placeholder="codeSKU" required/>
                            <input style="width: 120px" type="text" name="price[]" id="price" placeholder="prix" required/>
                            <input style="width: 120px" type="text" name="stock[]" id="stock" placeholder="Stock" required/>
                            <a href="javascript:void(0);" class="add_button" title="Add field">Ajouter</a>
                        </div>
                    </div>


            </div>
                <!-- /.col -->
            <div class="col-md-6">


                <div class="form-group">
                    <div class="input-group">
                        @if (!empty($productdata['main_image']))
                            <div style="margin-top: 5px;">
                                <img style="width: 100px" src="{{ asset($productdata['main_image']) }}" alt="{{ '/storage/'.$productdata['main_image'] }}">
                            </div>
                            &nbsp;
                        @endif
                    </div>
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


        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Attributs</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="products" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Taille</th>
                  <th>SKU</th>
                  <th>Prix</th>
                  <th>Stock</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($productdata['attributes'] as $attribute)
                  <tr>
                      <td>{{ $attribute['id'] }}</td>
                      <td>{{ $attribute['size'] }}</td>
                      <td>{{ $attribute['sku'] }}</td>
                      <td>{{ $attribute['price'] }}</td>
                      <td>{{ $attribute['stock'] }}</td>
                      <td>
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

        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
