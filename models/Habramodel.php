<?php

/**
 * Class Habramodel
 */
class Habramodel
{
    const POSTS_IN_PAGE = 5;

    private $db;

    /**
     * Habramodel constructor.
     */
    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    /**
     * @param $data
     * @return bool
     */
    public function save($data = [])
    {
        $sql = 'INSERT INTO habr (title, text, link, full_text) '.
               'VALUES (:title, :text, :link, :full_text)';

        $result = $this->db->prepare($sql);
        $result->bindParam(':title',     $data['title'],     PDO::PARAM_STR);
        $result->bindParam(':text',      $data['text'],      PDO::PARAM_STR);
        $result->bindParam(':link',      $data['link'],      PDO::PARAM_STR);
        $result->bindParam(':full_text', $data['full_text'], PDO::PARAM_STR);

        return $result->execute();
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getArticleById($id)
    {
        $sql = "SELECT * FROM habr WHERE id = :id";

        $result = $this->db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $article = $result->fetch();

        return $article;
    }


    /**
     * Поиск одинаковых статей
     * @param $link
     * @return mixed
     */
    public function findDuplicateArticles($link)
    {
        $sql = "SELECT id FROM habr WHERE link = :link";

        $result = $this->db->prepare($sql);
        $result->bindParam(':link', $link, PDO::PARAM_STR);
        $result->execute();
        $article = $result->fetch();

        return $article;
    }


    /**
     * Общее количество статей
     * @return array
     */
    private function getCountArticles()
    {
        $result   = $this->db->query("SELECT COUNT(id) FROM habr");
        $articles = $result->fetch();

        return $articles['COUNT(id)'];
    }

    /**
     * Общее количество страниц
     * @return float
     */
    public function getCountPages()
    {
        $articles_count = $this->getCountArticles();
        $pages_count = ceil($articles_count / self::POSTS_IN_PAGE);

        return $pages_count;
    }

    /**
     * Для пагинации
     * Все статьи с offset
     * @param $page
     * @return array
     */
    public function getArticles($page)
    {
        $page     = intval($page);
        $offset   = ($page - 1) * self::POSTS_IN_PAGE;
        $result   = $this->db->query("SELECT * FROM habr LIMIT " . self::POSTS_IN_PAGE . ' OFFSET ' . $offset);
        $articles = $result->fetchAll();

        return $articles;
    }
}