{if isset($MENUBAR)}{$MENUBAR}{/if}
<div id="content" class="content{if isset($MENUBAR)} contentWithMenu{/if}">
  <div class="titrePage">
    <ul class="categoryActions">
    </ul>
    <h2><a href="{$U_HOME}">{'Home'|@translate}</a>{$LEVEL_SEPARATOR}{'About'|@translate}</h2>
  </div>
  
  {include file='infos_errors.tpl'}
  
  <div id="piwigoAbout">
{* CUSTOM BEGIN *}
      <h3>Willkommen</h3>
      <h4>Wie funktioniert das und was kann ich hier machen?</h4>
      <ul>
          <li>Du kannst dir Fotos und Videos von anderen Benutzer*innen ansehen. Dafür stehen mehrere Wege zur Verfügung - sieh dich dafür einfach im Hauptmenü um.</li>
          <li>Speziell hervorzuheben ist zum Ansehen die Vollbild-Diashow, die durch ein <span class="pwg-icon pwg-icon-slideshow"></span> markiert ist.</li>
          <li>Nach erfolgreicher Registrierung erhältst du automatisch ein eigenes Album (mit deinem Benutzer*innen-Namen als Titel). Das heißt aber nicht, dass du etwas hinzufügen musst. Du kannst auch nur die bestehenden Fotos und Videos ansehen und dein Album leer lassen - dieses wird dann für andere auch gar nicht angezeigt.</li>
          <li>Wenn du möchtest kannst du eigene Fotos und Videos hinzufügen. Wir bitten dich möglichst nur Eigene hinzuzufügen und den Upload von denen, die du geschickt bekommen hast, den Menschen mit den Originalen zu überlassen. So können wir Unikate in der besten Qualität und mit den exaktesten Kontext-Informationen sammeln (siehe dazu auch den Punkt zu Meta-Informationen).</li>
          <li>Fotos und Videos hinzufügen kannst du über das Hauptmenü und in deinem Album kannst du auch Unter-Alben mit frei gewählten Titeln erstellen.</li>
          <li>Bei <b>Fragen und Anmerkungen</b> kannst du dich gerne per E-Mail melden - klicke dafür einfach auf den <b>Link ganz unten</b>. Die E-Mails werden von Wolfram und Pino beantwortet.</li>
      </ul>
      <h4>Wie kann ich auf die Fotos und Videos zugreifen?</h4>
      <ul>
          <li>Du kannst die Webseite sowohl auf großen Geräten (Desktop-PC oder Laptop) als auch am Tablet oder Smartphone benützen.</li>
          <li>Für iOS Geräte (iPhone und iPad) als auch für Android steht eine App im App-Store zur Verfügung. Du kannst die App mit dem Namen <i>Piwigo</i> herunterladen und dich mit deinem Benutzer*innen-Namen und Passwort sowie der Webseiten-Adresse <i>einfachgluecklichsein.at</i> verbinden.</li>
          <li>Die App für iOS ist sehr schön gestaltet und zu empfehlen, die App für Android leider nicht so sehr.</li>
      </ul>
      <h4>Meta-Informationen wie Titel, Beschreibung und Autor*in</h4>
      <ul>
          <li>Meta-Informationen zu Fotos und Videos können dabei helfen, den Kontext von diesen besser zu verstehen.</li>
          <li>Fotos und Video können zum Beispiel in einer Kalender-Ansicht (nach Aufnahmedatum) und als Pins auf einer Landkarte angesehen werden. Diese Ansichtsvarianten finden sich auf der Startseite und in einzelnen Alben rechts oben.</li>
          <li>Titel, Beschreibung und Autor*in können im Hochladen Prozess durch Klicken auf <i>Beschreibung hinzufügen</i> gesetzt werden (wobei Autor*in durch den Benutzer*innen-Namen vorausgefüllt wird).</li>
          <li>Weitere Meta-Informationen werden automatisch gesetzt, soweit diese in der Foto- oder Video-Datei vorhanden sind. Dazu gehören unter anderem Aufnahmedatum und Ort der Aufnahme.</li>
          <li>Der Titel kann auch im Nachhinein noch gesetzt werden (die anderen Informationen leider nicht). Wenn ein Foto geöffnet ist, kann dieser in der Werkzeugleiste und neben dem Titel mit diesem Symbol <span class="pwg-icon pwg-icon-edit"></span> geändert werden.</li>
      </ul>
      <h4>Limitierungen bei Videos</h4>
      <ul>
          <li>Um den Speicher nicht zu überlasten, können nur Videos mit einer Maximalgröße von 100 MB hochgeladen werden.</li>
          <li>Das Video hochladen funktioniert leider nur mit gewissen Formaten (siehe Hochladen Seite). Für Android Geräte empfehlen wir den Upload auf der Webseite, für iOS Geräte den Upload in der <i>Piwigo</i> App.</li>
      </ul>
      <p></br></p>
      <p>Diese Fotogalerie basiert auf Piwigo.</p>
      <p>Piwigo ist eine Fotogaleriesoftware für das Internet, die von einer Gemeinschaft engagierter Nutzer*innen und Programmierer*innen entwickelt wird. Erweiterungen machen Piwigo leicht anpassbar an die verschiedensten Bedürfnisse. Und das Tüpfelchen auf dem i: Piwigo ist frei und quelloffen.</p>
      <p id="linkToPiwigo"><a href="http://de.piwigo.org" style="text-decoration: underline;">Besuche die Piwigo-Webseite!</a></p>
{* CUSTOM END *}
  </div>
</div>
