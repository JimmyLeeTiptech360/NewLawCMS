<?php
if (file_exists('controller/database.php')) {
    require_once('controller/database.php');
} else {
    require_once('database.php');
}

/*This is the base class for every data entity. This class provide function to access every CRUD operation*/
class ModelClass
{
    /*Return all the record in mysql result set. Please fetch the record if you wish to access the data*/
    /*Parameters 
    $parameter_types = types of for $input_parameters:
    i - integer
    d - double
    s - string
    b - BLOB
    
    $input_parameters[] = external clause passed to the query
    example: array('and','id','=',11) will generate
    and id = 11     
    */
    /*Demo
    $output = $this->result('i',array('and','id','=',1));             
    $row = mysqli_fetch_assoc($output);
    
    $this->id = $row['email'];
    */
    public function result($parameter_types = '', array $input_parameters = null, $customClause = '')
    {
        $params = array(
            $parameter_types
        );
        $sql    = 'select * from  ' . get_class($this) . ' where 1 =1';
        
        if (isset($input_parameters)) {
            foreach ($input_parameters as $field) {
                $sql = $sql . ' ' . $field[0] . ' ' . $field[1] . ' ' . $field[2] . ' ?';
                $params[] =& $field[3];
            }
        } else if ($customClause != false) {
            $sql = $sql . ' ' . $customClause;
        }
        
        if (isset($input_parameters)) {
            $retval = $this->getPreparedStatement($sql, $params);
        } else {
            if (file_exists('controller/database.php')) {
                include('controller/database.php');
            } else {
                include('database.php');
            }
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            $retval = $stmt->get_result();
        }
        
        return $retval;
    }
    
    public function count($parameter_types = '', array $input_parameters = null)
    {
        $output = $this->result($parameter_types, $parameter_array);
        
        return mysqli_num_rows($output);
    }
    
    /*Insert the record into database. Please initialize the children object before call the insert function.*/
    /*Parameters 
    $parameter_types = types of for $input_parameters:
    i - integer
    d - double
    s - string
    b - BLOB
    
    $input_parameters[] = parameters to be filled in the prepared statement
    example: insert('s',array('first_name','Jimmy')); 
    */
    protected function insert($parameter_types = '', array $input_parameters = null)
    {
        $params     = array(
            $parameter_types
        );
        $columns    = '';
        $parameters = '';
        
        if (isset($input_parameters)) {
            foreach ($input_parameters as $field) {
                $columns    = $columns . $field[0];
                $parameters = $parameters . '?';
                $params[] =& $field[1];
                
                if (next($input_parameters)) {
                    $columns    = $columns . ',';
                    $parameters = $parameters . ',';
                }
            }
        }
        
        $sql = 'insert into ' . get_class($this) . ' (' . $columns . ')values(' . $parameters . ')';
        
        if (isset($input_parameters)) {
            $retval = $this->getPreparedStatement($sql, $params);
        }
    }
    
    /*Update the record based on ID. Please initialize the children object before call the update function.*/
    /*Parameters 
    $id = record primary key
    
    $parameter_types = types of for $input_parameters:
    i - integer
    d - double
    s - string
    b - BLOB
    
    $input_parameters[] = parameters to be filled in the prepared statement
    example: update(1,'s',array('first_name','Jimmy')); 
    */
    protected function update($id, $parameter_types = '', array $input_parameters = null)
    {
        $params  = array(
            $parameter_types
        );
        $columns = '';
        
        if (isset($input_parameters)) {
            foreach ($input_parameters as $field) {
                $columns = $columns . $field[0] . ' = ' . '? ';
                $params[] =& $field[1];
                
                if (next($input_parameters)) {
                    $columns = $columns . ',';
                }
            }
        }
        
        $sql = 'update ' . get_class($this) . ' set ' . $columns . 'where id =' . $id;
        
        if (isset($input_parameters)) {
            $retval = $this->getPreparedStatement($sql, $params);
        }
    }
    
    /*Function to establish database connection and execute the query. It will return rows for select operation only.*/
    /*Parameters 
    $query = sql statement to be executed
    
    $params = the real value to be fill in the prepared statement
    example = array[0] -> 'lkythemag@kmail.com'
    array[1] -> 'jimmy'
    */
    public function getPreparedStatement($query, $params)
    {
        if (file_exists('controller/database.php')) {
            include('controller/database.php');
        } else {
            include('database.php');
        }
        
        $rows = null;
        
        //try {
            $stmt = $conn->prepare($query);
            if ($stmt) {
                if (isset($params)) {
                    call_user_func_array(array(
                        $stmt,
                        'bind_param'
                    ), $this->makeValuesReferenced($params));
                }
                
                $stmt->execute();
                
                if ($conn->error != '') {
                    throw new Exception($conn->error);
                }
                
                $rows = $stmt->get_result();
                
                $stmt->close();
            }
        //}
        //catch (Exception $e) {
        //    echo 'Message: ' . $e->getMessage();
        //}
        
        $conn->close();
        
        return $rows;
    }
    
    //function to replace ? in prepared statement
    private function makeValuesReferenced($arr)
    {
        $refs = array();
        foreach ($arr as $key => $value)
            $refs[$key] =& $arr[$key];
        return $refs;
    }
    
    /*delete the record based on condition*/
    /*Parameters 
    $parameter_types = types of for $input_parameters:
    i - integer
    d - double
    s - string
    b - BLOB
    
    $input_parameters[] = parameters to be filled in the prepared statement
    example: delete('i',array('or','id','<=',2)); 
    */
    protected function delete($parameter_types = '', array $input_parameters = null)
    {
        $params = array(
            $parameter_types
        );
        $sql    = 'delete from  ' . get_class($this) . ' where 1 =1';
        
        if (isset($input_parameters)) {
            foreach ($input_parameters as $field) {
                $sql = $sql . ' ' . $field[0] . ' ' . $field[1] . ' ' . $field[2] . ' ?';
                $params[] =& $field[3];
            }
        }
        
        if (isset($input_parameters)) {
            $retval = $this->getPreparedStatement($sql, $params);
        } else {
            include('controller/database.php');
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    }
    
    
    public function get_association_result(array $association_array, $parameter_types = '', array $input_parameters = null)
    {
        $params     = array(
            $parameter_types
        );
        $sql        = ' from  ' . get_class($this) . '';
        $select_sql = 'select ' . get_class($this) . '.*, ' . get_class($this) . '.id as ' . get_class($this) . '_ori_id ';
        
        if (isset($association_array)) {
            foreach ($association_array as $table) {
                $sql = $sql . ' join ' . $table[0] . ' on ' . $table[0] . '.' . get_class($this) . '_id =' . get_class($this) . '.id ';
                $sql = $sql . ' join ' . $table[1] . ' on ' . $table[1] . '.id =' . $table[0] . '.' . $table[1] . '_id ';
                
                $select_sql = $select_sql . ', ' . $table[1] . '.*, ' . $table[1] . '.id as ' . $table[1] . '_ori_id ';
            }
        }
        
        $sql = $select_sql . $sql . ' where 1=1 ';
        
        if (isset($input_parameters)) {
            foreach ($input_parameters as $field) {
                $sql = $sql . ' ' . $field[0] . ' ' . $field[1] . ' ' . $field[2] . ' ?';
                $params[] =& $field[3];
            }
        }
        
        if (isset($input_parameters)) {
            $retval = $this->getPreparedStatement($sql, $params);
        } else {
            include('controller/database.php');
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            
            $retval = $stmt->get_result();
        }
        
        return $retval;
    }
}
