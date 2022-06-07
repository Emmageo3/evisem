@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
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

    <section class="content">
        <div class="container-fluid">

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
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(Session::has('success_message1'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                    {{ Session::get('success_message1') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ url('/admin/add-attributes/'.$productdata['id']) }}" method="post" name="addAttributeForm" id="addAttributeForm">
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

                            <div class="form-group">
                                <label for="product_color">Prix : {{ $productdata['product_price'] }} Fcfa</label>
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
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Ajouter les attributs</button>
                </div>
            </form>


            <form method="post" action="{{ url('/admin/edit-attributes/'.$productdata['id']) }}" name="editAttributeForm" id="editAttributeForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Attributs</h3>
                    </div>
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
                                <input style="display: none" type="text" name="attrId[]" value="{{ $attribute['id'] }}">
                                <tr>
                                    <td>{{ $attribute['id'] }}</td>
                                    <td>{{ $attribute['size'] }}</td>
                                    <td>{{ $attribute['sku'] }}</td>
                                    <td>
                                        <input type="number" name="price[]" value="{{ $attribute['price'] }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" required>
                                    </td>
                                    <td>
                                        @if($attribute['status']==1)
                                        <a href="javascript:void(0)" class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}">Actif</a>
                                        @else
                                        <a href="javascript:void(0)" class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}">Inactif</a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a class="confirmDelete" record="attribute" recordid="{{ $attribute['id'] }}" href="javascript:void(0)">Supprimer</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Mettre a jour les attributs</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <!-- /.content -->
</div>

@endsection
