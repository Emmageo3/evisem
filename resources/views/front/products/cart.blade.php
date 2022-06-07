<?php use App\Models\Cart; ?>

@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Panier</li>
    </ul>
	<h3>  Panier [ <small>{{ count($userCartItems) }} produits </small>]<a href="{{ url('/') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continuer mon shopping </a></h3>
	<hr class="soft"/>
	<table class="table table-bordered">
		<tr><th> Je me connecte  </th></tr>
		 <tr>
		 <td>
			<form class="form-horizontal">
				<div class="control-group">
				  <label class="control-label" for="inputUsername">Nom d'utilisateur</label>
				  <div class="controls">
					<input type="text" id="inputUsername" placeholder="Username">
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label" for="inputPassword1">Mot de passe</label>
				  <div class="controls">
					<input type="password" id="inputPassword1" placeholder="Password">
				  </div>
				</div>
				<div class="control-group">
				  <div class="controls">
					<button type="submit" class="btn">Se connecter</button> OU <a href="register.html" class="btn">S'inscrire</a>
				  </div>
				</div>
				<div class="control-group">
					<div class="controls">
					  <a href="forgetpass.html" style="text-decoration:underline">Mot de passe oublié ?</a>
					</div>
				</div>
			</form>
		  </td>
		  </tr>
	</table>

	<table class="table table-bordered">
              <thead>
                <tr>
                  <th>Produit</th>
                  <th colspan="2">Description</th>
                  <th>Quantité/Mettre à jour</th>
				  <th>Prix</th>
                  <th>Remise</th>
                  <th>Total</th>
				</tr>
              </thead>
              <tbody>
                  <?php $total_price = 0; ?>
                  @foreach ($userCartItems as $item)
                  <?php $attrPrice = Cart::getProductAttrPrice($item['product_id'],$item['size']); ?>
                  <tr>
                    <td> <img width="60" src="{{ asset($item['product']['main_image']) }}" alt=""/></td>
                    <td colspan="2">{{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>Couleur : {{ $item['product']['product_color'] }} <br> Taille: {{ $item['size'] }}</td>
                    <td>
                      <div class="input-append">
                          <input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}" id="appendedInputButtons" size="16" type="text">
                          <button class="btn" type="button">
                              <i class="icon-minus"></i>
                            </button>
                            <button class="btn" type="button"><i class="icon-plus"></i></button>
                            <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
                        </div>
                    </td>
                    <td>{{ $attrPrice }} Fcfa</td>
                    <td>{{ $item['product']['product_discount'] }} %</td>
                    <td>{{ $attrPrice * $item['quantity'] }} Fcfa</td>
                  </tr>
                  <?php $total_price = $total_price + ($attrPrice * $item['quantity']) ?>
                  @endforeach

                <tr>
                  <td colspan="6" style="text-align:right">Prix total:	</td>
                  <td>{{ $total_price }} Fcfa</td>
                </tr>
				 <tr>
                  <td colspan="6" style="text-align:right">Remise totale:	</td>
                  <td> Rs.0.00</td>
                </tr>
				 <tr>
                  <td colspan="6" style="text-align:right"><strong>TOTAL ({{ $total_price }} Fcfa - Rs.0) =</strong></td>
                  <td class="label label-important" style="display:block"> <strong> {{ $total_price }} Fcfa</strong></td>
                </tr>
				</tbody>
            </table>


            <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td>
				<form class="form-horizontal">
				<div class="control-group">
				<label class="control-label"><strong> Code promo: </strong> </label>
				<div class="controls">
				<input type="text" class="input-medium" placeholder="CODE">
				<button type="submit" class="btn"> Ajouter </button>
				</div>
				</div>
				</form>
				</td>
                </tr>

			</tbody>
			</table>

			<!-- <table class="table table-bordered">
			 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
			 <tr>
			 <td>
				<form class="form-horizontal">
				  <div class="control-group">
					<label class="control-label" for="inputCountry">Country </label>
					<div class="controls">
					  <input type="text" id="inputCountry" placeholder="Country">
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
					<div class="controls">
					  <input type="text" id="inputPost" placeholder="Postcode">
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn">ESTIMATE </button>
					</div>
				  </div>
				</form>
			  </td>
			  </tr>
            </table> -->
	<a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> Continuer mon shopping </a>
	<a href="login.html" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

</div>
</div></div>
</div>


@endsection
