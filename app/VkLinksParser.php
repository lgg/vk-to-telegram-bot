<?php

class VkLinksParser
{
    /**
     * @param string $type internal VK link type (club, id, app, etc)
     * @param string $id id of internal VK link target
     * @return string
     * Construct full link to VK by it's internal type(club, id, app, etc) and id
     */
    private static function constructFullLink($type, $id)
    {
        $prefix = "https://vk.com/";
        return $prefix . $type . $id;
    }

    /**
     * @param bool $needToShow need we delete links or replace them to normal
     * @param string $type internal VK link type (club, id, app, etc)
     * @return string
     * Construct regular expression for parsing text for internal links
     */
    private static function constructRegExpression($needToShow, $type)
    {
        if ($needToShow) {
            return "/\[" . $type . "(.*?)\|(.*?)\]/i";
        } else {
            return "/\[" . $type . ".*\|(.*?)\]/i";
        }
    }

    /**
     * @param array $vk_links
     * @param int $key
     * @return string
     * Construct replacement string for deleting internal VK links
     */
    private static function constructReplaceStringForDeletion($vk_links, $key)
    {
        return $vk_links[1][$key];
    }

    /**
     * @param array $vk_links
     * @param int $key
     * @param string $type internal VK link type (club, id, app, etc)
     * @param array $config defines open and close symbols
     * @return string
     * Construct replacement string for replacing internal VK links to full links
     */
    private static function constructReplaceStringForReplacing($vk_links, $key, $type, $config)
    {
        return $vk_links[2][$key] . $config["symbols"]["open"] . self::constructFullLink($type, $vk_links[1][$key]) . $config["symbols"]["close"];
    }

    /**
     * @param string $text source text
     * @param int $configIndex number of config to use
     * @return string
     * Parse $text for internal vk links [club1|Test] or [id1|Test] and delete or replace them to normal
     */
    public static function parseInternalLinks($text, $configIndex)
    {
        //check config
        $config = Config::getConfigs()[$configIndex]["vkLinks"];

        //internal VK link types
        $link_types = ["club", "id"];

        if ($config["show"]) {
            //need to show normal link
            $replace = 'constructReplaceStringForReplacing';
        } else {
            //we can delete internal VK links
            $replace = 'constructReplaceStringForDeletion';
        }

        //parse for each internal VK link type
        foreach ($link_types as $type) {
            //find all links of such type
            preg_match_all(self::constructRegExpression($config["show"], $type), $text, $vk_links);

            //change text for each link(delete it or replace)
            foreach ($vk_links[0] as $key => $vk_link) {
                $text = str_replace($vk_link, self::$replace($vk_links, $key, $type, $config), $text);
            }
        }

        return $text;
    }
}