<?php


namespace App\Models;


class HasLinksModel extends Model
implements HasLinks
{

    CONST LINKSTABLE = [];
    public $links = [];

    public function getLinkTables(): array
    {
        return static::LINKSTABLE;
    }

    public function findByIdWithLinks($id)
    {
        $elem = $this->findById($id);
        $elem->fillLinks();
        return $elem;
    }

    private function fillLinks()
    {
        if ( !empty($this->getLinkTables()) )
        {
            foreach ($this->getLinkTables()  as $table=>$field)
            {
                $className = '\App\Models\\' . $table;
                if (class_exists($className))
                {
                    $elem = new $className;
                    $res = $elem->findAllByLinkId($this->id, $field);
                    $this->links[$table] = $res;
                }

            }
        }
    }

}