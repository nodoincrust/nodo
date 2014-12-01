<?php
class Posts extends Controller
{
    function Posts()
    {
        parent::Controller();
    }

    function index()
    {
        $posts = $this->mongo->db->posts->find();

        foreach ($posts as $id => $post)
        {
            var_dump($id);
            var_dump($post);
        }
    }

    function create()
    {
        $post = array('title' => 'Test post');
        $this->mongo->db->posts->insert($post);
        var_dump($post);
    }
}
?>