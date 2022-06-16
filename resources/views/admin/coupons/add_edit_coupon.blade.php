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
            <div class="alert alert-success fade show" role="alert" style="margin-top: 10px">
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
                            @if(empty($coupon['coupon_code']))
                                <div class="form-group">
                                    <label for="coupon_option">Option de coupon</label><br>
                                    <span><input id="automaticCoupon" type="radio" name="coupon_option" value="automatic">&nbsp;Coupon automatique&nbsp;&nbsp;</span>
                                    &nbsp;&nbsp;
                                    <span><input id="manualCoupon" type="radio" name="coupon_option" checked value="manual">&nbsp;Coupon manuel&nbsp;</span>
                                </div>

                                <div class="form-group" style="display: none" id="couponField">
                                    <label for="coupon_code">Code</label>
                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code"
                                    placeholder="Entrez le code du coupon"
                                    @if (!empty($coupondata['coupon_code']))
                                        value="{{ $coupondata['coupon_code'] }}"
                                    @else
                                        value="{{ old('coupon_code') }}"
                                    @endif>
                                </div>
                            @else
                                <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                                <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                                <div class="form-group" id="couponField">
                                    <label for="coupon_code">Code : </label>
                                    <span>{{ $coupon['coupon_code'] }}</span>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="coupon_type">Type de coupon</label><br>
                                <span><input type="radio" name="coupon_type" value="Plusieurs fois" @if(isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Plusieurs fois") checked @endif>&nbsp;Plusieurs fois&nbsp;&nbsp;</span>
                                &nbsp;&nbsp;
                                <span><input type="radio" name="coupon_type" value="une fois" @if(isset($coupon['coupon_type']) && $coupon['coupon_type'] == "une fois") checked @endif>&nbsp;Une fois&nbsp;</span>
                            </div>

                            <div class="form-group">
                                <label for="amount_type">Type de montant</label><br>
                                <span><input type="radio" name="amount_type"  value="Pourcentage" @if(isset($coupon['amount_type']) && $coupon['amount_type'] == "Pourcentage") checked @endif>&nbsp;Pourcentage (en %)&nbsp;&nbsp;</span>
                                &nbsp;&nbsp;
                                <span><input type="radio" name="amount_type" value="fixe" @if(isset($coupon['amount_type']) && $coupon['amount_type'] == "fixe") checked @endif>&nbsp;fixe (en Fcfa)&nbsp;</span>
                            </div>

                            <div class="form-group">
                                <label for="amount">Montant</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                placeholder="Entrez le montant du coupon"
                                @if (!empty($coupondata['amount']))
                                    value="{{ $coupondata['amount'] }}"
                                @else
                                    value="{{ old('amount') }}"
                                @endif>
                            </div>

                            <div class="form-group">
                                <label for="categories">Choisir une catégorie</label>
                                <select name="categories[]" class="form-control select2bs4" style="width: 100%;" multiple>
                                    <option value="">Sélectionner</option>
                                    @foreach ($categories as $section)
                                        <optgroup label="{{ $section['name'] }}"></optgroup>
                                        @foreach ($section['categories'] as $category)
                                            <option value="{{ $category['id'] }}" @if (in_array($category['id'],$selCats)) selected @endif>&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                            @foreach ($category['subcategories'] as $subcategory)
                                                <option value="{{ $subcategory['id'] }}"
                                                @if (in_array($subcategory['id'],$selCats)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                  </select>
                            </div>

                            <div class="form-group">
                                <label for="users">Choisir un utilisateur</label>
                                <select name="users[]" class="form-control select2bs4" style="width: 100%;" multiple data-live-search="true">
                                    <option value="">Sélectionner</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user['email'] }}" @if (in_array($user['email'],$selUsers)) selected @endif>{{ $user['email'] }}</option>
                                    @endforeach
                                  </select>
                            </div>

                            <div class="form-group">
                                <label for="expiry_date">Date d'expiration</label>
                                <input type="text" class="form-control" name="expiry_date" id="expiry_date"
                                placeholder="Entrez la date d'expiration du coupon" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask
                                @if (!empty($coupondata['expiry_date']))
                                    value="{{ $coupondata['expiry_date'] }}"
                                @else
                                    value="{{ old('expiry_date') }}"
                                @endif>
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
