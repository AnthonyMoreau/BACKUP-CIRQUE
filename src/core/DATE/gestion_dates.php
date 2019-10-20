<?php


namespace AppCirque\core\DATE;
use Exception;

class gestion_dates {

    const DAY = [
        "Monday" => "Lundi",
        "Tuesday" => "Mardi",
        "Wednesday" => "Mercredi",
        "Thursday" => "Jeudi",
        "Friday" => "Vendredi",
        "Saturday" => "Samedi",
        "Sunday" => "Dimanche"
    ];
    const MONTH = [
        "January" => "Janvier",
        "February" => "février",
        "March" => "Mars",
        "April" => "Avril",
        "May" => "Mai",
        "June" => "Juin",
        "July" => "Juillet",
        "August" => "Août",
        "September" => "Septembre",
        "October" => "Octobre",
        "November" => "Novembre",
        "December" => "Décembre"
    ];
    const SECONDES_PERS_DAY = 86400;
    const SECONDES_PERS_WEEK = self::SECONDES_PERS_DAY * 7;

    /**
     * @param string $delimiter
     * @return string
     */
    public function day_date_digits ($delimiter = "/") {

        $x = $this->extract_date($this->make_date_digits($delimiter), $delimiter);
        $x = $this->format_zero($x);

        return $x[0].$delimiter.$x[1].$delimiter.$x[2];

    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function day_date_words ($delimiter = "/") {

        $x = $this->extract_date($this->make_date_words($delimiter), $delimiter);
        $x = $this->format_zero($x);

        $day = $this->date_translate(self::DAY, $x[0]);
        $month = $this->date_translate(self::MONTH, $x[2]);

        return $day.$delimiter.$x[1].$delimiter.$month.$delimiter.$x[3];

    }

    /**
     * @return mixed
     */
    public function get_timestamp(){
        try {
            return $this->get_date()[0];
        } catch (Exception $e) {
            die("le timestamp est indisponible tete de cul");
        }
    }

//-----------------------------------------------------------------------------------

    /**
     *
     * @throws Exception
     */
    private function get_date(){
        $x = getdate();
        if (!isset($x[0])){
            throw new Exception('"00/00/00(date temporairement indisponible)"');
        }
        return $x;
    }

    /**(
     * @param $delimiter
     * @return array|string
     */
    private function make_date_digits($delimiter){
        try{
            $x = $this->get_date();
            return $x["mday"].$delimiter.$x["mon"].$delimiter.$x["year"];
        } catch (Exception $e) {
            $x = $e->getMessage();
            return $x;
        }
    }

    /**
     * @param $delimiter
     * @return array|string
     */
    private function make_date_words($delimiter){
        try{
            $x = $this->get_date();
            return $x["weekday"].$delimiter.$x["mday"].$delimiter.$x["month"].$delimiter.$x["year"];
        } catch (Exception $e) {
            $x = $e->getMessage();
            return $x;
        }

    }

    /**
     * @param $date
     * @param string $delimiter
     * @return array
     */
    private function extract_date($date, $delimiter = "/"){
        $x = explode($delimiter, $date);
        return $x;
    }

    /**
     * @param $numbers_of_date
     * @return array
     */
    private function format_zero($numbers_of_date){
        $result = [];
        foreach ($numbers_of_date as $number){
            if ((int) $number < 10 AND (int) $number !== 00){
                $number = '0'.$number;
            }
            $result []= $number;
        }
        return $result;
    }

    /**
     * @param $tab_translate
     * @param $elements
     * @return mixed
     */
    private function date_translate($tab_translate, $elements) {

        foreach($tab_translate as $keys => $values){

            if($elements === $keys) {
                $elements = $values;
            }
        }
        return $elements;
    }
}