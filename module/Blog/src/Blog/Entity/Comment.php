<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="article", columns={"article"})})
 * @ORM\Entity
 */
class Comment
{
    /** 
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Annotation\Type("Zend\Form\Element\Hidden")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="user_mail", type="string", length=50, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Email")
     * @Annotation\Options({"label":"Email"})
     * @Annotation\Required({"required":"true"})
     * @Annotation\Attributes({"id":"user_email","class":"form-control","required":"required"})
     * @Annotation\Validator({"name": "EmailAddress"})
     * 
     */
    private $userMail;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     * @Annotation\Type("Zend\Form\Element\TextArea")
     * @Annotation\Required({"required":"true"})
     * @Annotation\Filter({"name":"StripTags"}) 
     * @Annotation\Attributes({"id":"user_comment","class":"form-control","required":"required"})
     * @Annotation\Options({"label":"Комментарий"})
     * @Annotation\Validator({"name": "StringLength","options":{"min":11,"max":30}})
     */
    private $comment;

    /**
     * @var \Blog\Entity\Article
     *
     * @ORM\ManyToOne(targetEntity="Blog\Entity\Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article", referencedColumnName="id")
     * })
     * @Annotation\Options({"label":"Комментарий"})
     */
    private $article;

    /**
     * @Annotation\Type("Zend\Form\Element\Submit")
     * @Annotation\Attributes({"value":"Сохранить","id":"btn_submit","class":"btn btn-primary"})
     * @Annotation\AllowEmpty({"allowempty":"true"}) 
     */
    public $submit;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userMail
     *
     * @param string $userMail
     *
     * @return Comment
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;

        return $this;
    }

    /**
     * Get userMail
     *
     * @return string
     */
    public function getUserMail()
    {
        return $this->userMail;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set article
     *
     * @param \Blog\Entity\Article $article
     *
     * @return Comment
     */
    public function setArticle(\Blog\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Blog\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
