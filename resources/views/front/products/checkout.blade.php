<?php use App\Models\Product; ?>

@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Valider la commande</li>
    </ul>
	<h3>  Valider la commande [ <span class="totalCartItems"> {{ totalCartItems() }}</span>  produits ]
        <a href="{{ url('/cart') }}" class="btn btn-large pull-right">
            <i class="icon-arrow-left"></i> Retourner au panier
        </a>
    </h3>
	<hr class="soft"/>

    @if(Session::has('error_message'))
        <div class="alert alert-danger" role="alert" style="margin-top: 10px">
            Ce produit a déja été ajouté au panier !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(Session::has('error_message1'))
        <div class="alert alert-danger" role="alert" style="margin-top: 10px">
            Veuillez choisir une adresse de livraison
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(Session::has('error_message2'))
        <div class="alert alert-danger" role="alert" style="margin-top: 10px">
            Veuillez choisir une méthode de paiement
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(Session::has('success_message'))
        <div class="alert alert-success" role="alert" style="margin-top: 10px">
            Ce produit a été ajouté au panier avec succès !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">
        @csrf
        <table class="table table-bordered">
            <tr><th><strong> Adresses de livraison </strong> | <a href="{{ url('add-edit-delivery-address') }}">Ajouter une adresse</a> </th></tr>
            @foreach($deliveryAddresses as $address)
            <tr>
            <td>
                    <div class="control-group" style="float: left; margin-top: -2px; margin-right: 5px">
                        <input type="radio" id="address{{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}">
                    </div>
                    <div class="control-group">
                    <label class="control-label" for="inputPassword1">{{ $address['name']}}, {{ $address['address'] }}, {{ $address['city'] }}-{{ $address['pincode'] }}, {{ $address['country'] }}, <span style="float: right">tel: {{ $address['mobile'] }}</span></label>
                    </div>
            </td>
            <td><a href="{{ url('add-edit-delivery-address/'.$address['id']) }}">Modifier</a> | <a href="{{ url('delete-delivery-address/'.$address['id']) }}" class="addressDelete">Supprimer</a></td>
            </tr>
            @endforeach
        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th colspan="2">Description</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Remise</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_price = 0; ?>
                @foreach ($userCartItems as $item)
                    <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']);?>
                    <tr>
                        <td>
                            <img width="60" src="{{ asset($item['product']['main_image']) }}" alt=""/>
                        </td>
                        <td colspan="2">{{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br> Taille: {{ $item['size'] }}</td>
                        <td>
                            {{ $item['quantity'] }}
                        </td>
                        <td>{{ $attrPrice['product_price'] }} Fcfa</td>
                        <td>{{ $attrPrice['discount'] }} Fcfa</td>
                        @if($attrPrice['discount']>0)
                            <td>{{ $attrPrice['final_price'] * $item['quantity'] }} Fcfa</td>
                        @else
                            <td>{{ $attrPrice['product_price']  * $item['quantity']}} Fcfa</td>
                        @endif
                    </tr>
                        <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']) ?>
                @endforeach

                    <tr>
                        <td colspan="6" style="text-align:right">Prix total:	</td>
                        <td>{{ $total_price }} Fcfa</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right">Appliquer le coupon:	</td>
                        <td class="couponAmount">
                            @if(Session::has('couponAmount'))
                            - {{ Session::get('couponAmount') }} Fcfa
                            @else
                                0 Fcfa
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align:right"><strong>TOTAL ({{ $total_price }} Fcfa - {{ Session::get('couponAmount') }} Fcfa) =</strong></td>
                        <td class="label label-important" style="display:block"> <strong class="grand_total"> {{ $grand_total = $total_price - Session::get('couponAmount') }} Fcfa <?php Session::put('grand_total', $grand_total); ?></strong></td>
                    </tr>
            </tbody>
        </table>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>
                                <div class="control-group">
                                    <label class="control-label"><strong> Méthode de paiement: </strong> </label>
                                    <div class="controls">
                                        <span>
                                            <input type="radio" name="payment_method" id="COD" value="COD"><strong>Payer à la livraison</strong>&nbsp;&nbsp;
                                            <input type="radio" name="payment_method" id="paypal" value="paypal"> <strong>Paypal</strong>
                                        </span>
                                    </div>
                                </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        <a href="{{ url('/cart') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Retourner au panier </a>
        <button type="submit" class="btn btn-large pull-right">Passer la commande <i class="icon-arrow-right"></i></button>
    </form>
</div>
</div></div>
</div>


@endsection
