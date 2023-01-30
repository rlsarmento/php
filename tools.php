<?php

/***************************************
* Modulo Ferramentas
* @author Rogerio L. Sarmento
* @Date 24/03/2021
* @Version 1
*/
namespace modulos\class;
class tools {
    /**
    * Caminho - troca as barras do caminho para compatibilizar Linux com Windows
    * @author my name Rogerio L. Sarmento
    * @Date 18/01/2023
    * @Version 1    
    * @return trocado as barras do path de \ por /
    */
    public function change_path(string $path) {
	    return str_replace("/", DIRECTORY_SEPARATOR, $path);
	}    
    /**
    * Load_modulo - carrega modulo configurado no array
    * @author my name Rogerio L. Sarmento
    * @Date 18/01/2023
    * @Version 1    
    * @return trocado as barras do path de \ por /
    */
    public function load_modulo($carga, array $modulos) {
        foreach($modulos as $x => $x_value) {
            if ($carga == $x) { 
                require($this->change_path($x_value));        
            } else {

            }
        }
	}

    /**
    * valor_por_extenso - numero por extenso    * 
    * @author my name Rogerio L. Sarmento
    * @Date 30/01/2023
    * @Version 1    
    * @param  numero 
    * @return numero por extenso
    */

    function valor_por_extenso( $v ){		
            $v = filter_var($v, FILTER_SANITIZE_NUMBER_INT);       
            $sin = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plu = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");    
            $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
            $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
            $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
            $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");    
            $z = 0;     
            $v = number_format( $v, 2, ".", "." );
            $int = explode( ".", $v );     
            for ( $i = 0; $i < count( $int ); $i++ ) {
                for ( $ii = mb_strlen( $int[$i] ); $ii < 3; $ii++ ) {
                    $int[$i] = "0" . $int[$i];
                }
            }    
            $rt = null;
            $fim = count( $int ) - ($int[count( $int ) - 1] > 0 ? 1 : 2);
            for ( $i = 0; $i < count( $int ); $i++ )
            {
                $v = $int[$i];
                $rc = (($v > 100) && ($v < 200)) ? "cento" : $c[$v[0]];
                $rd = ($v[1] < 2) ? "" : $d[$v[1]];
                $ru = ($v > 0) ? (($v[1] == 1) ? $d10[$v[2]] : $u[$v[2]]) : "";     
                $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
                $t = count( $int ) - 1 - $i;
                $r .= $r ? " " . ($v > 1 ? $plu[$t] : $sin[$t]) : "";
                if ( $v == "000")
                    $z++;
                elseif ( $z > 0 )
                    $z--;
                    
                if ( ($t == 1) && ($z > 0) && ($int[0] > 0) )
                    $r .= ( ($z > 1) ? " de " : "") . $plu[$t];
                    
                if ( $r )
                    $rt = $rt . ((($i > 0) && ($i <= $fim) && ($int[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
            }     
            $rt = mb_substr( $rt, 1 );     
            return($rt ? trim( $rt ) : "zero");     
    }

    /**
    * validaCPF($cpf)
    * @author https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
    * @Date 30/01/2023
    * @Version 1    
    * @param  numero 
    * @return true or false
    */

    function validaCPF($cpf) {
         // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    } 
}