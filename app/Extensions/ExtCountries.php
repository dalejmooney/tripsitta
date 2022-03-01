<?php
namespace App\Extensions;

class ExtCountries extends \Countries {


    public static function getCodeFromName($country_name)
    {
        $data = \Countries::getList();

        $found = '';
        foreach($data as $k => $name)
        {
            if(strtolower($name) === strtolower($country_name))
            {
                $found = $k;
            }
        }

        return $found;
    }


    /**
     * Get countries as array for select field
     *
     * @return array
     */
    public static function getSelectList()
    {
        $data = \Countries::getList();

        $array = [];
        foreach($data as $k => $name)
        {
            $array[] = ['label' => $name, 'value' => strtolower($k)];
        }

        return $array;
    }

    /**
     * Get languages as array for select field
     *
     * @return array
     */
    public static function getSelectLanguagesList()
    {
        //$data = require(base_path().'/vendor/umpirsky/language-list/data/en_GB/language.php');
        $data = config('tripsitta.languages');

        $array = [];
        foreach($data as $k => $name)
        {
            $array[] = ['label' => $name, 'value' => $k];
        }

        return $array;
    }

    /**
     * Get one language info
     *
     * @param $code
     * @param string $field
     * @return mixed|string
     */
    public static function getOneLanguage($code, $field='label')
    {
        $data = config('tripsitta.languages');

        $array = [];
        foreach($data as $k => $name)
        {
            if($code == $k)
            {
                $array = ['label' => $name, 'value' => $k];
                break;
            }
        }

        return (isset($array[$field])) ? $array[$field] : 'N/A';
    }
}
