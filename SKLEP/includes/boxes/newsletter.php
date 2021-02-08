<?php
if (!tep_session_is_registered('customer_id')) {
?>
<script language="JavaScript1.2" type="text/javascript">
        function verify(form)
        {
           var passed = false;
        var blnRetval, intAtSign, intDot, intComma, intSpace, intLastDot, intDomain, intStrLen;
        if (form.Email){
                       intAtSign=form.Email.value.indexOf("@");
                        intDot=form.Email.value.indexOf(".",intAtSign);
                        intComma=form.Email.value.indexOf(",");
                        intSpace=form.Email.value.indexOf(" ");
                        intLastDot=form.Email.value.lastIndexOf(".");
                        intDomain=intDot-intAtSign;
                        intStrLen=form.Email.value.length;
                // *** CHECK FOR BLANK EMAIL VALUE
                   if (form.Email.value == "" )
                   {
                alert("Nie wprowadzono adresu email.");
                form.Email.focus();
                passed = false;
                }
                // **** CHECK FOR THE  @ SIGN?
                else if (intAtSign == -1)
                {

                alert("W adresie email brakuje \"@\".");
                        form.Email.focus();
                passed = false;

                }
                // **** Check for commas ****

                else if (intComma != -1)
                {
                alert("Adres email nie moze zawierac przecinka.");
                form.Email.focus();
                passed = false;
                }

                // **** Check for a space ****

                else if (intSpace != -1)
                {
                alert("Adres email nie moze zawierac spacji.");
                form.Email.focus();
                passed = false;
                }

                // **** Check for char between the @ and dot, chars between dots, and at least 1 char after the last dot ****

                else if ((intDot <= 2) || (intDomain <= 1)  || (intStrLen-(intLastDot+1) < 2))
                {
                alert("Wprowadz poprawny adres email.\n" + form.Email.value + " nie jest poprawny.");
                form.Email.focus();
                passed = false;
                }
                else {
                        passed = true;
                }
        }
        else    {
                passed = true;
        }
        return passed;
  }
        //-->
</script>


          <tr>
            <td style="	border: 1px solid #D0D0D0;">
			
			
			<div id="box_newsletter"><?php 

	echo '<div class="headPosW">Newsletter</div>';

	echo '<div id="fkosz">';
?>
<?php echo '<form name="newsletter" action="' . tep_href_link(FILENAME_NEWSLETTERS_SUBSCRIBE, '', 'NONSSL') . '" method="post" onSubmit="return verify(this);">'; ?>
	
	<input type="text" name="firstname" value="imiê" onClick="javascript: if(this.value=='imiê')this.value=''" checked size="15" maxlength="35" style="width:120px;" class="inputGray" />
	<br><?php echo tep_draw_separator('pixel_trans.gif',1,3);?><br />
	<input type="text" name="Email" value="adres e-mail" onClick="javascript: if(this.value=='adres e-mail')this.value=''" checked size="15" maxlength="35" style="width:120px;" class="inputGray" />
<?php
	echo '</div>';
	
	echo '<div id="bnewsletter">';
echo tep_image_submit('button_zapisz.gif');
	echo '</div></form></div>';
?>
            </td>
          </tr>


<?php

	echo '<tr><td class="sep"></td></tr>';

}
?>