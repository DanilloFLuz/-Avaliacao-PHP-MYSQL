<?php
    include("bd/conexao.php");
?>
<html>
    <header>
        <title></title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </header>
    <body>

        <!-- FORMULARIO DE PREENCHIMENTO - PRODUTO, COR E PRECO -->
        <section id="form">
            <form action="api/index_api.php" method="POST">
                <?php
                    //Caso esteja passando o ID pela URL, exibir o layout de edição
                    if(!empty($_GET))
                    {
                        $selecionarProduto = mysqli_query($conectar,"SELECT * FROM produtos as prod INNER JOIN preco on preco.id_prod = prod.id_prod WHERE prod.id_prod = ".$_GET["id_prod"].";");
                        $exibeProduto = mysqli_fetch_array($selecionarProduto);
                ?>
                    <div class="titulo">
                        Produto:
                    </div>
                    <input type="text" name="produto" id="produto" class="input_padrao" value="<?echo $exibeProduto["nome"] ?>">
                    <div class="titulo">
                        Preço:
                    </div>
                    <input type="text" name="preco" id="preco" class="input_padrao" value="<?echo $exibeProduto["preco"] ?>">
                    <div class="titulo">
                        Cor:
                    </div>
                    <input type="text" name="cor" id="cor" class="input_padrao" readonly="true" value="<?echo $exibeProduto["cor"] ?>">
                    <input type="hidden" name="id_prod" value="<?php echo $exibeProduto["id_prod"] ?>">
                    <br>
                    <br>
                    <button type="submit" class="botao_padrao" name="alterar">Alterar</button>
                    <button type="submit" class="botao_padrao" name="inserir_novo">Inserir um novo produto</button>
                <?
                    }
                    //Caso não esteja passando nada pela URL, exibir o layout de inserção
                    else{
                ?>
                    <div class="titulo">
                        Produto:
                    </div>
                    <input type="text" name="produto" id="produto" class="input_padrao">
                    <div class="titulo">
                        Preço:
                    </div>
                    <input type="number" name="preco" id="preco" class="input_padrao">
                    <div class="titulo">
                        Cor:
                    </div>
                    <input type="text" name="cor" id="cor" class="input_padrao" >
                    <br>
                    <br>
                    <button type="submit" class="botao_padrao" name="inserir">Inserir</button>
                <?
                    }
                ?>
            </form>
        </section>
        <!-- TABELA DE EXIBIÇÃO DE PRODUTOS -->
        <section id="table_produtos">
                <!-- Filtro para a tabela -->
                    <div class="titulo">
                        Filtro por :
                        <select id="filtro" name="filtro" class="botao_padrao">
                            <option value="nome">Nome</option>
                            <option id="cor" value="cor">Cor</option>
                            <option value="preco">Preço</option>
                        </select>
                        <br>
                        <!-- Apenas aparecer quando a opção "Cor" for escolhida -->
                        <div id="esconder_cores" style="display: none;" class="botao_padrao">
                            <select id="cores">
                                <option value="azul">AZUL</option>
                                <option value="vermelho">VERMELHO</option>
                                <option value="amarelo">AMARELO</option>
                            </select>
                        </div>
                        <!-- #################################################### -->
                        <button type="button" class="botao_padrao" name="filtrar">Filtrar</button>
                    </div>
                <br>
                <!-- Exibição dos produtos -->
                <table border="1">
                    <tr>
                        <td>Produto</td>
                        <td>Cor</td>
                        <td>Preço</td>
                    </tr>
                    <?php
                        $selecionarTudo = "SELECT * FROM produtos as prod INNER JOIN preco on preco.id_prod = prod.id_prod;";
                        $executarSelect = mysqli_query($conectar,$selecionarTudo);
                        
                        while($exibeResul = mysqli_fetch_array($executarSelect)){
                    ?>
                    
                        <tr>
                            <td><? echo $exibeResul["nome"]?></td>
                            <td><? echo $exibeResul["cor"]?></td>
                            <td>R$<? echo number_format($exibeResul["preco"],2,",",".")?></td>
                            <td>
                                <a href="index.php?id_prod=<?php echo $exibeResul["id_prod"] ?>">
                                    <button type="button" class="botao_padrao">Editar</button>
                                </a>
                            </td>
                            <form action="api/index_api.php?id_prod=<?php echo $exibeResul["id_prod"] ?>" method="POST">
                                <td><button type="submit" class="botao_padrao" name="excluir">Excluir</button></td>
                            </form>
                        </tr>
                    <?php
                        }
                    ?>
                </table>
        </section>
        
        <script>
            //Função para fazer aparecer o outro select caso a opção "Cor" for escolhida
            window.onload=function(){
                document.getElementById("filtro").addEventListener('change', function (){
                    var style = this.value == 'cor' ? 'block' : 'none';
                    document.getElementById('esconder_cores').style.display = style;
                });
            }
        </script>
    </body>
</html>