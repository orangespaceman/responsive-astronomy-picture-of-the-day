<?php require_once('lib/TweetMunger.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Tweet Munger</title>
    </head>
    <body>
        <h1>Apodr</h1>
        <?php
            $tweetMunger = new TweetMunger(array(
                'debugMode' => true,
                'originalTwitterAccount' => 'apod',
                'mungedTwitterAccount' => 'apodr',
                'userAgentAccount' => 'lorem@ipsum.com',
                'newTweetCount' => 1,
                'ignoreRetweets' => true,
                'translations' => 'apodr',
                'twitterConsumerKey' => '',
                'twitterConsumerSecret' => '',
                'twitterConsumerOauthToken' => '',
                'twitterConsumerOauthSecret' => ''
            ));
        ?>
    </body>
</html>