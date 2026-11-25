<?php
require 'src/autenticacao.php';
exigirAutenticacao();
require 'src/conexao-bd.php';
require 'src/Modelo/produtos.php';  
require 'src/Repositorio/produtoRepositorio.php';

$produtoRepositorio = new produtoRepositorio($pdo);

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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" href="img/icone-grao.png" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
  <title>Limone d’Oro - Admin</title>
</head>
<body>
<main>
  <nav class="navbar">
    <ul>
      <li><a href="index.php">Cardápio</a></li>
      <li><a href="logout.php">Sair</a></li>
    </ul>
  </nav>
  <section class="container-admin-banner">
    <img src="img/banner-site.png" class="logo-admin" alt="logo-grao-horizontal">
    <h1>Administração Limone & Leonardo</h1>
    
  </section>
  <h2>Lista de Produtos</h2>

  <section class="container-table">
    <table>
      <thead>
        <tr>
          <th>Produto</th>
          <th>Tipo</th>
          <th>Descricão</th>
          <th>Valor</th>
          <th colspan="2">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($produtoRepositorio->buscarTodos() as $produto): ?>
          <tr>
            <td><?= $produto->getNome() ?></td>
            <td><?= $produto->getTipo() ?></td>
            <td><?= $produto->getDescricao() ?></td>
            <td><?= $produto->getPrecoFormatado()?></td>
            <td><a class="botao-editar" href="editar-produto.php?id=<?= $produto->getId() ?>">Editar</a></td>
            <td>
              <form action="excluir-produto.php" method="post">
                <input type="hidden" name="id" value="<?= $produto->getId() ?>">
                <input type="submit" class="botao-excluir" value="Excluir">
              </form>
            </td>
          </tr>
      <?php endforeach; ?>
     
      </tbody>
    </table>
  <a class="botao-cadastrar" href="cadastrar-produto.php">Cadastrar produto</a>
  <form action="#" method="post">
    <input type="submit" class="botao-cadastrar" value="Baixar Relatório"/>
  </form>
  </section>
</main>
</body>
</html>