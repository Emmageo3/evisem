@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
        <li><a href="{{ url('/'.$productDetails['category']['url']) }}">{{ $productDetails['category']['category_name'] }}</a> <span class="divider">/</span></li>
        <li class="active">{{ $productDetails['product_name'] }}</li>
    </ul>
    <div class="row">
        <div id="gallery" class="span3">
            <a href="{{ $productDetails['main_image'] }}" title="{{ $productDetails['product_name'] }}">
                <img src="{{ $productDetails['main_image'] }}" style="width:100%" alt="{{ $productDetails['product_name'] }}"/>
            </a>
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                    <div class="item active">
                        @foreach ($productDetails['images'] as $image)
                        <a href="{{ $image['image'] }}"> <img style="width:29%" src="{{ $image['image'] }}" alt=""/></a>
                        @endforeach
                    </div>
                </div>
                <!--
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                -->
            </div>

            <div class="btn-toolbar">
                <div class="btn-group">
                    <span class="btn"><i class="icon-envelope"></i></span>
                    <span class="btn" ><i class="icon-print"></i></span>
                    <span class="btn" ><i class="icon-zoom-in"></i></span>
                    <span class="btn" ><i class="icon-star"></i></span>
                    <span class="btn" ><i class=" icon-thumbs-up"></i></span>
                    <span class="btn" ><i class="icon-thumbs-down"></i></span>
                </div>
            </div>
        </div>
        <div class="span6">
            @if(Session::has('error_message'))
            <div style="color: red" role="alert" style="margin-top: 10px">
                Désolé, nous ne disposons pas de la quantité que vous avez demandé
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            @if(Session::has('success_message'))
                <div style="color: green" role="alert" style="margin-top: 10px">
                    Le produit a bien été inséré au panier
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('error_message2'))
                <div style="color: red" role="alert" style="margin-top: 10px">
                    Ce produit a déja été ajouté au panier
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('error_message3'))
                <div style="color: red" role="alert" style="margin-top: 10px">
                    Veuillez sélectionner la taille
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <h3>{{ $productDetails['product_name'] }}</h3>
            <hr class="soft"/>
            <small>{{ $total_stock }} produits en stock</small>
            <form action="{{ url('add-to-cart') }}" method="post" class="form-horizontal qtyFrm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                <div class="control-group">
                    <h4 class="getAttrPrice"> {{ $productDetails['product_price'] }} Fcfa</h4>
                    @if(!empty($productDetails['attributes']))
                        <select name="size" id="getPrice" product-id="{{ $productDetails['id'] }}" class="span2 pull-left" required>
                            <option value="">Sélectionner la taille</option>
                            @foreach ($productDetails['attributes'] as $attribute)
                            <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                            @endforeach
                        </select>
                    @endif
                        <input type="number" name="quantity" class="span1" placeholder="Qty." required/>
                        <button type="submit" class="btn btn-large btn-primary pull-right">Ajouter au panier<i class=" icon-shopping-cart"></i></button>
                    </div>
                </div>
            </form>

            <hr class="soft clr"/>
            <p class="span6">
                {{ $productDetails['description'] }}
            </p>
            <a class="btn btn-small pull-right" href="#detail">En savoir plus</a>
            <br class="clr"/>
            <a href="#" name="detail"></a>
            <hr class="soft"/>
        </div>

        <div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Détails</a></li>
                <li><a href="#profile" data-toggle="tab">Produits similaires</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="home">
                    <h4>Product Information</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="techSpecRow"><th colspan="2">Plus d'informations</th></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Code:</td><td class="techSpecTD2">{{ $productDetails['product_code'] }}</td></tr>
                            <tr class="techSpecRow"><td class="techSpecTD1">Couleur:</td><td class="techSpecTD2">{{ $productDetails['product_color'] }}</td></tr>
                            @if (!empty($productDetails['fabric']))
                            <tr class="techSpecRow"><td class="techSpecTD1">Matiere/Tissu:</td><td class="techSpecTD2">{{ $productDetails['fabric'] }}</td></tr>
                            @endif
                            @if(!empty($productDetails['pattern']))
                            <tr class="techSpecRow"><td class="techSpecTD1">Motif:</td><td class="techSpecTD2">{{ $productDetails['pattern'] }}</td></tr>
                            @endif
                        </tbody>
                    </table>


                </div>
                <div class="tab-pane fade" id="profile">
                    <br class="clr"/>
                    <hr class="soft"/>
                    <div class="tab-content">
                        <div class="tab-pane active" id="blockView">
                            <ul class="thumbnails">
                                @foreach ($relatedProducts as $product)
                                <li class="span3">
                                    <div class="thumbnail">
                                        <a href="{{ url('/product/'.$product['id']) }}"><img src="{{ asset($product['main_image']) }}" alt=""/></a>
                                        <div class="caption">
                                            <h5>{{ $product['product_name'] }}</h5>
                                            <h4 style="text-align:center"><a class="btn" href="{{ url('/product/'.$product['id']) }}"   > <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Ajouter au panier<i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{ $product['product_price'] }} Fcfa</a></h4>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <hr class="soft"/>
                        </div>
                    </div>
                    <br class="clr">
                </div>
            </div>
        </div>
    </div>
</div>
</div> </div>
</div>

@endsection
