<?php
header("Content-Type: application/rss+xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:itunesu="http://www.itunesu.com/feed" version="2.0" >
<channel>
<?php echo $this->bRss->renderData($channelData); ?>
<?php echo $content_for_layout; ?>
</channel>	
</rss>