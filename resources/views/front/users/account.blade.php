@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Mon compte</li>
    </ul>
	<h3>Mon compte</h3>
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
            Entrez vos informations de contact <br><br>
			<form id="accountForm" action="{{ url('/account') }}" method="post">
                @csrf
			    <div class="control-group">
				    <label class="control-label" for="name">Nom complet</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="name" name="name" value="{{ $userDetails['name'] }}">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="address">Adresse</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="address" name="address" value="{{ $userDetails['address'] }}">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="city">Ville</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="city" name="city" value="{{ $userDetails['city'] }}">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="state">Région</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="state" name="state" value="{{ $userDetails['state'] }}">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="country">Pays</label>
				    <div class="controls">
                         <select name="country" id="country" class="span3">
                             <option value="">Sélectionner</option>
                             @foreach ($countries as $country)
                                 <option value="{{ $country['country_name'] }}" @if($country['country_name']==$userDetails['country']) selected @endif>{{ $country['country_name'] }}</option>
                             @endforeach
                         </select>
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="pincode">Numéro postal</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="pincode" name="pincode" value="{{ $userDetails['pincode'] }}">
				    </div>
			    </div>
				<div class="control-group">
				    <label class="control-label" for="mobile">Numéro de téléphone</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="mobile" name="mobile" value="{{ $userDetails['mobile'] }}">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="email">Adresse e-mail</label>
				    <div class="controls">
				         <input class="span3" type="email" value="{{ $userDetails['email'] }}" readonly>
				    </div>
			    </div><br>
			    <div class="controls">
			        <button type="submit" class="btn block">Mettre a jour</button>
			    </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>Mettre a jour le mot de passe</h5>
			<form id="passwordForm" method="post" action="{{ url('/update-password') }}">
				@csrf
                <div class="control-group">
				    <label class="control-label" for="password">Mot de passe actuel</label>
				    <div class="controls">
				         <input class="span3"  type="password" id="password" name="password" placeholder="Mot de passe">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="password">Nouveau mot de passe</label>
				    <div class="controls">
				         <input class="span3"  type="password" id="password" name="password" placeholder="Mot de passe">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="password">Confirmer le mot de passe </label>
				    <div class="controls">
				         <input class="span3"  type="password" id="password" name="password" placeholder="Mot de passe">
				    </div>
			    </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Mettre a jour</button>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>

</div>
</div></div>
</div>


@endsection
