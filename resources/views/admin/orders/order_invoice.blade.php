<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
    .invoice-title h2, .invoice-title h3 {
    display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Facture</h2><h3 class="pull-right">Commande # {{ $orderDetails['id'] }}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturée à:</strong><br>
    					{{ $userDetails['name'] }}<br>
                        @if(!empty($userDetails['address']))
    					{{ $userDetails['address'] }}<br>
                        @endif
                        @if(!empty($userDetails['city']))
                        {{ $userDetails['city'] }},
                        @endif
                        {{ $userDetails['country'] }}<br>
                        {{ $userDetails['pincode'] }}<br>
                        @if(!empty($userDetails['mobile']))
                        {{ $userDetails['mobile'] }}<br>
                        @endif
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Livrée à:</strong><br>
                    {{ $orderDetails['name'] }}<br>
                    {{ $orderDetails['address'] }}<br>
                    {{ $orderDetails['city'] }},
                    {{ $orderDetails['country'] }}<br>
                    {{ $orderDetails['pincode'] }}<br>
                    {{ $orderDetails['mobile'] }}<br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Méthode de paiement:</strong><br>
    					{{ $orderDetails['payment_method'] }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Date:</strong><br>
    					{{ date('d-m-Y',strtotime($orderDetails['created_at'])) }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Détails de la commande</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Article</strong></td>
        							<td class="text-center"><strong>Prix</strong></td>
        							<td class="text-center"><strong>Quantité</strong></td>
        							<td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                @php $subtotal = 0; @endphp
    							@foreach ($orderDetails['orders_products'] as $product)
                                <tr>
    								<td>
                                        Nom : {{ $product['product_name'] }} <br>
                                        Code : {{ $product['product_code'] }} <br>
                                        Taille : {{ $product['product_size'] }} <br>
                                        Couleur : {{ $product['product_color'] }}
                                    </td>
    								<td class="text-center">{{ $product['product_price'] }} Fcfa</td>
    								<td class="text-center">{{ $product['product_qty'] }}</td>
    								<td class="text-right">{{ $product['product_price']*$product['product_qty'] }} Fcfa</td>
    							</tr>
                                @php $subtotal = $subtotal + ($product['product_price']*$product['product_qty']) @endphp
                                @endforeach
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Total</strong></td>
    								<td class="thick-line text-right">{{ $subtotal }} Fcfa</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">$15</td>
    							</tr>
                                @if(!empty($orderDetails['coupon_amount']))
                                <tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Réduction</strong></td>
    								<td class="no-line text-right">{{ $orderDetails['coupon_amount'] }} Fcfa</td>
    							</tr>
                                @endif
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total</strong></td>
    								<td class="no-line text-right">{{ $orderDetails['grand_total'] }} Fcfa</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
