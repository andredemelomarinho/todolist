<?php
/**
 * class TDataGridAction
 * representa uma a��o de uma listagem
 */
class TDataGridAction extends TAction
{
    private $image;
    private $label;
    private $field;
    private $field1;
	private $field2;
	private $field3;

    /**
     * m�todo setImage()
     * atribui uma imagem � a��o
     * @param $image = local do arquivo de imagem
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * m�todo getImage()
     * retorna a imagem da a��o
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * m�todo setLabel()
     * define o r�tulo de texto da a��o
     * @param $label = r�tulo de texto da a��o
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * m�todo getLabel()
     * retorna o r�tulo de texto da a��o
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * m�todo setField()
     * define o nome do campo do banco de dados que ser� passado juntamente com a a��o
     * @param $field = nome do campo do banco de dados
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * m�todo getField()
     * retorna o nome do campo de dados definido pelo m�todo setField()
     */
    public function getField()
    {
        return $this->field;
    }
    
    /**
     * m�todo setField()
     * define o nome do campo do banco de dados que ser� passado juntamente com a a��o
     * @param $field = nome do campo do banco de dados
     */
    public function setField1($field1)
    {
        $this->field1 = $field1;
    }

    /**
     * m�todo getField()
     * retorna o nome do campo de dados definido pelo m�todo setField()
     */
    public function getField1()
    {
        return $this->field1;
    }
	
	//--------------------------------------
		 public function setField2($field2)
    {
        $this->field2 = $field2;
    }

    /**
     * m�todo getField()
     * retorna o nome do campo de dados definido pelo m�todo setField()
     */
    public function getField2()
    {
        return $this->field2;
    }
	//------------------------------------------------------------------
		 public function setField3($field3)
    {
        $this->field3 = $field3;
    }

    /**
     * m�todo getField()
     * retorna o nome do campo de dados definido pelo m�todo setField()
     */
    public function getField3()
    {
        return $this->field3;
    }
}
?>
