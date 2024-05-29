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
    //AUTENTICAZIONE UTENTE
    $file = 'user.json'; //file che contine  i dati degli utenti
    // Localhost: indirizzo locale
    // root: utente default del DB (per ora non modificato)
    // password è vuota ""
    // ecommerce-nieddu è il nome del database
    $db = new mysqli("localhost", "root", "", "ecommerce-nieddu");


    if (file_exists($file)) //controlla se il file esiste 
    {
        $json = file_get_contents($file); //legge il contenuto del file
        $elementi = json_decode($json, true); //decodifica il contenuto JSON 
        if (isset($_POST['email']) && isset($_POST['password'])) //controlla se email e password sono stati inviati
        {
            $email = $_POST['email']; //prende l'email inviata
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
    }
    ?>
</body>

</html>