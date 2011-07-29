<?php
namespace faye\core\database\query\builder;

abstract class AbstractBuilder implements BuilderInterface {
    protected
        $sets    = null,
        $select  = null,
        $from    = null,
        $where   = null,
        $groupBy = null,
        $orderBy = null, $orderWay = null,
        $limit   = null, $offset  = 0,

        $type = self::SELECT_QUERY
    ;

    public function __construct () {
        $this->reset();
    }

    protected function getFieldName ($field) {
        return preg_replace ('/[AS\s+(\w)+|(SUM|COUNT|MIN|MAX|AVG)\s*\((\w+)\)]/i', '', $field);
    }

    protected function getAlias ($field) {
        if (preg_match('/AS\s+(\w+)/i', $field, $match)) {
            return $match[1];
        }

        return false;
    }

    public function getAggregate ($field) {
        if (preg_match('/(SUM|COUNT|MIN|MAX|AVG)\s*\((\w+)\)/i', $field, $match)) {
            return $match[1];
        }

        return false;
    }

    public function select () {
        foreach (func_get_args() as $field) {
            $name = $this->getFieldName($field);
            $alias = $this->getAlias($field);
            $aggregate = $this->getAggregate($field);

            $this->select->push(new namespace\node\Field($name, $alias ? $alias : null, $aggregate ? $aggregate : null));
        }

        return $this;
    }


    public function delete () {
        $this->type = self::DELETE_QUERY;

        return $this;
    }

    public function from ($entity) {
        $this->from = new namespace\node\From($entity);

        return $this;
    }

    public function insert (array $data) {
        return $this;
    }

    public function limit ($limit) {
        $this->limit = abs((int)$limit);

        return $this;
    }

    public function offset ($offset) {
        $this->offset = abs((int)$offset);

        return $this;
    }

    public function groupBy () {
        $fields = func_get_args();

        $this->groupBy->push(new namespace\node\GroupBy);

        return $this;
    }

    public function orderBy () {
        $fields = func_get_args();

        $this->orderBy->push(new namespace\node\OrderBy);

        return $this;
    }

    public function asc () {
        $this->orderWay = static::ASCENDING;

        return $this;
    }

    public function desc () {
        $this->orderWay = static::DESCENDING;

        return $this;
    }

    public function reset () {
        foreach (array('sets', 'select', 'from', 'where', 'orderBy', 'groupBy') as $prop) {
            $this->{$prop} = new ArrayList;
        }

        $this->limit = null;
        $this->offset = 0;
        $this->orderWay = null;

        return $this;
    }

    public function set ($fields, $values = null) {
        if ($values !== null) {
            $this->sets->push(new namespace\node\Set);
        } else if (is_array($fields)) {
            foreach ($fields as $field => $value) {
                $this->set($field, $value);
            }
        }

        return $this;
    }

    public function update () {
        $this->type = self::UPDATE_QUERY;

        return $this;
    }

    public function where ($fields, $value = NULL, $conjunction = 'AND') {

    }

    public function orWhere ($fields, $value = null) {
        return $this->where($fields, $value, 'OR');
    }

    public function getTree () {
        if (empty($this->tree)) {
            $this->tree = array(
                $this->select,
                $this->from,
                $this->where,
                $this->groupBy,
                $this->orderBy,
                $this->orderWay,
                $this->limit
            );
        }

        return $this->tree;
    }

    public function __toString () {
        return implode(' ', $this->getTree());
    }
}