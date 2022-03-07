<?php 
    include_once("../bd/conexao.php");

    //Caso clique no botão de inserir
    if(isset($_POST["inserir"])){
        //Recebendo informações do formulario e adicionando nas variaveis
        $produto = $_POST['produto'];
        $cor = $_POST['cor'];
        $preco = $_POST['preco'];
        $desconto = 0;
    
        if($produto != "" || $cor != "" || $preco != ""){
            //Fazendo a query de inserção e inserindo na tabela produto
            $inserirProd = "INSERT INTO produtos (nome,cor) VALUES ( '".$produto."','".$cor."');";
            $resProd = mysqli_query($conectar,$inserirProd);
    
            //Pegando o ultimo ID inserido na tabela produto
            $pesquisaId = "SELECT * FROM `produtos` WHERE id_prod = LAST_INSERT_ID();";
            $resPesquisa = mysqli_query($conectar,$pesquisaId);
            $exibePesquisa = mysqli_fetch_array($resPesquisa);
    
            //Verificando as cores e fazendo a query de inserção na tabela preço
            if(strtolower($cor) == "azul" || strtolower($cor) == "vermelho"){
                if(strtolower($cor) == "vermelho" && $preco > 50) {
                    $desconto = $preco -(($preco*5)/100);
                    $inserirPreco = "INSERT INTO preco (preco,id_prod) VALUES (".$desconto.",".$exibePesquisa["id_prod"].");";
                }else{
                    $desconto = $preco -(($preco*20)/100);
                    $inserirPreco = "INSERT INTO preco (preco,id_prod) VALUES (".$desconto.",".$exibePesquisa["id_prod"].");";
                }
    
            }else if(strtolower($cor) == "amarelo"){
                $desconto = $preco -(($preco*10)/100);
                $inserirPreco = "INSERT INTO preco (preco,id_prod) VALUES (".$desconto.",".$exibePesquisa["id_prod"].");";
            }else{
                $inserirPreco = "INSERT INTO preco (preco,id_prod) VALUES (".$preco.",".$exibePesquisa["id_prod"].");";
            }
    
            //Executando a query de inserção da tabela preço
            $resPreco = mysqli_query($conectar, $inserirPreco);
            //var_dump($resPreco);
            if($resPreco){
                $alert = "<script> alert('Inserido com sucesso!');";
                $alert .= "window.location.replace('../index.php');</script>";
                echo $alert;
    
            }else{
                $alert = "<script> alert('Erro ao inserir!');";
                $alert .= "window.location.replace('../index.php');</script>";
                echo $alert;
            }
        }else{
            $alert = "<script> alert('Preencha todos os campos!');";
            $alert .= "window.location.replace('../index.php');</script>";
            echo $alert;
        }
        mysqli_close($conectar);
    }//Caso clique no botão de editar
    else if(isset($_POST["alterar"])){
        //Recebendo informações do formulario e adicionando nas variaveis
        $produto = $_POST['produto'];
        $cor = $_POST['cor'];
        $preco = $_POST['preco'];
        $id_prod = $_POST['id_prod'];
        $desconto = 0;
    
        if($produto != "" || $cor != "" || $preco != ""){
            //Fazendo a query de atualização e atualizando na tabela produto
            $atualizaProd = "UPDATE produtos SET nome = '".$produto."', cor = '".$cor."' WHERE id_prod = ".$id_prod.";";
            $resProd = mysqli_query($conectar,$atualizaProd);
    
            //Verificando as cores e fazendo a query de inserção na tabela preço
            if(strtolower($cor) == "azul" || strtolower($cor) == "vermelho"){
                if(strtolower($cor) == "vermelho" && $preco > 50) {
                    $desconto = $preco -(($preco*5)/100);
                    $atualizaPreco = "UPDATE preco SET preco = '".$desconto."' WHERE id_prod = ".$id_prod.";";
                }else{
                    $desconto = $preco -(($preco*20)/100);
                    $atualizaPreco = "UPDATE preco SET preco = '".$desconto."' WHERE id_prod = ".$id_prod.";";
                }
    
            }else if(strtolower($cor) == "amarelo"){
                $desconto = $preco -(($preco*10)/100);
                $atualizaPreco = "UPDATE preco SET preco = '".$desconto."' WHERE id_prod = ".$id_prod.";";
            }else{
                $atualizaPreco = "UPDATE preco SET preco = '".$preco."' WHERE id_prod = ".$id_prod.";";
            }
    
            //Executando a query de atualização da tabela preço
            $resPreco = mysqli_query($conectar, $atualizaPreco);
            //var_dump($resPreco);
            if($resProd){
                $alert = "<script> alert('Atualizado com sucesso!');";
                $alert .= "window.location.replace('../index.php');</script>";
                echo $alert;
    
            }else{
                $alert = "<script> alert('Erro ao atualizar!');";
                $alert .= "window.location.replace('../index.php');</script>";
                echo $alert;
            }
        }else{
            $alert = "<script> alert('Preencha todos os campos!');";
            $alert .= "window.location.replace('../index.php');</script>";
            echo $alert;
        }
        mysqli_close($conectar);

    }//Caso clique no botão de excluir
    else if(isset($_POST["excluir"])){
        $id_prod = $_GET["id_prod"];
        $excluirProd = mysqli_query($conectar,
            "DELETE FROM produtos WHERE id_prod = ".$id_prod.";");
        $excluirPreco = mysqli_query($conectar,
            "DELETE FROM preco WHERE id_prod = ".$id_prod.";");

        if($excluirPreco){
            $alert = "<script> alert('Excluido com sucesso!');";
            $alert .= "window.location.replace('../index.php');</script>";
            echo $alert;
        }else{
            $alert = "<script> alert('Erro ao excluir!');";
            $alert .= "window.location.replace('../index.php');</script>";
            echo $alert;
        }
        mysqli_close($conectar);
    }//Caso não de nenhuma das opções
    else{
        $alert = "<script>window.location.replace('../index.php');</script>";
        echo $alert;
    }
?>