<?php
// Souvent on identifie cet objet par la variable $conn ou $db
$mysqlConnection = new PDO(
    'mysql:host=localhost;dbname=vap_factory;charset=utf8',
    'admin',
    'adminpwd',
);
$mysqlConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// récupere tous les produits
function getProducts()
{
    global $mysqlConnection;
    $sql = 'SELECT * FROM `produits`';
    $statement = $mysqlConnection->query($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function createProduct($reference, $nom, $description, $prixAchat, $prixVente, $quantiée)  {
    global $mysqlConnection;

    $sqlQuery = "INSERT INTO `produits` (`référence`, `nom`, `description`, `prix_d'achat`, `prix_de_vente`, `quantité_en_stock`) 
                                 VALUES (?          , ?    , ?            , ?             , ?              , ?) AS new
    ON DUPLICATE KEY UPDATE
        `nom` = new.`nom`,
        `description`= new.`description`, 
        `prix_d'achat` = new.`prix_d'achat`, 
        `quantité_en_stock` = new.`quantité_en_stock`, 
        `prix_de_vente`= new.`prix_de_vente`;";
    // Préparation
    $insertProduct = $mysqlConnection->prepare($sqlQuery);


    // Exécution ! le produit est maintenant en base de données

    $params = [$reference, $nom, $description, $prixAchat, $prixVente, $quantiée];
    $insertProduct->execute($params);
}

//mofifie les stocks
function changeStock($quantiée,$ID){
    global $mysqlConnection;
    $sqlQuery ="UPDATE `produits` SET `quantité_en_stock` = quantité_en_stock+?  WHERE `produits`.`ID` = ?"; 

    $changeStock = $mysqlConnection->prepare($sqlQuery);
    $paramsStock = [$quantiée,$ID];
    $changeStock->execute($paramsStock);
};

function getProduct($ID) {
    global $mysqlConnection;
    $sqlQuery = "SELECT * FROM `produits` WHERE `produits`.`ID` = ?";
    $statement = $mysqlConnection->prepare($sqlQuery);
    $statement->execute([$ID]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}