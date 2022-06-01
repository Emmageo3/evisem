<?php

use App\Models\Section;

$sections = Section::sections();

?>

<div id="sidebar" class="span3">
    <div class="well well-small"><a id="myCart" href="product_summary.html"><img src="{{ asset('images/front_images/ico-cart.png') }}" alt="cart">3 produits</a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        @foreach ($sections as $section)
        @if(count($section['categories'])>0)
        <li class="subMenu"><a>{{ $section['name'] }}</a>
            <ul>
                @foreach ($section['categories'] as $category)
                    <li><a href="{{ $category['url'] }}"><i class="icon-chevron-right"></i><strong>{{ $category['category_name'] }}</strong></a></li>
                    @foreach ($category['subcategories'] as $subcategory)
                        <li><a href="{{ $subcategory['url'] }}">&nbsp;{{ $subcategory['category_name'] }}</a></li>
                    @endforeach
                @endforeach
            </ul>
        </li>
        @endif
        @endforeach
    </ul>
    <br>
    @if (isset($page_name) && $page_name=="listing")
        <div class="well well-small">
            <h5>Tissu/Matière</h5>
            @foreach ($fabricArray as $fabric)
                <input style="margin-top: -3px" type="checkbox" name="fabric[]" id="{{ $fabric }}" value="{{ $fabric }}"> &nbsp;&nbsp;{{ $fabric }}<br>
            @endforeach
        </div>
        <div class="well well-small">
            <h5>Taille des manches</h5>
            @foreach ($sleeveArray as $sleeve)
                <input style="margin-top: -3px" type="checkbox" name="sleeve[]" id="{{ $sleeve }}" value="{{ $sleeve }}"> &nbsp;&nbsp;{{ $sleeve }}<br>
            @endforeach
        </div>
        <div class="well well-small">
            <h5>Style</h5>
            @foreach ($fitArray as $fit)
                <input style="margin-top: -3px" type="checkbox" name="fit[]" id="{{ $fit }}" value="{{ $fit }}"> &nbsp;&nbsp;{{ $fit }}<br>
            @endforeach
        </div>
        <div class="well well-small">
            <h5>Longueur</h5>
            @foreach ($heightArray as $height)
                <input style="margin-top: -3px" type="checkbox" name="height[]" id="{{ $height }}" value="{{ $height }}"> &nbsp;&nbsp;{{ $height }}<br>
            @endforeach
        </div>
        <div class="well well-small">
            <h5>Motif</h5>
            @foreach ($patternArray as $pattern)
                <input style="margin-top: -3px" type="checkbox" name="pattern[]" id="{{ $pattern }}" value="{{ $pattern }}"> &nbsp;&nbsp;{{ $pattern }}<br>
            @endforeach
        </div>
    @endif
    <br/>
    <div class="thumbnail">
        <img src="{{ asset('images/front_images/payment_methods.png') }}" title="Payment Methods" alt="Payments Methods">
        <div class="caption">
            <h5>Méthodes de paiment</h5>
        </div>
    </div>
</div>
