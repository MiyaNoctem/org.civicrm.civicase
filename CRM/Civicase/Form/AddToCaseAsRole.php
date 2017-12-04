<?php

class CRM_Civicase_Form_AddToCaseAsRole extends CRM_Contact_Form_Task {
  public function buildQuickForm() {
    $formBuilder = new CRM_Civicase_FormBuilder($this);
    $formBuilder->build();
  }

  public function postProcess() {
    $values = $this->controller->exportValues();

    $caseId = (int)$values['assign_to'];
    $roleTypeId = (int)$values['role_type'];
    $contacts = $this->_contactIds;

    $clients = CRM_Case_BAO_Case::getCaseClients($caseId);

    $params = array(
      'contact_id_a' => $clients[0],
      'contact_id_b' => $contacts,
      'case_id' => $caseId,
      'relationship_type_id' => $roleTypeId
    );

    CRM_Contact_BAO_Relationship::createMultiple($params, 'a');

    $url = CRM_Utils_System::url(
      'civicrm/contact/view/case',
      sprintf('cid=%d&id=%d', $clients[0], $caseId)
    );
    CRM_Utils_System::redirect($url);
  }
}
