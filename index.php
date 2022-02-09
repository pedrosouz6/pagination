<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">

    <?php
        //Conexão com o banco de dados para pegar a quantidade total de registros
        $conectar = new PDO("mysql:host=localhost; dbname=paginacao; charset=utf8", "root", "");
        $sqlTotalItem = "SELECT * FROM informacoes";
        $stmpTotalItem = $conectar->prepare($sqlTotalItem);
        $stmpTotalItem -> execute();

        //Página atual
        $pag_atual = isset($_GET["id"]) ? intval($_GET["id"]) : intval($_GET["id"] = 1);

        //Quantidade de items por página
        $quant_items = 5;

        //Numero total de registro
        $num_total_registro = $stmpTotalItem->rowCount();

        $num_links = ceil($num_total_registro / $quant_items);
        
        $inicio = ($quant_items * $pag_atual) - $quant_items;

        //Buscar os dados do banco de dados para cada página
        $dadosPaginas = "SELECT * FROM informacoes
        ORDER BY marca ASC
        LIMIT $inicio, $quant_items";

        $buscarNoBD = $conectar->prepare($dadosPaginas);

        $buscarNoBD->execute();

        $dados = $buscarNoBD->fetchAll(PDO::FETCH_ASSOC);
    ?>

        <h1>Carros</h1>
        <?php
            foreach($dados as $dado){
        ?>

        <p><strong>Marca: </strong> <?php echo $dado["marca"]?> |
           <strong>Modelo: </strong> <?php echo $dado["modelo"]?>
        </p>

        <?php };?>
            
        <div class="paginacao_links">
        <?php
            //Exibindo a quantidade de links necessária
            for($i = 1; $i <= $num_links; $i++){
                if($i == intval($pag_atual)){
                    echo "<a href='?id=$i' class='active'>$i</a>";
                }
                else{
                    echo "<a href='?id=$i'>$i</a>";
                }
            }
        ?>
        </div>
    </div>
</body>
</html>