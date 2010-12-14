<?php
/**
 * @package Pgnator
 * @version 0.3
 */
/*
Plugin Name: Pgnator
Plugin URI: #
Description: Pequeno paginador para wp_query e sql dinamico
Author: Bruno Lara Tavares
Version: 0.5
Author URI: #
*/
class Pgnator
{
//Deck
public $numPosts = 1;
public $urlLimpo = true;
private $total;
private $pg = 1;
private $numpgs;
private $prox = "&raquo;";
private $ant = "&laquo;";
private $ult = "&gt;";
private $pri = "&lt";
private $faixa = 2;

function Pgnator($css = "default"){
    //css
    $css = $css == "default" ?  WP_PLUGIN_URL . '/pgnator/pgnator.css' : $css;
    echo '<link type="text/css" rel="stylesheet" href="'. $css .'" />';
}

function conteudo($query, $sql = false)
{

$this->pg = is_null($_GET["pg"]) ? 1 : $_GET["pg"];

    if($sql)
    {
        $this->total = count($wpdb->get_results($query));
        $content = $wpdb->get_results($query."LIMIT ".$this->numPosts." OFFSET " .($this->pg-1));

    }
    else 
    {
        $this->total = count(query_posts($query));
        $content = new WP_Query($query."&posts_per_page=".$this->numPosts."&offset=".($this->pg-1));
    }
    
    $this->numpgs = $this->total / $this->numPosts;
    //retorna query dinamica

    return $content;
}


function criarMenu()
{
    $endereco = $this->urlLimpo ? $_SERVER["REDIRECT_URL"] . "?pg=" : "?page_id=".$_GET[page_id]."&pg=";
    $str = "<ul class='pgnator'>";
       if ($this->numpgs > 1)
       {
           //Link para pagina anterior, se for preciso
            if($this->pg > 1){
                $str .= "<li><a title='Primeiro' href='".$endereco."1'>".$this->pri."</a></li>";
                $str .= "<li><a title='Anterior' href='".$endereco.($this->pg-1)."'>".$this->ant."</a></li>";
            }
                 
            //Loop para números baseado na faixa
            for ($cont = 1; $cont <= ceil($this->numpgs); $cont ++)
            {
                $class = $cont == $this->pg ? 'active' : '';
                if(($cont < $this->pg + $this->faixa) && ($cont > $this->pg - $this->faixa))
                $str .= "<li><a class='".$class."' href='".$endereco.$cont."'>".$cont."</a></li>";
            }
            //Link para proxima pagina, se for preciso
            if($this->pg < $this->numpgs )
            {
                $str .= "<li><a title='Próximo' href='".$endereco.($this->pg+1)."'>".$this->prox."</a></li>";
                $str .= "<li><a title='Ultimo' href='".$endereco.ceil($this->numpgs)."'>".$this->ult."</a></li>";
            }
                
       }
   $str .= "</ul>";
        return $str;
}


function renomear($ant,$prox)
{
    //Renomeia os textos dos link de proximo e anterior
 $this->ant = $ant;
 $this->prox = $prox;
}

function mudarFaixa($int)
{
    //Muda faixa de numero
 $this->faixa = $int + 1;
}
}

?>
