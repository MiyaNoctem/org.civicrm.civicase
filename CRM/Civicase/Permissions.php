<?php

class CRM_Civicase_Permissions extends CRM_Core_Permission {

  /**
   * Deprecated CiviCase Permissions
   */
  const CVCASE_OLD_DELETE = 'delete in CiviCase';
  const CVCASE_OLD_ACCESS_MINE = 'access my cases and activities';
  const CVCASE_OLD_ACCESS_ALL = 'access all cases and activities';

  /**
   * New CiviCase permissions
   */
  const CVCASE_BASICVIEW_MINE = 'view basic information for cases that I manage';
  const CVCASE_VIEW_MINE = 'view all information for cases and case activities that I manage';
  const CVCASE_EDIT_MINE = 'edit cases and case activities that I manage';
  const CVCASE_DELETE_MINE = 'delete cases and case activities that I manage';
  const CVCASE_BASICVIEW_ALL = 'view basic information for all cases';
  const CVCASE_VIEW_ALL = 'view all information for all cases and case activities';
  const CVCASE_EDIT_ALL = 'edit all cases and case activities';
  const CVCASE_DELETE_ALL = 'delete in CiviCase';

  public static function getCiviCasePermissions() {
    $permissions = array();

    $civiCasePermissions = array(
      self::CVCASE_BASICVIEW_MINE => ts('WIP: Allows a user to view basic information of a case if he is the case manager.'),
      self::CVCASE_VIEW_MINE      => ts('Allows to view a case if user is defined as its manger.'),
      self::CVCASE_EDIT_MINE      => ts('Allows to edit a case if user is set as the case manager.'),
      self::CVCASE_DELETE_MINE    => ts('Allows deletion of cases and case activities if user is the case manager.'),
      self::CVCASE_BASICVIEW_ALL  => ts('WIP: Allows a user to view basic information of all cases.'),
      self::CVCASE_VIEW_ALL       => ts('Allows to view all cases and case activities.'),
      self::CVCASE_EDIT_ALL       => ts('Allows to edit all cases.'),
      self::CVCASE_DELETE_ALL     => ts('Allows deletion of all cases and case activities.')
    );

    $prefix = ts('CiviCase') . ': ';
    foreach ($civiCasePermissions as $permissionName => $description) {
      $permissions[$permissionName] = array(
        $prefix . self::getPermissionLabel($permissionName),
        $description
      );
    }

    return $permissions;
  }

  public static function getPermissionLabel($permissionName) {
  	switch ($permissionName) {
			case self::CVCASE_DELETE_ALL:
				$label = ts('delete all cases and case activities');
				break;

			default:
				$label = ts($permissionName);
		}

		return $label;
	}

  public static function isOldCasePermission($permission) {

    switch ($permission) {
      case self::CVCASE_OLD_ACCESS_ALL:
      case self::CVCASE_OLD_ACCESS_MINE:
      case self::CVCASE_OLD_DELETE:
        $isOld = TRUE;
        break;

      default:
        $isOld = FALSE;
    }

    return $isOld;
  }

  public static function permission_check($permission, $granted) {

    return $granted;
    switch ($permission) {

      case CVCASE_OLD_ACCESS_MINE:
        switch (self::determineUserIntent()) {
          case self::EDIT:
            $granted = self::permission_check();
            break;

          case self::VIEW:
            $granted = self::checkViewPermission();
            break;

          default:
            $granted = false;
        }
      break;

      case CVCASE_OLD_ACCESS_ALL:
        break;

      case CVCASE_OLD_DELETE:
        break;

      default:
        $granted = false;
    }

    return $granted;
  }

}