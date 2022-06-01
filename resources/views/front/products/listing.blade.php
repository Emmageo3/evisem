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
        <input type="hidden" name="url" id="url" value="{{ $url }}">
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
    <br class="clr"/>
    <div class="tab-content filter_products">
        @include('front.products.ajax_listing')
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
