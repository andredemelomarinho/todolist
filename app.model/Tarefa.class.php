<?php
/*
   * classe Tarefa
   * Active Record para tabela Tarefa
   */
class Tarefa extends TRecord
{
     const TABLENAME = 'tarefa';
	



 function get_grupo()
	 {
	       
        if (empty($this->grupo))
            $this->grupo = new Grupo($this->id_grupo);
    
        
        return $this->grupo;
    }

    public function set_grupo(Grupo $object)
    {
        $this->grupo = $object;
        $this->id_grupo = $object->id;
    }
	
	public function get_grupo_descricao()
    {
        if (empty($this->grupo))
        {
            $this->grupo = new Grupo($this->id_grupo);
        }
        
        return $this->grupo->descricao;
    }
}
    

?>

