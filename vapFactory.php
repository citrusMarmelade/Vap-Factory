<?php
// Souvent on identifie cet objet par la variable $conn ou $db
$mysqlConnection = new PDO(
    'mysql:host=localhost;dbname=vap_factory;charset=utf8',
    'admin',
    'adminpwd'
);
// récupere tous les produits
function getproducts() {
    global $mysqlConnection;
    $requete = 'SELECT * FROM  produits';
    $rows = $mysqlConnection->query($requete);
    return $rows;

}



//met à jour le produit 
function updateProduct($products) {
    try {
        global $mysqlConnection;
        $nom=$products["nom"];
        $requete = "UPDATE product set 
         $nom = $products[nom]";
        $stmt = $products->query($requete);
    }
    catch(PDOException $product) {
        echo $stmt;
    };
};

// ajouter un nouveau produit 

$sqlQuery ="INSERT INTO `produits` (`référence`, `nom`, `description`, `prix_d'achat`, `prix_de_vente`, `quantité_en_stock`) 
VALUES (:reference, :nom, :description, :prix_d_achat, :prix_de_vente, :quantite_en_stock)";

// Préparation
$insertProduct = $mysqlConnection->prepare($sqlQuery);


if (!empty($_POST)){

    $receptionReference= $_POST["réference"];
    $receptionNom = $_POST["nom"];
    $receptionDescription = $_POST["description"];
    $receptionPrix_de_vente = $_POST["prix_de_vente"];
    $receptionPrixdachat= $_POST["prix_d_achat"];
    $receptionQuantitéenstock =$_POST["quantité_en_stock"];
    
    // Exécution ! le produit est maintenant en base de données
    $insertProduct->execute([
        'reference' => $receptionReference,
        'nom' => $receptionNom,
        'description' => $receptionDescription,
        "prix_d_achat" => $receptionPrixdachat,
        "prix_de_vente" => $receptionPrix_de_vente,
        "quantite_en_stock" => $receptionQuantitéenstock
        
    ]);
};
    //recupere les donner 
    $result = getproducts();
    $result->execute();
    $products = $result->fetchAll(PDO::FETCH_ASSOC);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>vap factory</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <table class="table">
        <thead>
            <tr>
                <th>reférence</th>
                <th>nom</th>
                <th>description</th>
                <th>prix de vente</th>
                <th>quantité</th>
                
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <th scope="row"><?= $product["référence"]?></th>
                    <td><?= $product["nom"]?></td>
                    <td><?= $product["description"] ?></td>
                    <td><?= $product["prix_de_vente"] ?></td>
                    <td><?= $product["quantité_en_stock"] ?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <table>
        <form action="vapFactory.php" method="post">
            <p>réference : <input type="text" required name="réference" /></p>
            <p>nom : <input type="text" required name="nom" /></p>
            <p>description : <input type="text"  required name="description" /></p>
            <p>prix d'achat : <input type="number" step=".01" min="0" required name="prix_d_achat" /></p>
            <p>prix de vente: <input type="number" step=".01" min="0,01" required name="prix de vente" /></p>
            <p>quantité en stock: <input type="number" min="0" required name="quantité_en_stock" /></p>
            <p><input type="submit" value="OK"></p>
        </form>
    </table>           
    
</body>
</html>

