@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <div class="well well-small">
        <h4>Les tendances<small class="pull-right">+200 produits en tendance</small></h4>
        <div class="row-fluid">
            <div id="featured" class="carousel slide">
                <div class="carousel-inner">
                    @foreach ($featuredItemsChunk as $key => $featuredItem)
                    <div class="item @if($key == 1) active @endif">
                        <ul class="thumbnails">
                            @foreach ($featuredItem as $item)
                            <li class="span3">
                                <div class="thumbnail">
                                    <i class="tag"></i>
                                    <a href="product_details.html"><img src="{{ $item['main_image'] }}" alt=""></a>
                                    <div class="caption">
                                        <h5>{{ $item['product_name'] }}</h5>
                                        <h4><a class="btn" href="product_details.html">Voir</a> <span class="pull-right">{{ $item['product_price'] }} Fcfa</span></h4>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a>
            </div>
        </div>
    </div>
    <h4>Les nouveautés </h4>
    <ul class="thumbnails">
        @foreach ($newProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a  href="product_details.html"><img style="width: 150px" src="{{ $product['main_image'] }}" alt=""/></a>
                <div class="caption">
                    <h5>{{ $product['product_name'] }}</h5>
                    <p>
                        {{ $product['description'] }}
                    </p>

                    <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Ajouter au panier<i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">{{ $product['product_price'] }} Fcfa</a></h4>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

@endsection
