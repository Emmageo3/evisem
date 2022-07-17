@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Evisem vous remercie !</li>
    </ul>
	<h3>  Evisem vous remercie </h3>
	<hr class="soft"/>

    <div align="center">
        <h3>Votre commande a bien été enregistrée</h3>
        <p>Votre numéro de commande est {{ Session::get('order_id') }}. et le montant à payer est : {{ Session::get('grand_total') }}</p>
        <p>Veuillez effectuer le paiement en cliquant sur le lien suivant.</p>
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="business" value="seller@designerfotos.com">
            <input type="hidden" name="item_name" value="hat">
            <input type="hidden" name="item_number" value="123">
            <input type="hidden" name="amount" value="15.00">
            <input type="hidden" name="first_name" value="John">
            <input type="hidden" name="last_name" value="Doe">
            <input type="hidden" name="address1" value="9 Elm Street">
            <input type="hidden" name="address2" value="Apt 5">
            <input type="hidden" name="city" value="Berwyn">
            <input type="hidden" name="state" value="PA">
            <input type="hidden" name="zip" value="19312">
            <input type="hidden" name="email" value="jdoe@zyzzyu.com">
            <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
        </form>
    </div>

</div>
</div></div>
</div>


@endsection

<?php
    Session::forget('grand_total');
    Session::forget('order_id');
?>
