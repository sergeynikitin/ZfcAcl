<?php

namespace ZfcUserAcl\Model\Mapper;

use ZfcUserAcl\Module as ZfcUserAcl,
    ZfcUserAcl\Model\Role as RoleModel,
    ZfcBase\Mapper\DbMapperAbstract;

class RoleZendDb extends DbMapperAbstract implements Role
{
    protected $tableName = 'role';

    public function save(RoleModel $role)
    {
        $data = array(
            'role_id' => $role->getRoleId(),
            'name' => $role->getName(),
            'priority' => $role->getPriority()
        );

        $db = $this->getWriteAdapter();
        return $db->insert($this->getTableName(), $data);
    }

    public function getAllRoles()
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from($this->getTableName());

        $rows = $db->fetchAll($sql);

        $modelClass = ZfcUserAcl::getOption('role_model_class');
        $models = array();

        foreach ($rows as $row) {
            $models[] = $modelClass::fromArray($row);
        }

        return $models;
    }
}
