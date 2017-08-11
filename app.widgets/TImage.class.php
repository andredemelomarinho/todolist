<?php
/**
 * classe TImage
 * classe para exibi��o de imagens
 */
class TImage
{
    private $source;  // localiza��o da imagem
    private $nome;  // localiza��o da imagem
    private $tag;     // objeto TElement

    /**
     * m�todo construtor
     * instancia objeto TImage
     * @param $source = localiza��o da imagem
     */
    public function __construct($source,$nome)
    {
        // atribui a localiza��o da imagem
        $this->source = $source;
        $this->title = $nome;
        // instancia objeto TElement
        $this->tag    = new TElement('img');
    }

    /**
     * m�todo show()
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
