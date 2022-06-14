@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Coupons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                        <li class="breadcrumb-item active">Ajouter/Modifier un coupon</li>
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

        <form @if(empty($coupondata['id'])) action="{{ url('/admin/add-edit-coupon') }}" @else action="{{ url('/admin/add-edit-coupon/'.$coupondata['id']) }}" @endif  method="post" enctype="multipart/form-data" name="couponForm" id="couponForm">
          @csrf
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
                                <label for="coupon_option">Option de coupon</label><br>
                                <span><input id="automaticCoupon" type="radio" name="coupon_option" value="Automatic">&nbsp;Coupon automatique&nbsp;&nbsp;</span>
                                &nbsp;&nbsp;
                                <span><input id="manualCoupon" type="radio" name="coupon_option" value="manual">&nbsp;Coupon manuel&nbsp;</span>
                            </div>

                            <div class="form-group" style="display: none" id="couponField">
                                <label for="coupon_code">Code</label>
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                placeholder="Entrez le code du coupon">
                            </div>

                            <div class="form-group">
                                <label for="categories">Choisir une catégorie</label>
                                <select name="categories[]" class="form-control select2bs4" style="width: 100%;">
                                    <option value="">Sélectionner</option>
                                    @foreach ($categories as $section)
                                        <optgroup label="{{ $section['name'] }}"></optgroup>
                                        @foreach ($section['categories'] as $category)
                                            <option value="{{ $category['id'] }}" @if(!empty(@old('category_id')) && $category['id'] == @old('category_id')) selected  @elseif(!empty($productdata['category_id']) && $productdata['category_id']==$category['id']) selected @endif>&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                            @foreach ($category['subcategories'] as $subcategory)
                                                <option value="{{ $subcategory['id'] }}"
                                                @if(!empty(@old('category_id')) && $subcategory['id'] == @old('category_id'))
                                                selected @elseif (!empty($productdata['category_id']) && $productdata['category_id']==$subcategory['id'])
                                                selected
                                                @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                  </select>
                            </div>

                        </div>
                        <div class="col-md-6">

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
