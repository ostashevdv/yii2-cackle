<?php

namespace ostashevdv\cackle\commands;

use ostashevdv\cackle\models\Comment;
use yii\db\IntegrityException;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\console\Controller;

class CommentController extends Controller
{
    public function actionSync()
    {
        $since = strtotime(Comment::find()->max('modified'));

        $this->curlInit();
        $url = $this->getUrl();
        $result = $this->curlExec($url);
        $comments = Json::decode($result);
        $this->saveComments($comments['comments']['content']);
        if($comments['comments']['totalPages']>1) {
            for($i=1; $i<$comments['comments']['totalPages']; $i++) {
                $url = $this->getUrl($since, $i);
                $result = $this->curlExec($url);
                $comments = Json::decode($result);
                $this->saveComments($comments['comments']['content']);
            }
        }
    }


    public static function getUrl($modified=null, $page=null)
    {
        $cfg = \Yii::$app->getModule('cackle');
        $url = "http://cackle.me/api/2.0/comment/list.json?".
        "id={$cfg->siteId}&" .
        "accountApiKey={$cfg->accountAPIKey}&" .
        "siteApiKey={$cfg->siteAPIKey}&" .
        "modified={$modified}" .
        "&page={$page}";

        return $url;
    }
    /**
     * Обертка над соединениями в curl.
     * Т.к. может быть несколько страниц с комментариями, то 1 раз инициализируем соединение,
     * а закроем его в самом конце.
     */
    protected $ch;
    protected function curlInit()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['Content-type: application/x-www-form-urlencoded; charset=utf-8']);
    }
    protected function curlExec($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return curl_exec($this->ch);
    }
    protected function curlClose()
    {
        curl_close($this->ch);
    }
    
    /**
     * Сохранение комментариев в бд.
     * Если комментарий с таким id уже имеется, то выполняется обновление
     * @param array() $comments 
     */
    protected function saveComments($comments)
    {
        foreach($comments as $comment) {
            $q = \Yii::$app->db->createCommand();
            $comment['channel'] = strtr($comment['channel'], [
                    '/fullnews_'=>'/news/',
                    '.html' => '/'
                ]);
            try {
                $q->insert(Comment::tableName(),[
                        'id'        => $comment['id'],
                        'channel'   => $comment['channel'],
                        'comment'   => $comment['message'],
                        'date'      => $comment['created'],
                        'autor'     => $comment['author']['name'] ? :'',
                        'email'     => $comment['author']['email']? :'',
                        'avatar'    => $comment['author']['avatar']? :'',
                        'ip'        => $comment['ip'],
                        'approve'   => ( strtolower($comment['status'])=='approved') ? 1 : 0,
                        'user_agent'=> StringHelper::truncate($comment['userAgent'], 64),
                        'modified'  => $comment['modified'],
                    ])->execute();
            } catch(IntegrityException $e){
                $q->update(Comment::tableName(),[
                        'comment'   => $comment['message'],
                        'date'      => $comment['created'],
                        'autor'     => $comment['author']['name'] ? :'',
                        'email'     => $comment['author']['email']? :'',
                        'avatar'    => $comment['author']['avatar']? :'',
                        'ip'        => $comment['ip'],
                        'approve'   => ( strtolower($comment['status'])=='approved') ? 1 : 0,
                        'user_agent'=> StringHelper::truncate($comment['userAgent'], 64),
                        'modified'  => $comment['modified'],
                    ],
                    [
                        'id'=>$comment['id']
                    ]);
            }
        }
    }
}
