<?
namespace App;
use PDO;
use PDOException;

class Database {
    private static ? Database $instance=null;
    private  PDO $connection;

    private  function __construct(array $database_info) {
    try{
        $dns="mysql:host={$database_info['host']};dbname={$database_info['dbname']}";
        $username=$database_info["user_name"];
        $password=$database_info["password"];

        $this->connection=new PDO($dns,$username,$password);

    }catch(PDOException $th){
        die($th->getMessage());

    }
    
    }
 public static function getInstance(array $database_info): Database
    {
        if(self::$instance === null){
            self::$instance = new self(($database_info));
        }
        return self::$instance;
    }

    public function getConnection():PDO
    {

        return $this->connection;
    }


}


?>