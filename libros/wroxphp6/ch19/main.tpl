{include file="header.tpl" title="Widget World Menu"}
Welcome {$user->first_name} the {$user->role}!
<table border="0" cellspacing="8" cellpadding="8">
{strip}
{section name=security show=$user->isAccountant()}
  <tr><td><h3>Accountant functionality goes here.</h3></td></tr>
{/section}
  <tr>
    <td valign="top">
      <h3><a href="travel-expenses.php">New Travel Expenses</a></h3>
    </td>
  </tr>
  <tr>
     <td valign="top">
       <h3><a href="customer-contacts.php">New Customer Contacts</a></h3>
     </td>
  </tr>
{/strip}
</table>
{include file="footer.tpl"}