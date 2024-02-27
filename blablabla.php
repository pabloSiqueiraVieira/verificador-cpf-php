<?php

    $cpf_geral = $_POST['cpf']; //responsavel por armazenar CPF completo sem alterações
    $cpf_separado = array(); //responsavel por separar o CPF para o calculo
    $cpf_calculado = array(); //responsavel por salvar os calculos futuros
    $rotacao = strlen($_POST['cpf']); //responsavel por settar a quantidade de loops também  é o valor utilizado na multiplicação dos valores
    $calculo_digito;

    //separa os digitos do CPF em um array para manipulação futura
    for($i = 0; $i < $rotacao - 2; $i++){
        array_push($cpf_separado, substr($cpf_geral, $i, 1));
    }

    multiplica_valores($cpf_separado, $rotacao, $cpf_calculado);

    $calculo_digito = calcula_digito($cpf_calculado);
    array_push($cpf_separado,$calculo_digito);

    $cpf_calculado = array(); //limpa os valores calculados do CPF anterior para não causar erro no calculo
    multiplica_valores($cpf_separado, $rotacao, $cpf_calculado);
    
    $calculo_digito = calcula_digito($cpf_calculado);
    array_push($cpf_separado,$calculo_digito);

    if($cpf_separado[9] == $cpf_geral[9] && $cpf_separado[10] == $cpf_geral[10]){
        echo '<br> cpf é válido';
    } else{
        echo '<br> cpf invalido ou erro sla';
    }



    //empurra os valores multiplicados para o array CPF calculado que será usado no calculo do digito
    function multiplica_valores($cpf_separado, &$rotacao, &$cpf_calculado){
        $rotacao = count($cpf_separado);
        $iteracao = $rotacao;
        for($i = 0; $i < $rotacao; $i++){
            $multiplicacao_cpf = $cpf_separado[$i] * ($iteracao + 1);
            array_push($cpf_calculado, $multiplicacao_cpf);
            $iteracao--;
        }
    }
    //faz o calculo para descobrir se os ultimos dois digitos do CPF são realmente válidos
    function calcula_digito($cpf_calculado){
        $a = (array_sum($cpf_calculado) * 10) % 11;
        if($a == 10){
            $a = 0;
        }
        return $a;
    }
?> 