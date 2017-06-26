<?php

class TextCutter
{
    /**
     * @param string $text
     * @param string $link
     * @param int $configIndex index number of config to use
     * @return string
     * Cuts text to 140 symbols or more till the space and add "Read more:" text
     */
    public static function getTextPreview($text, $link, $configIndex)
    {
        //check config
        $config = Config::getConfigs()[$configIndex]["textCutter"];

        //check if we have 140th symbol
        $i = 139;
        if (!isset($text[$i])) {
            return trim($text . " Комментировать в ВК:") . " " . $link;
        }

        //check in which mode we are working
        if ($config["aggressive"]) {
            //139 + cutting letters limit
            $maxIndex = $i + $config["limit"] + 1;
            //check if we have symbols after last used symbol
            $needDots = isset($text[$maxIndex]);
            $text = substr($text, 0, $maxIndex);
        } else {
            //length of full text
            $maxIndex = strlen($text) - 1;
            //stop if we find space or last symbol
            while ($text[$i] != " " and $i < $maxIndex) {
                $i++;
            }
            $i++;
            //check if we have symbols after last used symbol
            $needDots = isset($text[$i]);
            $text = substr($text, 0, $i);
        }

        return trim($text) . ($needDots ? "..." : "") . " Подробнее: " . $link;
    }
}
