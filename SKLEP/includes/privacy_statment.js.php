<script type="text/javascript" language="javascript"><!-- 
function rowOverEffect(object) {
  document.create_account.elements[object].parentNode.parentNode.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (document.create_account.elements[object].checked) {
    document.create_account.elements[object].parentNode.parentNode.className = 'moduleRowSelected';
  } else {
    document.create_account.elements[object].parentNode.parentNode.className = 'moduleRow';
  }
}

function checkboxRowEffect(object) {
  document.create_account.elements[object].checked = !document.create_account.elements[object].checked;
  if(document.create_account.elements[object].checked) {
    document.create_account.elements[object].parentNode.parentNode.className = 'moduleRowSelected';
  } else {
    document.create_account.elements[object].parentNode.parentNode.className = 'moduleRowOver';
  }
}

function check_form_wrapper(formname) {
  if (check_form(formname)) {
    if (formname.elements['agree'].checked) {
      return true;
    } else {
      alert('<?php echo ENTRY_PRIVACY_AGREEMENT_ERROR; ?>');
      submitted = false;
      return false;
    }
  } else {
    formname.elements['agree'].checked = false;
    return false;
  }
}
//--></script>