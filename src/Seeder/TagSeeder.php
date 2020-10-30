<?php

namespace Bendt\Instagram\Seeder;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Bendt\Instagram\Models\InstagramGeneralTag;
use Bendt\Instagram\Models\InstagramPopularTag;
use Bendt\Instagram\Models\InstagramTemplate;

class TagSeeder
{
    private $general_tags = [
        ['#horee',1], //hashtag, ratio
        ['#horee'], //hashtag, default ratio = 1
    ];
    
    private $templates = [
        ['this is text content'.PHP_EOL.'next line'],
        ['this is text content to post with nl2br'],
    ];
    
    public static function generalTags($general_tags) {
        $tags = [];
        foreach ($general_tags as $tag) {
            $tag = new InstagramGeneralTag([
                'hashtag' => $tag[0],
                'chances' => isset($tag[1]) ? $tag[1] : 1,
            ]);
            $tag->save();
            $tags[] = $tag;
        }

        return $tags;
    }
    
    public static function popularTags($general_tags) {
        $tags = [];
        foreach ($general_tags as $tag) {
            $tag = new InstagramPopularTag([
                'hashtag' => $tag[0],
                'chances' => isset($tag[1]) ? $tag[1] : 1,
            ]);
            $tag->save();
            $tags[] = $tag;
        }

        return $tags;
    }
    
    public static function template($templates) {
        $contents = [];
        foreach ($templates as $row) {
            $content = new InstagramTemplate([
                'content' => $row,
            ]);
            $content->save();
            $contents[] = $content;
        }

        return $contents;
    }
}
