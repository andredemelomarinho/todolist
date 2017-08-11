<?php
/*
 * classe TSqlSelect
 * Esta classe prov� meios para manipula��o de uma instru��o de SELECT no banco de dados
 */
final class TSqlSelect extends TSqlInstruction
{
    private $columns;		   // array de colunas a serem retornadas.
    /*
     * m�todo addColumn
     * adiciona uma coluna a ser retornada pelo SELECT
     * @param $column = coluna da tabela
     */
    public function addColumn($column)
    {
        // adiciona a coluna no array
        $this->columns[] = $column;
    }

    /*
     * m�todo getInstruction()
     * retorna a instru��o de SELECT em forma de string.
     */	
    public function getInstruction()
    {
        // monta a instru��o de SELECT
        $this->sql = 'SELECT ';

        // monta string com os nomes de colunas
        $this->sql .= implode(',', $this->columns);

        // adiciona na cl�usula FROM o nome da tabela
        $this->sql .= ' FROM ' . $this->entity;

        // obt�m a cl�usula WHERE do objeto criteria.
        if ($this->criteria)
        {
            $expression = $this->criteria->dump();
            if ($expression)
            {
                   $this->sql .= ' WHeRE ' . $expression;
            }
            // obt�m as propriedades do crit�rio
            $order = $this->criteria->getProperty('order');
            $limit = $this->criteria->getProperty('limit');
            $offset= $this->criteria->getProperty('offset');
            $groupby= $this->criteria->getProperty('group by');

            // obt�m a ordena��o do SELECT
            if ($order)
            {
                   $this->sql .= ' ORDER by ' . $order;
            }
            if ($limit)
            {
                   $this->sql .= ' LIMIt ' . $limit;
            }
            if ($offset)
            {
                   $this->sql .= ' OFFSET ' . $offset;
            }
             if ($groupby)
            {
                   $this->sql .= ' GROUP BY ' . $groupby;
            }
        }
        echo $this->sql;
        return $this->sql;
    }
}
?>