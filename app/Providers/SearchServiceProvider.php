<?php


namespace App\Providers;

use App\Search;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{

    /**
     * This will parse a search string into an object with all search terms, index types and operators clearly defined
     * @param string $search_string The search string typed in by the user
     * @return array $search_list An array of \App\Search
     */
    public static function parseSearchString($search_string)
    {
        // capture words wrapped between double quotes
        $regexp = "/[\s]*\\\"([^\\\"]+)\\\"[\s]*"
            // delimit words by whitespace
            ."|[\s]+"
            // delimit words by colon but keep the colon
            ."|(?<=[:])/";

        $search_list = array();
        $words = preg_split($regexp, $search_string, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $word = current($words);
        // we're expecting the order of the query string to be [operator] [index]:[value] or just [index]:[value]
        // we'll assume AND if we don't see an operator and "default" if we don't see an index
        while ($word !== false) {
            $search_block = new Search();
            if (strcasecmp($word, "or") === 0 || strcasecmp($word, "and") === 0) {
                $search_block->setOperator($word);
                $word = next($words);
                if ($word === false) {
                    break;
                }
            }
            if (strpos($word, ":") !== false) {
                $search_block->setIndex(explode(":", $word, 2)[0]);
                $word = next($words);
                if ($word === false) {
                    break;
                }
            }
            $search_block->setValue($word);
            $word = next($words);
            array_push($search_list, $search_block);
        }
        return $search_list;
    }
}