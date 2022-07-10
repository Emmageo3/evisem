<!DOCTYPE html>
<body>

    <table style="width: 700px">
        <tr><td>&nbsp;</td></tr>
        <tr><td><img src="#" alt="logo"></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Salut {{ $name }}, </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Votre commande numéro {{ $order_id }} est <strong>{{ $order_status }}</strong> </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table style="width: 95%" cellpadding="5" cellspacing="5" bgcolor="#F7F4F4">
                <tr bgcolor="#ccc">
                    <td>Nom du produit</td>
                    <td>Code</td>
                    <td>Taille</td>
                    <td>Couleur</td>
                    <td>Quantité</td>
                    <td>Prix</td>
                </tr>
                @foreach ($orderDetails['orders_products'] as $order)
                    <tr>
                        <td>{{ $order['product_name'] }}</td>
                        <td>{{ $order['product_code'] }}</td>
                        <td>{{ $order['product_size'] }}</td>
                        <td>{{ $order['product_color'] }}</td>
                        <td>{{ $order['product_qty'] }}</td>
                        <td>{{ $order['product_price'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="right">Frais de livraison</td>
                    <td>{{ $orderDetails['shipping_charges'] }} Fcfa</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Total</td>
                    <td>{{ $orderDetails['grand_total'] }} Fcfa</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table>
                <tr>
                    <td><strong>Adresse de livraison : -</strong></td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['address'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['pincode'] }}</td>
                </tr>
                <tr>
                    <td>{{ $orderDetails['mobile'] }}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Pour toutes réclamations, veuillez nous contacter via <a href="mailto: kanfanyemma22@gmail.com">Evisem</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Merci.</td></tr>
    </table>

</body>
</html>

