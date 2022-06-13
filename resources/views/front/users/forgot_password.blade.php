@extends('layouts.front_layout.front_layout')
@section('content')


<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
		<li class="active">Mot de passe oublié</li>
    </ul>
	<h3>Mot de passe oublié</h3>
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
			<h5>Mot de passe oublié ?</h5><br/>
            Entrez votre e-mail pour changer de mot de passe
			<form id="forgotPasswordForm" action="{{ url('/forgot-password') }}" method="post">
                @csrf
                <div class="control-group">
				    <label class="control-label" for="email">Adresse e-mail</label>
				    <div class="controls">
				         <input class="span3"  type="text" id="email" name="email" placeholder="Email" required>
				    </div>
			    </div>
			    <div class="controls">
			        <button type="submit" class="btn block">Envoyer</button>
			    </div>
			</form>
		</div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
			<h5>Déja inscrit ?</h5>
			<form id="loginForm" method="post" action="{{ url('/login') }}">
				@csrf
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
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">Connexion</button> <a href="{{ url('forgot-password') }}">Mot de passe oublié?</a>
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
