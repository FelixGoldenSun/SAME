<?php

require "templates/functions.php";

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$questions = $_POST["questions"];
$contact = $_POST["contact"];
$product = $_POST["product"];
$products = array("Phone" => 1, "Tablet" => 2, "PC" => 3, "PSP" => 4);
$products_keys = array_keys($products);
$product_value = $product - 1;
$menu_string = selectMenu($products, $product);
$newsletter = $_POST["newsletter"];
$notify = $_POST["notify"];


if (isset($_POST["submit_button"])){

  if (empty($name)) {
    $name_error = "<div class='6u 12u(mobile)'>Name is required!</div>";
  } elseif (empty($email)) {
    $name_error = "<div class='6u 12u(mobile)'></div>";
  } else {
    $name_error = "";
  }

  if (empty($email)) {
    $email_error = "<div class='6u 12u(mobile)'>Email is required!</div>";
  } elseif (empty($name)) {
    $email_error = "<div class='6u 12u(mobile)'></div>";
  } else {
    $email_error = "";
  }

  $to = "benawalls@gmail.com";
  $subject = "Contact Form Info";
  $message = "<p>Name: $name</p>";
  $message .= "<p>Email: $email</p>";
  $message .= "<p>Phone: $phone</p>";
  $message .= "<p>Product: $products_keys[$product_value]</p>";

  $headers = "From: info@phpdev.chesthighwalls.com\r\n";
  $headers .= "Content-type: text/html\r\n";
  $headers .= "Bcc: dave.jones@scc.spokane.edu\r\n";


  if(isset($contact) && $contact == "radio_email"){
    $email_checked = "checked";
    $message .= "<p>Radio Buttons: Email checked</p>";
  }
  else if(isset($contact) && $contact == "radio_phone"){
    $phone_checked = "checked";
    $message .= "<p>Radio Buttons: Phone checked</p>";
  }

  if(isset($newsletter)){
    $newsletter_checked = "checked";
    $message .= "<p>Newsletter: Checked</p>";
  }else{
    $message .= "<p>Newsletter: Not checked</p>";
  }

  if(isset($notify)){
    $notify_checked = "checked";
    $message .= "<p>Notify: Checked</p>";
  }else{
    $message .= "<p>Notify: Not checked</p>";
  }

  mail($to, $subject, $message, $headers);

  ob_clean();
  header("location: /send_contact_thank_you.php");

}


// language="HTML"
$form = <<<END_OF_FORM
         <div class="content">
           <form method="post" action="/contactus.php">
             <div class="row 50%">
               <div class="6u 12u(mobile)">
                 <input type="text" name="name" value="$name" placeholder="Name" />
               </div>
               <div class="6u 12u(mobile)">
                 <input type="text" name="email" value="$email" placeholder="Email" />
               </div>
             </div>
              <div class="row 50%">
                    $name_error
                    $email_error
             </div>
             <div class="row 50%">
               <div class="12u">
                 <input type="text" name="phone" value="$phone" placeholder="Phone Number" />
               </div>
             </div>
             <div class="row 50%">
               <div class="12u">
                 <textarea name="questions" placeholder="Questions" rows="7">$questions</textarea>
               </div>
             </div>
             <div class="row 50%">
               <div class="6u 12u(mobile)">
                 <label>Email:</label>
                 <input type="radio" name="contact" value="radio_email" $email_checked>
                 <label> Phone:</label>
                 <input type="radio" name="contact" value="radio_phone" $phone_checked>
               </div>
               <div class="6u 12u(mobile)">
                  $menu_string
               </div>
             </div>
              <div class="row 50%">
               <div class="6u 12u(mobile)">
                 <label>Subscribe to Newsletter: </label>
                 <input type="checkbox" name="newsletter" value="newsletter" $newsletter_checked>
               </div>
               <div class="6u 12u(mobile)">
                 <label>Notify me when new products are added: </label>
                 <input type="checkbox" name="notify" value="notify" $notify_checked>
               </div>
             </div>
             <div class="row">
               <div class="12u">
                 <ul class="buttons">
                   <li><input type="submit" name='submit_button' class="special" value="Send Message" /></li>
                 </ul>
               </div>
             </div>
           </form>
         </div>
END_OF_FORM;

echo $form;

?>