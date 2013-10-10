# RSSClient

Fork of [https://github.com/desarrolla2/RSSClient](https://github.com/desarrolla2/RSSClient) to work with Laravel.


## Installation

``` json
    "require": {
        "tburial/rss-client":  "dev-master"
    },
    "repositories": [
		{
		    "type": "vcs",
		    "url": "https://github.com/tburial/RSSClient"
		}
    ],
```

## Example
``` php
<?php

use Desarrolla2\RSSClient\RSSClient;

class NewsController extends BaseController {
    
    public function getNews()
    {
        $feeds = [
                "http://cdnl.complex.com/feeds/channels/all.xml",
                "http://www.menshealth.com/events-promotions/washpofeed",
                "http://thenextweb.com/feed/"
            ];
        
        $items = [];
        $i=0;
        
        foreach( $feeds as $f )
        {
            $items[$i++] = self::getArticles( $f );
        }
        
        var_dump($items);
    }
    
    private static function getArticles( $feed )
    {
        $client = new RSSClient();
        
        try{
            
            $client->addFeeds( [$feed],'news' );
        
            $articles = $client->fetch('news',1);
            
            foreach($articles as $a)
            {                
                $date = (Array)$a->getPubDate();
                
                if(!empty($date['date']))
                    $post_date = $date['date'];
                else
                    $post_date = NULL;
                
                $article =  [
                                'title' => $a->getTitle(),
                                'link' => $a->getLink(),
                                'description' => trim(Str::limit(strip_tags($a->getDescription()), 200)),
                                'date' => $post_date
                            ];
                break;
            }
            
            return $article;
        }
        catch( Desarrolla2\RSSClient\Exception\ParseException $e)
        {
            //Do nothing
        }
    }
}
```



