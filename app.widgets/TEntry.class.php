<?php
/**
 * classe TEntry
 * classe para construção de caixas de texto
 */
class TEntry extends TField
{
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show()
    {
        // atribui as propriedades da TAG
        $this->tag->name = $this->name;     // nome da TAG
        $this->tag->id = $this->name;     // id da TAG
        $this->tag->value = $this->value;   // valor da TAG
        $this->tag->type = 'text';          // tipo de input
        $this->tag->style = "width:{$this->size}"; // tamanho em pixels
        // se o campo não é editável
        if (!parent::getEditable())
        {
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }
        if (!parent::getHidden(False))
        {
            $this->tag->hidden = "1";
            $this->tag->class = 'tfield_hidden'; // classe CSS
        }
        // exibe a tag
        $this->tag->show();
    }
    
     /**
     * método setTransformer()
     * define uma função (callback) a ser aplicada sobre
     * todo dado contido nesta coluna
     * @param $callback = função do PHP ou do usuário
     */
    public function setTransformer($callback)
    {
        $this->transformer = $callback;
    }

    /**
     * método getTransformer()
     * retorna a função (callback) aplicada à coluna
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}
?>

