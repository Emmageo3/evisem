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
                    </tr>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order['id'] }}</td>
                            <td>
                                @foreach ($order['orders_products'] as $pro)
                                    {{ $pro['product_code'] }}<br>
                                @endforeach
                            </td>
                            <td>{{ $order['payment_method'] }}</td>
                            <td>{{ $order['grand_total'] }} Fcfa</td>
                            <td>{{ date('d-m-Y', strtotime($order['created_at']))  }}</td>
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
