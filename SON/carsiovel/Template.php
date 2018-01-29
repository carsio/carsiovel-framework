<?php

function getController(string $className)
{
  $controllerTemplate =  "<?php

  namespace App\Controller;

  use SON\Controller\Controller;
  use SON\Controller\Action;
  use App\Model\Example;


  class $className extends Controller
  {

    public function action()
    {
      // your code here
    }

  }";

  return $controllerTemplate;
}


function getModel($className)
{
  $modelTemplate = '<?php

  namespace App\Model;

  use SON\Database\Model;
  use SON\Database\Metadata;

  /**
  *
  */
  class '.$className.' extends Model
  {
    use Metadata;

    // Metadados
    // protected $primaryKey = "PK-NAME";
    // protected $table = "TABLE-NAME";

    public function myQuery()
    {
      //$sql = "SELECT FROM DUAL";
      //return $this->execute($sql);
    }

  }';

  return $modelTemplate;
}
