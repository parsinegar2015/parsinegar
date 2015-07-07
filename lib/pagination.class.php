<?php

/**
 * Pageination Class
 * @records count
 * @items per page
 * @pagination button per page
 * @current page number (active button)
 * @options for config pagination button style and set page address
 *
 * Helps you to layout your content and publish blog! :)
 * 
 * @author Ali Smith [ali.online@ymail.com || parsnet4u@gmail.com]
 * @version 1.0 Beta
 * @copyright (c) 2013, Ali Smith
 * 
 */

class pagination{
	
	private $pages;
	private $links_set;
	private $link_count;
	private $links;
	private $current_page;
	private $options;
	
	public function __construct(){}
	
	public function init($total,$item,$link,$n,$options=''){
		
		$this->pages = ceil($total/$item);
		$this->links_set = ceil($this->pages/$link);
		$this->link_count = $link;
		$this->current_page = $n;
		$this->options = $options;
		$this->createLink();
		
		}
		
	private function createLink(){
		
		for($i=1; $i<=$this->links_set; $i++){
			$x = 0;
			if($i>1){
				$x = (int) ($i-1)*$this->link_count;
				}
			
			if($this->pages >= $this->link_count){
			 for($j=1; $j<=$this->link_count; $j++){
			   $num = $j+$x;
			   if($num > $this->pages){
			    break;
			   }
				$this->links[$i][] = $num;
				}
			}else{
			   for($j=1; $j<=$this->pages; $j++){
				$this->links[$i][] = $j+$x;
				}	
				}
			
				
			}
		
		}
	
	public function displayLink(){
		
		for($i=1; $i<=$this->links_set; $i++){
			$scope[] = $i*$this->link_count;
			}
			
			foreach($scope as $d){
				if($this->current_page <= $d){
					$x = ceil($d/$this->link_count);
					return $this->htmlLink($this->links[$x],$this->current_page,($x+1),($x-1));
					}
				}
		
		}
	
	private function htmlLink($links,$n,$next,$previous){
		$ret = array();
		$options = $this->options($this->options);
		
		$info = $options['info'];
		$template = $options['template'];
		$currentItemTemplate = $options['currentitemtemplate'];
		$url = $options['url'];
		$continer = $options['continer'];
		if(!empty($info)){
			$info = str_replace('{totalPages}',$this->pages,$info);
			}
		$previous = $this->navigation($previous,'&lt&lt',$url,$template,$info);
		if($previous){
		 $ret[] = $previous;
		}
		$first = false;
		$last = false;
		for($ix = 0; $ix < count($links); $ix++){
		
		$link_num = $links[$ix];
		$link = $links[$ix];
		
		if(!$first){
		if($ix == 0){
		 $link = '&lt';
		 $link_num = ceil($n-1);
		 if($link_num <= 0){
		 $link_num = 1;
		 }
		 $ix = -1;
         $first = true;		 
		 }
		}
		if(!$last){
		if($ix == (count($links) - 1)){
		$ix = $ix - 1;
		$last = true;
		}
		}else{
		if($ix == (count($links) - 1)){
		$link = '&gt';
		$link_num = ceil($n+1);
		if($link_num > $links[$ix]){
		 $link_num = $links[$ix];
		 }
		}
		}
			
			$l = $url;
			$l = str_replace("{number}",$link_num,$l);
			if($link == $n){
				$t = str_replace("{url}",$l,$currentItemTemplate);
				$t = str_replace("{number}",$link,$t);
				}else{
					$t = str_replace("{url}",$l,$template);
					$t = str_replace("{number}",$link,$t);
					}
				if($info){
					$i = str_replace('{currentPage}',$link_num,$info);
					$t = str_replace('{info}',$i,$t);
					 }		
					 
				$ret[] = $t;	
			
			}
            $next = $this->navigation($next,'&gt&gt',$url,$template,$info);
			if($next){
			$ret[] = $next;
			}
		 if(!empty($ret)){
			 return str_replace('{pagination}',implode($options['separator'],$ret),$continer); 
			 }else{
				 return false;
				 }
		}
	
	private function navigation($x,$target,$url,$template,$info){
	if(isset($this->links[$x])){
			 $l = $url;
			 $l = str_replace("{number}",$this->links[$x][0],$l);
			 $t = str_replace("{url}",$l,$template);
			 $t = str_replace("{number}",$target,$t);
			 if($info){
					$i = str_replace('{currentPage}',$this->links[$x][0],$info);
					$t = str_replace('{info}',$i,$t);
					 }
			 return $t;		 
			}
			return false;
	}
	
	private function options($options){
            $options = array_change_key_case($options,CASE_LOWER);
			$ret = array();
			$ret['template'] = (is_array($options) && isset($options['template']) && !empty($options['template']))? $options['template'] : '<li><a href="{url}" title="{info}">{number}</a></li>';
			$ret['info'] = (is_array($options) && isset($options['info']) && !empty($options['info']))? $options['info'] : 'page {currentPage} of {totalPages}';
			$ret['currentitemtemplate'] = (is_array($options) && isset($options['currentitemtemplate']) && !empty($options['currentitemtemplate']))? $options['currentitemtemplate'] : '<li class="active"><a href="{url}" title="{info}">{number}</a></li>';
			$ret['separator'] = (is_array($options) && isset($options['separator']) && !empty($options['separator']))? $options['separator'] : "\n";
			$urlParameters = (is_array($options) && isset($options['urlparameters']) && !empty($options['urlparameters']))? $options['urlparameters'].'&' : '';
			$ret['url'] = (is_array($options) && isset($options['url']) && !empty($options['url']))? $this->baseUrl($options['url']."?".$urlParameters."page={number}") : $this->baseUrl("?".$urlParameters."page={number}",0);
			
			if(is_array($options) && isset($options['continer']) && strstr($options['continer'],'{pagination}')){
				$ret['continer'] = $options['continer'];
				}else{
				 $ret['continer'] = '<ul class="pagination">{pagination}</ul>';	
				}
			
			return $ret;
		}
	
	
	public static function page($row_number,$itemppage){
	 if($row_number <= $itemppage){
	  return 1;
	 }
	 return ceil($row_number/$itemppage);
	}
	
	private function baseUrl($target,$lvl=1){
		
		$server_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';  
        $server_port = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80;  
        $scheme = ($server_https || $server_port) ? 'https://' : 'http://';  	
        $host = $_SERVER['HTTP_HOST'];
        $path = trim(filter_var($_SERVER['PHP_SELF'],FILTER_SANITIZE_STRING)); //$_SERVER['PHP_SELF'];
        $pArr = explode('/',$path);
        $len = count($pArr);
        $len = $len - $lvl;
        $path = implode('/',array_slice($pArr,0,$len));
		
		$url = $scheme.$host.$path.$target;
		
		return $url;
}
	
	}

?>