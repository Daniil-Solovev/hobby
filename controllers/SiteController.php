<?php

/**
 * Class SiteController
 */
class SiteController
{
    const ARTICLES_COUNT = 5;

    /**
     * @param null $page
     * @return bool
     */
    public function actionIndex($page = null)
    {
        $model        = new Habramodel();
        $current_page = $page ? intval($page) : 1;
        $count_pages  = $model->getCountPages();
        $articles     = $model->getArticles($current_page);

        if (isAjax()) {
            $current_page = $_REQUEST['page'];
            $articles     = $model->getArticles($current_page);
            echo json_encode($articles);
            return true;
        }

        require_once(ROOT . '/views/main/index.php');
        return true;
    }

    /**
     * @return bool
     */
    public function actionModal()
    {
        if (isAjax()) {
            $post_id = $_REQUEST['post_id'];
            $model   = new Habramodel();
            $text    = $model->getArticleById($post_id);
            echo json_encode($text['full_text']);
        }
        return true;
    }


    /**
     * @return bool
     */
    public function actionLoadArticles()
    {
        if (isAjax()) {
            $url      = 'https://habr.com/ru/';
            $html     = request($url);
            $page     = phpQuery::newDocument($html);
            $articles = $page->find('.post');


            $posts = [];
            foreach ($articles as $key => $article) {
                if ($key == self::ARTICLES_COUNT) break;

                $article            = pq($article);
                $posts['title']     = $article->find('.post__title')->text();
                $posts['text']      = $article->find('.post__text')->text();
                $posts['text']      = truncate($posts['text'], 200);
                $posts['link']      = $article->find('.post__title a')->attr('href');
                $inner_page         = request($posts['link']);
                $inner_html         = phpQuery::newDocument($inner_page);
                $posts['full_text'] = $inner_html->find('.post__wrapper')->html();

//                $posts = encodeChars($posts);
                $model = new Habramodel();

                if ($model->findDuplicateArticles($posts['link'])) continue;
                $model->save($posts);
            }
        }

        return true;
    }
}