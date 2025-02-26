<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "festa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Criar tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS confirmados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    presenca ENUM('Sim', 'Não') NOT NULL,
    quantidade INT NOT NULL,
    acompanhantes TEXT,
    data_confirmacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

$mensagem = "";

// Processar formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $conn->real_escape_string($_POST['nome']);
    $presenca = $conn->real_escape_string($_POST['presenca']);
    $quantidade = (int)$_POST['quantidade'];
    $acompanhantes = $conn->real_escape_string($_POST['acompanhantes']);
    
    $sql = "INSERT INTO confirmados (nome, presenca, quantidade, acompanhantes) VALUES ('$nome', '$presenca', '$quantidade', '$acompanhantes')";
    if ($conn->query($sql) === TRUE) {        
        echo "<script>alert('OPA, AGORA SIM! SHOW BORA SE DIVERTI ENTÃO'); window.location.href='';</script>";
    } else {
        $mensagem = "<p style='color: red;'>Erro ao registrar confirmação: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Confirmação de Presença</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<body>
    <div class="jumbotron jumbotron-fluid" style="background-color: black; color: white;">
        <div class="container">
            <h1 class="display-4">NIVER DA SCHERER</h1>
            <p class="lead">Venha fazer parte desta festa traga sua alegria e disposição e a sede .</p>
        </div>
    </div>
    <div class="container">
        <h2>Confirme sua presença</h2>
        <?php echo $mensagem; ?>
        <form method="post">
            <label>Nome:</label>
            <input type="text" name="nome" required><br><br>
            <label>Você vai comparecer?</label>
            <select name="presenca">
                <option value="Sim">Sim</option>
                <option value="Não">Não</option>
            </select><br><br>
            <label>Quantidade de pessoas:</label>
            <input type="number" name="quantidade" min="1" required><br><br>
            <label>Nomes dos acompanhantes:</label>
            <textarea name="acompanhantes"></textarea><br><br>
            <button type="submit">Confirmar</button>
        </form>
    </div>
    
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>


<?php
$conn->close();
?>
