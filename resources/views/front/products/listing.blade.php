@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">Accueil</a> <span class="divider">/</span></li>
        <li class="active"><?php echo $categoryDetails['breadcrumbs']; ?></li>
    </ul>
    <h3> {{ $categoryDetails['categoryDetails']['category_name'] }} <small class="pull-right"> {{ count($categoryProducts) }} produits</small></h3>
    <hr class="soft"/>
    <p>
        {{ $categoryDetails['categoryDetails']['description'] }}
    </p>
    <hr class="soft"/>
    <form name="sortProducts" id="sortProducts" class="form-horizontal span6">
        <input type="hidden" name="url" value="{{ $url }}">
        <div class="control-group">
            <label class="control-label alignL">Filtre</label>
            <select name="sort" id="sort">
                <option value="">filtrer</option>
                <option value="product_latest" @if (isset($_GET['sort']) && $_GET['sort'] == "product_latest") selected @endif>Les plus récents</option>
                <option value="product_name_a_z" @if (isset($_GET['sort']) && $_GET['sort'] == "product_name_a_z") selected @endif>Par ordre alphabétique (A à Z)</option>
                <option value="product_name_z_a" @if (isset($_GET['sort']) && $_GET['sort'] == "product_name_z_a") selected @endif>Par ordre alphabétique (Z à A)</option>
                <option value="price_lowest" @if (isset($_GET['sort']) && $_GET['sort'] == "product_lowest") selected @endif>Par le prix le plus bas</option>
                <option value="price_highest" @if (isset($_GET['sort']) && $_GET['sort'] == "product_highest") selected @endif>Par le prix le plus élevé</option>
            </select>
        </div>
    </form>

    <div id="myTab" class="pull-right">
        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
    </div>
    <br class="clr"/>
    <div class="tab-content">
        <div class="tab-pane" id="listView">
            @foreach ($categoryProducts as $product)
            <div class="row">
                <div class="span2">
                    <img src="{{ asset($product['main_image']) }}" alt=""/>
                </div>
                <div class="span4">
                    <h3>Nouveau | Disponible</h3>
                    <hr class="soft"/>
                    <h5>{{ $product['product_name'] }}</h5>
                    <p>
                        {{ $product['description'] }}
                    </p>
                    <a class="btn btn-small pull-right" href="product_details.html">Voir les détails</a>
                    <br class="clr"/>
                </div>
                <div class="span3 alignR">
                    <form class="form-horizontal qtyFrm">
                        <h3>{{ $product['product_price'] }} Fcfa</h3>
                        <label class="checkbox">
                            <input type="checkbox">  Ajouter aux favoris
                        </label><br/>

                        <a href="product_details.html" class="btn btn-large btn-primary">Ajouter au panier<i class=" icon-shopping-cart"></i></a>
                        <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>

                    </form>
                </div>
            </div>
            <hr class="soft"/>
            @endforeach
        </div>
        <div class="tab-pane  active" id="blockView">
            <ul class="thumbnails">
                @foreach ($categoryProducts as $product)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="product_details.html"><img style="width: 150px" src="{{ asset($product['main_image']) }}" alt=""/></a>
                        <div class="caption">
                            <h5>{{ $product['product_name'] }} {{ $product['id'] }}</h5>
                            <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a><a class="btn btn-primary" href="#">{{ $product['product_price'] }} Fcfa</a><a class="btn" href="#">Ajouter au panier<i class="icon-shopping-cart"></i></a></h4>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <hr class="soft"/>
        </div>
    </div>
    <a href="compair.html" class="btn btn-large pull-right">Comparer les produits</a>
    <div class="pagination">
        @if(isset($_GET['sort']) && !empty($_GET['sort']))
        {{ $categoryProducts->appends(['sort' => 'price_lowest'])->links() }}
        @else
        {{ $categoryProducts->links() }}
        @endif
    </div>
    <br class="clr"/>
</div>

@endsection
