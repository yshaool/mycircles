<?php
namespace App\Http\Traits;
use Validator;

trait DbFieldGuesserTrait {

    /*
    * @param  \Illuminate\Http\Request  $request
    */
    /**
     * This function will return an array of guessed column name for each column in the dataMap
     *
     * @param  $tableColNames  - [['dbColName'->'phone','rule'=>'isPhone','possibleColNames'=['phone','cellphone']]]
     * rules - isPhone, isEmail, isDate
     * Possible column names will be matched lower case trimmed if they contain possible match.
     * @return Array of column name guesses respective to the data map columns
     */
    public function guessArrayMapToDbFields($tableColNames, $dataMap,$containsHeaderRow)
    {
        Log::info('Running sample trait');

        //if there is a header row - go over each column and try to match it to the $tableColNames possibleColNames array.
        //Next step is to go over 5 rows and try to match to column name by rule. This means if a field in the row matches a rule 3 out of 5 times then we assume the it is that field.
        //we only do that to the empty fields that have not been identified in step 1.
        //return the array of fields names respective to column
    }

    private function isEmail($str){
        $validator = Validator::make(['maybeEmail'=>$str], [
            'maybeEmail' => 'email',
        ]);
        if ($validator->fails()) {
            return false;
        }
        else
            return true;
    }

    private function isUrl($str){
        $validator = Validator::make(['maybeUrl'=>$str], [
            'maybeUrl' => 'url',
        ]);
        if ($validator->fails()) {
            return false;
        }
        else
            return true;
    }

    private function isPhone($string) {
        $numbersOnly = ereg_replace("[^0-9]", "", $string);
        $numberOfDigits = strlen($numbersOnly);
        if ($numberOfDigits > 6 && $numberOfDigits < 11) {
            return true;
        } else {
            return false;
        }
    }

}
