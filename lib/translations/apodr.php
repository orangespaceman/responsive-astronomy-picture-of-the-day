<?php
/*
 * Apodr Translations class
 */
class ApodrTranslations extends Translations {

    /*
     * Updated HTML comments
     */
    public $updateStart = "\n<!-- APODR START -->\n";

    /*
     * Updated HTML comments
     */
    public $updateEnd = "\n<!-- APODR END -->\n";

    /*
     * Updated Metadata
     *
     * Replace "</head>"
     */
    public $meta = '
      <base href="http://apod.nasa.gov/apod/">
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script src="https://raw.github.com/gist/901295/bf9a44b636a522e608bba11a91b8298acd081f50/ios-viewport-scaling-bug-fix.js"></script>
      <style>
        img, object { max-width:100%; height:auto; }
        iframe { max-width:100%; max-height:100%;  }
        .credit { background:#000; margin:0; padding:10px; color:#fff; list-style:none; text-align:center;  }
        .credit li { display:inline-block; margin:0; padding:0 20px; }
        .credit a { color:#fff; }
      </style>
    ';

    /*
     * Updated Header
     */
    public $header = '
      <ul class="credit">
        <li><a href="http://apod.nasa.gov/apod/">View original</a></li>
        <li><a href="https://f90.co.uk/labs/responsive-astronomy-picture-of-the-day/">Back to lab</a></li>
      </ul>
    ';

    /*
     * Updated Metadata
     */
    public $footer = '
      <script>
        var _gaq=[["_setAccount","UA-898831-7"],["_trackPageview"]];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
        g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
        s.parentNode.insertBefore(g,s)}(document,"script"));
      </script>
    ';

    /*
     * An additional bit of piratical munging
     * @var string
     * @return string
     */
    public function additionalMunging($text, $context) {

        // today's date
        $date = date("Y-m-d");

        // get src of latest apod page
        $src = $this->file_get_contents_curl("http://apod.nasa.gov/apod/");

        // add meta
        $src = str_replace("</head>", $this->updateStart.$this->meta.$this->updateEnd."\n</head>", $src);

        // add header
        $src = preg_replace('/<center>/i', $this->updateStart.$this->header.$this->updateEnd."\n<center>", $src, 1);

        // add footer
        $src = str_replace("</body>", $this->updateStart.$this->header.$this->footer.$this->updateEnd."\n</body>", $src);

        // save index file - update latest for directory root
        $fp = fopen('../pages/index.html', 'w');
        fwrite($fp, $src);
        fclose($fp);

        // save dated file - for twitter
        $fp = fopen('../pages/'.$date.'.html', 'w');
        fwrite($fp, $src);
        fclose($fp);

        // grab first part of tweet (up to URL)
        $description = substr($text, 0, strrpos($text, ": "));

        // update tweet with new URL
        $text = $description . ": ".$date.".html";
        $context->debug('<p>Additional munging: ' . $text . '</p>');
        return $text;
    }


    /*
     * http://snipplr.com/view.php?codeview&id=4084
     * Curl replacement for file_get_contents
     */
     private function file_get_contents_curl($url) {
     	$ch = curl_init();

     	curl_setopt($ch, CURLOPT_HEADER, 0);
     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
     	curl_setopt($ch, CURLOPT_URL, $url);

     	$data = curl_exec($ch);
     	curl_close($ch);

     	return $data;
     }
}

