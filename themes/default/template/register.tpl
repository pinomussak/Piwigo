{if isset($MENUBAR)}{$MENUBAR}{/if}
<div id="registerPage">

<div id="content" class="content{if isset($MENUBAR)} contentWithMenu{/if}">

<div class="titrePage">
	<ul class="categoryActions">
	</ul>
	<h2><a href="{$U_HOME}">{'Home'|@translate}</a>{$LEVEL_SEPARATOR}{'Registration'|@translate}</h2>
</div>

{include file='infos_errors.tpl'}

<form method="post" action="{$F_ACTION}" class="properties" name="register_form">
  <fieldset>
    <legend>{'Enter your personnal informations'|@translate}</legend>

    <ul>
      <li>
        <span class="property">
          <label for="login">Benutzername</label> {* CUSTOM *}
        </span>
        <input type="text" name="login" id="login" value="{$F_LOGIN}" >
      </li>
      <li>
        <span class="property">
          <label for="password">Passwort</label> {* CUSTOM *}
        </span>
        <input type="password" name="password" id="password" >
      </li>
      <li>
        <span class="property">
          <label for="password_conf">Passwort bestätigen</label> {* CUSTOM *}
        </span>
        <input type="password" name="password_conf" id="password_conf" >
      </li>
      <li>
        <span class="property">
          <label for="mail_address">E-Mail Adresse</label> {* CUSTOM *}
        </span>
        <input type="text" name="mail_address" id="mail_address" value="{$F_EMAIL}" >
      </li>
      <li>
        <span class="property">
          <label for="send_password_by_mail">{'Send my connection settings by email'|@translate}</label>
        </span>
        <input type="checkbox" name="send_password_by_mail" id="send_password_by_mail" value="1">
      </li>
      <li class="captcha-container">
        <div class="h-captcha" data-sitekey="660c9903-ddf5-49a8-aeae-72fac63fb3ae"></div>
      </li>
    </ul>

  </fieldset>

  <p class="bottomButtons">
		<input type="hidden" name="key" value="{$F_KEY}" >
    <input class="submit" type="submit" name="submit" value="{'Register'|@translate}">
    <input class="submit light-button" type="reset" value="{'Reset'|@translate}"> {* CUSTOM *}
  </p>

</form>

<script type="text/javascript"><!--
document.register_form.login.focus();
//--></script>
{* CUSTOM BEGIN *}
<script src='https://www.hCaptcha.com/1/api.js' async defer></script>
{* CUSTOM END *}

</div> <!-- content -->
</div> <!-- registerPage -->
