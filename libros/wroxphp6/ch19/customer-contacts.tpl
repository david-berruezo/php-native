{include file="header.tpl" title="Widget World - Customer Contact"}
<h3>Customer Contact Report</h3>
<form action="customer-contacts.php" method="post">
 <table border="0" width="100%">
 <tr>
  <td><b>Employee Name:</b></td><td>{$user->first_name} {$user->last_name}</td>
  <td><b>Department:</b></td><td>{$user->department}</td>
 </tr> 
 <tr>
  <td><b>Number:</b></td><td>{$user->id}</td><td><b>Start Week:</b></td>
  <td><SELECT NAME="week_start">
         {html_options values=$start_weeks output=$start_weeks 
          selected=$current_start_week}
       </SELECT>
  </td>
 </tr>
</table>
<br><br>
<hr>
<p><font size="+1">
     <b>Significant Distributors and Customers Visited:</b>
    </font>
    <br>
    (also distributors/OEM/prospects)<p>
<table border="0">
{section name=idx loop=$max_weekly_contacts}{strip}
<tr>
  <td width="20"></td>
  <td><b>Company</b></td>
  <td><b>Contact</b></td>
  <td><b>City</b></td>
  <td><b>State</b></td>
  <td><b>FollowUp</b></td>
  <td><b>Literature Request</b></td>
</tr>
<tr>
  <td width="20"></td>
  <td><input name="company_name_{$smarty.section.idx.index}" 
       size="20" maxlength="50"></td>
  <td><input name="contact_name_{$smarty.section.idx.index}" 
       size="20" maxlength="50"></td>
  <td><input name="city_{$smarty.section.idx.index}" 
       size="20" maxlength="50"></td>
  <td><input name="state_{$smarty.section.idx.index}" 
       size="10" maxlength="50"></td>
  <td><input name="followup_{$smarty.section.idx.index}" 
       size="20" maxlength="2000"></td>
  <td><input name="literature_request_{$smarty.section.idx.index}" 
       size="20" maxlength="2000"></td>
</tr>
<tr>
 <td width="20"></td>
 <td colspan="7"><b>Accomplishments:</b></td>
</tr>
<tr>
 <td width="20"></td>
 <td colspan="7">
   <TEXTAREA NAME="accomplishments_{$smarty.section.idx.index}" 
      ROWS=4 COLS=95></TEXTAREA><br><br>
  </td>
</tr>
{/strip}{/section}
</table>
<br><hr>
<input type="hidden" name="action" value="persist_contact">
<br><br>
<center>
<input type="submit" name="submit" value=" Save " 
            onclick="return checkInputs(this.form);">
</center>
</form>
{include file="footer.tpl"}
