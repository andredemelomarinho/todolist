<?php
/**
 * class TDataGridAction
 * representa uma ação de uma listagem
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
     * método setImage()
     * atribui uma imagem à ação
     * @param $image = local do arquivo de imagem
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * método getImage()
     * retorna a imagem da ação
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * método setLabel()
     * define o rótulo de texto da ação
     * @param $label = rótulo de texto da ação
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * método getLabel()
     * retorna o rótulo de texto da ação
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * método setField()
     * define o nome do campo do banco de dados que será passado juntamente com a ação
     * @param $field = nome do campo do banco de dados
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * método getField()
     * retorna o nome do campo de dados definido pelo método setField()
     */
    public function getField()
    {
        return $this->field;
    }
    
    /**
     * método setField()
     * define o nome do campo do banco de dados que será passado juntamente com a ação
     * @param $field = nome do campo do banco de dados
     */
    public function setField1($field1)
    {
        $this->field1 = $field1;
    }

    /**
     * método getField()
     * retorna o nome do campo de dados definido pelo método setField()
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
     * método getField()
     * retorna o nome do campo de dados definido pelo método setField()
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
     * método getField()
     * retorna o nome do campo de dados definido pelo método setField()
     */
    public function getField3()
    {
        return $this->field3;
    }
}
?>
