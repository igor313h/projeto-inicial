<?php
require 'src/autenticacao.php';
exigirAutenticacao();
require 'src/conexao-bd.php';
require 'src/Modelo/produtos.php';  
require 'src/Repositorio/produtoRepositorio.php';

$produtoRepositorio = new ProdutoRepositorio($pdo);


if (isset($_POST['editar'])) {
  $id = (int) $_POST['id'];
  $produtoAtual = $produtoRepositorio->buscar($id);
  if (!$produtoAtual) {
    header("Location: admin.php");
    exit;
  }
  $tipo = $_POST['tipo'] ?? $produtoAtual->getTipo();
  $imagem = $produtoAtual->getImagem();
  $erroImagem = null;

  if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
      $erroImagem = 'Não foi possível enviar a imagem. Verifique o tamanho do arquivo.';
    } elseif (!is_uploaded_file($_FILES['imagem']['tmp_name'])) {
      $erroImagem = 'Arquivo de imagem inválido.';
    } else {
      $informacoesImagem = @getimagesize($_FILES['imagem']['tmp_name']);
      $extensoesPermitidas = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
      ];

      if ($informacoesImagem === false || !isset($extensoesPermitidas[$informacoesImagem['mime']])) {
        $erroImagem = 'Selecione uma imagem válida (JPG, PNG, GIF ou WebP).';
      } else {
        $extensao = $extensoesPermitidas[$informacoesImagem['mime']];
        $imagem = uniqid('produto-', true) . '.' . $extensao;
        $caminhoImagem = __DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $imagem;

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
          $erroImagem = 'Não foi possível salvar a imagem no servidor.';
        }
      }
    }
  }

  if ($erroImagem === null) {
    $preco = str_replace(['.', ','], ['', '.'], $_POST['preco']);
    $produto = new Produto($id, $tipo, $_POST['nome'], $_POST['descricao'], (float) $preco, $imagem);
    
    $produtoRepositorio->atualizar($produto);

    if (isset($caminhoImagem) && $produtoAtual->getImagem() !== 'banner-site.png') {
      $imagemAntiga = __DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $produtoAtual->getImagem();
      if (is_file($imagemAntiga)) {
        @unlink($imagemAntiga);
      }
    }

    header("Location: admin.php");
    exit;
  } else {
    $preco = str_replace(['.', ','], ['', '.'], $_POST['preco']);
    $produto = new Produto($id, $tipo, $_POST['nome'], $_POST['descricao'], (float) $preco, $imagem);
  }
} else {
  $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
  $produto = $produtoRepositorio->buscar($id);
  if (!$produto) {
    header("Location: admin.php");
    exit;
  }
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
  <title>Grão Digital - Editar Produto</title>
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
    <h1>Editar Produto</h1>
   
  </section>
  <section class="container-form">
    <form action="editar-produto.php" method="post" enctype="multipart/form-data">

      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" placeholder="Digite o nome do produto" value="<?= $produto->getNome() ?>" required>

      <div class="container-radio">
        <div>
            <label for="bebida">Bebida</label>
            <input type="radio" id="bebida" name="tipo" value="Bebida" <?= $produto->getTipo() === 'Bebida' ? 'checked' : '' ?>>
        </div>
        <div>
            <label for="almoco">Almoço</label>
            <input type="radio" id="almoco" name="tipo" value="Almoço" <?= $produto->getTipo() === 'Almoço' ? 'checked' : '' ?>>
        </div>
        <div>
            <label for="cafe">Café</label>
            <input type="radio" id="cafe" name="tipo" value="Café" <?= $produto->getTipo() === 'Café' ? 'checked' : '' ?>>
        </div>
        <?php if (!in_array($produto->getTipo(), ['Bebida', 'Almoço', 'Café'], true)): ?>
          <div>
            <label for="tipo-atual"><?= htmlspecialchars($produto->getTipo(), ENT_QUOTES, 'UTF-8') ?></label>
            <input type="radio" id="tipo-atual" name="tipo" value="<?= htmlspecialchars($produto->getTipo(), ENT_QUOTES, 'UTF-8') ?>" checked>
          </div>
        <?php endif; ?>
    </div>

      <label for="descricao">Descrição</label>
      <input type="text" id="descricao" name="descricao" value="<?= $produto->getDescricao() ?>" placeholder="Digite uma descrição" required>

      <label for="preco">Preço</label>
      <input type="text" id="preco" name="preco" value="<?= number_format($produto->getPreco(), 2, ',', '.') ?>" placeholder="Digite o preço" required>
      <?php if (isset($erroImagem) && $erroImagem !== null): ?>
        <p style="color: #ff8a8a;"><?= htmlspecialchars($erroImagem) ?></p>
      <?php endif; ?>
      <label>Imagem atual</label>
      <img id="imagem-atual" src="<?= htmlspecialchars($produto->getImagemDiretorio()) ?>" alt="Imagem atual do produto" style="width: 120px; height: 120px; object-fit: cover; margin-bottom: 10px;">
      <label for="imagem">Envie uma imagem do produto</label>
      <input type="file" name="imagem" accept="image/*" id="imagem" placeholder="Envie uma imagem">
      <input type="hidden" name="id" value="<?= $produto->getId() ?>">

      <input type="submit" name="editar" class="botao-cadastrar"  value="Editar produto"/>
    </form>

  </section>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/index.js"></script>
</body>
</html>