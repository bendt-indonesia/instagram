<?php
namespace Bendt\Instagram\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Bendt\Instagram\Models\InstagramSchedulePost;
use Bendt\Instagram\Models\InstagramPopularTag;
use Bendt\Instagram\Models\InstagramGeneralTag;


class TagService
{
    protected $options = [
        'append' => [],
        'prepend' => [],
        'populars' => [], //see $depth_array
        'generals' => [], //see $depth_array
        'limit' => 20,
    ];

    //Two level depth array
    //Seconds level will be array of tags that will be chosen through weight/change ratio ( First Index, #Tag, Comment )
    protected $depth_array = [
        [
            ['#love',1], //hashtag || ratio
            ['#happy',1],
        ]
    ];

    public function __construct($options)
    {
        $this->options = array_merge($this->options, $options);
    }


    public function processTags($tags) {
        $data = [];
        foreach ($tags as $row) {
            $data[] = $this->chooseTag($row);
        }
        return $data;
    }


    public function chooseRandomTag($tags) {
        $tags = $tags[rand(0,(count($tags)-1))];

        return $tags;
    }

    public function chooseTag($tagGroup)
    {
        $options = [];
        foreach ($tagGroup as $row) {
            for ($i = 0; $i < $row[0]; $i++) {
                $options[] = $row[1];
            }
        }

        $count = count($options);
        if ($count == 0) return false;
        shuffle($options);
        $randKey = rand(0, --$count);

        return $options[$randKey];
    }

    public function finalizeTags($tags)
    {
        $popularTags = count($this->options['populars']) > 0 ? $this->processTags($this->options['populars']) : [];

        $generalTags = count($this->options['generals']) > 0 ? $this->processTags($this->options['generals']) : [];

        $tags = array_merge($popularTags, $generalTags, $tags);

        return $this->limitTags($tags);

    }

    public function limitTags($tags)
    {
        $append = $this->options['append'];
        $prepend = $this->options['prepend'];

        $maxTags = count($tags) > $this->options['limit'] ? $this->options['limit'] : count($tags);
        $limitTags = $maxTags - count($append) - count($prepend);

        //if($limitTags <= 0) die('Sum of Appends & Prepends Tags should be greater than equals '.$this->options['limit']);

        if($limitTags > 1) {
            $randomTags = array_rand($tags, $limitTags);
            $selectedTags = [];
            foreach ($randomTags as $idx) {
                $selectedTags[] = $tags[$idx];
            }
        } else {
            $selectedTags = $tags;
        }

        shuffle($selectedTags);

        return array_merge($append,$selectedTags,$prepend);
    }

    public static function compose($instagramSchedulePost) {
        $tags = json_decode($instagramSchedulePost->tags);

        $content = $instagramSchedulePost->content.PHP_EOL;
        $content .= implode(' ', $tags);

        return $content;
    }

    public static function getSchedulePost() {
        return InstagramSchedulePost::where('is_posted',0)->orderBy('schedule_date')->first();
    }

    public static function getPopularTags() {
        $data = InstagramPopularTag::all();
        $tags = [];
        
        foreach ($data as $row) {
            $tags[] = [$row->hashtag,$row->chances];
        }

        return $tags;
    }

    public static function getGeneralTags() {
        $data = InstagramGeneralTag::all();
        $tags = [];

        foreach ($data as $row) {
            $tags[] = [$row->hashtag,$row->chances];
        }
        
        return $tags;
    }
}
