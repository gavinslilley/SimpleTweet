<?php
#CMS Made Simple - SimpleTweet by Gavin Lilley


function smarty_cms_function_simpletweet($params, &$smarty)
{
	if(empty($params['tw'])) {
		echo '<center><font color="#FF0000"><b>No Twitter URL has been given, please insert the required as a parameter like {simpletweet tw=""}.</b></font></center>';
	}else
		$simpletweet = $params['tw'];
?>
<script type="text/javascript" 
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"> 
</script> 
<script type="text/javascript">
$(document).ready(function() {
    // Declare variables to hold twitter API url and user name
    var twitter_api_url = 'http://search.twitter.com/search.json';
    var twitter_user    = '<?php echo $simpletweet; ?>';

    // Enable caching
    $.ajaxSetup({ cache: true });

    // Send JSON request
    // The returned JSON object will have a property called "results" where we find
    // a list of the tweets matching our request query
    $.getJSON(
        twitter_api_url + '?callback=?&rpp=5&q=from:' + twitter_user,
        function(data) {
            $.each(data.results, function(i, tweet) {
                // Uncomment line below to show tweet data in Fire Bug console
                // Very helpful to find out what is available in the tweet objects
                //console.log(tweet);

                // Before we continue we check that we got data
                if(tweet.text !== undefined) {
                    // Calculate how many hours ago was the tweet posted
                    var date_tweet = new Date(tweet.created_at);
                    var date_now   = new Date();
                    var date_diff  = date_now - date_tweet;
                    var hours      = Math.round(date_diff/(1000*60*60));

                    // Build the html string for the current tweet
                    var tweet_html = '<div class="tweet_text">';
                    tweet_html    += '<a href="http://www.twitter.com/';
                    tweet_html    += twitter_user + '/status/' + tweet.id + '">';
                    tweet_html    += tweet.text + '<\/a><\/div>';
                    tweet_html    += '<div class="tweet_hours">' + hours;
                    tweet_html    += ' hours ago<\/div>';

                    // Append html string to tweet_container div
                    $('#tweet_container').append(tweet_html);
                }
            });
        }
    );
});
</script>
<div id="tweet_container"></div>
<?php
}

function smarty_cms_help_function_simpletweet() {
	?>
	<h3>What is simpletweet?</h3>
	<p>Display Tweets in the sidebar of your blog</p>
	<p>Insert the tag into your template <code>{simpletweet tw=""}</code></p>
	<?php
}

function smarty_cms_about_function_simpletweet() {
?>
	<p>Author: Gavin Lilley g@gavinlilley.com</p>
	<p>Version: 0.1 (initial Release) 20/10/10 inspired by Wickett Twitter Widget (Wordpress)</p>
	<?php
}

?>