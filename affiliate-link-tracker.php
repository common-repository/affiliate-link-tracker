<?php
/*
Plugin Name: Affiliate Link Tracker
Description: Advanced affiliate link tracker for tracking where your affiliate conversions come from.
Version: 0.2
Author: SEOSEON
Author URI: https://seoseon.com/
Text Domain: affiliate-link-tracker
*/

/*  Copyright © SEOSEON EUROPE LTD. 2020 - info@seoseon.com
	
	This plugin is based on "Redirect List" © SOURCEFOUND INC. 2013-2017
	
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (is_admin()) {
	add_action('admin_menu','aff_lnk_admin_menu');
	add_action('admin_init','aff_lnk_admin_init');
}
function aff_lnk_admin_init() {
	register_setting('aff_lnk_admin_group','aff_lnk','aff_lnk_validate');
}
function aff_lnk_admin_menu() {
	add_options_page('Advanced Affiliate Link Tracker','<span class="dashicons dashicons-admin-links"></span> Affiliate Links','manage_options','aff_lnk_options','aff_lnk_options');
}
function aff_lnk_options() {
	load_plugin_textdomain('link-tracker-list',false,basename(dirname(__FILE__)));
	if (!current_user_can('manage_options'))
		wp_die(__('You do not have sufficient permissions to access this page.','link-tracker-list'));
	echo '<div class="wrap"><h1><span class="dashicons dashicons-admin-links"></span> Advanced Affiliate Link Tracker</h1>'
		.'<form action="options.php" method="post">'
		.'<input id="aff_lnk" type="hidden" name="aff_lnk">';
	settings_fields("aff_lnk_admin_group");
	$red=get_option('aff_lnk');
	echo '</form>'
		.'<style>input,select{vertical-align: middle;margin-bottom: 2px;}summary:before{color:green}</style><div style="background:#fff;padding:10px;display:block;"><table style="width:100%;"><tr><td style="width:21%;">Redirect from URL</td><td style="width:60%;">Redirect to URL</td><td style="width:8%;">Tracking tag</td><td style="width:11%;">Hits</td></tr></table><div id="link-tracker-list">';
	for ($i=0;isset($red[$i]);$i++)
		echo '<div data-idx="'.$i.'"><input type="text" name="aff_lnk['.$i.'][0]" value="'.$red[$i][0].'" style="width:20%;"><span> &raquo; </span><input type="text" name="aff_lnk['.$i.'][1]" value="'.$red[$i][1].'" style="width:60%;"><select name="aff_lnk['.$i.'][2]" style="width:8%;"><option value="0"'.($red[$i][2]=='0'?' selected="selected"':'').'>source</option><option value="1"'.($red[$i][2]=='1'?' selected="selected"':'').'>epi</option><option value="2"'.($red[$i][2]=='2'?' selected="selected"':'').'>sub</option><option value="3"'.($red[$i][2]=='3'?' selected="selected"':'').'>ref</option><option value="4"'.($red[$i][2]=='4'?' selected="selected"':'').'>clickref</option><option value="5"'.($red[$i][2]=='5'?' selected="selected"':'').'>subid</option><option value="6"'.($red[$i][2]=='6'?' selected="selected"':'').'>sid</option><option value="7"'.($red[$i][2]=='7'?' selected="selected"':'').'>r</option><option value="8"'.($red[$i][2]=='8'?' selected="selected"':'').'>afftrack</option></select><input type="number" name="aff_lnk['.$i.'][3]" value="'.$red[$i][3].'" style="width:6%;text-align:right;" disabled="disabled"></div>';
	echo '<div data-idx="'.$i.'"><input type="text" name="aff_lnk['.$i.'][0]" onchange="if (this.value) aff_lnk_add();" placeholder="example: /go/amazon" style="width:20%;"><span> &raquo; </span><input type="text" name="aff_lnk['.$i.'][1]" placeholder="example: https://www.amazon.com/?ref=yourid&linkid=69420" style="width:60%;"><select name="aff_lnk['.$i.'][2]" style="width:8%;"><option value="0">source</option><option value="1">epi</option><option value="2">sub</option><option value="3">ref</option><option value="4">clickref</option><option value="5">subid</option><option value="6">sid</option><option value="7">r</option><option value="8">afftrack</option><select><input type="number" name="aff_lnk['.$i.'][3]" value="0" disabled="disabled" style="width:6%;text-align:right;"></div>'
		.'</div></div>'
		.'<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Redirects" onclick="aff_lnk_submit()"></p>'
		.'<div>
		<script>function footertext() = document.getElementById("footer-thankyou").innerHTML="Created by SEOSEON!";</script>
		<details onload="footertext();"><summary style="font-size:1.5em;">Instructions</summary>
		<h3>How to use the plugin</h3>
		<ol>
		<li>Enter the URL you want to redirect FROM in the LEFT input box.</li>
		<li>Enter the URL you want to redirect TO in the RIGHT input box.</li>
		<li>Select the tracking tag that your affiliate network uses from the dropdown menu.</li>
		</ol>
		<h3>How it works</h3>
		<p>When a user visits your site, a cookie is created to capture URL parameters (standard UTM tags).</p>
		<p>Information captured in the cookie will be appended to your outbound URL, with the corresponding tracking tag of your choice.</p>
		<p>If your URL contains other URL parameters, they will be unaffected. A preceding "?" or "&" will be added to tags automatically as needed.</p>
		<p><strong>If a referrer is set, it will be included. If no referrer is set, the landing page will be inserted instead.</strong></p>
		<p>Every time a redirect is triggered, the hit counter will increase by one. You can reset the counter by exporting, removing the count and re-importing.</p>
		<h3>Standard UTM tags</h3>
		<p>These are the standard UTM tags and their typical usage (plus examples). Include any or all of these UTM tags in your inbound URLs to enable UTM tag tracking.</p>
		<div><ul>
		<p><strong>utm_source</strong> = The specific source (Google, Facebook, example.com)</p>
		<p><strong>utm_medium</strong> = The type of traffic (paid, organic, social, etc.)</p>
		<p><strong>utm_campaign</strong> = The specific campaign (Sunglasses, Caps, etc.)</p>
		<p><strong>utm_term</strong> = The specific keyword (buy sunglasses, best sunglasses, etc.)</p>
		<p><strong>utm_content</strong> = The specific placement (sidebar, top, bottom, email, blog post, etc.)</p>
		</ul></div>
		<p>Any tag that is set will be added to the cookie, and appended to the outbound affiliate link as a text string. The URL will look something like this:</p>
		<p><em>https://your-affiliate-network.com/?clickref=mysource-mymedium-mycampaign-myterm-mycontent-google.com</em></p>
		<p>You will now be able to see the appended information in your affiliate backend.</p>
		<h3>Importing/exporting CSV</h3>
		<p>Please note that all four fields (from URL, to URL, tag # and hit count) are required for importing, or it will assume null values.</p>
		<h3></h3>
		<p><strong>NOTE:</strong> While no personal data is stored by this plugin, please notify your users that you are using cookies if your local legislature requires you to (and to be nice).</p>
		<p><strong>For testing:</strong> Use the shortcode [aff_lnk_view_cookie] to see what is stored in your current cookie. The cookie is held for 30 days. Use a private window (incognito mode) in your browser to get/create a new cookie.</p>
		<p><strong>Please refer to readme.txt for further information</strong></p>
		</details>
		</div>'
		.'<p class="submit"><button class="button-secondary" onclick="aff_lnk_exp()">'.__('Export CSV','link-tracker-list').'</button> <button class="button-secondary" onclick="aff_lnk_inp()">'.__('Import CSV','link-tracker-list').'</button></p>'
		.'<textarea id="expimpbox" style="display:none;width:100%;height:200px">
1. Paste your CSV here
2. Click Import again
3. Click Save Redirects</textarea>'
		.'<script>'
		.'function aff_lnk_submit(){'
			.'var i,a=[],x,l=document.getElementById("link-tracker-list").childNodes;'
			.'for(i=0;i<l.length;i++)if(l[i].childNodes[0].value){x=[l[i].childNodes[0].value,l[i].childNodes[2].value,l[i].childNodes[3].value,l[i].childNodes[4].value];a.push(x);}'
			.'document.getElementById("aff_lnk").value=JSON.stringify(a);'
			.'document.getElementById("aff_lnk").parentNode.submit();'
		.'}'
		.'function aff_lnk_add(){'
			.'var i,n,l=document.getElementById("link-tracker-list");'
			.'if (!l.lastChild.childNodes[0].value) return l.lastChild;'
			.'l.appendChild(n=l.lastChild.cloneNode(true));'
			.'n.setAttribute("data-idx",i=parseInt(n.getAttribute("data-idx"))+1);'
			.'n.childNodes[0].name="aff_lnk["+i+"][0]";n.childNodes[0].value="";'
			.'n.childNodes[2].name="aff_lnk["+i+"][1]";n.childNodes[2].value="";'
			.'n.childNodes[3].name="aff_lnk["+i+"][2]";n.childNodes[3].value="";'
			.'n.childNodes[4].name="aff_lnk["+i+"][3]";n.childNodes[4].value="";'
			.'return n;'
		.'}'
		.'function aff_lnk_exp(){'
			.'var t=[],n,l=document.getElementById("link-tracker-list");'
			.'for(n=l.firstChild;n;n=n.nextSibling) if (n.childNodes[0].value)'
				.'t.push(\'"\'+n.childNodes[0].value+\'","\'+n.childNodes[2].value+\'",\'+n.childNodes[3].value+\',\'+n.childNodes[4].value);'
			.'document.getElementById("expimpbox").innerHTML=t.join("\n");'
			.'document.getElementById("expimpbox").style.display="";'
			.'document.getElementById("expimpbox").select();'
		.'}'
		.'function aff_lnk_inp(){'
			.'if(document.getElementById("expimpbox").style.display){document.getElementById("expimpbox").style.display="";return;}'
			.'var t=document.getElementById("expimpbox").value.split("\n"),i,n,l=document.getElementById("link-tracker-list");'
			.'for(;l.childNodes.length>1;)l.removeChild(l.lastChild);'
			.'l.firstChild.childNodes[0].value=l.firstChild.childNodes[2].value="";'
			.'for(i=0,n=l.firstChild;i<t.length;i++) if (t[i]) {'
				.'t[i]=t[i].split(",");if (t[i].length<2) continue;'
				.'n.childNodes[0].value=t[i][0].substr(0,1)==\'"\'?t[i][0].slice(1,-1):t[i][0];'
				.'n.childNodes[2].value=t[i][1].substr(0,1)==\'"\'?t[i][1].slice(1,-1):t[i][1];'
				.'if(!t[i][2]){t[i][2]=0;};'
				.'if(!t[i][3]){t[i][3]=0;};'
				.'n.childNodes[3].value=t[i][2];'
				.'n.childNodes[4].value=t[i][3];'
				.'n=aff_lnk_add();'
			.'}'
		.'}'
		.'</script></div>';
}

function aff_lnk_validate($in) {
	$out=array();
	$url=get_site_url();
	$in=json_decode($in,true);
	if (is_array($in)) for ($i=0;$i<count($in);$i++) if (is_array($in[$i])&&$in[$i][0]) {
		$tmp=strpos($in[$i][0],substr(strstr($url,'//'),2));
		if ($tmp!==false) $in[$i][0]=substr($in[$i][0],$tmp+strlen(strstr($url,'//'))-2);
		if (substr($in[$i][0],0,1)!='/') $in[$i][0]='/'.$in[$i][0];
		$tmp=strpos($in[$i][1],'//');
		if ($tmp===false) $in[$i][1]=$url.(strpos($in[$i][1],'/')===0?'':'/').$in[$i][1];
		else if ($tmp===0) $in[$i][1]='http:'.$in[$i][1];
		if ($in[$i][1]==$url.'/') $in[$i][1]=$url;
		$out[]=$in[$i];
	}
	return $out;
}

function aff_lnk_go() {
	$red=get_option('aff_lnk');
	if (!empty($_SERVER['REQUEST_URI']))
		$uri=$_SERVER['REQUEST_URI'];
	else if (!empty($_SERVER['HTTP_X_ORIGINAL_URL'])) // IIS mod-rewrite
		$uri=$_SERVER['HTTP_X_ORIGINAL_URL'];
	else if (!empty($_SERVER['HTTP_X_REWRITE_URL'])) // IIS isapi_rewrite
		$uri=$_SERVER['HTTP_X_REWRITE_URL'];
	else {
		if (isset($_SERVER['PATH_INFO'])&&isset($_SERVER['SCRIPT_NAME']))
			$uri=$_SERVER['SCRIPT_NAME'].($_SERVER['PATH_INFO']==$_SERVER['SCRIPT_NAME']?'':$_SERVER['PATH_INFO']);
		else
			$uri=$_SERVER['PHP_SELF'];
		if (!empty($_SERVER['QUERY_STRING']))
			$uri.='?'.$_SERVER['QUERY_STRING'];
	}
	if (strpos($uri,'/index.php')===0) $uri=substr($uri,10);
	if (!$uri) $uri='/'; else if (substr($uri,0,1)!='/') $uri='/'.$uri;
	$qry=strpos($uri,'?');
	$url=($qry!==false?substr($uri,0,$qry):$uri);
	if (strlen($url)>1&&substr($url,-1)=='/') $url=substr($url,0,strlen($url)-1);
	for ($i=0;isset($red[$i]);$i++) {
		$tmp=explode('?',$red[$i][0]);
		if (strlen($tmp[0])>1&&substr($tmp[0],-1)=='/') $tmp[0]=substr($tmp[0],0,strlen($tmp[0])-1);
		if ($url==$tmp[0]) {
			$exe=true;
			if (count($tmp)>1) {
				$tmp=explode('&',$tmp[1]);
				foreach ($tmp as $x) if ($x) {
					$x=explode('=',$x);
					if (!isset($_GET[$x[0]])||(count($x)>1&&urldecode($_GET[$x[0]])!=urldecode($x[1]))) $exe=false;
				}
			} else if ($qry!==false)
				$exe=false;

			$aff_lnk_url = $red[$i][1];
			$aff_lnk_tag = intval($red[$i][2]);
			$aff_lnk_string = sanitize_text_field($_COOKIE["aff_lnk_cookie"]);

			if ($exe) {
				$aff_lnk_tag_array = array(
						'0' => 'source',
						'1' => 'epi',
						'2' => 'sub',
						'3' => 'ref',
						'4' => 'clickref',
						'5' => 'subid',
						'6' => 'sid',
						'7' => 'r',
						'8' => 'afftrack',
				);
				$aff_lnk_tracktag = $aff_lnk_tag_array[$aff_lnk_tag];
				}
				if (parse_url($aff_lnk_url, PHP_URL_QUERY)) {
					$aff_lnk_tracktag = '&'.$aff_lnk_tracktag.'=';
				}
				else {
					$aff_lnk_tracktag = '?'.$aff_lnk_tracktag.'=';
				}
				$red[$i][3]++;
				update_option('aff_lnk',$red);
				wp_redirect($aff_lnk_url.$aff_lnk_tracktag.$aff_lnk_string,302);
				exit;
			}
		}
	}
add_action('plugins_loaded','aff_lnk_go');

/* Adds settings link to plugin list */
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'aff_add_plugin_page_settings_link');
function aff_add_plugin_page_settings_link( $links ) {
	if (current_user_can('manage_options')) {
	$settings = '<a href="' .
		admin_url( 'options-general.php?page=aff_lnk_options' ) .
		'">' . __('Settings') . '</a>';
	array_unshift($links, $settings);
	}
	return $links;
}

/* Knead the dough and bake the cookie (if none exists) */
function aff_lnk_bake_cookie() {
  if (!isset($_COOKIE['aff_lnk_cookie'])) {
	if (isset($_SERVER['HTTP_REFERER'])) {
		$aff_lnk_referrer = esc_url($_SERVER['HTTP_REFERER']);
	}
	else {
		$aff_lnk_referrer = strtok($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '?');
	}
	$aff_lnk_referrer = preg_replace('#^https?://#', '', rtrim($aff_lnk_referrer,'/'));
		$aff_lnk_utm_array = array(
				'utm_source'   => sanitize_text_field($_GET["utm_source"]),
				'utm_medium'   => sanitize_text_field($_GET["utm_medium"]),
				'utm_campaign' => sanitize_text_field($_GET["utm_campaign"]),
				'utm_term'     => sanitize_text_field($_GET["utm_term"]),
				'utm_content'  => sanitize_text_field($_GET["utm_content"]),
				'http_referrer' => sanitize_text_field($aff_lnk_referrer),
		);
	$aff_lnk_utm_array = array_filter($aff_lnk_utm_array);
	$aff_lnk_recipe = implode("-",$aff_lnk_utm_array);
    setcookie('aff_lnk_cookie',$aff_lnk_recipe,time()+60*60*24*30, '/');
	/* This part lets you set and use the cookie on the same page */
	if(!isset($_COOKIE['aff_lnk_cookie'])){
		$_COOKIE['aff_lnk_cookie'] = sanitize_text_field($aff_lnk_recipe);
	}
  }
}
add_action('init', 'aff_lnk_bake_cookie');

//View cookie shortcode for testing purposes
function aff_lnk_shortcode ( $atts, $content = null ) {
	$content = sanitize_text_field($_COOKIE["aff_lnk_cookie"]);
	return $content;
}
add_shortcode( 'aff_lnk_view_cookie', 'aff_lnk_shortcode' );
?>