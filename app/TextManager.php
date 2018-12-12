<?php

class TextManager
{
    /**
     * @param string $linkText
     * @param string $url
     * @return string
     * Creates Markdown link from url and text-title for this link
     */
    public static function createMarkdownLink($linkText, $url)
    {
        return "[" . $linkText . "](" . $url . ")";
    }

    /**
     * @param string $text
     * @param string $link
     * @param I18N $i18n
     * @param boolean $fromNewLine (optional) need to add \n before "comment: link"
     * @return string
     * Append "Comment in vk:" to text
     */
    public static function appendLinkToVKPost($text, $link, $i18n, $fromNewLine)
    {
        return trim($text . ($fromNewLine ? "\n" : " ") . $i18n->get("textManager", "comment")) . " " . $link;
    }

    /**
     * @param string $text
     * @param array $groupSource
     * @param I18N $i18n
     * @param bool $prepend
     * @return string
     * Prepend/Append "From [groupSource]:" to text
     */
    public static function addFromText($text, $groupSource, $i18n, $prepend)
    {
        if (isset($groupSource["withLink"])) {
            $fromText = self::createMarkdownLink($groupSource["name"], $groupSource["url"]);
        } else {
            $fromText = $groupSource["name"];
        }
        $fromText = $i18n->get("textManager", "from") . $fromText;
        $text = $prepend ? $fromText . "\n" . $text : $text . "\n" . $fromText;
        return trim($text);
    }

    /**
     * @param string $text
     * @param string $link
     * @param int $configIndex index number of config to use
     * @param I18N $i18n
     * @return string
     * Cuts text to 140 symbols or more till the space and add "Read more:" text
     */
    public static function getTextPreview($text, $link, $configIndex, $i18n)
    {
        //check config
        $config = Config::getConfigs()[$configIndex]["textManager"];

        //check if we have 140th symbol
        $i = 139;
        if (!isset($text[$i])) {
            return self::appendLinkToVKPost($text, $link, $i18n);
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

        return trim($text) . ($needDots ? $i18n->get("textManager", "dots") : "") . " " . $i18n->get("textManager", "read-more") . " " . $link;
    }
}
