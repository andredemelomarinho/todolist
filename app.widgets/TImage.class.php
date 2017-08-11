<?php
/**
 * classe TImage
 * classe para exibição de imagens
 */
class TImage
{
    private $source;  // localização da imagem
    private $nome;  // localização da imagem
    private $tag;     // objeto TElement

    /**
     * método construtor
     * instancia objeto TImage
     * @param $source = localização da imagem
     */
    public function __construct($source,$nome)
    {
        // atribui a localização da imagem
        $this->source = $source;
        $this->title = $nome;
        // instancia objeto TElement
        $this->tag    = new TElement('img');
    }

    /**
     * método show()
     * exibe imagem na tela
     */
    public function show()
    {
        // define algumas propriedades da tag
        $this->tag->src = $this->source;
        $this->tag->border=0;
         $this->tag->title=$this->title;	
         
        //echo $this->nome;
        // exibe tag na tela
        $this->tag->show();
    }
}
?>
