<?php use App\Models\Product; ?>

@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active"> Panier</li>
    </ul>
	<h3>  Panier [ <span class="totalCartItems"> {{ totalCartItems() }}</span>  produits ]
        <a href="{{ url('/') }}" class="btn btn-large pull-right">
            <i class="icon-arrow-left"></i> Continuer mon shopping
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
    @if(Session::has('success_message'))
        <div class="alert alert-success" role="alert" style="margin-top: 10px">
            Ce produit a été ajouté au panier avec succès !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div id="AppendCartItems">
        @include('front.products.cart_items')
    </div>

        <table class="table table-bordered">
			<tbody>
				<tr>
                    <td>
				        <form id="ApplyCoupon" method="post" action="javascript:void(0);" class="form-horizontal" @if(Auth::check()) user="1" @endif>
                            @csrf
				            <div class="control-group">
				                <label class="control-label"><strong> Code promo: </strong> </label>
				                <div class="controls">
				                    <input type="text" name="code" id="code" class="input-medium" placeholder="Entrez le code" required>
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
	<a href="{{ url('/') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continuer mon shopping </a>
	<a href="{{ url('checkout') }}" class="btn btn-large pull-right">Suivant <i class="icon-arrow-right"></i></a>

</div>
</div></div>
</div>


@endsection
