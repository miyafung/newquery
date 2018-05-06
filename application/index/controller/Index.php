<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller 
{
//和激光核聚变
    public function index()
    {
    	set_time_limit(0);
		$datas =DeleteHtml(getwebcontent('http://www.jin10.com'));

		trace($datas);

		preg_match_all('/(\d{2}:\d{2})/',$datas,$time);  /*对应的所有时间*/
		preg_match_all('/<td[^>]+?id\s*?=\s*?"content_\d+?">(.+?)<\/td>/',$datas,$content);  /*对应的所有内容*/
		preg_match_all('/"普通新闻"|"重要新闻"|"一般数据"|"重要数据"/',$datas,$importance);  /*对应的所有新闻的重要性*/
		$contents=$content[1];           /*对应的所有内容*/
		$times=$time[1];                  /*对应的所有时间*/
		$importances=$importance[0];
		$news=[];
		foreach ($contents as $key => $value) {
			$t=[
				"content"=>$value,
				"time"=>$times[$key],
				"importance"=>str_replace('"','',$importances[$key]),
			];
			array_push($news,$t);
		}
		// dump($news);
		$this->assign("News",$news);
        return $this->fetch();
    }
}
