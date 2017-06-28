<?php

class I18N
{
    //@TODO add default language
    //@TODO add function to change lang folder/path

    private $loadedLangs = [];
    private $activeLang;
    private $langPath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "i18n" . DIRECTORY_SEPARATOR;

    /**
     * @param string $lang
     * loads language array from json file
     */
    private function loadLangFromFile($lang)
    {
        //@TODO add fileload check | throw errors if no such file etc
        //load and decode .json lang file to array
        $langArray = json_decode(file_get_contents($this->langPath . $lang . ".json"), true);

        //add loaded lang to in-memory loaded array
        $this->loadedLangs[$lang] = $langArray;
    }

    /**
     * @param string $lang language to load/activate
     * loads language from file, if language is already loaded - activates it
     */
    public function loadLang($lang)
    {
        //check if we have already load this lang to in-memory array
        if (!isset($this->loadedLangs[$lang])) {
            //load this lang to memory and activate it
            $this->loadLangFromFile($lang);
        }

        //set this lang to activeLang
        $this->activeLang = $lang;
    }

    /**
     * @param string $group group of phrase, check i18n/en.json for more or docs
     * @param string $phrase current phrase to return
     * @return string
     * returns phrase in active-language for group/phrase
     */
    public function get($group, $phrase)
    {
        //@TODO add group/phrase existence check
        return $this->loadedLangs[$this->activeLang][$group][$phrase];
    }
}