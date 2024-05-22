<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .contenitore-carrello {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .prodotto-carrello {
            border-bottom: 1px solid #ccc;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .prodotto-carrello img {
            max-width: 100px;
            height: auto;
        }

        .prodotto-carrello div {
            flex: 1;
            padding: 0 10px;
        }

        .totale {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }

        .rimuovi-button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .rimuovi-button:hover {
            background-color: #c9302c;
        }

        .bottoni-fondo button {
            background-color: #5bc0de;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .bottoni-fondo button:hover {
            background-color: #31b0d5;
        }
    </style>
</head>

<body>

    <h1>Il tuo carrello</h1>

    <div class="contenitore-carrello">
        <?php
     //GESTIONE LOGOUT      
        session_start(); //inizio sessione
        if (isset($_GET['logout']))  //controlla se è stato riechiesto il logout
        {
            session_destroy(); //distrugge la sessione
            header("Location: carrello.php"); //reiderizza alla pagina del carrello
            exit; 
        }
    // RIMOZIONE PRODOTTI NEL CARRELLO
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rimuovi'])) // Verifica se il metodo di richiesta è POST e se il pulsante 'rimuovi' è stato premuto
        {
            $id_da_rimuovere = filter_input(INPUT_POST, 'id_prodotto', FILTER_SANITIZE_NUMBER_INT); //rimuove l'ID del prodotto da rimuovere
            foreach ($_SESSION['carrello'] as $key => $prodotto) //cicla i prodotti nel carrello
            {
                if ($prodotto['id'] == $id_da_rimuovere) //controlla se l'id corrisponde
                {
                    unset($_SESSION['carrello'][$key]); //rimuove il prodotto del carrello
                    break; //esce dal ciclo
                }
            }

            $_SESSION['carrello'] = array_values($_SESSION['carrello']); //riordina l'array del carrello

            header("Location: carrello.php"); //reinderizza alla pagina del carrello
            exit;
        }
      //VISUALIZZAZIONE E GESTIONE DEL CARRELLO DEGLI ACQUISTI  
        $totalPrice = 0; // Inizializza il prezzo totale a zero

        if (isset($_SESSION['carrello']) && !empty($_SESSION['carrello'])) // Controlla se il carrello non è vuoto 
        {
            foreach ($_SESSION['carrello'] as $product) 
            {
                if (isset($product['quantita'], $product['prezzo']) && is_numeric($product['quantita']) && is_numeric($product['prezzo'])) // Controlla se la quantità e il prezzo sono validi
                {
                    $subtotal = $product['quantita'] * $product['prezzo']; // Calcola il subtotale per il prodotto
                    $totalPrice += $subtotal; // Aggiunge il subtotale al totale

                    echo "<div class='prodotto-carrello'>"; // Inizia il contenitore per un singolo prodotto nel carrello
                    echo "<img src='" . htmlspecialchars($product['immagine']) . "' alt='Immagine prodotto'>";// Mostra l'immagine del prodotto
                    echo "<div>";
                    echo "<h3>" . htmlspecialchars($product['nome']) . "</h3>";// Mostra il nome del prodotto
                    echo "<p>" . htmlspecialchars($product['descrizione']) . "</p>";// Mostra la descrizione del prodotto
                    echo "<p>Prezzo: €" . htmlspecialchars(number_format($product['prezzo'], 2, ',', '.')) . "</p>";// Mostra il prezzo del prodotto
                    echo "<p>Quantità: " . htmlspecialchars($product['quantita']) . "</p>";// Mostra la quantità del prodotto
                    echo "</div>";
                    echo "<div>Totale: €" . htmlspecialchars(number_format($subtotal, 2, ',', '.')) . "</div>";// Mostra il totale per il prodotto
                    echo "<form method='post' action='carrello.php'>"; // Form per rimuovere il prodotto
                    echo "<input type='hidden' name='id_prodotto' value='" . htmlspecialchars($product['id']) . "'>"; // Campo nascosto con l'ID del prodotto
                    echo "<input class='rimuovi-button' type='submit' name='rimuovi' value='Rimuovi'>";// Pulsante per rimuovere il prodotto
                    echo "</form>";
                    echo "</div>";
                } 
                else 
                {
                    echo "Errore: Dettagli del prodotto mancanti o non validi.</p>";
                }
            }
        } 
        ?>

        <div class="totale"> <!-- Contenitore per il totale dell'ordine -->
            Totale ordine: € <?php echo number_format($totalPrice, 2, ',', '.'); ?><!-- Mostra il totale dell'ordine -->
        </div>
    </div>
    <div class="bottoni-fondo"> <!-- Contenitore per i bottoni di fondo pagina -->
        <a href='profile.php'><button>TORNA ALLA PAGINA PRECEDENTE</button></a><!-- Bottone per tornare alla pagina precedente -->
    </div>

</body>

</html>
