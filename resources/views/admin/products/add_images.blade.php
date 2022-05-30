@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Images</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Ajouter des images</li>
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

            <form action="{{ url('/admin/add-images/'.$productdata['id']) }}" method="post" name="addImageForm" id="addImageForm" enctype="multipart/form-data">
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
                                    <input style="width: 120px" type="file" name="images[]" id="images" required multiple/>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    @if (!empty($productdata['main_image']))
                                        <div style="margin-top: 5px;">
                                            <img style="width: 150px" src="{{ asset($productdata['main_image']) }}" alt="image">
                                        </div>
                                        &nbsp;
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Ajouter les images</button>
                </div>
            </form>


            <form method="post" action="{{ url('/admin/edit-images/'.$productdata['id']) }}" name="editImageForm" id="editImageForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Images</h3>
                    </div>
                    <div class="card-body">
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Images</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productdata['images'] as $image)
                                <input style="display: none" type="text" name="imageID[]" value="{{ $image['id'] }}">
                                <tr>
                                    <td>{{ $image['id'] }}</td>
                                    <td>
                                        <img width="160px" src="{{ asset($image['image']) }}" alt="{{ $image['image'] }}">
                                    </td>
                                    <td>
                                        @if($image['status']==1)
                                        <a href="javascript:void(0)" class="updateImageStatus" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}">Actif</a>
                                        @else
                                        <a href="javascript:void(0)" class="updateImageStatus" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}">Inactif</a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a class="confirmDelete" record="image" recordid="{{ $image['id'] }}" href="javascript:void(0)">Supprimer</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Mettre a jour les images</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
    <!-- /.content -->
</div>

@endsection
