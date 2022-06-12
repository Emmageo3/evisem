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
            <td>Bienvenue chez Evisem. Les informations de votre compte sont les suivants : </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Nom: {{ $name }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Numéro de téléphone: {{ $mobile }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Adresse e-mail: {{ $email }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Mot de passe: ********* (comme vous l'avez choisi)</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
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
