<?php use App\Models\Product; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produit</th>
            <th colspan="2">Description</th>
            <th>Quantité/Mettre à jour</th>
            <th>Prix</th>
            <th>Remise</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_price = 0; ?>
        @foreach ($userCartItems as $item)
            <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']);?>
            <tr>
                <td>
                    <img width="60" src="{{ asset($item['product']['main_image']) }}" alt=""/>
                </td>
                <td colspan="2">{{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>Couleur : {{ $item['product']['product_color'] }} <br> Taille: {{ $item['size'] }}</td>
                <td>
                    <div class="input-append">
                        <input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}" id="appendedInputButtons" size="16" type="text">
                        <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $item['id'] }}"><i class="icon-minus"></i></button>
                        <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{ $item['id'] }}"><i class="icon-plus"></i></button>
                        <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
                    </div>
                </td>
                <td>{{ $attrPrice['product_price'] }} Fcfa</td>
                <td>{{ $attrPrice['discount'] }} Fcfa</td>
                @if($attrPrice['discount']>0)
                    <td>{{ $attrPrice['final_price'] * $item['quantity'] }} Fcfa</td>
                @else
                    <td>{{ $attrPrice['product_price']  * $item['quantity']}} Fcfa</td>
                @endif
            </tr>
                <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']) ?>
        @endforeach

            <tr>
                <td colspan="6" style="text-align:right">Prix total:	</td>
                <td>{{ $total_price }} Fcfa</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:right">Appliquer le coupon:	</td>
                <td> Rs.0.00</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:right"><strong>TOTAL ({{ $total_price }} Fcfa - Rs.0) =</strong></td>
                <td class="label label-important" style="display:block"> <strong> {{ $total_price }} Fcfa</strong></td>
            </tr>
    </tbody>
</table>
