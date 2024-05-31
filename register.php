<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h4 {
            margin-top: 10px;
            color: #333;
            font-size: 18px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px auto;
            display: block;
            border: 1px solid #ccc;
            border-radius: 3px;
            text-align: left;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
            display: block;
            margin: 0 auto;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: #d9534f;
            margin-top: 5px;
        }

        .success-message {
            color: #5bc0de;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <h3>PAGINA DI REGISTRAZIONE</h3>

    <form method="post" action="register.php" class="center"> <!--invia dati tramite POST a register.php -->
        <h4> NOME: </h4> <input type="text" name="nome"><!-- Campo per inserire il nome -->
        <h4> COGNOME: </h4> <input type="text" name="cognome"><!-- Campo per inserire il cognome -->
        <h4> EMAIL: </h4> <input type="email" name="email"><!-- Campo per inserire l'email -->
        <h4> PASSWORD: </h4> <input type="password" name="password"><br><br><!-- Campo per inserire a password -->
        <input type="submit" value="REGISTRA I TUOI DATI"> <!-- Pulsante per inviare i dati del form -->
        <a href="login.php" class="button">vai alla pagina di accesso</a>
    </form>

    <?php
    if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['password'])) //controlla se nome, cognome,email e password sono stati inviati
    {
        $db = new mysqli("localhost", "root", "");


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
        // Controlla la connessione
        if ($db->connect_error) {
            die("Connessione fallita: " . $db->connect_error);
        }

        // Recupera e sanifica (evita l'attacco SQL injection) i dati inviati tramite il form POST
        $nome = $db->real_escape_string($_POST['nome']);
        $cognome = $db->real_escape_string($_POST['cognome']);
        $email = $db->real_escape_string($_POST['email']);
        $password = $db->real_escape_string($_POST['password']);

        // Costruisce la query di inserimento con concatenazione
        $sql = "INSERT INTO `user` (`nome`, `cognome`, `e-mail`, `password`) VALUES ('$nome', '$cognome', '$email', '$password')";

        // Esegue la query e verifica il risultato
        if ($db->query($sql) === TRUE) {
            echo "<p class='success-message'>Nuovo record inserito con successo</p>";
            header("Location: login.php"); // Reindirizza alla pagina di login
            exit(); // Termina lo script dopo il reindirizzamento
        } else {
            echo "<p class='error-message'>Errore nell'inserimento del record: " . $db->error . "</p>";
        }

    }
    ?>

</body>

</html>