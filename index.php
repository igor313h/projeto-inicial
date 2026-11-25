<?php


    require "src/conexao-bd.php";
    require "src/Modelo/produtos.php";
    require "src/Repositorio/produtoRepositorio.php";


    $produtoRepositorio = new produtoRepositorio($pdo);
    $dadosAlmoço = $produtoRepositorio -> opcoesAlmoço();
    $dadosDrinks = $produtoRepositorio -> opcoesDrinks();

   
    
    

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="img/icone-grao.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Grao Digital - Cardápio</title>
</head>
<body>
    <main>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Cardápio</a></li>
                <li><a href="login.html">Admin</a></li>
            </ul>
        </nav>
        <section class="container-banner">
            <div class="container-texto-banner">
                <img src="img/banner-site.png" class="logo" alt="logo-grao">
            </div>
        </section>
        <h2>Cardápio Digital</h2>
        <section class="container-cafe-manha">
            <div class="container-cafe-manha-titulo">
                <h3>Opções para o Almoço</h3>
                <img class= "ornaments" src="img/almoco.jpg" alt="ornaments">
            </div>
             <div class="container-cafe-manha-produtos">
                <?php foreach ($dadosAlmoço as $Almoço): ?>
                    <div class="container-produto">
                        <div class="container-foto">
                            <img src="<?php echo $Almoço -> getImagemDiretorio() ?>">
                        </div>
                        <p><?php echo $Almoço -> getNome() ?></p>
                        <p><?php echo $Almoço -> getDescricao() ?></p>
                        <p>R$ <?php echo  $Almoço -> getPrecoFormatado() ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="container-almoco">
            <div class="container-almoco-titulo">
                <h3>Opções para Drinks</h3>
                <img class= "ornaments" src="img/bebidas.jpg" alt="ornaments">
            </div>
            <div class="container-almoco-produtos">
                 <?php foreach ($dadosDrinks as $bebida): ?>
                <div class="container-produto">
                    <div class="container-foto">
                        <img src="<?php echo $bebida -> getImagemDiretorio() ?>">
                    </div>
                    <p><?php echo $bebida -> getNome() ?></p>
                    <p><?php echo $bebida -> getDescricao() ?></p>
                    <p>R$ <?php echo $bebida -> getPrecoFormatado() ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>