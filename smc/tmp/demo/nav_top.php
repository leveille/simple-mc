<table cellpadding="0" cellspacing="1" border="0" style="margin-top:61px">
<tr>
   <td width="84">&nbsp;</td>
   <td width="84"><a href="index.php" id="menu_item">Home</a></td>
   <td width="84"><a href="consulting.php" id="menu_item" onmouseover="show('services_layer','','show');" onmouseout="show('services_layer','','hide');">Services</a></td>
   <!-- td width="84"><a href="news.php" id="menu_item">News</a></td -->
   <td width="84"><a href="careers.php" id="menu_item" onmouseover="show('careers_layer','','show');" onmouseout="show('careers_layer','','hide');">Careers</a></td>
   <td width="84"><a href="referral.php" id="menu_item" onmouseover="show('referrals_layer','','show');" onmouseout="show('referrals_layer','','hide');">Referrals</a></td>
   <td width="84"><a href="contact.php" id="menu_item">Contact</a></td>
</tr>
</table>

<!-- SERVICES MENU -->
<div style="position:absolute; width:0px; height:0px; z-index:100;">
   <div id="services_layer" onmouseover="show('services_layer','','show');" onmouseout="show('services_layer','','hide');" style="position:relative; left:430px; top:-1px; height: 50px; background-color: white; width:150px; z-index:100; display: none;"> 
      <div class="menu"><a href="consulting.php">IT Consulting</a></div>
      <div class="menu"><a href="staffing.php">IT Staffing</a></div>
      <div class="menu"><a href="teaming.php">IT Teaming</a></div>
   </div>
</div>

<!-- CAREERS MENU -->
<div style="position:absolute; width:0px; height:0px; z-index:100;">
   <div id="careers_layer" onmouseover="show('careers_layer','','show');" onmouseout="show('careers_layer','','hide');" style="position:relative; left:515px; top:-1px; height: 70px; background-color: white; width:175px; z-index:100; display: none;"> 
      <div class="menu"><a href="careers.php">In-house Careers</a></div>
      <div class="menu"><a href="openings.php">Current Openings</a></div>
      <div class="menu"><a href="emp_benefits.php">Benefits</a></div>
      <!-- div class="menu"><a href="freq_emp.php">Frequent Employee Program</a></div -->
      <div class="menu"><a href="interview.php">Career Tips</a></div>
      <!-- div class="menu"><a href="#">Online Registration</a></div -->
      <!-- div class="menu"><a href="#">Salary Calculator</a></div -->
   </div>
</div>

<!-- REFERRALS MENU -->
<div style="position:absolute; width:0px; height:0px; z-index:100;">
   <div id="referrals_layer" onmouseover="show('referrals_layer','','show');" onmouseout="show('referrals_layer','','hide');" style="position:relative; left:600px; top:-1px; height: 50px; background-color: white; width:150px; z-index:100; display: none;"> 
      <div class="menu"><a href="proj_referral.php">Project Referrals</a></div>
      <div class="menu"><a href="referral.php">Consultant Referrals</a></div>
      <div class="menu"><a href="self_referral.php">Self Referrals</a></div>
   </div>
</div>
