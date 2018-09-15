<?php
class jayson_DFS_Extend_XenForo_ControllerPublic_Register extends XFCP_jayson_DFS_Extend_XenForo_ControllerPublic_Register {
    protected function _completeRegistration(array $user, array $extraParams = array()) {
        $signature = XenForo_Application::get('options')->jayson_dfs_signature;
        if (!empty($signature)) {
            $vars = array(
                '{username}' => $user['username'],
                '{user_id}' => $user['user_id'],
                '{email}' => $user['email'],
                '{gender}' => $user['gender'],
                '{timezone}' => $user['timezone']
            );
            $customFields = XenForo_Model::create('XenForo_Model_UserField')->getUserFieldValues($user['user_id']);
            foreach ($customFields as $customField => $value) {
                $vars["{customField.{$customField}}"] = $value; 
            }
            $signature = strtr($signature, $vars);
            $writer = XenForo_DataWriter::create('XenForo_DataWriter_User');
            $writer->setExistingData($user);
            $writer->set('signature', $signature);
            $writer->save();
        }
        return parent::_completeRegistration($user, $extraParams);
    }
}