<?php
$mysqlConnection = new PDO(
    'mysql:host=localhost;dbname=vap_factory;charset=utf8',
    'admin',
    'adminpwd'
);





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
</head>
<body>
<form action="update.php" method="post">
        <table clas="table">
            <tbody>
                <tr>
                    <th><label for="nom">nom :</label></th>
                    <td><input type="text" required name="nom" id="nom" />
                </tr>
                <tr>
                    <th><label for="réference">réference :</label></th>
                    <td><input type="text" required name="réference" id="réference" />
                </tr>
                <tr>
                    <th><label for="description">description :</label></th>
                    <td><input type="text" required name="description" id="description" />
                </tr>
                <tr>
                    <th><label for="prix_d_achat">prix d'achat :</label></th>
                    <td><input type="number" step=".01" min="0" required name="prix_d_achat" id="prix_d_achat" />
                </tr>
                <tr>
                    <th><label for="prix_de_vente">prix de vente:</label></th>
                    <td><input type="number" step=".01" min="0,01" required name="prix_de_vente" id="prix_de_vente" />
                </tr>
                <tr>
                    <th><label for="quantité_en_stock">quantité en stock:</label></th>
                    <td><input type="number" min="0" required name="quantité_en_stock" id="quantité_en_stock" />
                </tr>
            </tbody>
        </table>
        <input type="submit" value="OK">
    </form>
    

</body>
</html>