<?php include('layouts/header.php'); ?>

<div class="container">
  <h1>Resultado</h1>

  <?php
    // Recebe a data de nascimento do formulário
    $data_nascimento = $_POST['data_nascimento'];
    
    // Carrega o arquivo XML
    $signos = simplexml_load_file("signos.xml");

    // Converte a data de nascimento em formato "d/m"
    $data_usuario = date('d/m', strtotime($data_nascimento));
    
    $signo_encontrado = null;
    
    foreach ($signos->signo as $signo) {
        // Extrai as datas de início e fim dos signos e converte para formato "d/m"
        $dataInicio = DateTime::createFromFormat('d/m', $signo->dataInicio);
        $dataFim = DateTime::createFromFormat('d/m', $signo->dataFim);
        
        // Converte a data do usuário para "d/m"
        $dataUsuario = DateTime::createFromFormat('d/m', $data_usuario);

        // Verifica se o signo se encaixa no intervalo de datas, considerando a passagem de ano
        if (($dataUsuario >= $dataInicio && $dataUsuario <= $dataFim) || 
            ($dataInicio > $dataFim && ($dataUsuario >= $dataInicio || $dataUsuario <= $dataFim))) {
            $signo_encontrado = $signo;
            break;
        }
    }

    // Exibe o resultado ou mensagem de erro
    if ($signo_encontrado) {
      echo "<h2>Seu signo é: " . $signo_encontrado->signoNome . "</h2>";
      echo "<p>" . $signo_encontrado->descricao . "</p>";
    } else {
      echo "<p>Data de nascimento fora do intervalo dos signos.</p>";
    }
  ?>
  
  <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</div>
