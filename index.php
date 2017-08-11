<?php
if(session_start() ==null)
{
session_start();
}
//error_reporting(0);
//ini_set(“display_errors”, 0 );
echo"$_SESSION[user_name]\n<a href=logar.php?logout>Logout</a> ";
//echo"$_SESSION[permissao]";
 //include_once("Versao/includes/header.php");
 
function __autoload($classe)
{
	   $pastas = array('app.widgets', 'app.ado', 'app.model', 'app.control');
	   foreach ($pastas as $pasta)
	   {
		      if (file_exists("{$pasta}/{$classe}.class.php"))
        {
		
			         include_once "{$pasta}/{$classe}.class.php";
			         //echo "{$pasta}/{$classe}.class.php";
					 
		      }
			  
	   }
}


class TApplication
{
	   static public function run()
	   {
		      $template = file_get_contents('template.html');
		      $content = '';
		      if ($_GET)
		      {
			         $class = $_GET['class'];
			        
			         //
			         
					 
			         if (class_exists($class))
			         {
				            $pagina = new $class;
				            ob_start();
				            $pagina->show();
				            $content = ob_get_contents();
				            ob_end_clean();
				
			         }
			        /*
			        else if (function_exists($method))
			         {
				            call_user_func($method, $_GET);
				             echo $_GET['class'];
				             echo "-3";
			         }
			         */
		      }
		      echo str_replace('#CONTENT#', $content, $template);
	   }
}
TApplication::run();

?>

