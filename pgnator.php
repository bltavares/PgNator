<?php
/**
 * @package Pgnator
 * @version 0.6
 */
/*
Plugin Name: Pgnator
Plugin URI: #
Description: Pequeno paginador para wp_query e sql dinamico
Author: Bruno Lara Tavares
Version: 0.6
Author URI: #
*/
class Pgnator
{
//Deck
public $numPosts = 8;
public $cleanURL = true;
private $total;
private $pg = 1;
private $numpgs;
private $next = "&raquo;";
private $prev = "&laquo;";
private $last = "&gt;";
private $first = "&lt";
private $range = 2;

function Pgnator($css = "default"){
    //css
    $css = $css == "default" ?  WP_PLUGIN_URL . '/pgnator/pgnator.css' : $css;
    echo '<link type="text/css" rel="stylesheet" href="'. $css .'" />';
}

function content($query, $sql = false)
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
    //dinamic query return

    return $content;
}


function createMenu()
{
    $str = "<ul class='pgnator'>";
       if ($this->numpgs > 1)
       {
           //Link para pagina anterior, se for preciso
           //Link for previous page, if necessary
            if($this->pg > 1){
                $str .= "<li><a title='Primeiro' href='".$this->generateUrl("pg=1")."'>".$this->first."</a></li>";
                $str .= "<li><a title='Anterior' href='".$this->generateUrl("pg=".($this->pg-1))."'>".$this->prev."</a></li>";
            }
                 
            //Loop para números baseado na faixa
            //Number loop based on range
            for ($cont = 1; $cont <= ceil($this->numpgs); $cont ++)
            {
                $class = $cont == $this->pg ? 'active' : '';
                if(($cont < $this->pg + $this->range) && ($cont > $this->pg - $this->range))
                $str .= "<li><a class='".$class."' href='".$this->generateUrl("pg=".$cont)."'>".$cont."</a></li>";
            }
            //Link para nextima pagina, se for preciso
            //Link for the last page, if necessary
            if($this->pg < $this->numpgs )
            {
                $str .= "<li><a title='Próximo' href='".$this->generateUrl("pg=".($this->pg + 1))."'>".$this->next."</a></li>";
                $str .= "<li><a title='Ultimo' href='".$this->generateUrl("pg=".$this->numpgs)."'>".$this->last."</a></li>";
            }
                
       }
   $str .= "</ul>";
        return $str;
}


function rename($previous,$next)
{
    //Renomeia os textos dos link de proximo e anterior
    //Rename the next and previous link
 $this->prev = $previous;
 $this->next = $next;
}

function changeRange($int)
{
    //Muda faixa de numero
    //Change numbers range
 $this->range = $int + 1;
}

protected function parseQuery($primeiro,$segundo)
{
	$query = "";
	$primeiro = explode("&",$primeiro);
	foreach ($primeiro as $line)
	{
		list($key, $value) = explode("=", $line);
		$newPri[$key] = $value;
	}
	$segundo = explode("&",$segundo);
	foreach ($segundo as $line)
	{
		list($key, $value) = explode("=", $line);
		$newSeg[$key] = $value;
	}
	$query = array_merge($newPri,$newSeg);
	
	return http_build_query($query);
 
}

protected function generateUrl($updateQuery = "")
{
	$url = "http://".$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"];
	if($updateQuery)
	{
		$url .= "?". $this->parseQuery($_SERVER['QUERY_STRING'],$updateQuery);
	}
	return $url;
}

}

?>
