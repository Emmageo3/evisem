@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Connexion/Inscription</li>
    </ul>
	<h3> Se connecter / S'inscrire</h3>
	<hr class="soft"/>

	<div class="row">
		<div class="span4">
            @if(Session::has('error_message'))
                <div class="alert alert-danger" role="alert" style="margin-top: 10px">
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
			<div class="well">
			<h5>Créer un compte</h5><br/>
			<form action="{{ url('/register') }}" method="post">
                @csrf
			    <div class="control-group">
				    <label class="control-label" for="name">Nom complet</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="name" name="name" placeholder="Nom">
				    </div>
			    </div>
				<div class="control-group">
				    <label class="control-label" for="mobile">Numéro de téléphone</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="mobile" name="mobile" placeholder="Numéro de téléphone">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="email">Adresse e-mail</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="email" name="email" placeholder="Email">
				    </div>
			    </div>
                <div class="control-group">
				    <label class="control-label" for="password">Mot de passe</label>
				    <div class="controls">
				         <input class="span3"  type="password" id="password" name="password" placeholder="Mot de passe">
				    </div>
			    </div>
			    <div class="controls">
			        <button type="submit" class="btn block">Créer un compte</button>
			    </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>Déja inscrit ?</h5>
			<form>
			  <div class="control-group">
				<label class="control-label" for="inputEmail1">Email</label>
				<div class="controls">
				  <input class="span3"  type="text" id="inputEmail1" placeholder="Email">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="inputPassword1">Mot de passe</label>
				<div class="controls">
				  <input type="password" class="span3"  id="inputPassword1" placeholder="Password">
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Connexion</button> <a href="forgetpass.html">Mot de passe oublié?</a>
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
