<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h3 {
            color: #333;
        }

        form {
            background-color: #fff;
            border: 1px solid #ccc;
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        h4 {
            font-size: 18px;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        .button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <h3>PAGINA DI LOGIN</h3>
    <form method="post" action="login.php" class="center"> <!--invia dati tramite POST a login.php -->
        <h4> EMAIL: </h4> <input type="email" name="email"> <!-- Campo per inserire l'email -->
        <h4> PASSWORD: </h4> <input type="password" name="password"><br><br> <!-- Campo per inserire la password -->
        <input type="submit" value="INVIA I TUOI DATI"> <!-- Pulsante per inviare i dati del form -->
    </form>
    <p>NUOVO ACCOUNT?</p>
    <a href="register.php" class="button">REGISTRATI</a> <!-- Link alla pagina di registrazione -->
    <?php
    session_start(); //avvia sessione
    //GESTIONE DELLA DISCONNESIONE UTENTE
    if (isset($_GET['logout'])) //controlla se l'utente vuole disconnettersi
    {
        session_destroy(); //termina sessione
        header("Location: login.php"); //reidirizza alla pagina login
        exit; //ferma l'esecuzione dello script
    }

    // Localhost: indirizzo locale
    // root: utente default del DB (per ora non modificato)
    // password è vuota ""
    // ecommerce-nieddu è il nome del database
    $db = new mysqli("localhost", "root", "");

    // Controlla la connessione
    if ($db->connect_error) {
        die("Connessione fallita: " . $db->connect_error);
    }


    // Leggi il contenuto del file SQL
    $sqlContent = file_get_contents('db.sql');

    if ($sqlContent === false) {
        die("Errore nella lettura del file SQL.");
    }

    // Esegui tutte le query usando multi_query
    if ($db->multi_query($sqlContent)) {
        do {
            // Questo ciclo processa tutti i risultati delle query
            if ($result = $db->store_result()) {
                $result->free();
            }
        } while ($db->more_results() && $db->next_result());
        echo "Il database è stato creato con successo.";
    } else {
        echo "Errore nell'esecuzione delle query: " . $db->error;
    }

    // Seleziona il database 'ecommerce-nieddu'
    if (!$db->select_db("ecommerce-nieddu")) {
        die("Selezione del database fallita: " . $db->error);
    }
    // Query per ottenere i dati dalla tabella 'user'
    $sql = "SELECT * FROM user";
    $result = $db->query($sql);

    // Creazione di un array per contenere i dati
    $elementi = array();

    if ($result->num_rows > 0) {

        // Itera attraverso i risultati e aggiungili all'array
        while ($row = $result->fetch_assoc()) {
            $elementi[] = $row;
        }
    }
    if (isset($_POST['email']) && isset($_POST['password'])) //controlla se email e password sono stati inviati
    {
        $email = $_POST['e-mail']; //prende l'email inviata
        $password = $_POST['password']; //prende la password inviata
        foreach ($elementi as $elemento) { //controlla ogni utente registrato nel file JSON
            if ($elemento['email'] == $email && $elemento['password'] == $password) //controlla se email e password coincidono 
            {
                session_start(); //avvia una sessione
                $_SESSION['email'] = $email; //salva l'email nella sessione
                $_SESSION['carrello'] = []; //inizializza il carello vuoto
                header("Location: profile.php"); //reidirizza alla pagina profile.php
                exit;
            }
        }
        echo "Errore: email e/o password errati";
    }
    ?>
</body>

</html>