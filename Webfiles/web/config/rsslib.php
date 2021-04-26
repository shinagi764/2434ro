<?php

$RSS_Content = array();

function RSS_Tags($item, $type = 1, $channel_name="", $image="")
{
	$y = array();
	$tnl = $item->getElementsByTagName("pubDate");
	$tnl = $tnl->item(0);
	$date = $tnl->firstChild->textContent;	
	
	$tnl = $item->getElementsByTagName("title");
	$tnl = $tnl->item(0);
	$title = $tnl->firstChild->textContent;

	$tnl = $item->getElementsByTagName("link");
	$tnl = $tnl->item(0);
	$link = $tnl->firstChild->textContent;

	if( $type )
	{
		$tnl = $item->getElementsByTagName("description");
		$tnl = $tnl->item(0);
		$description = $tnl->firstChild->textContent;
		$y["description"] = $description;
	}

	$y["channel"] = $channel_name;
	$y["title"] = $title;
	$y["link"] = $link;
	$y["date"] = $date;		
	$y["type"] = $type;
	$y["image"] = $image;

	return $y;
}


function RSS_Channel( $channel, $key )
{
	global $RSS_Content;

	$items = $channel->getElementsByTagName("item");

	$y = RSS_Tags($channel, 0);
	$channel_name = $y['title'];
	
	foreach($items as $item)
	{
		$y = RSS_Tags($item, 1, $channel_name, $key);

		array_push($RSS_Content, $y);
	}
}

function RSS_Retrieve( $urls = array() )
{
	global $RSS_Content;
	$RSS_Content = array();

	foreach ( $urls as $key => $url )
	{
		$doc_{$key}  = new DOMDocument();
		$doc_{$key}->load( $url );
		$channels_{$key} = $doc_{$key}->getElementsByTagName("channel");

		foreach( $channels_{$key} as $channel )
		{
			RSS_Channel( $channel, $key );
		}
	}

}

function RSS_RetrieveLinks($url)
{
	global $RSS_Content;

	$doc  = new DOMDocument();
	$doc->load($url);

	$channels = $doc->getElementsByTagName("channel");
	
	$RSS_Content = array();
	
	foreach($channels as $channel)
	{
		$items = $channel->getElementsByTagName("item");
		foreach($items as $item)
		{
			$y = RSS_Tags($item, 1);
			array_push($RSS_Content, $y);
		}
	}

}

function RSS_Links($url, $size = 15)
{
	global $RSS_Content;

	$page = "<ul>";

	RSS_RetrieveLinks($url);
	if($size > 0)
		$recents = array_slice($RSS_Content, 0, $size + 1);

	foreach($recents as $article)
	{
		$type = $article["type"];
		if($type == 0) continue;
		$title = $article["title"];
		$link = $article["link"];
		$page .= "<li><a href=\"$link\">$title</a></li>\n";			
	}

	$page .="</ul>\n";

	return $page;
}


function RSS_Display( $urls=array(), $size = 15, $site = 0 )
{
	global $RSS_Content;

	$site = 0;
	$opened = false;
	$page = "";
	$site = (intval($site) == 0) ? 1 : 0;

	RSS_Retrieve( $urls );
	//RSS_Sort();
	@uksort($RSS_Content, 'mySort');

	if($size > 0)
	{
		$recents = array_slice($RSS_Content, 0, $size);
	}

	$page .= "
<table cellpadding=\"0\" cellspacing=\"0\">";
	foreach($recents as $article)
	{
		$channel = $article["channel"];
		$title = $article["title"];
		$link = $article["link"];
		$description = $article["description"];
		$date = $article["date"];
		$image = $article["image"];
		$page .= "<td class=\"news\" height='2'></td><tr class=\"row_1\">
					<td width='439'>
					  <div align='left' style='margin-top:0px; font-family: Exo; font-size: 10px; color: #ac9a8d; margin-bottom: 0px;'>" . date('M d, Y', strtotime( $date ) ) . "<span class=\"$image\" style='margin-left: 8px;'>[". $image ."] </span><a target=\"_blank\" href=\"$link\">".substr($title, 0, 65)."</a></div>
				    </td>
				   </tr>
				";
	}
	$page .= "</table>";
	return $page."\n";
}


function War_Masters( $urls=array(), $size = 15, $site = 0 )
{
	global $RSS_Content;

	$site = 0;
	$opened = false;
	$page = "";
	$site = (intval($site) == 0) ? 1 : 0;

	RSS_Retrieve( $urls );
	//RSS_Sort();
	@uksort($RSS_Content, 'mySort');

	if($size > 0)
	{
		$recents = array_slice($RSS_Content, 0, $size);
	}

	$page .= "<table cellspacing=\"0\" cellpadding=\"0\" width='100%'>";
	foreach($recents as $article)
	{
		$channel = $article["channel"];
		$title = $article["title"];
					if(strlen($title) > 15){ 
						$title = substr($title, 0, 15)."<br>".substr($title, 16, 30); 
					}
		$link = $article["link"];
		$description = $article["description"];
		$date = $article["date"];
		$image = $article["image"];
		$page .= "<tr>
					<!---<td class=\"news\"><img src=\"themes/default/img/$image.png\" /></td>--->
					<td class=\"title_wm\" align='center'>
					<a target=\"_blank\" href=\"$link\">".$title."</a>
					</td>
				</tr>	
				";
		
	}
	$page .= "</table>";

	return $page."\n";
}

function mySort($a, $b){
    global $RSS_Content;
    return strtotime($RSS_Content[$b]['date']) - strtotime($RSS_Content[$a]['date']);
}



function RSS_Sort()
{
	global $RSS_Content;

	for( $i =0; $i < count( $RSS_Content ); $i++ )
	{
		$array = array();
		for( $j =$i+1; $j < count( $RSS_Content ) - $i; $j++ )
		{
			if( strtotime($RSS_Content[$i]['date']) < strtotime($RSS_Content[$j]['date']) )
			{
				$temp = array(
					'channel'		=>	$RSS_Content[$i]['channel'],
					'title'			=>	$RSS_Content[$i]['title'],
					'link'			=>	$RSS_Content[$i]['link'],
					'date'			=>	$RSS_Content[$i]['date'],
					'description'	=>	$RSS_Content[$i]['description'],
					'image'			=>	$RSS_Content[$i]['image'],
					'type'			=>	$RSS_Content[$i]['type'],
				);

				$temp2 = array(
					'channel'		=>	$RSS_Content[$j]['channel'],
					'title'			=>	$RSS_Content[$j]['title'],
					'link'			=>	$RSS_Content[$j]['link'],
					'date'			=>	$RSS_Content[$j]['date'],
					'description'	=>	$RSS_Content[$j]['description'],
					'type'			=>	$RSS_Content[$j]['type'],
					'image'			=>	$RSS_Content[$j]['image'],
				);

				$RSS_Content[$i] = $temp2;
				$RSS_Content[$j] = $temp;
				


			}
		}
	}
}

?>
