<?php
namespace App\Http\Traits;
use Validator;

trait DbFieldGuesserTrait {

    /*
    * @param  \Illuminate\Http\Request  $request
    */
    /**
     * This function will return an array of guessed column name for each column in the dataMap
     * if there is a header row - will try to match it to the $tableColNames possibleColNames array.
     * The next step is to go over 1 row data and try to match to column name by rule of the content. This means if the field content in the row matches a rule then we assume the it is that field.
     * we only do that to the empty fields that have not been identified in step 1.
     * return the array of fields names respective to columns
     *
     * @param  $tableColNames  - [['dbColName'->'phone','rule'=>'isPhone','possibleColNames'=['phone','cellphone']]]. rules - isPhone, isEmail, isDate, none. possibleColNames - all lower case
     * @param  $dataArray - two dimentional array of data to insert to table in the databse
     * @param  $containsHeaderRow - weather the first row is heading or not.
     *
     *
     * @return Array of column name guesses respective to the data array columns
     */
    public function guessArrayMapToDbFields($tableColumns, $dataArray,$containsHeaderRow)
    {
        $guessedHeaders=array(); //this will contains the returned value
        $firstRow=array_shift($dataArray);

        //populate guessed headers with Empty strings
        for ($i=0 ; $i<count($firstRow) ; $i++)
        {
            array_push($guessedHeaders," ");
        }

        if ($containsHeaderRow)
        {
            $headersRow = array_map('strtolower', $firstRow);
            $i=0;
            foreach ($headersRow as $colHeading){
                //try to find the matching column name by checking if a match is in possibleColNames array of every db column.
                foreach($tableColumns as $tableCol){
                    if (in_array($colHeading, $tableCol["possibleColNames"])){
                        $guessedHeaders[$i]=$tableCol["dbColName"];
                        break;
                    }
                }
                $i++;
            }
        }
        //check if we are done and can return or still need to do second step guesswork
        if (!in_array(" ",$guessedHeaders))
            return $guessedHeaders;

        //the row we are going to work on
        $secondRow=array_shift($dataArray);

        //traverse the $guessedHeaders columns and for each empty one try to find a db column rule that the content of the respective field adheres to.
        for ($i=0 ; $i<count($guessedHeaders) ; $i++){
            if ($guessedHeaders[$i]==" "){
                foreach($tableColumns as $tableCol){
                    if ($tableCol["rule"]!="none"){
                        switch ($tableCol["rule"]) {
                            case "isEmail":
                                if ($this->isEmail($secondRow[$i]))
                                    $guessedHeaders[$i]=$tableCol["dbColName"];
                                break;
                                case "isPhone":
                                if ($this->isPhone($secondRow[$i]))
                                    $guessedHeaders[$i]=$tableCol["dbColName"];
                                break;
                                case "isUrl":
                                if ($this->isUrl($secondRow[$i]))
                                    $guessedHeaders[$i]=$tableCol["dbColName"];
                                break;
                        }
                        if ($guessedHeaders[$i]!=" ")
                            break;//found matching column already
                    }
                }
            }
        }

        return $guessedHeaders;
    }

    public function isEmail($str){
        $validator = Validator::make(['maybeEmail'=>$str], [
            'maybeEmail' => 'email',
        ]);
        if ($validator->fails()) {
            return false;
        }
        else
            return true;
    }

    public function isUrl($str){
        $validator = Validator::make(['maybeUrl'=>$str], [
            'maybeUrl' => 'url',
        ]);
        if ($validator->fails()) {
            return false;
        }
        else
            return true;
    }

    public function isPhone($str) {
        $validator = Validator::make(['maybePhone'=>$str], [
            'maybePhone' => 'phone:AUTO,US,CA',
        ]);
        if ($validator->fails()) {
            return false;
        }
        else
            return true;
    }

}
