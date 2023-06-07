<?php

declare(strict_types=1);

namespace App\Models\Entity;

class Organization
{
    /** @var integer $id */
    private $id = 1;

    /** @var string $name */
    private $name = "ACD WEBDEV";

    /** @var string $site */
    private $site = 'https://antoniocarlosdona';

    /** @var string $description */
    private $description = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio iusto aperiam voluptate consequuntur, id officiis soluta asperiores repudiandae dolor perspiciatis illum ab possimus nobis! Eaque placeat asperiores sed ex fugiat.';

    /** @var string $situation */
    private $situation = 'Cadastro Ativo';
    
    /**
     * getId
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }    

    /**
     * getName
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
        
    /**
     * getSite
     *
     * @return string
     */
    public function getSite(): string
    {
        return $this->site;
    }
        
    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
        
    /**
     * getSituation
     *
     * @return string
     */
    public function getSituation(): string
    {
        return $this->situation;
    }
}
