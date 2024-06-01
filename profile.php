<!DOCTYPE html>
<html>

<head>
    <title>Prodotti</title>
    <style>
        .contenitore-prodotti {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .prodotto {
            border: 1px solid #ccc;
            padding: 10px;
            width: 30%;
            text-align: center;
            margin-bottom: 20px;
        }

        .prodotto img {
            max-width: 100%;
            height: auto;
        }

        .aggiungi-carrello {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .aggiungi-carrello:hover {
            background-color: #45A049;
        }

        .quantita {
            width: 50px;
        }

        .bottoni-fondo {
            text-align: center;
            margin-top: 20px;
        }

        .bottoni-fondo button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }

        .bottoni-fondo button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="contenitore-prodotti">
        <?php
        session_start(); //inizia una sessione
    // Controlla se il metodo di richiesta è POST e se 'id_prodotto' è stato inviato
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_prodotto'])) 
        {
    // Crea un array prodotto con i dati inviati dal form         
            $product = [
                'id' => $_POST['id_prodotto'],
                'nome' => $_POST['nome'],
                'descrizione' => $_POST['descrizione'],
                'prezzo' => $_POST['prezzo'],
                'immagine' => $_POST['immagine'],
                'quantita' => $_POST['quantita']
            ];
            $_SESSION['carrello'][] = $product; // Aggiunge il prodotto all'array 'carrello' nella sessione
            header("Location: profile.php"); // Reindirizza l'utente alla pagina profile.php
            exit;
        }
        $json = 'prodotti.json'; // Nome del file JSON che contiene i dati dei prodotti
        $prodotti = []; // Inizializza un array vuoto per i prodotti
        if (file_exists($json)) // Controlla se il file prodotti.json esiste
        {
            $prodotti = json_decode(file_get_contents($json), true); // Legge il contenuto del file JSON e lo decodifica in un array associativo
            foreach ($prodotti as $prodotto) 
            {
                echo "<div class='prodotto'>";
                echo "<div class='nome'>" . $prodotto['nome'] . "</div>";// Mostra il nome del prodotto
                echo "<div class='descrizione'>" . $prodotto['descrizione'] . "</div>";// Mostra la descrizione del prodotto
                echo "<div class='prezzo'>" . $prodotto['prezzo'] . "</div>";// Mostra il prezzo del prodotto
                echo "<img src='" . $prodotto['immagine'] . "'>";// Mostra l'immagine del prodotto
                echo "<form method='post' action='profile.php'>";// Form per inviare i dati del prodotto al profilo
                echo "<input type='hidden' name='id_prodotto' value='" . $prodotto['id'] . "'>";// Campo nascosto con l'ID del prodotto
                echo "<input type='hidden' name='nome' value='" . $prodotto['nome'] . "'>";// Campo nascosto con il nome del prodotto
                echo "<input type='hidden' name='descrizione' value='" . $prodotto['descrizione'] . "'>";// Campo nascosto con la descrizione del prodotto
                echo "<input type='hidden' name='prezzo' value='" . $prodotto['prezzo'] . "'>";// Campo nascosto con il prezzo del prodotto
                echo "<input type='hidden' name='immagine' value='" . $prodotto['immagine'] . "'>";// Campo nascosto con l'URL dell'immagine del prodotto
                echo "Quantità: <input class='quantita' type='number' name='quantita' value='1' min='1'><br>";// Campo per inserire la quantità del prodotto
                echo "<input class='aggiungi-carrello' type='submit' value='Aggiungi al carrello'>"; // Pulsante per aggiungere il prodotto al carrello
                echo "</form>";
                echo "</div>";
            }
        }
        ?>
    </div>
    <div class="bottoni-fondo">
        <a href='carrello.php'><button>CARRELLO</button></a> <br> <br>
        <a href='login.php'><button>LOGOUT</button></a>
    </div>

</body>

</html>
