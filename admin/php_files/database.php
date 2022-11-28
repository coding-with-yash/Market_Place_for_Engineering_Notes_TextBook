<?php

class Database{

		private $db_host = "localhost";  // Change as required
		private $db_user = "root";       // Change as required
		private $db_pass = "";   // Change as required
		private $db_name = "shbs";   // Change as required

		private $result = array(); // Any results from a query will be stored here
		private $mysqli = ""; // This will be our mysqli object
		private $myQuery = "";// used for debugging process with SQL return

		private $conn = false;

		public function __construct(){

			if(!$this->conn){

				$this->mysqli = new mysqli($this->db_host,$this->db_user,$this->db_pass,$this->db_name);

				// Check connection
				if ($this->mysqli->connect_errno > 0) {
				 	array_push($this->result,$this->mysqli->connect_error);
	        return false; // Problem selecting database return FALSE
				}

			}else{
				return true;
			}
		}


		// Function to insert into the database
    public function insert($table,$params=array()){
    	// Check to see if the table exists
    	 if($this->tableExists($table)){

    	 	$table_columns = implode(', ',array_keys($params));
    	 	$table_value =implode("', '", $params);
    	 	// echo $arr_value; exit;

				$sql="INSERT INTO $table ($table_columns) VALUES ('$table_value')";

    	 	$this->myQuery = $sql; // Pass back the SQL
          // Make the query to insert to the database
          if($this->mysqli->query($sql)){
          	array_push($this->result,$this->mysqli->insert_id);
              //return true; // The data has been inserted
          }else{
          	array_push($this->result,$this->mysqli->error);
              return false; // The data has not been inserted
          }
        }else{
        	return false; // Table does not exist
        }
    }

    // Function to update row in database
    public function update($table,$params=array(),$where = null){
    	// Check to see if table exists
    	if($this->tableExists($table)){
    		// Create Array to hold all the columns to update
	        $args=array();
					foreach($params as $key=>$value){
						// Seperate each column out with it's corresponding value
						// $args[]=$key.'="'.$value.'"';
						$args[]="$key='$value'";
					}
					// print_r($params);
					// print_r($args);
					// Create the query
					//$sql='UPDATE '.$table.' SET '.implode(',',$args).' WHERE '.$where;
					$sql="UPDATE $table SET " . implode(',',$args);
					if($where != null){
		        $sql .= " WHERE $where";
					}
					$this->myQuery = $sql; // Pass back the sql
			 // Make query to database
          if($query = $this->mysqli->query($sql)){
          	array_push($this->result,$this->mysqli->affected_rows);
          	return true; // Update has been successful
          }else{
          	array_push($this->result,$this->mysqli->error);
              return false; // Update has not been successful
          }
        }else{
            return false; // The table does not exist
        }
    }

		//Function to delete table or row(s) from database
    public function delete($table,$where = null){
    	// Check to see if table exists
    	 if($this->tableExists($table)){
    	 	// The table exists check to see if we are deleting rows or table
    	 	
          $sql = "DELETE FROM $table"; // Create query to delete rows
         	if($where != null){
	        	$sql .= " WHERE $where";
					}
          // Submit query to database
          if($this->mysqli->query($sql)){
          	array_push($this->result,$this->mysqli->affected_rows);
              //$this->myQuery = $delete; // Pass back the SQL
              return true; // The query exectued correctly
          }else{
          	array_push($this->result,$this->mysqli->error);
             	return false; // The query did not execute correctly
          }
        }else{
            return false; // The table does not exist
        }
    }

  // Function to SELECT from the database
	public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null){
		// Check to see if the table exists
    if($this->tableExists($table)){ 
			// Create query from the variables passed to the function
			$sql = "SELECT $rows FROM  $table";
			if($join != null){
				$sql .= ' JOIN '.$join;
			}
	    if($where != null){
	    	$sql .= ' WHERE '.$where;
			}
	    if($order != null){
	        $sql .= ' ORDER BY '.$order;
			}
	    if($limit != null){
	    	  if(isset($_GET["page"])){
			    	$page = $_GET["page"];
					}
					else{
					  $page = 1;
					}
					$start = ($page-1) * $limit;

	        $sql .= ' LIMIT '.$start.','.$limit;
	    } 
			
	    	$this->myQuery = $sql; // Pass back the SQL 
	    	// The table exists, run the query
	    	$query = $this->mysqli->query($sql);   

				if($query){
					$this->result = $query->fetch_all(MYSQLI_ASSOC);
					return true; // Query was successful
				}else{
					array_push($this->result,$this->mysqli->error);
					return false; // No rows where returned
				}
    }else{
    	return false; // Table does not exist
  	}
  }

   // FUNCTION to show pagination
  public function pagination($table, $join = null, $where = null, $limit){
  	// Check to see if table exists
  	if($this->tableExists($table)){
  		//If no limit is set then no pagination is available
  		if( $limit != null){
  			// select count() query for pagination
        $sql = "SELECT COUNT(*) FROM $table";
        if($where != null){
      		$sql .= " WHERE $where";
				}
				if($join != null){
					$sql .= ' JOIN '.$join;
				}
				// echo $sql; exit;
        $query = $this->mysqli->query($sql);
        
        $total_record = $query->fetch_array();
        $total_record = $total_record[0];
 
        $total_page = ceil( $total_record / $limit);

        $url = basename($_SERVER['PHP_SELF']);

	        if(isset($_GET["page"])){
			    	$page = $_GET["page"];
					}
					else{
					  $page = 1;
					}

        // show pagination
        $output =   "<ul class='pagination'>";
        if($page>1){
            $output .="<li><a href='$url?page=".($page-1)."' class='page-link'>Prev</a></li>";
        }
        if($total_record > $limit){
          for ($i=1; $i<=$total_page ; $i++) {
            if($i == $page){
               $cls = "class='active'";
            }else{
               $cls = '';
            }
          	$output .="<li $cls><a class='page-link' href='$url?page=$i'>$i</a></li>";
          }
        }
        if($total_page>$page){
          $output .="<li> <a class='page-link' href='$url?page=".($page+1)."'>Next</a></li>";
        }
        $output .= "</ul>";

        return $output;
  		}

  	}else{
    	return false; // Table does not exist
  	}
  }

	public function sql($sql){
		$this->myQuery = $sql; // Pass back the SQL
		$query = $this->mysqli->query($sql);

		if($query){
      $sql_array = explode(' ',$sql);
      switch ($sql_array[0]) {
        case "INSERT":
          array_push($this->result,$this->mysqli->insert_id);
          break;
        case "UPDATE":
          array_push($this->result,$this->mysqli->affected_rows);
          break;
        case "DELETE":
          array_push($this->result,$this->mysqli->affected_rows);
          break;
        case "SELECT":
          array_push($this->result,$query->fetch_all(MYSQLI_ASSOC));
          break;
      }
			// $this->result = $query->fetch_all(MYSQLI_ASSOC);
			return true; // Query was successful
		}else{
			array_push($this->result,$this->mysqli->error);
			return false; // No rows where returned
		}
	}

	// Private function to check if table exists for use with queries
	private function tableExists($table){
		$tablesInDb = $this->mysqli->query("SHOW TABLES FROM  $this->db_name LIKE '$table'");
        if($tablesInDb){
        	if($tablesInDb->num_rows == 1){
                return true; // The table exists
            }else{
            	array_push($this->result,$table." does not exist in this database");
                return false; // The table does not exist
            }
        }
    }
	   
    // Public function to return the data to the user
    public function getResult(){
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql(){
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    // Escape your string
    public function escapeString($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $this->mysqli->real_escape_string($data);
    }

    // close connection
		public function __destruct(){
			if($this->conn){
				if($this->mysqli->close()){
					$this->conn = false;
					return true;
				}else{
					return false;
				}
			}
		}
	}


?>