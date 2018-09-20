<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
     <head>
          <tpl:title id="default" />
          <style type="text/css">
               .erroneous { color: red; }
          </style>
     </head>
     <body>
          <h1>Signup</h1>
               <tpl:if $success neq "">
                    <div id="submission">
                         <p class="successText">
                              <tpl:label id="success" />
                         </p>                         
                         <p class="summaryText">
                              You can unsubscribe
                              at any time by using the
                              link at the top of the emails
                              we'll send you.
                         </p>     
                         <p class="summaryText">
                              Why not visit our company web site?
                              <a href="http://www.example.com">Click here</a>
                              to go there now.
                         </p>     
                    </div>
               <tpl:else>
                    <p>
                         Hello; we'd very much like for you to sign up to our 
                         email newsletter.
                    </p>
                    <p>
                         We won't sell your email address and it's easy to
                         unsubscribe (just click on the link at the top of one
                         of our emails).
                    </p>
                    <form method="post" action="/Signup">
                         <label for="firstname"><tpl:label id=
                              "firstnamelabel" /></label>
                         <tpl:textbox id="firstname" /><br />
                         <label for="lastname"><tpl:label id=
                              "lastnamelabel" /></label>
                         <tpl:textbox id="lastname" /><br />
                         
                         <label for="email"><tpl:label id="emaillabel" /></label>
                         <tpl:textbox id="email" /><br />
                         <input type="submit" value="Sign Up" />
                         <tpl:if $status neq "">
                              <p class="errorText">
                                   <tpl:label id="status" />
                              </p>
                         </tpl:if>
                         <br /><br />
                         <i>* Required Field</i>
                    </form>                         
               </tpl:if>
                         
     </body>
</html>
