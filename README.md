#LoL Masteries
LoL API Challenge, 2016<br>
You can view a live demo <a href='http://lolmasteries.esy.es/'>here</a><br>
I´ll do the description in Spanish because I don´t know how to explain myself in English.<br>
Note: The webpage has an English translation which can have some errors. You can check it on <a href='https://github.com/ixtrunai/lolmasteries/blob/master/public_html/lang/lang.en.php'>/public_html/lang/lang.en.php</a><br>

Esta página ha sido desarrollada para su participación en el concurso de la API de Riot. <br>
Aunque la página no esta acabada en la fecha de finalización del concurso, seguiré con su desarrollo.<br>
Es muy probable que la información del top jugadores no sea correcta, esta será más precisa cuándo se hayan realizado más búsquedas en la página.

#Index.php (página finalizada)
Una vez que buscamos un invocador desde la página, se cargará una tabla con todos los campeones usados por dicho invocador
desde que si implementó el sistema de maestrías. Todos los datos de esta tabla se obtendrán siempre mediante consultas a la API<br>
Además, la página web almacenará TODA la información mostrada en la tabla en una base de datos (BDD) para su posterior uso en
la página de TOP Jugadores.

Si haces click sobre cualquier campeón se cargará otra página mostrando datos sobre las últimas tres rankeds jugadas con dicho campeón.

#Matchistory.php (página finalizada)
A la izquierda aparecerán dos cuadros, uno para buscar otro invocador y otro que nos mostrará algunas estadisticas sobre las partidas jugadas con el campeon, basadas en las últimas 10 partidas (o menos, en caso de que no haya 10 partidas).

A la derecha se cargarán los datos de las últimas 3 partidas (o menos, en caso de que no haya 3 partidas).
Al hacer scroll, la página cargará otras 3 partidas siguiendo el siguiente proceso para cada iteración:
<ol>
  <li>Se hace una consulta a la API con el ID de partida</li>
  <li>Se obtiene la lista de participantes de la partida</li>
  <li>Por cada participante se obtiene la lista de campeones y sus maestrias (la misma info. que se obtendría al buscar un invocador desde index.php</li>
  <li>Se guarda dicha información en la BDD</li>
  <li>Se imprime la información de la partida</li>
</ol>
La idea original era hacer esto con todas las partidas (incluyendo la primeras 3), pero esto ralentizaba mucho la carga de la página, por lo que he optado por hacerlo una vez cargada la página con las primeras tres partidas.
La información guardada en la BDD se utilizará posteriormente en leaderboards.php.

#leaderboards.php (página en desarrollo)
Esta es sin duda la página que más quebraderos de cabeza me ha causado, no por el diseño de la página en sí, sino por el trabajo de recoleccion de datos que esta requería.
Cómo ya he explicado, estos datos son recogidos cada vez que se hace una búsqueda de un invocador, o cada vez que se acceden a las stats con un campeón.
La página aún esta en desarrollo y el diseño seguramente cambie por completo a un diseño más sencillo y ordenable (cómo el de index.php).
Esta página mostrará una tabla con todos los campeones registrados en la BDD y al lado de cada campeón saldrá el invocador que más puntos tenga con dicho campeón. Al hacer click en un campeón podremos ver una tabla con los primeros 100 invocadores que más puntos tengan con el campeón (independientemente de la region a la que pertenezcan).

#Tecnologias usadas:
<ul>
  <li><a href='http://getbootstrap.com/'>Bootstrap</a></li>
  <li><a href='https://jquery.com/'>JQuery</a></li>
  <li><a href='http://www.mysql.com/'>MySQL</a></li>
</ul>
  Others:<br>
<ul>
  <li><a href='https://github.com/kevinohashi/php-riot-api'>PHP-RIOT-API</a></li>
  <li><a href='https://datatables.net/'>DataTables</a></li>
</ul>
Hosting gratuito por: <a href='http://www.hostinger.es'>www.hostinger.es</a>
