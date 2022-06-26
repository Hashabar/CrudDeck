<?php

require_once "config.php";
 
$usuario = $nome  = "";
$usuario_err = $nome_err  = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $input_usuario = trim($_POST["usuario"]);
    if(empty($input_usuario)){
        $usuario_err = "Favor inserir um Usuario.";
    }else{
        $usuario = $input_usuario;
    }
    
    $input_nome = trim($_POST["nome_deck"]);
    if(empty($input_nome)){
        $nome_err = "Favor definir o nome do deck.";     
    } else{
        $nome = $input_nome;
    }

   
    
    // Check input errors before inserting in database
    if(empty($usuario_err) && empty($nome_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO decks (usuario, nome_deck ) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_usuario, $param_nome);
            
            // Set parameters
            $param_usuario = $usuario;
            $param_nome = $nome;
            
            try{
                mysqli_stmt_execute($stmt);
                
                header("location: ../index.php");

                mysqli_stmt_close($stmt);
                exit();
            } catch(PDOException) {
                echo "Oops! Something went wrong. Please try again later.";
              }
        }
         
        

    }
    
    
    mysqli_close($conn);
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Deck</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Inserir deck</h2>
                    <p>Favor inserir os dados para deck.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control <?php echo (!empty($usuario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usuario; ?>">
                            <span class="invalid-feedback"><?php echo $usuario_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nome do deck</label>
                            <input type="text" name="nome_deck" id="nome_deck" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome; ?>">
                            <span class="invalid-feedback"><?php echo $nome_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Inserir">
                        <a href="../index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>