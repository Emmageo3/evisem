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
        <p>Votre numéro de commande est {{ Session::get('order_id') }}.</p>
        <p>Le total est {{ Session::get('grand_total') }} Fcfa</p>
    </div>

</div>
</div></div>
</div>


@endsection

<?php
    Session::forget('grand_total');
    Session::forget('order_id');
?>
