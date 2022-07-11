<?php use App\Models\Product; ?>

@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active"><a href="{{ url('/orders') }}">Commandes</a></li>
    </ul>
	<h3>commande numéro {{ $orderDetails['id'] }}</h3>
	<hr class="soft"/>

    <div class="row" style="margin: 1rem">
        <div class="span4">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="2">Détails de la commande</td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                </tr>
                <tr>
                    <td>Statut</td>
                    <td>{{ $orderDetails['id'] }}</td>
                </tr>
                @if(!empty($orderDetails['courrier_name']))
                <tr>
                    <td>Nom du courrier</td>
                    <td>{{ $orderDetails['courrier_name'] }}</td>
                </tr>
                @endif
                @if(!empty($orderDetails['tracking_number']))
                <tr>
                    <td>Numéro de suivi</td>
                    <td>{{ $orderDetails['tracking_number'] }}</td>
                </tr>
                @endif
                <tr>
                    <td>Total</td>
                    <td>{{ $orderDetails['grand_total'] }} Fcfa</td>
                </tr>
                <tr>
                    <td>Taxes</td>
                    <td>{{ $orderDetails['shipping_charges'] }} Fcfa</td>
                </tr>
                <tr>
                    <td>Coupon code</td>
                    <td>{{ $orderDetails['coupon_code'] }}</td>
                </tr>
                <tr>
                    <td>Montant du coupon</td>
                    <td>{{ $orderDetails['coupon_amount'] }}</td>
                </tr>
                <tr>
                    <td>Méthode de paiement</td>
                    <td>{{ $orderDetails['payment_method'] }}</td>
                </tr>
            </table>
        </div>
        <div class="span4">
            <table class="table table-striped table-bordered">
                <tr>
                    <td colspan="2"><strong>Adresse de livraison</strong></td>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td>{{ $orderDetails['name'] }}</td>
                </tr>
                <tr>
                    <td>Adresse</td>
                    <td>{{ $orderDetails['address'] }}</td>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td>{{ $orderDetails['name'] }}</td>
                </tr>
                <tr>
                    <td>Numéro de téléphone</td>
                    <td>{{ $orderDetails['mobile'] }}</td>
                </tr>
            </table>
        </div>
    </div>

        <div class="row" style="margin: 1rem">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Photo</th>
                        <th>Numéro du produit</th>
                        <th>Nom du produit</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Quantité</th>
                    </tr>
                    @foreach ($orderDetails['orders_products'] as $product)
                        <tr>
                            <td><?php $getProductImage=Product::getProductImage($product['product_id'])
                             ?>
                             <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width: 80px" src="{{ $getProductImage }}" alt=""></a>

                             </td>
                            <td>{{ $product['product_code'] }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td>{{ $product['product_size'] }}</td>
                            <td>{{ $product['product_color'] }}</td>
                            <td>{{ $product['product_qty'] }}</td>
                        </tr>
                    @endforeach
                </table>
        </div>
	</div>
	</div>

</div>
</div></div>
</div>


@endsection
