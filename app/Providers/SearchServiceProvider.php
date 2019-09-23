<?php


namespace App\Providers;

use App\Search;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{

    /**
     * This will parse a search string into an object with all search terms, label types and conjunctions clearly defined
     * @param string $search_string The search string typed in by the user
     * @return array $search_list An array of \App\Search
     */
    public static function parseSearchString($search_string)
    {
        $regexp = "/"
            // capture words wrapped between double quotes
            ."[\s]*\\\"([^\\\"]+)\\\"[\s]*"
            // delimit words by whitespace
            ."|[\s]+"
            // delimit words by colon but attach the colon to the end of the word
            ."|(?<=[:])"
            // use parenthesis as a delimiter but keep it
            ."|([()])"
            ."/";

        $search_list = array();
        $words = preg_split($regexp, $search_string, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        // we're expecting the order of the query string to be [conjunction] [label]:[value] or just [label]:[value]
        // we'll assume AND if we don't see a conjunction and "default" if we don't see a label
        Log::info(print_r($words, true));
        while (current($words) !== false) {
            self::buildSearchObject($words, $search_list);
        }
        Log::info(print_r($search_list, true));
        return $search_list;
    }

    private static function buildSearchObject(&$words, &$search_list) {
        $word = current($words);
        Log::info($word);
        if ($word === false) {
            return;
        }
        $search_block = new Search();
        if (strcasecmp($word, "or") === 0 || strcasecmp($word, "and") === 0) {
            $search_block->setConjunction(strtolower($word));
            $word = next($words);
            if ($word === false) {
                return;
            }
            Log::info($word);
        }
        if (strpos($word, ":") !== false) {
            $search_block->setLabel(explode(":", $word, 2)[0]);
            $word = next($words);
            if ($word === false) {
                return;
            }
            Log::info($word);
        }
        if ($word === "(") {
            $search_block->setLabel($word);
            $search_group_list = array();
            next($words);
            while(current($words) !== ")" && current($words) !== false) {
                self::buildSearchObject($words, $search_group_list);
            }
            $search_block->setValue($search_group_list);
        } else if ($word === ")") {
            next($words);
            return;
        } else {
            $search_block->setValue($word);
        }
        next($words);
        array_push($search_list, $search_block);
    }
}