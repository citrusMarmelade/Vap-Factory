<?php
require "mysql.php";

if (!empty($_POST)) {
    if ($_POST["action"] == "create") {
        $receptionReference = $_POST["référence"];
        $receptionNom = $_POST["nom"];
        $receptionDescription = $_POST["description"];
        $receptionPrixDeVente = $_POST["prix_de_vente"];
        $receptionPrixDAchat = $_POST["prix_d_achat"];
        $receptionQuantitéenstock = $_POST["quantité_en_stock"];
        createProduct(
            $receptionReference,
            $receptionNom,
            $receptionDescription,
            $receptionPrixDAchat,
            $receptionPrixDeVente,
            $receptionQuantitéenstock
        );
    } else if ($_POST["action"] == "modifyStock") {
        $ID = $_POST["ID"];
        $quantiée = $_POST["transactionSize"];
        $value = $_POST["transactionType"];
        if ($value == "sale") {
            $quantiée = -$quantiée;
        }

        changeStock($quantiée, $ID);
    }
};

$products = getProducts();

function showValue($modifiedProduct, $name, $editable = true)
{
    if ($modifiedProduct != null) {
        $value = $modifiedProduct[$name];
        echo "value=\"$value\"";
        if (!$editable) {
            echo " readonly";
        }
    }
}


$modify_id = $_GET["ID"] ?? null;
$modifiedProduct = $modify_id != null ? getProduct($modify_id) : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title>vap factory</title>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>reférence</th>
                <th>nom</th>
                <th>description</th>
                <th>prix de vente</th>
                <th>quantité</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product) : ?>
                <tr <?php if ($product["quantité_en_stock"]<=0){echo('class ="bg-danger"');}; 
                    ?>>
                    
                    <th scope="row"><?= $product["référence"] ?></th>
                    <td><?= $product["nom"] ?></td>
                    <td><?= $product["description"] ?></td>
                    <td><?= $product["prix_de_vente"] ?></td>
                    <td>
                        <form class="border border-dark border-2 rounded " method="post">
                            <input type="hidden" name="action" value="modifyStock">
                            <input type="hidden" name="ID" value="<?=  $product["ID"] ?>">
                            <div class="input-group">
                                <span class="input-group-text "><?=$product["quantité_en_stock"] ?></span>
                                <button class="p-2 btn btn-success material-symbols-outlined" name="transactionType" value="buy">add</button>
                                <button class="p-2 btn btn-danger material-symbols-outlined" name="transactionType" value="sale">remove</button>
                                <input class="form-control" type="number" name="transactionSize" min="1" value="1">
                            </div>
                        </form>
                    </td>
                    <td><a href="?ID=<?= $product["ID"] ?>" class="p-2 btn btn-warning material-symbols-outlined">edit</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="vapFactory.php" method="post">
        <table clas="table">
            <tbody>
                <tr>
                    <th><label for="nom">nom :</label></th>
                    <td>
                        <input type="text" required name="nom" id="nom" <?= showValue($modifiedProduct, "nom") ?> />
                </tr>
                <tr>
                    <th><label for="référence">référence :</label></th>
                    <td><input type="text" required name="référence" id="référence" <?= showValue($modifiedProduct, "référence", false) ?> />
                </tr>
                <tr>
                    <th><label for="description">description :</label></th>
                    <td><input type="text" required name="description" id="description" <?= showValue($modifiedProduct, "description") ?> />
                </tr>
                <tr>
                    <th><label for="prix_d_achat">prix d'achat :</label></th>
                    <td><input type="number" step=".01" min="0" required name="prix_d_achat" id="prix_d_achat" <?= showValue($modifiedProduct, "prix_d'achat") ?> />
                </tr>
                <tr>
                    <th><label for="prix_de_vente">prix de vente:</label></th>
                    <td><input type="number" step=".01" min="0,01" required name="prix_de_vente" id="prix_de_vente" <?= showValue($modifiedProduct, "prix_de_vente") ?> />
                </tr>
                <tr>
                    <th><label for="quantité_en_stock">quantité en stock:</label></th>
                    <td><input type="number" min="0" required name="quantité_en_stock" id="quantité_en_stock" <?= showValue($modifiedProduct, "quantité_en_stock") ?> />
                </tr>
            </tbody>
        </table>
        <button class="btn btn-success" type="submit" name="action" value="create">Créer</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>