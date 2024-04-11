<!DOCTYPE html>
<html>
<head>
    <title>Gestion de Stock</title>
    <!-- Ajout de Bootstrap CSS pour la mise en forme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .small-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
    <script>
        // Fonction pour actualiser la page
        function actualiserPage() {
            window.location.reload();
        }

        // Fonction pour supprimer un matériel
        function supprimerMateriel(nom) {
            var confirmation = confirm("Êtes-vous sûr de vouloir supprimer le matériel '" + nom + "' ?");
            if (confirmation) {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "gestion_stock.php");
                form.innerHTML = "<input type='hidden' name='action' value='supprimer'>" +
                                 "<input type='hidden' name='nom' value='" + nom + "'>";
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Fonction pour afficher le formulaire de modification du nom d'un matériel
        function afficherFormulaireModification(nom) {
            var nouveauNom = prompt("Entrez le nouveau nom pour '" + nom + "':");
            if (nouveauNom != null && nouveauNom !== "") {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "gestion_stock.php");
                form.innerHTML = "<input type='hidden' name='action' value='modifier'>" +
                                 "<input type='hidden' name='nom' value='" + nom + "'>" +
                                 "<input type='hidden' name='nouveau_nom' value='" + nouveauNom + "'>";
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Fonction pour afficher le formulaire de modification de la quantité d'un matériel
        function afficherFormulaireQuantite(nom) {
            var nouvelleQuantite = prompt("Entrez la nouvelle quantité pour '" + nom + "':");
            if (nouvelleQuantite != null && !isNaN(nouvelleQuantite) && nouvelleQuantite !== "") {
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "gestion_stock.php");
                form.innerHTML = "<input type='hidden' name='action' value='modifier_quantite'>" +
                                 "<input type='hidden' name='nom' value='" + nom + "'>" +
                                 "<input type='hidden' name='nouvelle_quantite' value='" + nouvelleQuantite + "'>";
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Fonction pour augmenter ou diminuer la quantité d'un matériel
        function modifierQuantite(nom, modification) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "gestion_stock.php");
            form.innerHTML = "<input type='hidden' name='action' value='modifier_quantite'>" +
                             "<input type='hidden' name='nom' value='" + nom + "'>" +
                             "<input type='hidden' name='modification' value='" + modification + "'>";
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Gestion de Stock</h1>
        <button class="btn btn-primary mb-3" onclick="actualiserPage()">Actualiser</button>

        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Stock Disponible</h2>
                <?php
                require_once 'StockManager.php';

                $stockManager = new StockManager('stock.json');
                $stock = $stockManager->getStock();

                foreach ($stock['materiels'] as $materiel) {
                    echo "<div class='d-flex justify-content-between mb-2'>";
                    echo "<p class='m-0'>" . $materiel['nom'] . ": " . $materiel['quantite'] . "</p>";
                    echo "<div>";
                    echo "<button class='btn btn-info btn-sm mr-2' onclick='afficherFormulaireModification(\"" . $materiel['nom'] . "\")'>Modifier Nom</button>";
                    echo "<button class='btn btn-secondary btn-sm mr-2' onclick='afficherFormulaireQuantite(\"" . $materiel['nom'] . "\")'>Modifier Quantité</button>";
                    echo "<button class='btn btn-success btn-sm mr-2' onclick='modifierQuantite(\"" . $materiel['nom'] . "\", -1)'>-1</button>";
                    echo "<button class='btn btn-success btn-sm mr-5' onclick='modifierQuantite(\"" . $materiel['nom'] . "\", 1)'>+1</button>";
                    echo "<button class='btn btn-danger btn-sm ml-auto m-2' onclick='supprimerMateriel(\"" . $materiel['nom'] . "\")'>Supprimer</button>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <h2 class="mt-4">Ajouter un Matériel</h2>
        <form class="mt-3" method="post" action="gestion_stock.php">
            <input type="hidden" name="action" value="ajouter">
            <div class="form-group">
                <label for="nom_nouveau">Nom du Matériel:</label>
                <input type="text" class="form-control" id="nom_nouveau" name="nom_nouveau" required>
            </div>
            <div class="form-group">
                <label for="quantite_nouveau">Quantité:</label>
                <input type="number" class="form-control" id="quantite_nouveau" name="quantite_nouveau" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter</button>
        </form>
    </div>

    <!-- Ajout de Bootstrap JS pour les fonctionnalités JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
