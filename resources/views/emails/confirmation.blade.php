<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
</head>
<body>
    <table>
        <tr>
            <td>Cher(e) {{ $name }}</td>
        </tr>
        <tr>
            <td>Veuillez cliquer sur le lien suivant pour activer votre compte </td>
        </tr>
        <tr>
            <td><a href="{{ url('confirm/'.$code) }}">Confirmer le compte</a></td>
        </tr>
        <tr>
            <td>Merci</td>
        </tr>
        <tr>
            <td>Evisem</td>
        </tr>
    </table>
</body>
</html>
