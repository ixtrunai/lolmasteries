#LoL Masteries
LoL API Challenge, 2016<br>
<img align="right" width='420' src="http://lolmasteries.esy.es/images/others/index.jpg"></img>
You can view a live demo <a href='http://lolmasteries.esy.es/'>here</a><br>
I´ll do the description in Spanish because I don´t know how to explain myself in English.<br>
Note: The webpage has an English translation which can have some errors. You can check it on <a href='https://github.com/ixtrunai/lolmasteries/blob/master/public_html/lang/lang.en.php'>/public_html/lang/lang.en.php</a><br>


Esta página ha sido desarrollada para su participación en el concurso de la API de Riot. <br>
Aunque la página no esta acabada en la fecha de finalización del concurso, seguiré con su desarrollo.<br>
Es muy probable que la información del top jugadores no sea correcta, esta será más precisa cuándo se hayan realizado más búsquedas en la página.

#Index.php
<img align="right" width='420' src="http://lolmasteries.esy.es/images/others/index1.jpg"></img>
Esta es la página principal, desde ella podrás realizar una búsqueda del invocador que quieras y tendrás dos opciones.<br>
Si pulsas la opción "Maestrías de campeones", se te mostrará en una tabla todos los campeones que ha jugado desde que se introdujo el sistema de maestrías y sus respectivos niveles. Además, toda la información mostrada en la tabla se guardará en la base de datos.<br>
Si pulsas la opción "Buscar en partida", el sistema te redirigirá a livegame.php.


#Livegame.php
<img align="right" width='420' src="http://lolmasteries.esy.es/images/others/livegame.jpg"></img>
Esta página es la encargada de mostrar la información de aquellos invocadores que se encuentran en una partida. Desde aquí podrás ver el nivel que tiene cada uno con el campeón que esta jugando en la partida.

#Matchistory.php
A la izquierda aparecerán dos cuadros, uno para buscar otro invocador y otro que nos mostrará algunas estadisticas sobre las partidas jugadas con el campeon, basadas en las últimas 10 partidas (o menos, en caso de que no haya 10 partidas).
A la derecha se cargarán los datos de las últimas 3 partidas (o menos, en caso de que no haya 3 partidas).
Al hacer scroll, la página cargará otras 3 partidas siguiendo el siguiente proceso para cada iteración:
<img align="right" width='420' src="http://lolmasteries.esy.es/images/others/matchistory.jpg"></img>
<ol>
  <li>Se hace una consulta a la API con el ID de partida</li>
  <li>Se obtiene la lista de participantes de la partida</li>
  <li>Por cada participante se obtiene la lista de campeones y sus maestrias (la misma info. que se obtendría al buscar un invocador desde index.php</li>
  <li>Se guarda dicha información en la BDD</li>
  <li>Se imprime la información de la partida</li>
</ol>
La idea original era hacer esto con todas las partidas (incluyendo la primeras 3), pero esto ralentizaba mucho la carga de la página, por lo que he optado por hacerlo una vez cargada la página con las primeras tres partidas.
La información guardada en la BDD se utilizará posteriormente en leaderboards.php.

#Leaderboards.php
<img align="right" width='420' src="http://lolmasteries.esy.es/images/others/leaderboards.jpg"></img>
Esta página recoge información de una base de datos propia y según los datos guardados mostrará a aquellos jugadores que más puntos de maestría tengan con cada campeón.<br>
Si crees que deberías de aparecer en esta página con algún campeón y no estas, realiza una búsqueda de tu nombre de invocador desde index.php seleccionando la opción "Maestrías de campeones".

#Tecnologias usadas:
<ul>
  <li><a href='http://getbootstrap.com/'>Bootstrap</a></li>
  <li><a href='https://jquery.com/'>JQuery</a></li>
  <li><a href='http://www.mysql.com/'>MySQL</a></li>
</ul>
  Otras:<br>
<ul>
  <li><a href='https://github.com/kevinohashi/php-riot-api'>PHP-RIOT-API</a></li>
  <li><a href='https://datatables.net/'>DataTables</a></li>
</ul>
Hosting gratuito por: <a href='http://www.hostinger.es'>www.hostinger.es</a>
