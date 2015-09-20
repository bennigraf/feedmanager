<?php
/**
 * RSS Helper class for easy output RSS structures.
 *  very much simplified bgraf-version
 *
 */

/**
 * Usage:
 * 
 */
class bRssHelper extends AppHelper {
	
	public function renderData($data = array()) {
		$myOutput = "";
		foreach ($data as $tag => $content) {
			$myContent = "";
			$props = array();
			if (is_array($content)) {
				/* check if $content has the form
					array(
						array(properties)
						array(content)
					) */
				if (!empty($content[0])) {
					foreach ($content[0] as $key => $prop) {
						$props[] = $key.'="'.$prop.'"';
					}
					if (isset($content[1])) {
						if (is_array($content[1])) {
							$myContent .= "\n".$this->renderData($content[1]);
						} else {
							$myContent .= $content[1];
						}
					}
				} else {
					$myContent .= "\n".$this->renderData($content);
				}
				
			} else {
				$myContent .= $content;
			}
			$myOutput .= '<'.$tag;
			if (!empty($props)) {
				$myOutput .= ' '.implode(' ', $props);
			}
			if (!empty($myContent)) {
				$myOutput .= '>';
				$myOutput .= $myContent;
				$myOutput .= '</'.$tag.'>'."\n";
			} else {
				$myOutput .= ' />'."\n";
			}
		}	
		return $myOutput;
	}
	
}


?>