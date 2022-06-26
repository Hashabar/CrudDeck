<?php

require_once "config.php";
$update = !empty($_GET['update']) ? $_GET['update'] : '';
$atual = intval(!empty($_GET['atual']) ? $_GET['atual'] : '');
$id = $_GET['id'];
$usuario = trim($_GET['usuario']);
$nome_deck = trim($_GET['nome_deck']);


if($_SERVER["REQUEST_METHOD"] == "GET"){
    
    if(empty($usuario)){
        $usuario_err = "Favor inserir um Usuario.";
    }
    
    if(empty($nome_deck)){
        $nome_err = "Favor definir o nome do deck.";     
    }
    
    // Check input errors before inserting in database
    if(empty($usuario_err) && empty($nome_err) && !empty($update)){
        
        // Prepare an insert statement
        //$sql = "INSERT INTO decks (usuario, nome_deck, atual ) VALUES (?, ?, ?)";
        $sql = "UPDATE `decks` SET `usuario`=?,`nome_deck`=?,`atual`=? WHERE `id`=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $usuario, $nome_deck, $atual, $id);
            
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
    <title>Update Deck</title>
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
                    <h2 class="mt-5">Update deck</h2>
                    <p>Favor inserir os dados para deck.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="update" id="update" value="1">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control <?php echo (!empty($usuario_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usuario; ?>">
                            
                        </div>
                        <div class="form-group">
                            <label>Nome do deck</label>
                            <input type="text" name="nome_deck" id="nome_deck" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nome_deck; ?>">
                            
                        </div>
                        <div class="form-group">
                            <label>Atual?</label>
                            <br>
                            <label for="sim">Sim</label>
                            <input type="radio" name="atual" id="sim" class="form-control" value="1" <?php echo $atual ? 'checked' : '' ?>>
                            <label for="nao">Não</label>
                            <input type="radio" name="atual" id="nao" class="form-control" value="0" <?php echo !$atual ? 'checked' : '' ?>>
                            
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