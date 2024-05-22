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
    </form>

    <?php
    if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['email']) && isset($_POST['password'])) //controlla se nome, cognome,email e password sono stati inviati
    {
        $elemento['nome'] = $_POST['nome'];//prende nome inviata
        $elemento['cognome'] = $_POST['cognome'];//prende cognome inviata
        $elemento['email'] = $_POST['email'];//prende l'email inviata
        $elemento['password'] = $_POST['password'];//prende la password inviata

        $elementi = []; //inizializza un array per contenere gli elementi
        if (file_exists('user.json')) //controlla se il file esiste 
        {
            $json = file_get_contents('user.json');//legge il contenuto del file
            $elementi = json_decode($json, false);//decodifica il contenuto JSON in un array
        }
        array_push($elementi, $elemento); //aggiunge un nuovo elemento all'arry
        $json_dati = json_encode($elementi); //codifica l'array in formato json
        file_put_contents('user.json', $json_dati); //scrive i dati json nel file
        header("Location: login.php");//reidirizza alla pagina login.php
    }
    ?>

</body>

</html>
