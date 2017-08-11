﻿<?php
/*
 * classe TarefaList
 * cadastro de tarefa: contém o formuláro e a listagem
 */
class TarefaList extends TPage
{
    private $form;        // formulário de cadastro
    private $datagrid;   // listagem
    private $loaded;

    /*
     * método construtor
     * Cria a página, o formulário e a listagem
     */
    public function __construct()
    {
        parent::__construct();

        // instancia um formulário
        $this->form = new TForm('form_tarefas');

        // instancia uma tabela
        $table = new TTable;

        // adiciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $descricao = new TEntry('descricao');
        $data    = new TEntry('data');
		$grupo    = new TCombo('grupo');
		 $obs    = new TEntry('observacao');

        // define os tamanhos dos campos
        
		
		// carrega as tarefa do banco de dados
        TTransaction::open('my_livro');

        // instancia um repositório de Tarefa
        $repository = new TRepository('Grupo');

        // carrega todos os objetos
        $collection = $repository->load(new TCriteria);

        // adiciona objetos na combo
         foreach ($collection as $object)
        {
            $items[$object->id-1] = $object->descricao;
        }
        $grupo->addItems($items);
		
        TTransaction::close();

        // adiciona uma linha para o campo descrição
        $row=$table->addRow();
        $row->addCell(new TLabel('Descrição:'));
        $row->addCell($descricao);

        // adiciona uma linha para o campo data
        $row=$table->addRow();
        $row->addCell(new TLabel('Data:'));
        $row->addCell($data);

        // adiciona uma linha para o campo estado
        $row=$table->addRow();
        $row->addCell(new TLabel('Grupo:'));
        $row->addCell($grupo);
		
		 // adiciona uma linha para o campo observação
        $row=$table->addRow();
        $row->addCell(new TLabel('Observação:'));
        $row->addCell($obs);

        // cria um botão de ação (salvar)
        $save_button=new TButton('save');

        // define a ação do botão
        $save_button->setAction(new TAction(array($this, 'onSave')), 'Salvar');

        // adiciona uma linha para a ação do formulário
        $row=$table->addRow();
        $row->addCell($save_button);

        // define quais são os campos do formulário
        $this->form->setFields(array($data, $descricao, $obs, $grupo,$save_button));

        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;

        // instancia as colunas da DataGrid
		$codigo   = new TDataGridColumn('id',     'Código', 'right', 50,'');
        $descricao   = new TDataGridColumn('descricao',     'Descrição', 'right', 50,'');
        $data     = new TDataGridColumn('data',   'Data',   'left', 200,'');
        //$grupo   = new TDataGridColumn('grupo_id', 'Grupo', 'left', 40,'');
		//$obs   = new TDataGridColumn('observacao', 'Observação','left',100,'');
        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($codigo);
			$this->datagrid->addColumn($descricao);
			$this->datagrid->addColumn($data);
        //$this->datagrid->addColumn($grupo);
		//$this->datagrid->addColumn($obs);

        // instancia duas ações da DataGrid
        $action1 = new TDataGridAction(array($this, 'onEdit'));
        $action1->setLabel('Editar');
        $action1->setImage('ico_edit.png');
        $action1->setField('id');
        $action2 = new TDataGridAction(array($this, 'onDelete'));
        $action2->setLabel('Deletar');
        $action2->setImage('ico_delete.png');
        $action2->setField('id');

        // adiciona as ações à DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);

        // cria o modelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();

        // monta a página através de uma tabela
        $table = new TTable;

        // cria uma linha para o formulário
        $row = $table->addRow();
        $row->addCell($this->form);

        // cria uma linha para a datagrid
        $row = $table->addRow();
        $row->addCell($this->datagrid);

        // adiciona a tabela à página
        parent::add($table);
    }

    /*
     * método onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload()
    {
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('my_livro');

        // instancia um repositório para Tarefa
        $repository = new TRepository('Tarefa');

        // cria um critério de seleção, ordenado pelo id
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'id');

        // carrega os objetos de acordo com o criterio
        $tarefas = $repository->load($criteria);
        $this->datagrid->clear();
        if ($tarefas)
        {
            // percorre os objetos retornados
            foreach ($tarefas as $tarefa)
            {
                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($tarefa);
            }
        }
        // finaliza a transação
        TTransaction::close();
        $this->loaded = true;
    }


    /*
     * método onSave()
     * executada quando o usuário clicar no botão salvar do formulário
     */
    function onSave()
    {
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        // obtém os dados no formulário em um objeto Tarefa
        $tarefa = $this->form->getData('Tarefa');
        // armazena o objeto
        $tarefa->store();
        // finaliza a transação
        TTransaction::close();
        // exibe mensagem de sucesso
        new TMessage('info', 'Dados armazenados com sucesso');
        // recarrega listagem
        $this->onReload();
    }


    /*
     * método onDelete()
     * executada quando o usuário clicar no botão excluir da datagrid
     * pergunta ao usuário se deseja realmente excluir um registro
     */
    function onDelete($param)
    {
        // obtém o parâmetro $key
        $key=$param['key'];
        // define duas ações
        $action1 = new TAction(array($this, 'Delete'));
        $action2 = new TAction(array($this, 'teste'));
        // define os parâmetros de cada ação
        $action1->setParameter('key', $key);
        $action2->setParameter('key', $key);

      // exibe um diálogo ao usuário
      new TQuestion('Deseja realmente excluir o registro?', $action1, $action2);
    }

    /*
     * método Delete()
     * exclui um registro
     */
    function Delete($param)
    {
        // obtém o parâmetro $key
        $key=$param['key'];
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('pg_livro');
        // instancia objeto Tarefa
        $tarefa = new Tarefa($key);
        // deleta objeto do banco de dados
        $tarefa->delete();
        // finaliza a transação
        TTransaction::close();
        // recarrega a datagrid
        $this->onReload();
        // exibe mensagem de sucesso
        new TMessage('info', "Registro excluído com sucesso");
    }

    /*
     * método onEdit()
     * executada quando o usuário clicar no botão editar da datagrid
     */
    function onEdit($param)
    {
        // obtém o parâmetro $key
        $key=$param['key'];
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('my_livro');
        // instancia objeto Tarefa
        $tarefa = new Tarefa($key);
        // lança os dados da tarefa no formulário
        $this->form->setData($tarefa);
        // finaliza a transação
        TTransaction::close();
        $this->onReload();
    }

    /*
     * método show()
     * exibe a página
     */
    function show()
    {
         // se a listagem ainda não foi carregada
         if (!$this->loaded)
         {
	            $this->onReload();
         }
         parent::show();
    }
}
?>
