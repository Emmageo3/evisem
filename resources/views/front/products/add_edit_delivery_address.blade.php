@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Adresse de livraison</li>
    </ul>
	<h3>{{ $title }}</h3>
	<hr class="soft"/>
    @if(Session::has('error_message'))
    <div class="alert alert-danger" role="alert" style="margin-top: 10px">
        {{ Session::get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(Session::has('success_message'))
    <div class="alert alert-success" role="alert" style="margin-top: 10px">
        {{ Session::get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
	<div class="row">
		<div class="span4">
			<div class="well">
			<h5>Informations</h5><br/>
            Entrez les détails de votre adresse <br><br>
			<form id="deliveryAddressForm" @if(empty($address['id'])) action="{{ url('add-edit-delivery-address') }}" @else action="{{ url('add-edit-delivery-address/'.$address['id']) }}" @endif  method="post">
                @csrf
			    <div class="control-group">
				    <label class="control-label" for="name">Nom complet</label>
				    <div class="controls">
				         <input class="span3" value="{{ $address['name'] }}"  type="text" id="name" name="name">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="address">Adresse</label>
				    <div class="controls">
				         <input class="span3" value="{{ $address['address'] }}"  type="text" id="address" name="address">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="city">Ville</label>
				    <div class="controls">
				         <input class="span3" value="{{ $address['city'] }}"  type="text" id="city" name="city">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="state">Région</label>
				    <div class="controls">
				         <input class="span3" value="{{ $address['state'] }}"  type="text" id="state" name="state">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="country">Pays</label>
				    <div class="controls">
                         <select name="country" id="country" class="span3">
                             <option value="">Sélectionner</option>
                             @foreach ($countries as $country)
                                 <option value="{{ $country['country_name'] }}"
                                 @if($country['country_name']==$address['country']) selected  @endif>{{ $country['country_name'] }}</option>
                             @endforeach
                         </select>
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="pincode">Numéro postal</label>
				    <div class="controls">
				         <input class="span3" value="{{ $address['pincode'] }}"  type="text" id="pincode" name="pincode">
				    </div>
			    </div>
				<div class="control-group">
				    <label class="control-label" for="mobile">Numéro de téléphone</label>
				    <div class="controls">
				         <input class="span3" value="{{ $address['mobile'] }}"  type="text" id="mobile" name="mobile">
				    </div>
			    </div>
			    <div class="controls">
			        <button type="submit" class="btn block">Soumettre</button>
                    <a style="float: right" class="btn block" href="{{ url('checkout') }}">Retour</a>
			    </div>
			</form>
		</div>
		</div>
	</div>

</div>
</div></div>
</div>


@endsection
