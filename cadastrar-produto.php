    <?php
    
    require "src/autenticacao.php";
    exigirAutenticacao();
    require "src/conexao-bd.php";
    require "src/Modelo/produtos.php";
    require "src/Repositorio/produtoRepositorio.php";
    
    if(isset($_POST['cadastro'])) {
    $preco = str_replace(['.', ','], ['', '.'], $_POST['preco']);
    $produto = new Produto(null,
    $_POST['tipo'],
    $_POST['nome'],
    $_POST['descricao'],
    (float) $preco,
    

  );

  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
      if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
          throw new RuntimeException('O upload da imagem falhou.');
      }

      $nomeImagem = uniqid() . '-' . basename($_FILES['imagem']['name']);
      $caminhoImagem = __DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $nomeImagem;
      if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
          throw new RuntimeException('Não foi possível salvar a imagem enviada.');
      }
      $produto->setImagem($nomeImagem);
  }
    $produtoRepositorio = new ProdutoRepositorio($pdo);
    $produtoRepositorio->salvar($produto);

    header("Location: admin.php");
    exit;
    }
?>





<!doctype html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="img/icone-grao.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Grão Digital - Cadastrar Produto</title>
</head>
<body>
<main>
  <nav class="navbar">
    <ul>
      <li><a href="index.php">Cardápio</a></li>
      <li><a href="admin.php">Voltar</a></li>
      <li><a href="logout.php">Sair</a></li>
    </ul>
  </nav>
  <section class="container-admin-banner">
    <img src="img/banner-site.png" class="logo-admin" alt="logo-grao">
    <h1>Cadastro de Produtos</h1>
        
    </section>
    <section class="container-form">

        <form method="post" enctype="multipart/form-data">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Digite o nome do produto" required>
            <div class="container-radio">
                <div>
                    <label for="bebida">Bebida</label>
                    <input type="radio" id="bebida" name="tipo" value="Bebida" checked>
                </div>
                <div>
                    <label for="almoco">Almoço</label>
                    <input type="radio" id="almoco" name="tipo" value="Almoço">
                </div>
            </div>
            <label for="descricao">Descrição</label>
            <input type="text" id="descricao" name="descricao" placeholder="Digite uma descrição" required>

            <label for="preco">Preço</label>
            <input type="text" id="preco" name="preco" placeholder="Digite uma descrição" required>

            <label for="imagem">Envie uma imagem do produto</label>
            <input type="file" name="imagem" accept="image/*" id="imagem" placeholder="Envie uma imagem">

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Cadastrar produto"/>
        </form>
    
    </section>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/index.js"></script>
</body>
</html>