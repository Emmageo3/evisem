@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Commandes</li>
    </ul>
	<h3>Mes commandes</h3>
	<hr class="soft"/>
        <div class="row">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Numéro de commande</th>
                        <th>Produits commandés</th>
                        <th>Méthode de paiement</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Détails</th>
                    </tr>
                    @foreach ($orders as $order)
                        <tr>
                            <td><a style="text-decoration: underline" href="{{ url('orders/'.$order['id']) }}">#{{ $order['id'] }}</a></td>
                            <td>
                                @foreach ($order['orders_products'] as $pro)
                                    {{ $pro['product_code'] }}<br>
                                @endforeach
                            </td>
                            <td>{{ $order['payment_method'] }}</td>
                            <td>{{ $order['grand_total'] }} Fcfa</td>
                            <td>{{ date('d-m-Y', strtotime($order['created_at']))  }}</td>
                            <td><a href="{{ url('orders/'.$order['id']) }}">Voir les détails</a></td>
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
