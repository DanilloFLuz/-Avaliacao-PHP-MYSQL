<?php
    $host = "localhost"; //Trabalhando com o wamp - forma local
    $user = "root"; //Usuario
    $pass = ""; //Senha
    $banco = "tabela_prova"; //Nome do banco criado no wamp

    //Recebe a conexão com o banco de dados - nome do host, usuario, senha e Banco de dados
    $conectar = mysqli_connect($host,$user,$pass,$banco);

    //Verifica se a conexão está correta ou não
    if(mysqli_connect_errno($conectar)){
        echo("Erro de conexão");
    }
?>