<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a href="product_details.html"><img style="width: 100%" src="{{ asset($product['main_image']) }}" alt=""/></a>
                <div class="caption">
                    <h5>{{ $product['product_name'] }}</h5>
                    <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a><a class="btn btn-primary" href="#">{{ $product['product_price'] }} Fcfa</a><a class="btn" href="#">Ajouter au panier<i class="icon-shopping-cart"></i></a></h4>
                    <p>
                        {{ $product['fabric'] }}
                    </p>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>

<!--
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
-->
