
<?php
/*
 * classe TarefaList
 * Cadastro de Tarefa
 * Contém o formuláro e a listagem
 */
class TarefaList extends TPage
{
    private $form;      // formulário de cadastro
    private $datagrid;  // listagem
    private $loaded;
    
    /*
     * método construtor
     * Cria a página, o formulário e a listagem
     */
    public function __construct()
    {
        parent::__construct();
        
        // instancia um formulário
        $this->form = new TForm('form_tarefa');
      
        // instancia uma tabela
        $table = new TTable;
        
        // adiciona a tabela ao formulário
        $this->form->add($table);
        
        // cria os campos do formulário
		$codigo = new TEntry('id');
        $descricao = new TEntry('descricao');
        $datatarefa   = new TEntry('datatarefa');
		$grupo   = new TCombo('id_grupo');
		$usuario  = new TEntry('usuario_id');
		
		
		
		// carrega os fabricantes do banco de dados
        TTransaction::open('my_livro');
        // instancia um repositório de Grupo
        $repository = new TRepository('Grupo');
        // carrega todos objetos
        $collection = $repository->load(new TCriteria);
        // adiciona objetos na combo
        foreach ($collection as $object)
        {
            $items[$object->id] = $object->descricao;
        }
        $grupo->addItems($items);
        TTransaction::close();
        
    
		
		
			
		
        // define os tamanhos
        $descricao->setSize(200);
        $datatarefa->setSize(100);
		$grupo->setSize(100);
		$codigo->setSize(10);
		$codigo->setHidden(FALSE);
		$usuario->setHidden(FALSE);
		$codigo->setEditable(FALSE);
        
        
		
		
		// adiciona uma linha para o campo Descrição
        $row=$table->addRow();
        $row->addCell(new TLabel(''));
        $row->addCell($codigo);
		
		// adiciona uma linha para o campo Descrição
        $row=$table->addRow();
        $row->addCell(new TLabel('Descrição:'));
        $row->addCell($descricao);
		
		
        
        // adiciona uma linha para o campo nome
        $row=$table->addRow();
        $row->addCell(new TLabel('Data Tarefa:'));
        $row->addCell($datatarefa);
		
		
		// adiciona uma linha para o campo grupo
        $row=$table->addRow();
        $row->addCell(new TLabel('Grupo:'));
        $row->addCell($grupo);
        
        
        // cria um botão de ação (salvar)
        $save_button=new TButton('save');
        // define a ação do botão
        $save_button->setAction(new TAction(array($this, 'onSave'),''), 'Salvar');
        
        // adiciona uma linha para a ação do formulário
        $row=$table->addRow();
        $row->addCell($save_button);
        
        // define quais são os campos do formulário
        $this->form->setFields(array($codigo,$descricao,$datatarefa,$grupo,$usuario,$save_button));
        
        // instancia objeto DataGrid
        //$this->datagrid = new TDataGrid;
		$this->datagrid = new TQuickGrid;
        //$this->datagrid->setHeight(200);
		
		        // creates the datagrid columns
        $this->datagrid->addQuickColumn('Tarefa', 'id', 'right', 40,'', new TAction(array($this, 'onReload')), array('order', 'id'));
        $this->datagrid->addQuickColumn('Descrição', 'descricao', 'left', 170,'', new TAction(array($this, 'onReload')), array('order', 'descricao'));
        $this->datagrid->addQuickColumn('Data', 'datatarefa', 'left',140,'', new TAction(array($this, 'onReload')), array('order', 'datatarefa'));
        $this->datagrid->addQuickColumn('Grupo', 'id_grupo', 'left', 190,'',new TAction(array($this, 'onReload')), array('order', 'id_grupo'));

		
        
        // instancia duas ações da DataGrid
        $action1 = new TDataGridAction(array($this, 'onEdit'),'');
        $action1->setLabel('Editar');
        $action1->setImage('ico_edit.png');
        $action1->setField('id');
        
        $action2 = new TDataGridAction(array($this, 'onDelete'),'');
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
		$table->width='1200';
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
     * função onReload()
     * Carrega a DataGrid com os objetos do banco de dados
     */
    function onReload()
    {
		
		echo $_SESSION['user_name'];
		$param =$_GET['order'];
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('my_livro');
        
        // instancia um repositório para Tarefa
        $repository = new TRepository('Tarefa');
        
        // cria um critério de seleção, ordenado pelo id
        $criteria = new TCriteria;
        $criteria->setProperty('order', $param);
        // carrega os objetos de acordo com o criterio
        $tarefas = $repository->load($criteria);
        $this->datagrid->clear();
        if ($tarefas)
        {
            // percorre os objetos retornados
            foreach ($tarefas as $tarefa)
            {
				echo $tarefa->grupo->descricao;
				$tarefa->id_grupo =$tarefa->grupo->descricao;
				$tarefa->datatarefa =$this->conv_data_to_br($tarefa->datatarefa);
                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($tarefa);
            }
        }
        // finaliza a transação
        TTransaction::close();
        $this->loaded = true;
    }
    
    /*
     * função onSave()
     * Executada quando o usuário clicar no botão salvar do formulário
     */
    function onSave()
    {
		
		
        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');
		
		// obtém os dados no formulário em um objeto do Usuário da Sessão
          $repository = new TRepository('Usuario');
        	
        $criteria = new TCriteria;
        $criteria->add(new TFilter('user_name', 'like', $_SESSION['user_name'] ),' AND ');
        // carrega todos os objetos
		$usuario_id = $repository->load($criteria);
		      
        // obtém os dados no formulário em um objeto Tarefa
		$tarefa ->usuario_id = 1;
        $tarefa = $this->form->getData('Tarefa');
        
		$tarefa ->datatarefa =$this->conv_data_to_us($tarefa->datatarefa);
		// armazena o objeto
		  $tarefa->store();
        
        // finaliza a transação
        TTransaction::close();
        // exibe mensagem de sucesso
        new TMessage('info', 'Dados armazenados com sucesso');
        // re-carrega listagem
        $this->onReload();
    }
    
    /*
     * método onDelete()
     * Executada quando o usuário clicar no botão excluir da datagrid
     * Pergunta ao usuário se deseja realmente excluir um registro
     */
    function onDelete($param)
    {
        // obtém o parâmetro $key
        $key=$param['key'];
        
        // define duas ações
        $action1 = new TAction(array($this, 'Delete'));
		$action2 = new TAction(array($this, 'onDelete'));
                
        // define os parâmetros de cada ação
        $action1->setParameter('key', $key);
        $action2->setParameter('key', $key);
        
        // exibe um diálogo ao usuário
        new TQuestion('Deseja realmente excluir o registro ?', $action1, $action2);
    }
    
    /*
     * método Delete()
     * Exclui um registro
     */
    function Delete($param)
    {
        // obtém o parâmetro $key
        $key=$param['key'];
        
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('my_livro');
        
        // instanicia objeto Tarefa
        $tarefa = new Tarefa($key);
        // deleta objeto do banco de dados
        $tarefa->delete();
        
        // finaliza a transação
        TTransaction::close();
        
        // re-carrega a datagrid
        $this->onReload();
        // exibe mensagem de sucesso
        new TMessage('info', "Registro Excluído com sucesso");
    }
    
    /*
     * método onEdit()
     * Executada quando o usuário clicar no botão visualizar
     */
    function onEdit($param)
    {
        // obtém o parâmetro e exibe mensagem
        $key=$param['key'];
        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');
        
        // instanicia objeto Tarefa
        $tarefa = new Tarefa($key);
        // lança os dados do tarefa no formulário
        $this->form->setData($tarefa);
        
        // finaliza a transação
        TTransaction::close();
        $this->onReload();
    }
    
    /*
     * método show()
     * Executada quando o usuário clicar no botão excluir
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
	 function conv_data_to_us($data)
    {
        $dia = substr($data,0,2);
        $mes = substr($data,3,2);
        $ano = substr($data,6,4);
        return "{$ano}-{$mes}-{$dia}";
    }
	function conv_data_to_br($data)
    {
        // captura as partes da data
        $ano = substr($data,0,4);
        $mes = substr($data,5,2);
        $dia = substr($data,8,4);

        // retorna a data resultante
        return "{$dia}/{$mes}/{$ano}";
    }
}
?>
