<?php
/*
 * classe GrupoList
 * Cadastro de Grupo
 * Contém o formuláro e a listagem
 */
class GrupoList extends TPage
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
        $this->form = new TForm('form_grupo');
        
        // instancia uma tabela
        $table = new TTable;
        
        // adiciona a tabela ao formulário
        $this->form->add($table);
        
        // cria os campos do formulário
		$codigo = new TEntry('id');
        $descricao = new TEntry('descricao');
        $observacao   = new TEntry('observacao');
        
        
        // define os tamanhos
        $descricao->setSize(100);
        $observacao->setSize(200);
		$codigo->setHidden(FALSE);
        
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
        $row->addCell(new TLabel('Observação:'));
        $row->addCell($observacao);
        
        
        // cria um botão de ação (salvar)
        $save_button=new TButton('save');
        // define a ação do botão
        $save_button->setAction(new TAction(array($this, 'onSave')), 'Salvar');
        
        // adiciona uma linha para a ação do formulário
        $row=$table->addRow();
        $row->addCell($save_button);
        
        // define quais são os campos do formulário
        $this->form->setFields(array($codigo,$descricao,$observacao,$save_button));
        
        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;
        
        // instancia as colunas da DataGrid
        $descricao       = new TDataGridColumn('descricao','Descrição',  'center',  100,'');
        $observacao      = new TDataGridColumn('observacao','Observação','left',  200,'');
        
        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($descricao);
        $this->datagrid->addColumn($observacao);
        
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
        // inicia transação com o banco 'pg_livro'
        TTransaction::open('my_livro');
        
        // instancia um repositório para Grupo
        $repository = new TRepository('Grupo');
        
        // cria um critério de seleção, ordenado pelo id
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'id');
        // carrega os objetos de acordo com o criterio
        $grupos = $repository->load($criteria);
        $this->datagrid->clear();
        if ($grupos)
        {
            // percorre os objetos retornados
            foreach ($grupos as $grupo)
            {
                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($grupo);
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
        // obtém os dados no formulário em um objeto Grupo
        $grupo = $this->form->getData('Grupo');
        // armazena o objeto
        $grupo->store();
        
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
        
        // instanicia objeto Grupo
        $grupo = new Grupo($key);
        // deleta objeto do banco de dados
        $grupo->delete();
        
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
        
        // instanicia objeto Grupo
        $grupo = new Grupo($key);
        // lança os dados do grupo no formulário
        $this->form->setData($grupo);
        
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
}
?>
