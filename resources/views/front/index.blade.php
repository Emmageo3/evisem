<?php use App\Models\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9" id="shop">
    <div class="well well-small">
        <h4>Les tendances<small class="pull-right">{{ $featuredItemsCount }} produits en tendance</small></h4>

        <div class="row-fluid">
            <div id="featured" @if($featuredItemsCount>4) class="carousel slide" @endif>
                <div class="carousel-inner">
                    @foreach ($featuredItemsChunk as $key => $featuredItem)

                    <div class="item @if($key == 1) active @endif">
                        <ul class="thumbnails">
                            @foreach ($featuredItem as $item)

                            <li class="span3">
                                <div class="thumbnail">
                                    <i class="tag"></i>
                                    <a href="{{ url('/product/'.$item['id']) }}"><img src="{{ $item['main_image'] }}" alt=""></a>
                                    <div class="caption">
                                        <h5>{{ $item['product_name'] }}</h5>
                                        <?php $discounted_price = Product::getDiscountedPrice($item['id']) ?>
                                        <h4><a style="text-align: center" class="btn" href="{{ url('/product/'.$item['id']) }}">Voir</a> <span class="pull-right" style="font-size: 12px">
                                            @if ($discounted_price>0)
                                                <del>{{ $item['product_price'] }} Fcfa</del>
                                                <font size="1px">{{ $discounted_price }} Fcfa</font>
                                            @else
                                                {{ $item['product_price'] }} Fcfa
                                            @endif

                                        </span></h4>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @endforeach
                    @if($key == 1)
                    <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                    @endif
                </div>

            </div>
        </div>

    </div>
    <h4>Les nouveautés </h4>
    <ul class="thumbnails">
        @foreach ($newProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a  href="{{ url('/product/'.$product['id']) }}"><img style="width: 100%; height: auto" src="{{ $product['main_image'] }}" alt=""/></a>
                <div class="caption">
                    <h5>{{ $product['product_name'] }}</h5>
                    <?php $discounted_price = Product::getDiscountedPrice($product['id']) ?>
                    <h4 style="text-align:center">
                        <a class="btn btn-primary" href="#">
                            @if ($discounted_price>0)
                                                <del>{{ $product['product_price'] }} Fcfa</del>
                                                <font size="1px">{{ $discounted_price }} Fcfa</font>
                                            @else
                                                {{ $product['product_price'] }} Fcfa
                                            @endif
                        </a>
                        <a class="btn" href="#">Ajouter au panier<i class="icon-shopping-cart"></i></a></h4>

                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

@endsection
