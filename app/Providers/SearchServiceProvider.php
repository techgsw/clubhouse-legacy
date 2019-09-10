<?php


namespace App\Providers;

use Illuminate\Support\Facades\Log;

class SearchServiceProvider
{

    /**
     * This will parse a search string into an object with all search terms, index types and operators clearly defined
     * @param string $search The search string typed in by the user
     * @return array $parsed_search An array of associative arrays, each with keys "operator", "index" and "value"
     */
    public static function parseSearchString($search) {
        // capture words wrapped between double quotes
        $regexp = "/[\s]*\\\"([^\\\"]+)\\\"[\s]*"
            // capture words wrapped between single quotes
            ."|[\s]*'([^']+)'[\s]*"
            // delimit words by whitespace
            ."|[\s]+"
            // delimit words by colon but keep the colon
            ."|(?<=[:])/";

        $parsed_search = array();
        $words = preg_split($regexp, $search, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $word = current($words);
        // we're expecting the order of the query string to be [operator] [index]:[value] or just [index]:[value]
        // we'll assume AND if we don't see an operator and "default" if we don't see an index
        while ($word !== false) {
            $index_block = array(
                "operator" => "AND",
                "index" => "default",
                "value" => ""
            );
            if (strcasecmp($word, "or") === 0 || strcasecmp($word, "and") === 0) {
                $index_block["operator"] = $word;
                $word = next($words);
                if ($word === false) {
                    break;
                }
            }
            if (strpos($word, ":") !== false) {
                $index_block["index"] = explode(":", $word, 2)[0];
                $word = next($words);
                if ($word === false) {
                    break;
                }
            }
            $index_block["value"] = $word;
            $word = next($words);
            array_push($parsed_search, $index_block);
        }
        return $parsed_search;
    }
}