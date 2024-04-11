<?php
class StockManager {
    private $stockFile;

    public function __construct($stockFile) {
        $this->stockFile = $stockFile;
    }

    public function getStock() {
        $stockJson = file_get_contents($this->stockFile);
        return json_decode($stockJson, true);
    }

    public function updateStock($itemName, $newQuantity) {
        $stock = $this->getStock();

        foreach ($stock['materiels'] as &$item) {
            if ($item['nom'] === $itemName) {
                $item['quantite'] = $newQuantity;
                break;
            }
        }

        file_put_contents($this->stockFile, json_encode($stock, JSON_PRETTY_PRINT));
    }

    public function ajouterMateriel($nom, $quantite) {
        $stock = $this->getStock();
        $stock['materiels'][] = array('nom' => $nom, 'quantite' => $quantite);
        file_put_contents($this->stockFile, json_encode($stock, JSON_PRETTY_PRINT));
    }

    public function supprimerMateriel($nom) {
        $stock = $this->getStock();

        foreach ($stock['materiels'] as $key => $item) {
            if ($item['nom'] === $nom) {
                unset($stock['materiels'][$key]);
                break;
            }
        }

        file_put_contents($this->stockFile, json_encode($stock, JSON_PRETTY_PRINT));
    }

    public function modifierNomMateriel($ancienNom, $nouveauNom) {
        $stock = $this->getStock();

        foreach ($stock['materiels'] as &$item) {
            if ($item['nom'] === $ancienNom) {
                $item['nom'] = $nouveauNom;
                break;
            }
        }

        file_put_contents($this->stockFile, json_encode($stock, JSON_PRETTY_PRINT));
    }
}
?>
