<?php
namespace faye\core\database\querybuilder;

class MySQL extends AbstractQueryBuilder {
    const 
        TRUE        = '1',
        FALSE       = '0',
        ORDER_ASC 	= 'ASC',
        ORDER_DESC 	= 'DESC',
        OPEN_QUOTE	= '`',
        CLOSE_QUOTE	= '`';
    
    protected function buildCondition() {
        if(empty($this->where)) {
            return NULL;
        }
        
        $wheres = array();
        foreach($this->where as $where) {
            $wheres[] = sprintf(' %s %s %s (%s)', 
                            $where['conjunction'], 
                            $this->quote($where['field']),
                            $where['operator'], 
                            $where['placeholder']);
        }

        return 'WHERE 1 ' . implode($wheres);
    }

    public function insert($data = array()) {			
        return $this->buildInsert($data);
    }

    protected function buildSelect() {
        $fields = array();
        if(empty($this->field)) {
            $fields[] = '*';
        } else {
            foreach($this->field as $field) {
                $f = $this->quote($field['fieldName']);

                if(!empty($field['aggregate'])) {
                    $f = sprintf('%s(%s) AS %s', $field['aggregate'], $f, $this->quote($field['alias']));
                }

                $fields[] = $f;
            }
        }

        $this->query = sprintf('SELECT %s FROM %s %s ', implode(', ', $fields), implode(', ', $this->from), $this->buildCondition());

        if(!empty($this->groupBy)) {
            $this->query .= sprintf('GROUP BY %s', implode(', ', $this->groupBy));
        }

        if(empty($this->orderBy) and !empty($this->orderWay) and !empty($this->entity->primaryKey)) {
            $this->orderBy[] = $this->entity->primaryKey;				
        }

        if(!empty($this->orderBy)) {
            $this->query .= sprintf('ORDER BY %s %s ', implode(', ', $this->orderBy), $this->orderWay);
        }

        if(!empty($this->limit)) {
            if(empty($this->offset)) {
                $this->offset = 0;
            }

            $this->query .= sprintf('LIMIT %d, %d', $this->offset, $this->limit);
        }

        return $this->query;
    }

    public function buildInsert() {
        if(empty($this->sets)) {
            throw new Exception('There is no data to be inserted.');
        }

        $params = '';
        foreach($data as $field => $value) {
            $params .= sprintf(':%s, ', $field);
        }

        return $this->query = sprintf('INSERT INTO %s(%s) VALUES (%s)', $this->quote($this->from[0]), implode(', ', array_keys($this->sets)), rtrim($params, ', '));
    }

    public function buildUpdate() {
        if(empty($this->sets)) {
            throw new Exception('There is no data to be updated.');
        }

        $sets = '';
        foreach(array_keys($this->sets) as $field) {
            $sets .= sprintf('%s = :v_%s, ', $this->quote($field), $field);
        }

        return $this->query = sprintf('UPDATE %s SET %s %s', $this->quote($this->from[0]), rtrim($sets, ', '), $this->buildCondition());
    }

    public function buildDelete() {
        return $this->query = sprintf('DELETE FROM %s %s', $this->quote($this->from[0]), $this->buildCondition());
    }

    public function build() {
        if(empty($this->from)) {
            throw new Exception('The entity name is empty.');
        }

        switch($this->type) {
            case self::SELECT_QUERY:
                $this->query = $this->buildSelect();
                
                break;
            case self::UPDATE_QUERY:
                $this->query = $this->buildUpdate();
                
                break;
            case self::DELETE_QUERY:
                $this->query = $this->buildDelete();
                
                break;
        }

        return $this->query;
    }
}