<?php
require_once 'StockManager.php';

$stockManager = new StockManager('stock.json');

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'ajouter':
            if (isset($_POST['nom_nouveau'], $_POST['quantite_nouveau'])) {
                $stockManager->ajouterMateriel($_POST['nom_nouveau'], $_POST['quantite_nouveau']);
            }
            break;
        
        case 'supprimer':
            if (isset($_POST['nom'])) {
                $stockManager->supprimerMateriel($_POST['nom']);
            }
            break;
        
        case 'modifier':
            if (isset($_POST['nom'], $_POST['nouveau_nom'])) {
                $stockManager->modifierNomMateriel($_POST['nom'], $_POST['nouveau_nom']);
            }
            break;
        
        case 'modifier_quantite':
            if (isset($_POST['nom'], $_POST['nouvelle_quantite'])) {
                $stockManager->updateStock($_POST['nom'], $_POST['nouvelle_quantite']);
            } elseif (isset($_POST['nom'], $_POST['modification'])) {
                $stock = $stockManager->getStock();
                $modification = (int)$_POST['modification'];
                foreach ($stock['materiels'] as $key => $item) {
                    if ($item['nom'] === $_POST['nom']) {
                        $stock['materiels'][$key]['quantite'] += $modification;
                        break;
                    }
                }
                file_put_contents('stock.json', json_encode($stock, JSON_PRETTY_PRINT));
            }
            break;
        
        default:
            // Action non reconnue
            break;
    }
}

// Redirection vers la page principale après l'action
header('Location: index.php');
?>
